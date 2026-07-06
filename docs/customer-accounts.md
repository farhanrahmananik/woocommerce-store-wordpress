# Customer Accounts

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

## Scope Overview

This document records Scope 12 — Customer Accounts for the DeskNest store: enabling and validating WooCommerce's customer registration/login/account-dashboard experience under the active `desknest` theme, adding a header navigation entry, and styling the classic account output so it feels consistent with the Cart/Checkout work from Scopes 10–11. This is a **settings-enablement, navigation, and CSS/styling scope**, not an order-management, payments, or shipping implementation.

## Account Architecture Decision

- **My Account page ID is 10** (URL `/my-account/`), using WooCommerce's **classic `[woocommerce_my_account]` shortcode** - not a block.
- WooCommerce 10.9.3 provides modern blocks for Cart and Checkout, but the account dashboard endpoints (Orders, Downloads, Addresses, Account details, login/register) remain classic PHP-template-rendered; there is no block-based dashboard replacement to migrate to in this WooCommerce version.
- WooCommerce's `woocommerce/customer-account` block was inspected directly in its source before being ruled out: it is an icon/login-state-aware navigation link block (auto-hookable next to the header navigation, similar to the cart-link block), not a dashboard replacement, and its visible label is hardcoded to "Login"/"My Account" depending on auth state with no attribute to set a custom label such as "Account." A plain navigation link was used instead so the header could read "Account" consistently with "Shop" and "Cart."
- No Account page database content was edited. Every change in this scope lives in theme files (`desknest`), not in the My Account page's stored post content.

## WooCommerce Settings

| Setting | Value | Change |
| --- | --- | --- |
| `woocommerce_enable_myaccount_registration` | `yes` | Changed from `no` - the only setting change made in this scope |
| `woocommerce_enable_signup_and_login_from_checkout` | `no` | Left unchanged, to avoid altering the Scope 11-validated Checkout form |
| `woocommerce_enable_checkout_login_reminder` | `no` | Left unchanged, same reason |
| `woocommerce_enable_guest_checkout` | `yes` | Left unchanged |
| `woocommerce_registration_generate_username` | `yes` | Left unchanged |
| `woocommerce_registration_generate_password` | `yes` | Left unchanged |

Isolating the change to a single setting kept Checkout's behavior byte-for-byte the same as it was at the end of Scope 11.

## Test Customer Strategy

One local test customer was created via WP-CLI (not through the front-end form) so the account dashboard, Orders, Downloads, Addresses, and Account details endpoints could be reached and validated without depending on email delivery:

- Username: `desknest_test_customer`
- Email: `desknest.customer@example.test`
- Role: `customer`

The password is intentionally not documented here or anywhere else in the repository. The front-end registration form itself was also exercised once (after enabling the setting) purely to confirm the registration UI renders and behaves correctly.

## Header Navigation Integration

- A plain `Account` navigation link (`/my-account/`) was added to `app/public/wp-content/themes/desknest/parts/header.html`, alongside the existing `Shop` and `Cart` links added in earlier scopes.
- Header navigation now reads: **Shop, Cart, Account**.
- The footer was intentionally **not** changed in this scope - Cart received a footer link in Scope 10 because it's a frequent, transactional destination; Account was judged lower-frequency and not necessary for a functional portfolio demo.

## Styling Summary

All account-specific styling is scoped under `body.woocommerce-account` in `style.css`, using WooCommerce's own real classic template class names (verified directly against WooCommerce's PHP templates and classic frontend CSS rather than guessed), following the same card/surface/border/radius/button visual language established for Cart and Checkout:

