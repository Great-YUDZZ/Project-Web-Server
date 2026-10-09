---
title: "Rekayasa Animasi & Interaksi Visual Frontend (60 FPS Motion)"
category: "Frontend / Motion & Visuals"
tags:
  - animations
  - threejs
  - gsap
  - webgl
  - canvas
  - scroll-spy
  - interactions
updated_at: "2026-10-09"
---

# Rekayasa Animasi & Interaksi Visual Frontend (60 FPS Motion)

Dokumen ini membedah arsitektur animasi performa tinggi (60 hingga 120 FPS), interaksi WebGL 3D, serta floating HUD navbar dinamis yang diimplementasikan pada website portofolio dan lab TKJ tanpa menyebabkan jank atau memory leak.

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Kembali ke pusat navigasi dokumentasi.
- [[05_Frontend_Design_Monokrom]]: Penerapan token warna akromatik pada elemen kanvas visual.
- [[06_Tipografi_Geometris]]: Animasi teks *reveal* dan *blur-in* pada heading Outfit.
- [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]]: Alasan di balik pemilihan Three.js dan GSAP serta penghapusan total loading screen buatan.

---

## 1. Arsitektur Engine Visual Frontend

Untuk menghadirkan pengalaman pengguna modern tanpa mengorbankan waktu muat (*Time-to-Interactive* < 12ms), sistem animasi dibagi menjadi empat pilar independen:

```text
+-------------------------------------------------------------------------+
|                        THREE.JS STARFIELD ENGINE                        |
|   WebGL 2.0 Canvas Particle Shaders (#interactive-bg)                   |
|   - Parallax vertikal sinkron scroll                                    |
|   - Repulsi halus kursor mouse (spring return physics)                  |
|   - Fallback otomatis ke HTML5 Canvas 2D jika WebGL absen               |
+-------------------------------------------------------------------------+
                                    |
+-------------------------------------------------------------------------+
|                         GSAP 3 MOTION ORCHESTRATION                     |
|   - Hero Entrance Timeline (name-reveal & blur-in)                      |
|   - Infinite Vertical Flow Columns (Tech Stack Showcase)                |
|   - Footer Marquee Continuous Track                                     |
+-------------------------------------------------------------------------+
                                    |
+-------------------------------------------------------------------------+
|                     FLOATING HUD NAVBAR SCROLL-SPY                      |
|   - Pelacakan posisi scroll real-time via requestAnimationFrame         |
|   - Penanda aktif otomatis mengikuti section yang sedang diinspeksi     |
|   - Smooth scroll programmatic saat tautan menu diklik                  |
+-------------------------------------------------------------------------+
                                    |
+-------------------------------------------------------------------------+
|                     INTERACTIVE MODAL FOUR BOUNDARY                     |
|   - Skeleton State -> Success Spec State -> Error Boundary              |
+-------------------------------------------------------------------------+
```

---

## 2. Three.js 3D Starfield & Celestial Voyage (`interactive-bg.js`)

Latar belakang website menggunakan kanvas interaktif berbasis Three.js:
1. **Titik Bintang 3D Progresif**:
   - Dihasilkan menggunakan `THREE.BufferGeometry` dan `THREE.PointsMaterial`.
   - Menggunakan array tipe data berkinerja tinggi (`Float32Array`) sehingga alokasi memori sangat kecil (< 0.1ms per frame komputasi).
2. **Efek Fisika Kursor (*Mouse Repulsion & Elastic Spring*)**:
   - Bintang di sekitar kursor mouse akan menghindar secara halus saat kursor melintas, kemudian memantul kembali ke posisi semulanya secara elastis.
3. **Scroll-Linked Celestial Parallax**:
   - Posisi kamera sumbu Z dan rotasi bintang terhubung dengan nilai scroll jendela, menciptakan ilusi penjelajahan ruang angkasa saat pengunjung menjelajahi halaman dari atas ke bawah.
4. **Fallback 2D Otomatis**:
   - Jika peramban pengunjung tidak mendukung konteks WebGL (misalnya pada perangkat lama atau mode hemat daya ketat), sistem secara elegan mengalihkan rendering ke HTML5 Canvas 2D native tanpa memicu exception JavaScript.

---

## 3. Orkestrasi GSAP 3: Zero-Delay Entrance & Infinite Loop

1. **Penghapusan Loading Screen Buatan (Zero-Delay Start)**:
   - Sesuai prinsip *anti-slop* dan performa instan, loading screen artifisial yang menghalangi konten dihapus seluruhnya.
   - Fungsi `initLoadingScreen()` langsung memicu animasi hero masuk seketika browser siap render:
     - `.name-reveal`: Menggeser elemen dari $Y = 50px$ ke $0$ dengan kurva `power3.out`.
     - `.blur-in`: Menghilangkan filter blur dari $10px$ ke $0px$ secara bertingkat (*staggered delay* 0.12 detik).
2. **Infinite Vertical Flow Columns (`tech-flow-columns.blade.php`)**:
   - Memamerkan 9 tumpukan teknologi inti server dan web (PHP 8.4, Laravel 12, Vite, Tailwind CSS v4, Debian 13, GSAP 3, Nginx 1.22, MySQL 8.0, Three.js).
   - Kolom berputar secara vertikal tanpa henti menggunakan interpolasi matematika looping posisi kartu.
   - Dilengkapi `IntersectionObserver` dan `ResizeObserver` sehingga animasi otomatis berhenti (*pause*) saat berada di luar viewport untuk menghemat siklus CPU.

---

## 4. Mekanisme Dynamic HUD Navbar Scroll-Spy

Navigasi bar melayang (*floating HUD pill*) di bagian atas layar mengimplementasikan pelacakan posisi scroll otomatis:
- **Ticking Window Loop**: Memanfaatkan `window.requestAnimationFrame` pasif untuk mencegah fenomena *scroll-jank* atau *layout thrashing*.
- **Perhitungan Trigger Point**:
  $$\text{Titik Pemicu} = \text{scrollY} + (\text{windowHeight} \times 0.35)$$
- **Deteksi Section**: Sistem membandingkan posisi offset tiap elemen (`#hero`, `#about`, `#skills`, `#projects`, `#blog`, `#contact`) dan memindahkan status pill aktif (`bg-white/15`, `text-white`) secara otomatis ke menu yang relevan.
- **Deteksi Batas Akhir Halaman**: Jika pengunjung menggulir hingga ke ujung bawah dokumen, navbar secara otomatis menandai menu `#contact`.

Untuk melihat bedah baris kode JavaScript dan Blade komponen ini, buka catatan [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]].
