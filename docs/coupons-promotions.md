# Coupons & Promotions

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
- Scope 10: Cart - completed
- Scope 11: Checkout - completed
- Scope 12: Customer Accounts - completed
- Scope 13: Order Management - completed
- Scope 14: Coupons & Promotions - completed

## Scope Overview

This document records Scope 14 — Coupons & Promotions for the DeskNest store: creating and validating four realistic WooCommerce coupon scenarios entirely in local development. **This scope is completed locally** - all validation below was performed and confirmed against the local development environment. This is a **local-only validation and documentation scope** - no real payments, real orders, or real shipments were created. All coupon behavior was confirmed against a live local WooCommerce cart and the Checkout block's own Store API, not against a placed order.

## Baseline

- `woocommerce_enable_coupons` = `yes` (coupons already enabled before this scope began).
- `woocommerce_calc_discounts_sequentially` = `no` (WooCommerce default, unchanged).
- Existing coupons before this scope: **zero**.
- The Cart block (page ID 8) and Checkout block (page ID 9) already contained their respective coupon-form sub-blocks (`cart-order-summary-coupon-form-block` / `checkout-order-summary-coupon-form-block`) in stored page content before any coupon existed - no template or settings change was needed to make coupons usable.

## Coupon Matrix

| Field | `newdesk10` | `ergo15` | `bundlesave` | `summersale` |
| --- | --- | --- | --- | --- |
| Purpose | First-order welcome discount | Ergonomic Essentials seasonal promotion | In-stock Starter Bundle cross-sell incentive | Intentionally expired seasonal promotion for validation testing |
| Discount type | Fixed cart | Percentage | Fixed cart | Percentage |
| Amount | €10 | 15% | €8 | 10% |
| Minimum spend | €40 | none | none | none |
| Maximum spend | none | €100 | none | none |
| Product/category restriction | Excludes Bundles category | Included category: Ergonomic Essentials | Included product: DN-BND-001 only; explicitly excludes DN-BND-002 | Storewide, no restriction |
| Exclude sale items | Yes | No | No | Yes |
| Individual use | Yes | No | Yes | No |
| Usage limit | 100 | 20 | 10 | 50 |
| Usage limit per user | 1 | Unlimited | 1 | Unlimited |
| Expiry date | None | 2026-09-30 | 2026-10-31 | 2026-06-01 (**deliberately already past**) |
| Usage count after validation | 0 | 0 | 0 | 0 |

`bundlesave`'s explicit exclusion of DN-BND-002 was deliberate: that SKU is intentionally kept out of stock in this catalog (see [Inventory & Stock Management](inventory-stock-management.md)), so the coupon is scoped only to the bundle that can actually be purchased.

## Cart Validation

Validated directly against WooCommerce's `WC_Cart` object in the local environment (no browser, no order):

| Scenario | Coupon | Cart contents | Expected result | Subtotal | Discount | Total | Status |
| --- | --- | --- | --- | --- | --- | --- | --- |
| A | newdesk10 | DN-ERG-003 + DN-CAB-002 | Applies | €47.80 | €10.00 | €37.80 | Passed |
| B | ergo15 | DN-ERG-004 | Applies | €19.90 | €2.98 | €16.92 | Passed |
| C | bundlesave | DN-BND-001 | Applies | €79.90 | €8.00 | €71.90 | Passed |
| D | newdesk10 | DN-CAB-002 | Rejected - minimum spend | €12.90 | €0.00 | €12.90 | Passed |
| E | ergo15 | DN-CAB-002 | Rejected - not applicable | €12.90 | €0.00 | €12.90 | Passed |
| F | bundlesave | DN-CAB-002 | Rejected - not applicable | €12.90 | €0.00 | €12.90 | Passed |
| G | summersale | DN-ERG-004 | Rejected - expired | €19.90 | €0.00 | €19.90 | Passed |

Rejection notices (identical wording to what a shopper would see in the Cart block):
- `The minimum spend for coupon "newdesk10" is €40,00.`
- `Sorry, coupon "ergo15" is not applicable to selected products.`
- `Sorry, coupon "bundlesave" is not applicable to selected products.`
- `Coupon "summersale" has expired.`

