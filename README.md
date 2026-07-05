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

The project blueprint is documented in [Store Requirements & Architecture](docs/store-requirements-architecture.md). The locked concept is **DeskNest** — a Germany-first desk-setup and workspace accessories WooCommerce store concept.

The DeskNest theme and design-system blueprint is documented in [Theme & Design System](docs/theme-design-system.md). The selected direction is a custom DeskNest block-theme architecture using `theme.json`, native templates, reusable patterns, centralized design tokens, and minimal JavaScript.

The WooCommerce foundation baseline — installation, Germany/EUR settings, default pages, and validation — is documented in [WooCommerce Foundation](docs/woocommerce-foundation.md). Taxes, payments, shipping, and custom storefront UI remain unconfigured.

The implemented DeskNest catalog is documented in [Product Catalog](docs/product-catalog.md). It contains 6 DeskNest product categories and 24 published products.

Global product attributes and product variations are documented in [Product Attributes & Variations](docs/product-attributes-variations.md). Three global attributes (Color, Finish, Size) and 11 variations across 5 previously simple products are implemented on the local development site; product images, inventory workflows, and storefront visual polish remain unimplemented.

Scopes 3 and 4 cover documentation and planning only. No custom theme folder has been created or activated. Scope 5 established the WooCommerce foundation, Scope 6 implemented the category and simple-product catalog, and Scope 7 implemented global attributes and variations for 5 of those products on the local development environment; later commerce and storefront scopes remain unstarted.

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

This repository currently documents the initialized LocalWP WordPress project, the theme and design-system blueprint, the WooCommerce foundation baseline, the implemented product catalog, and the implemented global attributes and variations for 5 products. Inventory workflows, cart, checkout, customer accounts, payments, shipping, and the custom storefront theme will be handled in later scopes.

## Local Setup

1. Open the site through LocalWP.
2. Start the LocalWP site before opening `woocommerce-store-wordpress.local`.
3. Do not commit real secrets or `wp-config.php`.

## Current Limitations

- 5 of the 24 products are variable products with global attributes and variations; the remaining 19 are simple products. No product images have been added.
- Inventory workflows, taxes, payments, shipping, cart, checkout, and account customization have not started.
- The custom DeskNest theme has been planned but not created or activated.
- No production deployment exists yet.
