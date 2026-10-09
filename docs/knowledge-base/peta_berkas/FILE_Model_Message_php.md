---
title: "Dokumentasi Berkas: app/Models/Message.php"
category: "Berkas Model"
tags:
  - file
  - model
  - message-model
  - contact-inbox
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: app/Models/Message.php

Path Berkas: `/var/www/project_tkj_yuda2/app/Models/Message.php`
Jumlah Baris: 29 baris

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_app_Models]]: Folder model data.
- [[FILE_PublicController_php]]: Handler penyimpan pesan masuk dari formulir kontak.
- [[FILE_Admin_MessageController_php]]: Controller pembaca pesan di panel admin.

---

## 1. Fungsi & Peran Berkas

Merepresentasikan log pesan masuk dari formulir kontak pengunjung publik pada tabel `messages`. Menyediakan proteksi mass-assignment untuk atribut pesan dan query scope `scopeUnread` untuk menyaring pesan yang belum dibaca admin.

---

## 2. Struktur & Rincian Kode di Dalam Berkas

- **Baris 12-18 (Array `$fillable`)**:
  - Kolom: `'sender_name'`, `'email'`, `'subject'`, `'message'`, `'is_read'`.
- **Baris 20-22 (Array `$casts`)**:
  - `'is_read' => 'boolean'`.
- **Baris 24-27 (`scopeUnread($query)`)**:
  - Filter `where('is_read', false)` untuk menghitung badge notifikasi di dashboard admin.

---

## 3. Panduan Baris Kode Operasional

### A. Jika Ingin MENAMBAH Kolom Penyimpanan Baru (Misal: `ip_address` atau `phone`)
- **Buka Baris**: Baris 12-18 (array `$fillable`).
- **Tambahkan**: `'phone',` atau `'ip_address',`.
- **Keterhubungan**: Nilai ini dapat langsung diisi saat `Message::create($validated)` dieksekusi di `PublicController.php` baris 235.
