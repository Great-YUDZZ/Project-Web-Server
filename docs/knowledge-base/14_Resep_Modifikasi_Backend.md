---
title: "Resep Modifikasi Backend: Routes, Controllers, Models, & Services"
category: "Playbook / Backend Development"
tags:
  - backend-playbook
  - controllers
  - routes
  - models
  - services
  - line-by-line
updated_at: "2026-10-09"
---

# Resep Modifikasi Backend: Routes, Controllers, Models, & Services

Dokumen ini berisi panduan teknis operasional terperinci mengenai berkas apa yang harus dibuka, baris ke berapa yang harus dimodifikasi, dan kemana kode tersebut terhubung saat Anda ingin **menambahkan**, **mengubah**, atau **menghapus** komponen logika backend.

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[02_Backend_Laravel_Framework]]: Fondasi arsitektur Laravel 12.
- [[13_Peta_Folder_dan_Berkas_Proyek]]: Peta inventarisasi seluruh berkas proyek.
- [[15_Resep_Modifikasi_Frontend_dan_Views]]: Integrasi data backend ke template antarmuka Blade.
- [[16_Resep_Modifikasi_Database_dan_DevOps]]: Sinkronisasi model backend dengan migrasi tabel.

---

## 1. Modifikasi Routing (`routes/web.php`)

Berkas ini mengontrol seluruh pemetaan URL aplikasi.

### A. Menambahkan Rute Halaman Publik Baru
- **Buka Berkas**: `routes/web.php`
- **Lokasi Baris**: Baris 29 hingga 30 (setelah rute `/api/telemetry`).
- **Langkah Penambahan**:
  ```php
  Route::get('/nama-fitur', [PublicController::class, 'namaMethod'])->name('nama.fitur');
  ```
- **Keterhubungan**:
  - Pemicu: Permintaan URL browser pengunjung (`https://domain/nama-fitur`).
  - Terhubung ke: `app/Http/Controllers/PublicController.php` pada method `namaMethod()`.
  - View terkait: Menghasilkan `resources/views/nama-fitur.blade.php`.

### B. Menambahkan Rute Terproteksi Admin Baru
- **Buka Berkas**: `routes/web.php`
- **Lokasi Baris**: Baris 65 hingga 70 (di dalam grup `Route::middleware(['auth'])->prefix('admin')`).
- **Langkah Penambahan**:
  ```php
  Route::resource('nama-modul', AdminNamaModulController::class);
  ```
- **Keterhubungan**:
  - Terproteksi oleh middleware `auth` (hanya admin dengan sesi aktif yang dapat mengakses).
  - Terhubung ke: `app/Http/Controllers/Admin/NamaModulController.php`.

### C. Mengubah Toleransi Pembatasan Laju (Rate Limiting)
- **Buka Berkas**: `routes/web.php`
- **Lokasi Baris**:
  - Baris 27: Rute form kontak `middleware('throttle:10,1')` (maksimal 10 request per 1 menit).
  - Baris 28: Rute pesan chatbot `middleware('throttle:30,1')` (maksimal 30 request per 1 menit).
  - Baris 29: Rute API telemetri `middleware('throttle:60,1')` (maksimal 60 request per 1 menit).
- **Langkah Perubahan**: Ubah angka `10,1` menjadi angka yang diinginkan jika ingin memperketat atau melonggarkan batas request.

---

## 2. Modifikasi Controller Publik (`app/Http/Controllers/PublicController.php`)

Berkas ini mengelola penyiapan data untuk seluruh antarmuka publik.

### A. Mengirimkan Data Baru ke Halaman Beranda (`home.blade.php`)
- **Buka Berkas**: `app/Http/Controllers/PublicController.php`
- **Lokasi Baris**: Baris 19 hingga 50 (method `index(ServerMonitorService $monitor)`).
- **Langkah Penambahan**:
  1. Pada baris 45, tambahkan query data yang ingin Anda ambil:
     ```php
     $dataTambahan = NamaModel::latest()->take(5)->get();
     ```
  2. Pada baris 49, tambahkan variabel tersebut ke dalam fungsi `compact(...)`:
     ```php
     return view('home', compact('skills', 'heroProjects', 'featuredProjects', 'certificates', 'serverMetrics', 'projectsCount', 'dataTambahan'));
     ```
- **Keterhubungan**: Data `$dataTambahan` kini langsung dapat di-looping menggunakan `@foreach($dataTambahan as $item)` di dalam `resources/views/home.blade.php`.

