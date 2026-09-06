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
        $projects = [
            [
                'title' => 'Perancangan Jaringan Dual-Core OSPF & VLAN Multi-Switch',
                'slug' => 'perancangan-jaringan-dual-core-ospf-vlan-multi-switch',
                'category' => 'Networking',
                'description' => "Proyek ini mendokumentasikan implementasi topologi jaringan kampus/sekolah skala menengah dengan redundansi tinggi menggunakan protokol routing dinamis OSPF Area 0 dan segmentasi VLAN antar departemen (Manajemen, Guru, Lab Komputer, dan Siswa).

### 1. Topologi & Segmentasi IP
- **Core Router 1 & 2:** MikroTik CCR / Cloud Hosted Router dengan VRRP untuk default gateway redundancy.
- **Distribution & Access Switch:** Cisco Catalyst 2960 dengan 802.1Q Trunking.
- **VLAN 10 (Admin):** 192.168.10.0/24
- **VLAN 20 (Guru):** 192.168.20.0/24
- **VLAN 30 (Lab TKJ):** 192.168.30.0/24
- **VLAN 40 (Hotspot Siswa):** 172.16.0.0/22

### 2. Langkah Konfigurasi Utama
1. Konfigurasi sub-interface dan VLAN ID pada switch trunk port.
2. Inisialisasi OSPF process ID 10 dan advertise subnet backbone 10.10.10.0/30.
3. Penerapan Inter-VLAN Routing pada switch layer 3 / router-on-a-stick.
4. Setting DHCP Server per VLAN dengan custom DNS resolver.

### 3. Hasil Pengujian & Troubleshooting
- Uji failover link backbone: Waktu konvergensi OSPF < 2 detik saat link utama diputus.
- Verifikasi tabel routing `show ip route ospf` dan pengetesan traceroute antar VLAN berhasil.",
                'topology_image' => '/images/topologies/lab-ospf-vlan.svg',
                'tools_used' => 'MikroTik RouterOS, Cisco Catalyst, GNS3, Wireshark, OSPF, VLAN 802.1Q',
                'demo_link' => 'https://github.com/example/tkj-ospf-vlan-lab',
                'is_featured' => true,
            ],
            [
                'title' => 'Implementasi Web Server LEMP dengan Reverse Proxy Nginx & PHP 8.4',
                'slug' => 'implementasi-web-server-lemp-reverse-proxy-nginx-php',
                'category' => 'Sysadmin',
                'description' => "Membangun infrastruktur server web mandiri pada sistem operasi Linux Debian 12 untuk melayani aplikasi web dinamis sekolah dengan arsitektur LEMP (Linux, Nginx, MariaDB, PHP-FPM).

### 1. Spesifikasi Server
- **OS:** Debian GNU/Linux 12 (Bookworm) 64-bit.
- **Web Engine:** Nginx 1.26 dengan modul FastCGI caching dan HTTP/2.
- **Backend Processor:** PHP 8.4 FPM via Unix Domain Socket (`/run/php/php8.4-fpm.sock`).
- **Database Server:** MariaDB Server 11.8 dengan buffer pool tuning.

### 2. Konfigurasi Nginx Server Block
- Pemisahan virtual host di `/etc/nginx/sites-available/` dan symlink ke `sites-enabled`.
- Konfigurasi security headers: `X-Frame-Options SAMEORIGIN`, `X-Content-Type-Options nosniff`, `X-XSS-Protection`.
- Blokir akses file dotfiles (`.env`, `.git`) dan proteksi rate limiting koneksi.

### 3. Pengujian Kinerja & Stress Testing
- Uji beban menggunakan `ab (ApacheBench)` dengan 500 concurrent requests menghasilkan waktu respons stabil di bawah 25ms tanpa downtime.",
                'topology_image' => '/images/topologies/lab-lemp-server.svg',
                'tools_used' => 'Debian 12, Nginx, PHP 8.4-FPM, MariaDB, Systemd, UFW Firewall',
                'demo_link' => 'http://portfolio.local',
                'is_featured' => true,
            ],
            [
                'title' => 'Firewall Filtering, Mangle, & Bandwidth Queue Management MikroTik',
                'slug' => 'firewall-filtering-mangle-queue-management-mikrotik',
                'category' => 'Security',
                'description' => "Proyek manajemen lalu lintas jaringan sekolah untuk memprioritaskan bandwidth kegiatan belajar mengajar (Ujian Berbasis Komputer & Lab TKJ) serta membatasi traffic hiburan/streaming.

### 1. Fitur yang Dikonfigurasi
- **Hierarchical Token Bucket (HTB) Queue Tree:** Alokasi CIR (Committed Information Rate) dan MIR (Maximum Information Rate).
- **Mangle Rules:** Pemisahan packet mark untuk traffic browsing, gaming, video streaming, dan port ujian UNBK/CBT.
- **Firewall Filter & Raw:** Pencegahan serangan DoS/DDoS SYN Flood, ICMP Flood, dan port scanning blocking.
- **Content Filter & Layer 7 Protocol:** Pemblokiran situs berbahaya dan aplikasi torrent.

### 2. Hasil Pengujian
- Latensi pada traffic ujian CBT tetap stabil di 1-2 ms saat kondisi link internet jenuh (congestion).
- Tidak ada packet loss pada traffic kritis berkat prioritas antrian `priority=1`.",
                'topology_image' => '/images/topologies/lab-firewall-qos.svg',
                'tools_used' => 'MikroTik RouterOS v7, WinBox, Queue Tree, HTB, PCQ, Wireshark',
                'demo_link' => null,
                'is_featured' => true,
            ],
            [
                'title' => 'Sistem Monitoring Server & Jaringan Berbasis Zabbix & SNMP',
                'slug' => 'sistem-monitoring-server-jaringan-zabbix-snmp',
                'category' => 'Sysadmin',
                'description' => "Penerapan sistem pemantauan terpusat (Centralized Network Monitoring System) untuk memonitor kesehatan puluhan switch, router, access point, dan server virtual secara real-time.

### 1. Arsitektur Monitoring
- **Zabbix Server & Web Frontend:** Berjalan pada Debian VM dengan database PostgreSQL + TimescaleDB.
- **Protokol:** SNMPv2c/SNMPv3 untuk perangkat jaringan (MikroTik, Cisco) dan Zabbix Agent 2 untuk Linux/Windows Server.
- **Notifikasi Insiden:** Integrasi bot webhook Telegram untuk alert otomatis jika CPU > 90%, link down, atau suhu perangkat berlebih.

### 2. Metrik Kunci yang Dipantau
- Utilisasi bandwidth interface gigabit secara grafis per port.
- Monitoring ketersediaan service (ICMP Ping, Port 80 HTTP, Port 3306 MySQL).
- Sisa kapasitas disk storage dan memory swap.",
                'topology_image' => '/images/topologies/lab-monitoring-zabbix.svg',
                'tools_used' => 'Zabbix 7.0, SNMPv3, Telegram Webhook, Grafana, PostgreSQL',
                'demo_link' => null,
                'is_featured' => false,
            ],
            [
                'title' => 'Infrastruktur Virtualisasi Private Cloud Berbasis Proxmox VE',
                'slug' => 'infrastruktur-virtualisasi-private-cloud-proxmox-ve',
                'category' => 'Virtualization',
                'description' => "Pembangunan private cloud server di laboratorium TKJ untuk melayani kebutuhan virtual machine praktikum siswa tanpa perlu menambah hardware fisik terpisah.

### 1. Fitur & Konfigurasi
- **Hypervisor:** Proxmox Virtual Environment (PVE) 8.x berbasis kernel Debian.
- **Storage:** Konfigurasi ZFS Pool Mirror untuk proteksi data dan snapshot otomatis.
- **Virtual Networking:** Linux Bridge (`vmbr0`, `vmbr1`) dengan integrasi VLAN Tagging langsung ke switch fisik.
- **Deployment:** Template otomatis Debian Cloud-Init dan container LXC ringan untuk lab praktikum web development.

### 2. Keuntungan Implementasi
- Penghematan konsumsi daya hingga 60% dibanding menyalakan PC lab individu.
- Kemampuan backup dan restore VM hanya dalam hitungan detik.",
                'topology_image' => '/images/topologies/lab-proxmox-cloud.svg',
                'tools_used' => 'Proxmox VE, KVM Hypervisor, LXC Containers, ZFS, Linux Bridge, Open vSwitch',
                'demo_link' => null,
                'is_featured' => false,
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['slug' => $project['slug']],
                $project
            );
        }
    }
}
