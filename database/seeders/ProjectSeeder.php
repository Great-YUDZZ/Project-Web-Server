<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::updateOrCreate(
            ['slug' => 'it-toolbox'],
            [
                'title' => 'IT Toolbox v1.5.0: All-in-One Developer, Network & System Utilities Suite',
                'slug' => 'it-toolbox',
                'category' => 'Network & Tools',
                'description' => "Aplikasi desktop engineering workbench native, modern, ringan, dan cepat yang dirancang untuk kebutuhan harian teknisi IT, siswa TKJ, software engineer, DevOps, dan network administrator. Dibangun menggunakan bahasa Go (Golang 1.25+) dan toolkit GUI modern Fyne v2.8 dengan arsitektur 100% offline-first dan dukungan multiplatform penuh (Linux & Windows). Versi terbaru v1.5.0 menghadirkan ekspansi modul besar, perombakan antarmuka Neumorphism Light, serta penambahan engine otomatisasi jaringan dan basis data.\n\nModul & Fitur Utama Pembaruan v1.5.0:\n1. Alat & Kalkulator Jaringan (Network & CIDR Workbench):\n   - Subnet & IP Calculator: Rekomendasi prefix & netmask paling hemat, rentang host usable, total host & rasio efisiensi alokasi, broadcast & wildcard, serta preset cepat (10, 50, 100, 250 host) dengan tombol 1-klik 'Salin Ringkasan'.\n   - CIDR Target Visualizer: Analisis blok CIDR (/24, /22, /20, /16, /30) lengkap dengan subnet mask dan network address.\n   - Number & Data Converter: Konversi basis bilangan (Biner, Oktal, Desimal, Heksadesimal), kalkulasi unit byte, dan transfer rate.\n   - Hash & Password Generator: MD5, SHA-1, SHA-256, SHA-512, JWT Inspector / Decoder, dan Random Password Generator berkekuatan tinggi.\n   - Format & Encode: Base64 encoder/decoder, URL encoder, JSON <-> YAML bidirectional converter, epoch/unix timestamp converter, dan text formatter.\n\n2. Konverter Berkas & Media Tools:\n   - PDF Suite: Penggabung (merger) dan pemisah (splitter) berkas PDF.\n   - Image Suite: Konverter format gambar dan image compressor/optimizer.\n   - OCR Engine: Optical Character Recognition lokal untuk ekstraksi teks dari gambar.\n   - Archive Engine: Pembuat dan pengekstraksi arsip ZIP instan.\n\n3. YouTube Media Downloader (Modul Baru v1.5.0):\n   - Pengunduh video dan audio YouTube dengan pemindai resolusi dinamis (4K, 1080p, 720p, 360p, hingga ekstraksi Audio M4A murni).\n   - Visual progress bar interaktif dengan estimasi waktu dan auto-muxing terintegrasi FFmpeg.\n\n4. Otomatisasi Cisco Packet Tracer (Modul Baru v1.5.0):\n   - Direktori perintah CLI Cisco IOS terstruktur untuk Router, Switch Catalyst, dan Client PC.\n   - Generator skrip konfigurasi instan untuk VLAN, Trunking 802.1Q, Inter-VLAN Routing, OSPF, ACL, dan DHCP Server.\n   - Panduan verifikasi topologi dan troubleshooting lab jaringan praktis.\n\n5. Database Schema Designer & DDL Suite (Modul Baru v1.5.0):\n   - Perancang skema database visual dengan perpustakaan DDL siap pakai (Auth & RBAC, E-Commerce, Akademik TKJ, Jaringan IPAM).\n   - Generator tabel kustom interaktif dengan pemilihan tipe data lintas DBMS (MySQL, MariaDB, PostgreSQL, SQLite, SQL Server, Oracle).\n   - Katalog perintah administrasi database CLI dan panduan prosedur backup/restore database produksi.\n\n6. Pengetahuan, IT Incident Logbook & Task Tracker:\n   - Katalog Port Directory standar IANA dan kamus lengkap HTTP Status Codes.\n   - Cheat sheet perintah esensial Linux CLI, Systemd, dan DevOps.\n   - Catatan teknis & error logbook berbasis SQLite lokal yang terenkripsi aman secara offline.\n   - Pelacak tugas pemeliharaan sistem dengan status visual real-time.\n\nDistribusi & Kemudahan Instalasi (Tersedia di GitHub Releases v1.5.0):\n- Linux: Paket resmi .deb (it-toolbox_1.5.0_amd64.deb) dengan integrasi otomatis ke Desktop (~/Desktop) dan Application Launcher sistem, serta skrip portable installer.\n- Windows: Eksekutabel mandiri siap jalan (it-toolbox.exe) dengan wizard pembuatan pintasan otomatis serta paket portabel ZIP (IT-Toolbox-Windows-Portable-x64.zip).\n- Performa: Native binary kompilasi Go berkecepatan tinggi tanpa runtime interpreter, penggunaan memori minimal, start-up instan, dan dukungan tema Neumorphism Light, Neumorphism Dark, serta Neo-Brutalism.",
                'topology_image' => 'images/topologies/it-toolbox.png',
                'tools_used' => 'Go 1.25+, Fyne v2.8, SQLite, Subnetting & CIDR, Cisco IOS CLI, Schema DDL Engine, YouTube DL / FFmpeg, Cryptography, Linux .deb, Windows .exe',
                'demo_link' => 'https://github.com/Great-YUDZZ/it-toolbox',
                'is_featured' => true,
                'is_hero' => true,
                'order' => 1,
            ]
        );

        Project::updateOrCreate(
            ['slug' => 'visualstyle-studio'],
            [
                'title' => 'VisualStyle Studio: Offline-First Visual CSS & Animation Workbench (Beta)',
                'slug' => 'visualstyle-studio',
                'category' => 'Frontend & Desktop Tools',
                'description' => "Aplikasi desktop native workbench visual styling dan tuning front-end CSS/animasi modern (offline-first & sandbox isolation). Dirancang khusus untuk frontend engineer, UI/UX designer, dan web developer dalam mempercepat perancangan tata letak, inspeksi elemen DOM real-time, peracikan palet & gradien warna tingkat lanjut, serta injeksi animasi CSS3 tanpa kompilasi rumit. Saat ini masih dalam fase aktif pengembangan (Beta).\n\nFitur & Keunggulan Utama:\n1. Visual CSS Inspector & Live Tuner:\n   - High-Precision Element Selector: Navigasi pohon elemen DOM real-time dengan highlight interaktif dan badge status.\n   - Live Color & Gradient Tuner: Penyetelan warna solid, linear gradient, dan radial gradient dengan preview langsung pada elemen aktif.\n   - Dual-Target Application: Terapkan warna/gradien pada Latar Kotak (Box Background) atau Teks Tulisan (Text Fill / Clipping via -webkit-background-clip).\n   - Kontrol Spesifisitas Cerdas: Opsi toggle '!important Override' untuk memenangkan aturan styling terhadap CSS bawaan framework.\n2. Sandbox Visual Prototyping & Generator Aturan:\n   - Clean CSS Rule Generator: Penghasil sintaks CSS instan dan teroptimasi dengan tombol 1-klik 'Copy CSS' dan 'Save Changes'.\n   - Project Palette & Quick Swatches: Palet warna terkurasi untuk konsistensi design tokens antar halaman.\n3. Multi-Device Viewport Switcher:\n   - Pengujian responsif instan: Desktop (1200px+), Tablet (768px), Mobile (375px), dan Fluid Auto dengan kontrol zoom presisi.\n   - Mode Sandbox Visual Builder terisolasi (sandbox.html & index.html) untuk eksperimen komponen web tanpa merusak file inti.\n4. Arsitektur 100% Offline-First:\n   - Berjalan sepenuhnya di komputer lokal menggunakan runtime desktop native tanpa membutuhkan koneksi internet atau server eksternal.\n   - Sinkronisasi file gaya lokal langsung (custom-styles.css & styles.css) dengan latensi 0.0ms dan performa 60 FPS.",
                'topology_image' => 'images/topologies/visualstyle-studio.png',
                'tools_used' => 'Electron, Node.js, JavaScript (ES6+), CSS3 Keyframes, DOM API, Visual CSS Inspector, Linux .deb/.AppImage, Windows .exe',
                'demo_link' => 'https://github.com/Great-YUDZZ/VisualStyle-Studio',
                'is_featured' => true,
                'is_hero' => true,
                'order' => 2,
            ]
        );

        Project::updateOrCreate(
            ['slug' => 'sakuku'],
            [
                'title' => 'SakuKu: Pengelola Keuangan Pribadi, Hutang-Piutang & Portofolio Investasi Multiaset',
                'slug' => 'sakuku',
                'category' => 'Financial Tech & Mobile',
                'description' => "Aplikasi pengelola keuangan pribadi, pencatatan hutang-piutang bertahap, dan pelacak portofolio investasi multiaset berbasis lokal (offline-first & privacy-focused). Dibangun menggunakan framework Flutter dan bahasa pemrograman Dart dengan arsitektur visual Neumorphism Light yang elegan, bersih, dan responsif lintas platform (Android, Windows, dan Linux Desktop).\n\nFitur & Keunggulan Utama:\n1. Dasbor Finansial & Visualisasi Interaktif:\n   - Arus Kas Dinamis: Grafik visual tren arus kas (pemasukan vs pengeluaran) harian, bulanan, dan tahunan beserta rasio tabungan (Savings Ratio).\n   - Diagram Lingkaran Kategori: Visualisasi proporsi pengeluaran dan pemasukan berbasis koordinat polar dengan kalkulasi sudut dinamis dan sinkronisasi interaktif.\n2. Portofolio Investasi Multiaset:\n   - Mendukung pencatatan Saham, Reksadana, Kripto, Obligasi/SBN, Emas, dan Deposito.\n   - Real-time Unrealized PnL, persentase ROI (Return on Investment), dan pelacak progres target tabungan.\n3. Pengelola Hutang & Piutang:\n   - Pencatatan hutang (kewajiban) dan piutang (hak tagih) dengan pelunasan cicilan bertahap serta sistem pelacak jatuh tempo (Overdue, Due Soon, Safe).\n4. Kalkulator Finansial & Proyeksi Majemuk:\n   - Simulasi pinjaman bunga Flat vs Efektif/Anuitas.\n   - Simulasi investasi bunga majemuk berkala (Compound Interest Dollar-Cost Averaging / DCA).\n5. Privasi & Keamanan 100% Offline:\n   - Penyimpanan data lokal pada perangkat menggunakan SQLite (sqflite native engine) tanpa ketergantungan server cloud eksternal.\n   - Fitur Backup & Restore JSON dengan verifikasi integritas kriptografi SHA-256 Checksum.",
                'topology_image' => 'images/topologies/sakuku.png',
                'tools_used' => 'Flutter, Dart 3.x, SQLite, Neumorphism UI, MVVM Architecture, SHA-256 Crypto, Android APK, Windows Portable, Linux Desktop',
                'demo_link' => 'https://github.com/Great-YUDZZ/SakuKu',
                'is_featured' => true,
                'is_hero' => false,
                'order' => 3,
            ]
        );
    }
}
