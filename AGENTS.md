# MINI-CEX (CodeIgniter 4) — Repo Guide

## Stack
- CodeIgniter 4.7, PHP 8.2+, MySQL (`bd_minicex` on `localhost:33069`)
- PHPMailer, TCPDF, FPDF (custom, in `api/fpdf/`)

## Database
- Credentials in **`config.php`** (root). CI4's `app/Config/Database.php` reads the same constants for its `$default` group.
- **`setup.php`** drops & recreates `bd_minicex`, creates all tables, seeds one teacher (`evaluador@upe.edu.mx` / `password123`) + 3 students.
- The app uses **raw PDO** (`getDbConnection()` from `config.php`) everywhere — the `app/Models/` directory is empty. Do NOT use CI4's `$this->db` or Query Builder unless adding new code.

## Routes (all in `app/Config/Routes.php`)
| Path | Controller |
|---|---|
| `/` | `HomeController::index` |
| `/admin` | `AdminController` |
| `/api/*` | `ApiController` |

## Admin Panel (`/admin`)
- Session-based auth. Credentials: `admin` / `Retsab21ACA*`.
- POST `/admin/login` with JSON `{username, password}`.
- POST `/admin/action` with JSON `{action, ...}`. Supports: `add_docente`, `add_alumno`, `add_alumnos_ajax`, `add_alumnos_bulk_text`, `delete_docente`, `delete_alumno`, `resend_email`, `reset_db`.

## API (Android app sync)
- All endpoints in `ApiController`. CORS enabled for all origins.
- Auth: POST `/api/auth/login` — plaintext password comparison (no hash).
- Students: GET `/api/students`, POST `/api/sync/students`.
- Evaluations: GET/POST `/api/sync/evaluations`, POST `/api/sync/resend-email`.
- Queue: POST `/api/sync/process_queue` — bidirectional offline sync protocol.
- Data mapping: Kotlin camelCase ↔ MySQL snake_case (e.g. `fechaEvaluacion` → `fecha_evaluacion`).

## Key architecture notes
- `parts/` = PHP partial views (included manually, not CI4 views).
- `includes/` = shared utilities (`email_sender.php`, `auth.php`, `data_fetcher.php`, `post_handlers.php`).
- `api/pdf_generator.php` = standalone FPDF report generator.
- Email logs to `email_log.log` via PHPMailer.
- SMTP auto-heals: if `SMTP_HOST` is `smtp.example.com` but username is `@gmail.com`, it switches to `smtp.gmail.com`.
- Admin password is hardcoded in `AdminController::login`.

## Tests
- **No tests exist** — `tests/` directory is absent. PHPUnit is in `require-dev` but has no config at project root.
- `composer test` runs `phpunit` (will fail until tests are created).

## Commands
```sh
composer test              # phpunit (no tests yet)
php spark                  # CI4 CLI
```

## What NOT to do
- Do NOT use CI4's Model layer or Query Builder for existing code — the app uses raw PDO throughout.
- Do NOT use CI4 migrations — `app/Database/Migrations/` is empty. Schema is managed by `setup.php`.
- Do NOT rely on `.env` — it's example-only, all values are commented out.
