# WooCommerce Store – WordPress

A portfolio-ready WooCommerce store project being built step by step with WordPress, WooCommerce, PHP, MySQL, HTML, CSS, JavaScript, Git, and GitHub.

## Current Status

- Scope 1: Environment Setup — completed
- Scope 2: Project Initialization — completed
- Scope 3: Store Requirements & Architecture — completed
- Scope 4: Theme & Design System — completed

The project blueprint is documented in [Store Requirements & Architecture](docs/store-requirements-architecture.md). The locked concept is **DeskNest** — a Germany-first desk-setup and workspace accessories WooCommerce store concept.

The DeskNest theme and design-system blueprint is documented in [Theme & Design System](docs/theme-design-system.md). The selected direction is a custom DeskNest block-theme architecture using `theme.json`, native templates, reusable patterns, centralized design tokens, and minimal JavaScript.

Scopes 3 and 4 cover documentation and planning only. No custom theme folder has been created or activated, and no WooCommerce setup or storefront implementation has started yet.

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

This repository currently documents the initialized LocalWP WordPress project. WooCommerce configuration, the theme and design system, products, cart, checkout, customer accounts, payments, and shipping will be handled in later scopes.

## Local Setup

1. Open the site through LocalWP.
2. Start the LocalWP site before opening `woocommerce-store-wordpress.local`.
3. Do not commit real secrets or `wp-config.php`.

## Current Limitations

- No WooCommerce store functionality has been implemented yet.
- No custom theme has been selected or built yet.
- No production deployment exists yet.
