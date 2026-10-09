---
title: "Dokumentasi Berkas: nginx/project_tkj_yuda2.conf"
category: "Berkas Konfigurasi Web Server"
tags:
  - file
  - nginx
  - web-server
  - fastcgi
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: nginx/project_tkj_yuda2.conf

Path Berkas: `/var/www/project_tkj_yuda2/nginx/project_tkj_yuda2.conf`
Salinan Aktif di Server: `/etc/nginx/sites-available/project_tkj_yuda2`

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[01_Infrastruktur_LEMP]]: Arsitektur tumpukan LEMP baremetal.
- [[16_Resep_Modifikasi_Database_dan_DevOps]]: Prosedur reload konfigurasi Nginx.

---

## 1. Fungsi & Peran Berkas

Salinan konfigurasi virtualhost Nginx yang bertindak sebagai gerbang terdepan (*reverse proxy & static file server*). Mengatur penanganan domain, port HTTP 80 dan HTTPS 443, kompresi Gzip, caching berkas gambar/font, dan forwarding eksekusi skrip PHP ke soket UNIX PHP 8.4-FPM.

---

## 2. Struktur & Baris Kritis Konfigurasi

- **`listen 80;` / `listen 443 ssl;`**: Menangani lalu lintas web masuk.
- **`server_name great-yuda.my.id yuda.local localhost;`**: Daftar nama domain dan host lokal yang dilayani.
- **`root /var/www/project_tkj_yuda2/public;`**:
  - *Aturan Wajib*: Harus mengarah ke subfolder `/public` demi keamanan dokumen internal Laravel.
- **`index index.php index.html;`**: Memprioritaskan `index.php` sebagai file awal.
- **`location / { try_files $uri $uri/ /index.php?$query_string; }`**:
  - Mengalihkan seluruh permintaan dinamis ke front controller Laravel.
- **`location ~ \.php$ { fastcgi_pass unix:/run/php/php8.4-fpm.sock; ... }`**:
  - Meneruskan eksekusi PHP melalui UNIX domain socket berlatensi rendah.

---

## 3. Panduan Baris Kode Operasional

### A. Jika Ingin MENAMBAH Domain Baru
- Buka baris `server_name ...;`, tambahkan nama domain baru di ujung baris sebelum titik koma.
- Salin berkas ke `/etc/nginx/sites-available/` dan jalankan:
  ```bash
  sudo nginx -t && sudo systemctl reload nginx
  ```
