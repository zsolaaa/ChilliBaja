# Chili Baja – Főoldal (index.html) Override

> Örökli: `design-system/MASTER.md`
> Csak az eltérések vannak itt dokumentálva.

---

## Oldal típus
Marketing landing page — cél: brand megismertetés + termékbemutatás + hírlevél feliratkozás

## Oldal-specifikus szekciók

| Szekcióazonosító | Tartalom | Megjegyzés |
|------------------|----------|------------|
| Hero | Teljes viewport, parallax kép | `fetchpriority="high"`, `@starting-style` entry |
| `#kollekcio` | 3 kiemelt termék | Stagger animáció, `ember-glow` |
| `#tortenetunk` | Brand story | Teljes szélességű, `surface-container-lowest` háttér |
| `#velemenyek` | 3 testimonial | `testimonial-featured` stílus a középsőn |
| `#helyszinek` | Piac + üzlet + pickup + szállítás | Google Maps iframe embed |
| Hírlevél | Email form | `aria-live` visszajelzés, `handleNewsletter()` validáció |

## Hero specifikus

- Képméret: 1920×1080 (desktop), mobil verzió: `mobil.png`
- Spark partikle animáció: 6 db `.spark` elem, CSS `spark-rise` keyframe
- Tűz underline: `#hero-fire-line`, `fire-line-grow` animáció, 0.55s delay
- Badge shimmer: `#hero-badge`, `shimmer` 3.5s linear infinite
- Parallax: scroll listener → `heroImg.style.transform` (rAF-throttled, passive)
- Scroll caret: `#scroll-caret`, `caret-bounce`, elhalvánul 90px scroll után

## Sticky kosár sáv

- `#cart-bar`: `translateY(100%)` → `translateY(0)` első item hozzáadásakor
- `role="region"`, `aria-label="Kosár"`, `aria-live="polite"`
- `ease-drawer` görbe, 350ms

## Hírlevél form

- Input: `id="newsletter-email"`, `autocomplete="email"`, `spellcheck="false"`
- Label: `<label for="newsletter-email" class="sr-only">`
- Visszajelzés: `#newsletter-msg`, `role="status"`, `aria-live="polite"`
- Validáció: `handleNewsletter(e)` — üres/invalid → piros hibaüzenet, valid → zöld siker
