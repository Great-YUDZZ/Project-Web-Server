---
title: "Dokumentasi Folder: app/Models/"
category: "Direktori Proyek"
tags:
  - folder
  - models
  - eloquent-orm
updated_at: "2026-10-09"
---

# Dokumentasi Folder: app/Models/

Path Proyek: `/var/www/project_tkj_yuda2/app/Models/`

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[04_Skema_Database_Relasional]]: Dokumentasi skema tabel database.
- [[FILE_Model_Project_php]]: Model entitas proyek portofolio.
- [[FILE_Model_Post_php]]: Model entitas artikel blog.
- [[FILE_Model_Message_php]]: Model entitas pesan masuk kontak.

---

## 1. Fungsi & Peran Folder

Folder ini menampung seluruh kelas Model Eloquent ORM (Object-Relational Mapping). Setiap kelas model merepresentasikan satu tabel di basis data MariaDB/MySQL, menyediakan pemetaan kolom ke atribut objek PHP, mengatur hak akses mass-assignment (`$fillable`), konversi tipe data (`$casts`), serta relasi dan query scope.

---

## 2. Berkas di Dalam Folder

1. `Project.php`: Mewakili tabel `projects`. Dilengkapi query scope `scopeHero` dan `scopeFeatured`, serta pembuatan slug otomatis.
2. `Post.php`: Mewakili tabel `posts`. Dilengkapi query scope `scopePublished` dan pembuatan slug otomatis saat disimpan.
3. `Certificate.php`: Mewakili tabel `certificates`. Menangani data lisensi dan berkas scan sertifikat.
4. `Skill.php`: Mewakili tabel `skills`. Menangani kategori keterampilan (networking, sysadmin, hardware, tools).
5. `Message.php`: Mewakili tabel `messages`. Menangani log pesan kontak dan scope `unread()`.
6. `User.php`: Mewakili tabel `users`. Mengimplementasikan kontrak otentikasi `Authenticatable` untuk login admin.
7. `Admin.php`: Model opsional pelengkap entitas admin.
8. `Setting.php`: Model penyimpanan pengaturan dinamis profil sistem berbasis key-value.

---

## 3. Kemana Folder Ini Terhubung

- **Dipanggil Oleh**: Seluruh controller di `app/Http/Controllers/` untuk membaca dan menulis data ke database.
- **Terikat Ke**: Tabel-tabel fisik di database MariaDB yang dibuat oleh berkas migrasi di `database/migrations/`.
