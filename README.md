# Appfront

Prototype product catalog page

## Quick Developer Install

Production install requires additional steps, such as editing `.env`
Tested with

- Mac OS v15
- PHP v8.4
- Node v22.14

```shell
cd ~/appfront   # else what you named your unpacked path
composer install
npm install
php artisan migrate --seed
composer run dev
```

## Tests

### Clean Tests

- `composer audit`
- `composer check-platform-reqs`
- `composer validate`
- `npm audit`
- `npm doctor`
- `php artisan test` # trivial

### Fixing Failed Tests

- Code proved resilient against updating composer libs
- `composer diagnose` # by deleting composer.lock
- `composer outdated` # manual update phpunit, but not `brick/math`

# Security Fixes

- Fixed invalid syntax in robots.txt . No SEO requirements given
- Added security.txt
- Added .env to .gitignore
- Replaced all calls to `env()` in resources to `secure_asset()`. Other env() to config()
- Switch to Request classes for validation
- Replace $request->all() with safe()
- Simplified Request validation
- Fuller coverage of Request validation
- Prevented spelljacking
- Replaced potential file injection

# Architecture Choices

- Input validation shared in model. Leaving existing validation in place.
- Ensure all blade variables are null-safe
- Fully adopted vite
- Restricted public access on attributes
- Added email test
- Replaced email build() with tighter cohesive email methods
- Modern code
  - PHP 8 constructors
  - PHP 8.4 compatibility (& backwards)

# Bug Fixes

- Removed unused code throughout
- Added type hints
- show.blade: made HTML valid with A11Y via missing `alt` attribute
- login.blade: disabled unused CSS
- Wrote clean code to inject variables into email blade
- Improved email clients compatibility
- Replaced legacy HTML attributes

## Bugs not Fixing. *Not* doing:

- Dead *Add to Cart* button
- Assume prefilled login credentials are intentional
- MFA nor captcha nor rate limiting
- Enforcing special password chars
- Further restrict allowed input characters throughout
- UUIDs for product IDs
- Limit input, e.g. $1M and a lengthy description
- Anti-fingerprinting, such as x-powered-by
- Assume framework files are complete & correct
- Not changing onclick to addEventListener or similar
- routes/console.php
- Applying `final`
- Leaving sqlite alone, with its limits
- linking public/uploads to storage/app/* might not embed in git
- getExchangeRate() should be moved out of ProductController. Need biz rules to do this properly.
- Modifying database for transactions, soft deletes, referential integrity, etc.
- Deleting image, when a product is deleted
- Replacing cURL with Laravel HTTP Client (Guzzle)
- Change routes to Resource routes

### Out of Scope?
- No formal / automated testing / test plans
- Unit & further testing
- HSTS
- Ran pint, but no further formatting.
- Compress images
- favicon.ico improvements
- UX / UI design improvements
- custom.css: Change px to elastic rem
- Addressing a11y nor i18n, including fuzzing
- Esoteric pen testing, such as timing attacks
- Dotfiles for better Development eXperience
