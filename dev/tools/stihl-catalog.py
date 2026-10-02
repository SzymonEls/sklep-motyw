#!/usr/bin/env python3
"""Downloads the whole stihl.pl catalogue: machines, accessories, batteries,
spare parts, consumables and clothing.

The result is large, so it is written outside the repository (by default to
../stihl-katalog next to the theme folder):

    raw/<id>.json            stihl.pl API responses (cache, re-used on later runs)
    stihl-products.json      all products in the format of dev/demo/stihl-products.json,
                             plus "variants" for products with sizes or lengths
    mapping.json             stihl.pl category -> shop category

    python3 dev/tools/stihl-catalog.py fetch   download (resumable, ~1 request per second)
    python3 dev/tools/stihl-catalog.py build   build stihl-products.json from raw/
    python3 dev/tools/stihl-catalog.py demo    write the preview subset to dev/demo/stihl-products.json

Product URLs come from stihl.pl/sitemap.xml (/pl/p/ machines, /pl/ap/
accessories) and from the machine categories used by stihl-products.py.
"""

import importlib.util
import json
import os
import re
import sys
import urllib.parse
import urllib.request

HERE = os.path.dirname(os.path.abspath(__file__))
OUT = os.environ.get('STIHL_CATALOG_DIR') or os.path.normpath(os.path.join(HERE, '..', '..', '..', 'stihl-katalog'))
RAW = os.path.join(OUT, 'raw')

spec = importlib.util.spec_from_file_location('stihl_products', os.path.join(HERE, 'stihl-products.py'))
sp = importlib.util.module_from_spec(spec)
spec.loader.exec_module(sp)


def sitemap_ids():
	request = urllib.request.Request(sp.SITE + '/sitemap.xml', headers={'User-Agent': 'Mozilla/5.0 KlinikaTrawnika-katalog/1.0'})
	with urllib.request.urlopen(request, timeout=60) as response:
		xml = response.read().decode('utf-8')
	ids = []
	for url in re.findall(r'<loc>([^<]+/pl/a?p/[^<]+)</loc>', xml):
		found = re.search(r'-(\d+)/?$', urllib.parse.unquote(url))
		if found:
			ids.append(found.group(1))
	return list(dict.fromkeys(ids))


def raw_path(product_id):
	return os.path.join(RAW, '%s.json' % product_id)


def load_raw(product_id):
	path = raw_path(product_id)
	if os.path.exists(path):
		with open(path, encoding='utf-8') as handle:
			return json.load(handle)
	return None


def fetch():
	os.makedirs(RAW, exist_ok=True)
	queue = sitemap_ids()
	print('sitemap: %d' % len(queue), file=sys.stderr)
	# Machines as listed in the categories (each kit is a separate model).
	listed = {}
	for path, _ in sp.CATEGORIES:
		for item in sp.listing(path.rsplit('-', 1)[1]):
			listed[str(item['id'])] = item['url']
			queue.append(str(item['id']))
	with open(os.path.join(OUT, 'listed.json'), 'w', encoding='utf-8') as handle:
		json.dump(listed, handle, ensure_ascii=False)

	seen, errors = set(), []
	while queue:
		product_id = queue.pop(0)
		if product_id in seen:
			continue
		seen.add(product_id)
		detail = load_raw(product_id)
		if detail is None:
			try:
				detail = sp.request('%s/products/%s?lang=pl-PL' % (sp.API, product_id))
			except Exception as error:  # noqa: BLE001
				errors.append('%s: %s' % (product_id, error))
				continue
			with open(raw_path(product_id), 'w', encoding='utf-8') as handle:
				json.dump(detail, handle, ensure_ascii=False)
		for model in detail.get('models') or []:
			if model.get('id') and str(model['id']) not in seen:
				queue.append(str(model['id']))
		if len(seen) % 100 == 0:
			print('pobrane: %d, w kolejce: %d' % (len(seen), len(queue)), file=sys.stderr)
	print('Pobrane: %d, błędy: %d' % (len(seen), len(errors)))
	for error in errors:
		print('  ' + error)


