# Portfolio Web Server & Lab Infrastruktur TKJ
**I Made Yuda Pramana | SMKN 1 Denpasar**

Repository ini memuat seluruh kode sumber untuk web portfolio sekaligus showcase lab Teknik Komputer dan Jaringan (TKJ) yang kubangun sendiri, tujuannya buat nunjukin kompetensi yang ku kuasai mulai dari administrasi server Linux, konfigurasi jaringan, sampai perancangan aplikasi web modern. Project ini di-deploy langsung di atas mesin fisik baremetal menggunakan Debian 13 (Trixie), bukan sekadar shared hosting biasa, sehingga seluruh pembacaan telemetri server berjalan secara riil dari kernel sistem operasi.

---

## Akses Website & Live Production

Pengunjung dan reviewer dapat mengakses web ini secara langsung melalui beberapa endpoint berikut:

- **Web Utama (Live Production)**: [https://great-yuda.my.id](https://great-yuda.my.id)
- **Akses Jaringan Lokal (Home Lab)**: [http://yuda.local](http://yuda.local) (dapat diakses saat terhubung ke jaringan Wi-Fi lab yang sama)
- **Konsol Asisten AI Yuna**: [https://great-yuda.my.id/ai](https://great-yuda.my.id/ai)
- **Katalog Blog & Jurnal Teknis**: [https://great-yuda.my.id/blog](https://great-yuda.my.id/blog)
- **Arsip Portofolio Klasik (2024-2025)**: [https://great-yuda.my.id/archive/classic](https://great-yuda.my.id/archive/classic)
- **Repositori GitHub**: [https://github.com/Great-YUDZZ/Project-Web-Server](https://github.com/Great-YUDZZ/Project-Web-Server)

Seluruh metrik dan telemetri perangkat keras yang tampil di halaman utama diambil secara berkala langsung dari pembacaan kernel Linux `/proc`, jadi data beban CPU, penggunaan memori RAM, dan status penyimpanan yang kalian lihat adalah data aktual server fisik.

---

## Gambaran Umum Project

Aplikasi ini kurancang sebagai bukti implementasi nyata di bidang infrastruktur jaringan komputer, pengelolaan server mandiri, dan software engineering modern. Selain menampilkan profil serta dokumentasi keahlian, website ini mengintegrasikan beberapa sub-sistem utama yang kubuat:

- **IT-Toolbox v1.5.0**: utilitas diagnostik jaringan dan inspeksi sistem berbasis web serta antarmuka command line.
- **VisualStyle Studio**: editor token desain visual dan utilitas antarmuka berkinerja tinggi.
- **SakuKu Financial Engine**: sistem pencatatan analitik keuangan lokal dengan integritas transaksi database ACID.
- **Yuna AI Assistant**: asisten interaktif berbasis multi-key Google Gemini Flash dengan failover lokal untuk konsultasi materi jaringan, Linux, MikroTik, dan arsitektur server.

---

## Tech Stack & Infrastruktur

Untuk menjaga efisiensi sumber daya dan performa tinggi di lingkungan server baremetal, stack teknologi yang kupilih disusun seringan mungkin tanpa dependensi berlebih:

| Layer | Teknologi | Peran & Implementasi |
|---|---|---|
| **Sistem Operasi** | Debian 13 (Trixie) | Host baremetal fisik dengan optimasi TCP BBR kernel |
| **Web Server** | Nginx 1.22+ | Reverse proxy, terminasi SSL/TLS, static cache, dan FastCGI pass |
| **Backend Runtime** | PHP 8.4-FPM | Eksekusi engine via Unix socket `unix:/run/php/php8.4-fpm.sock` |
| **Framework Backend** | Laravel 12 | Arsitektur MVC, route handling, validasi ketat, dan Eloquent ORM |
| **Basis Data** | MariaDB 11.8 / MySQL 8.0 | Manajemen basis data relasional dengan storage engine InnoDB |
| **Styling & CSS** | Tailwind CSS v4 | Konfigurasi sistem token monokrom via directive `@theme` di app.css |
| **Bundler Frontend** | Vite 5 | Kompilasi kilat aset JavaScript dan CSS dengan Hot Module Replacement |
| **Engine Animasi** | GSAP 3 + ScrollTrigger | Transisi teks hero, floating scroll-spy HUD, dan marquee teknologi 60 FPS |
| **Kanvas Grafis 3D** | Three.js WebGL | Latar belakang partikel bintang 3D interaktif yang merespons kursor mouse |

---

## Sistem Desain & Tipografi Monokrom

Dari segi visual, antarmuka sengaja tidak menggunakan gradien warna-warni yang mencolok, konsepnya ku arahkan ke gaya **Dark Engineering Terminal** yang berfokus pada palet hitam murni (`#000000`), abu-abu presisi, dan putih kontras tinggi untuk menjaga ergonomi pembacaan teknis:

- **Outfit**: font geometric sans-serif untuk hierarki judul utama, branding, dan angka metrik agar tampak kokoh serta presisi.
- **Inter**: font netral untuk teks isi dan artikel jurnal agar nyaman dibaca dalam durasi panjang di layar mobile maupun desktop.
- **JetBrains Mono**: font monospace berjarak tetap untuk perintah terminal Bash, alamat IP, penomoran port, dan cuplikan log telemetri.

---

## Fitur Utama

1. **Dark Engineering Portfolio**:
   - Hero section interaktif dengan animasi bertingkat tanpa loading screen buatan yang menghambat akses awal pengguna.
   - Floating HUD Navbar yang sinkron secara presisi dengan posisi viewport pengunjung (scroll-spy aktif) menggunakan `requestAnimationFrame`.
   - Widget telemetri real-time yang memantau beban CPU, alokasi RAM, kapasitas penyimpanan SSD, durasi uptime, dan ketersediaan database.
   - Tech flow columns yang memutar kartu komponen teknologi secara vertikal lengkap dengan modal detail arsitektur.
   - Formulir kontak terproteksi dengan sanitasi input anti-XSS, rate limiting ketat, dan validasi token CSRF.

2. **Modul Publikasi & Jurnal Teknis**:
   - Ruang dokumentasi artikel panduan jaringan, administrasi sistem, dan konfigurasi server.
   - Dilengkapi modul pencarian kata kunci, filter kategori teknologi, estimasi waktu baca otomatis, dan rekomendasi artikel terkait.

3. **Dashboard Manajemen Terproteksi**:
   - Autentikasi administrator dengan proteksi anti brute-force maksimal 5 percobaan per IP dan email.
   - Manajemen CRUD penuh untuk proyek portofolio, arsip sertifikasi kompetensi (Cisco/MikroTik), artikel jurnal, dan pesan kontak masuk.

---

## Struktur Direktori Project

Berikut adalah struktur direktori utama pada project ini untuk memudahkan pemetaan kode sumber:

```text
project_tkj_yuda2/
├── app/
│   ├── Http/Controllers/       # Controller publik, autentikasi, AI Yuna, dan admin CRUD
│   ├── Models/                 # Model Eloquent (Project, Post, Certificate, Skill, Message, User)
│   └── Services/               # ServerMonitorService untuk parsing data telemetri Linux
├── bootstrap/app.php           # Inisialisasi framework, konfigurasi routing, dan middleware
├── config/                     # Berkas konfigurasi sistem (database, auth, session, app)
├── database/
│   ├── migrations/             # 9 berkas skema migrasi tabel basis data
│   └── seeders/                # Seeder data bawaan proyek, keahlian, dan sertifikasi
├── docs/knowledge-base/        # Dokumentasi playbook arsitektur teknis dan panduan file
├── nginx/                      # Template konfigurasi reverse proxy Nginx server
├── public/                     # Dokumen root web publik, aset statis, dan upload berkas
├── resources/
│   ├── css/app.css             # Konfigurasi tema monokrom Tailwind CSS v4
│   ├── js/                     # dark-portfolio.js, interactive-bg.js, dan app.js
│   └── views/                  # Template tampilan Blade (home, layouts, blog, projects, admin)
└── routes/web.php              # Definisi rute URL publik, API telemetri, dan rute admin
```

---

## Panduan Instalasi & Menjalankan di Lingkungan Lokal

Untuk menjalankan project ini pada lingkungan pengembangan lokal, ikuti langkah-langkah terstruktur berikut:

1. Kloning repositori dari GitHub:
   ```bash
   git clone https://github.com/Great-YUDZZ/Project-Web-Server.git
   cd Project-Web-Server
   ```

2. Pasang dependensi PHP menggunakan Composer:
   ```bash
   composer install
   ```

3. Pasang paket dependensi JavaScript menggunakan NPM:
   ```bash
   npm install
   ```

4. Buat berkas environment lokal dari template `.env.example`:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Sesuaikan kredensial basis data pada berkas `.env`, kemudian jalankan migrasi tabel beserta data awal:
   ```bash
   php artisan migrate --seed
   ```

6. Buat tautan simbolik direktori penyimpanan publik:
   ```bash
   php artisan storage:link
   ```

7. Bangun aset frontend menggunakan Vite:
   ```bash
   npm run build
   ```

8. Jalankan server lokal Laravel:
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui browser pada alamat `http://127.0.0.1:8000`.

---

## Pengujian Otomatis (Automated Testing)

Untuk menjamin keandalan sistem dan memastikan tidak ada regresi fungsionalitas saat pembaruan kode, project ini telah dilengkapi dengan 29 automated test (Feature dan Unit test):

```bash
php artisan test
```

Pengujian mencakup seluruh rute publik, validasi alur autentikasi admin, proteksi token CSRF, pembatasan rate limiting kontak, hingga integritas query database dengan hasil 100% lulus (29 passed, 185 assertions).

---

## Knowledge Base & Dokumentasi Obsidian

Seluruh dokumentasi teknis mendalam mengenai arsitektur kode, pemetaan relasi antar berkas, panduan modifikasi baris spesifik, dan alasan teknis implementasi fitur telah terdokumentasi secara terstruktur di folder `docs/knowledge-base/` (serta tersimpan pada vault Obsidian lokal di `/home/yudz/Documents/project_tkj_yuda2/`).

Kalian dapat membuka direktori tersebut menggunakan Obsidian untuk melihat keterhubungan modular antar komponen sistem melalui fitur Graph View.

---

## Catatan Penutup

Project web ini kubangun bukan sekadar portofolio visual semata, melainkan sarana implementasi praktis bagaimana mengelola server fisik Linux secara mandiri, mengonfigurasi jalur jaringan, serta merancang kode web yang efisien dan aman. Semakin dalam ku eksplorasi optimasi server baremetal ini ya semakin paham juga tantangan stabilitas dan mitigasi keamanannya, tapi ya semakin luas cakupan fiturnya tentu menuntut ketelitian perawatan berkala yang sepadan, intinya semoga repositori ini bisa memberi gambaran nyata bagi siapa pun yang mendalami administrasi sistem, jaringan komputer, maupun web development modern.
