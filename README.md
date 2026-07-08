# WooCommerce Store – WordPress

A portfolio-ready WooCommerce store project being built step by step with WordPress, WooCommerce, PHP, MySQL, HTML, CSS, JavaScript, Git, and GitHub.

## Current Status

- Scope 1: Environment Setup — completed
- Scope 2: Project Initialization — completed
- Scope 3: Store Requirements & Architecture — completed
- Scope 4: Theme & Design System — completed
- Scope 5: WooCommerce Foundation — completed
- Scope 6: Product Catalog — completed
- Scope 7: Product Attributes & Variations — completed
- Scope 8: Inventory & Stock Management — completed
- Scope 9: Storefront Experience — completed
- Scope 10: Cart — completed
- Scope 11: Checkout — completed
- Scope 12: Customer Accounts — completed
- Scope 13: Order Management — completed
- Scope 14: Coupons & Promotions — completed
- Scope 15: Product Reviews — completed
- Scope 16: Payment Configuration — completed
- Scope 17: Shipping Configuration — completed
- Scope 18: Reports & Analytics — completed
- Scope 19: Security & Hardening — completed
- Scope 20: Performance Optimization — completed

The project blueprint is documented in [Store Requirements & Architecture](docs/store-requirements-architecture.md). The locked concept is **DeskNest** — a Germany-first desk-setup and workspace accessories WooCommerce store concept.

The DeskNest theme and design-system blueprint is documented in [Theme & Design System](docs/theme-design-system.md). The selected direction is a custom DeskNest block-theme architecture using `theme.json`, native templates, reusable patterns, centralized design tokens, and minimal JavaScript.

The WooCommerce foundation baseline — installation, Germany/EUR settings, default pages, and validation — is documented in [WooCommerce Foundation](docs/woocommerce-foundation.md). Taxes, payments, shipping, and custom storefront UI remain unconfigured.

The implemented DeskNest catalog is documented in [Product Catalog](docs/product-catalog.md). It contains 6 DeskNest product categories and 24 published products.

Global product attributes and product variations are documented in [Product Attributes & Variations](docs/product-attributes-variations.md). Three global attributes (Color, Finish, Size) and 11 variations across 5 previously simple products are implemented on the local development site; product images and storefront visual polish remain unimplemented.

Inventory and stock management are documented in [Inventory & Stock Management](docs/inventory-stock-management.md). All 19 simple products and 11 variations have quantity tracking enabled with realistic stock levels, the 5 variable parent products remain parent-level untracked by WooCommerce design, backorders are disabled everywhere, and two items are intentionally out of stock for testing.

The storefront experience foundation is documented in [Storefront Experience](docs/storefront-experience.md). The custom `desknest` block theme is now active, a static DeskNest homepage (linking all 6 real product categories) has replaced the default blog feed, and WooCommerce browsing (Shop, category archives, simple and variable product pages) is verified working.

The cart experience is documented in [Cart](docs/cart.md). WooCommerce's modern Cart block workflow (add to cart, quantity updates, item removal, empty/filled states) is validated for both simple and variable products, and header/footer navigation now includes a Cart link with cart-specific styling. Customer accounts, payments, shipping, coupons/promotions, and reviews remain unimplemented.

The checkout experience is documented in [Checkout](docs/checkout.md). WooCommerce's modern Checkout block is validated for both the empty-cart redirect and filled-cart rendering, a pre-existing gap where the theme's own stylesheet was never enqueued on the frontend was found and fixed, and checkout now has theme-level CSS support (step/card styling, order summary styling, and a responsive mobile form refinement so billing fields stack cleanly on small screens) consistent with the rest of the storefront. No payment gateway is configured, so checkout cannot currently be completed, and no order has been placed; this is intentional and documented, not a defect.

The customer account experience is documented in [Customer Accounts](docs/customer-accounts.md). WooCommerce's classic My Account page (registration, login, dashboard, Orders, Downloads, Addresses, and Account details) is enabled and validated end-to-end using a local test customer, header navigation now includes an Account link, and the account pages have theme-level CSS support consistent with Cart/Checkout, including a mobile Account Details alignment fix found and resolved during visual review. No screenshots are committed to the repository.

