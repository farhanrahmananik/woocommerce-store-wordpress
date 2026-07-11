# Storefront Experience

## Scope Status

- Scope 1: Environment Setup - completed
- Scope 2: Project Initialization - completed
- Scope 3: Store Requirements & Architecture - completed
- Scope 4: Theme & Design System - completed
- Scope 5: WooCommerce Foundation - completed
- Scope 6: Product Catalog - completed
- Scope 7: Product Attributes & Variations - completed
- Scope 8: Inventory & Stock Management - completed
- Scope 9: Storefront Experience - completed

## Scope Purpose

This document records the Scope 9 storefront experience foundation for the DeskNest store: activating and building the custom `desknest` block theme, replacing the default blog-feed homepage with a static storefront landing page, and validating that WooCommerce browsing (Shop, category archives, simple and variable product pages) continues to work correctly. This is a **foundation-level** storefront implementation, not a finished, polished, or production-ready storefront.

## Historical Context

This document records the earlier Scope 9 `desknest` storefront foundation. Scope 21 later introduced `desknest-storefront` as the final active theme. Current storefront implementation details are documented in [UI Polish](ui-polish.md).

## Storefront Baseline Before Scope 9

At the start of this scope:

- The active theme was Twenty Twenty-Five; no `desknest` theme folder existed yet.
- The homepage was the default WordPress blog feed (`show_on_front = posts`, `page_on_front = 0`), not a curated storefront landing page.
- WooCommerce's "Coming Soon" / Launch Your Store feature was intercepting store-related pages for anonymous visitors.
- Product, category, attribute, and inventory data already existed and was healthy (from Scopes 6-8), but no product had a featured image.

## Root-Cause Finding: WooCommerce Coming Soon

