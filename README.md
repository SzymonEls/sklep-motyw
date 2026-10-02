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
- **Opinie**: sekcje pokazują wyłącznie prawdziwe, zatwierdzone opinie produktów z WooCommerce
  (`witryna_store_reviews()`), nigdy przykładowe.
- Nowe ikony: `shield`, `wrench`, `store`, `clock`, `pin`, `star` (`npm run icons`).

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
Pierwsze uruchomienie instaluje WordPressa, WooCommerce, polskie tłumaczenia i przykładowe
produkty (kilka minut). Strona demo jest przechowywana w `node_modules/.cache/witryna-playground`.

## Tłumaczenia
Teksty źródłowe są po angielsku, zgodnie z konwencją WordPressa.
`npm run i18n` odświeża `languages/witryna.pot`, aktualizuje pliki `.po`
i kompiluje `.mo` oraz `.l10n.php`!
