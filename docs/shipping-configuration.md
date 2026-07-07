# Shipping Configuration

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
- Scope 15: Product Reviews - completed
- Scope 16: Payment Configuration - completed
- Scope 17: Shipping Configuration - completed

## 1. Scope Summary

Scope 17 configured local-development-safe WooCommerce shipping for the DeskNest Germany-first store: one shipping zone covering Germany, with a flat-rate method and a free-shipping-above-threshold method, entirely using WooCommerce's own native shipping zone/method APIs. **This is a portfolio/local development configuration, not live fulfilment** - no real carrier, no real rates, and no real shipment has ever been created.

## 2. Shipping Architecture

| Item | Value |
| --- | --- |
| Zone name | `Deutschland` |
| Country/location | `DE` (type: country) |
| Flat rate method | `Standardversand Deutschland` |
| Flat rate cost | `€4.90` |
| Free shipping method | `Kostenloser Versand ab 75 €` |
| Free shipping threshold | `€75` (requires: minimum order amount) |
| Shipping destination option | Shipping address (`woocommerce_ship_to_destination = shipping`) |
| Default zone ("Locations not covered by your other zones") | 0 methods |
| Shipping classes | Not used in this scope |

## 3. WooCommerce Settings Applied

| Option | Value |
| --- | --- |
| `woocommerce_ship_to_destination` | `shipping` (changed from `billing`) |
| `woocommerce_enable_shipping_calc` | `yes` (unchanged) |
| `woocommerce_shipping_debug_mode` | `no` (unchanged) |

The store continues to sell only to Germany, per the pre-existing foundation settings from earlier scopes (`woocommerce_allowed_countries = specific`, `woocommerce_specific_allowed_countries = ['DE']`), which is why a single Germany-only zone is sufficient - no multi-country zone logic was needed. Currency remains `EUR`, unchanged.

## 4. Validation Summary

All validation was performed using WooCommerce's own native shipping APIs, without placing an order or submitting checkout:

- A package with destination country `DE` correctly matched the `Deutschland` zone (zone ID 1).
- A package with a non-`DE` destination country correctly fell back to the default zone, which still has 0 shipping methods.
- A below-threshold scenario using a cart total of `€31.80` (matching existing local order #49's total) correctly exposed only the flat-rate method at `€4.90` - free shipping did not appear.
- The at/above-threshold (`€75`+) behavior was validated through WooCommerce's own free-shipping method settings and its confirmed source-code logic (`$total >= $this->min_amount`), rather than through a persisted live cart, since WooCommerce's `is_available()` check for free shipping reads the live cart object directly and adding items to reach a real €75+ cart would have required a cart/session mutation. This is disclosed honestly as a deliberate methodology choice to avoid unnecessary database side effects, not a gap in coverage - the settings-based check applies the exact same comparison rule WooCommerce's own code performs.
- WooCommerce core allows the flat-rate and free-shipping methods to coexist above the threshold - free shipping becoming available does not automatically hide flat rate, and no such override was configured in this scope.
- The Cart page (`woocommerce/cart` block) and Checkout page (`woocommerce/checkout` block) were both confirmed intact and unmodified.
- No checkout was submitted and no order was created at any point in this scope.
- All non-shipping data (products, orders, coupons, payment gateways) remained unchanged throughout validation.
- The `wp_woocommerce_sessions` table's existing row count (20 rows, pre-dating this scope from earlier cart/checkout validation work) stayed exactly the same throughout Scope 17's validation - confirmed stable across repeated reads, proving the validation approach introduced no new session rows.

## 5. Local Development Safety

- No real shipping carrier integration of any kind.
- No real shipping labels are generated or purchased.
- No DHL, UPS, DPD, Hermes, or Deutsche Post account exists or is referenced.
- No API credentials, secrets, tokens, or webhooks are stored anywhere for shipping.
- No real fulfilment workflow exists - shipping methods only calculate a displayed cost, they do not trigger any external process.
- No shipping classes or product-level freight logic have been configured yet.

## 6. Scope Boundaries

The following are explicitly **not** implemented by Scope 17 and remain future, separately approved work if ever needed:

- No local pickup method.
- No shipping classes.
- No product-level shipping rules (weight/dimension-based rates, per-class costs).
- No international shipping (store remains Germany-only, consistent with existing foundation settings).
- No real carrier rates or rate-shopping.
- No tracking numbers or shipment tracking.
- No tax redesign - tax settings were left exactly as they were before this scope, aside from the flat-rate method's own default `tax_status` field.
- No checkout order placement.
- No payment gateway changes - `bacs` configuration from Scope 16 is untouched.

## 7. Regression Safety

- Order #49 is unchanged: status `processing`, total `31.80`, payment method `local_dev`.
- Local order count remained at exactly 1 throughout.
- Coupon `usage_count` remained `0` for all four Scope 14 coupons (`newdesk10`, `ergo15`, `bundlesave`, `summersale`).
- Product count (24) and variation count (11) are unchanged.
- `bacs` remained the only enabled payment gateway; `cheque` and `cod` remained disabled.
- No carrier or payment plugins were installed - WooCommerce remains the only active plugin.

## 8. Future Scope Notes

A future scope may exercise a broader end-to-end checkout/order workflow now that both a payment method (Scope 16) and a shipping method (Scope 17) exist - for example, a full guided cart → shipping selection → `bacs` payment → order placement test. That full workflow is intentionally **not** implemented or tested in this scope.
