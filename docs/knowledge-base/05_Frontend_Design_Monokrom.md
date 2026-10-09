---
title: "Sistem Desain Frontend Monokrom & Anti-Slop Guidelines"
category: "Frontend / Design System"
tags:
  - frontend
  - css
  - monochrome
  - tailwindcss
  - antislop
  - ui-ux
updated_at: "2026-10-09"
---

# Sistem Desain Frontend Monokrom & Anti-Slop Guidelines

Dokumen ini mendokumentasikan filosofi estetika visual, palet warna monokrom murni (hitam, abu-abu, putih), dan token Tailwind CSS v4 yang digunakan pada proyek portofolio dan lab TKJ. Desain ini mengadopsi standar **Anti-Slop** untuk menolak tren kecerdasan buatan generik dan mengedepankan presisi rekayasa jaringan.

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Kembali ke pusat navigasi dokumentasi.
- [[02_Backend_Laravel_Framework]]: Integrasi template Blade dengan class Tailwind CSS.
- [[06_Tipografi_Geometris]]: Sistem tipografi Outfit, Inter, dan JetBrains Mono.
- [[07_Animasi_Interaksi_Visual]]: Penerapan easing curve dan micro-interactions pada komponen.
- [[08_Modul_Blog_Pribadi]]: Desain layout artikel dan card monokrom.
- [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]]: Alasan di balik penolakan warna pelangi generik.

---

## 1. Filosofi Estetika: The Monochrome Engineering Terminal

Sebagian besar template web modern saat ini mengalami kejenuhan visual akibat tren "AI Slop" (seperti gradien ungu-neon cerah, blur latar belakang berlebihan tanpa hierarki, dan sudut membulat berlebihan tanpa proporsi).

Proyek ini mengambil pendekatan radikal: **Dark Engineering Terminal**:
1. **Palet Akromatik Terkontrol**: Seluruh antarmuka hanya tersusun dari rentang hitam legam (`#0a0a0a`), abu-abu arang (`#141414` hingga `#878787`), dan putih optik (`#f5f5f5` hingga `#ffffff`).
2. **Hierarki Kontras Tinggi**: Keterbacaan teks dan data teknis diutamakan melalui rasio kontras ketat yang melampaui standar WCAG AAA.
3. **Batas Tipis Presisi (Subtle Borders)**: Menggunakan garis pembatas 1 piksel (`#1f1f1f`) untuk mendefinisikan batas modul tanpa visual clutter.

---

## 2. Token Warna Tailwind CSS v4 (`resources/css/app.css`)

Dalam konfigurasi Tailwind CSS v4 (`@theme`), token warna monokrom didefinisikan sebagai berikut:

| Token Desain | Nilai Hex | Fungsi / Penggunaan dalam Antarmuka |
|---|---|---|
| `--color-bg-dark` | `#0a0a0a` | Warna latar belakang utama seluruh canvas halaman |
| `--color-surface-dark` | `#141414` | Latar belakang kartu kontainer, panel modul, dan card |
| `--color-surface-highlight` | `#1e1e1e` | Latar belakang saat elemen disentuh/diarahkan (*hover state*) |
| `--color-stroke-dark` | `#1f1f1f` | Warna border kartu, garis pemisah (*divider*), dan grid line |
| `--color-text-dark` | `#f5f5f5` | Warna tipografi utama (heading, judul, nilai penting) |
| `--color-muted-slate` | `#878787` | Warna tipografi sekunder (keterangan, tanggal, metadata, label) |
| `--accent-gradient` | `#FFFFFF -> #D4D4D4` | Gradasi aksen putih optik untuk teks penekanan khusus |

---

## 3. Kurva Easing & Waktu Transisi (Motion Physics)

Animasi tidak menggunakan nilai default browser (`ease-in-out`), melainkan kurva pegas fisika khusus (*spring physics*):

```css
:root {
    --ease-out: cubic-bezier(0.16, 1, 0.3, 1);
    --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
    --duration-fast: 150ms;
    --duration-normal: 300ms;
    --duration-slow: 500ms;
}
```

- **`--ease-out`**: Digunakan untuk transisi perpindahan posisi menu, pop-up, dan pergantian halaman agar terasa instan namun mulus saat mendarat.
- **`--ease-spring`**: Digunakan untuk micro-interaction tombol dan interaksi kartu agar memberikan efek pantulan taktil alami.

---

## 4. Empat Boundary States Wajib

Sesuai standar antarmuka berkualitas tinggi, setiap komponen dinamis mengimplementasikan empat status batas:

1. **Loading Skeleton**: Tampilan skeleton bergelombang monokrom (`#141414` berkedip ke `#1e1e1e`) saat data sedang dimuat dari server.
2. **Empty State**: Ilustrasi teknis minimalis dan teks penjelas jika koleksi data kosong (misal: "Belum ada artikel ditemukan").
3. **Error Boundary + Retry**: Penanganan saat koneksi terputus dengan tombol coba lagi (*retry button*) yang jelas.
4. **Success Toast / Feedback**: Konfirmasi interaksi (seperti pengiriman form kontak berhasil) dengan banner status monokrom berbingkai kontras.

Untuk melihat bagaimana aturan CSS diimplementasikan secara spesifik ke dalam komponen Blade, buka catatan [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]].
