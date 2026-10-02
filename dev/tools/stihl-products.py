#!/usr/bin/env python3
"""Downloads the STIHL products sold by Klinika Trawnika from stihl.pl.

The old store website links to these stihl.pl categories. The script reads
them through the same JSON API the stihl.pl pages use and writes
dev/demo/stihl-products.json, which dev/demo/setup.php imports into the demo
store (and which can be turned into a WooCommerce CSV for the live store).
No images are saved; the JSON only keeps their stihl.pl URLs.

    python3 dev/tools/stihl-products.py           download everything
    python3 dev/tools/stihl-products.py --images  only re-check the images

Some stihl.pl product photos are promotion banners with a price ("TERAZ
719,-"); they are left out, because the shop shows its own prices. Needs
Pillow (python-pillow) for that check.

About one request per second, as stihl.pl/robots.txt allows the pages.
"""

import datetime
import html
import json
import os
import re
import sys
import time
import urllib.request

API = 'https://252092-stihl-b2c.adobeioruntime.net/apis/pl-b2c'
SITE = 'https://www.stihl.pl'
OUT = os.path.join(os.path.dirname(__file__), '..', 'demo', 'stihl-products.json')
DELAY = 1.0

POWER = {'cordless': 'Akumulatorowe', 'gasoline': 'Spalinowe', 'electric': 'Elektryczne'}


def by_power(parent, names):
	"""Picks a child category by power source: names = (cordless, petrol, electric)."""
	def pick(item, name):
		index = {'cordless': 0, 'gasoline': 1, 'electric': 2}.get(item.get('productPower'), 1)
		return parent + ' > ' + names[index]
	return pick


def fixed(path):
	return lambda item, name: path


def blowers(item, name):
	if re.search(r'odkurzacz|^SH ', name, re.I):
		return 'Dmuchawy i odkurzacze > Odkurzacze ogrodowe'
	return 'Dmuchawy i odkurzacze > Dmuchawy'


# Specific categories come first: a product found in several categories keeps
# the first one (e.g. a tractor listed under "Kosiarki" stays a tractor).
CATEGORIES = [
	('/pl/c/roboty-koszace-98119', fixed('Roboty koszące > Roboty iMOW')),
	('/pl/c/kosiarki-mulczujace-98010', fixed('Kosiarki > Kosiarki specjalistyczne')),
	('/pl/c/traktory-ogrodowe-98215', fixed('Kosiarki > Traktorki ogrodowe')),
	('/pl/c/kosiarki-97983', by_power('Kosiarki', ('Kosiarki akumulatorowe', 'Kosiarki spalinowe', 'Kosiarki elektryczne'))),
	('/pl/c/podkrzesywarki-97998', fixed('Pilarki > Podkrzesywarki')),
	('/pl/c/pilarki-lancuchowe-98176', by_power('Pilarki', ('Pilarki akumulatorowe', 'Pilarki spalinowe', 'Pilarki elektryczne'))),
	('/pl/c/nozyce-do-zywoplotow-98171', by_power('Nożyce do żywopłotu', ('Akumulatorowe', 'Spalinowe', 'Elektryczne'))),
	('/pl/c/kombisystem-98055', fixed('KombiSystem')),
	('/pl/c/kosy-mechaniczne-98236', by_power('Kosy i podkaszarki', ('Kosy akumulatorowe', 'Kosy spalinowe', 'Podkaszarki elektryczne'))),
	('/pl/c/siekiery-mloty-narzedzia-lesne-98053', fixed('Narzędzia ręczne > Narzędzia leśne')),
	('/pl/c/narzedzia-i-akcesoria-do-prac-lesnych-i-ogrodowych-97968', fixed('Narzędzia ręczne > Narzędzia ogrodowe')),
	('/pl/c/przecinarki-98160', fixed('Przecinarki i pilarki do betonu')),
	('/pl/c/pilarka-do-betonu-98226', fixed('Przecinarki i pilarki do betonu')),
	('/pl/c/wertykulator-98241', fixed('Uprawa gleby > Wertykulatory i aeratory')),
	('/pl/c/glebogryzarki-98153', fixed('Uprawa gleby > Glebogryzarki')),
	('/pl/c/swider-glebowy-98075', fixed('Uprawa gleby > Świdry glebowe')),
	('/pl/c/opryskiwacze-98224', fixed('Opryskiwacze')),
	('/pl/c/myjki-cisnieniowe-98132', fixed('Myjki ciśnieniowe')),
	('/pl/c/odkurzacz-na-mokro-i-sucho-98199', fixed('Dmuchawy i odkurzacze > Odkurzacze przemysłowe')),
	('/pl/c/dmuchawy-odkurzacze-97976', blowers),
	('/pl/c/zamiatarki-98207', fixed('Zamiatarki')),
	('/pl/c/rozdrabniacz-ogrodowy-97981', fixed('Rozdrabniacze')),
	('/pl/c/kompresor-204427', fixed('Kompresory i pompy > Kompresory')),
	('/pl/c/pompy-wodne-167250', fixed('Kompresory i pompy > Pompy wodne')),
]

