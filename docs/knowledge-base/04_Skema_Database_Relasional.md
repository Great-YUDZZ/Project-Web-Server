---
title: "Skema Database Relasional & Eloquent ORM"
category: "Database / Data Persistence"
tags:
  - database
  - mariadb
  - mysql
  - schema
  - migrations
  - eloquent
updated_at: "2026-10-09"
---

# Skema Database Relasional & Eloquent ORM

Dokumen ini memetakan arsitektur penyimpanan data, struktur tabel relasional, konvensi kolom, serta migrasi basis data pada sistem web portofolio dan lab TKJ. Basis data dikelola oleh engine MariaDB 11.8+ / MySQL 8.0 dengan storage engine InnoDB.

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Kembali ke pusat navigasi dokumentasi.
- [[01_Infrastruktur_LEMP]]: Konfigurasi engine MariaDB dan koneksi PDO UNIX socket.
- [[02_Backend_Laravel_Framework]]: Interaksi model Eloquent ORM terhadap tabel.
- [[08_Modul_Blog_Pribadi]]: Struktur tabel `posts` untuk artikel blog.
- [[09_Modul_Kontak_Security]]: Struktur tabel `messages` untuk log pengiriman form.
- [[10_Admin_Panel_Otentikasi]]: Struktur tabel `users` untuk kredensial admin.
- [[11_Panduan_Operasional_CLI]]: Perintah migrasi `artisan migrate` dan backup database.
- [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]]: Alasan pemilihan tipe data dan indeks.

---

## 1. Diagram Relasi Entitas Data (Entity Relationship)

```text
+---------------------+          +-----------------------+
|        users        |          |       settings        |
+---------------------+          +-----------------------+
| id (PK)             |          | id (PK)               |
| name                |          | key (UNIQUE)          |
| email (UNIQUE)      |          | value                 |
| password            |          | created_at            |
| remember_token      |          | updated_at            |
| timestamps          |          +-----------------------+
+---------------------+
           
+---------------------+          +-----------------------+
|      projects       |          |         posts         |
+---------------------+          +-----------------------+
| id (PK)             |          | id (PK)               |
| title               |          | title                 |
| slug (UNIQUE)       |          | slug (UNIQUE)         |
| description         |          | excerpt               |
| category            |          | content               |
| tags (JSON/string)  |          | category              |
| demo_url            |          | tags (JSON)           |
| github_url          |          | cover_image           |
| image_path          |          | reading_time          |
| is_featured         |          | is_published          |
| is_hero             |          | published_at          |
| order               |          | timestamps            |
| timestamps          |          +-----------------------+
+---------------------+

+---------------------+          +-----------------------+
|    certificates     |          |       messages        |
+---------------------+          +-----------------------+
| id (PK)             |          | id (PK)               |
| title               |          | name                  |
| issuer              |          | email                 |
| issue_date          |          | subject               |
| credential_id       |          | message               |
| credential_url      |          | is_read               |
| file_path           |          | ip_address            |
| is_featured         |          | user_agent            |
| order               |          | timestamps            |
| timestamps          |          +-----------------------+
+---------------------+
```

---

## 2. Rincian Tabel Domain Aplikasi

### A. Tabel `projects` (Portofolio Rekayasa & Lab)
Menyimpan data pameran proyek jaringan, server, dan aplikasi web yang telah dibangun.
- `id`: BigInteger Unsigned Auto Increment (Primary Key).
- `title`: Varchar(255) - Nama proyek teknis.
- `slug`: Varchar(255) Unique - Identifier URL ramah SEO.
- `description`: Text - Penjelasan komprehensif latar belakang dan solusi teknis.
- `category`: Varchar(100) - Kategori (misalnya: *Networking*, *SysAdmin*, *Web Development*).
- `tags`: Text/Json - Daftar tag teknologi (misalnya: *MikroTik*, *Linux*, *Docker*).
- `demo_url`: Varchar(255) Nullable - URL live demo jika tersedia.
- `github_url`: Varchar(255) Nullable - URL repositori source code.
- `image_path`: Varchar(255) Nullable - Path aset gambar banner proyek.
- `is_featured`: Boolean Default 0 - Penanda proyek unggulan di halaman depan.
- `is_hero`: Boolean Default 0 - Penanda proyek prioritas di sorotan hero.
- `order`: Integer Default 0 - Urutan tampilan kustom.
- `created_at` & `updated_at`: Timestamps.

