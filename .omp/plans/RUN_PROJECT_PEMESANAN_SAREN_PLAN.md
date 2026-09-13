# Run project pemesanan-saren-group

## Goal
Jalankan aplikasi (Laravel 13 + Filament 5) di mesin lokal dan verifikasi bisa diakses.

## Pre-verified state (tidak perlu diulang)
- PHP 8.5.6 statis di ~/.local/bin/php (ext sqlite3, intl, gd, zip OK); composer OK.
- vendor/ terpasang, node_modules terpasang, `public/build` sudah ada (assets frontend ter-build).
- .env: DB_CONNECTION=sqlite, SESSION=file, QUEUE=sync, CACHE=file; database/database.sqlite ada.
- Migrasi semua "Ran"; data seeded: products=17, users=2.
- Login panel: email `admin@sarengroup.test`, password `password` (role super_admin, panel path `admin`, login diaktifkan).
- Rute: `/` (HomePage Livewire), `/admin` (Filament dashboard), `/admin/login`.

## Approach (urut)
1. Mulai server long-running via `hub op="start"`:
   - name: `serve`, application: `~/.local/bin/php`, args: `["artisan", "serve", "--host=127.0.0.1", "--port=8000"]`, cwd: repo root, ready: port 8000 + log "Server running".
2. Verifikasi HTTP:
   - `GET http://127.0.0.1:8000/` → 200, halaman home (HomePage) berisi konten brand "Saren".
   - `GET http://127.0.0.1:8000/admin/login` → 200, form login Filament tampil.
3. Verifikasi login end-to-end lewat browser (tab `browser.open`):
   - Buka `http://127.0.0.1:8000/admin/login`, isi email `admin@sarengroup.test` + password `password`, submit.
   - Diharapkan redirect ke `/admin` (dashboard) tanpa error.
4. Laporkan URL + kredensial ke user. Jika user minta hot-reload frontend, opsional jalankan `hub op="start"` name `vite`, app `npm`, args `["run","dev"]` — tidak dibutuhkan karena assets sudah ter-build.

## Non-Goals
- Tidak ada perubahan kode, migrasi baru, atau seeding ulang.
- Tidak menjalankan Sail/Docker (compose.yaml diabaikan; runtime sqlite lokal).

## Verification
- `curl -s -o /dev/null -w "%{http_code}" http://127.0.0.1:8000/` → `200`.
- `curl -s -o /dev/null -w "%{http_code}" http://127.0.0.1:8000/admin/login` → `200`.
- Login via browser → tampil dashboard `/admin`.

## Assumptions
- APP_URL `http://localhost` dipakai apa adanya; akses via `http://127.0.0.1:8000` (serve binding default).
- Kredensial admin dari DatabaseSeeder: `admin@sarengroup.test` / `password`.