# Panduan Lengkap Setup DNS Server & Akses Client (DNS Setup Guide)
**Domain Tujuan:** `http://yuda.local`  
**Sistem Operasi Server:** Debian GNU/Linux 13 (Trixie)  
**Web Server:** Nginx 1.26 (Reverse Proxy & FastCGI PHP 8.4-FPM)  
**DNS Resolver:** BIND9 (Named) & Avahi mDNS Daemon

---

## 1. Pendahuluan & Konsep Arsitektur DNS Lokal

Website portofolio ini menggunakan domain lokal khusus **`yuda.local`**. Karena domain `.local` bukan domain publik di internet (seperti `.com` atau `.id`), perangkat klien (Laptop, Komputer, HP Android, iPhone) memerlukan sistem penerjemah nama domain ke alamat IP server (*Name Resolution*) di jaringan lokal (LAN / Wi-Fi).

### Skema Alur Akses Jaringan:

```
┌─────────────────────────────────┐
│ Perangkat Klien (HP / Laptop)   │
│ Buka Browser: http://yuda.local │
└────────────────┬────────────────┘
                 │
                 ▼ (1. Tanya DNS: "Berapa IP yuda.local?")
┌─────────────────────────────────┐
│ DNS Server BIND9 (Port 53)      │
│ Mengembalikan: IP Server        │
└────────────────┬────────────────┘
                 │
                 ▼ (2. Request HTTP Port 80 ke IP Server)
┌─────────────────────────────────┐
│ Nginx Web Server (Port 80)      │
│ Virtual Host: yuda.local        │
└────────────────┬────────────────┘
                 │
                 ▼ (3. Proses Aplikasi)
┌─────────────────────────────────┐
│ PHP 8.4-FPM & Laravel 11 App   │
└─────────────────────────────────┘
```

---

## 2. Ringkasan File & Script yang Terlibat

| File / Script | Lokasi | Fungsi |
| :--- | :--- | :--- |
| `setup-dns.sh` | `/var/www/project_tkj_yuda2/setup-dns.sh` | Script otomatisasi satu perintah untuk konfigurasi DNS, Virtual Host Nginx, dan Host mapping |
| `project_tkj_yuda2.conf`| `/etc/nginx/sites-available/project_tkj_yuda2` | Konfigurasi Virtual Host Nginx untuk domain `yuda.local` |
| `named.conf.local` | `/etc/bind/named.conf.local` | Pendaftaran zona domain `yuda.local` pada BIND9 |
| `db.yuda.local` | `/etc/bind/db.yuda.local` | Database forward zone record A BIND9 |
| `hosts` | `/etc/hosts` | Pemetaan resolusi domain statis lokal server |
| `dns.sh` | `/var/www/project_tkj_yuda2/public/dns.sh` | Script bantu otomatis untuk klien Linux & macOS |
| `dns.ps1` | `/var/www/project_tkj_yuda2/public/dns.ps1` | Script bantu otomatis untuk klien Windows (PowerShell) |

---

## 3. Konfigurasi di Sisi Server (Debian 13)

### Cara Cepat (Rekomendasi Satu Perintah)
Cukup jalankan script konfigurasi otomatis yang sudah disediakan di dalam repositori:

```bash
sudo bash /var/www/project_tkj_yuda2/setup-dns.sh
```

Script ini akan secara otomatis:
1. Mendeteksi IP aktif server dan default gateway jaringan.
2. Mengonfigurasi `/etc/hosts` server.
3. Mengonfigurasi zona DNS BIND9 (`/etc/bind/db.yuda.local`).
4. Mengaktifkan daemon Avahi mDNS (untuk Apple & Linux).
5. Memasang dan menguji konfigurasi Virtual Host Nginx.
6. Memperbarui script client `dns.sh` dan `dns.ps1` dengan IP terbaru server.

---

### Cara Manual & Penjelasan Konfigurasi Komponen Server

Jika ingin mengonfigurasi atau memodifikasi secara manual, berikut adalah langkah dan perintahnya:

#### Langkah 1: Memeriksa Alamat IP Server & Gateway
Jalankan perintah berikut di terminal server:
```bash
# Cek alamat IP lokal server
hostname -I | awk '{print $1}'

# Cek gateway jaringan
ip route | grep default | awk '{print $3}'
```
*Catatan:* Misalkan IP server yang diperoleh adalah `10.10.22.34` (atau `192.168.1.18`).

---

#### Langkah 2: Mengatur Pemetaan Lokal di `/etc/hosts` Server
Edit file `/etc/hosts`:
```bash
sudo nano /etc/hosts
```
Tambahkan entri berikut pada baris paling bawah:
```text
127.0.0.1   yuda.local
10.10.22.34 yuda.local
```
*(Ganti `10.10.22.34` dengan IP server Anda yang sebenarnya).*

---

#### Langkah 3: Mengonfigurasi BIND9 DNS Server (Port 53)
Pastikan paket BIND9 terpasang:
```bash
sudo apt update && sudo apt install -y bind9 bind9utils
```

