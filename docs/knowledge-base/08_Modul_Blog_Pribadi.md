---
title: "Modul Blog & Jurnal Rekayasa Teknis"
category: "Features / Blog"
tags:
  - blog
  - laravel
  - eloquent
  - markdown
  - reading-time
  - search-filter
updated_at: "2026-10-09"
---

# Modul Blog & Jurnal Rekayasa Teknis

Dokumen ini mendokumentasikan arsitektur modul blog pribadi pada web portofolio. Modul ini dirancang sebagai wadah publikasi artikel, jurnal riset, panduan konfigurasi jaringan, dan catatan administrasi sistem secara mandiri tanpa bergantung pada platform pihak ketiga seperti Medium atau Dev.to.

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Kembali ke pusat navigasi dokumentasi.
- [[02_Backend_Laravel_Framework]]: Routing publik `blog` dan `blogDetail` di `PublicController`.
- [[04_Skema_Database_Relasional]]: Struktur tabel `posts` pada MariaDB.
- [[05_Frontend_Design_Monokrom]]: Layout kartu artikel berdesain monokrom dan tipografi editorial.
- [[06_Tipografi_Geometris]]: Format pembacaan teks panjang (*typography prose*).
- [[10_Admin_Panel_Otentikasi]]: Antarmuka CRUD penulisan artikel di admin panel.
- [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]]: Bedah implementasi algoritma pencarian dan estimasi waktu baca.

---

## 1. Arsitektur Alur Kerja Blog

```text
Pengunjung Membuka /blog
          |
          v
PublicController@blog
          |
          +--> Query: Post::published()
          +--> Filter Pencarian (?q=keyword) pada judul, ringkasan, konten, tags
          +--> Filter Kategori (?category=nama_kategori)
          +--> Isolasi Artikel Unggulan Terkini (Featured Post Hero)
          +--> Paginasi 6 Artikel per Halaman (paginate(6)->withQueryString())
          |
          v
View: resources/views/blog/index.blade.php
          |
Pengunjung Mengklik Artikel (/blog/{slug})
          |
          v
PublicController@blogDetail
          |
          +--> Query: Post::published()->where('slug', $slug)->firstOrFail()
          +--> Auto-Increment Total Pembaca: $post->increment('views_count')
          +--> Query Artikel Terkait Berdasarkan Kesamaan Kategori
          |
          v
View: resources/views/blog/show.blade.php (Editorial Reader)
```

---

## 2. Fitur Fungsional Utama

### A. Fitur Pencarian Cerdas (*Full-Text Keyword Search*)
Pengunjung dapat mencari artikel berdasarkan kata kunci pada bilah pencarian:
- Kueri SQL mencari kecocokan pada 4 kolom sekaligus: `title`, `excerpt`, `content`, dan `tags`.
- State kueri pencarian tetap dipertahankan saat berpindah halaman paginasi melalui metode Laravel `withQueryString()`.

### B. Penyaring Kategori (*Category Filter Pills*)
Daftar kategori diambil secara dinamis dari database menggunakan `Post::published()->select('category')->distinct()->pluck('category')`. Pengunjung dapat memilih kategori spesifik atau melihat semua artikel.

### C. Hero Artikel Unggulan (*Featured Hero Post*)
Saat pengunjung membuka halaman utama blog tanpa filter pencarian aktif:
- Artikel terbaru secara otomatis disajikan sebagai kartu utama berukuran besar (*Hero Card*) di bagian paling atas.
- Sisa artikel lainnya ditampilkan dalam grid 2 kolom di bawahnya tanpa terjadinya duplikasi data berkat klausa `where('id', '!=', $featuredPost->id)`.

### D. Penghitungan Estimasi Waktu Baca (*Reading Time Algorithm*)
Waktu baca dihitung secara otomatis saat artikel disimpan oleh admin:
$$\text{Waktu Baca (Menit)} = \max\left(1, \left\lceil \frac{\text{Jumlah Kata}}{200} \right\rceil\right)$$
Standar 200 kata per menit digunakan sebagai rata-rata kecepatan membaca artikel teknis.

### E. Pelacak Jumlah Pembaca (*Views Counter*)
Setiap kali endpoint `GET /blog/{slug}` diakses dan artikel ditemukan, sistem secara atomik mengeksekusi `$post->increment('views_count')` untuk mencatat statistik ketertarikan pembaca tanpa membebani performa database.

---

## 3. Desain Antarmuka Monokrom Editorial

1. **Card Layout Minimalis**:
   - Kartu artikel dibungkus kontainer permukaan gelap (`#141414`) dengan garis border tipis (`#1f1f1f`).
   - Badge kategori menggunakan font JetBrains Mono dengan huruf kapital presisi.
2. **Artikel Terkait (*Related Posts*)**:
   - Di bagian bawah artikel, disajikan hingga 3 artikel terkait dengan kategori yang sama untuk meningkatkan retensi pembaca.
3. **Empty State & Not Found**:
   - Jika pencarian tidak membuahkan hasil, sistem menampilkan status kosong dengan tombol reset pencarian instan.

Untuk melihat baris kode controller dan view Blade artikel, buka catatan [[12_Anatomi_Kode_dan_Rasionalitas_Arsitektur]].
