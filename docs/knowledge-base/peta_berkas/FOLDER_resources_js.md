---
title: "Dokumentasi Folder: resources/js/"
category: "Direktori Proyek"
tags:
  - folder
  - javascript
  - animations
  - frontend-engine
updated_at: "2026-10-09"
---

# Dokumentasi Folder: resources/js/

Path Proyek: `/var/www/project_tkj_yuda2/resources/js/`

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FILE_dark_portfolio_js]]: Skrip interaksi landing page utama.
- [[FILE_interactive_bg_js]]: Skrip render latar belakang 3D Three.js.
- [[07_Animasi_Interaksi_Visual]]: Rekayasa animasi 60 FPS.

---

## 1. Fungsi & Peran Folder

Folder ini menampung seluruh skrip logika sisi klien (Client-Side JavaScript) sebelum dikompilasi oleh bundler Vite. Menggerakkan micro-interactions, animasi timeline GSAP 3, rendering WebGL kanvas Three.js, polling telemetri AJAX, dan dynamic scroll-spy navbar.

---

## 2. Berkas di Dalam Folder

1. `app.js` (550 baris):
   - Entry point utama JavaScript yang dimuat oleh layout Blade. Mengimpor dan menginisialisasi modul-modul turunan.
2. `dark-portfolio.js` (651 baris):
   - Mengorkestrasi interaksi DOM pada landing page: peniadaan loading screen buatan, animasi hero entrance GSAP, pelacakan scroll-spy navbar, infinite vertical tech columns, dan modal telemetri.
3. `interactive-bg.js` (541 baris):
   - Engine grafis 3D Three.js WebGL yang merender hamparan partikel bintang (*starfield*) dengan deteksi pergerakan kursor dan fallback 2D.
4. `gsap-animations.js` & `labs-rotator.js` & `orrery-gallery.js`:
   - Modul pendukung untuk animasi tambahan dan galeri orrery.

---

## 3. Kemana Folder Ini Terhubung

- **Didaftarkan di**: `vite.config.js` (`resources/js/app.js`).
- **Dihasilkan ke**: `public/build/assets/app-*.js` saat proses build.
- **Dimuat di**: `<head>` dokumen Blade melalui `@vite(['...', 'resources/js/app.js'])`.
