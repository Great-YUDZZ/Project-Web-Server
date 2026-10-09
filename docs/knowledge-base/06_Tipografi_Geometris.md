---
title: "Sistem Tipografi Geometris: Outfit, Inter, & JetBrains Mono"
category: "Frontend / Typography"
tags:
  - typography
  - fonts
  - outfit
  - inter
  - jetbrains-mono
  - design-system
updated_at: "2026-10-09"
---

# Sistem Tipografi Geometris: Outfit, Inter, & JetBrains Mono

Dokumen ini menjelaskan struktur tipografi tiga serangkai (*tri-font typography system*) yang diadopsi oleh web portofolio. Sistem ini memadukan font geometris modern, font teks berketerbacaan tinggi, dan font monospace rekayasa perangkat lunak.

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Kembali ke pusat navigasi dokumentasi.
- [[05_Frontend_Design_Monokrom]]: Penyelarasan tipografi dengan palet monokrom akromatik.
- [[07_Animasi_Interaksi_Visual]]: Pengaruh bobot font terhadap rendering animasi teks.
- [[08_Modul_Blog_Pribadi]]: Format keterbacaan artikel teknis panjang (*editorial reading*).
- [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]]: Alasan pemilihan rasio hierarki font.

---

## 1. Pemilihan Font & Peran Fungsional

Untuk menciptakan kesan laboratorium rekayasa komputer modern, tiga font khusus dipilih dengan peran yang tegas:

```text
+-------------------------------------------------------------------------+
|                              OUTFIT                                     |
|             Geometric Sans-Serif (Weight 500 - 900)                     |
|  Digunakan untuk: Headline Hero, Section Title, Angka Metrik Besar      |
+-------------------------------------------------------------------------+
                                    |
                                    v
+-------------------------------------------------------------------------+
|                               INTER                                     |
|            Humanist/Grotesque Sans-Serif (Weight 300 - 700)             |
|   Digunakan untuk: Paragraf Deskripsi, Narasi Blog, Navigasi Menu       |
+-------------------------------------------------------------------------+
                                    |
                                    v
+-------------------------------------------------------------------------+
|                          JETBRAINS MONO                                 |
|               Engineered Monospace (Weight 400 - 700)                   |
| Digunakan untuk: Alamat IP, Status Kernel, Cuplikan Kode, Bash Command  |
+-------------------------------------------------------------------------+
```

---

## 2. Karakteristik Teknis Setiap Font

### A. Outfit (Font Display Geometris)
- **Tipe**: Geometris sans-serif dengan proporsi lingkaran dan garis lurus tegas.
- **Karakter**: Modern, presisi, berkarakter industri teknologi tinggi.
- **Implementasi**:
  - Judul utama (`<h1>`, `<h2>`).
  - Huruf kapital judul modul.
  - Angka besar di dashboard telemetri (misal: beban CPU `0.15`, kapasitas RAM `16GB`).
- **Token Tailwind**: `font-display`, `font-geometric`.

### B. Inter (Font Konten Standar)
- **Tipe**: Neo-grotesque sans-serif yang dioptimalkan khusus untuk layar komputer beresolusi tinggi maupun rendah.
- **Karakter**: Keterbacaan (*legibility*) superior pada ukuran teks kecil, memiliki x-height yang tinggi sehingga nyaman dibaca dalam waktu lama.
- **Implementasi**:
  - Teks paragraf (`<p>`).
  - Label tombol (*button text*).
  - Teks artikel blog dan deskripsi proyek.
- **Token Tailwind**: `font-sans`, `font-body`.

### C. JetBrains Mono (Font Rekayasa & Terminal)
- **Tipe**: Monospaced font yang dirancang khusus oleh pengembang untuk pengembang.
- **Karakter**: Pembagian lebar karakter identik, pembedaan tegas antara angka nol `0` dan huruf `O`, serta simbol `l` dan `1`.
- **Implementasi**:
  - Blok kode program dan perintah terminal Bash.
  - Alamat IP, port jaringan, URL endpoint API.
  - Log status server dan badge metrik teknis.
- **Token Tailwind**: `font-mono`.

---

## 3. Skala Modular & Hierarki Ukuran Teks

Tipografi diatur mengikuti hierarki visual proporsional:

| Level Tipografi | Font Family | Bobot (*Font Weight*) | Ukuran Relatif | Penerapan Komponen |
|---|---|---|---|---|
| **Display Hero** | Outfit | 800 / 900 (Extra Bold) | `text-4xl` s/d `text-6xl` | Headline nama dan sambutan awal |
| **Section Title** | Outfit | 700 (Bold) | `text-2xl` s/d `text-3xl` | Judul bagian (Proyek, Blog, Lab) |
| **Card Heading** | Outfit | 600 (Semi-Bold) | `text-lg` s/d `text-xl` | Judul kartu proyek dan judul artikel |
| **Body Standard** | Inter | 400 (Regular) | `text-base` (16px) | Paragraf bacaan dan narasi |
| **Body Subtle** | Inter | 400 (Regular) | `text-sm` (14px) | Deskripsi sekunder dan keterangan |
| **Code / Telemetry** | JetBrains Mono | 500 (Medium) | `text-xs` s/d `text-sm` | Indikator status, IP address, uptime |

---

## 4. Optimasi Pemanggilan & Kinerja Web Vitals

1. **Google Fonts Preconnect**:
   - Header HTML memuat tag `<link rel="preconnect" href="https://fonts.googleapis.com">` dan `<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>` untuk mempercepat proses DNS pre-fetching.
2. **Display Swap (`display=swap`)**:
   - Mencegah fenomena FOIT (*Flash of Invisible Text*) saat font kustom sedang diunduh, sehingga browser langsung menampilkan font sistem sementara sebelum beralih ke font kustom tanpa memblokir perenderan halaman (*render-blocking*).

Untuk melihat contoh integrasi tipografi dalam kode HTML/Blade, rujuk catatan [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]].
