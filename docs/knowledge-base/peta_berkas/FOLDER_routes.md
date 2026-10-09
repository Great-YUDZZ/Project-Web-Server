---
title: "Dokumentasi Folder: routes/"
category: "Direktori Proyek"
tags:
  - folder
  - routes
  - url-mapping
updated_at: "2026-10-09"
---

# Dokumentasi Folder: routes/

Path Proyek: `/var/www/project_tkj_yuda2/routes/`

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[13_Peta_Folder_dan_Berkas_Proyek]]: Peta inventarisasi berkas proyek.
- [[FILE_routes_web_php]]: Dokumentasi detail berkas routing web utama.

---

## 1. Fungsi & Peran Folder

Folder `routes/` bertanggung jawab mendefinisikan seluruh titik akhir (*endpoints*) URL dan rute lalu lintas HTTP yang dapat diakses oleh browser klien, API telemetri, serta perintah konsol CLI Artisan.

Folder ini menjadi pemisah utama antara permintaan jaringan luar dengan eksekusi kode internal framework Laravel.

---

## 2. Berkas di Dalam Folder

1. `web.php` (71 baris):
   - Menampung seluruh rute publik (landing page, blog, proyek, form kontak, API telemetri), otentikasi login/logout, dan rute CRUD admin yang terproteksi.
2. `console.php` (8 baris):
   - Menampung perintah kustom terminal Artisan berbasis closure.

---

## 3. Kemana Folder Ini Terhubung

- **Input Dari**: Web server Nginx meneruskan request HTTP ke `public/index.php`, lalu inisialisasi kernel di `bootstrap/app.php` memuat berkas-berkas di dalam `routes/`.
- **Output Ke**: Memetakan URL ke Controller di `app/Http/Controllers/` (`PublicController`, `AuthController`, `ChatbotController`, dan controller di subdirektori `Admin/`).

---

## 4. Panduan Modifikasi Pengembang

- **Kapan Membuka Folder Ini**: Setiap kali ingin membuat halaman baru, menambah endpoint API baru, atau mengubah URL yang ada di browser.
- **Apa yang Harus Ditambahkan**: Tambahkan definisi `Route::get(...)` atau `Route::post(...)` di dalam `web.php`.
- **Apa yang Harus Dihapus**: Jika ingin menonaktifkan fitur atau halaman tertentu, hapus baris `Route::...` yang bersangkutan.