Early in this scope, the Shop page, category archives, and even individual product pages appeared to return HTTP 200 with a normal page shell but showed **no actual product content** for anonymous visitors. Investigation (read-only, tracing WooCommerce's own `Automattic\WooCommerce\Internal\ComingSoon` source) found the cause was not a broken query, template, or catalog problem:

- `woocommerce_coming_soon = yes` and `woocommerce_store_pages_only = yes` were both set.
- WooCommerce's "Launch Your Store" feature was replacing the body of every page it classifies as a "store page" (Shop, product category/tag archives, and individual product pages) with a Coming Soon placeholder for any visitor who isn't logged in as a shop manager/administrator.
- This was confirmed decisively via the definitive marker WooCommerce injects into `<head>` when this fires (`<meta name="woo-coming-soon-page" content="yes">`), which was present on all affected pages before the fix and absent afterward.

**Fix applied**: `woocommerce_coming_soon` was set to `no` (the only option changed). `woocommerce_store_pages_only` was left at `yes` unchanged, since WooCommerce's own logic short-circuits before ever checking it once `coming_soon` is `no` - confirmed live via `ComingSoonHelper::is_site_live()` returning `true` after the change.

## Theme Architecture

- Custom block theme: **desknest**.
- Path: `app/public/wp-content/themes/desknest`.
- No page builder plugin was introduced; the theme uses native WordPress block templates and `theme.json` only, consistent with the architecture decision already locked in [Theme & Design System](theme-design-system.md).
- **No WooCommerce template overrides exist in this theme** - no `archive-product.html`, `taxonomy-product_cat.html`, `single-product.html`, `cart.html`, `checkout.html`, or account/order templates were created. WooCommerce's own bundled block/classic compatibility templates continue to render the Shop page, category archives, and product pages exactly as they did before `desknest` existed - confirmed by directly comparing rendered output before and after theme activation, with no change in product-content behavior attributable to the theme itself.

## Theme Files Created

| File | Purpose |
| --- | --- |
| `style.css` | Theme header (name, author, version, requirements) |
| `theme.json` | Design tokens (color, typography, spacing, layout) and global/block style foundation |
| `functions.php` | Minimal `after_setup_theme` support declarations only (`title-tag`, `post-thumbnails`, `woocommerce`) - no template overrides, no enqueued assets |
| `parts/header.html` | Site title/brand label + a single Shop navigation link; no cart, account, or checkout elements |
| `parts/footer.html` | Brand name, honest value statement, a Shop link column, and an honest "policies will be added later" placeholder - no fabricated legal/payment/shipping claims |
| `templates/index.html` | Generic fallback template (header + post content + footer) |
| `templates/home.html` | Generic blog-index template (used only if `show_on_front` ever reverts to `posts`) |
| `templates/page.html` | Generic page template |
| `templates/single.html` | Generic single-post template (does not affect WooCommerce single-product resolution, which WooCommerce controls separately) |
| `templates/archive.html` | Generic fallback archive template (dates/author/non-product taxonomies only; does not affect WooCommerce's own product archive resolution) |

## Homepage Implementation

- A new WordPress page, **"Home" (ID 48, slug `home`, status `publish`)**, was created with native block content only.
- Static front page settings: `show_on_front = page`, `page_on_front = 48`. `page_for_posts` was left at `0`, unchanged.
- Homepage sections: a hero (brand/value proposition, Germany-first positioning, primary Shop link, secondary category link), a "Shop by category" section linking all **6 real commercial categories** (Ergonomic Essentials, Desk Organization, Lighting & Ambience, Cable Management, Productivity Accessories, Bundles) - **`Uncategorized` is deliberately excluded**, an "Explore the catalog" section, an honest "Why DeskNest" trust section (curated range, simple product structure, practical categories - no fabricated delivery/payment/warranty/support claims), and a closing call-to-action.
- Built entirely with core blocks (`core/group`, `core/heading`, `core/paragraph`, `core/buttons`, `core/button`, `core/columns`, `core/column`, `core/list`, `core/separator`) - no WooCommerce-specific blocks, no custom HTML/JS.

## Visual Foundation

- `theme.json` design tokens (color palette, typography scale, spacing scale, layout widths) were defined when the theme was scaffolded, sourced directly from [Theme & Design System](theme-design-system.md).
- Global/block styling added: link color and hover state, button color/radius/padding and hover state, heading color and spacing, per-level heading line-heights (H1-H4), paragraph line-height, separator color, navigation typography/spacing, and column gap.
- No external fonts were loaded (a system font stack is used throughout). No custom CSS/JS assets were added - `style.css` contains only the required theme header.
- No WooCommerce-block-specific styles were added. Investigation confirmed the live Shop/category archive renders through WooCommerce's classic compatibility block (`woocommerce/legacy-template`), not the blockified Product Collection blocks, so targeting those blocks in `theme.json` would have had no visible effect - adding them anyway would have been misleading, so they were intentionally omitted rather than added as a fragile, ineffective workaround.

## Validation Summary

The following was confirmed with live command output at each implementation step of this scope:

| Check | Result |
| --- | --- |
| Active theme | `desknest` |
| Homepage (`/`) | HTTP 200 |
| Shop (`/shop/`) | HTTP 200 |
| Category archive (`/product-category/ergonomic-essentials/`) | HTTP 200 |
| Simple product page | HTTP 200 |
| Variable product page | HTTP 200 |
| Shop/category pages show real product names and price markup | Confirmed |
| Simple product shows title, price, and add-to-cart markup | Confirmed |
| Variable product shows title, variation terms (e.g. Black/Silver), and variation-selector markup | Confirmed |
| Coming Soon marker (`woo-coming-soon-page`) | Absent on all pages |
| Fatal/critical error text | Absent on all pages |
| Header brand label and footer content | Present on homepage, Shop, category, and both product page types |

## Scope Boundaries

Scope 9 explicitly did **not** implement: cart, checkout, customer accounts, payments, shipping, product reviews, coupons/promotions, analytics/reporting, security hardening, performance optimization, final visual polish, or portfolio-presentation work (GitHub Pages, LinkedIn preview, etc.). These remain future, separately approved scopes.

## Known Limitations

- Product images remain absent (0 of 24 products have a featured image); Shop/category/product pages display WooCommerce's own placeholder imagery only.
- The homepage's content exists only as a WordPress page record in the local database - it is not exported as a reusable theme template/pattern, so it would not automatically transfer to a different WordPress installation.
- Shop, category archive, and single-product rendering still rely entirely on WooCommerce's own default templates; `desknest` has not authored any WooCommerce-specific template of its own.
- Footer "Store Info" content is an intentional honest placeholder ("Policies and support details will be added as the store develops") - no real legal, support, or policy content exists yet.

## Next Scope

**Scope 10 - Cart.**