# --------------------------------------------------------------------------
# Building the catalogue.
# --------------------------------------------------------------------------

# Machines: stihl.pl category id -> shop category (same rules as stihl-products.py).
MACHINES = {path.rsplit('-', 1)[1]: categorize for path, categorize in sp.CATEGORIES}
MACHINES.update({
	'98249': sp.fixed('Akcesoria > STIHL Connected'),
	'174393': sp.fixed('Akumulatory i ładowarki > Ładowarki'),
	'1022099': sp.fixed('Narzędzia ręczne > Narzędzia ogrodowe'),
})

# Accessory groups: stihl.pl category id -> "Akcesoria > …" sub-category.
ACCESSORY_GROUPS = {
	'99374': 'Akcesoria do kos', '99376': 'Akcesoria do kos', '99417': 'Akcesoria do nożyc',
	'98285': 'Akcesoria do pilarek', '99380': 'Akcesoria do dmuchaw i odkurzaczy',
	'99413': 'Akcesoria do odkurzaczy przemysłowych', '99429': 'Akcesoria do myjek',
	'99416': 'Akcesoria do opryskiwaczy', '100085': 'Akcesoria do robotów iMOW',
	'99377': 'Akcesoria do KombiSystemu', '98055': 'Akcesoria do KombiSystemu',
	'99393': 'Akcesoria do kosiarek', '99394': 'Akcesoria do traktorków',
	'99392': 'Akcesoria do przecinarek', '99382': 'Akcesoria do pilarek do betonu',
	'99414': 'Akcesoria do podkrzesywarek', '99407': 'Akcesoria do rozdrabniaczy',
	'99383': 'Akcesoria do świdrów', '99423': 'Akcesoria do wertykulatorów',
	'99389': 'Akcesoria do glebogryzarek', '98281': 'Pozostałe akcesoria',
}

RULES = [
	# (regex on "group | name", shop category); the first match wins.
	(r'^KIDS\b', 'Odzież i ochrona > Dla dzieci'),
	(r'^(STIHL COLLECTION|STIHL TIMBERSPORTS|MATERIAŁY REKLAMOWE)', 'Odzież i ochrona > Odzież robocza i gadżety'),
	(r'^(SYSTEM A[KSPR]|SYSTEM ALLPRO)\b.*\|\s*(akumulator|zestaw startowy)', 'Akumulatory i ładowarki > Akumulatory'),
	(r'^(SYSTEM A[KSPR]|SYSTEM ALLPRO)\b.*\|\s*(szybka )?ładowark', 'Akumulatory i ładowarki > Ładowarki'),
	(r'^(SYSTEM A[KSPR]|SYSTEM ALLPRO)\b', 'Akumulatory i ładowarki > Akcesoria do akumulatorów'),
	(r'^(Oleje)\b|\|\s*(olej|motomix|moto4plus|paliwo)', 'Części i eksploatacja > Oleje i paliwa'),
	(r'^(Środki czyszczące|Kanistry)', 'Części i eksploatacja > Środki czyszczące, smary i kanistry'),
	(r'^(ŁAŃCUCHY DO PILAREK|ZESTAWY CUT KIT|ZESTAWY HEXA|NARZĘDZIA DO ZESTAWU TNĄCEGO|PROWADNICE)\b', 'Części i eksploatacja > Łańcuchy i prowadnice'),
	(r'^(Carving E|Duromatic E|Light 0|Light GTA|Rollomatic)', 'Części i eksploatacja > Łańcuchy i prowadnice'),
	(r'^(ŻYŁKI TNĄCE|NARZĘDZIA TNĄCE|AutoCut|DuroCut|PolyCut|SuperCut|TrimCut|Nożyki z tworzywa)', 'Części i eksploatacja > Żyłki i głowice'),
	(r'^(BrushCut|GrassCut|WoodCut|ShredCut|RG /)', 'Części i eksploatacja > Noże i tarcze do kos'),
	(r'^(TARCZE DIAMENTOWE|ŚCIERNICE)', 'Części i eksploatacja > Tarcze do przecinarek'),
	(r'\|\s*(ostrza|nóż|noże|ack |adc |tarcza disc)', 'Części i eksploatacja > Noże do kosiarek'),
	(r'^(Zestawy serwisowe|ZESTAWY SERWISOWE)|\|\s*zestaw serwisowy', 'Części i eksploatacja > Zestawy serwisowe'),
	(r'^(FILTRY|WORKI FILTRACYJNE)\b|\|\s*(filtr|świec)', 'Części i eksploatacja > Filtry i świece'),
	(r'^MATERIAŁY EKSPLOATACYJNE', 'Części i eksploatacja > Pozostałe części'),
	(r'^(Rękawice)', 'Odzież i ochrona > Rękawice'),
	(r'^(Obuwie)', 'Odzież i ochrona > Obuwie'),
	(r'^(Ochrona słuchu|Okulary ochronne)', 'Odzież i ochrona > Kaski i ochronniki'),
	(r'^(Kurtki|Spodnie|Ochronniki / Pasy|ODZIEŻ OCHRONNA|System ADVANCE X-FLEX)', 'Odzież i ochrona > Odzież ochronna'),
]
RULES = [(re.compile(pattern, re.I), category) for pattern, category in RULES]

