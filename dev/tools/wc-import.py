#!/usr/bin/env python3
"""Imports STIHL products (stihl-products.json format) into a WooCommerce shop
through the REST API.

    python3 dev/tools/wc-import.py --site https://sklep.sze.one \\
        --keys ../wc-api.txt --products ../stihl-katalog/stihl-products.json [--limit 10] [--skus A,B]

The keys file holds the consumer key and secret (ck_…, cs_…), one per line.
They are never printed or logged; keep the file outside the repository.

The import is idempotent: a product whose SKU already exists is updated, not
duplicated (images are only sent for new products, unless --images is set).
Products are sent one by one, because WooCommerce downloads the images on the
server and shared hosting has short PHP time limits. A log of every product is
appended to <products dir>/import-log.jsonl and the progress is kept in
<products dir>/import-state.json, so an interrupted import can simply be
started again: SKUs already imported are skipped (unless --again).

Prices: the STIHL list price only (regular price), never a promotional price,
because a sale price needs the lowest price of the last 30 days (Omnibus).
"""

import argparse
import base64
import datetime
import json
import os
import re
import sys
import time
import urllib.error
import urllib.parse
import urllib.request

GLOBAL_ATTRIBUTES = (
	'Zasilanie', 'System akumulatorowy', 'Akumulator w zestawie', 'Szerokość koszenia',
	'Długość prowadnicy', 'Długość listwy tnącej', 'Moc', 'Pojemność skokowa', 'Waga', 'Rozmiar', 'Długość',
)
MAX_IMAGES = 3


class Shop:
	def __init__(self, site, keys):
		with open(keys, encoding='utf-8') as handle:
			lines = [line.strip() for line in handle if line.strip()]
		consumer_key = next(line for line in lines if line.startswith('ck_'))
		consumer_secret = next(line for line in lines if line.startswith('cs_'))
		self.auth = 'Basic ' + base64.b64encode(('%s:%s' % (consumer_key, consumer_secret)).encode()).decode()
		self.base = site.rstrip('/') + '/wp-json/wc/v3/'

	def call(self, method, path, body=None, timeout=180):
		data = json.dumps(body).encode() if body is not None else None
		request = urllib.request.Request(self.base + path, data, method=method, headers={
			'Authorization': self.auth,
			'Content-Type': 'application/json',
			'Accept': 'application/json',
			'User-Agent': 'KlinikaTrawnika-import/1.0',
		})
		for attempt in range(4):
			try:
				with urllib.request.urlopen(request, timeout=timeout) as response:
					return json.loads(response.read().decode('utf-8') or 'null')
			except urllib.error.HTTPError as error:
				payload = error.read().decode('utf-8', 'ignore')
				if error.code in (429, 500, 502, 503, 504) and attempt < 3:
					time.sleep(10 * (attempt + 1))
					continue
				try:
					detail = json.loads(payload)
				except ValueError:
					detail = {'message': payload[:300]}
				raise ShopError(error.code, detail) from None
			except (urllib.error.URLError, TimeoutError) as error:
				if attempt < 3:
					time.sleep(10 * (attempt + 1))
					continue
				raise ShopError(0, {'message': str(error)}) from None

	def all(self, path):
		items, page = [], 1
		while True:
			separator = '&' if '?' in path else '?'
			batch = self.call('GET', '%s%sper_page=100&page=%d' % (path, separator, page))
			items += batch
			if len(batch) < 100:
				return items
			page += 1


class ShopError(Exception):
	def __init__(self, status, detail):
		super().__init__('%s %s' % (status, detail.get('code', '')))
		self.status = status
		self.detail = detail


def slugify(value):
	table = str.maketrans('ąćęłńóśźżĄĆĘŁŃÓŚŹŻ', 'acelnoszzACELNOSZZ')
	return re.sub(r'[^a-z0-9]+', '-', value.translate(table).lower()).strip('-')


