# Witryna – nowoczesny motyw WooCommerce

Motyw blokowy (Full Site Editing) dla WordPress 7.0+ i WooCommerce 10+
(testowany: WordPress 7.1.2, WooCommerce 11.1.2, PHP 8.3).

Katalog główny repozytorium **jest motywem** (`style.css`, `theme.json`, `templates/`…),
więc można go instalować bezpośrednio z GitHuba.

## Klinika Trawnika

Od wersji 1.2.0 motyw jest dopasowany do sklepu Klinika Trawnika (dealer STIHL, Czernica):
grafitowo-pomarańczowa paleta, ostrzejsze rogi, pasek z adresem, godzinami, telefonem i TikTokiem.

- **Dane sklepu** (telefon, e-mail, adres, NIP, godziny, TikTok, link do opinii Google) są w jednym
  miejscu: `inc/klinika.php` → `witryna_store_info()`. Można je też nadpisać filtrem `witryna_store_info`.
- **Strony** dostają gotowy układ automatycznie po slugu (szablony `templates/page-{slug}.html`):
  `serwis`, `kontakt`, `opinie`, `social-media`, `o-firmie`. Wystarczy utworzyć pustą stronę o takim
  adresie. Treść wpisana w edytorze pojawia się pod gotowym układem (np. formularz zgłoszenia serwisu).
- **Opinie**: blok `witryna/reviews` (strona główna i /opinie) pokazuje opinie z Google (wyświetla je
  sam Google, patrz niżej) i zatwierdzone opinie produktów z WooCommerce, od najnowszych, z każdą
  oceną, nigdy przykładowe. Na /opinie jest też informacja, czy i jak opinie są weryfikowane.
- Nowe ikony: `shield`, `wrench`, `store`, `clock`, `pin`, `star` (`npm run icons`).

## Opinie Google

Opinie i ocenę z wizytówki Google pokazuje w przeglądarce oficjalny element Google (Places UI Kit).
Sklep nic z Google nie pobiera ani nie przechowuje, tak jak wymaga regulamin Google Maps Platform.

