"""Polish translations of the Witryna theme.

Keys are msgid or (context, msgid). Run `python3 dev/tools/pl_PL.py` to
(re)write languages/pl_PL.po; `npm run i18n` compiles it afterwards.
"""
import os
import sys

sys.path.insert(0, os.path.dirname(__file__))
import i18n  # noqa: E402

T = {
    # Theme header.
    ('Theme Name of the theme', 'Witryna'): 'Witryna',
    ('Description of the theme', 'Witryna is a modern block theme designed for WooCommerce stores. It ships with a sticky header, a custom mobile menu, product filters, a refined single product layout, cart and checkout templates, five style variations (light, dark, elegant, organic and high-contrast) and dozens of ready-made patterns for home pages, promotions and content. Fonts are bundled locally, so no data is sent to third-party font services.'):
        'Witryna to nowoczesny motyw blokowy dla sklepów WooCommerce. Zawiera przyklejony nagłówek, własne menu mobilne, filtry produktów, dopracowany układ karty produktu, szablony koszyka i kasy, pięć wariantów stylu (jasny, ciemny, elegancki, naturalny i kontrastowy) oraz dziesiątki gotowych wzorców stron głównych, promocji i treści. Fonty są dołączone lokalnie, więc żadne dane nie trafiają do zewnętrznych usług z fontami.',

    # theme.json presets.
    ('Font size name', 'Extra small'): 'Bardzo mały',
    ('Font size name', 'Small'): 'Mały',
    ('Font size name', 'Medium'): 'Średni',
    ('Font size name', 'Large'): 'Duży',
    ('Font size name', 'Extra large'): 'Bardzo duży',
    ('Font size name', '2X large'): '2X duży',
    ('Font size name', '3X large'): '3X duży',
    ('Font size name', 'Display'): 'Tytułowy',
    ('Font family name', 'Inter'): 'Inter',
    ('Font family name', 'Bricolage Grotesque'): 'Bricolage Grotesque',
    ('Font family name', 'Fraunces'): 'Fraunces',
    ('Font family name', 'Instrument Serif'): 'Instrument Serif',
    ('Font family name', 'System Sans-serif'): 'Systemowy bezszeryfowy',
    ('Color name', 'Base'): 'Tło',
    ('Color name', 'Surface'): 'Powierzchnia',
    ('Color name', 'Line'): 'Linia',
    ('Color name', 'Contrast'): 'Kontrast',
    ('Color name', 'Muted'): 'Wyciszony',
    ('Color name', 'Accent'): 'Akcent',
    ('Color name', 'Accent soft'): 'Jasny akcent',
    ('Color name', 'Highlight'): 'Wyróżnienie',
    ('Gradient name', 'Shade from bottom'): 'Cień od dołu',
    ('Gradient name', 'Surface to base'): 'Powierzchnia do tła',
    ('Gradient name', 'Accent glow'): 'Poświata akcentu',
    ('Space size name', 'Tiny'): 'Minimalny',
    ('Space size name', '2X-Small'): '2X mały',
    ('Space size name', 'X-Small'): 'Bardzo mały',
    ('Space size name', 'Small'): 'Mały',
    ('Space size name', 'Medium'): 'Średni',
    ('Space size name', 'Large'): 'Duży',
    ('Space size name', 'X-Large'): 'Bardzo duży',
    ('Space size name', '2X-Large'): '2X duży',
    ('Aspect ratio name', 'Portrait - 4:5'): 'Pionowy – 4:5',
    ('Aspect ratio name', 'Landscape - 5:4'): 'Poziomy – 5:4',
    ('Shadow name', 'Subtle'): 'Delikatny',
    ('Shadow name', 'Soft'): 'Miękki',
    ('Shadow name', 'Elevated'): 'Uniesiony',
    ('Border radius size name', 'Small'): 'Mały',
    ('Border radius size name', 'Medium'): 'Średni',
    ('Border radius size name', 'Large'): 'Duży',
    ('Border radius size name', 'Extra large'): 'Bardzo duży',
    ('Border radius size name', 'Full'): 'Pełny',
    ('Custom template name', 'Page without title'): 'Strona bez tytułu',
    ('Custom template name', 'Landing page (no header & footer)'): 'Strona docelowa (bez nagłówka i stopki)',
    ('Custom template name', 'Wide page'): 'Szeroka strona',
    ('Template part name', 'Header'): 'Nagłówek',
    ('Template part name', 'Footer'): 'Stopka',
    ('Template part name', 'Checkout header'): 'Nagłówek kasy',
    ('Template part name', 'Mobile menu'): 'Menu mobilne',
    ('Style variation name', 'Atelier'): 'Atelier',
    ('Style variation name', 'Contrast'): 'Kontrast',
    ('Style variation name', 'Forest'): 'Las',
    ('Style variation name', 'Night'): 'Noc',
    ('Style variation name', 'Accent section'): 'Sekcja akcentowa',
    ('Style variation name', 'Dark section'): 'Sekcja ciemna',
    ('Style variation name', 'Soft accent section'): 'Sekcja z jasnym akcentem',
    ('Style variation name', 'Surface section'): 'Sekcja na tle powierzchni',

    # Block styles, icons, pattern categories.
    ('block style', 'Eyebrow'): 'Nadtytuł',
    ('block style', 'Checklist'): 'Lista z ptaszkami',
    ('block style', 'No bullets'): 'Bez punktorów',
    ('block style', 'Card'): 'Karta',
    ('block style', 'Arrow link'): 'Link ze strzałką',
    ('block style', 'Zoom on hover'): 'Powiększenie po najechaniu',
    ('block style', 'Pills'): 'Etykiety',
    ('block style', 'Underline on hover'): 'Podkreślenie po najechaniu',
    'Witryna': 'Witryna',
    'Store icons bundled with the Witryna theme.': 'Ikony sklepowe dołączone do motywu Witryna.',
    ('icon label', 'Delivery truck'): 'Samochód dostawczy',
    ('icon label', 'Returns'): 'Zwroty',
    ('icon label', 'Padlock'): 'Kłódka',
    ('icon label', 'Chat'): 'Czat',
    ('icon label', 'Gift'): 'Prezent',
    ('icon label', 'Leaf'): 'Liść',
    ('icon label', 'Package'): 'Paczka',
    ('icon label', 'Sparkle'): 'Iskierki',
    ('icon label', 'Heart'): 'Serce',
    ('icon label', 'Phone'): 'Telefon',
    'Shop sections': 'Sekcje sklepu',
    'Product grids, categories and store benefits.': 'Siatki produktów, kategorie i zalety sklepu.',
    'Full pages': 'Całe strony',
    'Complete page layouts built from Witryna patterns.': 'Gotowe układy stron zbudowane z wzorców Witryny.',
    'Copyright notice': 'Informacja o prawach autorskich',
    '© %1$s %2$s. All rights reserved.': '© %1$s %2$s. Wszelkie prawa zastrzeżone.',
    '−%d%%': '−%d%%',
    'Sold out': 'Wyprzedane',
    'New': 'Nowość',

    # Brand story.
    ('Pattern title', 'Brand story with numbers'): 'Historia marki z liczbami',
    ('Pattern description', 'Image next to the brand story and three key numbers.'): 'Zdjęcie obok historii marki i trzech kluczowych liczb.',
    'orders shipped': 'wysłanych zamówień',
    'average rating': 'średnia ocena',
    'dispatch time': 'czas wysyłki',
    'Ceramic pieces drying in the studio': 'Ceramika schnąca w pracowni',
    'Our story': 'Nasza historia',
    'Designed with care, made to last': 'Zaprojektowane z troską, zrobione na lata',
    'We started with a single kiln and a simple idea: everyday objects should be beautiful, honest and durable. Today we work with a dozen small studios, but every piece is still checked by hand before it reaches you.':
        'Zaczynaliśmy od jednego pieca i prostej idei: przedmioty codziennego użytku powinny być piękne, uczciwe i trwałe. Dziś współpracujemy z kilkunastoma małymi pracowniami, ale każdy przedmiot wciąż sprawdzamy ręcznie, zanim do Ciebie trafi.',
    'Read more about us': 'Poznaj nas bliżej',

    # Checkout header.
    ('Pattern title', 'Checkout header'): 'Nagłówek kasy',
    ('Pattern description', 'Distraction-free header for the checkout with a link back to the cart.'): 'Nagłówek kasy bez rozpraszaczy, z linkiem powrotnym do koszyka.',
    'Secure checkout': 'Bezpieczne zakupy',

    # FAQ.
    ('Pattern title', 'Frequently asked questions'): 'Najczęściej zadawane pytania',
    ('Pattern description', 'Introduction with a contact button next to an accordion with common store questions.'): 'Wstęp z przyciskiem kontaktu obok akordeonu z typowymi pytaniami o sklep.',
    'How long does delivery take?': 'Jak długo trwa dostawa?',
    'Orders placed on business days before 2 pm are shipped the same day. Courier and parcel locker deliveries usually arrive within 1–2 business days.':
        'Zamówienia złożone w dni robocze do 14:00 wysyłamy tego samego dnia. Przesyłki kurierskie i do paczkomatów docierają zwykle w ciągu 1–2 dni roboczych.',
    'How can I return a product?': 'Jak mogę zwrócić produkt?',
    'You have 30 days to return any product without giving a reason. Log in to your account, choose the order and follow the return steps. We refund the payment within 5 business days.':
        'Masz 30 dni na zwrot dowolnego produktu bez podawania przyczyny. Zaloguj się na swoje konto, wybierz zamówienie i postępuj zgodnie z instrukcją zwrotu. Pieniądze oddajemy w ciągu 5 dni roboczych.',
    'Which payment methods do you accept?': 'Jakie metody płatności akceptujecie?',
    'You can pay by card, fast bank transfer, mobile wallet or bank transfer. All payments are processed by certified payment operators.':
        'Możesz zapłacić kartą, szybkim przelewem, portfelem mobilnym lub przelewem tradycyjnym. Wszystkie płatności obsługują certyfikowani operatorzy.',
    'Can I change or cancel my order?': 'Czy mogę zmienić lub anulować zamówienie?',
    'Yes, as long as the order has not been shipped. Write to us as soon as possible and include your order number.':
        'Tak, dopóki zamówienie nie zostało wysłane. Napisz do nas jak najszybciej i podaj numer zamówienia.',
    'Do you offer gift wrapping?': 'Czy pakujecie na prezent?',
    'Every order is packed in recyclable paper. You can add a handwritten card for free by leaving a note at checkout.':
        'Każde zamówienie pakujemy w papier nadający się do recyklingu. Odręczny bilecik dodamy bezpłatnie – wystarczy zostawić notatkę przy zamówieniu.',
    'Help centre': 'Centrum pomocy',
    'Questions? We have answers': 'Masz pytania? Mamy odpowiedzi',
    'Could not find what you were looking for? Our team is happy to help with orders, products and returns.':
        'Nie ma tu odpowiedzi na Twoje pytanie? Nasz zespół chętnie pomoże w sprawie zamówień, produktów i zwrotów.',
    'Contact us': 'Napisz do nas',

    # Store benefits.
    ('Pattern title', 'Store benefits'): 'Zalety sklepu',
    ('Pattern description', 'Four short benefits with icons: delivery, returns, payments and customer support.'): 'Cztery krótkie korzyści z ikonami: dostawa, zwroty, płatności i obsługa klienta.',
    'Fast, free delivery': 'Szybka, darmowa dostawa',
    'On all orders over %s': 'Dla zamówień od %s',
    '30-day returns': '30 dni na zwrot',
    'Changed your mind? No problem': 'Zmiana zdania? Żaden problem',
    'Secure payments': 'Bezpieczne płatności',
    'Cards, transfers and mobile wallets': 'Karty, przelewy i portfele mobilne',
    'Real people, real help': 'Prawdziwi ludzie, prawdziwa pomoc',
    'We reply within one business day': 'Odpowiadamy w ciągu jednego dnia roboczego',

    # Footer.
    ('Pattern title', 'Footer with store menus'): 'Stopka z menu sklepu',
    ('Pattern description', 'Dark footer with brand description, social links, store menus, contact details, legal links and payment methods.'):
        'Ciemna stopka z opisem marki, linkami do mediów społecznościowych, menu sklepu, danymi kontaktowymi, linkami prawnymi i metodami płatności.',
    'Thoughtfully chosen products for everyday life. Designed to last, packed with care and shipped quickly to your door.':
        'Starannie wybrane produkty do codziennego życia. Zaprojektowane na lata, pakowane z troską i szybko wysyłane pod Twoje drzwi.',
    'Shop': 'Sklep',
    'All products': 'Wszystkie produkty',
    'New arrivals': 'Nowości',
    'Bestsellers': 'Bestsellery',
    'Top rated': 'Najwyżej oceniane',
    'Customer care': 'Obsługa klienta',
    'Delivery and payment': 'Dostawa i płatność',
    'Returns and complaints': 'Zwroty i reklamacje',
    'Order status': 'Status zamówienia',
    'Frequently asked questions': 'Częste pytania',
    'Contact': 'Kontakt',
    'Monday to Friday, 9:00–17:00': 'Od poniedziałku do piątku, 9:00–17:00',
    'Terms and conditions': 'Regulamin',
    'Privacy policy': 'Polityka prywatności',

    # Social gallery.
    ('Pattern title', 'Social media gallery'): 'Galeria z mediów społecznościowych',
    ('Pattern description', 'Grid of square photos with a link to your social media profile.'): 'Siatka kwadratowych zdjęć z linkiem do profilu w mediach społecznościowych.',
    'Share your space with us': 'Pokaż nam swoje wnętrze',
    'Tag your photos with #witryna and get featured in our gallery.': 'Oznacz zdjęcia tagiem #witryna, a pokażemy je w naszej galerii.',
    'Follow us on Instagram': 'Obserwuj nas na Instagramie',

    # Header and search.
    ('Pattern title', 'Header with announcement bar'): 'Nagłówek z paskiem ogłoszeń',
    ('Pattern description', 'Announcement bar, logo, main menu, product search, customer account and mini cart.'): 'Pasek ogłoszeń, logo, menu główne, wyszukiwarka produktów, konto klienta i mini koszyk.',
    'Free delivery on orders over %s': 'Darmowa dostawa od %s',
    '30-day free returns': 'Bezpłatny zwrot do 30 dni',
    'Secure online payments': 'Bezpieczne płatności online',
    ('search label', 'Search products'): 'Szukaj produktów',
    'Search products…': 'Szukaj produktów…',
    ('search button', 'Search'): 'Szukaj',
    ('search label', 'Search'): 'Szukaj',
    'Search…': 'Szukaj…',

    # Heroes.
    ('Pattern title', 'Hero with full-width image'): 'Hero ze zdjęciem na całą szerokość',
    ('Pattern description', 'Full-width photo with a headline and buttons in the bottom left corner.'): 'Zdjęcie na całą szerokość z nagłówkiem i przyciskami w lewym dolnym rogu.',
    'The winter edit': 'Zimowa selekcja',
    'Warm light for long evenings': 'Ciepłe światło na długie wieczory',
    'Lamps, candles and textiles that make every room feel like home.': 'Lampy, świece i tekstylia, dzięki którym każde wnętrze staje się domem.',
    'Discover the collection': 'Odkryj kolekcję',
    ('Pattern title', 'Hero with product image'): 'Hero ze zdjęciem produktu',
    ('Pattern description', 'Large headline, call to action buttons and social proof next to a tall product image with a floating label.'):
        'Duży nagłówek, przyciski wezwania do działania i opinie klientów obok wysokiego zdjęcia produktu z pływającą etykietą.',
    'New collection · Autumn 2026': 'Nowa kolekcja · Jesień 2026',
    'Objects for slow, beautiful days': 'Przedmioty na spokojne, piękne dni',
    'Ceramics, light and home accessories made in small batches by independent studios. Pieces you will want to keep for years.':
        'Ceramika, oświetlenie i dodatki do domu tworzone w krótkich seriach przez niezależne pracownie. Rzeczy, które zechcesz mieć na lata.',
    'Shop the collection': 'Zobacz kolekcję',
    'Browse categories': 'Przeglądaj kategorie',
    '4.9/5 from over 2,400 reviews': '4,9/5 na podstawie ponad 2400 opinii',
    'Handmade ceramic vases on a sunlit shelf': 'Ręcznie robione ceramiczne wazony na nasłonecznionej półce',
    'Bestseller': 'Bestseller',
    'Amfora stoneware vase': 'Wazon Amfora z kamionki',
    'from %s': 'od %s',

    # 404, blog, search.
    ('Pattern title', '404'): '404',
    'Error 404': 'Błąd 404',
    'This page went shopping': 'Ta strona poszła na zakupy',
    'The page you are looking for does not exist or has been moved. Let us help you find something nice instead.':
        'Strona, której szukasz, nie istnieje lub została przeniesiona. Pomożemy Ci znaleźć coś równie ładnego.',
    'Go to the shop': 'Przejdź do sklepu',
    'Back to home page': 'Wróć na stronę główną',
    ('Pattern title', 'Blog heading'): 'Nagłówek bloga',
    'Journal': 'Blog',
    'Stories, guides and news from our studio': 'Historie, poradniki i nowości z naszej pracowni',
    ('Pattern title', 'Comments'): 'Komentarze',
    ('Pattern title', 'No results'): 'Brak wyników',
    'Nothing here yet': 'Na razie nic tu nie ma',
    'We could not find anything matching your request. Try a different search or browse the shop.':
        'Nie znaleźliśmy niczego, co pasuje do zapytania. Spróbuj wyszukać coś innego lub przejrzyj sklep.',
    ('Pattern title', 'Post meta'): 'Metadane wpisu',
    ('Pattern title', 'Posts grid'): 'Siatka wpisów',
    ('Pattern title', 'Search form'): 'Formularz wyszukiwania',

    # Single product.
    ('Pattern title', 'Product details accordion'): 'Akordeon ze szczegółami produktu',
    ('Pattern description', 'Description, specifications and delivery information in an accordion.'): 'Opis, specyfikacja i informacje o dostawie w akordeonie.',
    'Description': 'Opis',
    'Specifications': 'Specyfikacja',
    'Delivery and returns': 'Dostawa i zwroty',
    'Orders placed on business days before 2 pm are shipped the same day.': 'Zamówienia złożone w dni robocze do 14:00 wysyłamy tego samego dnia.',
    'Choose courier delivery, a parcel locker or in-store pickup at checkout.': 'Przy zamówieniu wybierzesz kuriera, paczkomat lub odbiór osobisty w salonie.',
    'You can return the product within 30 days without giving a reason.': 'Produkt możesz zwrócić w ciągu 30 dni bez podawania przyczyny.',
    ('Pattern title', 'Product filters'): 'Filtry produktów',
    ('Pattern description', 'Category, price, attribute, rating and stock filters. On small screens they open in a drawer.'):
        'Filtry kategorii, ceny, atrybutów, oceny i dostępności. Na małych ekranach otwierają się w szufladzie.',
    'Filters': 'Filtry',
    'Clear filters': 'Wyczyść filtry',
    'Category': 'Kategoria',
    'Price': 'Cena',
    'Rating': 'Ocena',
    'Availability': 'Dostępność',
    ('Pattern title', 'Product meta'): 'Metadane produktu',
    'Brand: ': 'Marka: ',
    'Tags: ': 'Tagi: ',
    ('Pattern title', 'Product reviews section'): 'Sekcja opinii o produkcie',
    ('Pattern title', 'Product trust badges'): 'Gwarancje przy produkcie',
    ('Pattern description', 'Delivery, returns and payment reassurance shown next to the add to cart button.'):
        'Informacje o dostawie, zwrotach i płatnościach wyświetlane przy przycisku dodawania do koszyka.',
    '<strong>Free delivery</strong> on orders over %s, dispatched within 24 hours': '<strong>Darmowa dostawa</strong> od %s, wysyłka w ciągu 24 godzin',
    '<strong>30 days</strong> to return or exchange, free of charge': '<strong>30 dni</strong> na bezpłatny zwrot lub wymianę',
    '<strong>Secure payments</strong> by card, bank transfer or mobile wallet': '<strong>Bezpieczne płatności</strong> kartą, przelewem lub portfelem mobilnym',
    ('Pattern title', 'Related products'): 'Powiązane produkty',
    'You may also like': 'Może Ci się spodobać',

    # Mobile menu.
    ('Pattern title', 'Mobile menu'): 'Menu mobilne',
    ('Pattern description', 'Full-screen menu with large links, product search and quick links to the account.'): 'Menu na cały ekran z dużymi linkami, wyszukiwarką produktów i szybkim dostępem do konta.',
    'Need help?': 'Potrzebujesz pomocy?',

    # Newsletter.
    ('Pattern title', 'Newsletter call to action'): 'Zachęta do zapisu na newsletter',
    ('Pattern description', 'Dark band encouraging visitors to join the newsletter. Replace the button with the form block of your newsletter plugin.'):
        'Ciemny pas zachęcający do zapisu na newsletter. Zastąp przycisk blokiem formularza z wtyczki do newslettera.',
    'Get 10% off your first order': 'Odbierz 10% rabatu na pierwsze zamówienie',
    'Join our newsletter to hear about new collections, studio stories and offers before anyone else.':
        'Zapisz się do newslettera, a o nowych kolekcjach, historiach z pracowni i ofertach dowiesz się przed wszystkimi.',
    'Join the newsletter': 'Zapisz się',
    'No spam. You can unsubscribe at any time.': 'Zero spamu. Możesz wypisać się w każdej chwili.',

    # About page.
    ('Pattern title', 'About us page'): 'Strona „O nas”',
    ('Pattern description', 'About page with an introduction, wide photo, brand values and a call to action.'): 'Strona o firmie ze wstępem, szerokim zdjęciem, wartościami marki i wezwaniem do działania.',
    'Responsibly made': 'Odpowiedzialna produkcja',
    'We choose durable materials and work with studios that pay fair wages and minimise waste.': 'Wybieramy trwałe materiały i współpracujemy z pracowniami, które uczciwie płacą i ograniczają odpady.',
    'Checked by hand': 'Sprawdzone ręcznie',
    'Every item is inspected before shipping, so you receive exactly what you see in the photos.': 'Każdy przedmiot oglądamy przed wysyłką, więc dostajesz dokładnie to, co widzisz na zdjęciach.',
    'Plastic-free packaging': 'Opakowania bez plastiku',
    'We pack orders in recycled paper and reuse boxes from our suppliers whenever possible.': 'Pakujemy w papier z recyklingu i, gdy tylko się da, ponownie wykorzystujemy kartony od dostawców.',
    'About us': 'O nas',
    'We believe in fewer, better things': 'Wierzymy w mniej, ale lepiej',
    'Our shop began as a small market stall. Today we ship across the country, but our approach has not changed: we sell only what we would happily use at home ourselves.':
        'Nasz sklep zaczynał jako małe stoisko na targu. Dziś wysyłamy w całym kraju, ale podejście się nie zmieniło: sprzedajemy tylko to, czego sami chętnie używamy w domu.',
    'Our studio with shelves full of ceramics': 'Nasza pracownia z półkami pełnymi ceramiki',
    'What we stand for': 'W co wierzymy',

    # Contact page.
    ('Pattern title', 'Contact page'): 'Strona kontaktowa',
    ('Pattern description', 'Contact cards, opening hours, company details and frequently asked questions.'): 'Karty kontaktowe, godziny otwarcia, dane firmy i najczęściej zadawane pytania.',
    'Email': 'E-mail',
    'We reply within one business day.': 'Odpowiadamy w ciągu jednego dnia roboczego.',
    'Phone': 'Telefon',
    'Showroom': 'Salon',
    'ul. Przykładowa 12, 00-001 Warszawa': 'ul. Przykładowa 12, 00-001 Warszawa',
    'Tuesday to Saturday, 11:00–19:00': 'Od wtorku do soboty, 11:00–19:00',
    'We are here to help': 'Jesteśmy tu, by pomóc',
    'Questions about an order, a product or a return? Get in touch the way that suits you best.': 'Pytania o zamówienie, produkt albo zwrot? Skontaktuj się z nami w najwygodniejszy sposób.',
    'Company details': 'Dane firmy',
    'Example Store Ltd.<br>ul. Przykładowa 12, 00-001 Warszawa<br>Tax ID (NIP): 000-000-00-00 · Company number (KRS): 0000000000':
        'Przykładowy Sklep sp. z o.o.<br>ul. Przykładowa 12, 00-001 Warszawa<br>NIP: 000-000-00-00 · KRS: 0000000000',

    # Home page and sections.
    ('Pattern title', 'Store home page'): 'Strona główna sklepu',
    ('Pattern description', 'Complete store home page: hero, benefits, categories, bestsellers, promotion, new arrivals, reviews, brand story and newsletter.'):
        'Kompletna strona główna sklepu: hero, korzyści, kategorie, bestsellery, promocja, nowości, opinie, historia marki i newsletter.',
    ('Pattern title', 'Latest journal posts'): 'Najnowsze wpisy z bloga',
    ('Pattern description', 'Three most recent blog posts with images.'): 'Trzy najnowsze wpisy z bloga ze zdjęciami.',
    'Inspiration and guides': 'Inspiracje i poradniki',
    'All articles': 'Wszystkie artykuły',
    ('Pattern title', 'Promotion banner'): 'Baner promocyjny',
    ('Pattern description', 'Seasonal campaign with a large image and a call to action on a soft accent card.'): 'Sezonowa kampania z dużym zdjęciem i wezwaniem do działania na karcie w kolorze akcentu.',
    'Seasonal tableware arranged on a linen cloth': 'Sezonowa zastawa ułożona na lnianym obrusie',
    'End of season': 'Koniec sezonu',
    'Up to 30% off selected favourites': 'Do −30% na wybrane ulubione produkty',
    'Refresh your home for the colder months. Discounts apply automatically in the cart.': 'Odśwież wnętrze na chłodniejsze miesiące. Rabaty naliczają się automatycznie w koszyku.',
    'Shop the sale': 'Kupuj w promocji',
    'Offer valid while stocks last. Prices include VAT.': 'Oferta ważna do wyczerpania zapasów. Ceny zawierają VAT.',
    ('Pattern title', 'Bestsellers'): 'Bestsellery',
    ('Pattern description', 'Grid of the best selling products with a link to the full catalogue.'): 'Siatka najlepiej sprzedających się produktów z linkiem do pełnego katalogu.',
    'Customer favourites': 'Ulubione klientów',
    'View all': 'Zobacz wszystkie',
    ('Pattern title', 'Shop by category'): 'Zakupy według kategorii',
    ('Pattern description', 'Image tiles for the four most popular product categories. Category thumbnails are used when available.'):
        'Kafle ze zdjęciami czterech najpopularniejszych kategorii produktów. Jeśli kategorie mają miniatury, zostaną użyte.',
    '%s product': ['%s produkt', '%s produkty', '%s produktów'],
    'Ceramics': 'Ceramika',
    'Explore': 'Zobacz',
    'Lighting': 'Oświetlenie',
    'Kitchen': 'Kuchnia',
    'Decor': 'Dekoracje',
    'Categories': 'Kategorie',
    'Shop by category': 'Kupuj według kategorii',
    ('Pattern title', 'New arrivals'): 'Nowości',
    ('Pattern description', 'The newest products in the store.'): 'Najnowsze produkty w sklepie.',
    'Just landed': 'Właśnie dotarły',
    ('Pattern title', 'Products on sale'): 'Produkty w promocji',
    ('Pattern description', 'Products that are currently discounted, on a soft accent background.'): 'Produkty, które są obecnie przecenione, na jasnym tle w kolorze akcentu.',
    'Limited time': 'Tylko przez chwilę',
    'On sale now': 'Teraz w promocji',
    ('Pattern title', 'Customer reviews'): 'Opinie klientów',
    ('Pattern description', 'Three customer reviews with star ratings on cards.'): 'Trzy opinie klientów z oceną w gwiazdkach na kartach.',
    'The vase is even more beautiful in person. Carefully packed and delivered the next day. I am already planning my next order.':
        'Wazon na żywo jest jeszcze piękniejszy. Starannie zapakowany i dostarczony następnego dnia. Już planuję kolejne zamówienie.',
    'Anna, Kraków': 'Anna, Kraków',
    'Great quality and a really thoughtful selection. Customer service helped me choose the right lamp size within an hour.':
        'Świetna jakość i naprawdę przemyślany wybór. Obsługa w godzinę pomogła mi dobrać właściwy rozmiar lampy.',
    'Michał, Gdańsk': 'Michał, Gdańsk',
    'Globe table lamp': 'Lampa stołowa Glob',
    'I bought a set of mugs as a gift and ended up keeping two for myself. Simple, elegant and perfect for everyday use.':
        'Kupiłam zestaw kubków na prezent, a dwa zostawiłam sobie. Proste, eleganckie i idealne na co dzień.',
    'Kasia, Wrocław': 'Kasia, Wrocław',
    'Morning mug set': 'Zestaw kubków Poranek',
    'Reviews': 'Opinie',
    'Loved by over 2,400 customers': 'Pokochało nas ponad 2400 klientów',
    'Verified purchase · %s': 'Zweryfikowany zakup · %s',
}


def main():
    cat = i18n.build_catalog()
    out, missing = [], []
    for (ctx, msgid), e in cat.entries.items():
        n = dict(e)
        tr = T.get((ctx, msgid)) if ctx else T.get(msgid)
        if tr is None and ctx:
            tr = T.get(msgid)
        if isinstance(tr, list):
            n['msgstr_plural'] = tr
        elif tr is not None:
            n['msgstr'] = tr
        else:
            missing.append((ctx, msgid))
        out.append(n)
    i18n.write_po(os.path.join(i18n.LANG, 'pl_PL.po'), out, i18n.po_header('pl_PL'))
    print(f'pl_PL.po: {len(out)} strings, {len(missing)} missing')
    for m in missing:
        print('  missing:', m)


if __name__ == '__main__':
    main()
