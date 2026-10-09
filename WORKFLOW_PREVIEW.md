# Preview Workflow dan Arsitektur Web Portofolio TKJ

Dokumen ini dirancang secara khusus untuk visualisasi menggunakan ekstensi VS Code **Markdown Preview Mermaid Support**. Untuk melihat diagram secara interaktif di editor, tekan kombinasi tombol `Ctrl + Shift + V` atau klik kanan pada tab file ini lalu pilih **Open Preview**.

Semua diagram di bawah ini menggunakan sintaks Mermaid standar dan menggambarkan seluruh siklus operasional aplikasi web, mulai dari infrastruktur server hingga rendering antarmuka pengguna.

---

## 1. Topologi Arsitektur LEMP Baremetal

Diagram alir berikut menggambarkan interaksi menyeluruh antara peramban pengunjung, web server Nginx, runtime FastCGI PHP 8.4, aplikasi Laravel 12, dan subsistem Linux Debian 13.

```mermaid
flowchart TB
    subgraph Klien["1. Klien Pengguna"]
        Peramban["Peramban Web (Desktop / Mobile)"]
        MesinJS["Mesin JavaScript (GSAP, Swiper, Starfield 3D)"]
    end

    subgraph GerbangNginx["2. Web Server Nginx (Reverse Proxy)"]
        PortHTTP["Port 80 / 443 (HTTP/HTTPS)"]
        PenyajiStatis["Penyaji Aset Statis (CSS, JS, Gambar, Dokumen PDF)"]
        FastCGIProxy["FastCGI Proxy Pass (/run/php/php8.4-fpm.sock)"]
    end

    subgraph RuntimePHP["3. Runtime Backend PHP-FPM & Laravel 12"]
        KernelHTTP["Laravel HTTP Kernel (bootstrap/app.php)"]
        LapisanMiddleware["Lapisan Middleware (CSRF, Session, Auth, Throttle)"]
        Pengontrol["Pengontrol Aplikasi (PublicController, Admin, Auth)"]
        LayananBisnis["Layanan Khusus (ServerMonitorService)"]
        EloquentORM["Lapisan Data (Eloquent ORM & Query Builder)"]
    end

    subgraph PenyimpananData["4. Basis Data MariaDB / MySQL"]
        BasisData[("Database project_tkj (InnoDB Engine)")]
    end

    subgraph SubsistemHost["5. Kernel Linux Debian 13"]
        FileProc["Virtual FS (/proc/loadavg, /proc/meminfo, /proc/net/dev)"]
        PerintahSistem["Utilitas CLI (systemctl, ss, df, uptime)"]
    end

    Peramban -->|"Permintaan HTTP (GET, POST)"| PortHTTP
    PortHTTP -->|"Aset Statis (/build/*, /images/*)"| PenyajiStatis
    PortHTTP -->|"Skrip PHP Dinamis"| FastCGIProxy
    FastCGIProxy -->|"UNIX Socket"| KernelHTTP
    KernelHTTP --> LapisanMiddleware
    LapisanMiddleware --> Pengontrol
    Pengontrol --> LayananBisnis
    Pengontrol --> EloquentORM
    EloquentORM -->|"Protokol TCP 3306"| BasisData
    LayananBisnis -->|"Pembacaan Status"| FileProc
    LayananBisnis -->|"Eksekusi Shell Terbatas"| PerintahSistem
    Pengontrol -->|"Kompilasi Template Blade"| FastCGIProxy
    FastCGIProxy -->|"Respons HTML Stream"| PortHTTP
    PortHTTP -->|"Dokumen HTML & Aset Bundling"| Peramban
    Peramban --> MesinJS
```

---

## 2. Alur Permintaan Pengunjung Publik (Landing Page)

Diagram sekuensial ini memetakan urutan operasi internal saat pengunjung mengakses rute utama `/` hingga halaman ter-render sempurna dengan gaya monokrom dan tipografi geometris.

