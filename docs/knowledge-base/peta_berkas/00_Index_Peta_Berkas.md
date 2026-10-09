---
title: "Indeks Navigasi Peta Berkas & Folder Proyek"
category: "Indeks Berkas / Navigation"
tags:
  - index
  - file-map
  - folder-docs
  - navigation
updated_at: "2026-10-09"
---

# Indeks Navigasi Peta Berkas & Folder Proyek

Dokumen ini adalah katalog tautan navigasi instan menuju setiap dokumen spesifik yang menjelaskan **fungsi**, **keterhubungan**, dan **panduan baris kode** (apa yang harus diubah, ditambah, atau dihapus) untuk setiap folder dan berkas dalam proyek ini.

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks utama vault Obsidian.
- [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]]: Bedah rasionalitas kode komprehensif.

---

## 1. Direktori & Berkas Routing
- [[FOLDER_routes]]: Dokumentasi folder rute HTTP & CLI.
- [[FILE_routes_web_php]]: Dokumentasi lengkap rute web publik, otentikasi, dan rute CRUD admin.

---

## 2. Direktori & Berkas Controllers (Lapisan HTTP)
- [[FOLDER_app_Http_Controllers]]: Dokumentasi folder controller utama.
  - [[FILE_PublicController_php]]: Controller publik (home, blog, proyek, kontak, telemetri).
  - [[FILE_AuthController_php]]: Controller otentikasi login admin dan proteksi brute-force.
  - [[FILE_ChatbotController_php]]: Controller konsol dan pemrosesan pesan Yuna AI.
- [[FOLDER_app_Http_Controllers_Admin]]: Dokumentasi folder controller panel admin.
  - [[FILE_Admin_DashboardController_php]]: Controller ringkasan statistik dan metrik server.
  - [[FILE_Admin_ProjectController_php]]: Controller CRUD portofolio proyek lab.
  - [[FILE_Admin_PostController_php]]: Controller CRUD artikel blog dan status publikasi.
  - [[FILE_Admin_MessageController_php]]: Controller inbox pesan kontak masuk.

---

## 3. Direktori & Berkas Model Eloquent (Lapisan Data)
- [[FOLDER_app_Models]]: Dokumentasi folder entitas data basis data.
  - [[FILE_Model_Project_php]]: Model entitas proyek lab dan query scope hero/featured.
  - [[FILE_Model_Post_php]]: Model entitas artikel blog dan query scope published.
  - [[FILE_Model_Message_php]]: Model entitas pesan masuk kontak dan scope unread.

---

## 4. Direktori & Berkas Service Layer (Lapisan Komputasi)
- [[FOLDER_app_Services]]: Dokumentasi folder service mandiri.
  - [[FILE_ServerMonitorService_php]]: Service telemetri Linux kernel (`/proc`) dan status LEMP.

---

## 5. Direktori & Berkas View Blade (Lapisan Tampilan)
- [[FOLDER_resources_views]]: Dokumentasi folder template antarmuka.
  - [[FILE_home_blade_php]]: Halaman beranda utama satu halaman portofolio monokrom.
  - [[FILE_layouts_app_blade_php]]: Master layout publik untuk blog dan proyek.
  - [[FILE_components_tech_flow_columns_blade_php]]: Komponen pameran teknologi vertikal tak terbatas.

---

## 6. Direktori & Berkas Aset Frontend (CSS & JavaScript)
- [[FOLDER_resources_css]]: Dokumentasi folder stylesheet.
  - [[FILE_app_css]]: Definisi token warna monokrom Tailwind CSS v4, font geometris, dan easing.
- [[FOLDER_resources_js]]: Dokumentasi folder skrip JavaScript.
  - [[FILE_dark_portfolio_js]]: Skrip GSAP entrance, scroll-spy navbar, dan modal telemetri.
  - [[FILE_interactive_bg_js]]: Skrip render latar belakang WebGL Three.js 3D Starfield.

---

## 7. Direktori & Berkas Database (Migrasi & Seeder)
- [[FOLDER_database]]: Dokumentasi folder basis data.
  - [[FILE_migrations]]: Rincian 9 berkas cetak biru skema tabel MariaDB.
  - [[FILE_seeders]]: Rincian berkas pengisi data awal percontohan sistem.

---

## 8. Konfigurasi Sistem, Bundler, & Web Server
- [[FOLDER_config_dan_root]]: Dokumentasi konfigurasi lingkungan root repositori.
  - [[FILE_vite_config_js]]: Berkas konfigurasi bundler aset statis Vite.
  - [[FILE_nginx_conf]]: Berkas konfigurasi virtualhost web server Nginx.
