# Walkthrough: Pembaruan Kebijakan AI Yuna (Menjawab Segala Pertanyaan & Bebas Kode)

## Ringkasan Perubahan
Implementasi konfigurasi baru pada asisten AI **Yuna** di website portofolio I Made Yuda Pramana:
1. **Dapat Menjawab Segala Pertanyaan**: Yuna bebas membahas topik apapun secara mendalam dan natural (pengetahuan umum, sains, teori komputer, jaringan, sejarah, percakapan sehari-hari, dll). Tidak ada batasan filter kata kunci topik.
2. **Larangan Tunggal: Kode Pemrograman**: Yuna secara ketat dilarang membagikan atau membuat kode pemrograman (HTML, CSS, JavaScript, Python, PHP, Go, C/C++, Java, Bash, SQL, dll).
3. **Penjelasan Konseptual & Alur Logika**: Ketika diminta kode, Yuna menolak secara sopan dan menjelaskan konsep arsitektur, algoritma, atau teori pemecahan masalah secara deskriptif/naratif tanpa menuliskan sintaks atau blok kode.
4. **Sanitasi Multi-Lapis**: 
   - Prompt instruksi sistem yang tegas dan ketat.
   - Metode `sanitizeCodeBlocks()` di sisi controller untuk mengintersepsi jika terdapat blok kode (` ``` `).
   - Filter `stripEmojis()` tetap aktif untuk memastikan respons bebas emoji.
   - Proteksi identitas tetap terjaga: Yuna tidak pernah membocorkan nama model dasar.

---

## Verifikasi Pengujian Langsung (Live Testing)

### 1. Pertanyaan Pengetahuan Umum (Sains)
- **Input**: `"Apa itu fotosintesis pada tumbuhan secara singkat?"`
- **Hasil**: Dijawab secara mendalam dan terstruktur mengenai alur biologis fotosintesis, bahan baku, klorofil, dan hasil glukosa/oksigen.
- **Status**: Berhasil (`source: ai_engine`), tanpa emoji, tanpa blok kode.

### 2. Permintaan Kode HTML & CSS
- **Input**: `"Buatkan saya kode HTML dan CSS untuk membuat tombol login yang cantik"`
- **Hasil**: Yuna menolak menuliskan kode pemrograman, lalu menjelaskan 4 pilar desain tombol modern secara teori (Hierarki visual/kontras warna, interaktivitas/state hover-focus-active, tipografi & padding proporsional, serta border-radius & soft shadow).
- **Status**: Berhasil, menolak memberikan kode dan memberikan pemaparan konsep yang komprehensif.

### 3. Permintaan Kode Python
- **Input**: `"Tolong buatkan kode python untuk sorting list bilangan genap dan ganjil"`
- **Hasil**: Yuna menolak menuliskan skrip Python, lalu menjabarkan alur logika algoritma secara runut (analisis data, pemisahan genap-ganjil dengan operasi modulo 2, algoritma sorting seperti bubble/insertion sort, dan rekonsiliasi penggabungan list).
- **Status**: Berhasil, murni penjelasan logika tanpa baris kode atau sintaks.

### 4. Topik Jaringan & IT
- **Input**: `"Jelaskan perbedaan antara TCP dan UDP"`
- **Hasil**: Menjelaskan 5 poin perbandingan (koneksi 3-way handshake vs connectionless, keandalan, urutan paket, latensi/kecepatan, dan contoh use-case dunia nyata).
- **Status**: Berhasil, akurat dan relevan dengan profil TKJ.

---

## Sistem Failover & Rotasi Multi-Key (Cadangan)
1. **Primary Provider (Google Gemini)**:
   - Mendukung rotasi beberapa key sekaligus (`GEMINI_API_KEY`, `GEMINI_API_KEY_BACKUP`, atau koma `key1,key2`).
   - Jika key pertama limit/habis kuota (HTTP 429), sistem otomatis beralih ke key berikutnya.
2. **Secondary Provider (Local Antigravity Gateway Port 20128)**:
   - Terhubung dengan `BACKUP_AI_KEY` (disimpan aman di `.env`).
   - Endpoint: `http://127.0.0.1:20128/v1/chat/completions`.
   - Model: `ag/gemini-3.7-flash-low`.
   - Uji Failover: Berhasil (`source: backup_ai_engine`) saat key Gemini utama disimulasikan habis/error.
   - Aturan larangan kode tetap ditegakkan secara ketat pada gateway cadangan.
3. **Tertiary Offline Fallback**:
   - Menjawab seputar profil portofolio, sertifikasi Cisco/Komdigi, dan IT Toolbox secara lokal dari basis data.

---

## Audit & Pembersihan Berkas Tidak Terpakai (Workspace Cleanup)

### Berkas yang Berhasil Dibersihkan (~6.5 MB):
1. **Berkas Kosong (0 bytes)**:
   - `public/test_laptop_3d.html`
   - `database/database.sqlite` (Aplikasi aktif menggunakan MariaDB)
2. **Build Cache Usang**:
   - `public/build.old/` (Backup build Vite lama, ~408 KB)
3. **Duplikat & Aset Gambar Lama**:
   - `public/images/it-toolbox.jpg` (597 KB duplikat JPG usang)
   - `public/images/topologies/it-toolbox.jpg` (165 KB JPG usang)
4. **Diagram Lab Jaringan Fiktif**:
   - `public/images/topologies/lab-firewall-qos.svg`
   - `public/images/topologies/lab-lemp-server.svg`
   - `public/images/topologies/lab-monitoring-zabbix.svg`
   - `public/images/topologies/lab-ospf-vlan.svg`
   - `public/images/topologies/lab-proxmox-cloud.svg`
5. **Aset Render Uji Coba Sementara**:
   - `public/images/discord_assets/laptop_clean_test.png` (~1.0 MB)
   - `public/images/discord_assets/laptop_clean_test2.png` (~1.0 MB)
   - `public/images/discord_assets/laptop_clean_test3.png` (~1.0 MB)
   - `public/images/discord_assets/test_rot180.png` (~815 KB)
6. **Skrip Uji Ad-hoc**:
   - `scripts/verify_robot_wander.js`

### Berkas Penting yang Dipertahankan:
- `public/images/discord_assets/laptop_frames/*.webp`: Digunakan untuk animasi scroll canvas 3D laptop pada landing page.
- `DATABASE_SCHEMA.md`, `DNS_SETUP_GUIDE.md`, `DOKUMENTASI_TEKNIS.md`: Dokumentasi teknis proyek.
- `public/dns.sh`, `public/dns.ps1`, `setup-dns.sh`, `scripts/auto-dns-sync.sh`: Skrip otomatisasi konfigurasi DNS client/server.
- `public/images/default-topology.svg`: Fallback image model Project.

### Status Verifikasi:
- **PHPUnit Test Suite**: 20/20 test passing (116 assertions).
- **Integritas Route & View**: Seluruh endpoint publik dan admin berfungsi tanpa broken links/missing assets.

