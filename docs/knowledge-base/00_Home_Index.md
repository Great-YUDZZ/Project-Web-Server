---
title: "Peta Konten Utama (Central MOC) - Portofolio & Lab TKJ Yuda Pramana"
category: "Index / Map of Content"
tags:
  - moc
  - index
  - architecture
  - documentation
updated_at: "2026-10-09"
---

# Perpustakaan Pengetahuan Teknis Proyek (Central MOC)

Selamat datang di repositori pengetahuan dan dokumentasi arsitektur komprehensif untuk aplikasi web **Portofolio & Showcase Lab TKJ (Teknik Komputer dan Jaringan)** milik **I Made Yuda Pramana**.

Dokumen ini berfungsi sebagai **Map of Content (MOC)** atau pusat saraf repositori di Obsidian. Seluruh modul catatan teknis dihubungkan secara dua arah (*bidirectional wikilinks*) sehingga keterkaitan antar-komponen dapat dijelajahi secara visual melalui fitur **Graph View** di Obsidian.

---

## 1. Peta Navigasi Modul Catatan

Gunakan tautan di bawah ini untuk menjelajahi setiap aspek rekayasa web:

### Fondasi Infrastruktur & Backend
- [[01_Infrastruktur_LEMP]]: Arsitektur server baremetal Debian 13, konfigurasi web server Nginx 1.22, dan runtime UNIX socket PHP 8.4-FPM.
- [[02_Backend_Laravel_Framework]]: Struktur aplikasi Laravel 12, siklus hidup request (*lifecycle*), middleware pipeline, dan routing MVC.
- [[03_Telemetri_Linux_Kernel]]: Cara kerja `ServerMonitorService` dalam mengekstrak metrik langsung dari virtual filesystem Linux `/proc`.
- [[04_Skema_Database_Relasional]]: Desain basis data MariaDB/MySQL, tabel relasional, migrasi, dan seeder data teknis.

### Antarmuka & Sistem Desain
- [[05_Frontend_Design_Monokrom]]: Filosofi desain monokrom murni (hitam, abu-abu, putih), token Tailwind CSS v4, dan prinsip anti-slop.
- [[06_Tipografi_Geometris]]: Hirarki tipografi modern yang mengadopsi font Outfit (geometris), Inter (body), dan JetBrains Mono (data/kode).
- [[07_Animasi_Interaksi_Visual]]: Rekayasa animasi Canvas 3D Starfield, floating HUD navbar dengan dynamic scroll-spy, dan Swiper coverflow 3D.

### Fitur Fungsional & Keamanan
- [[08_Modul_Blog_Pribadi]]: Arsitektur katalog blog publik, pembaca artikel, estimasi waktu baca, dan penyaring kategori.
- [[09_Modul_Kontak_Security]]: Penanganan transmisi pesan, verifikasi token CSRF, sanitasi input, dan pencegahan bot spam.
- [[10_Admin_Panel_Otentikasi]]: Sistem otentikasi sesi, proteksi session fixation, dan antarmuka manajemen data CRUD.

### Operasional & Bedah Rasionalitas Kode
- [[11_Panduan_Operasional_CLI]]: Cheatsheet perintah harian Laravel Artisan, kompilasi Vite, status service Linux, dan prosedur backup.
- [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]]: **Bedah mendalam alasan keberadaan setiap baris kode**, kemana kode tersebut terhubung, dan justifikasi keputusan teknis di balik setiap file.

### Katalog Berkas & Resep Pengembangan Cepat (Token-Saving Playbooks)
- [[00_Index_Peta_Berkas]]: **Indeks Navigasi Berkas & Folder Individual** (berisi dokumentasi tersendiri untuk setiap folder dan berkas proyek).
- [[13_Peta_Folder_dan_Berkas_Proyek]]: Inventarisasi seluruh pohon direktori dan peran setiap berkas proyek.
- [[14_Resep_Modifikasi_Backend]]: Resep baris per baris saat menambah/mengubah rute, controller, model, dan telemetri.
- [[15_Resep_Modifikasi_Frontend_dan_Views]]: Resep baris per baris saat mengubah tampilan Blade, warna CSS, dan interaksi JavaScript.
- [[16_Resep_Modifikasi_Database_dan_DevOps]]: Resep baris per baris saat migrasi tabel, penambahan seeder, dan konfigurasi server.

---

## 2. Ringkasan Eksekutif Sistem

| Parameter | Spesifikasi Teknis | Keterangan |
|---|---|---|
| **Nama Proyek** | Web Portofolio & Lab TKJ Yuda Pramana | Platform showcase lab mandiri & jurnal rekayasa |
| **Lingkungan Host** | Linux Debian 13 (Baremetal) | Server fisik mandiri berkinerja tinggi |
| **Web Server** | Nginx 1.22+ | Menangani port 80/443, SSL, dan reverse proxy FastCGI |
| **Runtime Backend** | PHP 8.4-FPM (`php8.4-fpm.sock`) | Engine pemroses logika server-side Laravel |
| **Framework Backend** | Laravel Framework 12 | Framework modern MVC, Eloquent ORM, dan Blade Engine |
| **Database Engine** | MariaDB 11.8+ / MySQL 8.0 | RDBMS relasional bertenaga mesin InnoDB |
| **Frontend Styling** | Tailwind CSS v4.0.0 | Desain monokrom presisi tinggi berbasis token `@theme` |
| **Frontend Engine** | Vanilla JS + GSAP 3 + Three.js | Performa 60 FPS bebas jank tanpa runtime bundle berat |

---

## 3. Relasi Antar-Modul (Graph View Connectivity)

Dalam Graph View Obsidian, modul-modul ini membentuk klaster pengetahuan:
- Klaster **Server & Kernel**: [[01_Infrastruktur_LEMP]] terhubung erat dengan [[03_Telemetri_Linux_Kernel]] dan [[11_Panduan_Operasional_CLI]].
- Klaster **Logika Backend**: [[02_Backend_Laravel_Framework]] bertindak sebagai jembatan yang menghubungkan [[04_Skema_Database_Relasional]], [[08_Modul_Blog_Pribadi]], [[09_Modul_Kontak_Security]], dan [[10_Admin_Panel_Otentikasi]].
- Klaster **Visual & Interaksi**: [[05_Frontend_Design_Monokrom]] bertaut langsung dengan [[06_Tipografi_Geometris]] dan [[07_Animasi_Interaksi_Visual]].
- Klaster **Rasionalitas**: [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]] merangkul seluruh modul dan menjelaskan latar belakang pembuatannya.
- Klaster **Panduan Aksi Pengembang**: [[13_Peta_Folder_dan_Berkas_Proyek]] bercabang langsung ke [[14_Resep_Modifikasi_Backend]], [[15_Resep_Modifikasi_Frontend_dan_Views]], dan [[16_Resep_Modifikasi_Database_dan_DevOps]] sebagai petunjuk operasional baris kode.

---

*Catatan: Dokumen ini diperbarui secara berkala seiring perkembangan arsitektur sistem proyek.*
