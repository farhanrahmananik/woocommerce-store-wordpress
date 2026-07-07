# Reports & Analytics

## 1. Scope Status

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
- Scope 15: Product Reviews - completed
- Scope 16: Payment Configuration - completed
- Scope 17: Shipping Configuration - completed
- Scope 18: Reports & Analytics - completed

## 2. Scope Overview

Scope 18 validates and documents WooCommerce's own **native, built-in** Reports & Analytics functionality for the DeskNest store, entirely against the store's existing local data. **This scope is completed locally** - it adds no new plugin, no external analytics or tracking service, and no fabricated data. It confirms what WooCommerce's native reporting already shows given the real (and intentionally small) amount of local activity generated across Scopes 1-17, and documents that honestly.

## 3. Reporting Architecture

WooCommerce ships two overlapping reporting systems, both confirmed present and active on this installation (WooCommerce 10.9.3, active theme `desknest`, HPOS/custom order tables enabled):

- **WooCommerce Analytics** (`wc-admin`) - the modern React-based Analytics suite, confirmed enabled (`Features::is_enabled('analytics') = yes`). It is backed by a set of dedicated MySQL lookup tables that WooCommerce keeps in sync with the underlying orders/products/coupons/customers data.
- **Legacy Reports** (`WC_Admin_Reports`) - the older reports screen, confirmed still present as a class in this WooCommerce version and available as a fallback.

No custom reporting code, no external analytics SaaS, and no additional plugin were added to produce or support this reporting - both systems are entirely native to the WooCommerce core plugin already installed.

## 4. Native WooCommerce Analytics Areas

The following are WooCommerce's own native Analytics report areas, relevant to this project:

- Analytics Overview
- Analytics Revenue
- Analytics Orders
- Analytics Products
- Analytics Stock
- Analytics Coupons
- Analytics Customers
- Analytics Taxes
- Analytics Downloads
- Legacy Reports (fallback)

## 5. Validated Local Dataset

All numbers below were confirmed via read-only WP-CLI/database queries against WooCommerce's own APIs and analytics lookup tables - the same underlying data source the Analytics UI itself reads from - not by visually opening the admin screens.

| Metric | Value |
| --- | --- |
| Total orders | 1 |
| Order | #49 |
| Order status | `processing` |
| Order total | €31.80 |
| Currency | EUR |
| Created | 2026-07-06T22:07:03+00:00 |
| Customer | user ID 2 / `desknest.customer@example.test` |
| Payment method | `local_dev` / "Local development order - no payment processed" |
| Line items | DN-PRD-005 × 1 = €13.90; DN-PRD-004 × 1 = €17.90 |
| Published products | 24 (19 simple, 5 variable parents, 11 variations) |
| Reviews | 7 |

## 6. Orders & Revenue Reporting

- `wc_order_stats`: **1 row**, matching order #49 exactly (`total_sales: 31.8`, `num_items_sold: 2`, `tax_total: 0`, `shipping_total: 0`, `net_total: 31.8`).
- Cross-checked directly against `wc_get_order(49)`: status, total, currency, customer, payment method, and both line items all matched exactly.
- The Analytics Overview/Revenue/Orders reports will therefore show exactly **one order and €31.80 in total revenue** for the entire store's history - this is accurate and expected, not a bug or missing data.

## 7. Product Reporting

- `wc_order_product_lookup`: **2 rows** - `DN-PRD-005` (qty 1, €13.90 net revenue) and `DN-PRD-004` (qty 1, €17.90 net revenue), matching order #49's line items exactly.
- Total units sold across the entire store: **2**. Distinct products ever sold: **2**.
- `wc_product_meta_lookup`: **35 rows**, reflecting the full 24-product / 11-variation catalog.
- The Products Analytics report will show 2 units sold across exactly 2 products, with the remaining 22 products showing 0 units sold - accurate given the store's real local activity.

## 8. Stock Reporting

- In stock: **23**. Out of stock: **1**. On backorder: **0**. Stock-managed products/variations: **19**.
- The single out-of-stock item is **DN-BND-002** - "DeskNest Cable-Control Bundle (cable tray, sleeve kit, clip set, routing channel kit)" - consistent with the intentional out-of-stock test SKU documented since [Inventory & Stock Management](inventory-stock-management.md) / Scope 8.

## 9. Coupon Reporting

| Code | Type | Amount | Expiry | Usage count |
| --- | --- | --- | --- | --- |
| `newdesk10` | fixed_cart | €10 | none | 0 |
| `ergo15` | percent | 15% | 2026-09-30 | 0 |
| `bundlesave` | fixed_cart | €8 | 2026-10-31 | 0 |
| `summersale` | percent | 10% | 2026-06-01 (past) | 0 |

`wc_order_coupon_lookup`: **0 rows**. The Coupons Analytics report will correctly show **no coupon-attributed order or revenue data**, because no coupon has ever actually been applied to a real order (see [Coupons & Promotions](coupons-promotions.md) / Scope 14, which validated coupon logic against the cart/Store API without creating an order by design). This is expected, not a defect.