# Technical data copied to visible product attributes: attribute name -> feature names.
ATTRIBUTES = [
	('Szerokość koszenia', ('Szerokość koszenia', 'Szerokość cięcia')),
	('Długość prowadnicy', ('Długość prowadnicy',)),
	('Długość listwy tnącej', ('Długość listwy tnącej',)),
	('Moc', ('Moc',)),
	('Pojemność skokowa', ('Pojemność skokowa',)),
	('Waga', ('Ciężar', 'Ciężar urządzenia bez akumulatora', 'Waga')),
]

# Accessory sub-categories ("Akcesoria do…"), not "Narzędzia i akcesoria…".
ACCESSORY = re.compile(r'^\s*(akcesoria|materiały eksploatacyjne|środki ochrony)', re.I)
# Accessories listed directly in a device category.
ACCESSORY_NAME = re.compile(r'^\s*(kabura|pokrowiec|wysięgnik|etui|torba)\b', re.I)


def request(url, body=None):
	headers = {
		'User-Agent': 'Mozilla/5.0 (X11; Linux x86_64) KlinikaTrawnika-katalog/1.0',
		'Accept': 'application/json',
		'Accept-Language': 'pl-PL',
		'Referer': SITE + '/',
	}
	data = None
	if body is not None:
		data = json.dumps(body).encode()
		headers['Content-Type'] = 'application/json'
	for attempt in range(3):
		try:
			time.sleep(DELAY)
			with urllib.request.urlopen(urllib.request.Request(url, data, headers), timeout=40) as response:
				return json.loads(response.read().decode('utf-8'))
		except Exception as error:  # noqa: BLE001 - retried, then reported.
			last = error
			time.sleep(3 * (attempt + 1))
	raise last


def listing(category_id):
	results, offset = [], 0
	while True:
		page = request(API + '/products/search', {
			'sort': None, 'limit': 100, 'offset': offset, 'seoFilter': '',
			'searchQueryContext': 'MODELS', 'selectedFacets': 'allCategories:' + category_id,
			'isAlgoliaSearchEnabled': False, 'disjunctiveFacets': [], 'dealerBranchCode': '',
		})
		results += page.get('results', [])
		offset += 100
		if offset >= page.get('total', page.get('count', 0)) or not page.get('results'):
			return results


def tidy(value):
	value = re.sub(r'\s+', ' ', value).strip()
	value = re.sub(r'\s+([.,;:!?®²³)])', r'\1', value)
	return re.sub(r'\(\s+', '(', value)


def text(value):
	value = re.sub(r'</?(strong|b|em|i|sup|sub|span|a)\b[^>]*>', '', value or '', flags=re.I)
	value = re.sub(r'<[^>]+>', ' ', value)
	return tidy(html.unescape(value))


def shorten(value, limit=300):
	if len(value) <= limit:
		return value
	cut = value[:limit].rsplit(' ', 1)[0].rstrip(',;:–- ')
	return cut + '…'