### B. Menambahkan Validasi Bidang Baru pada Form Kontak
- **Buka Berkas**: `app/Http/Controllers/PublicController.php`
- **Lokasi Baris**: Baris 222 hingga 245 (method `contactSubmit(Request $request)`).
- **Langkah Penambahan**:
  1. Pada array validasi (baris 225-229), tambahkan aturan field baru:
     ```php
     'phone' => ['nullable', 'string', 'max:20'],
     ```
  2. Pada sanitasi XSS (baris 231-233), tambahkan pembersihan tag:
     ```php
     if (isset($validated['phone'])) {
         $validated['phone'] = strip_tags(trim($validated['phone']));
     }
     ```
- **Keterhubungan**: Nilai baru akan dimasukkan ke tabel `messages` melalui `Message::create($validated)`. Pastikan kolom `phone` telah ditambahkan di migrasi database dan properti `$fillable` pada `app/Models/Message.php`.

---

## 3. Modifikasi Otentikasi Admin (`app/Http/Controllers/AuthController.php`)

### A. Mengubah Jumlah Percobaan Maksimal Gagal Login
- **Buka Berkas**: `app/Http/Controllers/AuthController.php`
- **Lokasi Baris**: Baris 37 (`RateLimiter::tooManyAttempts($throttleKey, 5)`).
- **Langkah Perubahan**: Ubah angka `5` menjadi angka yang diinginkan (misalnya `3` untuk penguncian lebih ketat setelah 3 kali gagal).

### B. Menyesuaikan Lokasi Pengalihan Setelah Login Sukses
- **Buka Berkas**: `app/Http/Controllers/AuthController.php`
- **Lokasi Baris**: Baris 54 (`return redirect()->intended(route('admin.dashboard'))`).
- **Keterhubungan**: Terhubung ke route `admin.dashboard` yang didefinisikan di `routes/web.php` baris 47.

---

## 4. Modifikasi Model Eloquent (`app/Models/`)

Model mewakili tabel data di basis data.

### A. Menambahkan Kolom Baru pada Proyek (`app/Models/Project.php`)
- **Buka Berkas**: `app/Models/Project.php`
- **Lokasi Baris**: Baris 13 hingga 24 (array `$fillable`).
- **Langkah Penambahan**:
  - Masukkan nama kolom baru ke dalam array `$fillable`:
    ```php
    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'topology_image',
        'tools_used',
        'demo_link',
        'is_featured',
        'is_hero',
        'order',
        'client_name', // Kolom baru ditambahkan di sini
    ];
    ```
- **Perhatian Penting**: Jika nama kolom tidak didaftarkan di `$fillable`, operasi mass assignment seperti `Project::create($request->all())` akan mengabaikan kolom tersebut demi keamanan (*MassAssignmentException*).

### B. Menambahkan Scope Query Kustom pada Artikel Blog (`app/Models/Post.php`)
- **Buka Berkas**: `app/Models/Post.php`
- **Lokasi Baris**: Baris 38 hingga 45 (setelah method `scopePublished`).
- **Langkah Penambahan**:
  ```php
  public function scopePopular(Builder $query): Builder
  {
      return $query->where('views_count', '>=', 100)->orderByDesc('views_count');
  }
  ```
- **Keterhubungan**: Kini Anda dapat memanggil `Post::popular()->get()` langsung di controller mana pun.

---

## 5. Modifikasi Layanan Telemetri Linux (`app/Services/ServerMonitorService.php`)

Berkas ini membaca status perangkat keras dan sistem operasi server fisik.

### A. Menambahkan Pembacaan Metrik Kernel Baru (Contoh: Temperatur CPU)
- **Buka Berkas**: `app/Services/ServerMonitorService.php`
- **Langkah Penambahan**:
  1. Buat method pembaca baru pada baris 195 (setelah method `getUptimeMetrics`):
     ```php
     protected function getCpuTemperature(): array
     {
         $tempMilli = @file_get_contents('/sys/class/thermal/thermal_zone0/temp');
         $celsius = $tempMilli ? round(((int) $tempMilli) / 1000, 1) : null;
         return [
             'celsius' => $celsius,
             'status'  => $celsius > 75 ? 'warning' : 'normal',
         ];
     }
     ```
  2. Buka method `getSystemMetrics()` pada baris 25-38. Masukkan metrik baru tersebut:
     ```php
     public function getSystemMetrics(): array
     {
         $cpu = $this->getCpuMetrics();
         $ram = $this->getMemoryMetrics();
         $disk = $this->getDiskMetrics();
         $uptime = $this->getUptimeMetrics();
         $temperature = $this->getCpuTemperature(); // Tambahkan di sini

         return [
             'cpu' => $cpu,
             'ram' => $ram,
             'disk' => $disk,
             'uptime' => $uptime,
             'temp' => $temperature, // Disertakan ke payload
         ];
     }
     ```
- **Keterhubungan**: Nilai suhu baru akan otomatis tersedia di endpoint `/api/telemetry` dan objek `$serverMetrics` di `home.blade.php`.
