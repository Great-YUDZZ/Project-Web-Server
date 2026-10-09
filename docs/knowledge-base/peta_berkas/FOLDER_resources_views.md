---
title: "Dokumentasi Folder: resources/views/"
category: "Direktori Proyek"
tags:
  - folder
  - views
  - blade-templates
updated_at: "2026-10-09"
---

# Dokumentasi Folder: resources/views/

Path Proyek: `/var/www/project_tkj_yuda2/resources/views/`

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FILE_home_blade_php]]: Template halaman beranda utama.
- [[FILE_layouts_app_blade_php]]: Master layout publik.
- [[FILE_components_tech_flow_columns_blade_php]]: Komponen pameran teknologi vertikal.

---

## 1. Fungsi & Peran Folder

Folder ini menampung seluruh berkas template antarmuka HTML menggunakan mesin Blade template engine bawaan Laravel. Bertanggung jawab menyajikan markup semantik, struktur layout responsif, komponen UI modular, dan pengikatan (*binding*) data dari controller.

---

## 2. Struktur Subdirektori & Berkas Utama

- `home.blade.php`: Halaman beranda utama satu halaman portofolio monokrom.
- `layouts/`:
  - `app.blade.php`: Master layout aplikasi publik (memuat header font, CSS, JS, SEO, dan canvas background).
  - `admin.blade.php`: Master layout panel admin dengan sidebar dan header navigasi.
- `blog/`:
  - `index.blade.php`: Katalog artikel blog dengan bilah pencarian dan filter tag/kategori.
  - `show.blade.php`: Halaman pembaca artikel dengan rekomendasi artikel terkait.
- `projects/`:
  - `index.blade.php`: Katalog seluruh proyek lab.
  - `show.blade.php`: Halaman detail satu proyek teknis.
- `components/`:
  - `tech-flow-columns.blade.php`: Pameran tumpukan teknologi vertikal tak terbatas.
  - `chatbot-widget.blade.php`: Tombol dan dialog floating chat Yuna AI.
  - `pc-hardware-silhouettes.blade.php`: Siluet visual komponen hardware PC lab.
- `admin/`: Subfolder template untuk operasi CRUD proyek, blog, sertifikat, keterampilan, dan pesan masuk.
- `auth/`:
  - `login.blade.php`: Halaman formulir login administrator.
- `ai/`:
  - `index.blade.php`: Halaman penuh konsol interaktif Yuna AI.
- `archive/classic/`:
  - `home.blade.php`: Versi arsip portofolio klasik 2024-2025.

---

## 3. Kemana Folder Ini Terhubung

- **Dipanggil Oleh**: Controller melalui pemanggilan `return view('nama.view', compact(...))`.
- **Memuat Aset**: Mengimpor CSS dan JS hasil kompilasi Vite melalui direktif `@vite(['resources/css/app.css', 'resources/js/app.js'])`.
