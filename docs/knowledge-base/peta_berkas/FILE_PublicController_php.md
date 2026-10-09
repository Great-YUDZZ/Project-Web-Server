---
title: "Dokumentasi Berkas: app/Http/Controllers/PublicController.php"
category: "Berkas Controller"
tags:
  - file
  - controller
  - public-controller
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: app/Http/Controllers/PublicController.php

Path Berkas: `/var/www/project_tkj_yuda2/app/Http/Controllers/PublicController.php`
Jumlah Baris: 247 baris

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_app_Http_Controllers]]: Folder controller.
- [[FILE_routes_web_php]]: Definisi rute yang memicu controller ini.
- [[FILE_ServerMonitorService_php]]: Service kernel yang diinjeksi ke controller ini.
- [[FILE_home_blade_php]]: View yang dirender oleh method index.

---

## 1. Fungsi & Peran Berkas

Pengendali sentral untuk semua halaman publik yang dapat dilihat oleh pengunjung situs. Berkas ini bertanggung jawab menyiapkan data keterampilan, proyek lab, sertifikat, telemetri server fisik, katalog artikel blog, dan menyimpan pesan dari formulir kontak.

---

## 2. Struktur & Rincian Method di Dalam Berkas

- **Baris 19-50: `public function index(ServerMonitorService $monitor)`**:
  - Mengambil daftar keahlian diurutkan berdasarkan kategori dan level (baris 21).
  - Mengambil 2 proyek unggulan hero dengan logika fallback (baris 23-30).
  - Mengambil proyek featured dan sertifikat (baris 32-44).
  - Mengambil seluruh metrik Linux kernel via `$monitor->getAllMetrics()` (baris 46).
  - Merender view `resources/views/home.blade.php` (baris 49).
- **Baris 55-99: `public function classicArchive(ServerMonitorService $monitor)`**:
  - Menyiapkan data untuk arsip portofolio klasik 2024-2025 dan merender `resources/views/archive/classic/home.blade.php`.
- **Baris 104-107: `public function telemetry(ServerMonitorService $monitor): JsonResponse`**:
  - Mengembalikan payload JSON dari `$monitor->getAllMetrics()` untuk dikonsumsi polling frontend.
- **Baris 112-134: `public function projects(Request $request)`**:
  - Query katalog proyek lengkap dengan pencarian kata kunci (`?q=`) dan filter kategori (`?category=`), serta paginasi 9 per halaman.
- **Baris 139-152: `public function projectDetail(string $slug)`**:
  - Menampilkan satu proyek berdasarkan slug dan merekomendasikan 3 proyek terkait dari kategori yang sama.
- **Baris 157-191: `public function blog(Request $request)`**:
  - Query artikel blog terbit (`Post::published()`), memisahkan Hero Featured Post jika tanpa pencarian, dan paginasi 6 artikel per halaman.
- **Baris 196-217: `public function blogDetail(string $slug)`**:
  - Menampilkan detail artikel blog, melakukan `$post->increment('views_count')`, dan mencari artikel terkait.
- **Baris 222-245: `public function contactSubmit(Request $request)`**:
  - Validasi ketat field `sender_name`, `email`, `subject`, `message` (baris 224-229).
  - Sanitasi `strip_tags(trim(...))` untuk menolak XSS (baris 231-233).
  - Menyimpan ke database via `Message::create($validated)` (baris 235).
  - Mengembalikan respons JSON atau redirect `back()->withFragment('contact')`.

---

## 3. Kemana Berkas Ini Terhubung

- **Dipanggil Oleh**: `routes/web.php` (baris 19-25, 27, 29).
- **Memanggil Model**:
  - `App\Models\Project`
  - `App\Models\Skill`
  - `App\Models\Certificate`
  - `App\Models\Post`
  - `App\Models\Message`
- **Memanggil Service**:
  - `App\Services\ServerMonitorService`
- **Merender View**:
  - `resources/views/home.blade.php`
  - `resources/views/blog/index.blade.php` & `blog/show.blade.php`
  - `resources/views/projects/index.blade.php` & `projects/show.blade.php`
  - `resources/views/archive/classic/home.blade.php`

---

## 4. Panduan Baris Kode Operasional

### A. Jika Ingin MENAMBAHKAN Data Baru ke Halaman Depan
- **Buka Baris**: Baris 45.
- **Tambahkan**:
  ```php
  $dataBaru = ModelBaru::latest()->get();
  ```
- **Buka Baris**: Baris 49.
- **Tambahkan Nama Variabel ke `compact(...)`**:
  ```php
  return view('home', compact(..., 'dataBaru'));
  ```

### B. Jika Ingin MENGUBAH Jumlah Paginasi Proyek atau Blog
- **Proyek**: Buka baris 130, ubah `paginate(9)` menjadi angka yang diinginkan.
- **Blog**: Buka baris 182 dan 184, ubah `paginate(6)` menjadi angka yang diinginkan.

### C. Jika Ingin MENAMBAH Field Input Baru pada Form Kontak
- **Buka Baris**: Baris 225-229 (array validasi).
- **Tambahkan**: `'telepon' => ['nullable', 'string', 'max:20'],`.
- **Buka Baris**: Baris 233.
- **Tambahkan Sanitasi**: `$validated['telepon'] = strip_tags(trim($validated['telepon'] ?? ''));`.
