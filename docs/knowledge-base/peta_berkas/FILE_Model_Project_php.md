---
title: "Dokumentasi Berkas: app/Models/Project.php"
category: "Berkas Model"
tags:
  - file
  - model
  - project-model
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: app/Models/Project.php

Path Berkas: `/var/www/project_tkj_yuda2/app/Models/Project.php`
Jumlah Baris: 85 baris

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_app_Models]]: Folder model data.
- [[FILE_Admin_ProjectController_php]]: Controller manajemen proyek.
- [[FILE_PublicController_php]]: Controller penampilan proyek di web publik.

---

## 1. Fungsi & Peran Berkas

Merepresentasikan entitas proyek laboratorium jaringan dan administrasi server. Mengatur atribut yang boleh diisi secara massal, konversi tipe data boolean dan integer, pembuatan slug URL unik otomatis saat entri baru dibuat, serta query scope untuk proyek unggulan (*featured*) dan sorotan hero (*hero*).

---

## 2. Struktur & Rincian Kode di Dalam Berkas

- **Baris 13-24 (Array `$fillable`)**:
  - Mendaftarkan kolom: `'title'`, `'slug'`, `'category'`, `'description'`, `'topology_image'`, `'tools_used'`, `'demo_link'`, `'is_featured'`, `'is_hero'`, `'order'`.
- **Baris 26-30 (Array `$casts`)**:
  - `'is_featured' => 'boolean'`, `'is_hero' => 'boolean'`, `'order' => 'integer'`.
- **Baris 32-35 (`scopeHero($query)`)**:
  - Filter `where('is_hero', true)->orderBy('order')`.
- **Baris 37-40 (`scopeFeatured($query)`)**:
  - Filter `where('is_featured', true)->orderBy('order')`.
- **Baris 42-57 (Event Model `boot()`)**:
  - Event `creating`: Jika slug kosong, buat slug dari judul (`Str::slug($project->title)`) dan pastikan unik dengan menambahkan suffix angka `-1`, `-2` jika terjadi duplikasi judul.
- **Baris 59-65 (Accessor `getToolsListAttribute()`)**:
  - Memecah string `tools_used` yang dipisahkan koma menjadi array PHP agar mudah di-looping di template Blade.

---

## 3. Panduan Baris Kode Operasional

### A. Jika Ingin MENAMBAH Kolom Baru pada Proyek
- **Buka Baris**: Baris 13-24 (array `$fillable`).
- **Langkah**: Tambahkan nama kolom baru (misal: `'github_repo'`).
- **Peringatan**: Jika tidak didaftarkan di sini, Laravel akan membuang nilai kolom tersebut saat dieksekusi via `Project::create($request->all())`.

### B. Jika Ingin MENGUBAH Urutan Default Proyek
- **Buka Baris**: Baris 34 dan 39.
- **Modifikasi**: Ubah `orderBy('order')` menjadi `latest()` atau `orderByDesc('order')`.
