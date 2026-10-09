---
title: "Dokumentasi Folder: app/Services/"
category: "Direktori Proyek"
tags:
  - folder
  - services
  - service-layer
updated_at: "2026-10-09"
---

# Dokumentasi Folder: app/Services/

Path Proyek: `/var/www/project_tkj_yuda2/app/Services/`

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FILE_ServerMonitorService_php]]: Service telemetri Linux kernel.
- [[03_Telemetri_Linux_Kernel]]: Landasan teori virtual filesystem Linux.

---

## 1. Fungsi & Peran Folder

Folder ini menampung kelas-kelas Service Layer. Lapisan ini memisahkan logika komputasi khusus atau integrasi tingkat rendah (low-level OS / kernel) dari controller, sehingga controller tetap ramping (*skinny controller*) dan fokus pada penanganan alur HTTP.

---

## 2. Berkas di Dalam Folder

1. `ServerMonitorService.php` (331 baris):
   - Service khusus yang bertugas mengekstrak metrik perangkat keras dan status sistem operasi langsung dari virtual filesystem Linux `/proc` serta menguji latensi basis data.

---

## 3. Kemana Folder Ini Terhubung

- **Dipanggil Oleh**: `PublicController@index`, `PublicController@telemetry`, `Admin\DashboardController@index`, dan `Admin\DashboardController@serverMetrics`.
- **Berinteraksi Dengan**: Virtual filesystem Linux host (`/proc/cpuinfo`, `/proc/stat`, `/proc/meminfo`, `/proc/uptime`) dan soket PDO database.
