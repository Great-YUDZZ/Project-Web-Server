---
title: "Peta Struktur Folder & Berkas Proyek (Filesystem Inventory)"
category: "Architecture / Filesystem Map"
tags:
  - directory-map
  - file-inventory
  - project-structure
  - architecture
updated_at: "2026-10-09"
---

# Peta Struktur Folder & Berkas Proyek (Filesystem Inventory)

Dokumen ini menyediakan inventarisasi lengkap seluruh struktur direktori dan berkas dalam repositori web portofolio TKJ `/var/www/project_tkj_yuda2`. Dokumen ini menjadi pedoman cepat untuk mengetahui letak berkas, perannya dalam sistem, dan konektivitas arsitekturnya tanpa perlu memindai filesystem berulang kali.

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[02_Backend_Laravel_Framework]]: Detail implementasi backend Laravel.
- [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]]: Alasan di balik keberadaan kode.
- [[14_Resep_Modifikasi_Backend]]: Panduan baris kode untuk controllers, models, routes, dan services.
- [[15_Resep_Modifikasi_Frontend_dan_Views]]: Panduan baris kode untuk blade views, CSS, dan skrip JavaScript.
- [[16_Resep_Modifikasi_Database_dan_DevOps]]: Panduan baris kode untuk migrasi, seeder, dan konfigurasi server.

---

## 1. Ikhtisar Pohon Direktori Utama

```text
/var/www/project_tkj_yuda2/
├── app/                        # Inti logika aplikasi (MVC & Services)
│   ├── Http/
│   │   └── Controllers/        # Pengendali alur request (Public, Auth, Chatbot, Admin)
│   ├── Models/                 # Entitas data Eloquent ORM (Project, Post, Certificate, dll)
│   └── Services/               # Logika komputasi khusus (ServerMonitorService)
├── bootstrap/                  # Inisialisasi awal aplikasi Laravel 12 (app.php)
├── config/                     # Berkas konfigurasi framework (database, auth, session, app)
├── database/                   # Skema dan data awal
│   ├── factories/              # Generator data pengujian
│   ├── migrations/             # Cetak biru skema tabel MariaDB
│   └── seeders/                # Pengisi data awal database
├── nginx/                      # Berkas konfigurasi virtualhost server Nginx
├── public/                     # Dokumen root yang terekspos ke internet publik
│   ├── build/                  # Aset hasil kompilasi Vite (CSS & JS produksi)
│   ├── certificates/           # File fisik dokumen PDF dan pratinjau sertifikat
│   ├── images/                 # Logo, ikon teknologi, topologi jaringan
│   └── index.php               # Titik masuk utama seluruh request HTTP
├── resources/                  # Sumber aset mentah sebelum dikompilasi
│   ├── css/                    # Token Tailwind CSS v4 dan variabel tema (app.css)
│   ├── js/                     # Skrip interaksi GSAP, Three.js, dan HUD navbar
│   └── views/                  # Template Blade HTML antarmuka pengguna
├── routes/                     # Definisi URL routing web dan konsol CLI
│   ├── console.php             # Perintah kustom Artisan
│   └── web.php                 # Peta perutean URL aplikasi publik dan admin
├── tests/                      # Rangkaian pengujian otomatis PHPUnit (Feature & Unit)
├── composer.json               # Dependensi paket PHP backend
├── package.json                # Dependensi pustaka npm frontend (Tailwind, GSAP, Three.js)
├── phpunit.xml                 # Konfigurasi lingkungan testing
└── vite.config.js              # Konfigurasi bundler Vite dan plugin Tailwind
```

---

## 2. Inventarisasi Rinci Berdasarkan Folder

### A. Direktori `app/`
Folder terpenting untuk logika bisnis server:
1. `app/Http/Controllers/PublicController.php`:
   - Mengendalikan seluruh halaman pengunjung publik (landing page `/`, arsip klasik `/archive/classic`, telemetri `/api/telemetry`, katalog proyek `/projects`, detail proyek `/projects/{slug}`, katalog blog `/blog`, detail artikel `/blog/{slug}`, dan submit kontak `/contact`).
2. `app/Http/Controllers/AuthController.php`:
   - Mengelola login admin (`GET /login` dan `POST /login`), pembatasan laju 5x percobaan, dan proses logout (`POST /logout`).
3. `app/Http/Controllers/ChatbotController.php`:
   - Mengendalikan antarmuka dan penanganan percakapan asisten AI Yuna (`/ai` dan `/chatbot/message`).
4. `app/Http/Controllers/Admin/DashboardController.php`:
   - Menyajikan metrik ringkasan data lab dan status server untuk administrator.
5. `app/Http/Controllers/Admin/ProjectController.php`:
   - Operasi CRUD portofolio proyek lab serta tombol toggle hero dan toggle featured.