```mermaid
sequenceDiagram
    autonumber
    actor Pengunjung as Pengunjung Web
    participant Nginx as Nginx 1.22
    participant Route as Laravel Router
    participant Controller as PublicController
    participant Monitor as ServerMonitorService
    participant DB as MariaDB Database
    participant Blade as Blade Engine
    participant Browser as Browser Engine

    Pengunjung->>Nginx: HTTP GET /
    Nginx->>Route: FastCGI request ke index.php
    Route->>Controller: Eksekusi index(ServerMonitorService)
    
    activate Controller
    Controller->>DB: Query Skill::orderBy('category')->get()
    DB-->>Controller: Kumpulan koleksi keahlian
    
    Controller->>DB: Query Project::hero()->take(2)->get()
    DB-->>Controller: Koleksi proyek unggulan hero
    
    Controller->>DB: Query Certificate::featured()->get()
    DB-->>Controller: Koleksi sertifikat resmi
    
    Controller->>Monitor: Eksekusi getAllMetrics()
    activate Monitor
    Monitor->>Monitor: Baca /proc/loadavg dan meminfo
    Monitor-->>Controller: Data metrik server (CPU, RAM, Uptime)
    deactivate Monitor

    Controller->>DB: Query Project::count()
    DB-->>Controller: Angka total proyek lab

    Controller->>Blade: Kompilasi view('home', compact(...))
    activate Blade
    Blade->>Blade: Resolusi token font (Outfit, Inter, JetBrains Mono)
    Blade->>Blade: Resolusi manifest Vite public/build/manifest.json
    Blade-->>Controller: String HTML utuh
    deactivate Blade

    Controller-->>Nginx: FastCGI Response (200 OK + Payload HTML)
    deactivate Controller

    Nginx-->>Pengunjung: HTTP 200 OK (Dokumen HTML)
    
    activate Browser
    Browser->>Browser: Evaluasi CSS tokens (hitam #0a0a0a, abu-abu #878787, putih #ffffff)
    Browser->>Browser: Unduh Google Fonts (Outfit, Inter, JetBrains Mono)
    Browser->>Browser: Inisialisasi Starfield 3D Canvas
    Browser->>Browser: Pasang Scroll-Spy HUD Navbar
    Browser-->>Pengunjung: Visualisasi Halaman Interaktif Selesai
    deactivate Browser
```

---

## 3. Alur Pengiriman Formulir Kontak dan Proteksi Data

Diagram berikut merinci siklus validasi, sanitasi, proteksi serangan CSRF dan spam bot, serta penyimpanan pesan ke database.

```mermaid
sequenceDiagram
    autonumber
    actor Pengirim as Pengirim Pesan
    participant UI as Form Kontak (DOM)
    participant Nginx as Nginx
    participant Middleware as VerifyCsrfToken
    participant Controller as PublicController
    participant DB as MariaDB (Table messages)

    Pengirim->>UI: Isi data: nama, email, subjek, isi pesan
    Pengirim->>UI: Klik tombol Kirim Pesan Transmisi
    UI->>Nginx: HTTP POST /contact (Data Formulir + Token _token)
    
    Nginx->>Middleware: Teruskan ke kernel Laravel
    activate Middleware
    alt Token CSRF Tidak Valid atau Kedaluwarsa
        Middleware-->>Nginx: HTTP 419 Page Expired
        Nginx-->>Pengirim: Tampilan sesi kedaluwarsa, silakan muat ulang
    else Token CSRF Sah
        Middleware->>Controller: submitContact(Request $request)
        deactivate Middleware
        
        activate Controller
        Controller->>Controller: Validasi aturan (required, string, email, max length)
        
        alt Validasi Gagal (Data tidak lengkap / format salah)
            Controller-->>Nginx: Redirect back dengan pesan galat input
            Nginx-->>UI: Tampilkan container galat warna batu gelap
            UI-->>Pengirim: Indikasi bidang yang wajib diperbaiki
        else Validasi Berhasil
            Controller->>DB: INSERT INTO messages (name, email, subject, message, is_read, ip_address, created_at)
            DB-->>Controller: Konfirmasi penyimpanan baris baru
            Controller-->>Nginx: Redirect back dengan flash session success
            deactivate Controller
            Nginx-->>UI: Tampilkan notifikasi konfirmasi monokrom
            UI-->>Pengirim: Notifikasi transmisi berhasil diterima
        end
    end
```

---

## 4. Alur Kerja Telemetri Server Linux Real-Time

Diagram berikut menggambarkan cara layanan `ServerMonitorService` membaca metrik langsung dari kernel Linux tanpa dependensi eksternal, lalu menyajikannya ke frontend.

```mermaid
flowchart LR
    subgraph TitikAwal["1. Pemicu Permintaan"]
        Timer["Timer Interval Klien (Setiap 3 Detik)"]
        Manual["Tombol Manual Refresh"]
    end

    subgraph APIEndpoint["2. Endpoint Web"]
        RuteAPI["GET /api/metrics"]
        Controller["PublicController::metrics()"]
    end

    subgraph LayananTelemetri["3. ServerMonitorService"]
        MetodeCPU["getCpuUsage()"]
        MetodeRAM["getMemoryUsage()"]
        MetodeDisk["getDiskUsage()"]
        MetodeUptime["getUptime()"]
        MetodeStatus["getServiceStatus()"]
    end

    subgraph SumberKernel["4. Kernel Host Debian 13"]
        ProcStat["/proc/stat"]
        ProcMem["/proc/meminfo"]
        ProcUptime["/proc/uptime"]
        CmdDf["Perintah df -k /"]
        SysControl["systemctl is-active nginx/mariadb"]
    end

    subgraph FormatOutput["5. Serialisasi JSON"]
        OutputJSON["Payload JSON Metrik Terstruktur"]
        DOMUpdate["Pembaruan Nilai DOM (HUD Telemetry)"]
    end

    Timer --> RuteAPI
    Manual --> RuteAPI
    RuteAPI --> Controller
    Controller --> LayananBisnisService["ServerMonitorService"]
    LayananBisnisService --> MetodeCPU
    LayananBisnisService --> MetodeRAM
    LayananBisnisService --> MetodeDisk
    LayananBisnisService --> MetodeUptime
    LayananBisnisService --> MetodeStatus

    MetodeCPU --> ProcStat
    MetodeRAM --> ProcMem
    MetodeUptime --> ProcUptime
    MetodeDisk --> CmdDf
    MetodeStatus --> SysControl

    MetodeCPU --> OutputJSON
    MetodeRAM --> OutputJSON
    MetodeDisk --> OutputJSON
    MetodeUptime --> OutputJSON
    MetodeStatus --> OutputJSON

    OutputJSON --> DOMUpdate
```

