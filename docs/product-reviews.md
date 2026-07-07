# Product Reviews

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

## Scope Overview

This document records Scope 15 — Product Reviews for the DeskNest store: validating realistic WooCommerce product review behavior (star ratings, verified-owner detection, review display, and the review submission form) entirely in local development. **This scope is completed locally** - no real payments, real shipments, or real customer data were used at any point.

## Baseline Settings (Preserved, Not Changed)

The existing WooCommerce/WordPress review settings were already correctly configured for this scope's purpose, so none were changed:

| Setting | Value |
| --- | --- |
| `woocommerce_enable_reviews` | `yes` |
| `woocommerce_enable_review_rating` | `yes` |
| `woocommerce_review_rating_required` | `yes` |
| `woocommerce_review_rating_verification_required` | `no` |
| `woocommerce_review_rating_verification_label` | `yes` |
| `comment_moderation` | `0` |
| `comment_registration` | `0` |

Leaving `woocommerce_review_rating_verification_required` at `no` is what makes an honest, mixed verified/non-verified review dataset possible - requiring verified purchases only would have made 5 of the 7 seeded reviews impossible without fabricating orders.

## Review Data Seeded

Exactly 7 local-safe reviews were seeded (no more, no fewer):

| Product | Reviewer | Rating | Verified owner |
| --- | --- | --- | --- |
| DN-PRD-005 / Magnetic Notepad and Stylus Holder | desknest.customer@example.test | 5 | Yes |
| DN-PRD-004 / Analog Desk Timer for Focused Work Sessions | desknest.customer@example.test | 4 | Yes |
| DN-ERG-003 / Ergonomic Footrest, Adjustable Height & Tilt | lena.m@example.test | 5 | No |
| DN-LIT-002 / Compact LED Desk Lamp, Adjustable Color Temperature | jonas.b@example.test | 4 | No |
| DN-CAB-002 / Reusable Cable Clip Set (12-Piece) | sophie.r@example.test | 3 | No |
| DN-BND-001 / DeskNest Starter Workspace Bundle | markus.t@example.test | 5 | No |
| DN-ERG-001 / Adjustable Aluminum Laptop Stand | anna.w@example.test | 5 | No |

All non-verified reviewer identities use the `example.test` reserved test domain (RFC 2606), consistent with the existing `desknest.customer@example.test` convention already used elsewhere in this project.

## Verified-Owner Honesty

- **Only** DN-PRD-005 and DN-PRD-004 are marked verified owner.
- They are verified because local order #49 (from [Order Management](order-management.md) / Scope 13) genuinely contains both products and belongs to customer user ID 2 / `desknest.customer@example.test`.
- **No verified-owner status was fabricated** for any of the other 5 products - none of them appear in order #49 or any other order.
- **No new order was created** to produce this review data. The verified-owner determination was made entirely by WooCommerce's own purchase-history logic (see below), not by manually setting a flag.

## WooCommerce Technical Notes

Confirmed directly against the installed WooCommerce 10.9.3 source rather than assumed:

- Reviews are stored as standard WordPress comments with `comment_type = 'review'`.
- The rating value is stored under comment meta key **`rating`** (confirmed in `class-wc-comments.php`) - not `_wc_review_rating`.
- Verified-owner status is stored under comment meta key **`verified`**, and its value is determined by calling WooCommerce's own `wc_customer_bought_product( $email, $user_id, $product_id )` function - the same function WooCommerce itself uses when a real review is submitted through the front-end. This function checks orders in a "paid" status (`processing` or `completed`); order #49 is `processing`, so it correctly qualifies.
- Rating aggregates (average rating, review count, per-rating counts) were recalculated using WooCommerce's own authoritative method, `WC_Comments::clear_transients( $product_id )`, called once per affected product after seeding - the same mechanism WooCommerce uses internally to keep these numbers in sync.

## UI Styling

Review UI styling was added to `app/public/wp-content/themes/desknest/style.css`, scoped under `body.single-product` so no other page type is affected. Coverage includes:

- The product rating summary near the product title (WooCommerce's modern `product-rating` block).
- The Reviews tab container, styled as a card consistent with the rest of the DeskNest design language.
- Individual review cards (avatar, author, date, review text).
- Star rating color (both the summary block and the classic per-review stars).
- A verified-owner badge, styled as a small, understated pill rather than a loud banner.
- The empty-review state (`.woocommerce-noreviews`), kept visible with an intentional-looking dashed-border treatment rather than hidden.
- The review submission form (labels, inputs, textarea, select, and the submit button), including visible focus outlines on every field for accessibility.
- Mobile responsiveness at the existing 600px/480px breakpoints, stacking each review's avatar and text vertically on narrow screens.

The product page itself was discovered to use a hybrid structure: the rating summary near the title is a modern WooCommerce block, while the Reviews tab content (list and form) is classic WooCommerce template output. Both were styled correctly based on real, verified markup - no selector was guessed.

## Validation Summary

- 7 reviews exist in the database after seeding (confirmed via direct query, not estimated).
- The verified-owner badge appears **only** on the two reviews tied to order #49; it is confirmed absent on all 5 non-verified reviews.
- The 3-star non-verified review (DN-CAB-002) renders correctly with its rating and text, and no verified badge.
- The empty-review state ("There are no reviews yet.") renders correctly on a product with no seeded review (DN-ORG-002).
- The review submission form renders on all tested product pages.
- HTTP checks confirmed all tested product pages return 200, the theme stylesheet loads, and the served CSS content matches what's on disk. This automated validation was performed directly against the local site (via WP-CLI and direct page fetches), not by viewing rendered pages in a browser.
- **Manual visual review was performed separately, using screenshots the user captured and shared.** No browser automation or screenshot-capture tool is available in the automated tooling's own environment, so this visual pass was done by the user reviewing the live site directly and sharing screenshots for review, rather than by the automated checks above. Coverage:
  - Product 33 (DN-PRD-005): desktop and mobile Reviews tab reviewed - the verified-owner review card, verified-owner badge (visible, not visually excessive), star rating, and review form were all confirmed usable and free of obvious horizontal overflow.
  - Product 26 (DN-CAB-002): desktop and mobile Reviews tab reviewed - the 3-star non-verified review, the confirmed absence of any verified-owner badge, and the review form were all confirmed usable and free of obvious horizontal overflow.
  - Product 18 (DN-ORG-002): **mobile** Reviews tab reviewed - the empty-review state and review form were confirmed visible and usable, free of obvious horizontal overflow. **A desktop screenshot of Product 18's Reviews tab was not captured**, so the desktop empty-state appearance is not confirmed by screenshot; only its mobile appearance is.
  - No screenshots were committed to this repository - they were shared for review only.
- This visual review confirms the styled reviews UI renders and behaves as intended for the scenarios above; it does not constitute a full QA pass or final UI polish sign-off, and other screen sizes, browsers, and edge cases (e.g., very long review text, many reviews on one product) remain unverified.
- No real payment, no real shipment, and no real customer data were used anywhere in this scope.

## Side-Effect Summary

- Order #49 is unchanged (`status: processing`, same 7 notes, same total).
- Coupon `usage_count` remained `0` throughout for all four Scope 14 coupons: `newdesk10`, `ergo15`, `bundlesave`, `summersale`.
- Product stock quantities and statuses are unchanged for all 7 reviewed products.
- Payment gateways remain disabled.
- Shipping zones remain at 0.
- No real, paid orders were created at any point in this scope.

## Scope Boundaries / Not Implemented

The following are explicitly **not** implemented by Scope 15 and remain future, separately approved scopes:

- Payment configuration (deferred to Scope 16).
- Shipping configuration (deferred to Scope 17).
- Reports/analytics.
- Security hardening.
- Performance optimization.
- Final UI polish.
- Full testing/QA review.
- GitHub documentation.
- Portfolio presentation.
- GitHub Pages.
- LinkedIn preview optimization.

## Files Changed

- `app/public/wp-content/themes/desknest/style.css`
- `docs/product-reviews.md`
- `README.md`

No WooCommerce settings, orders, coupons, products, stock, users, or comments/reviews were modified to produce this documentation.