## Checkout Validation

Checkout-level validation used the **WooCommerce Store API cart endpoints** (`/wp-json/wc/store/v1/cart/*`) - the same backend the Checkout block's own coupon form calls in the browser. This intentionally goes one layer deeper than a PHP-object cart test: it confirms the actual HTTP/REST behavior the Checkout block relies on, without ever calling the `/checkout` endpoint (which would create a draft order) and without placing an order.

All seven scenarios (A–G) were re-run against the Store API and **matched the cart-level results exactly** - same subtotals, same discount amounts, same totals, same rejections.

Exact Store API error responses for the rejection scenarios:
```json
{"code":"woocommerce_rest_cart_coupon_error","message":"The minimum spend for coupon \"newdesk10\" is 40,00 €."}
{"code":"woocommerce_rest_cart_coupon_error","message":"Sorry, coupon \"ergo15\" is not applicable to selected products."}
{"code":"woocommerce_rest_cart_coupon_error","message":"Sorry, coupon \"bundlesave\" is not applicable to selected products."}
{"code":"woocommerce_rest_cart_coupon_error","message":"Coupon \"summersale\" has expired."}
```

## Usage Limits

All four coupons have `usage_limit` and/or `usage_limit_per_user` configured (see the matrix above), and this configuration was verified directly on the stored coupon objects. However, **usage-limit exhaustion itself was not tested** in this scope. WooCommerce only increments a coupon's `usage_count` when the coupon is attached to an order - applying a coupon to a cart or through the Checkout block's Store API never increments it, which is exactly why all four coupons still show `usage_count: 0` after every validation scenario above. Demonstrating a coupon actually hitting its usage limit would require creating at least one additional order, which was deliberately not done in this scope to avoid growing local order history for a scope whose core objective (coupon logic validation) didn't require it. This is a known, intentional limitation, not an oversight.

## Stock/Order Safety

- No orders were created in this scope. The local order count remained exactly **1** throughout (order #49, from [Order Management](order-management.md) / Scope 13) - unchanged before and after every scenario.
- No product stock quantities changed at any point.
- DN-BND-002 and DN-PRD-001-GRN remained the project's two intentional out-of-stock SKUs throughout, and `bundlesave` was deliberately scoped to avoid DN-BND-002 entirely.
- No payment gateway was enabled and no shipment was created or configured.

## Admin/Configuration Notes

- Coupons exist as standard WordPress `shop_coupon` posts (IDs 50–53), each `publish` status.
- HPOS (WooCommerce's custom order tables) affects **order** storage only - it has no bearing on how coupons are stored or managed.
- Coupon list screen: `/wp-admin/edit.php?post_type=shop_coupon`
- Coupon edit screen pattern: `/wp-admin/post.php?post={coupon_id}&action=edit`
- **Admin visual review was not performed.** The URLs above were constructed from WordPress's own standard admin routing conventions, not confirmed by viewing the rendered screens in a browser.

## Limitations

- No real payment gateway validation - payment configuration remains deferred to Scope 16.
- No shipping or free-shipping coupon behavior was exercised - shipping configuration remains deferred to Scope 17; all four coupons have `free_shipping: no`.
- No browser visual checkout submission or order placement was performed at any point in this scope.
- Usage-limit exhaustion was not tested, for the reason explained above (requires at least one order).
- `individual_use` is correctly configured and verified in stored coupon metadata for all four coupons, but a clean, isolated "cannot combine coupons" UX scenario was **not** established - two attempts to combine individual-use coupons were both confounded by product/category restrictions rather than cleanly isolating the individual-use rejection message itself. This document does not claim the individual-use stacking behavior was cleanly demonstrated, only that the setting is correctly stored.
- Temporary WooCommerce session rows were created in the local database as an unavoidable side effect of cart/Store API testing (consistent with every prior scope's cart/checkout validation work) - these were reported honestly in each step's validation output and were not removed via direct database mutation.

## Files Touched

- `docs/coupons-promotions.md`
- `README.md`

No PHP, CSS, JS, theme templates, WooCommerce settings, products, categories, variations, stock, orders, customers, payments, shipping, plugins, or pages were modified to produce this documentation.
