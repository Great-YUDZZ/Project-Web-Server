---
title: "Dokumentasi Folder & Berkas: Konfigurasi Sistem & Root Repository"
category: "Direktori Proyek"
tags:
  - folder
  - configuration
  - devops
  - root-files
updated_at: "2026-10-09"
---

# Dokumentasi Folder & Berkas: Konfigurasi Sistem & Root Repository

Path Proyek: `/var/www/project_tkj_yuda2/` (Root) dan `/var/www/project_tkj_yuda2/config/`

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FILE_vite_config_js]]: Berkas bundler frontend.
- [[FILE_nginx_conf]]: Berkas konfigurasi web server Nginx.
- [[16_Resep_Modifikasi_Database_dan_DevOps]]: Panduan operasional DevOps.

---

## 1. Fungsi & Peran Konfigurasi Root

Menampung seluruh konfigurasi lingkungan (*environment*), definisi dependensi perangkat lunak PHP dan JavaScript, skrip kompilasi Vite, serta konfigurasi server web Nginx.

---

## 2. Berkas Penting di Root & Folder Config

1. `bootstrap/app.php`:
   - Titik inisialisasi aplikasi Laravel 12. Mengatur perutean web dan middleware pipeline tanpa file kernel warisan.
2. `config/database.php`:
   - Konfigurasi koneksi database MariaDB/MySQL melalui PDO FastCGI dan UNIX socket.
3. `config/auth.php`:
   - Konfigurasi guard sesi admin dan provider model `App\Models\User`.
4. `vite.config.js`:
   - Konfigurasi bundler Vite, Hot Module Replacement (HMR), dan plugin `@tailwindcss/vite`.
5. `package.json`:
   - Daftar pustaka frontend: `tailwindcss`, `@tailwindcss/vite`, `gsap`, `three`, `hls.js`, `swiper`.
6. `composer.json`:
   - Daftar pustaka backend: `php: ^8.2`, `laravel/framework: ^12.0`, `pestphp/pest`.
7. `nginx/project_tkj_yuda2.conf`:
   - Salinan master konfigurasi virtualhost Nginx (listen port 80/443, root public, socket FastCGI `php8.4-fpm.sock`).
8. `phpunit.xml`:
   - Konfigurasi suite pengujian otomatis testing environment (`DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`).

---

## 3. Kemana Berkas-Berkas Ini Terhubung

- **Dipanggil Oleh**: Sistem operasi Debian (Nginx, systemd, PHP-FPM) dan toolchain developer (`composer`, `npm`, `artisan`).
