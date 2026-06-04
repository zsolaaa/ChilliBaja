# Chili Baja – Design System MASTER

> **Source of Truth** minden oldal és komponens számára.
> Oldal-specifikus felülírásokhoz: `design-system/pages/<oldalnev>.md`

---

## 1. Termék & Stílus Profil

| Tulajdonság | Érték |
|-------------|-------|
| **Termék típus** | Kézműves élelmiszer e-commerce (D2C, kis márka) |
| **Stílus** | Dark Premium Artisan — tüzes, sötét, prémium kézműves |
| **Hangulat** | Intenzív, természetes, autentikus, parázs-érzetű |
| **Célközönség** | 25–55 éves, gasztronómia-rajongók, ajándékvásárlók |
| **Platform** | Web (desktop + mobile responsive) |
| **Stack** | Vanilla HTML + Tailwind CSS CDN + vanilla JS |

**Anti-patternek kerülendők:**
- Fehér/világos háttér (elveszíti a brand hangulatot)
- Túl sok animáció egyszerre (max 1-2 elem per viewport)
- Emoji ikonok rendszer-ikonként (Material Symbols használata helyette)
- Neon/cyberpunk vizuális elemek (nem illik az artisan hanghoz)
- Helvetica / Inter / Roboto — túl generikus ehhez a brandhez

---

## 2. Színrendszer

### Material Design 3 alapú sötét séma

```
Alap háttér / felszínek
──────────────────────
background / surface-dim        #131313   ← legmélyebb réteg
surface-container-lowest        #0e0e0e   ← mélyebb felszín
surface-container-low           #1c1b1b   ← kártyák háttere
surface-container               #201f1f   ← másodlagos felszín
surface-container-high          #2a2a2a   ← emeltebb felszín
surface-container-highest       #353534   ← legmagasabb felszín
surface-bright                  #393939   ← legvilágosabb sötét

Szöveg
──────
on-surface                      #e5e2e1   ← elsődleges szöveg
on-surface-variant              #c9a99f   ← másodlagos szöveg
on-background                   #e5e2e1

Elsődleges szín (barack/lazac)
──────────────────────────────
primary / primary-fixed-dim     #ffb5a0   ← fő akcióshín
primary-fixed                   #ffdbd1   ← halványabb primary
on-primary / on-primary-container #5f1500 / #541200
primary-container               #ff5722   ← tűz/narancs (gradient)
on-primary-fixed-variant        #862200
inverse-primary                 #b02f00

Másodlagos
──────────
secondary / secondary-fixed-dim #ffb3ac
secondary-container             #a40213
tertiary                        #f8b6b2
on-tertiary-container           #461e1d

Kontúrok
────────
outline                         #ab8980   ← erős körvonal
outline-variant                 #5b4039   ← finom körvonal
surface-tint                    #ffb5a0
```

### Gradient tokenek

```css
.gradient-fire   { background: linear-gradient(135deg, #ff5722 0%, #ff8a65 100%); }
.ember-glow      { box-shadow: 0 8px 32px rgba(255,87,34,0.1), 0 2px 8px rgba(0,0,0,0.35); }
.ember-glow-strong { box-shadow: 0 12px 48px rgba(255,87,34,0.2), 0 4px 16px rgba(0,0,0,0.5); }
.inner-rim       { box-shadow: inset 1px 1px 0 rgba(255,255,255,0.05), inset -1px -1px 0 rgba(0,0,0,0.15); }
```

