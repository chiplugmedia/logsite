# PHP to React Migration Audit

## Current Architecture

- Root PHP files render public pages and auth forms directly.
- `actions/` contains procedural form handlers for auth, verification, coupons, and contact flows.
- `dash/` contains the user dashboard, page rendering, session checks, wallet/product/payment handlers, and bundled dashboard assets.
- `admin/` and `assistant/` are largely duplicated control-panel implementations with many identical assets and actions.
- `includes/` contains shared database/session/bootstrap helpers, mail helpers, settings reads, purchase logic, and utility functions.
- `proc/` contains product AJAX/API-like handlers.
- `young/`, `admin/assets/`, `assistant/assets/`, and `dash/assets/` contain large copied template/vendor/static bundles.

## Converted Modules

- Auth: login, signup, forgot password, reset password, session, logout.
- User dashboard summary: balances, counts, recent orders, recent funding, bank snapshot.

## Deleted Files

These were removed because they are runtime logs, backup archives, or stale backup code and are not included by application flows:

- `admin/error_log`
- `assistant/error_log`
- `dash/error_log`
- `error_log`
- `dash/actions/flutterwave/error_log`
- `dash/actions/error_log`
- `admin/actions/error_log`
- `dash/actions/nomba/error_log`
- `includes/error_log`
- `proc/error_log`
- `young/imag/Notice.zip`
- `mainyou/maintenance.php.zip`
- `actions/formprocess.php8`

## Cleanup Candidates Not Deleted Yet

- `assistant/` duplicates much of `admin/`; delete only after assistant role requirements are confirmed or merged into one role-aware admin API.
- `assistant/assets/` and `admin/assets/` contain duplicate product/course images, fonts, CSS, and JS.
- `admin/inc/server.php` and `assistant/inc/server.php` use old `md5` auth patterns and direct SQL interpolation. They should be retired after admin/assistant auth is migrated.
- `young/youn/assets`, `young/css`, `dash/assets/vendor`, `admin/assets`, and `assistant/assets` include repeated template assets. These should be replaced by the React build and a single public media folder.
- Legacy rendered pages such as `login.php`, `signup.php`, `forgot-password.php`, and `reset-password.php` should stay until the React auth routes are live in production.

## Security Issues Found

- Hardcoded DB/SMTP credentials in legacy config and mail files.
- Mixed rendering and mutation logic in the same PHP files.
- Many POST handlers lack CSRF protection.
- Several old admin/assistant server files use `md5` and direct interpolated SQL.
- Payment and purchase flows need transaction boundaries and callback signature verification audits.
- User-provided file uploads need stricter MIME/type/size validation and safer filenames.

## Safe Migration Strategy

1. Convert one module into JSON APIs.
2. Build the matching React route.
3. Verify API response, React build, and role/session behavior.
4. Keep old PHP pages until the new module is production-live.
5. Delete old rendered PHP/module assets only after route parity is confirmed.
