# Product Attributes & Variations

## Scope Status

- Scope 1: Environment Setup - completed
- Scope 2: Project Initialization - completed
- Scope 3: Store Requirements & Architecture - completed
- Scope 4: Theme & Design System - completed
- Scope 5: WooCommerce Foundation - completed
- Scope 6: Product Catalog - completed
- Scope 7: Product Attributes & Variations - completed

## Scope Purpose

This document records the implemented WooCommerce global product attributes and product variations for the DeskNest store, built on top of the Scope 6 simple-product catalog documented in [Product Catalog](product-catalog.md).

Scope 7 implemented exactly three global attributes, assigned them to five previously flagged variable-product candidates from Scope 6, converted those five products from simple to variable, and created eleven product variations with realistic SKUs and prices. It did not touch inventory workflows beyond the fields required for a variation to exist, and it did not touch taxes, payments, shipping, cart, checkout, accounts, storefront UI, plugins, or theme files.

## Confirmed Environment

| Item | Value |
| --- | --- |
| Project | WooCommerce Store - WordPress (DeskNest) |
| WordPress root | `E:\wordpress-projects\woocommerce-store-wordpress\app\public` |
| Local environment | LocalWP, site `woocommerce-store-wordpress.local` |
| WooCommerce version | 10.9.3 |
| WP-CLI access | LocalWP-bundled PHP 8.2.29 and WP-CLI phar (no global `wp`/`php` on PATH) |

## Summary of Final State

| Item | Final state |
| --- | ---: |
| Global product attributes | 3 |
| Attribute terms | 9 |
| Variable products | 5 |
| Product variations | 11 |
| Simple products remaining | 19 |
| Total products | 24 (unchanged from Scope 6) |

## Global Attributes

| Label | Taxonomy | Terms | Commercial purpose |
| --- | --- | --- | --- |
| Color | `pa_color` | Black, Grey, Green | Cosmetic color choice for fabric/leather items; a common conversion driver and a realistic future storefront filter |
| Finish | `pa_finish` | Black, Silver | Metal/plastic hardware finish choice for aluminum and metal accessories |
| Size | `pa_size` | 60 cm, 80 cm, Compact, Standard | One reusable attribute serving two different dimension concepts (width and module-based size) across different products, avoiding attribute sprawl |

## Variable Products

| Parent SKU | Product name | Category | Attribute | Terms | Variation count |
| --- | --- | --- | --- | --- | ---: |
| `DN-ERG-001` | Adjustable Aluminum Laptop Stand | Ergonomic Essentials | Finish (`pa_finish`) | Black, Silver | 2 |
| `DN-ERG-002` | Wooden Monitor Riser | Ergonomic Essentials | Size (`pa_size`) | 60 cm, 80 cm | 2 |
| `DN-ORG-001` | Modular Bamboo Desk Organizer | Desk Organization | Size (`pa_size`) | Compact, Standard | 2 |
| `DN-LIT-001` | Dimmable USB-C Monitor Light Bar | Lighting & Ambience | Finish (`pa_finish`) | Black, Silver | 2 |
| `DN-PRD-001` | Vegan-Leather Desk Mat, Large | Productivity Accessories | Color (`pa_color`) | Black, Grey, Green | 3 |

Each attribute assignment is `visible=true` and `variation=true`. All five parents remain `publish` status, in their original Scope 6 category, with unchanged product title, description, and category assignment.

## Variations

