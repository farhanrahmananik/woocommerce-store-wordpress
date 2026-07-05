# Inventory & Stock Management

## Scope Status

- Scope 1: Environment Setup - completed
- Scope 2: Project Initialization - completed
- Scope 3: Store Requirements & Architecture - completed
- Scope 4: Theme & Design System - completed
- Scope 5: WooCommerce Foundation - completed
- Scope 6: Product Catalog - completed
- Scope 7: Product Attributes & Variations - completed
- Scope 8: Inventory & Stock Management - completed

## Scope Purpose and Goal

This document records the inventory and stock-management strategy applied to the DeskNest WooCommerce catalog on top of the Scope 6 catalog and Scope 7 attributes/variations work.

The goal of Scope 8 is a realistic but deliberately simple inventory policy: decide which sellable items should have their quantity tracked, apply that policy safely through WooCommerce's own product APIs, and create a small number of intentional test scenarios (low stock, an out-of-stock simple product, and an out-of-stock variation whose parent remains available) so the catalog behaves like a real store without introducing warehouse, supplier, or point-of-sale complexity that this portfolio project does not need.

## Inventory Strategy Summary

- All 19 simple products have quantity tracking enabled (`manage_stock=true`) with a specific stock quantity each.
- All 11 product variations have quantity tracking enabled (`manage_stock=true`) with a specific stock quantity each.
- All 5 variable parent products keep parent-level stock tracking disabled (`manage_stock=false`); their availability is derived from their variations.
- Backorders are disabled everywhere (`backorders=no`) - no product or variation allows purchase once its quantity reaches zero.
- No product- or variation-level low-stock override was set; every quantity-tracked item relies on the global WooCommerce low-stock threshold.
- Out-of-stock items remain visible in the catalog (`woocommerce_hide_out_of_stock_items=no` was left unchanged).
- Two intentional out-of-stock scenarios exist: simple product `DN-BND-002` and variation `DN-PRD-001-GRN`.

## Global WooCommerce Stock Settings

These options were read before and after applying the policy in Step 3 and are unchanged:

| Option | Value | Meaning |
| --- | --- | --- |
| `woocommerce_manage_stock` | `yes` | Global switch that makes stock fields available in the admin; a WooCommerce default from installation, not changed in this scope |
| `woocommerce_hold_stock_minutes` | `60` | Minutes an unpaid order holds stock before it is released |
| `woocommerce_notify_low_stock` | `yes` | Low-stock admin notification enabled |
| `woocommerce_notify_no_stock` | `yes` | Out-of-stock admin notification enabled |
| `woocommerce_notify_low_stock_amount` | `2` | Global low-stock threshold used by every quantity-tracked item in this scope (no per-item override) |
| `woocommerce_notify_no_stock_amount` | `0` | Quantity at which an item is treated as out of stock |
| `woocommerce_hide_out_of_stock_items` | `no` | Out-of-stock items stay visible in the catalog |
| `woocommerce_stock_format` | *(empty/default)* | Default stock-quantity display behavior |

## Why Simple Products Are Quantity-Tracked

Each simple product is a single standalone sellable SKU with no variation splitting, so it is the natural unit to hold a real stock count. Enabling quantity tracking on all 19 lets the catalog demonstrate realistic low-stock and out-of-stock behavior credibly, rather than every item permanently reporting "in stock" with no underlying number.

## Why Variable Parents Remain Parent-Level Untracked

A WooCommerce variable product's parent post is a grouping and display entity; the actual purchasable units are its variations. WooCommerce does not use a variable parent's own stock fields once its variations manage their own stock - enabling both would be redundant and could create conflicting signals. Keeping `manage_stock=false` on all 5 parents follows WooCommerce's own architecture: the parent's displayed availability is synced from its children instead of holding an independent count.

## Why Variations Are Quantity-Tracked

Each variation (a specific color, finish, or size) is the real unit a customer selects and purchases, and different options commonly sell through at different rates in a real store. Tracking quantity per variation, rather than only at the parent level, is what makes the color/finish/size selector behave realistically - for example, showing one finish as available while another is sold out.

## Simple Product Inventory

| SKU | Manage stock | Stock quantity | Stock status | Backorders |
| --- | --- | ---: | --- | --- |
| `DN-ERG-003` | true | 14 | instock | no |
| `DN-ERG-004` | true | 9 | instock | no |
| `DN-ERG-005` | true | 5 | instock | no |
| `DN-ORG-002` | true | 18 | instock | no |
| `DN-ORG-003` | true | 12 | instock | no |
| `DN-ORG-004` | true | 7 | instock | no |
| `DN-LIT-002` | true | 10 | instock | no |
| `DN-LIT-003` | true | 6 | instock | no |
| `DN-LIT-004` | true | 3 | instock | no |
| `DN-CAB-001` | true | 22 | instock | no |
| `DN-CAB-002` | true | 16 | instock | no |
| `DN-CAB-003` | true | 8 | instock | no |
| `DN-CAB-004` | true | 2 | instock | no |
| `DN-PRD-002` | true | 11 | instock | no |
| `DN-PRD-003` | true | 6 | instock | no |
| `DN-PRD-004` | true | 4 | instock | no |
| `DN-PRD-005` | true | 13 | instock | no |
| `DN-BND-001` | true | 5 | instock | no |
| `DN-BND-002` | true | 0 | **outofstock** | no |

## Variable Parent Inventory

