---
title: "Dokumentasi Berkas: app/Services/ServerMonitorService.php"
category: "Berkas Service"
tags:
  - file
  - service
  - linux-telemetry
  - procfs
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: app/Services/ServerMonitorService.php

Path Berkas: `/var/www/project_tkj_yuda2/app/Services/ServerMonitorService.php`
Jumlah Baris: 331 baris

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_app_Services]]: Folder service layer.
- [[03_Telemetri_Linux_Kernel]]: Penjelasan mendalam tentang procfs.
- [[FILE_PublicController_php]]: Controller yang mengonsumsi service ini.

---

## 1. Fungsi & Peran Berkas

Mengekstrak data performa server baremetal Linux Debian 13 secara real-time tanpa alat bantu pihak ketiga. Menyediakan data utilisasi CPU instan, beban rata-rata (*load average*), kapasitas RAM terpakai dan tersedia, ruang disk, durasi aktif server (*uptime*), serta status kesehatan koneksi tumpukan LEMP (Database MariaDB, PHP 8.4-FPM, Web Server Nginx).

---

## 2. Struktur & Rincian Method di Dalam Berkas

- **Baris 13-20 (`getAllMetrics(): array`)**:
  - Menggabungkan tiga kelompok data: `'system'`, `'services'`, dan `'host'`.
- **Baris 25-38 (`getSystemMetrics(): array`)**:
  - Mengagregasi metrik CPU, RAM, Disk, dan Uptime.
- **Baris 43-70 (`getCpuMetrics(): array`)**:
  - Menghitung core prosesor dari `/proc/cpuinfo` (baris 46-52).
  - Mengambil load average 1m, 5m, 15m via `sys_getloadavg()` (baris 54).
  - Menghitung utilisasi instan via `calculateInstantCpuUsage()` (baris 60).
- **Baris 75-101 (`calculateInstantCpuUsage($fallbackLoad, $cores): float`)**:
  - Menghitung delta tick CPU antara request saat ini dan request sebelumnya dari cache Laravel (`server_monitor_cpu_stat`) selama 5 menit.
- **Baris 106-141 (`getMemoryMetrics(): array`)**:
  - Regex pembaca `MemTotal` dan `MemAvailable` dari `/proc/meminfo`. Menghitung persentase memori terpakai.
- **Baris 147-162 (`getDiskMetrics(): array`)**:
  - Membaca `disk_total_space(base_path())` dan `disk_free_space(base_path())`.
- **Baris 167-193 (`getUptimeMetrics(): array`)**:
  - Membaca detik dari `/proc/uptime` dan memformatnya menjadi string ramah manusia `X hari Y jam Z menit`.
- **Baris 198-205 (`getServiceStatus(): array`)**:
  - Memanggil `checkDatabaseService()`, `checkPhpFpmService()`, dan `checkWebServerService()`.
- **Baris 210-230 (`checkDatabaseService(): array`)**:
  - Menjalankan `DB::select('SELECT VERSION() as version')` dan mengukur latensi kueri dalam milidetik (`latencyMs`).

---

## 3. Kemana Berkas Ini Terhubung

- **Dipanggil Oleh**:
  - `PublicController@index` (diinjeksikan langsung ke view `home.blade.php`)
  - `PublicController@telemetry` (mengembalikan payload JSON untuk endpoint `/api/telemetry`)
  - `DashboardController@index` (dashboard admin)
  - `DashboardController@serverMetrics` (endpoint polling admin)

---

## 4. Panduan Baris Kode Operasional

### A. Jika Ingin MENAMBAH Metrik Sensor Baru (Contoh: CPU Temperature)
1. Buat method baru di bawah baris 193:
   ```php
   protected function getCpuTempMetrics(): array
   {
       $raw = @file_get_contents('/sys/class/thermal/thermal_zone0/temp');
       return ['celsius' => $raw ? round(((int)$raw) / 1000, 1) : null];
   }
   ```
2. Panggil di dalam `getSystemMetrics()` baris 32:
   ```php
   'temp' => $this->getCpuTempMetrics(),
   ```

### B. Jika Ingin MENGUBAH Ambang Batas Status Beban CPU / RAM (Warning Status)
- Cari method `getUsageStatus($percent)` di bagian bawah file.
- Ubah rentang persentase (standar: < 60% optimal, 60-85% normal, > 85% high).
