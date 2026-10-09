---
title: "Dokumentasi Berkas: app/Models/Post.php"
category: "Berkas Model"
tags:
  - file
  - model
  - post-model
  - blog
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: app/Models/Post.php

Path Berkas: `/var/www/project_tkj_yuda2/app/Models/Post.php`
Jumlah Baris: 68 baris

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_app_Models]]: Folder model data.
- [[FILE_Admin_PostController_php]]: Controller manajemen artikel admin.
- [[FILE_PublicController_php]]: Controller penampilan blog publik.

---

## 1. Fungsi & Peran Berkas

Merepresentasikan artikel jurnal teknis pada tabel `posts`. Mengelola slug generator otomatis saat penyimpanan, query scope artikel terbit (`scopePublished`), serta casting tipe data datetime dan integer.

---

## 2. Struktur & Rincian Kode di Dalam Berkas

- **Baris 14-26 (Array `$fillable`)**:
  - Kolom: `'title'`, `'slug'`, `'excerpt'`, `'content'`, `'category'`, `'tags'`, `'featured_image'`, `'reading_time'`, `'is_published'`, `'published_at'`, `'views_count'`.
- **Baris 28-33 (Array `$casts`)**:
  - `'is_published' => 'boolean'`, `'published_at' => 'datetime'`, `'reading_time' => 'integer'`, `'views_count' => 'integer'`.
- **Baris 38-45 (`scopePublished(Builder $query)`)**:
  - Menyeleksi hanya artikel yang memiliki `is_published = true` dan `published_at` sudah melewati atau sama dengan waktu sekarang (`now()`).
- **Baris 50-65 (Event Model `boot()`)**:
  - Event `saving`: Jika slug kosong, buat otomatis dari judul via `Str::slug($post->title)`. Jika artikel ditandai terbit tetapi tanggal belum diisi, isi otomatis dengan `now()`.

---

## 3. Panduan Baris Kode Operasional

### A. Jika Ingin MENAMBAH Kolom Baru (Misal: `meta_keywords`)
- **Buka Baris**: Baris 14-26 (array `$fillable`).
- **Tambahkan**: `'meta_keywords',`.

### B. Jika Ingin MENGUBAH Format Tanggal Publikasi
- **Buka Baris**: Baris 30 (array `$casts`).
- **Modifikasi**: Ubah tipe casting jika diperlukan format khusus.
