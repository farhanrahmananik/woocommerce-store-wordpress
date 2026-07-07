# Order Management

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

## Scope Overview

This document records Scope 13 — Order Management for the DeskNest store: establishing a safe, local-only way to have at least one real WooCommerce order to inspect, then validating the admin order-management workflow (order detail, status changes, order notes) and the customer-facing My Account order history/detail workflow, entirely on the local development database. **This scope is completed locally** - all validation below was performed and confirmed against the local development environment. This is a **validation and documentation scope**, not a payments, shipping, or production order-fulfillment implementation.

## Current Local Order Dataset

**One local development order exists in the local development database only** - it is not committed seed data, is not part of any migration or fixture file, and will not exist on a fresh clone of this repository. It exists solely in the local LocalWP MySQL database for validation purposes.

| Field | Value |
| --- | --- |
| Order ID / number | 49 |
| Customer | `desknest_test_customer` (ID 2, `desknest.customer@example.test`) |
| Status | `processing` (created as `on-hold`, transitioned during workflow validation) |
| Line items | DN-PRD-005 "Magnetic Notepad and Stylus Holder" x1 (€13.90); DN-PRD-004 "Analog Desk Timer for Focused Work Sessions" x1 (€17.90) |
| Total | €31.80 |
| Payment method / title | `local_dev` / "Local development order - no payment processed" |
| Created via | `scope-13-local-dev` |
| Billing/shipping address | Clearly marked test data: "DeskNest Test Customer", "TEST DATA - Local Development", Teststraße 13, "Scope 13 Local Dev Order", 10115 Berlin, DE |
| Customer note | "TEST DATA - Scope 13 local development order. No real payment, no real shipment." |

## Why Programmatic Order Creation Was Chosen

Three strategies were evaluated before creating this order: (A) temporarily enabling a payment gateway (e.g., Cash on Delivery) and placing one order through the real checkout flow, (B) creating one order programmatically with WooCommerce's `wc_create_order()`/`WC_Order` APIs, or (C) creating no order and only documenting empty states.

