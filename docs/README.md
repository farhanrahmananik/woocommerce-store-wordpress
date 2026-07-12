# Project Documentation Index

This directory contains the scope records and architecture notes for the DeskNest WooCommerce portfolio project.

Each scope document records the project state and boundaries at that scope's completion. Later scope documents may supersede earlier implementation-state statements.

For the final current storefront and QA state, prioritize `ui-polish.md` and `testing-quality-review.md`.

## Documentation Navigation

### Documentation Overview

- [Project Documentation Index](README.md) - this navigation file for the repository documentation set.
- [Portfolio Presentation](portfolio-presentation.md) - recruiter-facing DeskNest case study and complete screenshot gallery.

### Product and Business Architecture

- [Store Requirements & Architecture](store-requirements-architecture.md) - DeskNest business concept, market positioning, product strategy, and architecture boundaries.
- [Theme & Design System](theme-design-system.md) - original Scope 4 design-system and block-theme blueprint, with historical context for later theme changes.

### Theme and Storefront

- [Storefront Experience](storefront-experience.md) - earlier Scope 9 `desknest` storefront foundation and homepage setup.
- [UI Polish](ui-polish.md) - final Scope 21 `desknest-storefront` theme, WooCommerce UI layer, and responsive storefront implementation.

### Catalog and Inventory

- [WooCommerce Foundation](woocommerce-foundation.md) - WooCommerce installation, Germany/EUR settings, default pages, and foundation validation.
- [Product Catalog](product-catalog.md) - implemented categories and 24 published products.
- [Product Attributes & Variations](product-attributes-variations.md) - global attributes, variable products, and variation strategy.
- [Inventory & Stock Management](inventory-stock-management.md) - SKU rules, stock quantities, low-stock behavior, and out-of-stock scenarios.

### Cart, Checkout, and Customer Flows

- [Cart](cart.md) - cart behavior and styling evidence from the original cart scope.
- [Checkout](checkout.md) - Checkout Block validation and theme-level checkout styling evidence.
- [Customer Accounts](customer-accounts.md) - customer registration, login, dashboard, addresses, and account-details workflow documentation.

### Orders, Promotions, and Reviews

- [Order Management](order-management.md) - local order-management workflow validation against a development order.
- [Coupons & Promotions](coupons-promotions.md) - four realistic local coupon scenarios and validation notes.
- [Product Reviews](product-reviews.md) - local-safe review dataset, verified-owner handling, and review UI styling.

### Payments and Shipping

- [Payment Configuration](payment-configuration.md) - local-development-only BACS payment configuration and payment boundaries.
- [Shipping Configuration](shipping-configuration.md) - Germany-only shipping zone, flat rate, and free-shipping threshold configuration.

### Reporting, Security, and Performance

- [Reports & Analytics](reports-analytics.md) - read-only WooCommerce analytics and reporting review against local data.
- [Security & Hardening](security-hardening.md) - local-safe hardening review and honest security boundaries.
- [Performance Optimization](performance-optimization.md) - historical LocalWP performance baseline and asset review captured before the final Scope 21 theme.

### UI Polish, Testing, and QA

- [Testing & Quality Review](testing-quality-review.md) - Scope 22 static checks, responsive/browser checks, keyboard/accessibility-focused checks, and defect retesting.

## Current-State Reading Path

For a reviewer who wants the quickest accurate picture:

1. Read the root [project README](../README.md).
2. Read [Portfolio Presentation](portfolio-presentation.md) for the recruiter-facing case study and screenshot gallery.
3. Read `ui-polish.md` for the final active theme.
4. Read `testing-quality-review.md` for QA evidence and boundaries.
5. Use detailed scope documents only when deeper catalog, inventory, payment, shipping, reporting, or implementation evidence is needed.

## Important Boundaries

- The repository does not include a portable database snapshot.
- WordPress core, WooCommerce plugin files, uploads, LocalWP runtime files, and `wp-config.php` are intentionally not tracked.
- Some earlier documents describe historical states from their own scope, such as the earlier `desknest` block theme. Current final UI implementation details are in `ui-polish.md`.
