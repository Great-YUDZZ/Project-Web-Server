---
title: "Dokumentasi Berkas: resources/css/app.css"
category: "Berkas Styling"
tags:
  - file
  - css
  - tailwindcss-v4
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: resources/css/app.css

Path Berkas: `/var/www/project_tkj_yuda2/resources/css/app.css`
Jumlah Baris: 1319 baris

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_resources_css]]: Folder sumber CSS.
- [[05_Frontend_Design_Monokrom]]: Penjelasan filosofi desain monokrom.
- [[06_Tipografi_Geometris]]: Hirarki tipografi Outfit, Inter, JetBrains Mono.

---

## 1. Fungsi & Peran Berkas

Pusat saraf konfigurasi desain visual website. Berkas ini mendefinisikan token warna monokrom, kurva fisika transisi (*spring easing*), binding font keluarga, serta aturan utilitas kustom untuk gradasi akromatik dan efek glassmorphism HUD.

---

## 2. Struktur & Rincian Kode di Dalam Berkas

- **Baris 1**: `@import url('https://fonts.googleapis.com/...');` (Memuat font Outfit, Inter, JetBrains Mono dari CDN Google Fonts).
- **Baris 2-3**: `@import 'tailwindcss';` dan `@import 'swiper/swiper-bundle.css';`.
- **Baris 5-7**: `@source` direktif untuk memindai kelas-kelas di folder views dan vendor paginasi.
- **Baris 9-23 (`:root`)**:
  - Kurva transisi: `--ease-out: cubic-bezier(0.16, 1, 0.3, 1);`, `--ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);`.
  - Durasi: `--duration-fast: 150ms;`, `--duration-normal: 300ms;`, `--duration-slow: 500ms;`.
  - Palet HSL: `--bg: 0 0% 4%;`, `--surface: 0 0% 8%;`, `--text: 0 0% 96%;`.
- **Baris 25-64 (`@theme`)**:
  - Binding font Tailwind:
    - `--font-sans`: 'Inter', sans-serif;
    - `--font-mono`: 'JetBrains Mono', monospace;
    - `--font-display`: 'Outfit', sans-serif;
    - `--font-geometric`: 'Outfit', sans-serif;
  - Token warna monokrom:
    - `--color-bg-dark: #0a0a0a;`
    - `--color-surface-dark: #141414;`
    - `--color-surface-highlight: #1e1e1e;`
    - `--color-text-dark: #f5f5f5;`
    - `--color-muted-slate: #878787;`
    - `--color-stroke-dark: #1f1f1f;`
- **Baris 66-100 (`@layer utilities`)**:
  - Utilitas `.accent-gradient`, `.border-accent-gradient`, animasi `@keyframes scroll-down`, dan `@keyframes role-fade-in`.

---

## 3. Panduan Baris Kode Operasional

### A. Jika Ingin MENGUBAH Warna Gelap Dasar
- **Buka Baris**: Baris 33 (`--color-bg-dark: #0a0a0a;`).
- **Modifikasi**: Ubah `#0a0a0a` ke nilai heksadesimal baru.
- **Kompilasi Wajib**: Jalankan `npm run build` di terminal.

### B. Jika Ingin MENGUBAH Warna Border / Garis Pembatas Kartu
- **Buka Baris**: Baris 38 (`--color-stroke-dark: #1f1f1f;`).
- **Modifikasi**: Ubah `#1f1f1f` ke warna yang lebih terang atau gelap.
- **Kompilasi Wajib**: Jalankan `npm run build`.