1. **Buat file database zona:** `/etc/bind/db.yuda.local`:
```bash
sudo nano /etc/bind/db.yuda.local
```
Isikan konfigurasi Resource Record DNS berikut:
```text
$TTL    604800
@   IN  SOA yuda.local. root.yuda.local. (
                  2026092501 ; Serial
             604800         ; Refresh
              86400         ; Retry
            2419200         ; Expire
             604800 )       ; Negative Cache TTL

@   IN  NS  yuda.local.
@   IN  A   10.10.22.34
*   IN  A   10.10.22.34
```

2. **Daftarkan zona pada file** `/etc/bind/named.conf.local`:
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

3. **Konfigurasi opsi forwarder pada** `/etc/bind/named.conf.options`:
```bash
sudo nano /etc/bind/named.conf.options
```
Pastikan opsi berikut aktif agar DNS server juga bisa meneruskan kueri internet:
```text
options {
    directory "/var/cache/bind";
    listen-on port 53 { any; };
    listen-on-v6 port 53 { any; };
    allow-query { any; };
    recursion yes;
    forwarders {
        8.8.8.8;
        1.1.1.1;
    };
    dnssec-validation no;
    auth-nxdomain no;
};
```

4. **Uji sintaks dan restart layanan BIND9:**
```bash
# Validasi sintaks konfigurasi BIND9
sudo named-checkconf /etc/bind/named.conf
sudo named-checkzone yuda.local /etc/bind/db.yuda.local

# Restart service BIND9
sudo systemctl restart named
sudo systemctl enable named
```

---

#### Langkah 4: Mengonfigurasi Virtual Host Nginx (Web Server)
Virtual host bertugas menangkap permintaan HTTP dengan `Host: yuda.local` dan mengarahkannya ke direktori aplikasi Laravel `public/`:

1. Buat file virtual host di `/etc/nginx/sites-available/project_tkj_yuda2`:
```bash
sudo nano /etc/nginx/sites-available/project_tkj_yuda2
```
Isi konfigurasi server block Nginx:
```nginx
server {
    listen 80 default_server;
    listen [::]:80 default_server;
    server_name yuda.local localhost 127.0.0.1 _;
    root /var/www/project_tkj_yuda2/public;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;

    index index.php index.html;
    charset utf-8;
    client_max_body_size 20M;

    # Routing Laravel Front Controller
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    # FastCGI PHP 8.4-FPM
    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/run/php/php8.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_read_timeout 120;
    }

    # Static Assets Cache
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 30d;
        add_header Cache-Control "public, no-transform";
        access_log off;
    }

    # Blokir akses ke file sensitif (.env, .git)
    location ~ /\.(?!well-known).* {
        deny all;
        access_log off;
        log_not_found off;
    }
}
```

2. Aktifkan virtual host dan reload Nginx:
```bash
# Hapus default virtual host lama jika ada
sudo rm -f /etc/nginx/sites-enabled/default

# Buat symbolic link untuk mengaktifkan
sudo ln -sf /etc/nginx/sites-available/project_tkj_yuda2 /etc/nginx/sites-enabled/project_tkj_yuda2

# Uji konfigurasi Nginx
sudo nginx -t

# Muat ulang service Nginx
sudo systemctl reload nginx
```

---

## 4. Panduan Konfigurasi di Sisi Klien (Multiplatform)

Agar komputer atau smartphone klien yang terhubung dalam satu jaringan Wi-Fi/LAN bisa membuka `http://yuda.local`, ikuti panduan sesuai sistem operasi perangkat klien:

### 4.1 Klien Smartphone Android

> [!IMPORTANT]
> Sistem operasi Android secara default mengaktifkan **Private DNS (DNS over TLS)** yang memaksa kueri DNS lari ke Google/Cloudflare di internet, sehingga mengabaikan DNS server lokal. Anda **WAJIB mematikan Private DNS** terlebih dahulu!

1. **Langkah 1: Nonaktifkan Private DNS**
   - Buka menu **Pengaturan (Settings)** di HP Android.
   - Masuk ke menu **Koneksi / Jaringan & Internet** -> **DNS Pribadi (Private DNS)**.
   - Ubah setelan menjadi **Nonaktif (Off)**, lalu simpan.

2. **Langkah 2: Ubah Pengaturan Wi-Fi HP ke IP Statik**
   - Buka **Pengaturan Wi-Fi** dan ketuk ikon gerigi/nama Wi-Fi yang sedang terhubung.
   - Pilih menu **Kelola Pengaturan Jaringan / Opsi Lanjutan**.
   - Ubah **Setelan IP** dari `DHCP` menjadi **Statik**.
   - Isi formulir konfigurasi:
     - **Alamat IP**: Masukkan IP satu subnet dengan server (contoh: `10.10.22.210`).
     - **Gateway / Router**: IP Router jaringan (contoh: `10.10.18.1`).
     - **Panjang Awalan Jaringan**: `21` (atau `24` sesuai subnet).
     - **DNS 1**: **Alamat IP Server Debian Anda** (contoh: `10.10.22.34`).
     - **DNS 2**: `8.8.8.8` (sebagai cadangan).
   - Ketuk **Simpan**.