class Catalog:
	"""Categories, attributes and the brand, created on first use."""

	def __init__(self, shop):
		self.shop = shop
		self.categories = {(c['parent'], c['name']): c for c in shop.all('products/categories')}
		self.slugs = {c['slug'] for c in self.categories.values()}
		self.attributes = {a['name']: a['id'] for a in shop.call('GET', 'products/attributes')}
		self.brand = None

	def category_ids(self, path):
		ids, parent = [], 0
		for name in [part.strip() for part in path.split('>')]:
			key = (parent, name)
			if key not in self.categories:
				slug = slugify(name)
				if slug in self.slugs:
					parent_slug = next(c['slug'] for c in self.categories.values() if c['id'] == parent) if parent else ''
					slug = slugify(parent_slug + '-' + name)
				self.categories[key] = self.shop.call('POST', 'products/categories', {'name': name, 'parent': parent, 'slug': slug})
				self.slugs.add(self.categories[key]['slug'])
			parent = self.categories[key]['id']
			ids.append(parent)
		return ids

	def attribute_id(self, name):
		if name not in GLOBAL_ATTRIBUTES:
			return 0
		if name not in self.attributes:
			created = self.shop.call('POST', 'products/attributes', {'name': name, 'slug': slugify(name)[:27], 'type': 'select', 'has_archives': False})
			self.attributes[name] = created['id']
		return self.attributes[name]

	def brand_id(self):
		if self.brand is None:
			try:
				brands = self.shop.call('GET', 'products/brands?per_page=100')
				found = next((b for b in brands if b['name'].upper() == 'STIHL'), None)
				self.brand = found['id'] if found else self.shop.call('POST', 'products/brands', {'name': 'STIHL', 'slug': 'stihl'})['id']
			except ShopError:
				self.brand = 0
		return self.brand


def sku_of(product):
	return product['sku'] or 'STIHL-%s' % product['stihl_id']


def payload(product, catalog, with_images=True):
	attributes = []
	for position, (name, value) in enumerate(product['attributes'].items()):
		attribute = {'name': name, 'options': [value], 'visible': True, 'variation': False, 'position': position}
		attribute_id = catalog.attribute_id(name)
		if attribute_id:
			attribute = {'id': attribute_id, 'options': [value], 'visible': True, 'variation': False, 'position': position}
		attributes.append(attribute)
	data = {
		'name': product['name'],
		'type': 'simple',
		'status': 'publish',
		'sku': sku_of(product),
		'regular_price': product['price_regular'],
		'sale_price': '',
		'description': product['description_html'] + '<p><a href="%s" target="_blank" rel="noopener">Strona produktu na stihl.pl</a></p>' % product['url'],
		'short_description': product['short_description'],
		'categories': [{'id': i} for i in catalog.category_ids(product['category'])],
		'attributes': attributes,
		'manage_stock': False,
		'stock_status': 'instock',
		'meta_data': [{'key': '_klinika_stihl_url', 'value': product['url']}, {'key': '_klinika_stihl_id', 'value': product['stihl_id']}] + ([{'key': '_klinika_stihl_device_number', 'value': product['device_number']}] if product.get('device_number') else []),
	}
	brand = catalog.brand_id()
	if brand:
		data['brands'] = [{'id': brand}]
	if with_images:
		data['images'] = [{'src': src, 'name': product['name'], 'alt': product['name']} for src in product['images'][:MAX_IMAGES]]
	return data


def import_product(shop, catalog, product, force_images=False):
	sku = sku_of(product)
	existing = shop.call('GET', 'products?sku=%s&status=any' % urllib.parse.quote(sku))
	existing = [p for p in existing if p.get('sku') == sku]
	if existing:
		target = existing[0]
		data = payload(product, catalog, with_images=force_images or not target.get('images'))
		return 'updated', shop.call('PUT', 'products/%d' % target['id'], data)
	data = payload(product, catalog)
	action = 'created'
	for _ in range(3):
		try:
			return action, shop.call('POST', 'products', data)
		except ShopError as error:
			detail = json.dumps(error.detail).lower()
			if 'brands' in detail and 'brands' in data:
				# The brand must never block the product: create it without one.
				data.pop('brands')
				action += '-without-brand'
			elif 'image' in detail and data.get('images'):
				# An image could not be downloaded: create the product without images.
				data.pop('images')
				action += '-without-images'
			else:
				raise
	return action, shop.call('POST', 'products', data)


def check(schema, value, path='product'):
	"""Returns the problems of a payload against the REST schema (types only)."""
	problems = []
	types = schema.get('type')
	types = types if isinstance(types, list) else [types] if types else []
	python = {'string': str, 'integer': int, 'number': (int, float), 'boolean': bool, 'array': list, 'object': dict, 'null': type(None)}
	if types and not any(isinstance(value, python[t]) for t in types if t in python):
		return ['%s: expected %s, got %s' % (path, '/'.join(types), type(value).__name__)]
	if isinstance(value, list) and 'items' in schema:
		for index, item in enumerate(value):
			problems += check(schema['items'], item, '%s[%d]' % (path, index))
	if isinstance(value, dict) and 'properties' in schema:
		for key, item in value.items():
			if key not in schema['properties']:
				problems.append('%s.%s: unknown field' % (path, key))
			elif schema['properties'][key].get('readonly'):
				problems.append('%s.%s: read-only field' % (path, key))
			else:
				problems += check(schema['properties'][key], item, '%s.%s' % (path, key))
	if 'enum' in schema and value not in schema['enum']:
		problems.append('%s: %r not in %s' % (path, value, schema['enum']))
	return problems