---

## 5. Alur Otentikasi dan Pengelolaan Data Admin Panel

Diagram sekuensial ini merinci alur login administrator, regenerasi sesi keamanan, dan eksekusi operasi CRUD di dashboard admin.

```mermaid
sequenceDiagram
    autonumber
    actor Admin as Administrator
    participant LoginView as Halaman Login Admin
    participant AuthCtrl as AuthController
    participant Guard as Laravel Session Guard
    participant DB as MariaDB (Table users)
    participant Dashboard as Admin Dashboard
    participant ResourceCtrl as Project / Post Controller

    Admin->>LoginView: Akses URL /login
    LoginView-->>Admin: Formulir Otentikasi Obsidian Dark
    Admin->>LoginView: Masukkan kredensial (username/email dan password)
    LoginView->>AuthCtrl: HTTP POST /login

    activate AuthCtrl
    AuthCtrl->>DB: Query User berdasarkan username atau email
    DB-->>AuthCtrl: Catatan data akun user
    
    AuthCtrl->>AuthCtrl: Verifikasi Hash::check(password, password_hash)
    alt Kredensial Salah
        AuthCtrl-->>LoginView: Redirect back dengan notifikasi gagal login
        LoginView-->>Admin: Pesan kredensial tidak cocok
    else Kredensial Sah
        AuthCtrl->>Guard: Auth::login($user)
        Guard->>Guard: Sesi regenerasi token (Cegah Session Fixation)
        AuthCtrl-->>Dashboard: Redirect ke /admin/dashboard
        deactivate AuthCtrl
        
        Dashboard-->>Admin: Render Dashboard dengan metrik sistem
        
        Admin->>ResourceCtrl: Tambah / Edit data proyek lab atau artikel blog
        activate ResourceCtrl
        ResourceCtrl->>DB: Transaksi database (INSERT / UPDATE / DELETE)
        DB-->>ResourceCtrl: Baris data berhasil diperbarui
        ResourceCtrl-->>Admin: Tampilkan feedback status berhasil
        deactivate ResourceCtrl
    end
```

---

## 6. Pipeline Kompilasi Aset, Tipografi, dan Desain Monokrom

Diagram berikut mengilustrasikan bagaimana sistem tipografi baru (`Outfit`, `Inter`, `JetBrains Mono`) dan palet warna monokrom dikompilasi oleh Vite 8 dan Tailwind CSS v4.

```mermaid
flowchart TD
    subgraph SumberKode["1. Sumber Kode Desain"]
        CSSSource["resources/css/app.css (@theme tokens & utility classes)"]
        JSSource["resources/js/app.js (Interaksi, Starfield, Nav ScrollSpy)"]
        BladeViews["resources/views/**/*.blade.php (Template Antarmuka)"]
    end

    subgraph EngineTipografi["2. Konfigurasi Tipografi Geometris"]
        FontOutfit["Outfit (Weights 400 - 900) -> --font-display, --font-geometric"]
        FontInter["Inter (Weights 300 - 800) -> --font-body, --font-sans"]
        FontMono["JetBrains Mono (Weights 400 - 700) -> --font-mono"]
        GoogleFontsAPI["Google Fonts CDN / Bunny Fonts Local Bundle"]
    end

    subgraph PaletMonokrom["3. Nilai Variabel Warna Monokrom"]
        WarnaHitam["Latar Belakang: #0A0A0A (Hitam Pekat)"]
        WarnaPermukaan["Kartu & Komponen: #141414, #1F1F1F (Abu-abu Gelap)"]
        WarnaTeksMuted["Teks Sekunder & Border: #878787, #2A2A2A (Abu-abu)"]
        WarnaTeksPutih["Teks Utama & Aksen: #F5F5F5, #FFFFFF (Putih Bersih)"]
    end

    subgraph BundlerVite["4. Vite 8 & Tailwind CSS v4 Engine"]
        ViteCompiler["Vite Build Runner (Kompilasi CSS & Tree Shaking)"]
        TailwindEngine["@tailwindcss/vite Scanner"]
        AssetOutput["public/build/assets/ (app-*.css, app-*.js, manifest.json)"]
    end

    subgraph BrowserOutput["5. Tampilan Akhir Peramban"]
        RenderTampilan["Tampilan Web Bersih, Presisi, Berorientasi Keteknikan"]
    end

    CSSSource --> TailwindEngine
    BladeViews --> TailwindEngine
    FontOutfit --> CSSSource
    FontInter --> CSSSource
    FontMono --> CSSSource
    GoogleFontsAPI --> BladeViews

    WarnaHitam --> CSSSource
    WarnaPermukaan --> CSSSource
    WarnaTeksMuted --> CSSSource
    WarnaTeksPutih --> CSSSource

    TailwindEngine --> ViteCompiler
    JSSource --> ViteCompiler
    ViteCompiler --> AssetOutput
    AssetOutput --> RenderTampilan
```

