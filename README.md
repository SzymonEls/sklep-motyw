# Witryna – nowoczesny motyw WooCommerce

Motyw blokowy (Full Site Editing) dla WordPress 7.0+ i WooCommerce 10+ (testowany: WP 7.1.2, WooCommerce 11.1.2, PHP 8.3).

## Instalacja
1. `npm run build` → `dist/witryna.zip`
2. WordPress → Wygląd → Motywy → Dodaj nowy → Wyślij motyw na serwer.

## Co zawiera
- `theme.json` z paletą, typografią płynną, odstępami, zaokrągleniami; 5 wariantów stylu (domyślny, Night, Atelier, Forest, Contrast) i 4 style sekcji.
- Szablony: strona główna, sklep z filtrami, karta produktu (galeria, warianty, akordeon, recenzje, powiązane), koszyk, kasa (z uproszczonym nagłówkiem), potwierdzenie zamówienia, blog, wyszukiwarka, 404, strony bez tytułu / landing / szeroka.
- 34 wzorce (hero, korzyści, kategorie z danych sklepu, bestsellery, nowości, promocje, opinie, FAQ, newsletter, strony „O nas” i „Kontakt”).
- Przyklejony nagłówek chowany przy przewijaniu, własne menu mobilne (nakładka WP 7.x), ikony w rejestrze ikon WP 7.1.
- Plakietki „−20%”, „Nowość”, „Wyprzedane”, drugie zdjęcie produktu po najechaniu.
- Fonty lokalne (zgodne z RODO), obrazy wygenerowane proceduralnie (bez praw autorskich osób trzecich).

## Lokalny sklep demo
```bash
npm install
npm start      # http://127.0.0.1:9400 (dopisz ?dev-login=1 aby się zalogować)
npm run reset  # nowy sklep od zera
```

## Tłumaczenia
Teksty źródłowe są po angielsku; `languages/witryna.pot` zawiera ~300 ciągów.
`python3 dev/tools/i18n.py update` tworzy/aktualizuje `languages/pl_PL.po`, a `python3 dev/tools/i18n.py compile` buduje `.mo` i `.l10n.php`.