| Parent SKU | Manage stock | Stock quantity | Backorders | Child variation SKUs |
| --- | --- | --- | --- | --- |
| `DN-ERG-001` | false | not tracked | no | `DN-ERG-001-BLK`, `DN-ERG-001-SLV` |
| `DN-ERG-002` | false | not tracked | no | `DN-ERG-002-60`, `DN-ERG-002-80` |
| `DN-ORG-001` | false | not tracked | no | `DN-ORG-001-CPT`, `DN-ORG-001-STD` |
| `DN-LIT-001` | false | not tracked | no | `DN-LIT-001-BLK`, `DN-LIT-001-SLV` |
| `DN-PRD-001` | false | not tracked | no | `DN-PRD-001-BLK`, `DN-PRD-001-GRY`, `DN-PRD-001-GRN` |

Each parent's own displayed stock status is synced from its children (via WooCommerce's variable-product sync) rather than held independently.

## Variation Inventory

| Parent SKU | Variation SKU | Manage stock | Stock quantity | Stock status | Backorders |
| --- | --- | --- | ---: | --- | --- |
| `DN-ERG-001` | `DN-ERG-001-BLK` | true | 8 | instock | no |
| `DN-ERG-001` | `DN-ERG-001-SLV` | true | 4 | instock | no |
| `DN-ERG-002` | `DN-ERG-002-60` | true | 7 | instock | no |
| `DN-ERG-002` | `DN-ERG-002-80` | true | 3 | instock | no |
| `DN-ORG-001` | `DN-ORG-001-CPT` | true | 10 | instock | no |
| `DN-ORG-001` | `DN-ORG-001-STD` | true | 6 | instock | no |
| `DN-LIT-001` | `DN-LIT-001-BLK` | true | 5 | instock | no |
| `DN-LIT-001` | `DN-LIT-001-SLV` | true | 2 | instock | no |
| `DN-PRD-001` | `DN-PRD-001-BLK` | true | 9 | instock | no |
| `DN-PRD-001` | `DN-PRD-001-GRY` | true | 4 | instock | no |
| `DN-PRD-001` | `DN-PRD-001-GRN` | true | 0 | **outofstock** | no |

## Intentional Test Scenarios

- **Low-stock examples** (quantity at or below the global low-stock threshold of 2, but still greater than zero): simple product `DN-CAB-004` (quantity 2) and variation `DN-LIT-001-SLV` (quantity 2). Both remain `instock` but sit exactly at the threshold that triggers WooCommerce's low-stock admin notification and low-stock display state.
- **Out-of-stock simple product**: `DN-BND-002` (quantity 0, `outofstock`) - a standalone product that is fully unavailable.
- **Out-of-stock variation while the parent remains available**: `DN-PRD-001-GRN` (quantity 0, `outofstock`) under parent `DN-PRD-001`. The parent itself still shows `instock` overall because its other two variations (`DN-PRD-001-BLK` at 9 and `DN-PRD-001-GRY` at 4) remain in stock - this demonstrates WooCommerce's per-variation availability alongside overall parent availability.

## Backorder Policy

Backorders are disabled (`backorders=no`) on every one of the 35 quantity-relevant entities (19 simple products, 5 variable parents, 11 variations). Once a quantity-tracked item's stock reaches zero, it becomes unavailable for purchase with no backorder option and no backorder notification. This deliberately simple policy avoids the added complexity of backorder customer messaging, negative stock handling, and backorder-specific notifications, which are not needed for this project's current scope.

## SKU Integrity Summary

- 35 total SKU-bearing entities: 19 simple products + 5 variable parents + 11 variations.
- 35 unique, non-empty SKUs confirmed via a direct database query in Step 3.
- 0 duplicate SKUs, 0 empty SKUs.
- No SKU was changed, added, or removed by this scope.

## Scope Boundaries / What This Scope Does Not Include

- Storefront, cart, and checkout inventory behavior (for example, whether an out-of-stock variation is correctly blocked at add-to-cart, or how the variation selector visually represents an out-of-stock option) has **not** been tested; that belongs to a later, separately approved scope.
- No warehouse management, point-of-sale integration, or supplier/purchase-order workflow exists or is implied by this document.
- No claim of production readiness or deployment is made; this inventory state exists only on the local WooCommerce database for `woocommerce-store-wordpress.local`.
- No product-level or variation-level custom low-stock threshold was introduced; every item relies on the single global threshold.
- No plugin was installed, and no product name, slug, price, description, category, tag, image, attribute, or SKU was changed by this scope - only stock-related fields (`manage_stock`, `stock_quantity`, `stock_status`, `backorders`, `low_stock_amount`).
- No global WooCommerce setting was changed; the table above lists the same values before and after this scope's changes.

## Validation Summary

Based on the read-only validation performed after applying the policy (Step 3):

| Check | Result |
| --- | --- |
| Product type counts | 19 simple, 5 variable, 11 variations - unchanged from before this scope |
| Global stock settings | Identical before and after (see table above) |
| Items with `manage_stock=true` | Exactly 30 (19 simple + 11 variations) |
| Items with `manage_stock=false` | Exactly 5 (variable parents) |
| Stock status breakdown | 33 `instock`, 2 `outofstock` |
| Out-of-stock items | Exactly `DN-BND-002` and `DN-PRD-001-GRN` - no more, no less |
| Backorders | `no` on all 35 relevant entities |
| SKU integrity | 35 unique SKUs, 0 duplicates, 0 empty |
| Project files changed during database update | None - `git status` was clean throughout Step 3 |

## Next-Scope Notes

The following are explicitly **not implemented** by this scope and are left for later, separately approved work:

- Testing and, if needed, adjusting storefront/cart/checkout behavior for out-of-stock and low-stock items.
- Any automated or manual verification of the low-stock/out-of-stock admin email notifications.
- Any warehouse, supplier, purchasing, or point-of-sale inventory integration - none is planned as part of this project unless a future scope explicitly approves it.
- Taxes, shipping, payments, customer accounts, and storefront UI/theme work remain unconfigured, consistent with all prior scopes.