Order management is documented in [Order Management](docs/order-management.md). Order management is validated locally: one local development order (created programmatically, not through real checkout, since payment configuration and shipping configuration were not yet implemented at the time - both were completed later, in Scopes 16 and 17 respectively) exists in the local development database only - it is not committed seed data and will not exist on a fresh clone of this repository. Admin order-management behavior (order detail, status changes, order notes) and the customer-facing My Account Orders/order-detail workflow were both validated against this order using WooCommerce's own APIs and template logic. Browser visual validation was not performed, and customer order-table/order-detail CSS has not been specifically styled yet; both remain future work.

Coupons and promotions are documented in [Coupons & Promotions](docs/coupons-promotions.md). Four realistic DeskNest coupons (a welcome discount, a category-scoped seasonal promotion, a bundle cross-sell incentive, and an intentionally expired promo code) were created and validated locally against both the WooCommerce cart and the Checkout block's own Store API - no order was created, the local order count remained at 1 throughout, and no product stock changed. Usage-limit exhaustion was not tested, since that requires an order and was intentionally left out of this scope; individual-use is configured and verified in coupon metadata, but a clean stacking-prevention UX scenario was not isolated. No real payment or shipping validation occurred.

Product reviews are documented in [Product Reviews](docs/product-reviews.md). Seven local-safe reviews were seeded across seven products, including two genuinely verified-owner reviews tied to the products actually present in local order #49, with no fabricated verified status anywhere else. Review UI styling (rating summary, review cards, verified badge, empty state, and the review form) was added to the theme stylesheet. HTTP/markup validation was performed directly against the local site, and a manual visual review was performed separately using screenshots of the live desktop and mobile Reviews tab for two products, plus the mobile empty-review state for a third; a desktop screenshot of that third product's empty state was not captured. No screenshots are committed to the repository.

Payment configuration is documented in [Payment Configuration](docs/payment-configuration.md). WooCommerce core `bacs` (Direct bank transfer) is enabled as a single, clearly local-development-only payment method titled "Banküberweisung (lokale Entwicklung)", with no bank account details, API keys, secrets, or tokens configured, while `cheque` and `cod` remain disabled and no third-party payment processor is installed. The Checkout block's own rendered payment data was confirmed to expose only this one method. No order was placed during validation; local order #49 remains unchanged and its historical `local_dev` label is not a registered gateway. Full end-to-end checkout/order placement using this payment method together with the shipping configuration below has not yet been tested.

