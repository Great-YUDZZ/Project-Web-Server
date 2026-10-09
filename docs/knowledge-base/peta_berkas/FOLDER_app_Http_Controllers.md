---
title: "Dokumentasi Folder: app/Http/Controllers/"
category: "Direktori Proyek"
tags:
  - folder
  - controllers
  - http-layer
updated_at: "2026-10-09"
---

# Dokumentasi Folder: app/Http/Controllers/

Path Proyek: `/var/www/project_tkj_yuda2/app/Http/Controllers/`

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FILE_PublicController_php]]: Controller utama publik.
- [[FILE_AuthController_php]]: Controller otentikasi login admin.
- [[FILE_ChatbotController_php]]: Controller asisten AI Yuna.
- [[FOLDER_app_Http_Controllers_Admin]]: Subfolder controller panel admin.

---

## 1. Fungsi & Peran Folder

Folder ini adalah lapisan pengendali (Controller Layer) dalam arsitektur Model-View-Controller (MVC). Berfungsi menerima input dari rute HTTP, berinteraksi dengan database melalui Model Eloquent atau memanggil Service khusus, lalu merender View Blade atau mengembalikan respons JSON.

---

## 2. Berkas di Dalam Folder

1. `Controller.php`: Base abstract controller induk bawaan Laravel.
2. `PublicController.php`: Pengendali utama landing page, katalog proyek, blog, formulir kontak, dan telemetri publik.
3. `AuthController.php`: Pengendali form login, rate limiting anti brute-force, dan proses logout admin.
4. `ChatbotController.php`: Pengendali konsol dan pemrosesan pesan chatbot AI Yuna.
5. Subfolder `Admin/`: Menampung 6 controller khusus manajemen data CRUD panel admin.

---

## 3. Kemana Folder Ini Terhubung

- **Dipanggil Oleh**: `routes/web.php` berdasarkan pencocokan rute URL.
- **Memanggil**:
  - Model data di `app/Models/` (`Project`, `Post`, `Certificate`, `Skill`, `Message`, `User`).
  - Layanan telemetri di `app/Services/ServerMonitorService.php`.
  - Template antarmuka di `resources/views/`.
