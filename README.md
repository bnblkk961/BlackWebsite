# Ban Black — WordPress Theme

**Custom WooCommerce-powered theme for Ban Black.**
Dark, editorial, typographic. Roboto + Playfair Display + Noto Naskh Arabic.

---

## 1 · What's inside

```
ban-black/
├── style.css               Theme header (required by WP)
├── functions.php           Bootstrap — loads everything in /inc
├── index.php               Fallback
├── 404.php
├── page.php                Generic page
├── header.php · footer.php
│
├── front-page.php          Home
├── page-about.php          Template: About
├── page-wholesale.php      Template: Wholesale
├── archive-bb_journal.php  Journal archive
├── single-bb_journal.php   Single journal article
│
├── template-parts/
│   ├── ticker.php
│   ├── marquee.php
│   ├── product-card.php    Used everywhere products are listed
│   └── journal-card.php
│
├── inc/
│   ├── setup.php           Theme supports, menus, image sizes
│   ├── enqueue.php         CSS/JS per page type
│   ├── helpers.php         bb_placeholder(), bb_field(), etc.
│   ├── woocommerce.php     Woo hooks, card/loop/summary overrides, cart pip
│   ├── acf-fields.php      Registers ACF groups via PHP fallback + JSON sync
│   ├── cpt-journal.php     bb_journal CPT + taxonomy
│   └── shortcodes.php      [bb_ticker] [bb_marquee] [bb_product_grid]
│
├── woocommerce/            Overrides Woo's own templates
│   ├── archive-product.php
│   ├── single-product.php
│   ├── content-single-product.php
│   └── content-product.php
│
├── acf-json/               Local JSON sync directory (ACF reads from here)
│   └── group_bb_coffee_specs.json
│
└── assets/
    ├── css/                Per-page stylesheets (shared + 6 page-specific)
    └── js/shared.js
```

---

## 2 · Install

1. **Copy the `ban-black/` folder** into `wp-content/themes/` on your WordPress install.
2. In WP admin → **Appearance → Themes** → activate **Ban Black**.
3. Install + activate required plugins (see §3).
4. Flush permalinks: **Settings → Permalinks → Save** (forces the `bb_journal` rewrite rules to register).

---

## 3 · Required plugins

| Plugin | Why | Note |
|---|---|---|
| **WooCommerce** | Products, cart, checkout, all commerce | Required |
| **Advanced Custom Fields (ACF Pro)** | Coffee specs, About/Wholesale content, Home modules | Pro required for Repeater |
| **OMGF** *(optional but recommended)* | Self-hosts Google Fonts locally for speed + GDPR | Replace font enqueue in `inc/enqueue.php` with OMGF output |
| **Gravity Forms / Fluent Forms** *(optional)* | Wholesale inquiry form | Put shortcode in the "Form Shortcode" ACF field on the Wholesale page |

---

## 4 · First-time setup (after activation)

### 4.1 — Pages
Create these pages in **Pages → Add New**:

| Page title | Slug | Page template |
|---|---|---|
| Home | `home` | Default (uses `front-page.php` automatically) |
| About | `about` | **About** |
| Wholesale | `wholesale` | **Wholesale** |
| Journal | `journal` | *Not needed* — CPT archive lives at `/journal/` |

Then: **Settings → Reading → Your homepage displays → A static page → Homepage: Home**.

### 4.2 — WooCommerce pages
Run the WooCommerce setup wizard. It creates `/shop/`, `/cart/`, `/checkout/`, `/my-account/`.
If Woo prompts about the theme — click **"I'll do it manually"** / **"Continue"**. We already declare Woo support.

### 4.3 — Product categories
At minimum, create these `product_cat` terms (slugs matter — used in templates):

- `whole-bean` — single-origin & blends
- `espresso-machines`
- `grinders`
- `brewing-equipment`
- `accessories`
- `merchandise`

Add a **Thumbnail** to each category (used in the home page grid).

### 4.4 — Menus (Appearance → Menus)