def clean_summary(value):
	"""Turns a stihl.pl teaser like "Pilarka: lekka ✓ cicha ✓ ➤ Dowiedz się więcej!" into a sentence."""
	value = re.split(r'\s*➤', value)[0]
	parts = [part.strip(' ,;') for part in re.split(r'\s*✓\s*', value) if part.strip(' ,;')]
	if len(parts) > 1:
		value = ', '.join(parts)
	else:
		value = parts[0] if parts else ''
	value = value.strip()
	return value + '.' if value and value[-1] not in '.!?…' else value


def number(value):
	return str(value).replace('.', ',')


def price(amount):
	return '%.2f' % (amount / 100) if amount else None


def build(item, detail, source, category):
	name = detail.get('name') or item['name']
	prices = {p['type']: p['amount'] for p in detail.get('prices') or item.get('prices') or []}
	regular = prices.get('RRP') or prices.get('BUY')
	buy = prices.get('BUY')
	features = detail.get('features') or []
	feature = {f['name']: f for f in features}
	power = detail.get('productPower') or item.get('productPower')

	attributes = {}
	if power in POWER:
		attributes['Zasilanie'] = POWER[power]
	if power == 'cordless':
		system = feature.get('System akumulatorowy', {}).get('value')
		if not system:
			for icon in detail.get('icons') or []:
				found = re.match(r'(AS|AK|AP|AR|AI)\b', icon.get('name', ''))
				if found:
					system = found.group(1)
		if system:
			attributes['System akumulatorowy'] = system
		attributes['Akumulator w zestawie'] = 'Nie' if re.search(r'bez akumulatora', name, re.I) else 'Tak'
	for label, names in ATTRIBUTES:
		for feature_name in names:
			if feature_name in feature and feature[feature_name].get('value'):
				f = feature[feature_name]
				attributes[label] = (number(f['value']) + ' ' + (f.get('unit') or '')).strip()
				break

	highlights = [text(h) for h in detail.get('highlights') or item.get('highlights') or [] if text(h)]
	parts = []
	if detail.get('description'):
		parts.append('<p>' + html.escape(shorten(text(detail['description']), 900)) + '</p>')
	if highlights:
		parts.append('<h3>Najważniejsze cechy</h3><ul>' + ''.join('<li>' + html.escape(h) + '</li>' for h in highlights) + '</ul>')
	if features:
		rows = ''.join(
			'<tr><th>%s</th><td>%s</td></tr>' % (html.escape(f['name']), html.escape((number(f['value']) + ' ' + (f.get('unit') or '')).replace(' pcs', ' szt.').strip()))
			for f in features if f.get('value')
		)
		parts.append('<h3>Dane techniczne</h3><table>' + rows + '</table>')

	summary = next((a['value'] for a in detail.get('attributes') or [] if a.get('id') == 'summary'), '')
	short = clean_summary(text(summary)) or text(detail.get('headline')) or (highlights[0] if highlights else '')

	variants = detail.get('variants') or []
	sku = variants[0].get('manufacturerAID', '') if len(variants) == 1 else detail.get('masterVariantId', '')

	images = []
	for asset in detail.get('assets') or item.get('assets') or []:
		if asset.get('url', '').startswith('/content/dam/') and asset.get('imageType') != 'ICONS':
			images.append(SITE + asset['url'])
	badges = []
	for flag in detail.get('flags') or item.get('flags') or []:
		badge = {'NEW': 'NOWOŚĆ', 'OFFER': 'PROMOCJA'}.get(flag.get('code'))
		if badge and badge not in badges:
			badges.append(badge)

	return {
		'name': name,
		'url': SITE + item['url'],
		'source_category': SITE + source,
		'category': category,
		'price_regular': price(regular),
		'price_promo': price(buy) if buy and regular and buy < regular else None,
		'sku': sku or '',
		'stihl_id': str(item['id']),
		'short_description': shorten(short),
		'description_html': ''.join(parts),
		'attributes': attributes,
		'images': list(dict.fromkeys(images))[:4],
		'badges': badges,
		'scraped_at': datetime.datetime.now(datetime.timezone.utc).strftime('%Y-%m-%dT%H:%M:%SZ'),
	}


