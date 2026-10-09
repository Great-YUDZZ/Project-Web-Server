---
title: "Dokumentasi Berkas: resources/js/dark-portfolio.js"
category: "Berkas JavaScript"
tags:
  - file
  - javascript
  - gsap
  - scroll-spy
  - interactions
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: resources/js/dark-portfolio.js

Path Berkas: `/var/www/project_tkj_yuda2/resources/js/dark-portfolio.js`
Jumlah Baris: 651 baris

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_resources_js]]: Folder sumber JavaScript.
- [[FILE_home_blade_php]]: Halaman beranda yang dimanipulasi oleh skrip ini.
- [[FILE_components_tech_flow_columns_blade_php]]: Komponen yang didengarkan event klik-nya oleh skrip ini.

---

## 1. Fungsi & Peran Berkas

Mengorkestrasi seluruh interaksi dinamis pada landing page beranda monokrom: memicu animasi masuk teks hero menggunakan GSAP 3, memutar video latar belakang HLS, melacak posisi scroll secara real-time untuk memberi sorotan aktif pada floating HUD navbar (*scroll-spy*), menggerakkan perputaran kartu teknologi tanpa henti (*infinite vertical flow*), serta membuka modal spesifikasi teknologi lengkap dengan empat boundary states (*Skeleton, Success, Error, Retry*).

---

## 2. Struktur & Rincian Method di Dalam Berkas

- **Baris 25-31 (`initLoadingScreen()`)**:
  - Menghapus elemen `#dark-loading-screen` seketika untuk performa instan tanpa jeda, kemudian memanggil `initHeroEntrance()`.
- **Baris 34-47 (`initHeroEntrance()`)**:
  - GSAP timeline untuk memunculkan `.name-reveal` (Y: 50 -> 0) dan efek `.blur-in` bertingkat (filter: blur(10px) -> 0px).
- **Baris 49-70 (`initHlsVideos()`)**:
  - Inisialisasi streaming video HLS melalui pustaka `hls.js` untuk latar belakang hero dan footer.
- **Baris 120-202 (`initNavbar()`)**:
  - **Dynamic Scroll-Spy**: Menghitung `triggerPoint = scrollY + (windowHeight * 0.35)` di dalam callback `requestAnimationFrame`. Menandai link aktif (`text-white`, `bg-white/15`) sesuai section yang terlihat di layar.
  - Menangani smooth scroll saat menu navbar diklik.
- **Baris 205-336 (`initTechStackShowcase()`)**:
  - Menghitung tinggi kartu dan perputaran kolom vertikal tak terbatas menggunakan GSAP ticker. Menghentikan animasi saat berada di luar viewport menggunakan `IntersectionObserver`.
- **Baris 339-500 (`techDatabase`)**:
  - Database JSON spesifikasi lengkap untuk 9 teknologi (PHP 8.4, Laravel 12, Tailwind CSS v4, Vite 5, GSAP 3, Nginx 1.22, Debian 13, MariaDB, Three.js).
- **Baris 504-580 (`openTechModal()`)**:
  - Membuka modal dengan transisi GSAP dan menampilkan state *Loading Skeleton* selama 120ms sebelum menyuntikkan data spesifikasi (*Success State*).
- **Baris 631-641 (`initMarquee()`)**:
  - Animasi teks berjalan continuous loop di footer (`xPercent: -50`, durasi 35 detik, repeat: -1).

---

## 3. Panduan Baris Kode Operasional

### A. Jika Ingin MENAMBAH Teknologi Baru ke Modal Interaktif
- **Buka Baris**: Baris 339-500 (objek `techDatabase`).
- **Tambahkan**: Entri objek baru dengan properti `title`, `badge`, `subhead`, `color`, `logo`, `explanation`, `rationale`, dan array `specs`.

### B. Jika Ingin MENGUBAH Durasi Animasi Teks Berjalan di Footer
- **Buka Baris**: Baris 637 (`duration: 35`).
- **Modifikasi**: Ubah angka 35 menjadi angka yang lebih kecil (untuk gerakan lebih cepat) atau lebih besar (untuk gerakan lebih lambat).

### C. Jika Ingin MENYESUAIKAN Sensitivitas Highlight Scroll-Spy
- **Buka Baris**: Baris 156 (`const triggerPoint = scrollY + (windowHeight * 0.35);`).
- **Modifikasi**: Sesuaikan persentase `0.35`.
- **Kompilasi Wajib**: Jalankan `npm run build` setelah setiap perubahan.