| Menu location | Typical items |
|---|---|
| Primary (top nav) | Shop · Story (→ About) · Journal · Wholesale |
| Footer · Shop | Whole bean · Machines · Grinders · Accessories |
| Footer · Inside | Story · Journal · Wholesale |
| Footer · Help | Shipping · Returns · Contact · FAQ |

### 4.5 — ACF
ACF will auto-sync the JSON group in `/acf-json/`. If it doesn't:
**Custom Fields → Field Groups → Sync Available** → click Sync.

On each coffee product (Products → Edit) fill in the **Coffee Specs** box:
Origin, Altitude, Process, Roast, Notes, Weight.

On the **Home** page, fill in **Home Modules** (hero title, lede, reserve product, ticker items).
On the **About** page, fill the **Manifesto pillars / Timeline / Team** repeaters.
On the **Wholesale** page, fill **Services / Stats / Partner Cafés**.

---

## 5 · Product template — one template, many categories

There is **one** `content-single-product.php`. It adapts based on the product's category:

- If the product is in `whole-bean` **and** has an "Origin Story" (ACF `bb_story`), an editorial origin section is inserted after the summary.
- Brew specs (`bb_origin`, `bb_altitude`, `bb_process`, `bb_roast`, `bb_notes`, `bb_weight`) render automatically wherever filled.
- For machines/grinders, use WooCommerce's native **Attributes** (Products → Attributes) — they show up in the tabbed "Additional information" panel.

If you need a *visually different* product page per category, create `single-product-{category-slug}.php` in the theme root and WP will pick it up via the `template_hierarchy` filter (add that filter in `inc/woocommerce.php` if/when needed).

---

## 6 · Journal (CPT)

- Post type: `bb_journal` (slug `/journal/`).
- Custom taxonomy: `bb_journal_cat` for grouping articles.
- Per-article ACF: kicker, read time, pull quote.

Admin menu: **Journal → All articles / Add new**.

---

## 7 · Style system

**Tokens live in `assets/css/shared.css`** under `:root`:

```
--bb-ink:    #0a0a0a   (charcoal canvas)
--bb-paper:  #f1ede5   (cream — for "inverted" light sections)
--bb-ember:  #d4573a   (accent — use sparingly)
--bb-brass:  #a68a5b
--ff-sans:   Roboto
--ff-serif:  Playfair Display
--ff-ar:     Noto Naskh Arabic
--ff-mono:   Roboto Mono
```

To rebrand colors: change these variables. Everything cascades.

---

## 8 · Images / placeholders

Any page that references an image uses `bb_thumbnail_or_placeholder()`. If no image is attached, a styled hatched placeholder appears with a label and SKU. Upload real images when ready; no template edits needed.

Recommended aspects:
- Products: **1:1** square (min 1200×1200)
- Category thumbnails: **3:4** portrait
- Journal featured: **16:10** landscape
- Hero: 16:9 wide, 2400px+ long edge

---

## 9 · Performance notes

- Page-specific CSS is loaded only where needed (see `inc/enqueue.php`).
- JS is deferred.
- Use **OMGF** or **FlyingPress / WP Rocket** to self-host Google Fonts.
- Enable a cache plugin and optimize images (WebP via **Smush** or **Imagify**).

---

## 10 · Next steps / stretch goals

- [ ] **Faceted filtering** on Shop — install FacetWP or WOOF and swap the static `.facets` UI in `archive-product.php`.
- [ ] **Subscription coffee** — WooCommerce Subscriptions.
- [ ] **Arabic (RTL)** — duplicate `style.css` as `rtl.css` and adjust flexbox/grid directions.
- [ ] **Blocks** — the theme is classic (not FSE). Easily block-ified by adding `theme.json`.
- [ ] **Multicurrency** — WooCommerce Multi-Currency or Aelia for USD / LBP / EUR.

---

## 11 · Support

File: `CLAUDE_CODE_PROMPT.md` — paste that into Claude Code to let it pick up development.