SIZE_TOKEN = re.compile(r'(?:^|[\s(])(XXS|XS/S|M/L|XL/XXL|XS|S|M|L|XL|XXL|XXXL|3XL|4XL)(?=$|[\s),])', re.I)
SIZE = re.compile(r'^(XXS|XS|S|M|L|XL|XXL|XXXL|3XL|4XL|\d{2}(/\d{2})?|\d{1,2}([,.]5)?|[A-Z]{1,3}/[A-Z]{1,3})$', re.I)


def category_of(detail):
	primary = detail.get('primaryCategory') or {}
	url = primary.get('url') or ''
	group_id = url.rsplit('-', 1)[-1] if url else str(detail.get('parentCategoryId', ''))
	group_name = primary.get('name') or ''
	name = detail.get('name') or ''
	if group_id in MACHINES and (not detail.get('isAccessory') or group_id in ('98055', '204427', '167250', '98249', '1022099')):
		if group_id == '98055' and detail.get('isAccessory'):
			return 'KombiSystem'
		return MACHINES[group_id](detail, name)
	text = '%s | %s' % (group_name, name)
	for pattern, category in RULES:
		if pattern.search(text):
			return category
	if group_id in ACCESSORY_GROUPS:
		return 'Akcesoria > ' + ACCESSORY_GROUPS[group_id]
	return 'Akcesoria > Pozostałe akcesoria'


def variant_axis(names):
	"""Returns the variant attribute name and the varying part of each variant name."""
	sizes = [SIZE_TOKEN.search(n) for n in names]
	if all(sizes) and len({m.group(1).upper() for m in sizes}) == len(names):
		return 'Rozmiar', [m.group(1).upper() for m in sizes]

	# Drop the words all names share at the start and at the end.
	words = [n.split() for n in names]
	start = 0
	while all(len(w) > start for w in words) and len({w[start] for w in words}) == 1:
		start += 1
	end = 0
	unit = re.compile(r'^(og\.?|ogniw|cm|mm|m|l|ml|szt\.?|kg|g)[,.;]?$', re.I)
	while all(len(w) > start + end for w in words) and len({w[-1 - end] for w in words}) == 1 and not unit.match(words[0][-1 - end]):
		end += 1
	options = [' '.join(w[start:len(w) - end]).strip(' ,;()') for w in words]
	if not all(options) or len(set(options)) != len(options):
		options = names
	options = [re.sub(r'^(rozmiar|rozm\.?)\s*', '', o, flags=re.I) for o in options]
	if all(re.search(r'\d+\s*og', o) for o in options):
		label = 'Liczba ogniw'
	elif all(SIZE.match(o) for o in options) or all(re.match(r'^\d{2,3}\s*[-–]\s*\d{2,3}$', o) for o in options):
		label = 'Rozmiar'
	elif all(re.search(r'\d\s*(cm|m|mm)\b', o) for o in options):
		label = 'Długość'
	elif all(re.search(r'\d\s*(l|ml)\b', o, re.I) for o in options):
		label = 'Pojemność'
	else:
		label = 'Wariant'
	return label, options


