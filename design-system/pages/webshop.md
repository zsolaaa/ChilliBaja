# Chili Baja – Webshop (webshop.html + shop.html) Override

> Örökli: `design-system/MASTER.md`
> Csak az eltérések vannak itt dokumentálva.

---

## Oldal típus
E-commerce terméklistázó + kosár + checkout — SPA-jellegű, nézetek közötti váltással

## Nézetek (view-switching, nem routing)

| Nézet ID | Tartalom | Aktiválás |
|----------|----------|-----------|
| `#shop-view` | Termékgrid + szűrők | Alapértelmezett |
| `#detail-view` | Termék részletek | `openDetail(id)` |
| `#checkout-view` | 3 lépéses checkout | Kosár → Tovább |
| `#confirm-view` | Rendelés visszaigazolás | `submitOrder()` |
| `#cart-drawer` | Kosár oldalpanel | `openCart()` |

## Termékgrid

- `PRODUCTS` tömb (statikus adatok) → `PRODUCT_MAP` (O(1) lookup)
- `renderGrid(filter)` — `loadCart()` egyszer, cikluson kívül
- Kártya: `article.product-card.fade-up`, `content-visibility: auto`, `contain-intrinsic-size: 0 380px`
- Szűrők: `all | sauce | other | gift | spice`
- Heat bar: shared `IntersectionObserver`, `data-w` attribútum

## Kosár drawer

- `role="dialog"`, `aria-labelledby="cart-drawer-title"`, `aria-modal="true"`
- Bezárás: `aria-label="Kosár bezárása"` a close gombon
- Overlay: `rgba(0,0,0,0.55)` scrim
- Panel: `overscroll-behavior: contain` — megakadályozza a mögöttes oldal scrollját
- Szállítási progress bar: 20.000 Ft küszöb ingyenes szállításhoz

## Checkout form (3 lépés)

| Lépés | Tartalom | Gomb |
|-------|----------|------|
| 1 | Szállítási adatok | "Tovább a fizetéshez →" |
| 2 | Fizetési mód + összegzés | "Rendelés leadása" |
| 3 | Visszaigazolás (email mailto) | "Vásárlás folytatása" |

**Input tokenek:**
- `fname`: `type="text"`, `autocomplete="family-name"`
- `lname`: `type="text"`, `autocomplete="given-name"`
- `email`: `type="email"`, `autocomplete="email"`, `spellcheck="false"`
- `phone`: `type="tel"`, `inputmode="tel"`, `autocomplete="tel"`
- `zip`: `type="text"`, `inputmode="numeric"`, `autocomplete="postal-code"`, `maxlength="4"`, `pattern="[0-9]{4}"`
- `city`: `type="text"`, `autocomplete="address-level2"`
- `street`: `type="text"`, `autocomplete="street-address"`

## Ár formázás

```js
var _nf = new Intl.NumberFormat('hu-HU');
function fmt(n) { return _nf.format(n) + ' Ft'; }
```
Minden ár elem kap `tabular-nums` CSS osztályt.

## Rendelés folyamata (mailto alapú)

- `submitOrder()` → `mailto:` link generálás a rendelési adatokból
- Visszaigazolás a `#confirm-view`-ban, email cím megjelenítéssel
- Fizetési módok: e-mailes egyeztetés / átutalás / utánvét (+350 Ft)

## Kosár perzisztencia

- `localStorage` kulcs: `chillibaja_cart`
- `loadCart()` / `saveCart(cart)` — a cart objektum: `{ [productId]: { name, price, qty, size } }`
- `cartStats(cart)` → `{ total, count }` egyszeri iterációval