### B. Tabel `posts` (Artikel Jurnal & Blog Teknis)
Menyimpan artikel panduan teknis, dokumentasi riset, dan tutorial rekayasa TKJ.
- `id`: BigInteger Unsigned Auto Increment (Primary Key).
- `title`: Varchar(255) - Judul artikel.
- `slug`: Varchar(255) Unique - Slug URL kanonikal artikel.
- `excerpt`: Text Nullable - Cuplikan ringkas untuk kartu pratinjau.
- `content`: LongText - Isi lengkap artikel (mendukung sintaks HTML/Markdown).
- `category`: Varchar(100) - Klasifikasi tema (misal: *Tutorial*, *Server*, *Networking*).
- `tags`: Json Nullable - Array tag terstruktur dalam format JSON.
- `cover_image`: Varchar(255) Nullable - Banner utama artikel.
- `reading_time`: Integer Default 1 - Perhitungan durasi estimasi baca dalam satuan menit.
- `is_published`: Boolean Default 1 - Status publikasi artikel (draft vs terbit).
- `published_at`: Timestamp Nullable - Waktu resmi artikel dipublikasikan.
- `created_at` & `updated_at`: Timestamps.

### C. Tabel `certificates` (Sertifikasi Kompetensi)
Menyimpan bukti pengakuan kompetensi formal (MikroTik, Cisco, BNSP, Dicoding, dll).
- `id`: BigInteger Unsigned Auto Increment (Primary Key).
- `title`: Varchar(255) - Nama sertifikat kompetensi.
- `issuer`: Varchar(255) - Lembaga/institusi penerbit sertifikat.
- `issue_date`: Date Nullable - Tanggal sertifikat diterbitkan.
- `credential_id`: Varchar(255) Nullable - Nomor lisensi/kredensial unik.
- `credential_url`: Varchar(255) Nullable - Tautan verifikasi digital resmi.
- `file_path`: Varchar(255) Nullable - File scan atau dokumen PDF bukti sertifikat.
- `is_featured`: Boolean Default 0 - Ditampilkan di kartu utama halaman beranda.
- `order`: Integer Default 0 - Prioritas urutan tampilan.
- `created_at` & `updated_at`: Timestamps.

### D. Tabel `messages` (Inbox Kontak Masuk & Audit Jejak)
Menyimpan pesan yang dikirimkan oleh pengunjung melalui formulir kontak.
- `id`: BigInteger Unsigned Auto Increment (Primary Key).
- `name`: Varchar(255) - Nama pengirim pesan.
- `email`: Varchar(255) - Alamat email pengirim yang tervalidasi.
- `subject`: Varchar(255) Nullable - Topik atau judul pesan.
- `message`: Text - Pesan teks lengkap pengunjung.
- `is_read`: Boolean Default 0 - Penanda status apakah admin telah membaca pesan.
- `ip_address`: Varchar(45) Nullable - Alamat IPv4 atau IPv6 pengirim untuk keamanan dan pencegahan spam.
- `user_agent`: Text Nullable - Informasi browser/client pengirim untuk audit jejak.
- `created_at` & `updated_at`: Timestamps.

### E. Tabel `users` (Otentikasi Pengguna & Administrator)
- `id`: BigInteger Unsigned Auto Increment (Primary Key).
- `name`: Varchar(255) - Nama akun administrator.
- `email`: Varchar(255) Unique - Email login.
- `password`: Varchar(255) - Hash kata sandi terenkripsi (Bcrypt / Argon2id).
- `remember_token`: Varchar(100) Nullable.
- `timestamps`: Waktu pembuatan dan pembaruan data.

---

## 3. Strategi Migrasi & Seeder Data

1. **Konsistensi Skema**:
   - Seluruh perubahan skema basis data didefinisikan secara deklaratif melalui migration files di `database/migrations/`.
   - Hal ini memastikan skema dapat direplikasi secara identik di lingkungan pengembangan lokal maupun server produksi.
2. **Seeder Bawaan (`DatabaseSeeder.php`)**:
   - Menyiapkan akun administrator mula-mula, artikel percontohan, proyek unggulan, dan daftar keterampilan jaringan awal saat sistem pertama kali dideploy.

Untuk membaca analisis rasionalitas mengapa skema database dirancang demikian, rujuk catatan [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]].
