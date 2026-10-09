---
title: "Dokumentasi Berkas: app/Http/Controllers/Admin/ProjectController.php"
category: "Berkas Controller Admin"
tags:
  - file
  - controller
  - project-crud
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: app/Http/Controllers/Admin/ProjectController.php

Path Berkas: `/var/www/project_tkj_yuda2/app/Http/Controllers/Admin/ProjectController.php`
Jumlah Baris: 165 baris

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_app_Http_Controllers_Admin]]: Folder controller admin.
- [[FILE_Model_Project_php]]: Model entitas proyek.
- [[FILE_projects_index_blade_php]]: Katalog publik tempat proyek ditampilkan.

---

## 1. Fungsi & Peran Berkas

Mengelola siklus hidup data portofolio proyek laboratorium TKJ: menampilkan daftar proyek dengan paginasi admin, memvalidasi form tambah dan ubah, menangani unggah file gambar topologi, serta menyediakan endpoint cepat untuk toggle status `is_hero` dan `is_featured`.

---

## 2. Struktur & Rincian Method di Dalam Berkas

- **`index()`**: Menampilkan tabel seluruh proyek dengan tombol edit, hapus, dan toggle.
- **`create()`**: Menampilkan formulir input proyek baru.
- **`store(Request $request)`**:
  - Validasi: `title`, `category`, `description`, `tools_used`, `topology_image`, `demo_link`.
  - Penanganan berkas upload gambar ke direktori `storage/app/public/topologies/`.
  - Penyimpanan ke database via `Project::create($validated)`.
- **`edit(Project $project)`**: Menampilkan form pengeditan data proyek yang sudah ada.
- **`update(Request $request, Project $project)`**: Memperbarui atribut proyek dan mengganti gambar lama jika ada gambar baru.
- **`destroy(Project $project)`**: Menghapus file gambar dari disk dan menghapus record dari database.
- **`toggleHero(Project $project)`**: Mengubah nilai boolean `is_hero` (true <-> false) secara instan.
- **`toggleFeatured(Project $project)`**: Mengubah nilai boolean `is_featured` secara instan.

---

## 3. Kemana Berkas Ini Terhubung

- **Dipanggil Oleh**: `routes/web.php` baris 51-53 (`admin.projects.*`).
- **Memanipulasi Model**: `App\Models\Project`.
- **Merender View**: `resources/views/admin/projects/index.blade.php`, `create.blade.php`, dan `edit.blade.php`.

---

## 4. Panduan Baris Kode Operasional

### A. Jika Ingin MENAMBAHKAN Kolom Input Baru pada Proyek (Misal: `client_name`)
1. Buka method `store()` dan `update()`, tambahkan aturan validasi:
   `'client_name' => ['nullable', 'string', 'max:150'],`.
2. Buka `app/Models/Project.php` baris 13-24, pastikan `'client_name'` terdaftar di `$fillable`.
3. Buka `resources/views/admin/projects/create.blade.php` dan `edit.blade.php`, tambahkan elemen form input teks.

### B. Jika Ingin MENGUBAH Folder Penyimpanan Gambar Topologi
- Cari baris `$request->file('topology_image')->store('topologies', 'public');`.
- Ganti `'topologies'` dengan nama folder penyimpanan yang baru.
