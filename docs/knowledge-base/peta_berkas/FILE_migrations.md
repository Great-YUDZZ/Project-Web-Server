---
title: "Dokumentasi Berkas: database/migrations/ (9 Berkas Skema)"
category: "Berkas Database"
tags:
  - file
  - migrations
  - database-schema
  - table-structure
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: database/migrations/ (9 Berkas Skema)

Path Direktori: `/var/www/project_tkj_yuda2/database/migrations/`

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_database]]: Folder database.
- [[04_Skema_Database_Relasional]]: Dokumentasi arsitektur database.
- [[16_Resep_Modifikasi_Database_dan_DevOps]]: Resep pembuatan dan rollback migrasi.

---

## 1. Daftar 9 Berkas Migrasi & Fungsinya

1. `0001_01_01_000000_create_users_table.php`:
   - Membuat tabel `users` (id, name, email, password, remember_token, timestamps), `password_reset_tokens`, dan `sessions`.
2. `0001_01_01_000001_create_cache_table.php`:
   - Membuat tabel `cache` dan `cache_locks` untuk driver database cache Laravel.
3. `0001_01_01_000002_create_jobs_table.php`:
   - Membuat tabel antrean pekerjaan latar belakang `jobs`, `job_batches`, dan `failed_jobs`.
4. `2026_09_06_000001_create_skills_table.php`:
   - Membuat tabel `skills` (id, name, category, icon, level, order, timestamps).
5. `2026_09_06_000002_create_projects_table.php`:
   - Membuat tabel `projects` (id, title, slug, category, description, topology_image, tools_used, demo_link, is_featured, timestamps).
6. `2026_09_06_000003_create_messages_table.php`:
   - Membuat tabel `messages` (id, sender_name, email, subject, message, is_read, timestamps).
7. `2026_09_07_000001_create_certificates_table.php`:
   - Membuat tabel `certificates` (id, title, issuer, issue_date, credential_id, credential_url, file_path, is_featured, order, timestamps).
8. `2026_09_25_000001_add_is_hero_and_order_to_projects_table.php`:
   - Menambahkan kolom `is_hero` (boolean default false) dan `order` (integer default 0) pada tabel `projects`.
9. `2026_10_08_000001_create_posts_table.php`:
   - Membuat tabel `posts` (id, title, slug, excerpt, content, category, tags, featured_image, reading_time, is_published, published_at, views_count, timestamps).

---

## 2. Panduan Modifikasi & Perintah Eksekusi

- **Membuat Kolom / Tabel Baru**:
  Jalankan `php artisan make:migration nama_migrasi --table=nama_tabel`.
- **Menjalankan Migrasi**:
  Jalankan `php artisan migrate`.
- **Melihat Status**:
  Jalankan `php artisan migrate:status`.
- **Membatalkan Migrasi Terakhir**:
  Jalankan `php artisan migrate:rollback`.
