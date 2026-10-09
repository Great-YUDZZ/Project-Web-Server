---
title: "Dokumentasi Berkas: app/Http/Controllers/Admin/DashboardController.php"
category: "Berkas Controller Admin"
tags:
  - file
  - controller
  - admin-dashboard
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: app/Http/Controllers/Admin/DashboardController.php

Path Berkas: `/var/www/project_tkj_yuda2/app/Http/Controllers/Admin/DashboardController.php`
Jumlah Baris: 55 baris

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_app_Http_Controllers_Admin]]: Folder controller admin.
- [[FILE_ServerMonitorService_php]]: Service telemetri server Linux.

---

## 1. Fungsi & Peran Berkas

Menyediakan data ringkasan eksekutif untuk halaman utama dashboard admin (`/admin/dashboard`). Menghitung jumlah total data dari setiap modul dan menyediakan endpoint JSON status server untuk widget dashboard.

---

## 2. Struktur & Rincian Method di Dalam Berkas

- **Baris 18-38: `public function index(ServerMonitorService $monitor)`**:
  - Mengambil statistik data:
    - `totalProjects = Project::count();`
    - `totalSkills = Skill::count();`
    - `totalCertificates = Certificate::count();`
    - `unreadMessages = Message::unread()->count();`
    - `totalPosts = Post::count();`
  - Mengambil metrik Linux kernel via `$monitor->getAllMetrics()`.
  - Merender view `resources/views/admin/dashboard.blade.php`.
- **Baris 43-52: `public function serverMetrics(ServerMonitorService $monitor): JsonResponse`**:
  - Endpoint JSON khusus dasbor admin untuk memperbarui kartu telemetri secara berkala tanpa memuat ulang seluruh halaman.

---

## 3. Kemana Berkas Ini Terhubung

- **Dipanggil Oleh**: `routes/web.php` baris 47 (`admin.dashboard`) dan baris 48 (`admin.dashboard.server-metrics`).
- **Merender View**: `resources/views/admin/dashboard.blade.php`.

---

## 4. Panduan Baris Kode Operasional

### A. Jika Ingin MENAMBAH Kartu Statistik Baru di Dashboard
- **Buka Baris**: Baris 30.
- **Tambahkan**:
  ```php
  $totalDataBaru = ModelBaru::count();
  ```
- **Buka Baris**: Baris 36 (array data ke view).
- **Tambahkan**: `'totalDataBaru' => $totalDataBaru,`.
- **Langkah Lanjutan**: Buka `resources/views/admin/dashboard.blade.php` untuk menampilkan kartu statistik tersebut.
