---
title: "Dokumentasi Berkas: app/Http/Controllers/AuthController.php"
category: "Berkas Controller"
tags:
  - file
  - controller
  - auth
  - login-security
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: app/Http/Controllers/AuthController.php

Path Berkas: `/var/www/project_tkj_yuda2/app/Http/Controllers/AuthController.php`
Jumlah Baris: 78 baris

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_app_Http_Controllers]]: Folder controller.
- [[FILE_routes_web_php]]: Rute autentikasi (`/login`, `/logout`).
- [[FILE_auth_login_blade_php]]: Template antarmuka form login.

---

## 1. Fungsi & Peran Berkas

Mengelola gerbang otentikasi login administrator. Berkas ini bertanggung jawab memverifikasi kecocokan kredensial (email dan kata sandi), mengunci akses penyerang otomatis melalui rate limiting IP, serta melakukan regenerasi sesi untuk mencegah pembajakan sesi (*session hijacking*).

---

## 2. Struktur & Rincian Method di Dalam Berkas

- **Baris 16-23: `public function showLogin()`**:
  - Memeriksa apakah admin sudah login (`Auth::check()`). Jika ya, langsung alihkan ke `admin.dashboard`. Jika belum, tampilkan view `resources/views/auth/login.blade.php`.
- **Baris 28-63: `public function login(Request $request)`**:
  - Baris 30-33: Validasi input `email` dan `password`.
  - Baris 35: Pembuatan kunci throttle unik: `$throttleKey = Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());`.
  - Baris 37-45: Pemeriksaan batas 5 kali percobaan gagal (`RateLimiter::tooManyAttempts($throttleKey, 5)`). Jika gagal, lemparkan `ValidationException` penguncian waktu.
  - Baris 50: Verifikasi kredensial via `Auth::attempt($credentials, $remember)`.
  - Baris 51-55: Jika sukses, bersihkan percobaan (`RateLimiter::clear`), regenerasi ID sesi (`$request->session()->regenerate()`), dan alihkan ke dashboard admin.
  - Baris 58: Jika gagal, catat percobaan gagal (`RateLimiter::hit($throttleKey)`).
- **Baris 68-76: `public function logout(Request $request)`**:
  - Menghancurkan sesi aktif (`Auth::logout()`, `$request->session()->invalidate()`, `$request->session()->regenerateToken()`), lalu mengalihkan ke halaman beranda publik.

---

## 3. Kemana Berkas Ini Terhubung

- **Dipanggil Oleh**: `routes/web.php` pada baris 36 (`GET /login`), baris 37 (`POST /login`), dan baris 38 (`POST /logout`).
- **Memanggil Framework**:
  - `Illuminate\Support\Facades\Auth`
  - `Illuminate\Support\Facades\RateLimiter`
  - Model `App\Models\User` (dikonfigurasi di `config/auth.php`)
- **Merender View**: `resources/views/auth/login.blade.php`.

---

## 4. Panduan Baris Kode Operasional

### A. Jika Ingin MENGUBAH Jumlah Maksimal Percobaan Login Gagal
- **Buka Baris**: Baris 37 (`if (RateLimiter::tooManyAttempts($throttleKey, 5))`).
- **Modifikasi**: Ubah angka `5` menjadi `3` untuk penguncian yang lebih protektif.

### B. Jika Ingin MENGUBAH Halaman Tujuan Setelah Logout
- **Buka Baris**: Baris 74 (`return redirect('/')->with('success', ...)`).
- **Modifikasi**: Ubah `'/'` menjadi `route('login')` jika ingin admin dialihkan kembali ke form login setelah keluar.
