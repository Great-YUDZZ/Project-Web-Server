---
title: "Dokumentasi Berkas: database/seeders/ (Data Awal Sistem)"
category: "Berkas Database"
tags:
  - file
  - seeders
  - sample-data
  - default-records
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: database/seeders/ (Data Awal Sistem)

Path Direktori: `/var/www/project_tkj_yuda2/database/seeders/`

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_database]]: Folder database.
- [[FILE_migrations]]: Skema tabel tujuan pengisian data.

---

## 1. Daftar Berkas Seeder & Fungsinya

1. `DatabaseSeeder.php` (35 baris):
   - Titik masuk sentral seeder. Menjalankan sub-seeder secara berurutan: `AdminUserSeeder`, `SkillSeeder`, `ProjectSeeder`, `CertificateSeeder`, dan `PostSeeder`.
2. `AdminUserSeeder.php`:
   - Membuat akun administrator mula-mula dengan password terenkripsi Hash::make().
3. `SkillSeeder.php`:
   - Mengisi 15+ data keahlian teknik jaringan (MikroTik RouterOS, Cisco IOS, Debian Server, Nginx, Docker, Wireshark, Fiber Optic, dll).
4. `ProjectSeeder.php`:
   - Mengisi data proyek laboratorium percontohan (Konfigurasi BGP Multihoming, VLAN & Inter-VLAN Routing, Server Baremetal, Monitoring Server).
5. `CertificateSeeder.php`:
   - Mengisi data lisensi resmi (Cisco Certified Support Technician, MikroTik MTCNA, Sertifikasi Kejuruan BNSP).
6. `PostSeeder.php`:
   - Mengisi artikel jurnal panduan konfigurasi jaringan awal.

---

## 2. Panduan Modifikasi & Perintah Eksekusi

- **Menjalankan Seluruh Seeder**:
  `php artisan db:seed`
- **Menjalankan Hanya Satu Seeder Tertentu**:
  `php artisan db:seed --class=ProjectSeeder`
- **Reset Database & Isi Ulang dari Nol (Fresh Seed)**:
  `php artisan migrate:fresh --seed` (Hati-hati: perintah ini menghapus seluruh tabel dan data lama).
