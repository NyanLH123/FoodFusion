# FoodFusion (Custom PHP MVC)

FoodFusion is a pure PHP 8.x MVC culinary community platform built for NCC Education Back End Web Development [2183-1].

## Tech Stack
- PHP 8.x (no external framework)
- MySQL (PDO prepared statements)
- Bootstrap 5 + Bootstrap Icons (CDN)
- Vanilla JavaScript + AJAX

## Project Root
`D:/xampp/htdocs/Projects/test_foodfusion`

## URL
`http://localhost/Projects/test_foodfusion/public/`

## Setup Instructions (XAMPP)
1. Start Apache and MySQL in XAMPP.
2. Create database and import schema:
   - `mysql -u root -p < database/schema.sql`
3. Confirm DB credentials in `config/database.php`.
4. Ensure Apache `mod_rewrite` is enabled.
5. Visit `http://localhost/Projects/test_foodfusion/public/`.

## Default Accounts (Seed)
- Admin: `admin@foodfusion.local` / `Admin@123!`
- User: `mia@example.com` / `<!-- User@123! -->`
- User: `daniel@example.com` / `User@123!`

## Upload Permissions
Ensure these folders are writable by Apache/PHP:
- `public/uploads/images/`
- `public/uploads/videos/`
- `public/uploads/pdfs/`

## Routing
Routing is handled by:
- `public/index.php`
- `config/routes.php`
- `app/core/Router.php`

Uses explicit route mappings in `config/routes.php`.

## Security Notes
- Passwords hashed with `password_hash(..., PASSWORD_BCRYPT)`
- Login lockout after 3 failed attempts for 3 minutes
- PDO prepared statements for all DB operations
- Output escaped in views with `htmlspecialchars()`
- File uploads validated with `finfo_file()` MIME checks
- Session handling centralized in `app/core/Session.php`

## Theme Assets
- SASS source: `public/css/theme.scss`
- Compiled CSS: `public/css/theme.css`

## JavaScript Files
- `public/js/main.js`: join-us AJAX, cookbook AJAX, share, popup timer, filter auto-submit
- `public/js/cookie.js`: cookie consent banner behavior
- `public/js/admin.js`: admin confirmation helpers

 

## Cookie Consent
- Banner is shown when `ff_cookie_consent` is not present.
- Consent cookie is written with `SameSite=Lax` and root path scope (`/`) using key `ff_cookie_consent` for reliable behavior across entry and subpages.
- For testing, clear `ff_cookie_consent` in your browser for `http://localhost` and reload the entry URL (`/Projects/test_foodfusion/public/`).

## Database Updates
- `interactions` now has `UNIQUE KEY uq_interactions_post_user_type (postId, userId, type)` to prevent duplicate like/share rows.
- New table: `contact_replies` for admin in-app replies visible in user contact inbox.


