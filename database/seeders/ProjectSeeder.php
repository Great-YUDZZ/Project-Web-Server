<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::updateOrCreate(
            ['slug' => 'it-toolbox'],
            [
                'title' => 'IT Toolbox: All-in-One Developer, Network & System Utilities Suite',
                'slug' => 'it-toolbox',
                'category' => 'Network & Tools',
                'description' => "Aplikasi desktop native, modern, ringan, dan cepat yang dirancang untuk kebutuhan harian teknisi IT, siswa TKJ, programmer, DevOps, dan network administrator. Dibangun menggunakan bahasa Go (Golang 1.25+) dan toolkit GUI modern Fyne v2.8 dengan arsitektur offline-first dan dukungan multiplatform penuh (Linux & Windows).\n\nModul & Fitur Utama Aplikasi:\n1. Alat & Kalkulator:\n   - Toolbox & Kalkulator: IP Subnet Calculator, CIDR Visualizer, Range Usable Host, Efisiensi Alokasi Host, Broadcast & Wildcard, serta preset cepat.\n   - Number & Data Converter: Konversi basis bilangan, format byte, dan kalkulasi unit data.\n   - Hash & Password: MD5, SHA-1, SHA-256, SHA-512 generator, JWT Inspector / Decoder, dan Random Password Generator yang aman.\n   - Format & Encode: Base64 encoder/decoder, URL encoder, JSON <-> YAML bidirectional converter, dan epoch timestamp converter.\n   - Konverter Berkas: PDF tools & merger, image converter & optimizer, OCR engine, dan ZIP archiver.\n2. Pengetahuan & Logbook:\n   - Katalog Referensi: Database port directory, kamus HTTP status codes, dan cheat sheet perintah esensial Linux CLI & DevOps.\n   - Catatan & Debugging: Penyimpanan catatan teknis harian berbasis SQLite lokal yang aman dan terenkripsi secara offline.\n   - Pelacak Tugas: Task & issue tracker untuk manajemen pemeliharaan sistem dan lab jaringan.\n\nDistribusi & Kemudahan Instalasi (Tersedia di GitHub Releases):\n- Linux: Paket installer resmi .deb (1-klik pasang otomatis dengan shortcut Desktop dan Application Launcher) serta skrip portable installer.\n- Windows: Paket portable .exe / .zip siap pakai dan installer setup wizard modern (.exe via Inno Setup).\n- Performa: Native binary tanpa runtime tambahan, footprint memori sangat rendah, start-up instan, dan mendukung mode gelap / terang.",
                'topology_image' => 'images/topologies/it-toolbox.png',
                'tools_used' => 'Golang, Fyne v2.8, SQLite, Subnet Calculator, CIDR, Cryptography & Hash, Linux .deb, Windows .exe',
                'demo_link' => 'https://github.com/Great-YUDZZ/it-toolbox',
                'is_featured' => true,
            ]
        );
    }
}
