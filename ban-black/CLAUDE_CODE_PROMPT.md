# Claude Code Handoff — Ban Black Theme

You are picking up a custom WordPress theme named **Ban Black**. It's a WooCommerce-powered storefront for a specialty coffee brand based in Lebanon. This document is your brief.

---

## What already exists

A scaffolded theme at `wp-content/themes/ban-black/` with:

- Theme bootstrap (`style.css`, `functions.php`, `/inc/`)
- Global chrome: `header.php`, `footer.php`, ticker + marquee template parts
- Page templates: `front-page.php`, `page-about.php`, `page-wholesale.php`
- Journal CPT (`bb_journal`) + its archive + single templates
- WooCommerce template overrides in `/woocommerce/`:
  - `archive-product.php` (shop/category)
  - `single-product.php` + `content-single-product.php` (PDP)
  - `content-product.php` (card in loops)
- ACF field groups (coffee specs, home modules, about, wholesale) registered in PHP + local JSON in `/acf-json/`
- Styled CSS per page type in `/assets/css/`
- Shared JS with reveal-on-scroll and cart pip updates

**Read `README.md` before making changes.**

---

## Design system (DO NOT drift)

- **Palette** — `--bb-ink #0a0a0a`, `--bb-paper #f1ede5`, `--bb-ember #d4573a`, `--bb-brass #a68a5b`
- **Type** — Playfair Display (display, italic for accents), Roboto (body), Roboto Mono (labels/numerals), Noto Naskh Arabic (logo + Arabic accents)
- **Voice** — editorial, slightly irreverent, "black and only black" tone. See the manifesto block on `front-page.php` for reference.
- **Placeholder hatches** — `bb_placeholder()` helper renders a styled placeholder when no image is uploaded. Keep using it; don't generate fake imagery.

---

## Priorities (in order)

1. **Local dev spin-up** — install on Local/LocalWP or a staging site. Activate the theme. Install WooCommerce + ACF Pro. Run the WP installer + Woo setup.
2. **Seed content** — create Home, About, Wholesale pages; assign templates; fill ACF fields. Create product categories (slugs in `README.md §4.3`).
3. **Visual QA** — compare against the original site at `banblack.com`. Every page should render cleanly on desktop + mobile with placeholder content if no images yet.
4. **Connect payment** — Stripe + cash-on-delivery for Lebanon context; enable shipping zones.
5. **Performance** — install OMGF (self-host fonts), WP Rocket (or FlyingPress), and an image optimizer.
6. **Security** — Wordfence or Sucuri, harden `wp-config.php`, set up backups (UpdraftPlus → Google Drive).
7. **Future work** — see `README.md §10`.

---

## Rules of engagement

- **Never** edit WooCommerce core files. Override via our `/woocommerce/` directory or hooks in `/inc/woocommerce.php`.
- **Never** hard-code copy that lives in ACF — if it's content, it goes in a field.
- **Never** break the `bb-` CSS class prefix convention.
- **All new CSS** goes in the matching page file under `/assets/css/`. Don't dump into `shared.css` unless it's truly shared.
- **All new templates** register in `inc/setup.php` (image sizes, menus) not inline.
- **New ACF fields** → edit `inc/acf-fields.php` AND keep `/acf-json/*.json` in sync (ACF will write the JSON for you if you edit via the admin).
- **Enqueue new CSS/JS** in `inc/enqueue.php` with the correct `is_*()` conditional so it only loads where needed.
- Use `bb_field( 'key', $post_id, $fallback )` to read ACF with a safe fallback.
- Use `bb_thumbnail_or_placeholder( $id, $size, $label )` for any image that may be missing.

---

## Unknown: what to clarify before coding

Ask the project owner:

1. Exact product category slugs (my defaults: `whole-bean`, `espresso-machines`, `grinders`, `brewing-equipment`, `accessories`, `merchandise`). Confirm or override.
2. Which form plugin is canonical for the Wholesale inquiry? (Gravity vs Fluent vs hand-rolled WP REST endpoint)
3. Multicurrency requirements — USD only? USD + LBP? USD + EUR for GCC shipping?
4. Shipping: local Lebanon only or international? Carrier? Flat-rate or real-time rates?
5. Arabic site — a separate RTL version now, or phase 2?
6. Subscription coffee — launch with it or later?
7. Do they want the blog (standard WP `post` type) active alongside Journal, or Journal-only?

---

## Definition of done (launch-ready)

- [ ] All pages from `banblack.com` have a matching template or are content-editable via ACF
- [ ] Home page renders with real content + imagery, not placeholders
- [ ] Shop, category pages, and at least 10 products are populated
- [ ] A real journal article demonstrates the editorial layout end-to-end
- [ ] Cart → checkout → order confirmation flow tested with Stripe test keys
- [ ] Wholesale inquiry form routes to the right inbox + sends confirmation
- [ ] Mobile Lighthouse: Performance ≥ 80, Accessibility ≥ 95, SEO ≥ 95
- [ ] Core Web Vitals pass on the 3 top pages (Home, Shop, a PDP)
- [ ] Backup configured
- [ ] Staging + prod environments with a deploy workflow (Git + `wp-cli` or Gitea/Deployer)

---

Good luck. When in doubt: read `README.md`, then read the template-parts, then ask.
