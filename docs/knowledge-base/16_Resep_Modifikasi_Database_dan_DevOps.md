---
title: "Resep Modifikasi Basis Data, Konfigurasi Bundler, & DevOps Server"
category: "Playbook / Database & DevOps"
tags:
  - database-playbook
  - devops
  - migrations
  - seeders
  - nginx
  - vite
  - line-by-line
updated_at: "2026-10-09"
---

# Resep Modifikasi Basis Data, Konfigurasi Bundler, & DevOps Server

Dokumen ini adalah panduan langkah demi langkah saat Anda ingin **membuat migrasi skema tabel baru**, **menambah atau memodifikasi data seeder**, **mengonfigurasi bundler Vite**, serta **mengelola web server Nginx dan permission file di server Linux**.

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[01_Infrastruktur_LEMP]]: Konfigurasi Nginx dan PHP-FPM di sistem host Debian.
- [[04_Skema_Database_Relasional]]: Struktur relasi tabel dan arsitektur database.
- [[11_Panduan_Operasional_CLI]]: Perintah praktis maintenance terminal.
- [[13_Peta_Folder_dan_Berkas_Proyek]]: Peta inventarisasi seluruh berkas proyek.
- [[14_Resep_Modifikasi_Backend]]: Penyelarasan kolom database dengan Model Eloquent.

---

## 1. Modifikasi Skema Basis Data (`database/migrations/`)

Seluruh perubahan tabel di basis data MariaDB/MySQL harus dilakukan melalui file migrasi deklaratif agar riwayat skema terlacak secara konsisten.

### A. Resep Menambahkan Kolom Baru pada Tabel yang Sudah Ada
Misalnya, Anda ingin menambahkan kolom `hardware_spec` pada tabel `projects`:

1. **Jalankan Perintah Pembuatan Migrasi via Terminal**:
   ```bash
   php artisan make:migration add_hardware_spec_to_projects_table --table=projects
   ```
2. **Buka Berkas Migrasi Baru**:
   - Berkas akan berada di `database/migrations/YYYY_MM_DD_HHMMSS_add_hardware_spec_to_projects_table.php`.
3. **Tulis Definisi Kolom pada Method `up()` dan `down()`**:
   ```php
   public function up(): void
   {
       Schema::table('projects', function (Blueprint $table) {
           $table->text('hardware_spec')->nullable()->after('tools_used');
       });
   }

   public function down(): void
   {
       Schema::table('projects', function (Blueprint $table) {
           $table->dropColumn('hardware_spec');
       });
   }
   ```
4. **Jalankan Migrasi ke Database**:
   ```bash
   php artisan migrate
   ```
5. **Keterhubungan Penting ke Model**:
   - Buka `app/Models/Project.php`, tambahkan `'hardware_spec'` ke dalam array `$fillable` (baris 13-24) agar nilai dapat disimpan saat form di-submit.
   - Buka view admin `resources/views/admin/projects/create.blade.php` dan `edit.blade.php` untuk menambahkan input field textarea.

### B. Memeriksa Status & Membatalkan Migrasi Terakhir
```bash
# Cek tabel mana saja yang sudah atau belum termigrasi
php artisan migrate:status

# Batalkan migrasi paling akhir jika terjadi kesalahan penulisan kolom
php artisan migrate:rollback
```

---

## 2. Modifikasi Data Awal Sistem (`database/seeders/`)

Seeder digunakan untuk mengisi data awal percontohan tanpa perlu memasukkan data satu per satu melalui formulir web.

### A. Menambahkan Entri Proyek Baru ke Seeder
- **Buka Berkas**: `database/seeders/ProjectSeeder.php`
- **Lokasi Penambahan**: Cari array `$projects = [...]`.
- **Langkah Penambahan**:
  ```php
  [
      'title' => 'Implementasi VLAN & Hotspot MikroTik RouterOS v7',
      'slug' => 'implementasi-vlan-hotspot-mikrotik',
      'category' => 'Networking',
      'description' => 'Konfigurasi trunking VLAN pada switch terkelola dan sistem billing voucher...',
      'topology_image' => '/images/topologies/mikrotik-vlan.svg',
      'tools_used' => 'MikroTik RB750Gr3, Winbox, Cisco Packet Tracer',
      'demo_link' => 'https://lab.domain.id',
      'is_featured' => true,
      'is_hero' => false,
      'order' => 1,
  ],
  ```
