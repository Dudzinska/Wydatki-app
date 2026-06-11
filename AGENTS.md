# AGENTS.md

## Cursor Cloud specific instructions

BillsBuddy is a single Laravel 12 application (PHP 8.3) for splitting group bills/expenses, with a Vite + Tailwind frontend (Alpine.js). There is one service to run: the Laravel app, optionally with the Vite dev server for hot asset reloading.

### Environment notes
- Database is **SQLite** by default (`database/database.sqlite`), configured via `DB_CONNECTION=sqlite` in `.env`. No external DB server is needed.
- The MySQL-only triggers/SQL functions mentioned in `JAK_URUCHOMIC.md` are not exercised on SQLite; balances are computed in PHP, so the app runs fully on SQLite.
- `.env`, `database/database.sqlite`, `vendor/`, and `node_modules/` are gitignored and persist via the VM snapshot. They are created once during setup; the startup update script only refreshes dependencies. If starting from a clean checkout, recreate them with: `cp .env.example .env && php artisan key:generate && touch database/database.sqlite && php artisan migrate:fresh --seed`.

### Running (dev)
- App server: `php artisan serve --host=0.0.0.0 --port=8000` (serves on http://127.0.0.1:8000).
- Asset hot-reload (optional, separate terminal): `npm run dev`. If Vite dev is not running, build once with `npm run build` so the Vite manifest exists.
- `composer dev` runs server + queue + logs + vite together via concurrently (uses `npx concurrently`).

### Test / lint / build
- Tests: `php artisan test` (PHPUnit). **The Vite manifest must exist first** — run `npm run build` before testing, otherwise feature tests that render Blade layouts fail with "Vite manifest not found".
- Lint: `./vendor/bin/pint` (Laravel Pint). Note: running `pint --test` on the current codebase reports pre-existing style deviations; this is not caused by environment setup.
- Build: `npm run build`.

### Demo / seeded accounts (password: `password`)
- admin: `oliwia@example.com`
- users: `adam@example.com`, `ewa@example.com`