---

## 7. Mesin State Navigasi HUD & Dynamic Scroll-Spy

Diagram state berikut memetakan logika JavaScript pada floating HUD navbar dalam mendeteksi section aktif pengunjung.

```mermaid
stateDiagram-v2
    [*] --> SectionHero: Pengunjung berada di bagian atas layar

    SectionHero --> SectionWorks: Pengguna menggulir layar ke bawah (Scroll Offset)
    SectionWorks --> SectionSkills: Pengguna menggulir melewati #works
    SectionSkills --> SectionCerts: Pengguna menggulir melewati #skills
    SectionCerts --> SectionTech: Pengguna menggulir melewati #certificates
    SectionTech --> SectionStats: Pengguna menggulir melewati #technologies
    SectionStats --> SectionContact: Pengguna menggulir ke bagian footer

    SectionContact --> SectionStats: Pengguna menggulir layar ke atas
    SectionStats --> SectionTech: Pengguna menggulir ke atas
    SectionTech --> SectionCerts: Pengguna menggulir ke atas
    SectionCerts --> SectionSkills: Pengguna menggulir ke atas
    SectionSkills --> SectionWorks: Pengguna menggulir ke atas
    SectionWorks --> SectionHero: Pengguna kembali ke puncak layar

    state SectionHero {
        [*] --> AktifkanPillHero: Pasang class bg-white/15 text-white
        AktifkanPillHero --> NonaktifkanLainnya: Redupkan tautan lainnya ke #878787
    }

    state SectionWorks {
        [*] --> AktifkanPillWorks: Pasang class bg-white/15 text-white
        AktifkanPillWorks --> NonaktifkanLainnyaWorks: Redupkan tautan lainnya
    }

    state SectionContact {
        [*] --> AktifkanPillContact: Pasang class bg-white/15 text-white
        AktifkanPillContact --> NonaktifkanLainnyaContact: Redupkan tautan lainnya
    }
```

---

## 8. Relasi Data Entitas Relasional (ERD)

Diagram ERD berikut memetakan struktur tabel database yang menyokong seluruh alur data aplikasi.

```mermaid
erDiagram
    USERS ||--o{ POSTS : "menulis"
    USERS {
        bigint id PK
        string name
        string email UK
        string username UK
        string password
        timestamp created_at
    }

    PROJECTS {
        bigint id PK
        string title
        string slug UK
        string category
        text description
        string tech_stack
        boolean is_featured
        boolean is_hero
        int order
        timestamp created_at
    }

    SKILLS {
        bigint id PK
        string name
        string category
        int level
        string icon
        timestamp created_at
    }

    CERTIFICATES {
        bigint id PK
        string title
        string issuer
        string credential_id
        string credential_url
        string verification_status
        boolean is_featured
        int order
        timestamp created_at
    }

    POSTS {
        bigint id PK
        bigint user_id FK
        string title
        string slug UK
        string category
        text excerpt
        longtext content
        boolean is_published
        int views_count
        timestamp published_at
        timestamp created_at
    }

    MESSAGES {
        bigint id PK
        string name
        string email
        string subject
        text message
        boolean is_read
        string ip_address
        timestamp created_at
    }
```

---

## Ringkasan Integrasi dan Penggunaan

File visualisasi workflow ini dirancang untuk menjaga transparansi dan kemudahan pemeliharaan kode:
- Setiap alur kerja mematuhi arsitektur bersih tanpa komponen tersembunyi.
- Visualisasi diuji kompatibel dengan ekstensi **Markdown Preview Mermaid Support**.
- Jika Anda memperbarui rute atau struktur controller baru, Anda dapat memperbarui blok Mermaid yang sesuai dalam dokumen ini.
