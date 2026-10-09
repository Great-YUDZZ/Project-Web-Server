---
title: "Panduan Operasional Terminal CLI & Maintenance"
category: "DevOps / Operations"
tags:
  - cli
  - devops
  - artisan
  - maintenance
  - bash
  - terminal
updated_at: "2026-10-09"
---

# Panduan Operasional Terminal CLI & Maintenance

Dokumen ini berfungsi sebagai lembar contekan (*cheatsheet*) praktis bagi administrator atau teknisi sistem dalam mengoperasikan, menguji, memelihara, dan menyelesaikan insiden (*troubleshooting*) pada server dan aplikasi web portofolio.

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Kembali ke pusat navigasi dokumentasi.
- [[01_Infrastruktur_LEMP]]: Pengelolaan service Nginx, PHP 8.4-FPM, dan MariaDB.
- [[02_Backend_Laravel_Framework]]: Perintah Artisan framework Laravel.
- [[04_Skema_Database_Relasional]]: Perintah migrasi skema dan pencadangan database.
- [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]]: Alasan di balik konfigurasi operasional.

---

## 1. Operasi Harian Framework Laravel (Artisan)

Semua perintah dijalankan di dalam direktori proyek `/var/www/project_tkj_yuda2`:

```bash
cd /var/www/project_tkj_yuda2
```

### A. Pengujian Otomatis (*Automated Testing Suite*)
Menjalankan seluruh 29 pengujian unit dan fitur untuk memastikan tidak ada regresi kode:
```bash
php artisan test
```

### B. Pembersihan & Pembaruan Cache Aplikasi
Gunakan rangkaian perintah ini setelah melakukan perubahan konfigurasi file `.env` atau pembaruan kode produksi:
```bash
# Membersihkan seluruh cache konfigurasi, route, dan view yang usang
php artisan optimize:clear

# Mengompilasi ulang cache konfigurasi untuk kecepatan eksekusi produksi
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### C. Manajemen Skema Basis Data
```bash
# Menjalankan migrasi database yang belum dieksekusi
php artisan migrate

# Memeriksa status migrasi tabel
php artisan migrate:status

# Mengisi data awal percontohan
php artisan db:seed
```

### D. Interaksi Langsung Melalui Laravel Tinker
```bash
php artisan tinker
```
*Contoh pengecekan di dalam konsol Tinker:*
```php
// Cek jumlah pesan masuk
App\Models\Message::count();

// Cek status server via monitor service
app(App\Services\ServerMonitorService::class)->getAllMetrics();
```

---

## 2. Operasi Kompilasi Aset Frontend (Vite)

Aplikasi menggunakan Vite 5 dan Tailwind CSS v4 untuk mengompilasi bundel JavaScript dan CSS:

```bash
# Kompilasi aset produksi (menghasilkan file teroptimasi di public/build/)
npm run build

# Menjalankan dev server lokal dengan Hot Module Replacement (HMR)
npm run dev
```

---

## 3. Manajemen Layanan Infrastruktur LEMP (Systemd)

Untuk memeriksa atau me-restart layanan server di Linux Debian:

```bash
# Nginx Web Server
sudo systemctl status nginx
sudo systemctl reload nginx
sudo nginx -t  # Uji sintaks konfigurasi /etc/nginx/sites-available/

# PHP 8.4 FastCGI Process Manager
sudo systemctl status php8.4-fpm
sudo systemctl restart php8.4-fpm

# MariaDB Relational Database
sudo systemctl status mariadb
sudo systemctl restart mariadb
```

---

## 4. Prosedur Diagnosis Masalah & Log Monitoring

Jika terjadi kendala pada website (misalnya HTTP 500 atau 502 Bad Gateway), periksa berkas log berikut:

```bash
# 1. Log error internal aplikasi Laravel
tail -n 100 -f storage/logs/laravel.log

# 2. Log error web server Nginx
sudo tail -n 100 -f /var/log/nginx/error.log

# 3. Log query lambat atau kendala koneksi PHP-FPM
sudo tail -n 100 -f /var/log/php8.4-fpm.log

# 4. Status beban CPU dan alokasi memori fisik saat ini
htop
free -h
df -h /var/www/project_tkj_yuda2
```

---

## 5. Prosedur Pencadangan Mandiri (*Database Backup*)

Lakukan pencadangan database secara berkala sebelum pembaruan besar:

```bash
# Dump basis data ke file SQL terkompresi
mysqldump -u root -p project_tkj_yuda2 | gzip > /home/yudz/backup_db_$(date +%Y%m%d_%H%M%S).sql.gz

# Memulihkan data dari berkas cadangan (jika diperlukan)
gunzip < /home/yudz/backup_db_YYYYMMDD_HHMMSS.sql.gz | mysql -u root -p project_tkj_yuda2
```

Untuk melihat anatomi kode yang dieksekusi oleh perintah-perintah ini, buka catatan [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]].