1. W [Google Cloud](https://console.cloud.google.com) utwórz projekt z kontem rozliczeniowym i włącz
   **Maps JavaScript API** oraz **Places UI Kit**.
2. Utwórz klucz API. Ogranicz go do witryn sklepu (np. `https://sklep.sze.one/*`) i do tych dwóch API.
3. W *Places UI Kit → Quotas* ustaw dzienny limit (np. 300 na dzień). Darmowa pula „Places UI Kit Query”
   to 10 000 wczytań miesięcznie.
4. W WordPressie: **Wygląd → Dostosuj → Opinie Google**: wklej klucz (Place ID jest już wpisany).
   „Wczytuj opinie Google automatycznie” zaznacz dopiero, gdy polityka prywatności (i baner cookies)
   obejmuje Mapy Google. Bez tego opinie wczytują się po kliknięciu „Pokaż opinie z Google”.
5. Zalecane w WooCommerce (*Ustawienia → Produkty → Opinie*): „Opinie mogą wystawiać tylko
   zweryfikowani właściciele”. Wtedy strona /opinie informuje, że opinie ze sklepu są weryfikowane.

Bez klucza widać linki do wizytówki w Mapach Google i opinie ze sklepu. Wtyczka cookies może wczytać
opinie po zgodzie, wywołując `window.witrynaLoadGoogleReviews()`.

## Instalacja

**Z GitHuba (bez wtyczek)**
1. Na GitHubie: *Code → Download ZIP*.
2. WordPress → *Wygląd → Motywy → Dodaj nowy motyw → Wyślij motyw na serwer* i wskaż pobrany plik.

Archiwum z GitHuba zawiera tylko pliki motywu – narzędzia deweloperskie są wyłączone
w `.gitattributes` (`export-ignore`).

**Z GitHuba z automatycznymi aktualizacjami**
Wtyczka [Git Updater](https://git-updater.com/) odczytuje nagłówek `GitHub Theme URI`
z `style.css` (`SzymonEls/sklep-motyw`, gałąź `main`). Działa też [WP Pusher](https://wppusher.com/)
– wystarczy wskazać repozytorium i gałąź `main`.

**Z paczki ZIP**
```bash
npm run build
```
Tworzy `dist/witryna.zip` (folder `witryna/` z samymi plikami motywu).

## Ustaw sklep (po instalacji na nowym serwerze)

Po wgraniu i włączeniu motywu na nowym serwerze wejdź w **Wygląd → Ustaw sklep**. Ekran porównuje
sklep z lokalnym podglądem i pokazuje w tabeli, co zrobi każdy krok i jaki jest stan obecny.
Przed pierwszym uruchomieniem na działającym sklepie zrób kopię zapasową bazy danych (np. w panelu
hostingu).

- tworzy brakujące strony (Strona główna, Blog, Serwis, Opinie, Social media, O firmie, Kontakt,
  Regulamin), ustawia stronę główną i blog, menu „Menu główne” (Sklep z kategoriami, które mają
  produkty, i strony), nazwę i opis witryny, adres sklepu, opinie tylko od zweryfikowanych klientów
  oraz polskie tytuły stron WooCommerce,
- domyślnie zaznaczone są kroki, które dodają brakujące rzeczy albo zmieniają ustawienia różniące
  się od podglądu: istniejąca strona (także szkic lub strona w koszu), własne menu, własna nazwa
  witryny i wpisany adres zostają bez zmian; tytuły stron WooCommerce i ustawienia opinii są
  zaznaczone, gdy różnią się od podglądu, a nie zostały zmienione ręcznie – sprawdź je przed
  kliknięciem; poradniki z podglądu i przeniesienie przykładowych treści WordPressa do kosza trzeba
  zaznaczyć samemu,
- strona „Regulamin” powstaje jako szkic z tymczasowym tekstem – wklej regulamin, opublikuj stronę
  i wybierz ją w WooCommerce → Ustawienia → Zaawansowane,
- menu najlepiej tworzyć po ustawieniu bezpośrednich odnośników na „Nazwa wpisu” – przy „Prosty”
  ten krok nie jest zaznaczony,
- nigdy nie zmienia produktów, kategorii, płatności (PayU), wysyłki, trybu „Wkrótce dostępny”
  ani bezpośrednich odnośników – tylko o nich przypomina.

Po kliknięciu **Zastosuj zaznaczone** ekran pokazuje wynik z linkami. Narzędzie można uruchomić
ponownie: to, co jest gotowe, zostaje bez zmian. Dopóki brakuje stron z gotowym układem lub menu,
na Kokpicie i ekranie Motywy widać przypomnienie (można je ukryć). Strony, menu i ustawienia są
zdefiniowane w `inc/store-setup.php` i z tych samych funkcji korzysta `dev/demo/setup.php`, więc
podgląd i sklep się nie rozjadą (w podglądzie kategorie w menu są w kolejności katalogu, w sklepie
alfabetycznie).

## Co zawiera
- `theme.json` z paletą, płynną typografią, odstępami i zaokrągleniami; 5 wariantów stylu
  (domyślny, Night, Atelier, Forest, Contrast) i 4 style sekcji.
- Szablony: strona główna, sklep z filtrami, karta produktu (galeria, warianty, akordeon,
  recenzje, polecane), koszyk, kasa z uproszczonym nagłówkiem, potwierdzenie zamówienia,
  blog, wyszukiwarka, 404, strony bez tytułu / landing / szeroka.
- 34 wzorce (hero, korzyści, kategorie z danych sklepu, bestsellery, nowości, promocje,
  opinie, FAQ, newsletter, strony „O nas” i „Kontakt”).
- Przyklejony nagłówek chowany przy przewijaniu, własne menu mobilne (nakładka WP 7.x),
  ikony w rejestrze ikon WP 7.1.
- Plakietki „−20%”, „Nowość”, „Wyprzedane” i drugie zdjęcie produktu po najechaniu.
- Fonty lokalne (zgodne z RODO) i obrazy wygenerowane proceduralnie (bez licencji osób trzecich).

## Struktura repozytorium
```
style.css, theme.json, functions.php   nagłówek, ustawienia i kod motywu
assets/ inc/ languages/ parts/          zasoby, moduły PHP, tłumaczenia, części szablonu
patterns/ styles/ templates/            wzorce, warianty stylu, szablony
dev/                                    narzędzia deweloperskie (nie trafiają do paczek)
```

## Lokalny sklep demo
```bash
npm install
npm start      # http://127.0.0.1:9400 (dopisz ?dev-login=1, aby zalogować się jako admin)
npm run reset  # nowy sklep od zera
```
Pierwsze uruchomienie instaluje WordPressa, WooCommerce, polskie tłumaczenia i sklep Kliniki
Trawnika z produktami STIHL (kilka minut). Strona demo jest przechowywana w `node_modules/.cache/witryna-playground`.

Produkty pochodzą z `dev/demo/stihl-products.json` (kategorie stihl.pl, do których linkuje stara
strona sklepu). Domyślnie importowanych jest do 6 produktów na kategorię, wszystkie:
`WITRYNA_DEMO_ALL=1 npm run reset`. Zdjęcia są pobierane ze stihl.pl przy instalacji,
ceny to ceny katalogowe STIHL bez promocji. Odświeżenie danych ze stihl.pl:
```bash
python3 dev/tools/stihl-products.py           # ok. 10 minut, 1 zapytanie na sekundę
python3 dev/tools/stihl-products.py --images  # tylko ponowne sprawdzenie zdjęć promocyjnych
```

## Tłumaczenia
Teksty źródłowe są po angielsku, zgodnie z konwencją WordPressa.
`npm run i18n` odświeża `languages/witryna.pot`, aktualizuje pliki `.po`
i kompiluje `.mo` oraz `.l10n.php`!