6. `app/Http/Controllers/Admin/PostController.php`:
   - Operasi CRUD artikel blog dan pengalihan status publikasi artikel.
7. `app/Http/Controllers/Admin/CertificateController.php`:
   - Operasi CRUD sertifikasi kejuruan dan unggah berkas bukti.
8. `app/Http/Controllers/Admin/SkillController.php`:
   - Operasi CRUD keterampilan teknis jaringan dan sysadmin.
9. `app/Http/Controllers/Admin/MessageController.php`:
   - Pengelolaan pesan masuk kontak publik dan penandaan status pesan dibaca.
10. `app/Models/`:
    - `User.php`: Otentikasi administrator.
    - `Project.php`: Representasi entitas proyek laboratorium.
    - `Post.php`: Representasi entitas postingan blog dan kalkulasi slug otomatis.
    - `Certificate.php`: Entitas lisensi dan sertifikat kejuruan.
    - `Skill.php`: Entitas keahlian dan persentase penguasaan.
    - `Message.php`: Entitas log pesan pengunjung.
11. `app/Services/ServerMonitorService.php`:
    - Service mandiri yang mem-parsing `/proc/cpuinfo`, `/proc/stat`, `/proc/meminfo`, dan `/proc/uptime`.

### B. Direktori `routes/`
1. `routes/web.php`:
   - Menghubungkan seluruh permintaan HTTP dengan controller yang sesuai.
2. `routes/console.php`:
   - Menampung perintah terminal Artisan kustom.

### C. Direktori `database/`
1. `database/migrations/`:
   - Menampung 9 berkas migrasi pembuatan tabel: `users`, `cache`, `jobs`, `skills`, `projects`, `messages`, `certificates`, kolom hero pada projects, dan `posts`.
2. `database/seeders/`:
   - `DatabaseSeeder.php`: Orkestrator pemanggilan seluruh seeder.
   - `AdminUserSeeder.php`, `SkillSeeder.php`, `ProjectSeeder.php`, `CertificateSeeder.php`, `PostSeeder.php`.

### D. Direktori `resources/views/`
1. `resources/views/home.blade.php`:
   - Template utama halaman beranda monokrom portofolio.
2. `resources/views/layouts/app.blade.php`:
   - Master layout publik (memuat font, CSS, JS, dan metadata SEO).
3. `resources/views/layouts/admin.blade.php`:
   - Master layout panel administratif.
4. `resources/views/blog/index.blade.php` & `blog/show.blade.php`:
   - Antarmuka katalog artikel dan pembaca artikel blog.
5. `resources/views/projects/index.blade.php` & `projects/show.blade.php`:
   - Antarmuka katalog proyek dan halaman detail proyek.
6. `resources/views/components/`:
   - `tech-flow-columns.blade.php`: Pameran tumpukan teknologi vertikal tak terbatas.
   - `chatbot-widget.blade.php`: Widget floating percakapan asisten AI Yuna.
   - `pc-hardware-silhouettes.blade.php`: Siluet visual perangkat keras lab.
7. `resources/views/admin/`:
   - Subfolder form pembuatan (`create.blade.php`), pengeditan (`edit.blade.php`), dan daftar data (`index.blade.php`) untuk proyek, artikel blog, sertifikat, keterampilan, serta pesan masuk.

### E. Direktori `resources/css/` & `resources/js/`
1. `resources/css/app.css`:
   - Berisi import font Google (Outfit, Inter, JetBrains Mono), plugin Tailwind CSS v4, variabel tema monokrom, dan kurva transisi.
2. `resources/js/app.js`:
   - Berkas bootstrap JavaScript utama yang menginisialisasi modul-modul interaktif.
3. `resources/js/dark-portfolio.js`:
   - Logika GSAP hero entrance, floating HUD navbar scroll-spy, pemutar HLS, dan modal telemetri teknologi.
4. `resources/js/interactive-bg.js`:
   - Engine kanvas WebGL Three.js untuk latar belakang bintang 3D interaktif.

---

## 3. Alur Hubungan & Panduan Lanjutan

Untuk mengetahui secara persis **berkas apa yang harus dibuka**, **pada baris ke berapa modifikasi dilakukan**, dan **apa yang perlu ditambah atau dihapus**, silakan buka dokumen panduan aksi berikut:
- [[14_Resep_Modifikasi_Backend]]: Panduan baris kode untuk Controller, Model, Service, dan Rute.
- [[15_Resep_Modifikasi_Frontend_dan_Views]]: Panduan baris kode untuk Template Blade, Styling Tailwind CSS, dan JavaScript.
- [[16_Resep_Modifikasi_Database_dan_DevOps]]: Panduan baris kode untuk Migrasi Database, Seeder, dan Konfigurasi Nginx/Vite.
