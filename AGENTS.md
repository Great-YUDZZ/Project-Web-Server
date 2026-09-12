# AGENTS.md

Laravel 13 portfolio app (LEMP stack). PHP 8.3+, MySQL/MariaDB, Nginx, Vite + Tailwind CSS v4.

## Commands

- Setup (fresh): `composer setup` — installs deps, copies `.env`, generates key, migrates, installs/builds frontend. Or run `bash setup-lemp.sh` (also sets storage perms, storage:link, nginx vhost instructions).
- Dev server: `composer dev` (runs `artisan dev` = Vite + PHP built-in server). Frontend only: `npm run dev`. Build assets: `npm run build`.
- CLI: `php artisan …`
- Tests: `composer test` (= `artisan config:clear` + `artisan test`). Run a single test: `php artisan test --filter=…`.
- Formatting: `./vendor/bin/pint` (Laravel Pint).

## Environment & database

- `.env` uses **MySQL** (not sqlite): `DB_DATABASE=project_tkj_yuda2`, `DB_USERNAME=yuda_user`, `DB_PASSWORD=yuda123`. A MySQL/MariaDB server must be running locally.
- `phpunit.xml` hardcodes the same MySQL creds for the test suite.
- **Tests need a migrated+seeded DB.** `composer test` does NOT migrate. Run `php artisan migrate --seed` first. Note `tests/Feature/TkjPortfolioTest.php` imports `RefreshDatabase` but does not use the trait, so tests run against real DB state.
- Admin seed credentials: `admin@tkj.lan` / `AdminTKJ2026!` (from `AdminUserSeeder`).
- `php artisan storage:link` needed for uploaded topology images (public disk).

## Architecture

- Standard Laravel layout. App code in `app/`, routes in `routes/web.php` (only web; no api/console routes).
- Public site (guest): `/`, `/projects`, `/projects/{slug}`, `/contact` → `PublicController`.
- Auth: `/login`, `/logout` → `AuthController` (session-based, rate-limited 5 attempts).
- Admin panel: `auth`-gated, prefix `/admin`, routes named `admin.*`. Resources: `projects`, `skills`; messages inbox at `/admin/messages` (index/show/toggle-read/destroy). Dashboard at `/admin/dashboard`.
- Models: `User`, `Skill` (enum category: networking/sysadmin/hardware/tools; level 1–100), `Project` (has `topology_image`, `slug`), `Message`.
- Frontend: Vite entries `resources/css/app.css` + `resources/js/app.js`. Vite config ignores `storage/framework/views/**` in watch. Tailwind v4 via `@tailwindcss/vite`; font loading via `laravel-vite-plugin` bunny fonts (Instrument Sans). The design is deliberately minimalist (anti-slop): avoid adding fake terminals, monospace eyebrows on every section, or excessive decorative elements. Keep layouts clean and typography-first.
- Deploy target: Nginx vhost `nginx/project_tkj_yuda2.conf` → PHP 8.4-FPM at `unix:/run/php/php8.4-fpm.sock`. Static assets cached 30d; dotfiles denied.

## Conventions

- PSR-4: `App\` → `app/`, `Database\Factories\`, `Database\Seeders\`, `Tests\` → `tests/`.
- `.editorconfig`: 4-space indent, LF, trim trailing whitespace (except `*.md`).
- Tests in `tests/Unit` and `tests/Feature`. `tests/TestCase.php` extends Laravel's base (empty).
- **Unit tests do not boot Laravel.** `tests/Unit/ExampleTest.php` extends bare `PHPUnit\Framework\TestCase`, not `Tests\TestCase` — no DB, no session, no app container. Feature tests extend `Tests\TestCase` (Laravel). Don't try to use facades/models in `tests/Unit/`.
- Single git branch `master`, single commit so far; working tree clean.

## Model notes

- `Project`: `slug` auto-generated from `title` on create (unique-suffixed via `Str::slug`). `topology_image` stores a relative path under `public/`; `getImageUrlAttribute()` returns `asset('storage/...')` for local uploads but passes through `http(s)://` and `/images/` prefixes verbatim. Editing upload logic: images land on the `public` disk (`Storage::fake('public')` in tests).
- `Skill`: `category` is an enum column (`networking`, `sysadmin`, `hardware`, `tools`); `level` is `unsignedTinyInteger` (1–100).
- `Message`: read/unread toggled via `is_read` boolean; `scopeUnread()` exists. Viewing a message (`GET /admin/messages/{id}`) marks it read.