def build_one(detail, full=True):
	category = category_of(detail)
	product = sp.build(detail, detail, (detail.get('parentCategoryUrl') or ''), category, full=full)
	product['url'] = sp.SITE + (detail.get('url') or '')
	variants = [v for v in detail.get('variants') or [] if v.get('sku')]
	if len(variants) > 1:
		label, options = variant_axis([v.get('name') or v['sku'] for v in variants])
		rows = []
		for variant, option in zip(variants, options):
			prices = {p.get('type'): p.get('amount') for p in variant.get('prices') or [] if p.get('type')}
			amount = prices.get('RRP') or prices.get('BUY')
			if amount:
				rows.append({'sku': variant['sku'], 'option': option, 'price_regular': sp.price(amount), 'device_number': variant.get('manufacturerAID', '')})
		if len(rows) > 1:
			product['variants'] = {'attribute': label, 'items': rows}
			product['price_regular'] = min(rows, key=lambda r: float(r['price_regular']))['price_regular']
			product['sku'] = detail.get('masterVariantId') or ''
			if product['sku'] in {r['sku'] for r in rows}:
				product['sku'] = 'STIHL-%s' % detail['id']
		elif rows:
			product['sku'] = rows[0]['sku']
			product['price_regular'] = rows[0]['price_regular']
	return product


def checked_images(products):
	"""Drops promotion banners, remembering checked URLs in images-checked.json."""
	path = os.path.join(OUT, 'images-checked.json')
	cache = {}
	if os.path.exists(path):
		with open(path, encoding='utf-8') as handle:
			cache = json.load(handle)
	try:
		import PIL  # noqa: F401
	except ImportError:
		print('Brak Pillow: pomijam sprawdzanie zdjęć promocyjnych.', file=sys.stderr)
		return
	for number, product in enumerate(products):
		kept = []
		for url in product['images']:
			if len(kept) == 4:
				break
			if url not in cache:
				picture = sp.image(url)
				cache[url] = bool(picture is not None and sp.is_promotion(picture))
			if not cache[url]:
				kept.append(url)
		product['images'] = kept[:4]
		if number % 50 == 0:
			print('zdjęcia: %d/%d' % (number, len(products)), file=sys.stderr)
			with open(path, 'w', encoding='utf-8') as handle:
				json.dump(cache, handle)
	with open(path, 'w', encoding='utf-8') as handle:
		json.dump(cache, handle)


def all_raw():
	for name in sorted(os.listdir(RAW)):
		if name.endswith('.json'):
			with open(os.path.join(RAW, name), encoding='utf-8') as handle:
				yield json.load(handle)


