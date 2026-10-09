---
title: "Dokumentasi Berkas: resources/views/partials/tech-flow-columns.blade.php"
category: "Berkas View Partials"
tags:
  - file
  - view-partial
  - tech-showcase
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: resources/views/partials/tech-flow-columns.blade.php

Path Berkas: `/var/www/project_tkj_yuda2/resources/views/partials/tech-flow-columns.blade.php`
Jumlah Baris: 118 baris

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_resources_views]]: Folder view Blade.
- [[FILE_home_blade_php]]: Halaman beranda yang meng-include partial ini.
- [[FILE_dark_portfolio_js]]: Skrip yang menggerakkan animasi kolom vertikal dan membuka modal telemetri.

---

## 1. Fungsi & Peran Berkas

Menampilkan pameran tumpukan teknologi modern (*Tech Stack Showcase*) berupa aliran kolom vertikal kontinu (*infinite continuous flow columns*). Menampilkan 9 pilar teknologi website dan server (PHP 8.4, Laravel 12, Tailwind CSS v4, Vite 5, Debian 13, GSAP 3, Nginx 1.22, MySQL 8.0, dan Three.js). Setiap node lingkaran dapat diklik untuk memicu pembukaan jendela modal spesifikasi teknis interaktif.

---

## 2. Struktur & Rincian Kode di Dalam Berkas

- **Baris 1-70 (`$flowTech` Array)**:
  - Definisi tunggal (*single source of truth*) data kartu teknologi:
    - `name`: Nama resmi teknologi.
    - `role`: Peran fungsional dalam arsitektur website.
    - `color` & `rgb`: Warna aksen resmi dan nilai RGB untuk efek cahaya *glow*.
    - `logo`: Path aset gambar logo PNG resmi di `public/images/tech_logos/`.
    - `svg`: Path aset fallback SVG di `public/images/tech/`.
- **Baris 72-118 (Markup HTML Tiga Kolom Aliran)**:
  - Tiga kontainer kolom dengan kelas `.flow-column`.
  - Node sirkular dengan atribut `data-tech="..."` dan kelas `.tech-circle-orb`.

---

## 3. Kemana Berkas Ini Terhubung

- **Di-include Oleh**: `resources/views/home.blade.php` pada section `#technologies` melalui `@include('partials.tech-flow-columns')`.
- **Digerakkan Oleh**: `resources/js/dark-portfolio.js` pada fungsi `initTechStackShowcase()` (baris 205-336).
- **Membuka Modal**: Berkomunikasi dengan database JavaScript `techDatabase` di `dark-portfolio.js` baris 339-500.

---

## 4. Panduan Baris Kode Operasional

### A. Jika Ingin MENAMBAH Teknologi Baru ke Dalam Aliran
1. **Buka Baris**: Baris 60-70 di dalam array `$flowTech`.
2. **Tambahkan**:
   ```php
   'docker' => [
       'name'  => 'Docker',
       'role'  => 'Containerization',
       'color' => '#2496ED',
       'rgb'   => '36,150,237',
       'logo'  => 'images/tech_logos/docker.png',
       'svg'   => 'images/tech/docker.svg',
   ],
   ```
3. **Buka Berkas**: `resources/js/dark-portfolio.js` pada baris 339-500, tambahkan spesifikasi teknis `docker: { ... }` pada objek `techDatabase`.
4. **Jalankan**: `npm run build`.
