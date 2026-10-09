---
title: "Dokumentasi Berkas: resources/js/interactive-bg.js"
category: "Berkas JavaScript"
tags:
  - file
  - javascript
  - threejs
  - webgl
  - canvas-3d
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: resources/js/interactive-bg.js

Path Berkas: `/var/www/project_tkj_yuda2/resources/js/interactive-bg.js`
Jumlah Baris: 541 baris

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_resources_js]]: Folder sumber JavaScript.
- [[FILE_home_blade_php]]: Memanipulasi elemen `<canvas id="interactive-bg">`.
- [[07_Animasi_Interaksi_Visual]]: Rekayasa grafis WebGL 3D.

---

## 1. Fungsi & Peran Berkas

Merender kanvas partikel bintang 3D interaktif (*Interactive 3D White Starfield Engine*) berbasis Three.js WebGL 2.0. Menghasilkan efek penjelajahan ruang angkasa saat pengguna menggulir halaman (*scroll-linked celestial voyage*), efek repulsi kursor kustom dengan pegas elastis (*spring return physics*), serta mekanisme fallback otomatis ke HTML5 Canvas 2D native jika perangkat tidak mendukung WebGL.

---

## 2. Struktur & Rincian Kode di Dalam Berkas

- **Baris 15-43 (`initInteractiveBackground()`)**:
  - Memeriksa dukungan WebGL browser via `isWebGLSupported()`.
  - Jika didukung, panggil `initThreeJsBackground(canvas)`.
  - Jika gagal atau tidak didukung, secara mulus beralih ke `init2DFallback(canvas)`.
- **Baris 48-180 (`initThreeJsBackground(canvas)`)**:
  - Konfigurasi `THREE.WebGLRenderer` (alpha true, antialias true).
  - Pembentukan geometri partikel menggunakan `THREE.BufferGeometry` dan `Float32Array`.
  - Konfigurasi kamera perspektif `THREE.PerspectiveCamera`.
  - Event listener pelacakan kursor mouse dan nilai scroll jendela.
  - Loop perenderan `requestAnimationFrame` dengan komputasi efisien (< 0.1ms per frame).
- **Baris 185-350 (`init2DFallback(canvas)`)**:
  - Logika perenderan alternatif 2D murni berbasis konteks `canvas.getContext('2d')`.

---

## 3. Panduan Baris Kode Operasional

### A. Jika Ingin MENYESUAIKAN Jarak Reaksi Kursor Mouse terhadap Bintang
- Cari variabel radius repulsi kursor mouse di dalam fungsi perenderan (biasanya bernama `repulsionRadius` atau `mouseDistThreshold`).
- Perbesar angka untuk membuat lingkaran tolakan lebih luas.

### B. Jika Ingin MENGHENTIKAN Animasi pada Mode Hemat Daya
- Di awal berkas, skrip telah memeriksa `window.matchMedia('(prefers-reduced-motion: reduce)')`. Jika aktif, komputasi pergerakan dinonaktifkan secara otomatis untuk mematuhi standar aksesibilitas WCAG.
- **Kompilasi Wajib**: Jalankan `npm run build` setelah setiap perubahan.
