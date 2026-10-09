---
title: "Dokumentasi Folder: resources/css/"
category: "Direktori Proyek"
tags:
  - folder
  - styling
  - css
  - tailwindcss
updated_at: "2026-10-09"
---

# Dokumentasi Folder: resources/css/

Path Proyek: `/var/www/project_tkj_yuda2/resources/css/`

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FILE_app_css]]: Berkas styling utama proyek.
- [[05_Frontend_Design_Monokrom]]: Dokumentasi sistem desain monokrom.

---

## 1. Fungsi & Peran Folder

Folder ini menampung stylesheet sumber utama proyek sebelum diproses dan dikompilasi oleh Vite. Menggunakan engine Tailwind CSS v4 terbaru yang berorientasi pada token desain CSS native.

---

## 2. Berkas di Dalam Folder

1. `app.css` (1319 baris):
   - Definisi impor font Google, integrasi Tailwind CSS v4, aturan custom properties `:root`, token warna `@theme`, dan kelas utilitas `@layer utilities`.

---

## 3. Kemana Folder Ini Terhubung

- **Didaftarkan di**: `vite.config.js` sebagai input bundler.
- **Dihasilkan ke**: `public/build/assets/app-*.css` saat `npm run build` dijalankan.
- **Dimuat di**: Seluruh layout Blade (`resources/views/layouts/app.blade.php` dan `home.blade.php`).
