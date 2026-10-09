---
title: "Infrastruktur LEMP Stack & Lingkungan Baremetal Linux"
category: "Infrastruktur & Server"
tags:
  - lemp
  - nginx
  - php-fpm
  - debian
  - baremetal
updated_at: "2026-10-09"
---

# Infrastruktur LEMP Stack & Lingkungan Baremetal Linux

Modul ini mendokumentasikan spesifikasi teknis dan konfigurasi lingkungan server yang menaungi aplikasi web portofolio. Sistem berjalan di atas server fisik (*baremetal*) bersistem operasi **Linux Debian 13** dengan stack **LEMP (Linux, Nginx, MariaDB/MySQL, PHP)**.

Kembali ke gerbang utama: [[00_Home_Index]]

---

## 1. Arsitektur Komponen Server

```
+-----------------------------------------------------------------+
|                        KLIEN (Peramban Web)                     |
+-----------------------------------------------------------------+
                                |
                   Port 80 / 443 (HTTP/HTTPS)
                                v
+-----------------------------------------------------------------+
|                      NGINX 1.22+ WEB SERVER                     |
|  - Terminasi SSL / TLS                                          |
|  - Reverse Proxy FastCGI                                        |
|  - Kompresi Gzip & Penyaji Berkas Statis (/build, /images)      |
+-----------------------------------------------------------------+
                                |
                  UNIX Socket FastCGI IPC
            (/run/php/php8.4-fpm.sock)
                                v
+-----------------------------------------------------------------+
|                     PHP 8.4-FPM RUNTIME ENGINE                  |
|  - Zend OPcache & JIT Compiler Aktif                            |
|  - Eksekusi Kernel Laravel 12 (public/index.php)                |
+-----------------------------------------------------------------+
                                |
                  Koneksi TCP Soket Lokal (:3306)
                                v
+-----------------------------------------------------------------+
|                    MARIADB / MYSQL DATABASE                     |
|  - Penyimpanan Persisten Data (InnoDB)                          |
+-----------------------------------------------------------------+
```

---

## 2. Konfigurasi VirtualHost Nginx

File blok konfigurasi Nginx untuk situs ini berlokasi di `/etc/nginx/sites-available/default` atau `/etc/nginx/sites-available/project_tkj_yuda2`.

### Konfigurasi Inti
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name localhost 127.0.0.1;
    root /var/www/project_tkj_yuda2/public;

    # Dokumen indeks bawaan
    index index.php index.html index.htm;

    # Karakter encoding
    charset utf-8;

    # Optimasi pengiriman file baremetal
    sendfile on;
    tcp_nopush on;
    tcp_nodelay on;
    keepalive_timeout 65;
    types_hash_max_size 2048;

    # Routing seluruh permintaan melalui Laravel Front Controller
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Penanganan aset statis dengan cache panjang
    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 30d;
        add_header Cache-Control "public, no-transform";
        access_log off;
        try_files $uri =404;
    }

    # Jalur eksekusi skrip PHP melalui FastCGI UNIX Socket
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    # Blokir akses berkas tersembunyi seperti .env dan .git
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 3. Runtime PHP 8.4-FPM

Aplikasi ini menggunakan **PHP 8.4**, rilis modern PHP yang menawarkan fitur bahasa terkini, optimasi memori, serta performa eksekusi kompilasi Just-In-Time (JIT).

### Konfigurasi Pool PHP-FPM (`/etc/php/8.4/fpm/pool.d/www.conf`)
- **Listen Socket**: `unix:/run/php/php8.4-fpm.sock`
  *Alasan*: Menggunakan UNIX domain socket menghasilkan latensi jauh lebih rendah dibandingkan soket TCP jaringan (`127.0.0.1:9000`) karena tidak memerlukan overhead stack protokol TCP/IP loopback.
- **Proses Manager (`pm`)**: `dynamic`
- **Max Children**: `pm.max_children = 10`
- **Start Servers**: `pm.start_servers = 3`
- **Min / Max Spare Servers**: `pm.min_spare_servers = 2`, `pm.max_spare_servers = 5`
- **Max Requests**: `pm.max_requests = 500` (mencegah kebocoran memori jangka panjang)

### Modul Ekstensi Kritis
Aplikasi bergantung pada ekstensi resmi berikut:
- `php8.4-fpm`: Manajemen proses pool aplikasi web.
- `php8.4-mysql`: Komunikasi dengan database MariaDB.
- `php8.4-mbstring` & `php8.4-xml`: Parsing string multibita dan manipulasi dokumen.
- `php8.4-curl`: Integrasi HTTP client eksternal.
- `php8.4-zip`: Pembacaan arsip file sertifikat dan modul cadangan.
- `php8.4-opcache`: Peningkatan kecepatan hingga 3x lipat melalui cache bytecode compiled.

---

## 4. Manajemen Layanan Systemd (Service Control)

Status seluruh komponen server dipantau langsung oleh sistem init Systemd pada Debian 13:

| Service Unit | Port / Socket | Perintah Status |
|---|---|---|
| `nginx.service` | `0.0.0.0:80` | `systemctl status nginx` |
| `php8.4-fpm.service` | `/run/php/php8.4-fpm.sock` | `systemctl status php8.4-fpm` |
| `mariadb.service` | `127.0.0.1:3306` | `systemctl status mariadb` |

Panduan lengkap mengenai perintah CLI darurat dan troubleshooting dapat dibaca pada:
[[11_Panduan_Operasional_CLI]]

---

## 5. Hubungan dengan Modul Lain

- **Integrasi Backend**: Konfigurasi Nginx di atas meneruskan request langsung ke file bootstrap Laravel yang dibahas di [[02_Backend_Laravel_Framework]].
- **Telemetri Live**: Status operasional Nginx dan MariaDB dibaca secara berkala oleh modul telemetri pada [[03_Telemetri_Linux_Kernel]].
- **Alasan Pemilihan Desain**: Rincian mengapa soket UNIX dan PHP 8.4 dipilih dianalisis pada [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]].
