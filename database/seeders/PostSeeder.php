<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Optimasi Kernel Linux & TCP BBR untuk High Throughput Web Server',
                'slug' => 'optimasi-kernel-linux-tcp-bbr-high-throughput',
                'excerpt' => 'Analisis mendalam tuning sysctl, buffer socket TCP, modifikasi queue discipline fq, dan implementasi algoritma Google BBR v3 pada host baremetal Debian 13.',
                'content' => '<h2>Latar Belakang Arsitektur</h2>
<p>Dalam pengelolaan server web berkinerja tinggi, bottleneck sering kali tidak terletak pada CPU atau memori, melainkan pada lapisan transport TCP dan penumpukan buffer (bufferbloat) di network interface card (NIC). Secara bawaan, kernel Linux menggunakan algoritma congestion control berbasis kehilangan paket (packet-loss based) seperti CUBIC. Pada jaringan modern dengan latensi bervariasi, CUBIC cenderung menurunkan throughput secara agresif saat terjadi fluktuasi sinyal kecil.</p>

<h2>Implementasi Google BBR (Bottleneck Bandwidth and RTT)</h2>
<p>BBR mengukur bandwidth maksimum yang dapat dilewatkan dan round-trip time (RTT) minimum secara independen. Dengan menggabungkan queue discipline Fair Queuing (fq), transmisi paket dialirkan secara teratur tanpa membanjiri antrian switch.</p>

<pre><code class="language-bash"># Verifikasi modul BBR pada Debian 13
sudo modprobe tcp_bbr
echo "tcp_bbr" | sudo tee -a /etc/modules-load.d/bbr.conf

# Parameter tuning /etc/sysctl.d/99-network-performance.conf
net.core.default_qdisc = fq
net.ipv4.tcp_congestion_control = bbr
net.core.somaxconn = 65535
net.ipv4.tcp_max_syn_backlog = 16384
net.ipv4.tcp_slow_start_after_idle = 0
net.ipv4.tcp_notsent_lowat = 16384
net.ipv4.tcp_rmem = 4096 87380 16777216
net.ipv4.tcp_wmem = 4096 65536 16777216</code></pre>

<h2>Hasil Pengujian Benchmarking</h2>
<p>Setelah menerapkan konfigurasi di atas pada server lab TKJ baremetal, throughput transfer HTTP/2 meningkat hingga 38% pada koneksi dengan RTT 25ms, dan waktu penyelesaian koneksi concurrent stabil di bawah 4.2ms.</p>',
                'category' => 'Linux Kernel',
                'tags' => 'Debian 13, BBR, TCP/IP, Sysctl, Networking',
                'reading_time' => 7,
                'is_published' => true,
                'published_at' => now()->subDays(3),
                'views_count' => 142,
            ],
            [
                'title' => 'Implementasi RPKI & Validasi ROA pada Autonomous System Border Edge',
                'slug' => 'implementasi-rpki-validasi-roa-as-border-edge',
                'excerpt' => 'Mencegah insiden BGP route hijacking dan prefix misorigination menggunakan kriptografi RPKI Route Origin Authorization pada router edge.',
                'content' => '<h2>Ancaman BGP Route Hijacking</h2>
<p>Border Gateway Protocol (BGP) pada awalnya dirancang atas dasar kepercayaan timbal balik (mutual trust). Siapa pun yang mengiklankan prefix IP dapat menarik trafik global tanpa verifikasi bawaan. Route Origin Authorization (ROA) melalui Resource Public Key Infrastructure (RPKI) memberikan validasi kriptografis bahwa hanya AS pemilik sah yang berhak mengumumkan rentang alamat IP tertentu.</p>

<h2>Arsitektur Validasi Routinator</h2>
<p>Dalam pengujian lab ini, kami mengintegrasikan Routinator sebagai RPKI validator lokal yang mengambil data trust anchors global dan menyalurkan tabel validasi ke router edge melalui protokol RTR (RPKI-to-Router).</p>

<pre><code class="language-bash"># Konfigurasi BGP Filter pada daemon routing
router bgp 64512
  rpki cache 127.0.0.1 3323 preference 1
  neighbor 198.51.100.1 remote-as 64500
  neighbor 198.51.100.1 route-map RPKI-INBOUND in

route-map RPKI-INBOUND permit 10
  match rpki valid
  set local-preference 200

route-map RPKI-INBOUND permit 20
  match rpki not-found
  set local-preference 100

route-map RPKI-INBOUND deny 30
  match rpki invalid</code></pre>

<h2>Kesimpulan Operasional</h2>
<p>Dengan menerapkan aturan ketat untuk menolak status RPKI Invalid, seluruh pengumuman rute palsu dapat dicegat sebelum masuk ke tabel routing global (FIB), melindungi integritas transit data dari pembajakan rute.</p>',
                'category' => 'Networking',
                'tags' => 'BGP, RPKI, Cisco, Router, Security',
                'reading_time' => 9,
                'is_published' => true,
                'published_at' => now()->subDays(6),
                'views_count' => 98,
            ],
            [
                'title' => 'Arsitektur LEMP Baremetal: Optimalisasi Event Loop Nginx & Soket UNIX',
                'slug' => 'arsitektur-lemp-baremetal-optimalisasi-nginx-soket-unix',
                'excerpt' => 'Meningkatkan efisiensi komunikasi inter-process antara Nginx dan PHP 8.4-FPM melalui UNIX domain socket dan parameter worker affinity.',
                'content' => '<h2>Mengapa Memilih UNIX Domain Socket?</h2>
<p>Komunikasi FastCGI pada stack LEMP yang berada dalam satu host fisik baremetal tidak memerlukan overhead layer TCP loopback (127.0.0.1:9000). UNIX domain sockets beroperasi langsung di memory buffer kernel VFS, menghilangkan enkapsulasi paket IP, checksum TCP, dan penanganan port ephemeral.</p>

<h2>Konfigurasi Pool FastCGI PHP 8.4</h2>
<p>Pengaturan pool PHP-FPM diatur dengan model static worker untuk beban kerja stabil, menghindari alokasi berulang proses baru saat lonjakan request tiba-tiba:</p>

<pre><code class="language-ini">[www]
listen = /run/php/php8.4-fpm.sock
listen.backlog = 8192
listen.owner = www-data
listen.group = www-data
listen.mode = 0660

pm = static
pm.max_children = 24
pm.max_requests = 1000
request_terminate_timeout = 60s</code></pre>

<h2>Optimalisasi Blok Server Nginx</h2>
<p>Nginx dikonfigurasi untuk memanfaatkan syscall epoll dan zero-copy sendfile untuk penyajian berkas statis dengan efisiensi maksimal:</p>

<pre><code class="language-nginx">events {
    worker_connections 8192;
    use epoll;
    multi_accept on;
}

http {
    sendfile on;
    tcp_nopush on;
    tcp_nodelay on;
    keepalive_timeout 65;
    types_hash_max_size 2048;
}</code></pre>',
                'category' => 'Sysadmin',
                'tags' => 'Nginx, PHP 8.4, LEMP, Baremetal, Debian',
                'reading_time' => 6,
                'is_published' => true,
                'published_at' => now()->subDays(10),
                'views_count' => 210,
            ],
        ];

        foreach ($posts as $postData) {
            Post::updateOrCreate(
                ['slug' => $postData['slug']],
                $postData
            );
        }
    }
}
