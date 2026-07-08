# Security & Hardening

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
- Scope 18: Reports & Analytics - completed
- Scope 19: Security & Hardening - completed

## Scope Overview

Scope 19 reviews the DeskNest local development environment for basic, low-risk WordPress/WooCommerce hardening, applies a small set of safe configuration changes, and documents everything else that was deliberately left unchanged with reasoning. **This scope is completed locally.** It does not claim, add, or simulate production-grade security.

## Local Development Context

This project runs entirely on LocalWP, served over plain HTTP at `woocommerce-store-wordpress.local`, with no public internet exposure, no real customer traffic, and no real payment or shipping credentials anywhere (see [Payment Configuration](payment-configuration.md) and [Shipping Configuration](shipping-configuration.md)). Hardening decisions below are made with that context in mind - some standard production hardening steps are either inapplicable or actively harmful to this local workflow, and are documented as such rather than blindly applied.

## Baseline Findings (Step 1)

Confirmed via read-only WP-CLI/database inspection before any change:

| Item | Baseline value |
| --- | --- |
| WordPress | 7.0 |
| WooCommerce | 10.9.3, active |
| Active theme | `desknest` v0.1.0 |
| Active plugins | WooCommerce only |
| `WP_DEBUG` | `false` |
| `WP_DEBUG_DISPLAY` | `true` (inert, since `WP_DEBUG` was `false`) |
| `WP_DEBUG_LOG` | `false` |
| `SCRIPT_DEBUG` | `false` |
| `DISALLOW_FILE_EDIT` | not defined |
| `DISALLOW_FILE_MODS` | not defined |
| `FORCE_SSL_ADMIN` | `false` |
| Table prefix | `wp_` (default) |
| Auth salts/keys | present, real (not placeholder) values |
| `debug.log` | did not exist |
| `.env`/`.sql`/`.zip`/archive/`phpinfo.php` files in web root | none found |
| Administrator accounts | 1 |
| Secrets in tracked files | none found |

## Hardening Changes Actually Applied

Exactly two constants were added to `app/public/wp-config.php`, in the file's existing "custom values" section (between the WordPress-recommended `/* Add any custom values... */` marker and the `WP_DEBUG` block), with all existing database credentials, salts, table prefix, and other constants left completely untouched:

```php
define( 'DISALLOW_FILE_EDIT', true );
define( 'WP_DEBUG_DISPLAY', false );
```

- **`DISALLOW_FILE_EDIT = true`** - disables the wp-admin "Theme Editor" / "Plugin Editor" screens, which allow live-editing PHP files directly from the browser. This project has never used those screens (all theme work has gone through direct file edits via the development toolchain), so this closes an unused, real code-execution surface with zero workflow impact.
- **`WP_DEBUG_DISPLAY = false`** (explicit) - previously relied on WordPress core's own default of `true`, which only matters if `WP_DEBUG` is ever turned on. Setting it explicitly to `false` now means that even if `WP_DEBUG` is temporarily enabled for a future debugging session and left on, raw PHP errors/warnings will never be printed directly on-screen. Zero behavioral change today; closes a latent future risk.

Both changes were verified via WP-CLI (`wp eval`) to be correctly in effect after editing, and a PHP syntax check (`php -l wp-config.php`) confirmed the file remained valid before considering the change complete.

## Items Deliberately Not Applied, and Why

- **`DISALLOW_FILE_MODS` was not enabled.** This constant also blocks installing/updating plugins and themes from wp-admin, not just editing them. Since future scopes or ad-hoc local testing might benefit from installing something quickly via wp-admin, this broader restriction was left as a documented option rather than silently applied.
- **`FORCE_SSL_ADMIN` was not enabled.** The LocalWP site is served over plain HTTP with no local HTTPS configured. Forcing SSL-only admin access would immediately lock out `wp-admin` in this environment - this is an environment mismatch, not a real vulnerability, and would only make sense if local HTTPS were separately and intentionally configured.
- **The database table prefix (`wp_`) was not changed.** Migrating it this late in an 18-scope project would require renaming every WordPress/WooCommerce table and updating serialized references - a nontrivial, error-prone operation for a security benefit that modern WordPress security guidance considers largely obscurity-only, not a real defense against SQL injection or other attacks.
- **No security plugin was added.** Security plugins (firewalls, malware scanners, brute-force login protection) are designed for internet-facing sites under real traffic. This is a local-only `.local` domain site with no public exposure - there is nothing for such a plugin to meaningfully protect against here, and adding one would introduce unnecessary complexity to a portfolio project.
- **Inactive bundled default themes (`twentytwentyfive`, `twentytwentyfour`, `twentytwentythree`) were not removed.** They are official, unmodified WordPress.org themes that are inactive and not routable - not a functional attack surface on a local site. Removing them is optional tidiness, not a security requirement.

## Positive Findings (Already Correct, No Action Needed)

- Exactly one administrator account exists, with no unexpected additional admin users.
- No `debug.log` file existed before or after this scope.
- No exposed database dumps, archives, `.env` files, or `phpinfo.php` were found anywhere in the web root.
- No real secrets, API keys, tokens, or credentials were found in any Git-tracked project file.
- `bacs` (the only enabled payment method) has empty `account_details` - no real bank information is stored.
- No external payment processor, carrier integration, or third-party analytics/tracking service exists anywhere in this project.
- Real, non-placeholder authentication salts/keys were already in use (not the insecure WordPress.org default placeholder text).

## Honest Limitations

- **This is not production-grade security.** It is a local-development-appropriate baseline review and two small, safe hardening additions - nothing more.
- No Web Application Firewall (WAF), CDN, rate limiting, malware scanning, real SSL/TLS, or server-level hardening has been configured anywhere.
- No live deployment, public hosting, or production traffic exists for this project. Any of the above would need to be revisited and reconsidered before a real production deployment - this scope makes no claim that the current configuration would be sufficient for one.
- `DISALLOW_FILE_MODS`, real SSL enforcement, and table-prefix migration remain deliberately unimplemented, as explained above, and would need separate consideration if this project's threat model ever changes (e.g., a real public deployment).

## Validation Summary

Based only on commands actually run in this scope:

- `php -l app/public/wp-config.php` - passed, no syntax errors.
- `wp core version` - WordPress still boots correctly (`7.0`) after the config change.
- Confirmed via `wp eval`: `WP_DEBUG = false`, `WP_DEBUG_DISPLAY = false`, `DISALLOW_FILE_EDIT = true`, `DISALLOW_FILE_MODS` still not defined, `FORCE_SSL_ADMIN = false` - all exactly as intended.
- WooCommerce regression checks after the change: WooCommerce still active at version `10.9.3`; active theme still `desknest`; order count still `1`; order #49 still `processing` at `€31.80`; product count still `24`; variation count still `11`; review count still `7`; all four coupon usage counts still `0`; `bacs` still the only enabled payment gateway with empty account details; the `Deutschland` shipping zone still has its 2 methods; HPOS still enabled with compatibility mode still off.
- No database records, products, orders, coupons, reviews, customers, payment settings, or shipping settings were modified - only `app/public/wp-config.php` (two added constants) plus this documentation and the README update.
- A pre-edit backup of `wp-config.php` was created at `app/public/wp-config.scope19-before-hardening.local-backup.php` (gitignored, not committed) before any change was made, as a rollback safeguard.

## Files Changed

- `app/public/wp-config.php` (not tracked by Git - gitignored; changed on disk only)
- `docs/security-hardening.md`
- `README.md`

No WordPress core files, plugins, products, orders, coupons, reviews, customers, payment settings, or shipping settings were modified to produce this documentation.