- **Keterhubungan**:
  - `DatabaseSeeder.php` pada baris 20-25 memanggil `ProjectSeeder::class`.
  - Untuk mengeksekusi seeder ini ke basis data tanpa menghapus tabel lain:
    ```bash
    php artisan db:seed --class=ProjectSeeder
    ```

---

## 3. Konfigurasi Bundler Aset (`vite.config.js`)

Berkas ini mengontrol bagaimana JavaScript dan CSS dikompilasi oleh Vite.

### A. Memeriksa atau Menambahkan Berkas Entri Kompilasi
- **Buka Berkas**: `vite.config.js`
- **Lokasi Baris**: Baris 8 hingga 15 (di dalam plugin `laravel({...})`).
- **Konfigurasi Aktif**:
  ```javascript
  laravel({
      input: [
          'resources/css/app.css',
          'resources/js/app.js',
      ],
      refresh: true,
  }),
  ```
- **Langkah Modifikasi**: Jika di masa mendatang Anda membuat modul skrip JavaScript independen (misalnya `resources/js/custom-dashboard.js`) yang tidak ingin digabung ke dalam `app.js`, tambahkan path berkas tersebut ke dalam array `input`.
- **Perintah Kompilasi Wajib**:
  ```bash
  npm run build
  ```

---

## 4. Konfigurasi Virtualhost Nginx (`nginx/project_tkj_yuda2.conf`)

Berkas ini adalah salinan master konfigurasi web server yang aktif di `/etc/nginx/sites-available/project_tkj_yuda2`.

### A. Anatomi Baris Kritis Konfigurasi Nginx
- **Root Direktori Dokumen**:
  ```nginx
  root /var/www/project_tkj_yuda2/public;
  ```
  *Aturan Penting*: Nginx harus selalu mengarah ke subfolder `/public`, bukan ke root `/var/www/project_tkj_yuda2`, agar berkas sensitif seperti `.env`, `routes/`, dan `storage/` tidak dapat diunduh langsung oleh publik dari peramban.
- **Koneksi FastCGI ke PHP 8.4-FPM**:
  ```nginx
  fastcgi_pass unix:/run/php/php8.4-fpm.sock;
  ```
  *Aturan Penting*: Menggunakan soket UNIX di direktori memori `/run/` alih-alih port TCP `127.0.0.1:9000` untuk mengurangi overhead latensi jaringan lokal.

### B. Prosedur Pembaruan Konfigurasi Nginx di Server
Jika Anda mengubah konfigurasi Nginx:
```bash
# 1. Salin konfigurasi ke direktori sistem (jika menyunting di folder repositori)
sudo cp /var/www/project_tkj_yuda2/nginx/project_tkj_yuda2.conf /etc/nginx/sites-available/project_tkj_yuda2

# 2. Uji sintaks apakah ada kesalahan ketik
sudo nginx -t

# 3. Muat ulang konfigurasi tanpa mematikan koneksi aktif
sudo systemctl reload nginx
```

---

## 5. Manajemen Hak Akses Direktori Server Linux (Permission Fix)

Aplikasi web Laravel membutuhkan izin menulis (*write permission*) pada direktori `storage` dan `bootstrap/cache` untuk menulis berkas log, sesi, dan cache Blade yang terkompilasi.

Jika terjadi galat *Permission Denied* (HTTP 500) di server Linux:
```bash
cd /var/www/project_tkj_yuda2

# Berikan kepemilikan grup ke pengguna web server Nginx/PHP-FPM (www-data)
sudo chown -R yudz:www-data storage bootstrap/cache

# Berikan hak izin baca, tulis, dan eksekusi pada level grup
sudo chmod -R 775 storage bootstrap/cache
```