Strategy B was chosen. Strategy A was rejected because enabling any payment gateway is Scope 16's deliverable and satisfying a shipping rate for a physical product is Scope 17's - doing either "temporarily" here would still be scope creep into those later scopes. Strategy C was rejected because it would leave order management, the actual subject of this scope, entirely unvalidated. Programmatic creation was confirmed (by reading WooCommerce's own source) to have no dependency on the payment-gateway registry or the shipping-zone registry, making it the only option that stays fully inside this scope's boundary while still producing a real, HPOS-compatible order to validate against.

## HPOS Order-Management Notes

- HPOS (WooCommerce's custom order tables) is enabled on this installation.
- The WooCommerce Orders admin screen lives at `/wp-admin/admin.php?page=wc-orders` (not the legacy `edit.php?post_type=shop_order` route).
- `wc_create_order()` and the `WC_Order` object model are fully HPOS-native; order creation, line items, addresses, payment metadata, status changes, and notes were all validated using HPOS-aware APIs (`wc_get_orders()`, `wc_get_order()`, `wc_orders_count()`), not legacy post-table queries.

## Admin Order-Management Validation

Confirmed via WooCommerce's own APIs (not visual browser inspection - see the Manual Browser Validation Checklist below):

- Order 49 is retrievable via `wc_get_order(49)` with all expected fields intact.
- Order 49 appears in `wc_get_orders()` queries filtered by "all orders", by `status: on-hold` (before the workflow) and `status: processing` (after), and by `customer_id: 2`.
- The admin order edit route (`/wp-admin/admin.php?page=wc-orders&action=edit&id=49`) was identified from WooCommerce's own admin URL structure; its rendered appearance has not been visually confirmed (see below).

## Customer My Account Order Validation

- My Account page ID 10, URL `/my-account/`; Orders URL `/my-account/orders/`; View-order URL `/my-account/view-order/49/`.
- The **exact** query WooCommerce's real My Account "Orders" tab uses internally (`woocommerce_account_orders()` in WooCommerce core, which calls `wc_get_orders(['customer' => get_current_user_id(), 'paginate' => true])`, with no status filter) was traced and re-run directly for customer ID 2: it returns `total: 1` with order 49 - confirming the order would genuinely appear on that tab, not just in a generic query.
- The customer-facing "View order" template (`myaccount/view-order.php`) was read directly; it renders products, totals, billing/shipping address, the customer note, and payment method title, and calls `$order->get_customer_order_notes()` for its notes section.

## Status Workflow Validation

- Order was created with status `on-hold` (chosen specifically to avoid implying a payment had been processed).
- One intentional internal admin note was added, then the order was transitioned `on-hold` -> `processing` using `WC_Order::set_status()` with a custom transition note.
- Both transitions were confirmed to persist correctly and to be reflected in subsequent `wc_get_order()` reads and `wc_orders_count()` status tallies.

## Order Notes Behavior

- Order 49 currently has **7 total notes**: the original creation note, two automatic "Email ... sent" notes from the on-hold transition, the automatic "Order status changed from Pending payment to On hold" note, the intentional admin review note, the status-transition note (on-hold -> processing), and the automatic "Email 'Processing order' sent" note.
- All 7 are **internal/admin notes only**. Calling `$order->get_customer_order_notes()` - the exact method the customer-facing template uses - returns **0** notes for this order. **Internal admin notes are not customer-visible**; only the separate "customer note" field (visible in the order-detail summary) is shown to the customer.

## Email/Mailpit Behavior

Changing order status triggered WooCommerce's own standard transactional-email hooks (e.g., "New order", "Order on-hold", "Processing order" notifications) - this is normal WooCommerce core behavior on status transitions, not something this scope added or could suppress without non-standard intervention. This LocalWP site has Mailpit configured, which intercepts all outbound mail locally at the environment level. **No real external email was sent** at any point in this scope; no production email configuration exists or is claimed.

## Payment and Shipping Boundaries

- Payment gateways (`bacs`, `cheque`, `cod`) remain disabled throughout this entire scope, confirmed before and after every workflow action. **Payment configuration is deferred to Scope 16.**
- Shipping zones remain at 0 throughout this entire scope, confirmed before and after every workflow action. **Shipping configuration is deferred to Scope 17.**
- The test order's `payment_method` is the arbitrary string `local_dev`, which does not correspond to any registered gateway - order creation never touched the gateway or shipping-zone registries.

## Inventory/Stock Behavior and Caveat

Product stock was confirmed unchanged throughout this scope: DN-PRD-005 remained at 13, DN-PRD-004 remained at 4, checked before order creation, after creation, and after both status transitions.

**Caveat, documented honestly rather than glossed over:** the order-level `stock_reduced` marker (retrieved via `$order->get_data_store()->get_stock_reduced()`) became `true` during the `on-hold` transition. This happened because WooCommerce registers `on-hold` (and `processing`) as stock-reduction trigger statuses via `add_action('woocommerce_order_status_on-hold', 'wc_maybe_reduce_stock_levels')` - an unavoidable core WooCommerce hook, not something this scope's order-creation script triggered deliberately. However, the actual per-item reduction never executed: both line items' `_reduced_stock` meta remained empty (`''`, WooCommerce's own "never reduced" marker) at every check, consistent with the directly-observed, unchanged stock quantities. In short: the order-level flag is set, but no real inventory was ever reduced - this was verified empirically via stock quantities, not assumed from the flag alone.

## Manual Browser Validation Checklist

**Browser visual validation has not been performed in this scope.** All validation above was done via WooCommerce's PHP APIs and by tracing WooCommerce's own template/query source code, not by viewing rendered pages in a browser. For manual confirmation later:

1. Open `/wp-admin/admin.php?page=wc-orders` - confirm order #49 appears (customer, date, status "Processing", total €31.80).
2. Open `/wp-admin/admin.php?page=wc-orders&action=edit&id=49` - confirm line items, addresses, and all 7 internal notes are visible to an admin.
3. Log in to `/my-account/` as `desknest_test_customer` and open Orders - confirm order #49 appears with status "Processing" and total €31.80.
4. Open the order detail (`/my-account/view-order/49/`) - confirm products, totals, billing/shipping test address, and the customer note are visible, and confirm **no internal admin notes appear**.

## Current Limitations / Deferred Scopes

- **Customer order table/order-detail CSS is not specifically polished yet.** Scope 12's generic `.woocommerce-MyAccount-navigation`/`.woocommerce-MyAccount-content` styling still applies to these pages, but no selectors specific to `.woocommerce-orders-table` or the order-detail line-items table exist. This was not addressed in this scope.
- Payment gateway configuration is not implemented (deferred to **Scope 16**).
- Shipping zone/method configuration is not implemented (deferred to **Scope 17**).
- Reports/analytics, coupons/promotions, and product reviews are not implemented.
- No refund, cancellation, or order-editing workflow was exercised in this scope.
- No real customer ever placed this order through checkout; it was created programmatically for validation purposes only, and this is disclosed rather than implied otherwise.
- No production deployment, CI/CD, Docker, demo credentials, or GitHub Pages/LinkedIn presentation exists or is claimed.

## Files Changed

- `docs/order-management.md`
- `README.md`

No PHP, CSS, JS, theme template, WooCommerce setting, order, customer, product, or stock data was modified to produce this documentation.
