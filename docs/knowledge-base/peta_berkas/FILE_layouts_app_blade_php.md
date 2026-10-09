---
title: "Dokumentasi Berkas: resources/views/layouts/app.blade.php"
category: "Berkas Layout"
tags:
  - file
  - layout
  - master-layout
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: resources/views/layouts/app.blade.php

Path Berkas: `/var/www/project_tkj_yuda2/resources/views/layouts/app.blade.php`
Jumlah Baris: 209 baris

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_resources_views]]: Folder view Blade.
- [[FILE_blog_index_blade_php]]: Halaman katalog blog yang meng-extend layout ini.
- [[FILE_projects_index_blade_php]]: Halaman katalog proyek yang meng-extend layout ini.

---

## 1. Fungsi & Peran Berkas

Master layout induk untuk seluruh halaman publik non-landing page (seperti `/blog`, `/blog/{slug}`, `/projects`, `/projects/{slug}`). Menyediakan kerangka HTML bersama: pemuatan tag meta SEO, token CSRF, font Google, kompilasi Vite (`app.css` & `app.js`), header navigasi kapsul melayang (*floating pill HUD*), drawer navigasi mobile, slot konten `@yield('content')`, serta footer.

---

## 2. Struktur & Rincian Kode di Dalam Berkas

- **Baris 1-25 (`<head>`)**:
  - Judul dinamis `@yield('title', '...')`.
  - Token CSRF `<meta name="csrf-token" content="{{ csrf_token() }}">`.
  - Pemuatan font Outfit, Inter, dan JetBrains Mono.
  - Kompilasi aset Vite `@vite(['resources/css/app.css', 'resources/js/app.js'])`.
- **Baris 33-85 (Header Navigasi Melayang)**:
  - Logo identitas "YP" I Made Yuda Pramana.
  - Tautan menu navigasi desktop: Beranda, Karya, Keahlian, Proyek, Blog, Konsol AI Yuna, dan Kontak.
- **Baris 86-135 (Drawer Navigasi Seluler / Mobile Menu)**:
  - Tombol hamburger dan panel menu geser khusus layar HP.
- **Baris 140-155 (`<main>`)**:
  - Kontainer utama penampung konten dinamis `@yield('content')`.
- **Baris 160-205 (`<footer>`)**:
  - Footer informasi kontak, tautan GitHub/LinkedIn, dan penyertaan widget chatbot Yuna AI.

---

## 3. Panduan Baris Kode Operasional

### A. Jika Ingin MENAMBAH Menu Navigasi Global
- **Buka Baris**: Baris 52-65 (navigasi desktop) dan baris 95-115 (drawer seluler).
- **Tambahkan**:
  ```html
  <a href="{{ route('nama.rute') }}" class="nav-link ...">Nama Menu</a>
  ```

### B. Jika Ingin MENAMBAH Skrip Eksternal atau Tracking Tag
- **Buka Baris**: Baris 24 (sebelum penutup `</head>`).
- **Tambahkan**: Tag `<script>` atau `<meta>` yang diperlukan.
