# Payment Configuration

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

## Scope Overview

This document records Scope 16 — Payment Configuration for the DeskNest store: enabling exactly one local-development-safe WooCommerce payment method so the Checkout block has a usable payment option, entirely without real payment credentials, real bank details, or a third-party payment processor. **This scope is completed locally** - no real payment was configured or processed, and no order was placed.

## Objective

Enable a single WooCommerce core payment gateway that is clearly local-development-only, verify it is the only method the Checkout block exposes, and document the result honestly - without touching shipping, taxes, products, orders, or unrelated settings.

## Current Payment Architecture

- WooCommerce ships with three built-in gateways: `bacs` (Direct bank transfer), `cheque` (Check payments), and `cod` (Cash on delivery). These were the only registered gateways before and after this scope.
- No third-party payment plugin (Stripe, PayPal, Mollie, Klarna, WooPayments, or any other processor) is installed. `wp plugin list` confirms WooCommerce is the only active plugin.
- The Checkout page (ID 9, `/checkout/`) uses WooCommerce's modern Checkout block, which derives its available payment methods entirely from WooCommerce's own gateway registry at render time - no custom payment code exists anywhere in this project's theme or plugin files.

## Enabled Payment Gateway

Only WooCommerce core `bacs` is enabled, configured as a clearly local-development-only method:

| Field | Value |
| --- | --- |
| Gateway ID | `bacs` |
| Enabled | `yes` |
| Title | `Banküberweisung (lokale Entwicklung)` |
| Description | `Lokale Entwicklungs-Zahlungsart für DeskNest. Es wird keine echte Zahlung verarbeitet.` |
| Instructions | `Diese Bestellung dient nur zur lokalen WooCommerce-Portfolio-Validierung. Bitte keine echte Überweisung ausführen.` |
| Account details | Empty (no bank account rows configured) |

The title, description, and instructions were chosen deliberately to make it unmistakable - to any reviewer of this portfolio project - that this is not a real payment method and does not process real payments.

## Disabled Payment Gateways

- `cheque` (Check payments) - remains disabled, no settings stored.
- `cod` (Cash on delivery) - remains disabled, no settings stored.

Neither gateway was enabled or configured in this scope.

## Local-Development Safety Notes

- `bacs` is a WooCommerce core gateway that only displays instructions to the customer after checkout; it never contacts an external payment processor and never validates real banking information.
- It does not process real payments under any configuration.
- No real payment integration (Stripe, PayPal, Mollie, Klarna, WooPayments, or any live processor) exists anywhere in this project.

## Credential/Account-Details Policy

- No IBAN, BIC, bank account number, account holder name, or bank name is stored anywhere in the `bacs` settings - `account_details` is an empty array.
- No API keys, client secrets, tokens, passwords, or webhook secrets are stored for `bacs`, `cheque`, or `cod` - a direct read of all three settings options found no sensitive fields of any kind, since `cheque` and `cod` have no stored settings at all and `bacs` only stores the four local-safe fields above.

## Checkout Validation Summary

- `WC()->payment_gateways()->get_available_payment_gateways()` returns exactly **one** gateway: `bacs`.
- The live `/checkout/` page's own server-rendered hydration data (the `wcSettings.paymentMethodSortOrder` / `paymentMethodData` payload the Checkout block's JavaScript uses to render the payment method list) was inspected directly via an HTTP request and confirmed to expose only `bacs`, with the exact configured German title and description - `cheque`, `cod`, and no external processor name (Stripe/PayPal/Mollie/Klarna/WooPayments) appear anywhere in that payload.
- No browser/screenshot tool is available in this environment, so this was validated at the HTTP/markup and Store API data level, not by viewing the rendered page visually in a browser. This is disclosed honestly rather than assumed.
- Shipping is not yet configured (deferred to Scope 17), so the cart used for this validation reported `needs_shipping: false` / no shipping rates - expected, and not addressed in this scope.

## Order Safety Summary

- No order was created or placed during Scope 16 validation. The local order count remained exactly **1** throughout (order #49 only).
- A temporary guest cart session (via WooCommerce's Store API, not a real browser) was created only to inspect the rendered Checkout block's payment data, with exactly one item added and then removed again; checkout was never submitted.
- Existing local order #49 remains completely unchanged: status `processing`, total `31.80`, customer email `desknest.customer@example.test`, payment method `local_dev`, payment method title "Local development order - no payment processed".
- `local_dev` is an arbitrary historical string stored on order #49 from when it was created programmatically (see [Order Management](order-management.md) / Scope 13) - it is **not** a registered WooCommerce payment gateway and was not affected by this scope's `bacs` configuration.

## What Was Intentionally Not Done

- No real payment processor (Stripe, PayPal, Mollie, Klarna, WooPayments, or any other) was integrated.
- No real bank account details, API keys, secrets, tokens, or webhooks were configured or stored.
- No order was placed to test a full, real end-to-end payment flow.
- `cheque` and `cod` were left disabled - only one payment method is active, by design.
- Shipping was not configured - `bacs` is enabled, but a complete guided checkout (cart → shipping → payment → order) is not yet possible until Scope 17 adds a shipping zone/method.

## Scope Boundaries

The following are explicitly **not** implemented by Scope 16 and remain future, separately approved scopes:

- Shipping configuration (deferred to Scope 17).
- Taxes.
- Reports/analytics.
- Security hardening.
- Performance optimization.
- Final UI polish.
- Full end-to-end order/payment QA (blocked on shipping being configured first).
- GitHub documentation, portfolio presentation, GitHub Pages, LinkedIn preview.

## Validation Checklist

- [x] `bacs` enabled with the exact local-safe title/description/instructions above.
- [x] `cheque` and `cod` confirmed still disabled.
- [x] No account details, IBAN, BIC, or bank credentials stored.
- [x] No API keys/secrets/tokens/webhooks stored anywhere in payment settings.
- [x] No third-party payment plugin installed.
- [x] `get_available_payment_gateways()` returns exactly one gateway: `bacs`.
- [x] Checkout block's own rendered hydration data confirmed to expose only `bacs`.
- [x] No order placed; local order count remained at 1 throughout.
- [x] Order #49 confirmed unchanged (status, total, email, payment method, payment method title).
- [x] `local_dev` confirmed to not be a registered gateway.
- [ ] Full end-to-end checkout/order validation with a real shipping method selected - deferred until Scope 17.

## Next Scope Note

Scope 17 — Shipping Configuration will add at least one local-safe shipping zone/method, after which a complete guided checkout (cart → shipping → `bacs` payment → order) can be meaningfully validated end-to-end for the first time in this project.
