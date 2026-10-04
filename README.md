# Portfolio Web Server & Lab Infrastruktur TKJ
**I Made Yuda Pramana | SMKN 1 Denpasar**

Repository ini memuat kode sumber lengkap untuk aplikasi web portofolio profesional dan dokumentasi lab teknik komputer dan jaringan (TKJ). Sistem ini dibangun dengan arsitektur LEMP stack (Linux, Nginx, MariaDB, PHP 8.4) dan Laravel 12, mengedepankan performa tinggi, desain editorial modern, telemetri server langsung, serta panel manajemen data berbasis otentikasi aman.

---

## Daftar Isi
1. [Ikhtisar Proyek](#ikhtisar-proyek)
2. [Fitur Utama](#fitur-utama)
3. [Arsitektur Teknologi](#arsitektur-teknologi)
4. [Tipografi dan Desain Visual](#tipografi-dan-desain-visual)
5. [Struktur Direktori](#struktur-direktori)
6. [Instalasi dan Konfigurasi Lokal](#instalasi-dan-konfigurasi-lokal)
7. [Pengujian Otomatis](#pengujian-otomatis)
8. [Keamanan Sistem](#keamanan-sistem)

---

## Ikhtisar Proyek

Aplikasi ini berfungsi sebagai representasi keahlian teknis di bidang infrastruktur jaringan, administrasi server Linux, keamanan siber, dan rekayasa perangkat lunak modern. Portofolio menampilkan karya nyata seperti:
- **IT-Toolbox v1.5.0**: Rangkaian utilitas jaringan dan diagnostik sistem berbasis terminal dan web.
- **VisualStyle Studio**: Editor token desain visual dan utilitas antarmuka berkinerja tinggi.
- **SakuKu Financial Engine**: Sistem pencatatan analitik keuangan lokal berbasis transaksi ACID.

Selain itu, terdapat integrasi asisten virtual interaktif **Yuna AI** yang dilengkapi arsitektur multi provider (Google Gemini Flash dengan failover cadangan ke OpenRouter / Ollama) untuk membantu pengunjung mengeksplorasi dokumentasi teknis secara interaktif.

---

## Fitur Utama

### 1. Halaman Publik (Dark Portfolio)
- **Hero Interaktif**: Latar belakang video Mux HLS berkecepatan tinggi, efek glassmorphism, dan tipografi dinamis.
- **Bento Grid Karya Unggulan**: Kartu proyek terstruktur dengan visual topologi jaringan, terminal prompt langsung, dan rincian teknologi.
- **Konveyor Alur Teknologi**: Showcase teknologi pembuatan web berbasis GSAP ScrollTrigger berurutan dengan kartu interaktif dan dialog rincian teknis.
- **Orrery Planet 3D**: Galeri interaktif 3D berbahan dasar Three.js untuk visualisasi ekosistem komputasi.
- **Formulir Kontak Terenkripsi**: Pengiriman pesan langsung ke basis data dengan sanitasi input, validasi ketat, pembatasan laju request (rate limiting), dan status umpan balik instan.
- **Widget Chatbot AI Yuna**: Asisten pintar yang dapat menjawab pertanyaan seputar keahlian, riwayat proyek, dan konfigurasi server.

### 2. Dashboard Administrasi (Admin Panel)
- **Otentikasi Aman**: Dilengkapi proteksi brute force, sesi terenkripsi, dan middleware otorisasi.
- **Telemetri Server Langsung (Live Telemetry)**: Pemantauan metrik perangkat keras waktu nyata meliputi beban CPU, kapasitas RAM, penggunaan penyimpanan NVMe, status Nginx, basis data MariaDB, soket PHP-FPM, dan uptime server.
- **Manajemen Konten (CRUD)**:
  - Manajemen Proyek Lab (tambah, edit, hapus, unggah foto topologi, toggle unggulan).
  - Manajemen Matriks Keahlian (pengelompokan kategori sysadmin, networking, security, tools).
  - Manajemen Sertifikat dan Kredensial Resmi.
  - Pengelola Kotak Masuk Pesan dengan penanda status baca.
- **Navigasi Responsif**: Dilengkapi laci samping (slide-in drawer) pada perangkat ponsel cerdas tanpa pergeseran tata letak horizontal.

### 3. Arsip Desain Klasik
- Struktur arsip terisolasi (`resources/views/archive/classic/`) yang menyimpan tata letak antarmuka versi terdahulu sebagai catatan evolusi desain portofolio.

---

## Arsitektur Teknologi

| Lapisan | Komponen / Versi | Peran Teknis |
|---|---|---|
| **Sistem Operasi** | Debian 13 | Host bare metal atau mesin virtual |
| **Web Server** | Nginx 1.26 | Reverse proxy, penanganan SSL/TLS, static file delivery |
| **Bahasa Pemrograman** | PHP 8.4 | Pemrosesan logika server-side berkecepatan tinggi |
| **Framework Backend** | Laravel 12 | Arsitektur MVC, ORM Eloquent, middleware keamanan |
| **Basis Data** | MariaDB 11.8 / MySQL 8.4 | Penyimpanan relasional persisten berstandar ACID |
| **Bundler Aset** | Vite 8 | Kompilasi aset frontend secara instan |
| **Framework CSS** | Tailwind CSS v4 | Utilitas desain sistem modular berbasis token |
| **Mesin Animasi** | GSAP 3.15 + ScrollTrigger | Manajemen animasi 60 FPS dan transisi scroll |
| **Grafis 3D** | Three.js | Pemodelan objek interaktif berbasis WebGL |
| **Mesin Carousel** | Swiper 14 | Slider responsif ramah sentuhan |

---

## Tipografi dan Desain Visual

Desain aplikasi mengadopsi standar tipografi editorial teknis:
- **Inter** (`font-body` dan `--font-sans`): Digunakan untuk teks umum, elemen antarmuka, label navigasi, tabel data, dan formulir input demi kenyamanan membaca tingkat tinggi.
- **Instrument Serif** (`font-display`): Digunakan pada judul utama, subhead editorial, serta angka metrik statistik besar untuk memberikan karakter visual berkelas.
- **JetBrains Mono** (`font-mono`): Dikhususkan untuk data mesin, telemetri perangkat keras, parameter port jaringan, alamat IP, dan potongan kode perintah.

Palet warna mengusung tema obsidian dark mode dengan aksen monokrom kontras tinggi dan pencahayaan lembut tanpa gradien sembarangan.

---

## Struktur Direktori

```
project_tkj_yuda2/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/             # Controller CRUD panel admin
│   │   │   ├── AuthController.php # Autentikasi sesi admin
│   │   │   ├── ChatbotController.php # Integrasi asisten AI
│   │   │   └── PublicController.php  # Rute publik dan form kontak
│   │   └── Middleware/            # Pengerasan keamanan HTTP
│   ├── Models/                    # Model Eloquent (User, Project, Skill, Message, Certificate)
│   └── Services/                  # Telemetri server (ServerMonitorService)
├── bootstrap/                     # Konfigurasi booting dan registrasi aplikasi
├── config/                        # Pengaturan aplikasi, database, dan layanan AI
├── database/
│   ├── migrations/                # Skema migrasi tabel basis data
│   └── seeders/                   # Pengisi data awal proyek dan sertifikat
├── nginx/                         # Berkas konfigurasi web server Nginx
├── public/
│   ├── images/                    # Asset gambar proyek, logo teknologi, dan ilustrasi
│   └── index.php                  # Titik masuk utama HTTP
├── resources/
│   ├── css/                       # Definisi tema dan token Tailwind v4
│   ├── js/                        # Modul animasi GSAP, 3D, rotator lab, dan chatbot
│   └── views/
│       ├── admin/                 # Tampilan blade panel administrasi
│       ├── archive/               # Tampilan blade arsip desain klasik
│       ├── auth/                  # Formulir login sesi admin
│       ├── layouts/               # Template kerangka utama dan admin
│       ├── partials/              # Potongan komponen antarmuka modular
│       └── home.blade.php         # Halaman utama portofolio
├── routes/
│   ├── console.php                # Perintah artisan kustom
│   └── web.php                    # Definisi seluruh rute HTTP aplikasi
└── tests/
    └── Feature/                   # Pengujian otomatis fitur portofolio dan admin
```

---

## Instalasi dan Konfigurasi Lokal

### Kebutuhan Sistem
- PHP 8.3 atau 8.4 (ekstensi: `pdo`, `pdo_mysql`, `mbstring`, `xml`, `curl`, `bcmath`)
- Composer 2.7+
- Node.js 20+ dan npm
- MariaDB 10.11+ atau MySQL 8.0+
- Web server Nginx atau Apache

### Langkah Instalasi
1. Gandakan repositori ini ke komputer lokal:
   ```bash
   git clone https://github.com/Great-YUDZZ/Project-Web-Server.git
   cd Project-Web-Server
   ```

2. Pasang dependensi pustaka PHP:
   ```bash
   composer install
   ```

3. Pasang paket pustaka JavaScript:
   ```bash
   npm install
   ```

4. Buat salinan berkas konfigurasi lingkungan:
   ```bash
   cp .env.example .env
   ```

5. Hasilkan kunci enkripsi aplikasi:
   ```bash
   php artisan key:generate
   ```

6. Sesuaikan konfigurasi basis data pada berkas `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=project_tkj_yuda2
   DB_USERNAME=root
   DB_PASSWORD=rahasia
   ```

7. Jalankan migrasi tabel beserta pengisi data contoh:
   ```bash
   php artisan migrate --seed
   ```

8. Buat tautan simbolik direktori penyimpanan publik:
   ```bash
   php artisan storage:link
   ```

9. Kompilasi berkas aset frontend untuk produksi:
   ```bash
   npm run build
   ```

10. Jalankan server lokal:
    ```bash
    php artisan serve
    ```
    Aplikasi dapat diakses melalui peramban di `http://127.0.0.1:8000`.

---

## Pengujian Otomatis

Aplikasi ini dilengkapi pengujian fitur menyeluruh menggunakan PHPUnit untuk memastikan reliabilitas logika bisnis dan proteksi akses:

```bash
php artisan test
```

Cakupan pengujian mencakup:
- Akses halaman publik, landing page dark mode, dan arsip desain klasik.
- Proteksi otorisasi rute admin bagi pengguna tanpa autentikasi.
- Alur login dan logout administrator.
- Validasi CRUD proyek, kompetensi teknis, dan sertifikasi.
- API telemetri metrik server Linux.
- Validasi pengiriman pesan kontak dan proteksi rate limiting.

---

## Keamanan Sistem

- **Cross-Site Scripting (XSS)**: Sanitasi otomatis seluruh masukan form kontak sebelum penyimpanan data.
- **Cross-Site Request Forgery (CSRF)**: Perlindungan token aktif pada semua metode request mutasi state (POST, PUT, PATCH, DELETE).
- **Proteksi Brute Force**: Throttling otomatis pada endpoint login admin dan pengiriman formulir publik.
- **Kebijakan Header Keamanan**: Dilengkapi konfigurasi header perlindungan konten (Content Security Policy, X-Frame-Options, X-Content-Type-Options) pada level middleware dan web server Nginx.
- **Pemisahan Kredensial**: Tidak ada rahasia produksi atau berkas lingkungan sensitif yang disertakan dalam riwayat commit Git.

---

Hak Cipta (c) 2026 I Made Yuda Pramana. Semua hak dilindungi.
