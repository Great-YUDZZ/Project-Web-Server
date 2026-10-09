---
title: "Resep Modifikasi Frontend: Blade Views, Tailwind CSS, & Skrip JavaScript"
category: "Playbook / Frontend Development"
tags:
  - frontend-playbook
  - blade-views
  - tailwindcss
  - gsap
  - threejs
  - line-by-line
updated_at: "2026-10-09"
---

# Resep Modifikasi Frontend: Blade Views, Tailwind CSS, & Skrip JavaScript

Dokumen ini adalah pedoman langsung bagi pengembang yang ingin **menambah**, **mengubah**, atau **menghapus** komponen antarmuka pengguna (UI), tema warna, tipografi, dan animasi interaktif. Dilengkapi referensi nomor baris kode dan relasi antar-komponen.

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[05_Frontend_Design_Monokrom]]: Desain sistem monokrom murni.
- [[06_Tipografi_Geometris]]: Hirarki tipografi Outfit, Inter, dan JetBrains Mono.
- [[07_Animasi_Interaksi_Visual]]: Spesifikasi teknis animasi GSAP dan WebGL.
- [[13_Peta_Folder_dan_Berkas_Proyek]]: Peta inventarisasi seluruh berkas proyek.
- [[14_Resep_Modifikasi_Backend]]: Penyedia data dari Controller ke View Blade.

---

## 1. Modifikasi Desain & Warna (`resources/css/app.css`)

Berkas ini mengontrol seluruh styling Tailwind CSS v4 dan variabel CSS global.

### A. Mengubah Palet Warna Monokrom
- **Buka Berkas**: `resources/css/app.css`
- **Lokasi Baris**: Baris 33 hingga 38 (di dalam blok `@theme`).
- **Baris Kode & Nilai**:
  ```css
  --color-bg-dark: #0a0a0a;          /* Latar belakang utama halaman */
  --color-surface-dark: #141414;     /* Latar belakang kartu kontainer */
  --color-surface-highlight: #1e1e1e;/* Latar kartu saat disentuh/hover */
  --color-text-dark: #f5f5f5;        /* Warna teks utama kontras tinggi */
  --color-muted-slate: #878787;      /* Warna teks keterangan sekunder */
  --color-stroke-dark: #1f1f1f;      /* Warna garis border 1px */
  ```
- **Langkah Modifikasi**: Ubah kode heksadesimal warna pada baris yang sesuai, kemudian jalankan kompilasi:
  ```bash
  npm run build
  ```
- **Keterhubungan**: Nilai variabel ini langsung memengaruhi ribuan elemen HTML di seluruh view Blade yang menggunakan utilitas seperti `bg-bg-dark`, `bg-surface-dark`, `border-stroke-dark`, dan `text-muted-slate`.

### B. Menambahkan Font Google Baru
- **Buka Berkas**: `resources/css/app.css`
- **Lokasi Baris**: Baris 1 (`@import url('https://fonts.googleapis.com/...');`).
- **Langkah Penambahan**:
  1. Tambahkan nama keluarga font baru ke URL `@import`.
  2. Buka baris 26-30 di blok `@theme` untuk mendaftarkan variabel font Tailwind baru:
     ```css
     --font-kustom: 'NamaFontBaru', sans-serif;
     ```
  3. Jalankan `npm run build`.

---

## 2. Modifikasi Halaman Beranda (`resources/views/home.blade.php`)

Berkas ini adalah template utama satu halaman (*single-page layout*).

### A. Mengubah Bagian Headline Sambutan (Hero Section)
- **Buka Berkas**: `resources/views/home.blade.php`
- **Pencarian Elemen**: Cari tag `<section id="hero" ...>`.
- **Lokasi Modifikasi**:
  - Teks nama dan spesialisasi rekayasa berada di elemen dengan kelas `name-reveal`.
  - Teks status telemetri server berada di elemen kartu kecil berbingkai `border-stroke-dark`.
- **Keterhubungan**: Elemen dengan kelas `name-reveal` dipicu secara otomatis oleh GSAP di `dark-portfolio.js` saat halaman dimuat.

### B. Menambahkan Menu Tautan Baru pada Floating HUD Navbar
- **Buka Berkas**: `resources/views/home.blade.php`
- **Pencarian Elemen**: Cari kontainer `<nav ... id="floating-navbar">`.
- **Langkah Penambahan**:
  - Tambahkan tag tautan baru di dalam kontainer navigasi:
    ```html
    <a href="#nama-section" class="nav-link px-3 py-1.5 rounded-full text-xs transition-colors duration-200 text-[#878787] hover:text-white">
        Label Menu
    </a>
    ```
