---
title: "Dokumentasi Berkas: resources/views/home.blade.php"
category: "Berkas View"
tags:
  - file
  - view
  - home-page
  - landing-page
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: resources/views/home.blade.php

Path Berkas: `/var/www/project_tkj_yuda2/resources/views/home.blade.php`
Jumlah Baris: 1185 baris

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_resources_views]]: Folder view Blade.
- [[FILE_PublicController_php]]: Controller yang merender view ini.
- [[FILE_dark_portfolio_js]]: Skrip penggerak animasi DOM halaman ini.
- [[FILE_interactive_bg_js]]: Skrip perender canvas partikel `#interactive-bg`.

---

## 1. Fungsi & Peran Berkas

Halaman beranda utama satu halaman (*single-page portfolio*) berdesain monokrom presisi tinggi. Menggabungkan seluruh showcase portofolio: latar belakang 3D Three.js, floating HUD navbar dengan pelacakan scroll aktif, kartu telemetri server Linux fisik, showcase proyek unggulan, pameran keterampilan teknis, aliran teknologi tanpa henti (*tech flow columns*), pameran sertifikasi, formulir kontak publik, serta footer interaktif.

---

## 2. Struktur Section & Nomor Baris Penting

- **Baris 1-36**: Dokumen HTML `<head>`, meta tag, font Google (Outfit, Inter, JetBrains Mono), dan pemuatan Vite (`app.css`, `app.js`).
- **Baris 45-56**: Kontainer kanvas bintang 3D `<canvas id="interactive-bg">` dan kisi grid geometris.
- **Baris 58-115**: Floating HUD Navbar (`#dark-nav-pill`) dengan menu: Beranda (`#hero`), Profil (`#about`), Keterampilan (`#skills`), Proyek (`#projects`), Teknologi (`#technologies`), Sertifikasi (`#certificates`), dan Kontak (`#contact`).
- **Baris 120-350**: **Section Hero (`#hero`)**:
  - Teks judul nama dan spesialisasi dengan kelas animasi `name-reveal` dan `blur-in`.
  - Kartu indikator telemetri live server (CPU load, RAM usage, storage, uptime, database version).
  - Kartu showcase 2 proyek unggulan hero.
- **Baris 355-520**: **Section Profil & Lab TKJ (`#about`)**:
  - Penjelasan rekayasa lab mandiri, server Debian fisik, dan spesialisasi infrastruktur jaringan.
- **Baris 525-680**: **Section Keterampilan (`#skills`)**:
  - Kategori Networking, SysAdmin, Hardware, dan Tools.
- **Baris 685-820**: **Section Proyek Pilihan (`#projects`)**:
  - Grid kartu proyek unggulan dan tautan menuju katalog lengkap `/projects`.
- **Baris 825-860**: **Section Teknologi (`#technologies`)**:
  - Memasukkan komponen `@include('components.tech-flow-columns')`.
- **Baris 865-980**: **Section Sertifikat Lisensi (`#certificates`)**:
  - Kartu sertifikasi Cisco, MikroTik, BNSP dengan modal pratinjau PDF.
- **Baris 985-1100**: **Section Formulir Kontak (`#contact`)**:
  - Form kirim pesan dengan token CSRF (`@csrf`), feedback alert sesi, dan input sender_name, email, subject, message.
- **Baris 1105-1185**: Footer, teks berjalan (*marquee track*), dan hak cipta.

---

## 3. Kemana Berkas Ini Terhubung

- **Dirender Oleh**: `PublicController@index` ([app/Http/Controllers/PublicController.php](file:///var/www/project_tkj_yuda2/app/Http/Controllers/PublicController.php#L49)).
- **Menerima Data**: Variabel `$skills`, `$heroProjects`, `$featuredProjects`, `$certificates`, `$serverMetrics`, `$projectsCount`.
- **Dimanipulasi JavaScript**:
  - `resources/js/dark-portfolio.js` (GSAP entrance, scroll-spy navbar, marquee, modal tech).
  - `resources/js/interactive-bg.js` (WebGL Three.js canvas `#interactive-bg`).

---

## 4. Panduan Baris Kode Operasional

### A. Jika Ingin MENAMBAH Menu Baru pada Floating Navbar
- **Buka Baris**: Baris 70-100 (di dalam `#dark-nav-pill`).
- **Tambahkan**:
  ```html
  <a href="#id-section-baru" class="nav-link px-3 py-1 text-xs text-[#878787] hover:text-white rounded-full transition-colors">
      Label Baru
  </a>
  ```
- **Keterhubungan**: Pastikan Anda membuat `<section id="id-section-baru">` di dalam `home.blade.php` agar scroll-spy di `dark-portfolio.js` dapat melacak posisinya secara otomatis.

### B. Jika Ingin MENGUBAH Teks Sambutan di Hero Section
- **Buka Baris**: Sekitar baris 150-180 (di dalam elemen `.name-reveal`).
- **Ubah**: Teks nama, headline, atau subjudul deskripsi.

### C. Jika Ingin MENONAKTIFKAN Efek Partikel Bintang Kanvas
- **Buka Baris**: Baris 51 (`<canvas id="interactive-bg" ...>`).
- **Tindakan**: Beri komentar atau sembunyikan dengan kelas CSS `hidden`.
