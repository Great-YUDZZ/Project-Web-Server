<?php

namespace Database\Seeders;

use App\Models\Certificate;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Certificate::updateOrCreate(
            ['credential_id' => 'CISCO-NETACAD-NDIC-2026'],
            [
                'title' => 'Networking Devices and Initial Configuration',
                'issuer' => 'Cisco Networking Academy',
                'credential_id' => 'CISCO-NETACAD-NDIC-2026',
                'issued_date' => '11 September 2026',
                'duration_hours' => 'Student Level Credential',
                'verification_status' => 'Cisco NetAcad Verified & QR Validated',
                'description' => 'Kompetensi desain jaringan hierarkis, konversi bilangan desimal/biner/heksadesimal, operasional switching Ethernet, skema subnetting IPv4 untuk segmentasi jaringan, analisis protokol ARP, operasional layanan DNS dan DHCP, protokol transport layer (TCP/UDP) end-to-end, serta konfigurasi Cisco IOS untuk membangun jaringan komputer menggunakan perangkat Cisco.',
                'credential_url' => null,
                'file_path' => 'certificates/sertifikat-cisco-networking-devices-yuda.pdf',
                'order' => 1,
                'is_featured' => true,
            ]
        );

        Certificate::updateOrCreate(
            ['credential_id' => 'CISCO-NETACAD-AI-2026'],
            [
                'title' => 'Introduction to Modern AI',
                'issuer' => 'Cisco Networking Academy',
                'credential_id' => 'CISCO-NETACAD-AI-2026',
                'issued_date' => '10 September 2026',
                'duration_hours' => 'Student Level Credential',
                'verification_status' => 'Cisco NetAcad Verified & QR Validated',
                'description' => 'Kompetensi konsep dasar AI & Machine Learning, computer vision (klasifikasi objek, blur background, segmentasi gambar), machine translation, prinsip Large Language Models (LLM) & prompt engineering, use cases chatbot (generasi ide, peringkasan, grading), dialog interaktif mock interview, kolaborasi antar-chatbot, dan multimodal prompting dengan integrasi tools (web search & scraping).',
                'credential_url' => null,
                'file_path' => 'certificates/sertifikat-cisco-modern-ai-yuda.pdf',
                'order' => 2,
                'is_featured' => true,
            ]
        );

        Certificate::updateOrCreate(
            ['credential_id' => 'CISCO-NETACAD-NB-2026'],
            [
                'title' => 'Networking Basics',
                'issuer' => 'Cisco Networking Academy',
                'credential_id' => 'CISCO-NETACAD-NB-2026',
                'issued_date' => '9 September 2026',
                'duration_hours' => 'Student Level Credential',
                'verification_status' => 'Cisco NetAcad Verified & QR Validated',
                'description' => 'Kompetensi komunikasi jaringan, protokol & standardisasi Ethernet, pengalamatan IPv4/IPv6, switching & routing, connectivity troubleshooting, dan konfigurasi wireless router terintegrasi.',
                'credential_url' => null,
                'file_path' => 'certificates/sertifikat-cisco-networking-basics-yuda.pdf',
                'order' => 3,
                'is_featured' => true,
            ]
        );

        Certificate::updateOrCreate(
            ['credential_id' => '212131071110-18/DTA/BLSDM.Komdigi/2026'],
            [
                'title' => 'Fundamental of Optic Installation & Activation Technician',
                'issuer' => 'SMK Negeri 1 Denpasar • BLSDM Komdigi Yogyakarta',
                'credential_id' => '212131071110-18/DTA/BLSDM.Komdigi/2026',
                'issued_date' => '3 September 2026',
                'duration_hours' => '9 JP',
                'verification_status' => 'TTE Elektronik BSrE BSSN Valid',
                'description' => 'Penerapan Prosedur K3 (3 JP), Penyusunan Laporan Tertulis (3 JP), dan Instalasi Kabel Fiber Optik Ruangan/Gedung (3 JP).',
                'credential_url' => null,
                'file_path' => 'certificates/sertifikat-fiber-optic-yuda.pdf',
                'order' => 4,
                'is_featured' => true,
            ]
        );

        Certificate::updateOrCreate(
            ['credential_id' => '2299815850-27645/MS/BLSDM.Komdigi/2026'],
            [
                'title' => 'Pengantar Mindset Digital 1 : Pola Pikir Digital',
                'issuer' => 'Pusat Pengembangan Literasi Digital • Micro Skill',
                'credential_id' => '2299815850-27645/MS/BLSDM.Komdigi/2026',
                'issued_date' => '10 Agustus 2026',
                'duration_hours' => '2 JP',
                'verification_status' => 'QR Code Validated',
                'description' => 'Pengantar pola pikir digital adaptif, elemen kunci DMindset, dan strategi membangun kesiapan transformasi industri teknologi.',
                'credential_url' => null,
                'file_path' => 'certificates/sertifikat-mindset-digital-yuda.pdf',
                'order' => 5,
                'is_featured' => true,
            ]
        );
    }
}