- **Logged-out login/register**: card treatment on the two-column login/register layout, consistent form-row spacing, and a visible focus outline (using the theme's accent color) added to account form inputs for accessibility - a new addition not previously present anywhere else in the theme.
- **My Account navigation**: sidebar card treatment with per-link padding and a clear active-tab highlight.
- **Dashboard/content spacing**: conservative spacing on the content pane, deliberately without its own card background, to avoid a "double-card" look on pages whose children (like Addresses) already have their own cards.
- **Orders/Downloads empty states**: spacing around WooCommerce's own notice-banner element - message text, color, and visibility are untouched.
- **Address cards**: the billing/shipping columns share the same card treatment as login/register (they use the same underlying WooCommerce classes).
- **Account details form and password-change fieldset**: the fieldset (unstyled by WooCommerce by default) was given an explicit card border/padding; a mobile input-width/alignment issue was found during manual visual review and fixed through targeted, narrowly-scoped CSS under `body.woocommerce-account .woocommerce-EditAccountForm` addressing the fieldset's box model and per-row box-sizing consistency.
- **Mobile stacking**: navigation/content, address columns, and name-field pairs all stack to full width under the existing 600px/480px breakpoints, reusing the same technique already used for Checkout's address fields in Scope 11.

CSS lives in `app/public/wp-content/themes/desknest/style.css`; the navigation link lives in `app/public/wp-content/themes/desknest/parts/header.html`.

## Validation Summary

The following was functionally validated using real WooCommerce sessions/nonces (not simulated):

| Check | Result |
| --- | --- |
| Anonymous `/my-account/` | HTTP 200, login form present |
| Registration form | Present after enabling `woocommerce_enable_myaccount_registration` |
| Anonymous dashboard visibility | Not visible to logged-out visitors |
| Test customer login | Succeeded with a real WooCommerce nonce/session |
| Dashboard | Loaded correctly |
| Orders endpoint | Loaded, correct empty state (order count is 0) |
| Downloads endpoint | Loaded, correct empty state |
| Addresses endpoint | Loaded |
| Account details endpoint | Loaded |
| Logout | Worked; returned to the logged-out login/register view |
| Account details form saved | Never - form was never submitted |
| Addresses saved | Never - form was never submitted |
| Orders created | None, at any point in this scope |
| Regression: Home/Shop/Cart | HTTP 200 |
| Regression: empty-cart `/checkout/` | Still redirects 302 to `/cart/` |
| Regression: Checkout account settings | Unchanged from Scope 11 |

## Visual Validation Summary

Manual browser review (desktop and mobile) covered: the logged-out My Account screen, the logged-in dashboard, Orders, Downloads, Addresses, and Account details. A mobile-width issue was found on Account Details (input box widths/alignment inconsistent between the name fields and the display name/email/password fields) and was fixed through several rounds of targeted, narrowly-scoped CSS refinement; a final mobile recheck of Account Details passed. **No screenshots are committed to this repository** - visual validation was performed by manual browser review only, and no screenshot files were added to the project.

## Scope Boundaries / Not Implemented

The following are explicitly **not** implemented by Scope 12 and remain future, separately approved scopes:

- Order management/history beyond the empty-state view is not implemented (there are no orders to manage).
- Payment methods management (the "Payment methods" account endpoint) was not specifically exercised beyond confirming it renders; no payment gateway is configured (deferred to Scope 16).
- Shipping is not configured (deferred to Scope 17).
- Coupons/promotions are not implemented.
- Product reviews are not implemented.
- No account-related emails (registration/password-reset) were verified for delivery/content in this scope.
- No production deployment exists; this scope was validated entirely on the local LocalWP environment.

## Files Changed

- `app/public/wp-content/themes/desknest/parts/header.html`
- `app/public/wp-content/themes/desknest/style.css`
- `docs/customer-accounts.md`
- `README.md`

## Known Limitations / Deferred Work

- Registration is enabled store-wide on the My Account page as a real, live setting - not a simulation - for the local development environment. Whether to keep it enabled, disable it, or gate it further is a decision for a later, separately-scoped step if this project moves toward any public-facing presentation.
- The password-generation defaults (`generate_username`/`generate_password` both `yes`) mean the registration form only asks for an email address; this was validated but not reconsidered as a UX choice.
- Account styling in this scope is spacing/layout-level only; it has not been visually validated across every possible state (e.g., a populated Orders history, a saved address, a validation-error state on Account details).
- **No order was ever created, no payment was configured, and no production deployment exists.** This scope covers settings enablement, navigation, styling, and validation of the customer account experience as it exists today, with payments and shipping intentionally deferred to Scopes 16 and 17.
