---
title: "Mekanisme Telemetri Linux Kernel & ServerMonitorService"
category: "Telemetry / Linux Kernel"
tags:
  - telemetry
  - kernel
  - linux
  - procfs
  - monitoring
updated_at: "2026-10-09"
---

# Mekanisme Telemetri Linux Kernel & ServerMonitorService

Dokumen ini menjelaskan secara teknis bagaimana web portofolio ini mengekstrak data performa server fisik secara langsung dari sistem berkas virtual Linux (`/proc`) menggunakan service backend `ServerMonitorService`.

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Kembali ke pusat navigasi dokumentasi.
- [[01_Infrastruktur_LEMP]]: Server fisik Linux Debian 13 dan runtime eksekusi.
- [[02_Backend_Laravel_Framework]]: Integrasi `ServerMonitorService` ke dalam `MetricsController` dan `DashboardController`.
- [[07_Animasi_Interaksi_Visual]]: Widget HUD telemetri frontend yang mengonsumsi data ini via polling fetch.
- [[11_Panduan_Operasional_CLI]]: Perintah CLI Linux (`top`, `htop`, `free -m`, `uptime`) yang selaras dengan data telemetri.
- [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]]: Bedah detail alasan implementasi pembacaan `/proc` tanpa dependensi eksternal.

---

## 1. Filosofi Telemetri Baremetal Tanpa Agen Berat

Sebagian besar sistem monitoring web modern mengandalkan daemon pihak ketiga (seperti Prometheus Node Exporter, Datadog, atau New Relic) yang memakan memori puluhan megabyte. 

Untuk server lab mandiri TKJ ini, pendekatan yang dipilih adalah **In-Process Kernel Polling**:
- Mengakses virtual filesystem `/proc` Linux secara langsung melalui fungsi file I/O PHP (`file_get_contents`).
- Tanpa proses daemon latar belakang tambahan yang membebani CPU.
- Eksekusi instan dengan latency sub-milidetik (rata-rata 0.2 hingga 0.5 ms per pembacaan).
- Aman dari injeksi shell karena tidak memanggil perintah `exec()` atau `shell_exec()`.

---

## 2. Struktur Virtual Filesystem `/proc` yang Diparsing

Linux mengekspos struktur internal kernel ke userspace melalui filesystem in-memory `/proc`. File-file berikut dibaca secara dinamis:

### A. Jumlah Inti CPU (`/proc/cpuinfo`)
- Kernel mencatat daftar prosesor logika dalam `/proc/cpuinfo`.
- `ServerMonitorService` menghitung kemunculan string `"processor\t:"` untuk menentukan total core CPU server.

```php
$cpuinfo = @file_get_contents('/proc/cpuinfo');
if ($cpuinfo) {
    $counted = substr_count($cpuinfo, "processor\t:");
    if ($counted > 0) {
        $cores = $counted;
    }
}
```

### B. Beban Rata-rata CPU (*Load Average*)
- Memanfaatkan fungsi PHP bawaan `sys_getloadavg()` yang memetakan data dari `/proc/loadavg`.
- Menghasilkan tiga angka desimal: beban rata-rata 1 menit, 5 menit, dan 15 menit.

### C. Persentase Pemanfaatan CPU Instan (`/proc/stat`)
- Nilai load average mencerminkan rata-rata historis (eksponensial), bukan penggunaan CPU detik ini.
- Untuk mengukur penggunaan instan, service membaca baris pertama `/proc/stat` (`cpu  user nice system idle iowait irq softirq steal`).
- Nilai total tick dan idle tick disimpan sementara di cache Laravel (`cache('server_monitor_cpu_stat')`) selama 5 menit.
- Saat request berikutnya tiba, selisih (*delta*) dihitung:
  $$\text{Persentase Utilisasi} = \frac{\Delta \text{Total} - \Delta \text{Idle}}{\Delta \text{Total}} \times 100\%$$

### D. Statistik Memori RAM (`/proc/meminfo`)
- `/proc/meminfo` menyediakan gambaran rinci alokasi memori sistem.
- Regular expression digunakan untuk mengekstrak token:
  - `MemTotal`: Total RAM fisik terpasang (dalam Kilobyte).
  - `MemAvailable`: Estimasi memori yang siap dialokasikan untuk proses baru tanpa menyebabkan swapping.
  - `MemFree`: Memori yang benar-benar belum tersentuh (fallback jika `MemAvailable` tidak ada).
- Rumus kalkulasi memori terpakai:
  $$\text{RAM Used} = \text{MemTotal} - \text{MemAvailable}$$
  $$\text{RAM Percent} = \left(\frac{\text{RAM Used}}{\text{MemTotal}}\right) \times 100\%$$

### E. Durasi Aktif Server (*Uptime*) (`/proc/uptime`)
- File `/proc/uptime` berisi dua angka: total detik sejak booting dan waktu idle sistem.
- Nilai detik pertama dikonversi menjadi format ramah manusia: `X hari Y jam Z menit`.

### F. Kapasitas Penyimpanan Disk Storage
- Menggunakan fungsi native PHP `disk_total_space(base_path())` dan `disk_free_space(base_path())`.
- Mengukur partisi tempat aplikasi Laravel bersemayam (`/var/www/project_tkj_yuda2`).

---

## 3. Pengecekan Kesehatan Service LEMP

Selain metrik komputasi, `ServerMonitorService` melakukan audit konektivitas terhadap tiga komponen tumpukan server:

1. **Database MariaDB / MySQL**:
   - Menjalankan kueri ringan `DB::select('SELECT VERSION() as version')`.
   - Mengukur waktu latensi eksekusi kueri dalam satuan milidetik (`latencyMs`).
   - Melaporkan status `online` jika kueri berhasil atau `offline` dengan pesan error jika database terputus.

2. **PHP-FPM Runtime**:
   - Memeriksa Server API (`php_sapi_name()`).
   - Memverifikasi keberadaan UNIX socket di `/run/php/php8.4-fpm.sock` atau file PID aktif.

3. **Web Server Nginx**:
   - Membaca header `$_SERVER['SERVER_SOFTWARE']` untuk memvalidasi server yang menangani request.

---

## 4. Distribusi Data ke Frontend

Metrik telemetri didistribusikan melalui dua mekanisme:

1. **Server-Side Injection (`HomeController.php`)**:
   - Saat halaman utama dimuat, data telemetri pertama diinjeksikan langsung ke dalam view Blade (`$serverMetrics`).
   - Tidak ada kedipan (*flicker*) atau status kosong (*empty state*) pada tampilan awal.

2. **Client-Side Polling (`/api/metrics`)**:
   - File JavaScript frontend (`dark-portfolio.js`) melakukan AJAX fetch secara periodik ke endpoint `/api/metrics`.
   - Data diperbarui secara halus pada kartu telemetri dan badge status HUD tanpa memuat ulang halaman.

Untuk melihat bagaimana kode `ServerMonitorService.php` dirancang dan terhubung ke komponen lain, pelajari catatan [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]].
