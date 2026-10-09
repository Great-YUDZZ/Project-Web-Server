---
title: "Dokumentasi Berkas: vite.config.js"
category: "Berkas Konfigurasi Bundler"
tags:
  - file
  - vite
  - bundler
  - asset-compilation
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: vite.config.js

Path Berkas: `/var/www/project_tkj_yuda2/vite.config.js`
Jumlah Baris: 20 baris

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_config_dan_root]]: Folder konfigurasi sistem.
- [[FILE_app_css]]: File input stylesheet.
- [[FILE_dark_portfolio_js]]: File input JavaScript.

---

## 1. Fungsi & Peran Berkas

Mengatur proses kompilasi bundel aset statis frontend (CSS dan JavaScript) menggunakan Vite 5 dan Tailwind CSS v4. Menghasilkan aset yang telah di-minifikasi dan di-hash ke folder `public/build/assets/` saat `npm run build` dijalankan.

---

## 2. Struktur & Rincian Kode di Dalam Berkas

- **Baris 1-5**: Import fungsi `defineConfig` dari `vite`, plugin `laravel-vite-plugin`, dan `@tailwindcss/vite`.
- **Baris 7-18**:
  - `laravel({ input: ['resources/css/app.css', 'resources/js/app.js'], refresh: true })`:
    Mendaftarkan dua berkas entri utama dan mengaktifkan browser auto-refresh saat file Blade diubah di local dev.
  - `tailwindcss()`:
    Plugin resmi Tailwind v4 berbasis engine Rust LightningCSS.

---

## 3. Panduan Baris Kode Operasional

### A. Jika Ingin MENDAFTARKAN File CSS atau JavaScript Baru Secara Terpisah
- **Buka Baris**: Baris 9-12 (array `input`).
- **Tambahkan**: `'resources/js/nama-skrip-baru.js',`.
- **Eksekusi Wajib**: Jalankan `npm run build`.
