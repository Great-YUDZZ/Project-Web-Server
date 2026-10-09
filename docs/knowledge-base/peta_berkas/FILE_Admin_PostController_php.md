---
title: "Dokumentasi Berkas: app/Http/Controllers/Admin/PostController.php"
category: "Berkas Controller Admin"
tags:
  - file
  - controller
  - post-crud
  - blog-admin
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: app/Http/Controllers/Admin/PostController.php

Path Berkas: `/var/www/project_tkj_yuda2/app/Http/Controllers/Admin/PostController.php`
Jumlah Baris: 140 baris

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_app_Http_Controllers_Admin]]: Folder controller admin.
- [[FILE_Model_Post_php]]: Model entitas artikel blog.
- [[FILE_blog_index_blade_php]]: Katalog blog publik.

---

## 1. Fungsi & Peran Berkas

Mengelola pembuatan, pengeditan, penghapusan, dan publikasi artikel jurnal teknis pada modul blog. Mengatur slug unik secara otomatis, menghitung estimasi waktu baca (*reading time*), serta menangani unggah gambar banner (*featured_image*).

---

## 2. Struktur & Rincian Method di Dalam Berkas

- **`index()`**: Menampilkan seluruh artikel blog dengan status terbit, jumlah tayangan (*views*), dan kategori.
- **`create()`**: Menampilkan formulir penulisan artikel baru.
- **`store(Request $request)`**:
  - Validasi: `title`, `slug`, `excerpt`, `content`, `category`, `tags`, `featured_image`, `is_published`.
  - Kalkulasi waktu baca otomatis: `reading_time = max(1, ceil(str_word_count(strip_tags($content)) / 200))`.
  - Simpan artikel ke tabel `posts`.
- **`edit(Post $post)`**: Menampilkan formulir pengeditan artikel.
- **`update(Request $request, Post $post)`**: Memperbarui artikel dan memperbarui waktu baca jika konten diubah.
- **`destroy(Post $post)`**: Menghapus artikel beserta file banner dari disk storage.
- **`togglePublish(Post $post)`**: Mengubah status publikasi (Draft <-> Published) secara instan.

---

## 3. Kemana Berkas Ini Terhubung

- **Dipanggil Oleh**: `routes/web.php` baris 62-63 (`admin.posts.*`).
- **Memanipulasi Model**: `App\Models\Post`.
- **Merender View**: `resources/views/admin/posts/index.blade.php`, `create.blade.php`, dan `edit.blade.php`.

---

## 4. Panduan Baris Kode Operasional

### A. Jika Ingin MENGUBAH Rumus Kecepatan Baca Artikel
- Cari baris kalkulasi:
  `$readingTime = max(1, ceil(str_word_count(strip_tags($content)) / 200));`
- Ubah pembagi `200` (kata per menit) jika ingin menyesuaikan dengan kecepatan baca standar artikel teknis berbahasa Indonesia.
