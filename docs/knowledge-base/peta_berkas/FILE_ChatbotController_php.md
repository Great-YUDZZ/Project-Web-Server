---
title: "Dokumentasi Berkas: app/Http/Controllers/ChatbotController.php"
category: "Berkas Controller"
tags:
  - file
  - controller
  - ai-chatbot
  - yuna
  - line-by-line
updated_at: "2026-10-09"
---

# Dokumentasi Berkas: app/Http/Controllers/ChatbotController.php

Path Berkas: `/var/www/project_tkj_yuda2/app/Http/Controllers/ChatbotController.php`
Jumlah Baris: 554 baris

Modul ini terhubung erat dengan:
- [[00_Home_Index]]: Pusat indeks pustaka catatan Obsidian.
- [[FOLDER_app_Http_Controllers]]: Folder controller.
- [[FILE_routes_web_php]]: Rute `/ai` dan `/chatbot/message`.
- [[FILE_components_chatbot_widget_blade_php]]: Widget dialog mengambang di web.

---

## 1. Fungsi & Peran Berkas

Pengendali asisten kecerdasan buatan portofolio bernama **Yuna AI**. Berkas ini bertugas menyajikan antarmuka konsol AI interaktif (`/ai`), memvalidasi pesan pengguna, mencegah manipulasi prompt (*prompt injection*), memanggil API Google Gemini dengan rotasi multi-kunci otomatis, serta menyediakan mesin jawaban lokal (*local heuristic fallback*) jika API eksternal sedang offline atau habis kuota.

---

## 2. Struktur & Rincian Method di Dalam Berkas

- **Baris 17-24: `public function index()`**:
  - Mengambil data seluruh proyek, sertifikat, dan keterampilan teknis, lalu merender halaman konsol penuh `resources/views/ai/index.blade.php`.
- **Baris 30-90: `public function handle(Request $request): JsonResponse`**:
  - Baris 33-35: Validasi pesan teks (maksimal 1000 karakter).
  - Baris 39: Sanitasi teks via `$this->sanitizeInput($rawMessage)`.
  - Baris 49-55: Pertahanan prompt injection jailbreak via `$this->isPromptInjection()`.
  - Baris 58-85: Panggilan ke API Gemini dengan rotasi kunci otomatis dari berkas `.env` (`GEMINI_API_KEY`, `GEMINI_API_KEY_BACKUP`).
- **Baris 95-550: Mesin Pengetahuan Lokal (Local Knowledge Base)**:
  - Menyediakan respons cerdas deterministik tentang profil I Made Yuda Pramana, topologi jaringan MikroTik, Debian server, sertifikasi Cisco, dan konsep TKJ tanpa memerlukan internet.

---

## 3. Kemana Berkas Ini Terhubung

- **Dipanggil Oleh**: `routes/web.php` pada baris 26 (`GET /ai`) dan baris 28 (`POST /chatbot/message`).
- **Memanggil Model**: `App\Models\Project`, `App\Models\Certificate`, `App\Models\Skill`.
- **Frontend Consumer**: Komponen Blade `resources/views/components/chatbot-widget.blade.php` dan `resources/views/ai/index.blade.php`.

---

## 4. Panduan Baris Kode Operasional

### A. Jika Ingin MENAMBAH Kunci API Gemini Baru
- **Buka Berkas**: `.env` pada root proyek.
- **Modifikasi**: Pada baris `GEMINI_API_KEY=...`, Anda dapat memasukkan beberapa API key yang dipisahkan tanda koma. `ChatbotController.php` pada baris 58 secara otomatis memecah dan merotasi kunci tersebut jika salah satu terkena limit kuota.

### B. Jika Ingin MENAMBAH Jawaban Heuristik Lokal Baru
- **Buka Berkas**: `app/Http/Controllers/ChatbotController.php`
- **Lokasi Penambahan**: Cari method lokal pengenal pertanyaan (sekitar baris 200 ke atas) dan tambahkan pola regex kata kunci baru beserta respon teksnya.
