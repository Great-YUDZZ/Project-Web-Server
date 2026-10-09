---
title: "Modul Kontak, Validasi Input, & Pertahanan Keamanan"
category: "Security / Forms"
tags:
  - security
  - csrf
  - xss
  - contact-form
  - validation
  - sanitization
updated_at: "2026-10-09"
---

# Modul Kontak, Validasi Input, & Pertahanan Keamanan

Dokumen ini menjelaskan alur pemrosesan data formulir kontak publik, mekanisme validasi input server-side, sanitasi pencegahan serangan Cross-Site Scripting (XSS), verifikasi token CSRF, dan mitigasi bot pada aplikasi web.

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Kembali ke pusat navigasi dokumentasi.
- [[02_Backend_Laravel_Framework]]: Controller handler `contactSubmit` di `PublicController`.
- [[04_Skema_Database_Relasional]]: Struktur tabel `messages` yang menyimpan inbox pesan.
- [[05_Frontend_Design_Monokrom]]: Tampilan visual form kontak dan feedback toast monokrom.
- [[10_Admin_Panel_Otentikasi]]: Manajemen inbox pesan masuk oleh admin.
- [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]]: Alasan pemilihan sanitasi `strip_tags` dan proteksi request forgery.

---

## 1. Alur Transmisi & Pemrosesan Pesan

```text
Pengunjung Mengisi Form Kontak
               |
               v
Pemeriksaan Token CSRF oleh Middleware Laravel
  [Gagal -> HTTP 419 Page Expired]
  [Sukses -> Lanjut ke Controller]
               |
               v
PublicController@contactSubmit
               |
               +--> 1. Validasi Skema Data (Data Type, Max Length, Email Format)
               +--> 2. Sanitasi String (strip_tags & trim untuk menangkal XSS)
               +--> 3. Penyimpanan ke Database (Message::create)
               +--> 4. Respons Balik (JSON untuk Fetch / Flash Session untuk HTTP POST)
               |
               v
Pengunjung Menerima Feedback Sukses Tanpa Kehilangan Posisi (#contact)
```

---

## 2. Lapisan Pertahanan Keamanan (Security Layers)

### A. Proteksi Cross-Site Request Forgery (CSRF)
Setiap form HTML dienkripsi dengan token CSRF unik yang dihasilkan oleh session manager Laravel melalui direktif `@csrf`:
- Token ini terikat erat dengan cookie sesi pengunjung yang terenkripsi (`XSRF-TOKEN`).
- Jika penyerang mencoba mengirimkan request palsu dari domain luar (*third-party domain*), server Nginx/Laravel akan menolak transaksi seketika dengan status HTTP `419 Page Expired`.

### B. Validasi Skema Input Ketat
Data yang dikirimkan wajib memenuhi aturan ketat di controller:
```php
$validated = $request->validate([
    'sender_name' => ['required', 'string', 'max:100'],
    'email'       => ['required', 'email', 'max:150'],
    'subject'     => ['required', 'string', 'max:150'],
    'message'     => ['required', 'string', 'max:2000'],
]);
```
- Menolak input berukuran raksasa yang berpotensi menyebabkan *Denial of Service* (DoS) pada memori database (dibatasi maksimal 2000 karakter).
- Memastikan alamat email memiliki sintaks internet yang valid sesuai standar RFC 5322.

### C. Sanitasi Konten Anti-XSS (Cross-Site Scripting)
Meskipun Blade secara default melakukan escaping HTML (`{{ $data }}`), data teks yang masuk tetap disanitasi sebelum disimpan ke basis data:
```php
$validated['sender_name'] = strip_tags(trim($validated['sender_name']));
$validated['subject']     = strip_tags(trim($validated['subject']));
$validated['message']     = strip_tags(trim($validated['message']));
```
Fungsi `strip_tags()` melenyapkan seluruh tag HTML, JavaScript berbahaya (`<script>`, `<iframe>`, `onload=`), dan tag eksekusi lainnya, memastikan teks yang tersimpan murni berupa karakter alfanumerik aman.

---

## 3. Penanganan Respons & Pengalaman Pengguna (UX Feedback)

1. **Dukungan Dual-Mode Response**:
   - Jika dikirim via AJAX JavaScript (`$request->wantsJson()`), server mengembalikan payload JSON status `200 OK`.
   - Jika dikirim via form browser standar, controller memicu redirect kembali:
     ```php
     return back()->with('success', 'Pesan Anda telah berhasil terkirim ke Admin TKJ. Terima kasih!')->withFragment('contact');
     ```
2. **Anchor Preservation (`withFragment('contact')`)**:
   - Penambahan `#contact` pada URL memastikan browser pengunjung tetap berada di bagian formulir kontak setelah halaman termuat ulang, tanpa melompat ke bagian atas hero.
3. **Pesan Konfirmasi Terlihat Jelas**:
   - Banner sukses monokrom berbingkai aksen muncul di atas form dengan pesan ucapan terima kasih yang jelas.

Untuk melihat implementasi lengkap baris kode proteksi kontak, buka catatan [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]].
