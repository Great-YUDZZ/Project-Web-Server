# PANDUAN TEKNIS & MATERI PRESENTASI SISTEM
# Portofolio Digital & Laboratorium Jaringan Komputer TKJ
**Pengembang:** I Made Yuda Pramana  
**Keahlian:** Teknik Komputer dan Jaringan (TKJ), SMK Negeri 1 Denpasar  
**Domain Akses:** `http://yuda.local` / `http://10.10.22.34`  
**Target Arsitektur:** LEMP Production Stack (Linux, Nginx, MariaDB/MySQL, PHP 8.4-FPM)

---

## DAFTAR ISI

1. [Ringkasan Eksekutif & Identitas Proyek](#1-ringkasan-eksekutif--identitas-proyek)
2. [Arsitektur Infrastruktur Server (LEMP Stack)](#2-arsitektur-infrastruktur-server-lemp-stack)
3. [Arsitektur Jaringan & Cara Setting DNS Lokal](#3-arsitektur-jaringan--cara-setting-dns-lokal)
4. [Arsitektur Backend (Laravel 13 & PHP 8.4)](#4-arsitektur-backend-laravel-13--php-84)
5. [Arsitektur Frontend (Vite, Tailwind CSS v4, Swiper 3D)](#5-arsitektur-frontend-vite-tailwind-css-v4-swiper-3d)
6. [Keamanan Sistem & Manajemen Hak Akses](#6-keamanan-sistem--manajemen-hak-akses)
7. [Pengujian Kualitas Perangkat Lunak (QA & Testing)](#7-pengujian-kualitas-perangkat-lunak-qa--testing)
8. [Struktur Berkas & Direktori Proyek](#8-struktur-berkas--direktori-proyek)
9. [Alur Presentasi Sidang & Simulasi Tanya Jawab Penguji](#9-alur-presentasi-sidang--simulasi-tanya-jawab-penguji)

---

## 1. RINGKASAN EKSEKUTIF & IDENTITAS PROYEK

### 1.1 Latar Belakang
Sebagai siswa kejuruan Teknik Komputer dan Jaringan (TKJ), representasi kompetensi tidak cukup hanya berupa resume teks konvensional. Dibutuhkan sebuah platform nyata yang dapat menguji sekaligus mendemonstrasikan penguasaan sistem operasi server, konfigurasi web server produksi, perutean jaringan lokal, serta rekayasa perangkat lunak modern.

Website portofolio ini dibangun secara mandiri di atas server Linux fisik tanpa menggunakan hosting instan cPanel atau platform builder visual. Seluruh konfigurasi server web, runtime engine, basis data, dan DNS lokal dirancang langsung dari terminal Linux.

### 1.2 Tujuan Proyek
1. **Showcase Kompetensi Riil TKJ:** Menampilkan dokumentasi topologi lab jaringan (Cisco OSPF, VLAN, Subnetting), perakitan perangkat keras, dan sertifikasi resmi.
2. **Implementasi Nyata Server LEMP:** Membuktikan kemampuan konfigurasi dan tuning performa server Linux, Nginx, MySQL, dan PHP-FPM.
3. **Aksesibilitas Multiplatform:** Menghubungkan berbagai perangkat client (laptop, PC, smartphone Android/iOS) dalam jaringan LAN yang sama melalui domain lokal `http://yuda.local` menggunakan teknologi Multicast DNS (mDNS / Zeroconf).
4. **Desain Modern Digital Kensei:** Menyajikan antarmuka visual kelas profesional dengan performa tinggi, animasi 3D interaktif yang ringan, dan tata letak responsif ramah smartphone.

---

## 2. ARSITEKTUR INFRASTRUKTUR SERVER (LEMP STACK)

Sistem ini beroperasi di atas stack LEMP (Linux, Nginx, MySQL, PHP), yang merupakan standar industri untuk aplikasi web berkebutuhan konkurensi tinggi dan efisiensi memori.

```
                    +---------------------------------------+
                    |       Client Devices in LAN           |
                    | (PC, Laptop, Smartphone Android/iOS)  |
                    +-------------------+-------------------+
                                        |
                            HTTP / Port 80 (yuda.local)
                                        |
                                        v
                    +---------------------------------------+
                    |             NGINX 1.26                |
                    |  - Reverse Proxy                      |
                    |  - Static Assets Cache (30 days)      |
                    |  - Security Headers & Dotfile Block   |
                    +-------------------+-------------------+
                                        |
                        FastCGI via UNIX Domain Socket
                         /run/php/php8.4-fpm.sock
                                        |
                                        v
                    +---------------------------------------+
                    |            PHP 8.4-FPM                |
                    |  - Laravel 13 MVC Engine              |
                    |  - OPcache Bytecode Optimization      |
                    |  - Session & Authentication Guard     |
                    +-------------------+-------------------+
                                        |
                            MySQL Native Protocol
                                (Port 3306)
                                        |
                                        v
                    +---------------------------------------+
                    |          MariaDB / MySQL 8            |
                    |  - Database: project_tkj_yuda2        |
                    |  - InnoDB Storage Engine              |
                    +-------------------+-------------------+
```

### 2.1 Komponen Stack Server

| Layer | Teknologi | Versi | Peran & Konfigurasi Utama |
|---|---|---|---|
| **Operating System** | Linux (Ubuntu Server) | 24.04 LTS / 6.8 kernel | Host environment, hak akses `www-data`, systemd service supervisor |
| **Web Server** | Nginx | 1.26+ | Reverse proxy, static asset server, FastCGI passing, Gzip compression |
| **Runtime Engine** | PHP-FPM | 8.4 | FastCGI Process Manager, eksekusi backend Laravel, OPcache aktif |
| **Database** | MySQL / MariaDB | 8.0+ / 10.11+ | Penyimpanan relasional tabel projects, skills, certificates, messages |
| **Asset Pipeline** | Vite + Node.js | 8.2.2 / v20+ | Bundler modul frontend ESM, minifikasi CSS/JS ke mode produksi |

### 2.2 Konfigurasi Virtual Host Nginx (`nginx/project_tkj_yuda2.conf`)
Konfigurasi Nginx dirancang dengan prinsip performa tinggi dan keamanan:
- **Server Name:** Mengikat `yuda.local`, `10.10.22.34`, dan `localhost`.
- **Root Directory:** Mengarah ke `/var/www/project_tkj_yuda2/public` sehingga file inti aplikasi (`.env`, `app/`, `config/`) tidak dapat diakses publik.
- **FastCGI Socket:** Berkomunikasi dengan PHP 8.4 melalui UNIX Domain Socket (`unix:/run/php/php8.4-fpm.sock`) yang menghasilkan latensi lebih rendah dibandingkan TCP loopback (`127.0.0.1:9000`).
- **Caching Aset:** Header `Cache-Control: public, max-age=2592000` (30 hari) untuk file CSS, JS, SVG, gambar, dan font.
- **Proteksi Berkas Tersembunyi:** Blok aturan `location ~ /\. { deny all; }` untuk mencegah kebocoran file `.git`, `.env`, atau konfigurasi tersembunyi lainnya.

---

## 3. ARSITEKTUR JARINGAN & CARA SETTING DNS LOKAL

Salah satu nilai keunggulan utama dalam proyek kejuruan TKJ ini adalah integrasi jaringan lokal yang memungkinkan penguji membuka website langsung dari smartphone masing-masing dengan mengetikkan `http://yuda.local`.

---

### 3.1 Konsep & Alur Kerja Resolusi DNS Lokal

Di lingkungan jaringan lokal (LAN) tanpa koneksi internet publik, terdapat dua metode utama yang diterapkan secara terpadu di server ini:

1. **Multicast DNS (mDNS / Zeroconf - RFC 6762):**
   - Berjalan pada port UDP 5353.
   - Tidak memerlukan server DNS terpusat.
   - Perangkat Apple (Bonjour), Linux (Avahi), dan Windows 10/11 secara otomatis mengirim paket multicast ke `224.0.0.251` untuk menanyakan siapa pemilik nama `yuda.local`. Daemon Avahi di server merespons dengan IP `10.10.22.34`.

2. **Unicast DNS Standar (BIND9 DNS Server - RFC 1035):**
   - Berjalan pada port UDP/TCP 53.
   - Digunakan sebagai DNS server resmi lokal untuk perangkat smartphone Android atau laptop yang membutuhkan DNS Server statik dalam jaringan lab.

---

### 3.2 Langkah Konfigurasi DNS di Sisi Server Linux (Server-Side)

Berikut adalah tahapan teknis perancangan DNS yang dilakukan langsung pada server:

#### Langkah 1: Pemetaan Host Lokal (`/etc/hosts`)
Pastikan hostname server dan domain `yuda.local` terikat ke localhost dan IP LAN server:

```bash
sudo nano /etc/hosts
```

Tambahkan entri berikut:
```text
127.0.0.1   localhost yuda.local
10.10.22.34 yuda.local
```

#### Langkah 2: Instalasi & Konfigurasi BIND9 DNS Server
Untuk melayani query DNS standar dari smartphone Android dan client lain:

1. **Instalasi paket BIND9:**
   ```bash
   sudo apt update
   sudo apt install -y bind9 bind9utils dnsutils
   ```

2. **Membuat Berkas Database Zona (`/etc/bind/db.yuda.local`):**
   ```bash
   sudo nano /etc/bind/db.yuda.local
   ```
   Isi dengan konfigurasi zone file berikut:
   ```text
   $TTL    604800
   @   IN  SOA yuda.local. root.yuda.local. (
                     1         ; Serial
                604800         ; Refresh
                 86400         ; Retry
               2419200         ; Expire
                604800 )       ; Negative Cache TTL

   @   IN  NS  yuda.local.
   @   IN  A   10.10.22.34
   *   IN  A   10.10.22.34
   ```

3. **Mendaftarkan Zona di `/etc/bind/named.conf.local`:**
   ```bash
   sudo nano /etc/bind/named.conf.local
   ```
   Tambahkan blok zona:
   ```text
   zone "yuda.local" {
       type master;
       file "/etc/bind/db.yuda.local";
   };
   ```

4. **Mengatur Forwarders di `/etc/bind/named.conf.options`:**
   Agar client yang menggunakan DNS server ini tetap bisa mengakses internet luar (jika internet tersedia):
   ```text
   options {
       directory "/var/cache/bind";
       forwarders {
           8.8.8.8;
           1.1.1.1;
       };
       allow-query { any; };
       dnssec-validation no;
   };
   ```

5. **Uji Validasi Sintaks & Restart Service BIND9:**
   ```bash
   sudo named-checkconf /etc/bind/named.conf
   sudo named-checkzone yuda.local /etc/bind/db.yuda.local
   sudo systemctl restart named
   sudo systemctl enable named
   ```

#### Langkah 3: Konfigurasi Avahi Daemon (mDNS / Zeroconf)
Avahi bertugas melayani query `.local` secara otomatis tanpa perlu client menyetel IP DNS:

1. **Instalasi paket Avahi:**
   ```bash
   sudo apt install -y avahi-daemon libnss-mdns
   ```

2. **Menyetel Hostname Server di `/etc/avahi/avahi-daemon.conf`:**
   ```text
   [server]
   host-name=yuda
   domain-name=local
   use-ipv4=yes
   use-ipv6=yes
   check-response-ttl=no
   use-iff-running=no
   ```

3. **Mendaftarkan Mapping di `/etc/avahi/hosts`:**
   ```text
   10.10.22.34 yuda.local
   ```

4. **Mendaftarkan Service HTTP di `/etc/avahi/services/http.service`:**
   ```xml
   <?xml version="1.0" standalone='no'?>
   <!DOCTYPE service-group SYSTEM "avahi-service.dtd">
   <service-group>
     <name replace-wildcards="yes">Web Server Portofolio Yuda</name>
     <service>
       <type>_http._tcp</type>
       <port>80</port>
     </service>
   </service-group>
   ```

5. **Restart Service Avahi:**
   ```bash
   sudo systemctl restart avahi-daemon
   sudo systemctl enable avahi-daemon
   ```

#### Langkah 4: Skrip Otomatisasi Terpadu (`setup-dns.sh`)
Seluruh proses konfigurasi di atas telah dirangkum dalam satu skrip bash otomatis yang dapat dijalankan kapan saja dengan perintah:
```bash
sudo bash setup-dns.sh
```
Skrip ini secara cerdas mendeteksi IP LAN lokal yang aktif, membackup file konfigurasi lama, memperbarui zona DNS BIND9, mengonfigurasi Avahi mDNS, memvalidasi Nginx, dan memverifikasi respon HTTP 200.

---

### 3.3 Panduan Praktis Setting di Sisi Client (Client-Side)

Berikut adalah panduan langkah demi langkah saat penguji atau tamu ingin membuka website dari perangkat mereka:

#### METODE 1: Akses dari Smartphone Android (Wajib Disimak)
Android memiliki fitur keamanan bawaan bernama "Private DNS" yang secara otomatis mengabaikan DNS lokal jika tidak dinonaktifkan.

1. **Langkah A: Matikan DNS Pribadi (Private DNS)**
   - Buka menu **Pengaturan (Settings)** di HP Android.
   - Pilih menu **Koneksi** atau **Jaringan & Internet**.
   - Cari opsi **DNS Pribadi (Private DNS)**.
   - Ubah setelan dari *Otomatis* menjadi **Nonaktif (Off)**.
   *(PENTING: Jika Private DNS tetap aktif, Android akan memaksakan query ke Cloudflare/Google DNS publik dan gagal menemukan domain .local).*

2. **Langkah B: Atur DNS WiFi Menjadi Statik**
   - Buka menu **Pengaturan WiFi** di HP.
   - Ketuk dan tahan (atau ketuk ikon gerigi) pada nama WiFi jaringan lab yang sedang terhubung.
   - Pilih **Ubah Jaringan (Modify Network)** atau **Pengaturan Lanjutan**.
   - Ubah **Setelan IP (IP Settings)** dari *DHCP* ke **Statik (Static)**.
   - Masukkan konfigurasi berikut:
     * **Alamat IP:** `10.10.22.210` (atau IP bebas di subnet lab yang tidak bentrok)
     * **Gateway / Router:** `10.10.18.1` (atau gateway router lab)
     * **Panjang Awalan Jaringan (Prefix):** `21` (Netmask `255.255.248.0`)
     * **DNS 1:** `10.10.22.34` *(IP Server Portfolio Yuda)*
     * **DNS 2:** `8.8.8.8` *(DNS Google sebagai cadangan)*
   - Simpan pengaturan WiFi.

3. **Langkah C: Buka Browser HP**
   - Buka Google Chrome di HP.
   - Ketik alamat lengkap:
     ```
     http://yuda.local
     ```
   *(Catatan: Jangan lupa menyertakan awalan `http://` agar Chrome tidak menganggapnya sebagai kata kunci pencarian Google).*

---

#### METODE 2: Akses dari iPhone / iPad (iOS) & Mac
Sistem operasi Apple memiliki modul Bonjour mDNS bawaan pabrik:
1. Hubungkan iPhone / Mac ke jaringan WiFi yang sama dengan server.
2. Buka peramban **Safari** atau **Chrome**.
3. Langsung ketik di address bar:
   ```
   http://yuda.local
   ```
4. Website langsung terbuka secara instan tanpa perlu mengubah pengaturan IP maupun DNS!

---

#### METODE 3: Akses dari Laptop / PC Windows 10 & 11
Windows 10 (versi 1803 ke atas) dan Windows 11 telah mendukung mDNS secara native:
1. Hubungkan laptop ke WiFi yang sama.
2. Buka browser (Chrome / Edge) dan ketik:
   ```
   http://yuda.local
   ```
3. **Opsi Alternatif (Host File Windows):**
   Jika mDNS di laptop Windows dimatikan oleh kebijakan admin, buka `Notepad` dengan opsi **Run as Administrator**, buka berkas:
   `C:\Windows\System32\drivers\etc\hosts`
   Tambahkan baris berikut di bagian paling bawah:
   ```text
   10.10.22.34    yuda.local
   ```
   Simpan berkas, dan `http://yuda.local` dapat langsung diakses.

---

#### METODE 4: Mode Hotspot Lab Mandiri (Solusi Terbaik & Tercepat untuk Sidang Penguji)
Jika guru penguji tidak ingin mengubah setelan DNS atau IP di smartphone mereka:
Server laptop siswa dapat difungsikan langsung sebagai router WiFi Hotspot mandiri menggunakan NetworkManager CLI:

1. **Jalankan perintah hotspot mandiri di server:**
   ```bash
   sudo nmcli dev wifi hotspot ifname wlp2s0 ssid "Lab-TKJ-Yuda" password "yuda12345"
   ```
2. **Koneksikan HP Penguji:**
   Guru penguji cukup menyambungkan smartphone ke WiFi **"Lab-TKJ-Yuda"** dengan kata sandi `yuda12345`.
3. **Akses Langsung:**
   Buka browser HP dan ketik `http://yuda.local`.
   Dalam mode hotspot ini, DHCP dan DNS server otomatis mengarahkan seluruh client ke laptop server tanpa konfigurasi manual apapun di HP penguji!

---

### 3.4 Troubleshooting Masalah DNS di Lapangan

| Gejala Masalah | Penyebab Utama | Solusi Penanganan |
|---|---|---|
| Browser membuka halaman pencarian Google saat mengetik `yuda.local` | Browser menganggap nama domain tanpa TLD umum (.com/.id) sebagai teks pencarian | Ketikkan protokol `http://` secara eksplisit di awal: `http://yuda.local` |
| Muncul pesan error `DNS_PROBE_FINISHED_NXDOMAIN` di Android | Fitur Private DNS (DNS over TLS) di Android masih aktif | Buka Pengaturan HP -> Matikan Private DNS (set ke Off/Nonaktif) |
| Muncul pesan error `ERR_CONNECTION_REFUSED` | Nginx belum berjalan atau port 80 terblokir firewall | Jalankan `sudo systemctl status nginx` dan `sudo ufw allow 80/tcp` |
| Hostname mDNS berubah menjadi `yuda-2.local` | Terjadi konflik nama di jaringan Avahi lokal sebelumnya | Jalankan `sudo systemctl restart avahi-daemon` untuk merefresh registrasi nama |
| Tidak bisa akses domain sama sekali di jaringan WiFi publik | Router sekolah mengaktifkan fitur AP Isolation (Client Isolation) | Gunakan **Metode 4 (Hotspot Mandiri)** agar laptop dan HP berada dalam interface yang sama |

---

## 4. ARSITEKTUR BACKEND (LARAVEL 13 & PHP 8.4)

Aplikasi dibangun dengan framework Laravel 13 berbasis PHP 8.4, menerapkan arsitektur MVC (Model-View-Controller) yang modular dan bersih.

### 4.1 Struktur Rute Aplikasi (`routes/web.php`)

```
Public Routes (Tanpa Otentikasi):
├── GET  /                   -> PublicController@home (Hero, Lab, Sertifikat 3D, Skill)
├── GET  /projects           -> PublicController@projects (Katalog Lab Topologi)
├── GET  /projects/{slug}    -> PublicController@projectDetail (Detail Lab & Diagram)
└── POST /contact            -> PublicController@submitContact (Form Pesan, Rate Limited)

Auth Routes:
├── GET  /login              -> AuthController@showLogin (Form Login Admin)
├── POST /login              -> AuthController@login (Proteksi Brute-Force 5x/menit)
└── POST /logout             -> AuthController@logout (Invalidasi Sesi)

Admin Panel Routes (Prefix: /admin, Middleware: auth):
├── GET  /dashboard          -> DashboardController@index (Statistik Ringkasan)
├── CRUD /projects           -> ProjectController (Tambah/Edit/Hapus Topologi Lab)
├── CRUD /skills             -> SkillController (Kelola Matriks Keahlian)
├── CRUD /certificates       -> CertificateController (Kelola Sertifikat Resmi)
└── CRUD /messages           -> MessageController (Inbox Pesan Masuk & Toggle Baca)
```

### 4.2 Skema Model & Basis Data

1. **Model `Certificate` (`certificates` table):**
   - Kolom: `title`, `issuer`, `credential_id`, `credential_url`, `file_path`, `preview_image`, `description`, `issued_date`, `duration_hours`, `verification_status`, `is_featured`, `order`.
   - Accessor Pintar `preview_image_url`: Otomatis menyajikan path lokal `certificates/...` atau fallback storage.
   - Accessor `file_url`: Mengembalikan tautan absolut dokumen fisik PDF asli untuk verifikasi penguji.

2. **Model `Project` (`projects` table):**
   - Kolom: `title`, `slug` (unique), `category`, `description`, `long_description`, `topology_image`, `tools_used`, `github_url`, `demo_url`, `is_featured`, `order`.
   - Auto-slug logic: Menghasilkan slug URL yang ramah SEO secara otomatis saat proyek dibuat.

3. **Model `Skill` (`skills` table):**
   - Kolom: `name`, `category` (enum: `networking`, `sysadmin`, `hardware`, `tools`), `level` (1-100), `icon`, `order`.

4. **Model `Message` (`messages` table):**
   - Kolom: `sender_name`, `email`, `subject`, `message`, `is_read`.
   - Scope: `scopeUnread()` untuk kalkulasi badge notifikasi pada panel admin.

5. **Model `User` (`users` table):**
   - Digunakan untuk akun administrator portfolio dengan enkripsi password menggunakan algoritma Bcrypt standar Laravel.

---

## 5. ARSITEKTUR FRONTEND (VITE, TAILWIND CSS V4, SWIPER 3D)

Sistem visual mengusung filosofi **Digital Kensei**: tema gelap modern bernuansa *void black* (`#050508`), kartu permukaan (`#0c0c12`), dan aksen *cyber crimson* (`#ff2a55`), dipadukan dengan tipografi teknis.

### 5.1 Komponen Inti: 3D Coverflow Image Gallery (Sertifikat)
Menampilkan 4 sertifikat kejuruan resmi dengan teknologi hardware-accelerated CSS 3D Transforms melalui Swiper.js v14:
1. **Rotasi Sumbu-Y (Perspective & 3D Tilt):**
   - Kartu tengah aktif berskala penuh (`scale: 1`), menghadap lurus ke depan dengan border neon crimson glow.
   - Kartu samping flanking berotasi pada sumbu-Y (`rotateY: 35deg`), berskala lebih kecil (`scale: 0.82`), dan memiliki bayangan gelap halus (`slideShadows: true`).
2. **Kedalaman Sumbu-Z (Curvature Depth):**
   - Parameter `depth: 220` menciptakan efek lengkungan kedalaman 3D natural layaknya kartu fisik dalam galeri fisik.
3. **Mode Putar Berkelanjutan (Infinite Loop):**
   - Konfigurasi `loop: true` memastikan ketika pengunjung mencapai kartu ke-4 dan menekan tombol berikutnya, kartu berputar kembali ke kartu pertama secara mulus tanpa batas henti.
4. **Kontrol Ergonomis Bawah:**
   - Tombol Previous dan Next diposisikan di bawah kartu, mengapit dot pagination, sehingga sangat ramah dijangkau oleh ibu jari pengguna smartphone.
5. **Akses Dokumen Fisik:**
   - Setiap kartu memiliki tombol **Lihat Resolusi Penuh** (membuka modal lightbox layar penuh) dan **PDF Asli** (membuka berkas fisik asli beresolusi cetak).

### 5.2 Komponen Inti: 3D "Orrery / Orbital Focus" Gallery (Teknologi Web)
Memvisualisasikan 10 teknologi utama pembangun website ini dalam bentuk simulasi orbit kosmik (Orrery 3D):
1. **Lintasan Orbit Elips 3D (Parametric Elliptical Path):**
   - 10 node teknologi diatur melingkari lintasan elips miring bersudut perspektif dengan garis putus-putus bercahaya (*dashed glowing orbit path*).
2. **Kalkulasi Kedalaman & Z-Depth Sorting:**
   - Node di bagian belakang ($z \approx -1$) berukuran lebih kecil (`scale: 0.65`), transparan (`opacity: 0.35`), dan sedikit kabur (`blur: 2.5px`).
   - Node yang berputar ke arah depan ($z \approx +1$) membesar tajam (`scale: 1.2`), sepenuhnya kontras (`opacity: 1.0`), dan bebas blur.
3. **Fokus Proyeksi Tengah (Active Center Focus):**
   - Node yang berada di posisi paling depan (bawah tengah) dilingkari cincin neon menyala, dan detail lengkapnya diproyeksikan di tengah orbit dengan transisi *cross-fade* yang halus.
4. **Interaksi Multi-Input (Physics Engine):**
   - **Drag / Swipe:** Mendukung seretan mouse atau swipe sentuh layar dengan efek inersia dan peredaman alami.
   - **Wheel Scroll Acceleration:** Memutar roda mouse/trackpad mengakselerasi kecepatan putaran orbit (*"Scroll to spin faster, drag to turn"*).
   - **Click to Focus:** Mengklik orb teknologi manapun akan memutar orbit secara otomatis hingga orb tersebut berada di posisi fokus depan.
5. **HUD Kosmik & Tipografi Elegan:**
   - Latar belakang gradien kosmik gelap (`#0a0d1a` hingga `#04060c`) berpadu dengan partikel bintang dinamis.
   - Tipografi *"Orrery"* berhuruf serif di sudut kiri bawah, petunjuk navigasi di tengah, serta indikator derajat dan nomor urut aktif (`XX / 10 • XXX°`) di kanan bawah.

### 5.3 Fitur Frontend Unggulan Lainnya
- **Interactive Particle Background:** Efek latar belakang interaktif berbasis Canvas HTML5 dengan interaksi kursor halus (`interactive-bg.js`).
- **Tab Switcher & Filter Dinamis:** Pemisahan tab Showcase Proyek dan Matriks Keahlian tanpa perlu memuat ulang halaman (zero reload).
- **Mobile Drawer Menu:** Menu navigasi smartphone dengan minimum target sentuh 44px sesuai standar ergonomi Google Web Vitals.
- **Scroll Reveal & Counters:** Animasi kemunculan elemen saat digulir serta penghitung angka beranimasi halus.

---

## 6. KEAMANAN SISTEM & MANAJEMEN HAK AKSES

1. **Proteksi Serangan Brute-Force:**
   - Endpoint login dibatasi menggunakan mekanisme rate-limiting bawaan Laravel (`throttle: 5 attempts per minute`).
2. **Proteksi CSRF (Cross-Site Request Forgery):**
   - Setiap formulir POST (termasuk form kontak dan login) dilindungi oleh token CSRF terenkripsi.
3. **Pemisahan Hak Akses Direktori Server Linux:**
   - Kepemilikan direktori web diserahkan kepada pengguna `www-data:www-data`.
   - Izin berkas: `chmod 755` untuk direktori dan `chmod 644` untuk berkas kode program.
   - Direktori `storage` dan `bootstrap/cache` diberikan izin tulis aman (`chmod -R 775`).
4. **Pencegahan Directory Traversal & Berkas Sensitif:**
   - Seluruh berkas rahasia (`.env`, database credentials, log) berada di luar webroot Nginx (`public/`).
   - Nginx menolak akses langsung terhadap file tersembunyi (`location ~ /\. { deny all; }`).

---

## 7. PENGUJIAN KUALITAS PERANGKAT LUNAK (QA & TESTING)

Proyek ini telah melalui pengujian otomatis menyeluruh untuk memastikan keandalan fungsi:

### 7.1 Hasil Uji Otomatis (PHPUnit Test Suite)
Perintah eksekusi: `composer test`
- **Total Pengujian:** 18 Test Cases
- **Total Asersi:** 108 Assertions
- **Tingkat Keberhasilan:** 100% Passed (0 Failure, 0 Warning)

Daftar aspek yang diuji secara otomatis:
- Aksesibilitas halaman beranda dan render komponen inti.
- Aksesibilitas katalog arsip lab dan halaman detail topologi proyek.
- Mekanisme pengiriman pesan kontak publik ke basis data.
- Proteksi otentikasi admin (guest diarahkan ke login saat mengakses `/admin/*`).
- Login dan logout admin dengan kredensial sah.
- Penolakan login admin dengan password salah.
- Operasi CRUD Proyek (Create, Read, Update, Delete) oleh admin.
- Operasi CRUD Keahlian (Skills) oleh admin.
- Operasi CRUD Sertifikat (Certificates) oleh admin.
- Pengujian tampilan data sertifikat basis data pada beranda publik.

### 7.2 Linter & Standardisasi Kode (Laravel Pint)
Perintah eksekusi: `./vendor/bin/pint`
- Menjamin kepatuhan standar format kode internasional PSR-12 tanpa kesalahan sintaks.

---

## 8. STRUKTUR BERKAS & DIREKTORI PROYEK

Berikut adalah ikhtisar direktori kunci pada repositori:

```
/var/www/project_tkj_yuda2/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/               # Controller panel admin (Project, Skill, Cert, Message)
│   │   ├── AuthController.php   # Controller otentikasi login & logout
│   │   └── PublicController.php # Controller tampilan publik & form pesan
│   └── Models/
│       ├── Certificate.php      # Model data sertifikasi fisik
│       ├── Message.php          # Model pesan buku tamu
│       ├── Project.php          # Model data lab jaringan & topologi
│       ├── Skill.php            # Model data keahlian teknik
│       └── User.php             # Model data akun administrator
├── database/
│   ├── migrations/              # Definisi skema tabel basis data
│   └── seeders/                 # Data awal akun admin, sertifikat, lab, dan skill
├── nginx/
│   └── project_tkj_yuda2.conf   # Berkas konfigurasi virtual host produksi
├── public/
│   ├── certificates/            # Berkas PDF asli & gambar pratinjau sertifikat
│   ├── images/                  # Aset visual topologi jaringan & foto lab
│   └── build/                   # Bundle terkompilasi Vite (CSS & JS produksi)
├── resources/
│   ├── css/
│   │   └── app.css              # Konfigurasi Tailwind CSS v4 & custom 3D Coverflow
│   ├── js/
│   │   ├── app.js               # Logika inisialisasi Swiper 3D, tabs, & counters
│   │   └── interactive-bg.js    # Canvas animasi partikel interaktif
│   └── views/                   # Template Blade (layout, home, projects, admin)
├── setup-dns.sh                 # Skrip otomatisasi Avahi mDNS & IP LAN
├── setup-lemp.sh                # Skrip instalasi lengkap stack LEMP
└── PRESENTASI_TEKNIS_WEB.md     # Panduan materi presentasi teknis (berkas ini)
```

---

## 9. ALUR PRESENTASI SIDANG & SIMULASI TANYA JAWAB PENGUJI

### 9.1 Skenario Presentasi 10 Menit di Hadapan Guru Penguji

1. **Menit 00 - 02: Pembukaan & Demonstrasi Akses Jaringan (Multi-Device)**
   - *"Selamat pagi bapak/ibu guru penguji. Nama saya I Made Yuda Pramana dari kompetensi keahlian Teknik Komputer dan Jaringan SMK Negeri 1 Denpasar."*
   - *"Hari ini saya mendemonstrasikan sistem portofolio dan arsip lab jaringan mandiri yang berjalan di atas server fisik Linux lokal. Silakan bapak/ibu membuka smartphone dan mengetik `http://yuda.local` di browser. Website ini langsung terbuka tanpa memerlukan kuota internet publik karena terhubung via protokol Multicast DNS (mDNS) pada jaringan lokal kita."*

2. **Menit 02 - 05: Arsitektur Server LEMP & Alasan Pemilihan Nginx**
   - Jelaskan bahwa server ini tidak memakai Apache konvensional, melainkan Nginx 1.26 dengan PHP 8.4-FPM socket UNIX.
   - Tunjukkan efisiensi penggunaan memori RAM yang rendah dan kemampuan melayani request statis dengan kecepatan tinggi.

3. **Menit 05 - 07: Showcase Lab Topologi & Galeri 3D Coverflow Sertifikat**
   - Tunjukkan bagian **Sertifikasi Kejuruan**: demonstrasikan perputaran kartu 3D Coverflow yang berputar tanpa henti (infinite loop), kemudahan navigasi bawah kartu, dan klik untuk membuka modal pratinjau asli serta tautan unduh PDF resmi dari Cisco dan Komdigi RI.
   - Tunjukkan bagian **Showcase Lab Jaringan**: buka salah satu proyek topologi (misalnya OSPF Multi-Area atau LEMP Server) untuk memperlihatkan dokumentasi diagram topologi dan konfigurasi CLI.

4. **Menit 07 - 09: Panel Admin & Keamanan**
   - Buka `/login`, demonstrasikan masuk ke `/admin/dashboard`.
   - Tunjukkan pengelolaan data sertifikat atau proyek baru secara dinamis, serta pesan masuk yang terkirim dari form publik.

5. **Menit 09 - 10: Hasil Pengujian Otomatis & Penutup**
   - Perlihatkan hasil eksekusi terminal `composer test` (18/18 passed) sebagai jaminan kualitas perangkat lunak.
   - Tutup presentasi dan buka sesi tanya jawab.

---

### 9.2 Prediksi Pertanyaan Teknis Penguji & Kunci Jawaban Siap Pakai

#### Pertanyaan 1: "Mengapa kamu memilih web server Nginx daripada Apache?"
> **Jawaban:**  
> *"Nginx menggunakan arsitektur event-driven asynchronous non-blocking, sedangkan Apache secara bawaan membuat thread/proses baru untuk setiap koneksi masuk (process-driven). Dalam skenario jaringan sekolah atau server dengan resource terbatas, Nginx jauh lebih hemat konsumsi memori RAM dan memiliki throughput jauh lebih tinggi dalam menyajikan berkas statis (gambar topologi, PDF sertifikat, CSS, dan JS). Selain itu, Nginx berfungsi sebagai reverse proxy yang sangat cepat saat meneruskan request dinamis ke PHP-FPM melalui UNIX domain socket."*

#### Pertanyaan 2: "Bagaimana cara kerja domain `yuda.local` sehingga smartphone saya bisa membukanya tanpa koneksi internet?"
> **Jawaban:**  
> *"Sistem ini memanfaatkan teknologi Multicast DNS (mDNS) standar RFC 6762 melalui daemon Avahi pada port UDP 5353 di server Linux. Saat browser smartphone mencari hostname berakhiran `.local`, sistem operasi perangkat mengirimkan query broadcast di jaringan LAN yang sama. Daemon Avahi di server kita mendengarkan query tersebut dan membalas bahwa `yuda.local` berada di IP `10.10.22.34`. Proses ini sepenuhnya lokal, cepat, terdesentralisasi, dan tidak membutuhkan internet publik maupun server DNS eksternal."*

#### Pertanyaan 3: "Mengapa menggunakan UNIX domain socket daripada TCP port 9000 untuk menghubungkan Nginx ke PHP-FPM?"
> **Jawaban:**  
> *"UNIX domain socket (`unix:/run/php/php8.4-fpm.sock`) beroperasi langsung di dalam kernel Linux tanpa melalui overhead network protocol stack (tidak ada enkapsulasi TCP/IP, checksum, dan routing port loopback). Karena Nginx dan PHP-FPM berjalan di mesin fisik yang sama, penggunaan socket berkas UNIX menghasilkan latensi yang lebih rendah dan performa transfer data yang lebih tinggi."*

#### Pertanyaan 4: "Bagaimana kamu mengamankan halaman login admin dari serangan hacker atau bot?"
> **Jawaban:**  
> *"Keamanan panel admin kami lindungi dengan beberapa lapis pertahanan:  
> 1. **Rate Limiting:** Kami membatasi percobaan login maksimal 5 kali per menit per alamat IP untuk mencegah brute-force attack.  
> 2. **Proteksi CSRF:** Setiap submission form divalidasi dengan token unik terenkripsi.  
> 3. **Hashing Bcrypt:** Password admin tidak disimpan dalam teks biasa, melainkan dienkripsi dengan algoritma hash Bcrypt yang memiliki salt dinamis.  
> 4. **Isolasi Berkas:** Berkas sensitif seperti `.env` dan kode inti PHP berada di luar root folder Nginx, serta Nginx memiliki aturan eksplisit untuk menolak semua akses ke file dengan awalan titik (dotfiles)."*

#### Pertanyaan 5: "Bagaimana galeri kartu sertifikat 3D dibuat dan apakah berat jika dibuka di HP yang speknya rendah?"
> **Jawaban:**  
> *"Galeri 3D Coverflow kami dibangun menggunakan pustaka Swiper.js v14 dengan efek Coverflow yang sepenuhnya mengandalkan CSS3 3D Hardware Acceleration (`transform: translateZ`, `rotateY`). Ini berarti proses kalkulasi rendering visual 3D diserahkan langsung ke GPU perangkat (Graphical Processing Unit), bukan CPU. Hasilnya, transisi kartu berjalan stabil pada 60 frame per detik (FPS) dengan konsumsi memori yang sangat ringan di peramban smartphone."*

---

*Dokumen ini disusun sebagai panduan teknis komprehensif bagi pengembang I Made Yuda Pramana untuk sidang kejuruan dan presentasi portofolio.*