def dry_run(shop, products):
	"""Validates the payloads against OPTIONS /products without writing anything."""
	options = shop.call('OPTIONS', 'products')
	args = next(e['args'] for e in options['endpoints'] if 'POST' in e['methods'])

	class ReadOnlyCatalog:
		def category_ids(self, path):
			return [1] * len(path.split('>'))

		def attribute_id(self, name):
			return 1 if name in GLOBAL_ATTRIBUTES else 0

		def brand_id(self):
			return 1

	problems = 0
	for product in products:
		data = payload(product, ReadOnlyCatalog())
		found = []
		for key, value in data.items():
			if key not in args:
				found.append('%s: unknown field' % key)
			else:
				found += check(args[key], value, key)
		problems += len(found)
		print('%s %s %s' % ('OK ' if not found else 'ERR', sku_of(product), '; '.join(found)))
	print('Sprawdzone: %d, problemy: %d' % (len(products), problems))


def main():
	parser = argparse.ArgumentParser()
	parser.add_argument('--site', required=True)
	parser.add_argument('--keys', required=True)
	parser.add_argument('--products', required=True)
	parser.add_argument('--limit', type=int, default=0)
	parser.add_argument('--skus', default='', help='comma-separated SKUs or stihl_ids to import')
	parser.add_argument('--images', action='store_true', help='re-send images for existing products')
	parser.add_argument('--again', action='store_true', help='also update products already in import-state.json')
	parser.add_argument('--dry-run', action='store_true', help='only validate the payloads against the REST schema (read-only)')
	parser.add_argument('--background', action='store_true', help='detach and write the output to import.out next to the products file')
	args = parser.parse_args()

	if args.background:
		out = os.path.join(os.path.dirname(os.path.abspath(args.products)), 'import.out')
		if os.fork():
			print('Import działa w tle, log: %s' % out)
			return
		os.setsid()
		if os.fork():
			os._exit(0)
		with open(out, 'a', encoding='utf-8') as handle:
			os.dup2(handle.fileno(), sys.stdout.fileno())
			os.dup2(handle.fileno(), sys.stderr.fileno())
		sys.stdin.close()

	with open(args.products, encoding='utf-8') as handle:
		products = json.load(handle)
	if args.skus:
		wanted = set(args.skus.split(','))
		products = [p for p in products if sku_of(p) in wanted or p['stihl_id'] in wanted]
	products = [p for p in products if p.get('price_regular')]
	if args.limit:
		products = products[:args.limit]

	shop = Shop(args.site, args.keys)
	if args.dry_run:
		dry_run(shop, products)
		return
	catalog = Catalog(shop)
	folder = os.path.dirname(os.path.abspath(args.products))
	log_path = os.path.join(folder, 'import-log.jsonl')
	state_path = os.path.join(folder, 'import-state.json')
	state = {'done': {}, 'errors': {}, 'last': None}
	if os.path.exists(state_path):
		with open(state_path, encoding='utf-8') as handle:
			state = json.load(handle)
	if not args.again:
		products = [p for p in products if sku_of(p) not in state['done']]

	def save_state():
		with open(state_path + '.tmp', 'w', encoding='utf-8') as handle:
			json.dump(state, handle, ensure_ascii=False, indent='\t')
		os.replace(state_path + '.tmp', state_path)

	done = errors = 0
	with open(log_path, 'a', encoding='utf-8') as log:
		for number, product in enumerate(products, 1):
			entry = {'time': datetime.datetime.now().isoformat(timespec='seconds'), 'sku': sku_of(product), 'name': product['name']}
			try:
				action, result = import_product(shop, catalog, product, args.images)
				entry.update(action=action, id=result['id'], link=result.get('permalink'), images=len(result.get('images') or []))
				state['done'][entry['sku']] = result['id']
				state['errors'].pop(entry['sku'], None)
				done += 1
			except ShopError as error:
				entry.update(action='error', status=error.status, error=error.detail.get('message', '')[:300])
				state['errors'][entry['sku']] = entry['error']
				errors += 1
			state['last'] = entry
			save_state()
			log.write(json.dumps(entry, ensure_ascii=False) + '\n')
			log.flush()
			print('%d/%d %s %s %s' % (number, len(products), entry['action'], entry['sku'], entry.get('link') or entry.get('error', '')), flush=True)
	print('Gotowe: %d, błędy: %d (log: %s)' % (done, errors, log_path))


if __name__ == '__main__':
	main()