def build():
	products, seen = [], set()
	for detail in all_raw():
		if not detail.get('id') or detail['id'] in seen or not (detail.get('prices') or detail.get('variants')):
			continue
		seen.add(detail['id'])
		detail.setdefault('assets', [])
		# Keep more photos than needed, so some remain after removing banners.
		product = build_one(detail)
		product['images'] = [sp.SITE + a['url'] for a in detail['assets'] if a.get('url', '').startswith('/content/dam/') and a.get('imageType') != 'ICONS'][:8]
		if product.get('price_regular'):
			products.append(product)

	skus = set()
	for product in products:
		if not product['sku'] or product['sku'] in skus:
			product['sku'] = 'STIHL-%s' % product['stihl_id']
		skus.add(product['sku'])

	checked_images(products)
	products.sort(key=lambda p: (p['category'], p['name']))
	with open(os.path.join(OUT, 'stihl-products.json'), 'w', encoding='utf-8') as handle:
		json.dump(products, handle, ensure_ascii=False, indent='\t')
	write_csv(products)

	counts = {}
	for product in products:
		counts[product['category']] = counts.get(product['category'], 0) + 1
	with open(os.path.join(OUT, 'mapping.json'), 'w', encoding='utf-8') as handle:
		json.dump({'categories': counts}, handle, ensure_ascii=False, indent='\t')
	print('Produkty: %d (z wariantami: %d)' % (len(products), sum(1 for p in products if p.get('variants'))))
	for category in sorted(counts):
		print('  %-60s %d' % (category, counts[category]))


def write_csv(products):
	"""Plan B: a file for the WooCommerce CSV importer (Produkty > Importuj)."""
	import csv
	columns = ['Typ', 'SKU', 'Nadrzędny', 'Nazwa', 'Opublikowany', 'Krótki opis', 'Opis', 'Cena regularna', 'Kategorie',
		'Obrazki', 'Marki', 'Na stanie?', 'Nazwa atrybutu 1', 'Wartości atrybutu 1', 'Atrybut 1 widoczny', 'Atrybut 1 globalny',
		'Meta: _klinika_stihl_url']
	with open(os.path.join(OUT, 'stihl-produkty-woocommerce.csv'), 'w', encoding='utf-8', newline='') as handle:
		writer = csv.writer(handle)
		writer.writerow(columns)
		for p in products:
			category = p['category'].replace(' > ', ' > ')
			images = ', '.join(p['images'][:3])
			description = p['description_html'] + '<p><a href="%s">Strona produktu na stihl.pl</a></p>' % p['url']
			if p.get('variants'):
				v = p['variants']
				writer.writerow(['variable', p['sku'], '', p['name'], 1, p['short_description'], description, '', category, images, 'STIHL', 1,
					v['attribute'], ', '.join(i['option'].replace(',', ' ') for i in v['items']), 1, 0, p['url']])
				for item in v['items']:
					writer.writerow(['variation', item['sku'], p['sku'], '', 1, '', '', item['price_regular'], '', '', '', 1,
						v['attribute'], item['option'].replace(',', ' '), '', 0, ''])
			else:
				first = next(iter(p['attributes'].items()), ('', ''))
				writer.writerow(['simple', p['sku'], '', p['name'], 1, p['short_description'], description, p['price_regular'], category, images, 'STIHL', 1,
					first[0], first[1], 1 if first[0] else '', 1 if first[0] else '', p['url']])


def demo():
	"""Preview subset for the repository: machines only, short descriptions."""
	with open(os.path.join(OUT, 'stihl-products.json'), encoding='utf-8') as handle:
		full = {p['stihl_id']: p for p in json.load(handle)}
	with open(os.path.join(OUT, 'listed.json'), encoding='utf-8') as handle:
		listed = json.load(handle)
	products = []
	for stihl_id in listed:
		detail = load_raw(stihl_id)
		if not detail or stihl_id not in full or full[stihl_id].get('variants'):
			continue
		product = build_one(detail, full=False)
		product['images'] = full[stihl_id]['images']
		product['sku'] = full[stihl_id]['sku']
		products.append(product)
	sp.OUT = os.path.join(HERE, '..', 'demo', 'stihl-products.json')
	sp.save(products)
	print('Demo: %d produktów' % len(products))


if __name__ == '__main__':
	command = sys.argv[1] if len(sys.argv) > 1 else 'fetch'
	{'fetch': fetch, 'build': build, 'demo': demo}[command]()
