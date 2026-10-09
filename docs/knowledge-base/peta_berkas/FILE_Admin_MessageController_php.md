---
title: "Dokumentasi Berkas: app/Http/Controllers/Admin/MessageController.php"
category: "Berkas Controller Admin"
tags:
  - file
  - controller
  - messages-inbox
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: app/Http/Controllers/Admin/MessageController.php

Path Berkas: `/var/www/project_tkj_yuda2/app/Http/Controllers/Admin/MessageController.php`
Jumlah Baris: 65 baris

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_app_Http_Controllers_Admin]]: Folder controller admin.
- [[FILE_Model_Message_php]]: Model entitas pesan inbox.
- [[09_Modul_Kontak_Security]]: Modul keamanan form kontak publik.

---

## 1. Fungsi & Peran Berkas

Mengelola kotak masuk pesan (*inbox*) dari formulir kontak publik. Memungkinkan administrator membaca pesan, membedakan pesan baru dengan pesan lama melalui toggle status `is_read`, serta menghapus pesan yang tidak diinginkan atau teridentifikasi sebagai spam.

---

## 2. Struktur & Rincian Method di Dalam Berkas

- **`index()`**: Menampilkan daftar pesan masuk yang diurutkan dari yang terbaru (`latest()`) dengan penanda visual pesan belum dibaca.
- **`show(Message $message)`**: Menampilkan isi lengkap pesan dan secara otomatis menandai `is_read = true` saat pesan dibuka oleh admin.
- **`toggleRead(Message $message)`**: Mengubah status baca (Dibaca <-> Belum Dibaca) tanpa membuka pesan penuh.
- **`destroy(Message $message)`**: Menghapus baris pesan dari tabel `messages`.

---

## 3. Kemana Berkas Ini Terhubung

- **Dipanggil Oleh**: `routes/web.php` baris 66-69 (`admin.messages.*`).
- **Memanipulasi Model**: `App\Models\Message`.
- **Merender View**: `resources/views/admin/messages/index.blade.php` dan `show.blade.php`.