- **Keterhubungan Sangat Penting**:
  - Nilai `href="#nama-section"` harus cocok dengan atribut `id="nama-section"` pada elemen bagian halaman target.
  - Skrip scroll-spy di `resources/js/dark-portfolio.js` baris 120-170 secara otomatis mendeteksi tautan ini dan memberinya efek highlight saat pengunjung menggulir ke bagian tersebut.

---

## 3. Modifikasi Tumpukan Teknologi (`resources/views/components/tech-flow-columns.blade.php`)

Komponen ini menampilkan aliran vertikal logo dan modal detail teknologi (PHP 8.4, Laravel 12, Vite, Tailwind CSS v4, Debian 13, GSAP 3, Nginx 1.22, MySQL 8.0, Three.js).

### A. Menambahkan Teknologi Baru ke Dalam Tampilan Aliran
- **Buka Berkas**: `resources/views/components/tech-flow-columns.blade.php`
- **Langkah Penambahan**:
  1. Buat node lingkaran baru di dalam kolom yang diinginkan dengan menyertakan atribut `data-tech`:
     ```html
     <div class="tech-circle-orb cursor-pointer" data-tech="docker">
         <img src="/images/tech_logos/docker.png" alt="Docker" class="w-8 h-8 object-contain" />
     </div>
     ```
  2. Buka `resources/js/dark-portfolio.js` pada baris 339-500 (objek `techDatabase`). Tambahkan entri data baru untuk kunci `"docker"`:
     ```javascript
     docker: {
         title: "Docker Engine",
         badge: "[CONTAINER VIRTUALIZATION]",
         subhead: "Isolated Containerized Microservice Environment",
         color: "#2496ED",
         logo: "/images/tech_logos/docker.png",
         explanation: "Platform virtualisasi container untuk mengisolasi layanan...",
         rationale: "Menjamin replikasi lingkungan laboratorium yang identik...",
         specs: [
             { label: "ENGINE", value: "Docker CE v27" },
             { label: "STORAGE DRIVER", value: "overlay2" }
         ]
     },
     ```
  3. Jalankan `npm run build`.
- **Keterhubungan**: Saat pengunjung mengklik ikon Docker, sistem akan membuka modal interaktif dengan spesifikasi teknis dan efek cahaya sesuai warna `#2496ED`.

---

## 4. Modifikasi Orkestrasi JavaScript (`resources/js/dark-portfolio.js`)

Berkas ini mengelola interaksi, scroll-spy navbar, dan micro-interactions.

### A. Mengubah Kecepatan Animasi Masuk Hero
- **Buka Berkas**: `resources/js/dark-portfolio.js`
- **Lokasi Baris**: Baris 34 hingga 47 (fungsi `initHeroEntrance()`).
- **Modifikasi**:
  - `duration: 1.2`: Ubah angka durasi untuk mempercepat atau memperlambat gerakan naik teks nama.
  - `delay: 0.1`: Jeda waktu sebelum animasi dimulai setelah loading screen ditiadakan.

### B. Menyesuaikan Sensitivitas Titik Pemicu Scroll-Spy Navbar
- **Buka Berkas**: `resources/js/dark-portfolio.js`
- **Lokasi Baris**: Baris 156:
  ```javascript
  const triggerPoint = scrollY + (windowHeight * 0.35);
  ```
- **Modifikasi**: Ubah pengali `0.35` (35% dari tinggi jendela layar). Jika Anda ingin menu berubah lebih cepat saat baru menyentuh bagian atas layar, turunkan ke `0.20`. Jika ingin menu baru berubah saat section berada tepat di tengah layar, ubah ke `0.50`.

---

## 5. Modifikasi Latar Belakang Tiga Dimensi (`resources/js/interactive-bg.js`)

Berkas ini mengontrol kanvas partikel bintang 3D Three.js.

### A. Mengubah Jumlah Partikel Bintang
- **Buka Berkas**: `resources/js/interactive-bg.js`
- **Pencarian Baris**: Cari konstanta jumlah bintang (biasanya didefinisikan sebagai `STAR_COUNT` atau ukuran buffer array).
- **Modifikasi**: Sesuaikan jumlah partikel (standar: 600 hingga 1000 partikel untuk performa optimal pada perangkat mobile).

### B. Mengubah Jarak Reaksi Pantulan Kursor Mouse (*Repulsion Distance*)
- **Buka Berkas**: `resources/js/interactive-bg.js`
- **Pencarian Baris**: Cari perhitungan jarak vektor kursor (`distance < threshold`).
- **Modifikasi**: Memperbesar ambang batas (*threshold*) akan membuat partikel bintang menghindar lebih jauh saat kursor mendekat.
- **Kompilasi Wajib**: Selalu jalankan `npm run build` setelah menyunting berkas ini.