## 10. Customer Reporting

`wc_customer_lookup`: **1 row** - `customer_id` 1 (WooCommerce's internal surrogate key for this table) maps to `user_id` 2, username `desknest_test_customer`, email `desknest.customer@example.test`, country `DE`, city `Berlin` - correctly corresponding to order #49's customer. Since `wc_order_stats` has exactly one row for this customer, the Customers Analytics report will show 1 customer with 1 order and €31.80 total spend.

## 11. Taxes and Downloads Reporting

- `wc_order_tax_lookup`: **0 rows** - no tax report data exists, because no tax has ever been configured on this store.
- `wc_download_log`: **0 rows** - no download report data exists, because the catalog contains no downloadable products.
- Both are expected, accurate empty states given the current local catalog and settings - not gaps in this scope's validation.

## 12. Reviews Relevance

7 product reviews exist (see [Product Reviews](product-reviews.md) / Scope 15), but **reviews are not part of WooCommerce's native `wc-admin` Analytics report areas** - there is no built-in "Reviews" analytics screen in WooCommerce core. Reviews are noted here for completeness only and are out of scope for the report validation in this document.

## 13. Analytics Lookup Tables

| Table | Rows |
| --- | --- |
| `wc_order_stats` | 1 |
| `wc_order_product_lookup` | 2 |
| `wc_customer_lookup` | 1 |
| `wc_order_coupon_lookup` | 0 |
| `wc_order_tax_lookup` | 0 |
| `wc_product_meta_lookup` | 35 |
| `wc_download_log` | 0 |

All tables already existed and were already populated by WooCommerce itself as a natural consequence of order #49 being created in Scope 13 - no import, regeneration, or sync tool was run to produce or alter this data at any point in Scope 18.

## 14. Admin Paths for Manual Review

The following native WooCommerce admin URLs were identified and constructed via WooCommerce's own `wc_admin_url()` helper and documented URL structure. **They were not opened or visually reviewed in this scope** - no browser automation tool is available in this environment, so all validation above was performed at the data level (WP-CLI/database/API), not by viewing the rendered admin screens:

- `/wp-admin/admin.php?page=wc-admin&path=/analytics/overview`
- `/wp-admin/admin.php?page=wc-admin&path=/analytics/revenue`
- `/wp-admin/admin.php?page=wc-admin&path=/analytics/orders`
- `/wp-admin/admin.php?page=wc-admin&path=/analytics/products`
- `/wp-admin/admin.php?page=wc-admin&path=/analytics/stock`
- `/wp-admin/admin.php?page=wc-admin&path=/analytics/coupons`
- `/wp-admin/admin.php?page=wc-admin&path=/analytics/customers`
- `/wp-admin/admin.php?page=wc-admin&path=/analytics/taxes`
- `/wp-admin/admin.php?page=wc-admin&path=/analytics/downloads`
- `/wp-admin/admin.php?page=wc-reports` (legacy fallback)

If these screens are visually reviewed by the user directly and screenshots are shared later, that would be a separate, clearly-attributed manual review - not claimed here.

## 15. Scope Boundaries / What Was Not Added

The following are explicitly **not** implemented by Scope 18 and remain out of scope:

- No Google Analytics, Meta Pixel, tracking pixels, cookies, consent banners, or any external analytics SaaS.
- No third-party reporting service or plugin of any kind.
- No fake orders, sales, coupon usage, customers, or reviews were created to make dashboards look richer.
- No analytics import, regeneration, sync, or reset tool was run.
- No visual/browser review of the admin Analytics screens was performed or claimed.
- No production analytics, real traffic, or real sales data exists anywhere in this project.

## 16. Local Development Limitations

- This is a **local-development-only** analytics validation - all data originates from one programmatically-created test order (#49) and zero real customer traffic.
- The dataset is **intentionally sparse**: 1 order, €31.80 total revenue, 2 units sold, 0 coupon usage, 0 tax collected, 0 downloads. This is appropriate and expected for a local portfolio validation project, not a shortcoming to be padded out with fabricated activity.
- Because the underlying data is so small, most Analytics report screens (Revenue, Orders, Products, Coupons, Customers, Taxes, Downloads) would show near-empty or single-data-point charts if opened in a browser - this is accurate reporting, not broken reporting.

## 17. Validation Summary

- WooCommerce Analytics feature and legacy Reports class both confirmed available and unchanged from baseline.
- All 7 relevant analytics lookup tables inspected directly; every row's contents cross-checked against the corresponding WooCommerce order/product/coupon/customer API and found to match exactly.
- Order #49, all 4 coupons (usage_count 0), and all product/stock counts were confirmed unchanged before and after validation - no side effects occurred.
- No files, database records, settings, products, orders, coupons, reviews, customers, or plugins were modified to produce this documentation.