3. **Langkah 3: Buka Browser**
   - Buka Google Chrome di HP dan ketik:  
     👉 **`http://yuda.local`**

---

### 4.2 Klien Komputer / Laptop Windows

Ada 2 cara yang sangat mudah untuk Windows:

#### Cara A: Otomatis via Script PowerShell (Paling Direkomendasikan)
1. Buka **PowerShell sebagai Administrator** (*Run as Administrator*).
2. Jalankan perintah satu baris berikut untuk mengunduh dan mengeksekusi script DNS dari server:
```powershell
powershell -ExecutionPolicy Bypass -Command "Invoke-WebRequest -Uri 'http://10.10.22.34/dns.ps1' -OutFile '$env:TEMP\dns.ps1'; & '$env:TEMP\dns.ps1'"
```
Script tersebut akan otomatis mengatur DNS adapter dan mendaftarkan pemetaan ke file hosts Windows.

#### Cara B: Manual via File Hosts Windows
1. Buka aplikasi **Notepad** dengan klik kanan -> **Run as Administrator**.
2. Buka berkas: `C:\Windows\System32\drivers\etc\hosts`.
3. Tambahkan baris berikut di bagian paling bawah:
```text
10.10.22.34 yuda.local
```
4. Simpan file (`Ctrl + S`).
5. Buka Command Prompt (CMD) dan bersihkan cache DNS:
```cmd
ipconfig /flushdns
```
6. Buka browser (Chrome/Edge): **`http://yuda.local`**.

---

### 4.3 Klien Komputer Linux & macOS

#### Cara A: Otomatis via Terminal Klien
Jalankan perintah curl langsung dari terminal klien:
```bash
curl -s http://10.10.22.34/dns.sh | sudo bash
```

#### Cara B: Manual
Tambahkan domain ke file `/etc/hosts` pada komputer klien:
```bash
echo "10.10.22.34 yuda.local" | sudo tee -a /etc/hosts
```
Lalu bersihkan cache DNS klien:
```bash
# Pada Linux (systemd-resolved)
sudo resolvectl flush-caches

# Pada macOS
sudo killall -HUP mDNSResponder
```

---

### 4.4 Klien Apple iOS (iPhone / iPad)

Perangkat Apple secara bawaan memiliki dukungan protokol **mDNS (Bonjour/ZeroConfig)**:
1. Pastikan daemon `avahi-daemon` di server Debian telah aktif (`sudo systemctl status avahi-daemon`).
2. Hubungkan iPhone ke Wi-Fi yang sama dengan server.
3. Buka browser **Safari** dan langsung ketik:  
   👉 **`http://yuda.local`**  
   *(iPhone akan langsung mengenali nama domain secara otomatis tanpa perlu mengubah IP statik).*

---

### 4.5 Metode Hotspot Laptop (Solusi Tercepat untuk Ujian / Demonstrasi Penguji)

Jika Anda ingin mendemonstrasikan website portofolio ke guru atau penguji tanpa perlu mengubah setelan IP di HP mereka:

1. Buat **Wi-Fi Hotspot langsung dari Laptop Server**:
```bash
sudo nmcli dev wifi hotspot ifname wlp2s0 ssid 'Lab-TKJ-Yuda' password 'yuda12345'
```
*(Sesuaikan `wlp2s0` dengan nama interface Wi-Fi laptop Anda dari perintah `ip link`).*

2. Minta penguji menghubungkan HP mereka ke Wi-Fi **`Lab-TKJ-Yuda`**.
3. Karena laptop Anda bertindak sebagai Access Point sekaligus DHCP & DNS Server, perangkat penguji dapat langsung membuka:  
   👉 **`http://yuda.local`**

---

## 5. Perintah Pengujian & Diagnostik Troubleshooting

Jika klien mengalami kendala tidak bisa membuka halaman web, gunakan perintah diagnosa berikut:

### 1. Uji Resolusi DNS dari Server:
```bash
# Uji kueri BIND9 lokal
dig @127.0.0.1 yuda.local

# Uji menggunakan nslookup
nslookup yuda.local 127.0.0.1
```
*Hasil yang benar:* Harus mengembalikan IP lokal server pada bagian `ANSWER SECTION`.

### 2. Uji Port Layanan Terbuka:
```bash
# Pastikan Port 53 (DNS) dan Port 80 (HTTP) berstatus LISTEN
sudo ss -tulpn | grep -E ':(53|80)'
```

### 3. Uji Respon HTTP Web Server:
```bash
curl -I -H "Host: yuda.local" http://127.0.0.1/
```
*Hasil yang benar:* Mengembalikan status `HTTP/1.1 200 OK`.

### 4. Uji Ping dari Komputer Klien ke Server:
```bash
ping 10.10.22.34
ping yuda.local
```

### 5. Memeriksa Log Kendala:
```bash
# Log query dan error DNS BIND9
sudo journalctl -u named -n 30 --no-pager

# Log akses dan error Nginx
sudo tail -n 30 /var/log/nginx/error.log
```