Shipping configuration is documented in [Shipping Configuration](docs/shipping-configuration.md). A single Germany-only shipping zone (`Deutschland`, location `DE`) is configured with a flat-rate method ("Standardversand Deutschland", €4.90) and a free-shipping method above €75 ("Kostenloser Versand ab 75 €"); the shipping destination option now calculates against the shipping address rather than billing. No real carrier integration, shipping labels, or fulfilment exist anywhere - this is a local-development-safe configuration only. Validation confirmed correct zone matching, correct flat-rate behavior below €75, and correct free-shipping-eligibility logic at/above €75 (checked via WooCommerce's own method settings rather than a persisted live cart, to avoid unnecessary session side effects); no order was placed and no checkout was submitted.

Reports and analytics are documented in [Reports & Analytics](docs/reports-analytics.md). WooCommerce's native Analytics suite and legacy Reports fallback were confirmed available and validated read-only against the store's real (intentionally sparse) local data: 1 order (#49, €31.80), 2 units sold across 2 products, 1 out-of-stock product, 4 coupons with zero usage, 1 customer, and no tax or download activity - all cross-checked directly against WooCommerce's own analytics lookup tables and order/product/coupon APIs. No external analytics or tracking service was added, no data was fabricated to make dashboards look richer, and no admin screens were claimed to have been visually reviewed.

Security and hardening are documented in [Security & Hardening](docs/security-hardening.md). A read-only baseline review found no exposed secrets, dumps, or debug logs, and exactly one administrator account; two small, safe hardening constants (`DISALLOW_FILE_EDIT` and an explicit `WP_DEBUG_DISPLAY = false`) were added to the local `wp-config.php`, verified with a PHP syntax check and a full WooCommerce regression pass with zero side effects. Broader changes (`DISALLOW_FILE_MODS`, forced SSL admin, a custom table prefix, a security plugin) were deliberately left unapplied and documented with reasoning, since this remains a local-development-only project with no production deployment, no WAF/CDN/rate limiting, and no real SSL.

Performance optimization is documented in [Performance Optimization](docs/performance-optimization.md). A read-only LocalWP performance baseline and full asset dependency map found that the `desknest` theme itself is not the bottleneck - it contributes one small (~23.5KB), correctly-scoped CSS file and zero custom JavaScript - while nearly all measured frontend weight is WordPress/WooCommerce core assets that are already conditionally loaded per page type and required for the Cart, Checkout, product gallery/variation, and My Account workflows validated in earlier scopes. No code-level performance changes, caching plugins, CDN, or image optimization were implemented, since the evidence showed no safe, worthwhile theme-side optimization to make; local HTTP timings were measured and recorded but are explicitly not presented as production benchmarks.

Scopes 3 and 4 cover documentation and planning only. Scope 5 established the WooCommerce foundation, Scope 6 implemented the category and simple-product catalog, Scope 7 implemented global attributes and variations for 5 of those products, Scope 8 applied an inventory/stock-management policy across the catalog, Scope 9 activated the custom `desknest` theme and a static storefront homepage, Scope 10 validated and styled the WooCommerce cart workflow, Scope 11 validated and styled the WooCommerce checkout workflow (including the theme stylesheet enqueue fix), Scope 12 enabled and styled the WooCommerce customer account experience, Scope 13 validated the order-management workflow against one local development order, Scope 14 created and validated four local coupons against cart and checkout, Scope 15 seeded and styled a local-safe product review dataset, Scope 16 enabled one local-safe payment method, Scope 17 configured one local-safe Germany shipping zone, Scope 18 validated WooCommerce's native reporting against the store's real local data, Scope 19 applied minimal local-safe hardening, and Scope 20 measured and documented the local performance baseline, on the local development environment; no production deployment, GitHub Pages, or LinkedIn preview presentation exists yet.

## Verified Local Environment

| Item | Value |
| --- | --- |
| Operating system | Windows 11 |
| Local environment | LocalWP |
| Site name | `woocommerce-store-wordpress` |
| Local domain | `woocommerce-store-wordpress.local` |
| Project directory | `E:\wordpress-projects\woocommerce-store-wordpress` |
| Web server | nginx |
| PHP | 8.2.29 |
| MySQL | 8.4.0 |
| WordPress | 7.0 |
| Multisite | No |

## Repository Notes

WordPress core, `wp-config.php`, uploads, logs, LocalWP runtime files, and generated files are intentionally ignored. Custom theme and plugin folders will be explicitly tracked later, only when their respective development scopes begin.

The Git repository is initialized on `main`, the baseline files are committed, the GitHub remote is connected, and `main` has been pushed to `origin/main`.

## Scope Boundaries

This repository currently documents the initialized LocalWP WordPress project, the theme and design-system blueprint, the WooCommerce foundation baseline, the implemented product catalog, the implemented global attributes and variations for 5 products, the applied inventory/stock-management policy, the activated `desknest` storefront theme with a static homepage, the validated/styled WooCommerce cart, checkout, and customer account workflows, the validated order-management workflow (against one local development order), the validated coupons/promotions workflow (four local coupons against cart and checkout), the seeded/styled product reviews workflow, one local-development-safe payment method (`bacs`), one local-development-safe Germany shipping zone (flat rate + free shipping above €75), a read-only validation of WooCommerce's native Reports & Analytics against the store's real local data, a minimal local-safe security hardening pass, and a read-only LocalWP performance baseline/asset-dependency review. Final UI polish and portfolio presentation (including any GitHub Pages or LinkedIn preview) will be handled in later scopes.

## Local Setup

1. Open the site through LocalWP.
2. Start the LocalWP site before opening `woocommerce-store-wordpress.local`.
3. Do not commit real secrets or `wp-config.php`.

## Current Limitations

- 5 of the 24 products are variable products with global attributes and variations; the remaining 19 are simple products. No product images have been added.
- Inventory quantities and stock status are applied at the database level; the active `desknest` storefront now renders Shop, category, and product pages, and the WooCommerce cart and checkout workflows with this inventory have been validated for simple and variable products.
- Taxes have not started. Payment and shipping configuration are both complete but local-development-safe only (see below).
- Checkout is styled and validated, and one local-safe payment method (`bacs`) plus one local-safe Germany shipping zone are now enabled, but no order has been placed through checkout end-to-end. No Terms & Conditions page has been assigned yet.
- Customer accounts are enabled and validated (registration, login, dashboard, Orders/Downloads/Addresses/Account details) using one local test customer.
- Order management is validated locally against one programmatically-created development order (order #49, local database only, not committed seed data): admin order detail/status-change/notes behavior and the customer My Account Orders/order-detail workflow were both confirmed via WooCommerce's APIs and template logic. Browser visual validation was not performed, and no CSS specific to the orders table/order-detail page has been added yet. Payment methods on file and account-related email delivery (beyond local Mailpit capture) have not been verified.
- Four coupons are created and validated locally against both the cart and the Checkout block's Store API (fixed/percentage discounts, category/product restrictions, minimum/maximum spend, expiry). Usage-limit exhaustion was not tested (it requires an order, which was intentionally not created for this scope), and individual-use is configured/verified but its stacking-prevention UX was not cleanly isolated. No real payment or shipping validation occurred.
- Seven local-safe product reviews are seeded across seven products, with a verified-owner badge appearing only on the two reviews tied to local order #49; no verified status is fabricated elsewhere. Review UI styling was validated both at the HTTP/markup level and through manual review of user-provided screenshots (desktop and mobile Reviews tab for two products, mobile-only for the empty-state product); no screenshots are committed to the repository, and this does not constitute a full QA/final-polish sign-off.
- Only WooCommerce core `bacs` (Direct bank transfer) is enabled as a payment method, configured as clearly local-development-only ("Banküberweisung (lokale Entwicklung)"); `cheque` and `cod` remain disabled, and no real payment processor, bank account details, API keys, or credentials are configured anywhere. No order was placed to validate this.
- One Germany-only shipping zone (`Deutschland`) is configured with a flat-rate method (€4.90) and a free-shipping method above €75; no real carrier integration, shipping labels, credentials, or fulfilment exist anywhere, and no shipping classes have been configured. No order was placed to validate this, and full end-to-end checkout/order placement (cart → shipping → payment → order) remains untested.
- Reports & Analytics validation is local-development-only and uses WooCommerce's native Analytics/Reports functionality exclusively - no external analytics or tracking service exists anywhere in this project. The underlying dataset is intentionally sparse (1 order, €31.80 total revenue, 4 unused coupons, no tax or download activity), which is expected for a local portfolio project and was not padded out with fabricated orders or usage. Validation was performed read-only via WP-CLI/database checks against WooCommerce's own analytics lookup tables; the admin Analytics screens themselves were not visually reviewed.
- Security hardening is local-development-safe only and does not claim production-grade protection: `DISALLOW_FILE_EDIT` and an explicit `WP_DEBUG_DISPLAY = false` were added to `wp-config.php` (verified via PHP syntax check and a full WooCommerce regression pass with no side effects), while `DISALLOW_FILE_MODS`, forced SSL admin, a custom table prefix, and any security plugin were deliberately left unapplied and documented with reasoning. No WAF, CDN, rate limiting, malware scanning, or real SSL/server hardening exists anywhere in this project.
- Performance work documented a LocalWP baseline and a full frontend asset-loading review only; no code-level performance changes were made, because the `desknest` theme is already lightweight (one small scoped CSS file, zero custom JS) and the measured frontend weight is almost entirely required WordPress/WooCommerce core assets. No caching plugin, CDN, image optimization, or minification pipeline was added, and no production caching/CDN/Lighthouse/Core Web Vitals claims are made - all recorded timings are LocalWP development-machine measurements only.
- The custom DeskNest theme is now active with a basic homepage and visual foundation, and the theme's own stylesheet is now correctly enqueued on the frontend (a pre-existing gap fixed during Scope 11), but no final visual polish, product images, or portfolio-presentation work has been done.
- No production deployment exists yet.