### Kontraszt megfelelőség (WCAG AA)
| Pár | Arány | Státusz |
|-----|-------|---------|
| `on-surface` (#e5e2e1) on `surface` (#131313) | ~12:1 | ✅ AAA |
| `primary` (#ffb5a0) on `surface` (#131313) | ~7.5:1 | ✅ AAA |
| `on-surface-variant` (#c9a99f) on `surface-container-low` (#1c1b1b) | ~5.2:1 | ✅ AA |
| `on-primary-container` (#541200) on `gradient-fire` (#ff5722) | ~4.8:1 | ✅ AA |

---

## 3. Tipográfia

### Betűkészletek

| Szerepkör | Font | Használat |
|-----------|------|-----------|
| **Display / Heading** | Literata (serif, ital) | Terméknevek, hero cím, section fejlécek |
| **Body / UI** | Work Sans (sans-serif) | Törzsszöveg, gombok, navigáció, formok |

**Google Fonts betöltés:**
```html
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Literata:ital,wght@0,400;0,700;0,800;1,400&family=Work+Sans:wght@400;500;700&display=swap" rel="stylesheet"/>
```

### Tipográfiai skála

| Token | Méret | Line-height | Letter-spacing | Font-weight | Font |
|-------|-------|-------------|----------------|-------------|------|
| `display-lg` | 62px | 1.08 | -0.02em | 800 | Literata |
| `display-lg-mobile` | 36px | 1.15 | — | 800 | Literata |
| `headline-xl` | 46px | 1.2 | — | 700 | Literata |
| `headline-lg` | 28px | 1.3 | — | 700 | Literata |
| `body-lg` | 17px | 1.65 | — | 400 | Work Sans |
| `body-md` | 15px | 1.65 | — | 400 | Work Sans |
| `label-caps` | 11px | 1 | 0.12em | 700 | Work Sans (uppercase) |

**Szabályok:**
- Minimum body szöveg: 15px (mobilon ne menj 14px alá)
- `text-balance` kötelező minden `headline-xl` és `headline-lg` elemen
- `tabular-nums` minden ár és szám megjelenítésnél
- Italic Literata dekoratív kiemelésekhez (pl. testimonial idézetek)

---

## 4. Spacing & Layout

### Spacing tokenek

| Token | Érték | Használat |
|-------|-------|-----------|
| `unit` | 8px | Alap rács egység |
| `gutter` | 24px | Belső oldalpadding |
| `margin-mobile` | 20px | Mobilon oldalsó margó |
| `margin-desktop` | 64px | Desktopon oldalsó margó |
| `container-max` | 1280px | Max szélesség |

**Spacing rendszer:** 4px / 8px / 12px / 16px / 20px / 24px / 32px / 48px / 64px / 96px

### Breakpointok

| Breakpoint | px | Tailwind prefix |
|------------|----|----|
| Mobile | < 768px | (alap) |
| Tablet | 768px | `md:` |
| Desktop | 1024px | `lg:` |
| Wide | 1280px | `xl:` |

### Border-radius skála

| Token | Érték |
|-------|-------|
| DEFAULT | 4px |
| `lg` | 8px |
| `xl` | 12px |
| `2xl` | 16px |
| `full` | 9999px |

### Z-index rétegek

| Réteg | Érték | Elem |
|-------|-------|------|
| Alap | 0 | Normál tartalom |
| Kártya | 10 | Product card hover |
| Sticky nav | 50 | Site header |
| Cart bar | 60 | Sticky kosár sáv |
| Cart drawer | 70 | Kosár drawer overlay |
| Modal | 80 | Dialógok |

---

## 5. Komponens Tokenek

### Gombok

**Primary CTA (gradient-fire):**
```html
class="btn-press px-8 py-3 rounded-full gradient-fire text-on-primary-container
       font-label-caps text-label-caps uppercase tracking-widest
       hover:brightness-110 hover:shadow-[0_0_24px_rgba(255,87,34,0.38)]"
style="transition: transform 160ms cubic-bezier(0.23,1,0.32,1),
                   box-shadow 160ms cubic-bezier(0.23,1,0.32,1),
                   filter 160ms ease;"
```

**Secondary (outline):**
```html
class="btn-press px-6 py-2.5 rounded-full border border-outline-variant/30
       text-on-surface-variant hover:border-primary/35 hover:text-primary"
style="transition: color 140ms ease, border-color 140ms ease, transform 160ms ..."
```

**Press feedback:** `:active { transform: scale(0.97); }` — minden interaktív elemen kötelező

**Minimum érintési terület:** 44×44px (iOS standard), minden gomb teljesíti ezt

### Kártyák

```html
class="product-card bg-surface-container-low rounded-2xl p-6 inner-rim ember-glow
       relative overflow-hidden"
```
- `content-visibility: auto; contain-intrinsic-size: 0 380px;` — teljesítmény
- Hover: `translateY(-6px)` + erősebb `ember-glow-strong` — csak `hover:hover` és `pointer:fine` esetén

### Form mezők

```css
.field {
  background: #1c1b1b;
  border: 1px solid rgba(91,64,57,0.4);   /* outline-variant/40 */
  border-radius: 0.75rem;
  color: #e5e2e1;
  padding: 12px 16px;
  font-family: 'Work Sans', sans-serif;
  font-size: 15px;
}
.field:focus {
  border-color: rgba(255,181,160,0.5);    /* primary/50 */
  box-shadow: 0 0 0 3px rgba(255,181,160,0.08);
}
```
- Minden `<input>` kap: `autocomplete`, helyes `type`, `spellcheck="false"` (email)
- Mobilon: `inputmode="numeric"` (irányítószám), `inputmode="tel"` (telefon)
- Label: `font-label-caps`, uppercase, `color: rgba(201,169,159,0.7)`
- Focus: `focus-visible:` (nem `focus:`) — csak billentyűzethasználóknál látható gyűrű

### Navigáció

- Sticky header: `z-50`, `transition: box-shadow 0.25s` görgetéskor
- Hamburger: `aria-expanded` állapot kezelés, `aria-label="Menü megnyitása"`
- Smooth scroll anchoroknál: `scrollTo({ behavior: 'smooth' })`, offset: 72px (header magasság)
- Mobilon: `#mobile-menu` slide-down, `opacity + translateY` animáció

---

## 6. Animáció Tokenek

### Easing tokenek

```css
:root {
  --ease-out:    cubic-bezier(0.23, 1, 0.32, 1);   /* belépő elemek */
  --ease-drawer: cubic-bezier(0.32, 0.72, 0, 1);   /* drawer/sheet */
}
```

### Időzítések

| Használat | Időtartam | Easing |
|-----------|-----------|--------|
| Micro-interaction (gomb press) | 160ms | ease-out |
| Hover state | 140–200ms | ease |
| Fade-up reveal | 550ms | ease-out |
| Drawer nyitás | 350ms | ease-drawer |
| Hero fire line grow | 900ms | cubic-bezier(0.22,1,0.36,1) |
| Heat bar töltés | 900ms | ease-out |
| Ember pulse | 4s | ease-in-out, infinite |

### Animált tulajdonságok — CSAK ezek:
- `transform` (translate, scale, rotate)
- `opacity`
- `box-shadow`
- `border-color`
- `color`
- `filter` (brightness)
- `width` csak heat-baron (belső CSS, nem layout-shift)

**TILOS:** `transition: all`, `width/height` layout elemeken, `top/left/right/bottom`

### prefers-reduced-motion

```css
@media (prefers-reduced-motion: reduce) {
  .fade-up { transition: opacity 0.3s ease !important; transform: none !important; }
  .hero-line { transition: opacity 0.3s ease !important; transform: none !important; }
  .product-card { transition: box-shadow 0.2s ease !important; }
  .heat-bar { transition: width 0.5s ease !important; }
}
```
Minden új animáció kapjon `prefers-reduced-motion` fallbacket.

---

## 7. Képek & Médiakezelés

- Hero kép: `fetchpriority="high"`, explicit `width` + `height` (CLS megelőzés)
- Termékképek: `loading="lazy"`, WebP/AVIF preferált
- Hero mobilon: `<picture>` + `<source media="(max-width: 767px)">` srcset
- Dekoratív képek: `alt=""` + `role="presentation"`
- Termékképek JS-ből generálva: `alt="` + p.name + `"` — mindig kitöltött

---

## 8. Accessibility Alapkövetelmények

- `<html lang="hu">` — kötelező
- `color-scheme: dark` a CSS `:root`-on
- `<meta name="theme-color" content="#131313">` — Android Chrome chrome szín
- Ikon gombok: `aria-label` kötelező
- Dialógok: `role="dialog"`, `aria-labelledby`, `aria-modal="true"`
- Async tartalom frissítések: `aria-live="polite"`
- `focus-visible:` minden interaktív elemen (ne `focus:`)
- Fejléc hierarchia: h1 → h2 → h3, ne ugorjon szintet

---

## 9. SEO & Social Meta

Minden oldalon kötelező:
```html
<meta name="description" content="..."/>
<meta property="og:title" content="..."/>
<meta property="og:description" content="..."/>
<meta property="og:image" content="chilik.webp"/>
<meta property="og:type" content="website"/>
```

---

## 10. Oldalak & Override fájlok

| Oldal | Fájl | Override |
|-------|------|---------|
| Főoldal | `index.html` | `design-system/pages/index.md` |
| Webshop (új) | `webshop.html` | `design-system/pages/webshop.md` |
| Shop (régi) | `shop.html` | (azonos mint webshop) |

---

## 11. Fejlesztési Elvek

1. **Token-first:** soha ne írj nyers hex-et a HTML-be — mindig Tailwind tokent használj
2. **Mobile-first:** alap osztályok mobilra, `md:` prefix desktopon
3. **Hover guard:** minden hover effekt `@media (hover: hover) and (pointer: fine)` mögé
4. **JS-ből generált HTML:** ugyanazok a CSS osztályok, mint a statikus HTML-ben
5. **localStorage:** mindig egyszer olvasod egy műveleten belül, soha nem cikluson belül
6. **IntersectionObserver:** shared observer per típus, nem per elem
7. **Intl.NumberFormat:** cachedelt `_nf` példány, ne `toLocaleString` minden hívásban
