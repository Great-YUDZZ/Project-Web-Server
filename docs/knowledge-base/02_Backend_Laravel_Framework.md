---
title: "Arsitektur Backend Framework Laravel 12"
category: "Backend / Application Layer"
tags:
  - laravel
  - php
  - backend
  - mvc
  - architecture
updated_at: "2026-10-09"
---

# Arsitektur Backend Framework Laravel 12

Dokumen ini menguraikan struktur inti, siklus hidup eksekusi request (*request lifecycle*), konfigurasi middleware, dan pemetaan routing pada aplikasi web portofolio dan lab TKJ yang dibangun di atas **Laravel Framework 12**.

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Kembali ke pusat navigasi dokumentasi.
- [[01_Infrastruktur_LEMP]]: Ekosistem server Nginx dan runtime PHP 8.4-FPM yang mengeksekusi Laravel.
- [[03_Telemetri_Linux_Kernel]]: Integrasi service telemetri internal `ServerMonitorService`.
- [[04_Skema_Database_Relasional]]: Interaksi model Eloquent dengan tabel database MariaDB.
- [[08_Modul_Blog_Pribadi]]: Implementasi logika publikasi dan query artikel.
- [[09_Modul_Kontak_Security]]: Validasi request HTTP dan pencegahan serangan CSRF.
- [[10_Admin_Panel_Otentikasi]]: Manajemen sesi administratif dan kontrol akses.
- [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]]: Penjelasan rasionalitas setiap file controller dan service.

---

## 1. Request Lifecycle (Siklus Hidup Permintaan)

Alur penanganan permintaan dari client hingga response dikembalikan ke browser berjalan melalui tahapan berikut:

1. **Titik Masuk (Entrypoint)**:
   - Permintaan HTTP diterima oleh Nginx, kemudian diteruskan melalui FastCGI UNIX socket ke `public/index.php`.
   - File ini memuat autoloader Composer (`vendor/autoload.php`) dan menginisialisasi instance aplikasi Laravel dari `bootstrap/app.php`.

2. **Inisialisasi Aplikasi (`bootstrap/app.php`)**:
   - Di Laravel 12, konfigurasi routing, middleware, dan penanganan exception disederhanakan dalam satu konfigurasi terpadu di `bootstrap/app.php`.
   - Middleware global, grup `web`, dan penanganan error terdaftar di sini tanpa memerlukan file `Http/Kernel.php` warisan versi terdahulu.

3. **Routing Pipeline (`routes/web.php` & `routes/api.php`)**:
   - Router mencocokkan metode HTTP (GET, POST, PUT, DELETE) dan path URI.
   - Request dialirkan melalui middleware web (seperti pemulihan sesi, enkripsi cookie, dan proteksi CSRF).

4. **Eksekusi Controller & Service Layer**:
   - Controller yang dituju menerima objek `Illuminate\Http\Request` yang tervalidasi.
   - Controller berinteraksi dengan Eloquent Model atau memanggil Service class khusus (seperti `ServerMonitorService`).

5. **Rendering View atau JSON Response**:
   - Untuk route web publik, controller mengembalikan view Blade yang terkompilasi.
   - Untuk route telemetri (`/api/metrics`), controller mengembalikan `JsonResponse` dengan header HTTP yang sesuai.

---

## 2. Struktur Direktori Inti Aplikasi