def image(url):
	"""Downloads a small rendition of a stihl.pl image (or the image itself)."""
	import io
	from PIL import Image
	for candidate in (url + '/_jcr_content/renditions/cq5dam.thumbnail.319.319.png', url):
		try:
			time.sleep(DELAY / 2)
			request_ = urllib.request.Request(candidate, headers={'User-Agent': 'Mozilla/5.0 (X11; Linux x86_64) KlinikaTrawnika-katalog/1.0'})
			with urllib.request.urlopen(request_, timeout=40) as response:
				picture = Image.open(io.BytesIO(response.read())).convert('RGB')
			picture.thumbnail((320, 320))
			return picture
		except Exception:  # noqa: BLE001 - try the next candidate.
			continue
	return None


def is_promotion(picture):
	"""Promotion banners have orange lettering ("PROMOCJA") near the top.

	Letters make many short orange runs in one pixel row; an orange part of a
	device (a handle, a motor cover) makes only one or two.
	"""
	width, height = picture.size
	pixels = picture.load()
	most = 0
	for y in range(int(height * 0.2)):
		runs, previous = 0, False
		for x in range(width):
			red, green, blue = pixels[x, y]
			orange = red > 200 and 70 < green < 180 and blue < 90
			if orange and not previous:
				runs += 1
			previous = orange
		most = max(most, runs)
	return most >= 10


def drop_promotion_images(products):
	try:
		import PIL  # noqa: F401
	except ImportError:
		print('Brak Pillow: pomijam sprawdzanie zdjęć promocyjnych.', file=sys.stderr)
		return 0
	dropped = 0
	for number_, product in enumerate(products):
		kept = []
		for url in product['images']:
			picture = image(url)
			if picture is not None and is_promotion(picture):
				dropped += 1
				continue
			kept.append(url)
		product['images'] = kept
		if number_ % 50 == 0:
			print('zdjęcia: %d/%d' % (number_, len(products)), file=sys.stderr)
	return dropped


def save(products):
	with open(OUT, 'w', encoding='utf-8') as handle:
		json.dump(products, handle, ensure_ascii=False, indent='\t')
		handle.write('\n')


def main():
	if '--images' in sys.argv:
		with open(OUT, encoding='utf-8') as handle:
			products = json.load(handle)
		print('Usunięte zdjęcia promocyjne: %d' % drop_promotion_images(products))
		save(products)
		return

	products, seen, errors = [], set(), []
	for path, categorize in CATEGORIES:
		category_id = path.rsplit('-', 1)[1]
		try:
			items = listing(category_id)
		except Exception as error:  # noqa: BLE001
			errors.append('%s: listing: %s' % (path, error))
			continue
		print('%s: %d' % (path, len(items)), file=sys.stderr)
		for item in items:
			url = item.get('url', '')
			groups = (item.get('groupName', ''), item.get('primaryCategory', {}).get('name', ''))
			if not url or url in seen or any(ACCESSORY.search(group) for group in groups):
				continue
			seen.add(url)
			try:
				detail = request('%s/products/%s?lang=pl-PL' % (API, item['id']))
			except Exception as error:  # noqa: BLE001
				errors.append('%s: %s' % (url, error))
				detail = {}
			if detail.get('isAccessory') or ACCESSORY_NAME.search(detail.get('name') or item['name']):
				continue
			name = detail.get('name') or item['name']
			products.append(build(item, detail, path, categorize(item, name)))

	# Sets ("z akumulatorem…") share the device's STIHL number. WooCommerce
	# needs unique SKUs, so only the first product keeps it.
	skus = set()
	for product in products:
		if product['sku'] in skus:
			product['sku'] = ''
		skus.add(product['sku'])

	print('Usunięte zdjęcia promocyjne: %d' % drop_promotion_images(products))
	save(products)

	counts = {}
	for product in products:
		counts[product['category']] = counts.get(product['category'], 0) + 1
	print('\nProdukty: %d' % len(products))
	for category in sorted(counts):
		print('  %-55s %d' % (category, counts[category]))
	print('\nBłędy: %d' % len(errors))
	for error in errors:
		print('  ' + error)


if __name__ == '__main__':
	main()
