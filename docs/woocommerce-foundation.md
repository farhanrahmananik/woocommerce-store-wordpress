# WooCommerce Foundation

## Scope Status

- Scope 1: Environment Setup — completed
- Scope 2: Project Initialization — completed
- Scope 3: Store Requirements & Architecture — completed
- Scope 4: Theme & Design System — completed
- Scope 5: WooCommerce Foundation — completed

## Scope Purpose

This document records the WooCommerce foundation baseline for the DeskNest store: what was installed and configured, the exact settings verified after configuration, and what was intentionally left unconfigured for later scopes.

This scope covers installation, Germany/EUR foundation settings, and a read-only validation audit only. It does not cover products, categories, attributes, taxes, payments, shipping, cart/checkout/account customization, or a custom storefront theme. DeskNest remains a foundation-only build at the end of this scope — it is not a functioning storefront yet.

## Installation Summary

- WooCommerce was installed and activated on the existing LocalWP WordPress site.
- Default WooCommerce pages (Shop, Cart, Checkout, My account, Refund and Returns Policy) were created by WooCommerce's own setup process.
- Germany/EUR foundation settings (default country, currency, currency formatting, weight/dimension units, and selling countries) were configured and corrected to a Germany-only baseline.
- No fake or placeholder business address was added to the store settings.
- No products, categories, attributes, taxes, payment gateways, or shipping zones were created.
- No custom theme was created or activated as part of this scope.

## Verified Environment

| Item | Value |
| --- | --- |
| WordPress root | `E:\wordpress-projects\woocommerce-store-wordpress\app\public` |
| LocalWP site | `http://woocommerce-store-wordpress.local` |
| WordPress version | 7.0 |
| Active theme | Twenty Twenty-Five (unchanged) |
| WP-CLI access | LocalWP-bundled PHP 8.2.29 and WP-CLI phar (no global `wp`/`php` on PATH) |

## WooCommerce Plugin

| Item | Value |
| --- | --- |
| Plugin status | Active |
| Version | 10.9.3 |

## Germany/EUR Foundation Settings

Verified via read-only `wp eval` checks against live `wp_options` values:

| Option | Value | Type |
| --- | --- | --- |
| `woocommerce_default_country` | `DE` | string |
| `woocommerce_currency` | `EUR` | string |
| `woocommerce_currency_pos` | `right_space` | string |
| `woocommerce_price_thousand_sep` | `.` | string |
| `woocommerce_price_decimal_sep` | `,` | string |
| `woocommerce_price_num_decimals` | `2` | string |
| `woocommerce_weight_unit` | `kg` | string |
| `woocommerce_dimension_unit` | `cm` | string |
| `woocommerce_allowed_countries` | `specific` | string |
| `woocommerce_specific_allowed_countries` | `array('DE')` | array, 1 entry, DE only |

`woocommerce_specific_allowed_countries` was initially stored as an empty string after the WooCommerce setup step, which left selling countries incomplete. This was corrected to a proper PHP array containing only `DE`, using `wp eval` with a PHP array literal rather than a JSON option update, to avoid a shell/JSON quoting failure encountered with the JSON approach.

Store address fields (`woocommerce_store_address`, `woocommerce_store_address_2`, `woocommerce_store_city`, `woocommerce_store_postcode`) remain empty. No placeholder business address was introduced.

## WooCommerce Default Pages and Mappings

| Page | ID | Slug | Status | URL |
| --- | --- | --- | --- | --- |
| Shop | 7 | `shop` | publish | `/shop/` |
| Cart | 8 | `cart` | publish | `/cart/` |
| Checkout | 9 | `checkout` | publish | `/checkout/` |
| My account | 10 | `my-account` | publish | `/my-account/` |
| Refund and Returns Policy | 11 | `refund_returns` | draft | not publicly linked yet |

Page mappings were created by WooCommerce's own installation process and were only inspected, not edited, as part of this scope.

## Catalog Baseline State

| Item | Count |
| --- | --- |
| Products | 0 |
| Product variations | 0 |
| Global attributes | 0 |
| Product tags | 0 |
| Product categories | 1 — only WooCommerce's default "Uncategorized" category |

## Explicitly Unchanged / Deferred Areas

The following areas were intentionally left untouched in this scope and are deferred to later scopes:

- **Products** — none created.
- **Product categories beyond default** — only WooCommerce's built-in "Uncategorized" category exists.
- **Attributes / variations** — no global attributes, no variations.
- **Inventory thresholds** — not configured during this scope. (Update: Scope 8 later kept the global low-stock threshold at 2 and no-stock threshold at 0, unchanged from WooCommerce's defaults, and applied per-product/variation quantity tracking on top - see [Inventory & Stock Management](inventory-stock-management.md).)
- **Taxes** — `woocommerce_calc_taxes = no`, `woocommerce_prices_include_tax = no`, `woocommerce_tax_based_on = shipping` (WooCommerce defaults, unchanged).
- **Payments** — `bacs`, `cheque`, and `cod` gateways are present but all `enabled = no`. No gateway configured or enabled.
- **Shipping** — no shipping zones or methods configured (0 zones).
- **Cart customization** — default WooCommerce cart page and behavior only.
- **Checkout customization** — default WooCommerce checkout page and behavior only.
- **Accounts customization** — default WooCommerce My Account page and behavior only.
- **Custom theme / storefront UI** — active theme remains Twenty Twenty-Five; no DeskNest theme folder created or activated.

## Validation Summary

A read-only validation pass was run after configuration, with no database, plugin, page, or theme changes made during validation.

**Frontend URLs checked** (LocalWP site running):

| URL | HTTP Status |
| --- | --- |
| `/` | 200 |
| `/shop/` | 200 |
| `/cart/` | 200 |
| `/checkout/` | 302 → redirects to `/cart/` |
| `/my-account/` | 200 |

The `/checkout/` redirect to `/cart/` is expected WooCommerce behavior when the cart is empty, which it is because zero products exist. This is not a defect.

**WooCommerce database tables**: confirmed present via `wp db tables`, including `wp_woocommerce_*` and `wp_wc_*` core tables (orders, order items, tax rates, shipping zones, sessions, lookup tables, webhooks, and related tables).

**Git status**: the working tree was clean before this documentation step, with no pending or uncommitted changes.

## Non-Blocking Notes

- The LocalWP-bundled PHP CLI emits a startup warning (`Unable to load dynamic library 'php_imagick.dll'`) when running WP-CLI commands. This is a missing optional PHP extension in the CLI binary and does not affect WooCommerce, the site, or any of the checks performed in this scope.
- `woocommerce_terms_page_id` is not assigned (no Terms & Conditions page exists yet). This is normal at this stage and outside this scope's boundary.
- The Refund and Returns Policy page (ID 11) remains in `draft` status, as created by WooCommerce's own installation process. It has not been published or edited.

## Next Scope Boundary

This scope ends with a validated, documented WooCommerce foundation baseline only. No storefront, catalog, tax, payment, or shipping functionality exists yet.

Scope 6: Product Catalog will begin in a new chat. Product, category, attribute, and variation work is explicitly out of scope here and was not started as part of this document.
