---
title: "Dokumentasi Folder: app/Http/Controllers/Admin/"
category: "Direktori Proyek"
tags:
  - folder
  - admin-controllers
  - crud-management
updated_at: "2026-10-09"
---

# Dokumentasi Folder: app/Http/Controllers/Admin/

Path Proyek: `/var/www/project_tkj_yuda2/app/Http/Controllers/Admin/`

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_app_Http_Controllers]]: Folder induk controller.
- [[FILE_Admin_DashboardController_php]]: Controller dashboard admin.
- [[FILE_Admin_ProjectController_php]]: Controller manajemen proyek lab.
- [[FILE_Admin_PostController_php]]: Controller manajemen artikel blog.
- [[FILE_Admin_MessageController_php]]: Controller manajemen pesan masuk kontak.

---

## 1. Fungsi & Peran Folder

Folder ini menampung seluruh controller yang beroperasi di dalam zona terproteksi otentikasi admin (`/admin/*`). Bertanggung jawab menyediakan aksi CRUD (Create, Read, Update, Delete) untuk konten website, audit telemetri, serta moderasi pesan masuk dari pengunjung.

---

## 2. Berkas di Dalam Folder

1. `DashboardController.php` (50 baris):
   - Agregasi statistik sistem (total proyek, keterampilan, sertifikat, pesan belum dibaca) dan metrik live server.
2. `ProjectController.php` (160 baris):
   - CRUD data proyek laboratorium TKJ, unggah gambar topologi, toggle hero, dan toggle featured.
3. `PostController.php` (135 baris):
   - CRUD artikel blog teknis, slug generator otomatis, dan toggle status publish.
4. `CertificateController.php` (130 baris):
   - CRUD data sertifikasi, upload file bukti fisik PDF/gambar, dan tanggal penerbitan.
5. `SkillController.php` (80 baris):
   - CRUD keahlian teknis jaringan dan persentase tingkat penguasaan.
6. `MessageController.php` (65 baris):
   - Menampilkan daftar inbox pesan pengunjung, membaca detail pesan, menandai telah dibaca (`toggleRead`), dan menghapus pesan spam.

---

## 3. Kemana Folder Ini Terhubung

- **Dipanggil Oleh**: `routes/web.php` baris 45-70 (di dalam middleware `auth`).
- **Memanipulasi Model**: `Project`, `Post`, `Certificate`, `Skill`, `Message`.
- **Merender View**: Seluruh template Blade di `resources/views/admin/`.
