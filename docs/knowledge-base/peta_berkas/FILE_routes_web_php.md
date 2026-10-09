---
title: "Dokumentasi Berkas: routes/web.php"
category: "Berkas Routing"
tags:
  - file
  - routes
  - web-routes
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: routes/web.php

Path Berkas: `/var/www/project_tkj_yuda2/routes/web.php`
Jumlah Baris: 71 baris

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_routes]]: Dokumentasi folder rute.
- [[FILE_PublicController_php]]: Controller utama publik.
- [[FILE_AuthController_php]]: Controller otentikasi admin.

---

## 1. Fungsi & Peran Berkas

Berkas ini memetakan seluruh alamat URL web yang diketik oleh pengunjung atau dipanggil oleh skrip AJAX frontend ke controller yang bertanggung jawab menangani data dan tampilan.

---

## 2. Struktur & Rincian Isi Berkas

- **Baris 1-13**: Deklarasi import namespace controller (`CertificateController`, `DashboardController`, `MessageController`, `AdminPostController`, `ProjectController`, `SkillController`, `AuthController`, `ChatbotController`, `PublicController`, `Route`).
- **Baris 19-30 (Public Routes)**:
  - Baris 19: `GET /` -> `PublicController@index` (Landing page portofolio monokrom).
  - Baris 20: `GET /dark-preview` -> `PublicController@index`.
  - Baris 21: `GET /archive/classic` -> `PublicController@classicArchive` (Arsip 2024-2025).
  - Baris 22: `GET /projects` -> `PublicController@projects` (Katalog seluruh proyek).
  - Baris 23: `GET /projects/{slug}` -> `PublicController@projectDetail` (Detail proyek).
  - Baris 24: `GET /blog` -> `PublicController@blog` (Katalog artikel blog).
  - Baris 25: `GET /blog/{slug}` -> `PublicController@blogDetail` (Detail artikel blog).
  - Baris 26: `GET /ai` -> `ChatbotController@index` (Halaman konsol Yuna AI).
  - Baris 27: `POST /contact` -> `PublicController@contactSubmit` (`middleware('throttle:10,1')`).
  - Baris 28: `POST /chatbot/message` -> `ChatbotController@handle` (`middleware('throttle:30,1')`).
  - Baris 29: `GET /api/telemetry` -> `PublicController@telemetry` (`middleware('throttle:60,1')`).
- **Baris 36-38 (Authentication Routes)**:
  - Baris 36: `GET /login` -> `AuthController@showLogin`.
  - Baris 37: `POST /login` -> `AuthController@login`.
  - Baris 38: `POST /logout` -> `AuthController@logout`.
- **Baris 45-70 (Protected Admin Routes)**:
  - Baris 46: `GET /admin` -> redirect ke `admin.dashboard`.
  - Baris 47: `GET /admin/dashboard` -> `DashboardController@index`.
  - Baris 48: `GET /admin/dashboard/server-metrics` -> `DashboardController@serverMetrics`.
  - Baris 51-53: CRUD proyek + toggle hero & featured.
  - Baris 56: CRUD skills (`Route::resource('skills', SkillController::class)`).
  - Baris 59: CRUD certificates (`Route::resource('certificates', CertificateController::class)`).
  - Baris 62-63: CRUD blog posts + toggle publish.
  - Baris 66-69: Resource inbox pesan masuk + toggle read & destroy.

---

## 3. Kemana Berkas Ini Terhubung

- **Dipanggil Oleh**: `bootstrap/app.php` saat inisialisasi aplikasi.
- **Memanggil**:
  - `App\Http\Controllers\PublicController`
  - `App\Http\Controllers\AuthController`
  - `App\Http\Controllers\ChatbotController`
  - Controller administratif di namespace `App\Http\Controllers\Admin`

---

## 4. Panduan Baris Kode Operasional

### A. Jika Ingin MENAMBAH Rute Publik Baru
- **Buka Baris**: Baris 30.
- **Tambahkan**:
  ```php
  Route::get('/nama-url-baru', [PublicController::class, 'methodBaru'])->name('nama.route');
  ```
- **Langkah Lanjutan**: Buka `app/Http/Controllers/PublicController.php` dan buat method `public function methodBaru() { return view('nama_view'); }`.

### B. Jika Ingin MENGUBAH URL Rute yang Ada
- **Contoh**: Mengubah URL blog dari `/blog` menjadi `/artikel`.
- **Buka Baris**: Baris 24.
- **Ubah**: `Route::get('/blog', ...)` menjadi `Route::get('/artikel', ...)`.

### C. Jika Ingin MENONAKTIFKAN / MENGHAPUS Fitur Tertentu
- **Contoh**: Menonaktifkan arsip klasik.
- **Buka Baris**: Baris 21 (`Route::get('/archive/classic', ...)`).
- **Tindakan**: Hapus atau beri tanda komentar `//` pada baris tersebut.