| Parent SKU | Variation SKU | Attribute value | Price (EUR) | Stock status | Manage stock |
| --- | --- | --- | ---: | --- | --- |
| `DN-ERG-001` | `DN-ERG-001-BLK` | Finish: Black | 39.90 | instock | false |
| `DN-ERG-001` | `DN-ERG-001-SLV` | Finish: Silver | 39.90 | instock | false |
| `DN-ERG-002` | `DN-ERG-002-60` | Size: 60 cm | 44.90 | instock | false |
| `DN-ERG-002` | `DN-ERG-002-80` | Size: 80 cm | 49.90 | instock | false |
| `DN-ORG-001` | `DN-ORG-001-CPT` | Size: Compact | 27.90 | instock | false |
| `DN-ORG-001` | `DN-ORG-001-STD` | Size: Standard | 32.90 | instock | false |
| `DN-LIT-001` | `DN-LIT-001-BLK` | Finish: Black | 49.90 | instock | false |
| `DN-LIT-001` | `DN-LIT-001-SLV` | Finish: Silver | 49.90 | instock | false |
| `DN-PRD-001` | `DN-PRD-001-BLK` | Color: Black | 32.90 | instock | false |
| `DN-PRD-001` | `DN-PRD-001-GRY` | Color: Grey | 32.90 | instock | false |
| `DN-PRD-001` | `DN-PRD-001-GRN` | Color: Green | 32.90 | instock | false |

SKU suffixes extend the base SKU per the naming convention already documented in [Product Catalog](product-catalog.md#sku-naming-convention).

## Products Intentionally Left Simple

The remaining 19 products stay simple products, unchanged from Scope 6, because none were flagged as variable-product candidates in the Scope 6 catalog plan:

- `DN-ERG-003`, `DN-ERG-004`, `DN-ERG-005` - single-spec ergonomic items with no documented variant.
- `DN-ORG-002`, `DN-ORG-003`, `DN-ORG-004` - fixed-spec desk organization items.
- `DN-LIT-002`, `DN-LIT-003`, `DN-LIT-004` - fixed-spec lighting items (only `DN-LIT-001` was flagged).
- `DN-CAB-001` through `DN-CAB-004` - all cable-management items; none flagged.
- `DN-PRD-002`, `DN-PRD-003`, `DN-PRD-004`, `DN-PRD-005` - fixed-spec productivity items (only `DN-PRD-001` was flagged).
- `DN-BND-001`, `DN-BND-002` - bundles with fixed contents; Scope 6 already documented that bundles have no variation logic.

## Validation Checklist

| Check | Result |
| --- | --- |
| Global attribute count | 3 (`pa_color`, `pa_finish`, `pa_size`) - matches plan |
| Attribute term count | 9 total (3 + 2 + 4) - matches plan, all slugs exact |
| Product type counts | 19 simple, 5 variable - matches plan |
| Product variation count | 11 - matches plan |
| Pricing | All 11 variation prices match the approved plan exactly |
| Stock / manage stock | All 11 variations `instock`, `manage_stock=false` |
| Non-target products | All 19 confirmed unchanged: still simple, 0 attributes, original prices |
| Storefront HTTP checks | All 5 variable product pages returned HTTP 200, no PHP fatal errors, and each page's expected variation term names (e.g. Black/Silver, 60 cm/80 cm, Compact/Standard, Black/Grey/Green) were found in the rendered page content |

## Implementation Notes

- Variation attributes are stored and matched using **term slugs** (for example `pa_finish=black`, `pa_size=60-cm`), not term display names, per WooCommerce's variation-matching requirements.
- Each variable parent's own price field was cleared; a variable product's displayed price/price range is derived from its variations, not from a parent-level price field.
- Stock management remains disabled by design for every variation (`manage_stock=false`), consistent with the Scope 6 decision to leave inventory workflows out of scope. Creating a variation does not require stock management to be enabled.
- No product images or featured images are assigned to any variation or parent in this scope; image/media work remains outside this scope.
- The rendered variation selector on the frontend appears as block-based WooCommerce markup (the active theme, Twenty Twenty-Five, is a block theme), not the classic-theme `variations_form` shortcode markup; this is expected and was confirmed by checking for the expected term names in the rendered page instead of a classic-only CSS class.

## Limitations / Next Scope Notes

- Inventory-specific behavior (stock quantities, low-stock thresholds, backorders) is out of scope here and will be handled in a later, separately approved inventory scope.
- Storefront visual polish for the variation selector and product pages is deferred to a later storefront/theme scope.
- Cart, checkout, and customer-account workflows involving these variable products remain unimplemented and are later scopes.
- Taxes, shipping, and payments remain unconfigured, consistent with all prior scopes.