Berikut adalah tata letak folder dan file aplikasi di direktori `/var/www/project_tkj_yuda2`:

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── AuthController.php       # Otentikasi sesi login/logout admin
│   │   │   ├── CertificateController.php # CRUD sertifikat kompetensi
│   │   │   ├── DashboardController.php   # Dashboard analitik & ringkasan server
│   │   │   ├── MessageController.php     # Manajemen pesan masuk dari form kontak
│   │   │   ├── PostController.php        # Manajemen publikasi artikel blog
│   │   │   ├── ProjectController.php     # Manajemen portofolio proyek
│   │   │   └── SettingController.php     # Konfigurasi profil & metadata web
│   │   ├── ContactController.php         # Handler pengiriman pesan publik
│   │   ├── Controller.php                # Base controller abstrak
│   │   ├── HomeController.php             # Render landing page utama portofolio
│   │   ├── MetricsController.php          # Endpoint API telemetri JSON
│   │   └── PostController.php            # Render katalog dan detail artikel blog publik
│   └── Middleware/                       # Middleware kustom (jika diperlukan)
├── Models/
│   ├── Admin.php                         # Otentikasi entitas administrator
│   ├── Certificate.php                   # Model data sertifikat
│   ├── ContactMessage.php                # Model data pesan kontak masuk
│   ├── Post.php                          # Model data postingan blog
│   ├── Project.php                       # Model data proyek portofolio
│   ├── ServerMetric.php                  # Model histori telemetri (opsional)
│   ├── Setting.php                       # Model key-value pengaturan sistem
│   └── User.php                          # Model user standar
└── Services/
    └── ServerMonitorService.php          # Service parser virtual filesystem /proc
```

---

## 3. Peta Routing Web & API

Daftar rute yang aktif diklasifikasikan menjadi tiga domain fungsional:

### A. Rute Publik (`routes/web.php`)
- `GET /`: Menampilkan landing page utama (`HomeController@index`), mencakup hero, profil, showcase lab, portofolio proyek, sertifikat, dan form kontak.
- `GET /blog`: Menampilkan katalog artikel blog (`PostController@index`) dengan fitur pencarian dan filter tag/kategori.
- `GET /blog/{slug}`: Menampilkan detail artikel blog (`PostController@show`) dengan estimasi waktu baca dan artikel terkait.
- `POST /contact`: Menerima pengiriman formulir kontak (`ContactController@store`) dengan validasi ketat dan pesan flash sesi.

### B. Rute Telemetri API (`routes/web.php` / `routes/api.php`)
- `GET /api/metrics`: Mengembalikan data metrik realtime dalam format JSON (`MetricsController@index`) yang dikonsumsi oleh widget telemetri frontend.

### C. Rute Administratif Terproteksi (`routes/web.php` prefix `admin`)
- `GET /admin/login`: Form otentikasi login admin (`Admin\AuthController@showLoginForm`).
- `POST /admin/login`: Proses validasi kredensial login (`Admin\AuthController@login`) dengan proteksi brute force rate limiting.
- `POST /admin/logout`: Menghancurkan sesi aktif admin (`Admin\AuthController@logout`).
- `GET /admin/dashboard`: Ringkasan metrik lab, total proyek, pesan belum terbaca, dan status server.
- CRUD `/admin/projects`: Operasi tambah, ubah, hapus portofolio proyek.
- CRUD `/admin/posts`: Operasi penulisan artikel blog, slug generator, dan pengaturan status publikasi.
- CRUD `/admin/certificates`: Operasi unggah bukti sertifikat dan validasi tanggal perolehan.
- Resource `/admin/messages`: Melihat dan menghapus pesan kontak yang masuk.
- Form `/admin/settings`: Mengubah nama pemilik, bio, avatar, tautan media sosial, dan kontak resmi.

---

## 4. Keunggulan Pola Desain (Design Patterns) yang Diterapkan

1. **Separation of Concerns (Pemisahan Tanggung Jawab)**:
   - Logika ekstraksi kernel Linux dipisahkan sepenuhnya ke dalam `ServerMonitorService`, sehingga controller tidak tercemar oleh sintaks eksekusi shell atau file I/O langsung.
2. **Strict Request Validation**:
   - Seluruh data yang masuk dari form publik divalidasi menggunakan aturan Laravel (seperti `required`, `email`, `max:255`, `string`) sebelum disimpan ke basis data.
3. **Session Hardening**:
   - Sesi administratif menggunakan regenerasi token session (`$request->session()->regenerate()`) saat login sukses guna menangkal eksploitasi Session Fixation.

Untuk melihat rincian alasan keberadaan setiap baris kode controller dan alur koneksinya, rujuk catatan [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]].
