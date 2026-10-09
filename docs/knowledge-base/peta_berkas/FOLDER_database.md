---
title: "Dokumentasi Folder: database/"
category: "Direktori Proyek"
tags:
  - folder
  - database
  - migrations
  - seeders
updated_at: "2026-10-09"
---

# Dokumentasi Folder: database/

Path Proyek: `/var/www/project_tkj_yuda2/database/`

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[04_Skema_Database_Relasional]]: Dokumentasi skema basis data relasional.
- [[FILE_migrations]]: Dokumentasi 9 berkas migrasi database.
- [[FILE_seeders]]: Dokumentasi berkas seeder awal sistem.

---

## 1. Fungsi & Peran Folder

Folder ini mengelola struktur skema tabel basis data MariaDB/MySQL dan data awal percontohan sistem. Memungkinkan database direplikasi secara identik di lingkungan pengembangan lokal maupun server produksi menggunakan perintah deklaratif Artisan.

---

## 2. Struktur Subdirektori & Berkas

1. `migrations/` (9 berkas):
   - Seluruh cetak biru tabel relasional (`users`, `cache`, `jobs`, `skills`, `projects`, `messages`, `certificates`, kolom hero, dan `posts`).
2. `seeders/` (6 berkas):
   - `DatabaseSeeder.php`: Orkestrator utama seeder.
   - `AdminUserSeeder.php`: Pembuatan akun awal administrator.
   - `SkillSeeder.php`: Data keahlian jaringan dan sysadmin.
   - `ProjectSeeder.php`: Data proyek laboratorium TKJ.
   - `CertificateSeeder.php`: Data sertifikat Cisco dan MikroTik.
   - `PostSeeder.php`: Data artikel jurnal blog percontohan.
3. `factories/`:
   - `UserFactory.php`: Generator data dummy untuk pengujian unit.

---

## 3. Kemana Folder Ini Terhubung

- **Dieksekusi Oleh**: Perintah Artisan CLI (`php artisan migrate`, `php artisan db:seed`).
- **Membangun Tabel Untuk**: Model Eloquent di `app/Models/`.
