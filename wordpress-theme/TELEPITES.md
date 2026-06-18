# Chili Baja WordPress Téma – Telepítési útmutató

## Előfeltételek
- WordPress 6.0+
- WooCommerce plugin telepítve és aktiválva
- PHP 8.0+

## Telepítés lépései

### 1. Képek másolása
Másold át a következő képeket az `assets/images/` mappába:
- `chilik.webp` (a fő hero kép)
- `Chilicsepp-10ml.webp` (termékképek)
- `csepp.png`

### 2. Téma feltöltése WordPressbe
- Tömörítsd be a `wordpress-theme/` mappát ZIP-be
- WordPress admin → Megjelenés → Témák → Téma hozzáadása → Téma feltöltése
- Aktiváld a "Chili Baja" témát

### 3. WooCommerce beállítások
- WooCommerce → Beállítások → Általános: állítsd be a pénznemet (HUF), országot
- WooCommerce → Termékek: add hozzá a meglévő termékeidet képekkel és árakkal
- WooCommerce → Fizetési módok: konfiguráld (Barion, SimplePay, utánvét, stb.)
- WooCommerce → Szállítás: add meg a szállítási zónákat és díjakat

### 4. Menük beállítása
- Megjelenés → Menük: hozz létre egy "Fő navigáció" menüt
- Add hozzá: Főoldal, Webshop (WooCommerce Shop oldal), Rólunk (oldal), Kapcsolat (oldal)

### 5. Oldalak létrehozása
- Szerkesztő → Oldalak → Új:
  - "Rólunk" nevű oldal
  - "Kapcsolat" nevű oldal (Contact Form 7 shortcode-dal)
  - "ÁSZF" nevű oldal

### 6. Főoldal beállítása
- Beállítások → Olvasás → A főoldal megjelenítse: "Egy statikus oldal"
- Válaszd ki a főoldalnak az "Főoldal" nevű oldalt
- Ha nincs ilyen, hozz létre egyet

### 7. Tailwind élesítés előtt
A Tailwind CDN csak fejlesztéshez való! Éles környezetben:
- Futtasd le: `npx tailwindcss -o assets/css/tailwind.css --minify`
- A `functions.php`-ban cseréld le a CDN scriptet a lokális fájlra

## Fájlstruktúra
```
wordpress-theme/
├── style.css           ← Téma info + közös stílusok
├── functions.php       ← WP funkciók, script betöltés
├── header.php          ← Fejléc + navigáció
├── footer.php          ← Lábléc
├── front-page.php      ← Főoldal (hero, termékek, rólunk, kapcsolat)
├── page.php            ← Általános oldalak
├── index.php           ← Blog/archív fallback
├── assets/
│   ├── images/         ← Képek ide kerüljenek
│   └── js/             ← Egyedi JS fájlok (opcionális)
└── woocommerce/
    └── archive-product.php  ← Webshop terméklista
```
