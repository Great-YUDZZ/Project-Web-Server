@extends('layouts.app')

@section('title', 'Yuda Pratama - Portofolio Siswa TKJ | Network & Server Specialist')

@section('content')

<!-- Hero Section -->
<section class="relative pt-16 pb-20 overflow-hidden">
    <!-- Ambient Glow effects -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[350px] bg-cyan-500/10 blur-[130px] rounded-full pointer-events-none"></div>
    <div class="absolute top-1/3 right-10 w-[300px] h-[300px] bg-emerald-500/10 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Headline & Bio -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 font-mono-code text-xs">
                    <span class="h-2 w-2 rounded-full bg-cyan-400 animate-pulse"></span>
                    <span>TEKNIK KOMPUTER &amp; JARINGAN (TKJ)</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight">
                    Merancang Jaringan, <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-teal-300 to-emerald-400">
                        Mengelola Server Nyata.
                    </span>
                </h1>

                <p class="text-slate-400 text-base sm:text-lg max-w-2xl leading-relaxed mx-auto lg:mx-0">
                    Halo! Saya <span class="text-white font-semibold">Muhammad Yuda Pratama</span>, siswa kejuruan TKJ yang berdedikasi dalam perancangan topologi jaringan berkecepatan tinggi (MikroTik, Cisco), konfigurasi server mandiri berbasis Linux Debian/LEMP, dan virtualisasi enterprise Proxmox VE.
                </p>

                <!-- Actions -->
                <div class="flex flex-wrap gap-4 justify-center lg:justify-start font-mono-code text-sm pt-2">
                    <a href="{{ route('projects.index') }}" class="px-6 py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-black font-bold hover:shadow-lg hover:shadow-cyan-500/30 hover:scale-[1.02] transition-all flex items-center gap-2">
                        <span>Lihat Dokumentasi Lab</span>
                        <span>&rarr;</span>
                    </a>
                    <a href="#contact" class="px-6 py-3 rounded-xl bg-slate-900/80 border border-slate-700 hover:border-cyan-500/50 text-slate-200 hover:text-cyan-400 transition-all flex items-center gap-2">
                        <span>Hubungi Saya</span>
                    </a>
                </div>

                <!-- Quick Hardware / Specs Tags -->
                <div class="pt-4 border-t border-slate-800/80 flex flex-wrap items-center gap-4 justify-center lg:justify-start text-xs text-slate-400 font-mono-code">
                    <span class="flex items-center gap-1.5"><span class="text-cyan-400">#</span> MikroTik RouterOS</span>
                    <span class="flex items-center gap-1.5"><span class="text-emerald-400">#</span> Cisco IOS</span>
                    <span class="flex items-center gap-1.5"><span class="text-amber-400">#</span> Debian LEMP</span>
                    <span class="flex items-center gap-1.5"><span class="text-purple-400">#</span> Proxmox VE</span>
                </div>
            </div>

            <!-- Right Terminal Simulator HUD -->
            <div class="lg:col-span-5">
                <div class="rounded-2xl border border-cyan-500/30 bg-slate-950/90 backdrop-blur-xl shadow-2xl shadow-cyan-950/40 overflow-hidden font-mono-code text-xs">
                    <!-- Terminal Window Bar -->
                    <div class="bg-slate-900/90 px-4 py-3 border-b border-slate-800 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="h-3 w-3 rounded-full bg-rose-500 inline-block"></span>
                            <span class="h-3 w-3 rounded-full bg-amber-500 inline-block"></span>
                            <span class="h-3 w-3 rounded-full bg-emerald-500 inline-block"></span>
                        </div>
                        <div class="text-slate-400 text-[11px]">yuda@core-gateway: ~ (zsh)</div>
                        <div class="text-[10px] text-cyan-400">SSH: CONNECTED</div>
                    </div>

                    <!-- Terminal Output -->
                    <div class="p-5 space-y-3 text-slate-300">
                        <div>
                            <span class="text-emerald-400">yuda@core-gateway</span>:<span class="text-cyan-400">~</span>$ neofetch --tkj
                        </div>
                        <div class="border-l-2 border-cyan-500/40 pl-3 space-y-1 text-[11px] text-slate-400">
                            <div><span class="text-white font-semibold">OS:</span> Debian GNU/Linux 12 (bookworm) x86_64</div>
                            <div><span class="text-white font-semibold">Host:</span> Proxmox VE Hypervisor Lab Node 01</div>
                            <div><span class="text-white font-semibold">Kernel:</span> 6.8.4-pve // Nginx LEMP Native</div>
                            <div><span class="text-white font-semibold">Uptime:</span> 99.98% SLA (High Availability)</div>
                            <div><span class="text-white font-semibold">VLANs:</span> 10 (Admin), 20 (Guru), 30 (Lab), 40 (Public)</div>
                            <div><span class="text-white font-semibold">Routing:</span> OSPF Area 0 + BGP Autonomous System</div>
                        </div>

                        <div>
                            <span class="text-emerald-400">yuda@core-gateway</span>:<span class="text-cyan-400">~</span>$ ping -c 3 8.8.8.8
                        </div>
                        <div class="text-[11px] text-emerald-400/90 space-y-0.5">
                            <div>64 bytes from 8.8.8.8: icmp_seq=1 ttl=118 time=4.12 ms</div>
                            <div>64 bytes from 8.8.8.8: icmp_seq=2 ttl=118 time=3.95 ms</div>
                            <div>64 bytes from 8.8.8.8: icmp_seq=3 ttl=118 time=4.01 ms</div>
                            <div class="text-slate-500 text-[10px] pt-0.5">--- 8.8.8.8 ping stats: 0% packet loss, rtt min/avg/max = 3.95/4.02/4.12 ms ---</div>
                        </div>

                        <div class="pt-2 flex items-center gap-2 text-cyan-400">
                            <span class="text-emerald-400">yuda@core-gateway</span>:<span class="text-cyan-400">~</span>$ 
                            <span class="h-4 w-2 bg-cyan-400 animate-pulse"></span>
                        </div>
                    </div>

                    <!-- Terminal Status Footer -->
                    <div class="bg-slate-900/60 px-4 py-2 border-t border-slate-800/80 flex justify-between items-center text-[10px] text-slate-400">
                        <span class="text-emerald-400">● PACKET_LOSS: 0%</span>
                        <span>LATENCY: &lt;5ms</span>
                        <span class="text-cyan-400">PORT: 80 / 443 OPEN</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Metrics HUD Section -->
<section class="border-y border-slate-800/80 bg-slate-950/60 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="p-5 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-cyan-500/40 transition-colors">
                <div class="text-xs text-slate-400 font-mono-code mb-1">// DOKUMENTASI_LAB</div>
                <div class="text-3xl sm:text-4xl font-black text-white font-mono-code">{{ $stats['total_projects'] }}</div>
                <div class="text-xs text-cyan-400 mt-1">Proyek Jaringan &amp; Server</div>
            </div>

            <div class="p-5 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-emerald-500/40 transition-colors">
                <div class="text-xs text-slate-400 font-mono-code mb-1">// KELEMBAGAAN_SKILL</div>
                <div class="text-3xl sm:text-4xl font-black text-white font-mono-code">{{ $stats['total_skills'] }}</div>
                <div class="text-xs text-emerald-400 mt-1">Skill Teknis Terverifikasi</div>
            </div>

            <div class="p-5 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-amber-500/40 transition-colors">
                <div class="text-xs text-slate-400 font-mono-code mb-1">// ROUTING_SWITCHING</div>
                <div class="text-3xl sm:text-4xl font-black text-white font-mono-code">{{ $stats['network_labs'] }}</div>
                <div class="text-xs text-amber-400 mt-1">Lab Topologi Aktif</div>
            </div>

            <div class="p-5 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-purple-500/40 transition-colors">
                <div class="text-xs text-slate-400 font-mono-code mb-1">// SERVER_VIRTUAL</div>
                <div class="text-3xl sm:text-4xl font-black text-white font-mono-code">{{ $stats['server_labs'] }}</div>
                <div class="text-xs text-purple-400 mt-1">LEMP &amp; Cloud Nodes</div>
            </div>

        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-5">
                <div class="relative">
                    <div class="rounded-2xl border border-cyan-500/30 bg-gradient-to-b from-slate-900 to-slate-950 p-6 cyber-glow-cyan">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="h-16 w-16 rounded-xl bg-cyan-500/20 border border-cyan-500/50 flex items-center justify-center text-cyan-400 text-2xl font-bold font-mono-code">
                                TKJ
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Yuda Pratama</h3>
                                <p class="text-xs text-cyan-400 font-mono-code">Teknik Komputer dan Jaringan</p>
                                <p class="text-xs text-slate-400 mt-0.5">SMK Kejuruan Teknologi &amp; Rekayasa</p>
                            </div>
                        </div>

                        <div class="space-y-3 font-mono-code text-xs text-slate-300">
                            <div class="p-3 rounded-lg bg-slate-950/70 border border-slate-800 flex justify-between">
                                <span class="text-slate-400">STATUS:</span>
                                <span class="text-emerald-400 font-semibold">SIAP KERJA &amp; MAGANG</span>
                            </div>
                            <div class="p-3 rounded-lg bg-slate-950/70 border border-slate-800 flex justify-between">
                                <span class="text-slate-400">SPESIALISASI:</span>
                                <span class="text-cyan-400">Network &amp; Linux Sysadmin</span>
                            </div>
                            <div class="p-3 rounded-lg bg-slate-950/70 border border-slate-800 flex justify-between">
                                <span class="text-slate-400">SERVER STACK:</span>
                                <span class="text-purple-400">LEMP / Proxmox VE</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7 space-y-6">
                <div class="font-mono-code text-xs text-cyan-400">// PROFIL_KEJURUAN</div>
                <h2 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">
                    Dedikasi Penuh pada Keandalan Infrastruktur IT
                </h2>
                <p class="text-slate-300 leading-relaxed">
                    Sebagai siswa jurusan Teknik Komputer dan Jaringan, saya tidak hanya mempelajari teori protokol dan perangkat keras, melainkan secara konsisten melakukan praktikum implementasi di lingkungan nyata (*baremetal server* dan *lab simulator* seperti GNS3 &amp; Cisco Packet Tracer).
                </p>
                <p class="text-slate-400 leading-relaxed text-sm">
                    Keahlian saya mencakup perancangan arsitektur jaringan bertingkat (Access, Distribution, Core), implementasi redundansi OSPF, penanganan keamanan firewall MikroTik, serta instalasi dan optimasi server web Linux dengan arsitektur LEMP (Nginx, MariaDB, PHP-FPM) yang hemat sumber daya dan stabil.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 font-mono-code text-xs">
                    <div class="p-4 rounded-xl bg-slate-900/50 border border-slate-800">
                        <div class="text-cyan-400 font-bold mb-1">✔ Networking Mastery</div>
                        <p class="text-slate-400 text-[11px]">VLAN, Trunking 802.1Q, Routing OSPF/BGP, NAT, Hotspot &amp; Bandwidth Limiting.</p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-900/50 border border-slate-800">
                        <div class="text-emerald-400 font-bold mb-1">✔ System Administration</div>
                        <p class="text-slate-400 text-[11px]">Linux Debian Server, Nginx Reverse Proxy, DNS BIND9, DHCP Kea, SSH Hardening.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Skill Matrix Section -->
<section id="skills" class="py-20 bg-slate-950/70 border-t border-slate-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="font-mono-code text-xs text-cyan-400 mb-2">// TECHNICAL_CAPABILITIES</div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                Skill Matrix &amp; Penguasaan Alat
            </h2>
            <p class="text-slate-400 text-sm mt-3">
                Evaluasi tingkat penguasaan kompetensi kejuruan TKJ yang telah diuji melalui praktikum lab dan simulasi industri.
            </p>

            <!-- Category Filter Tabs -->
            <div class="flex flex-wrap justify-center gap-2 mt-8 font-mono-code text-xs" id="skill-filter-tabs">
                <button type="button" data-filter="all" class="skill-tab-btn active px-4 py-2 rounded-lg bg-cyan-500 text-black font-bold transition-all">
                    [Semua Skill]
                </button>
                <button type="button" data-filter="networking" class="skill-tab-btn px-4 py-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 hover:border-cyan-500/50 hover:text-cyan-400 transition-all">
                    Networking
                </button>
                <button type="button" data-filter="sysadmin" class="skill-tab-btn px-4 py-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 hover:border-emerald-500/50 hover:text-emerald-400 transition-all">
                    Sysadmin &amp; Server
                </button>
                <button type="button" data-filter="hardware" class="skill-tab-btn px-4 py-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 hover:border-amber-500/50 hover:text-amber-400 transition-all">
                    Hardware &amp; Kabel
                </button>
                <button type="button" data-filter="tools" class="skill-tab-btn px-4 py-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 hover:border-purple-500/50 hover:text-purple-400 transition-all">
                    Tools &amp; Simulator
                </button>
            </div>
        </div>

        <!-- Skills Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="skills-grid">
            @foreach($skills as $skill)
                <div class="skill-card p-5 rounded-xl bg-slate-900/60 border border-slate-800/80 hover:border-cyan-500/50 transition-all group" data-category="{{ $skill->category }}">
                    <div class="flex justify-between items-start mb-3">
                        <span class="text-xs px-2.5 py-1 rounded border font-mono-code uppercase {{ $skill->category_badge_color }}">
                            {{ $skill->category }}
                        </span>
                        <span class="font-mono-code text-sm font-bold text-cyan-400">{{ $skill->level }}%</span>
                    </div>

                    <h3 class="text-base font-semibold text-white group-hover:text-cyan-300 transition-colors mb-3">
                        {{ $skill->name }}
                    </h3>

                    <!-- Visual Progress Bar -->
                    <div class="w-full bg-slate-950 rounded-full h-2.5 overflow-hidden border border-slate-800">
                        <div class="h-2.5 rounded-full bg-gradient-to-r from-cyan-500 to-emerald-400 transition-all duration-700" style="width: {{ $skill->level }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- Featured Projects / Lab Showcase -->
<section id="labs" class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <div class="font-mono-code text-xs text-cyan-400 mb-2">// DOCUMENTED_TOPOLOGIES</div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                    Showcase Proyek &amp; Lab Unggulan
                </h2>
                <p class="text-slate-400 text-sm mt-2 max-w-xl">
                    Dokumentasi langkah konfigurasi teknis, topologi jaringan visual, dan hasil pengujian nyata.
                </p>
            </div>
            <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-2 font-mono-code text-sm text-cyan-400 hover:text-cyan-300 underline decoration-cyan-500/50">
                <span>Lihat Semua Lab ({{ $stats['total_projects'] }})</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($featuredProjects as $project)
                <div class="rounded-2xl border border-slate-800/80 bg-slate-900/50 overflow-hidden hover:border-cyan-500/50 hover:shadow-xl hover:shadow-cyan-950/30 transition-all flex flex-col group">
                    
                    <!-- Topology Graphic Header -->
                    <div class="relative h-56 bg-slate-950 overflow-hidden border-b border-slate-800 flex items-center justify-center p-2">
                        <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500">
                        
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 rounded bg-slate-900/90 border border-slate-700 text-cyan-400 font-mono-code text-xs font-semibold">
                                {{ $project->category }}
                            </span>
                        </div>

                        @if($project->is_featured)
                            <div class="absolute top-3 right-3">
                                <span class="px-2.5 py-1 rounded bg-amber-500/20 border border-amber-500/40 text-amber-300 font-mono-code text-[11px] font-bold">
                                    ★ UNGGULAN
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Project Content -->
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-white group-hover:text-cyan-300 transition-colors mb-3">
                                <a href="{{ route('projects.show', $project->slug) }}">
                                    {{ $project->title }}
                                </a>
                            </h3>

                            <p class="text-slate-400 text-sm line-clamp-3 mb-4 leading-relaxed">
                                {{ Str::limit(strip_tags($project->description), 150) }}
                            </p>

                            <!-- Tools Tags -->
                            <div class="flex flex-wrap gap-1.5 mb-6">
                                @foreach($project->tools_list as $tool)
                                    <span class="px-2 py-0.5 rounded bg-slate-950 border border-slate-800 text-[11px] text-slate-300 font-mono-code">
                                        {{ $tool }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between font-mono-code text-xs">
                            <span class="text-slate-500">{{ $project->created_at->format('d M Y') }}</span>
                            <a href="{{ route('projects.show', $project->slug) }}" class="inline-flex items-center gap-1 text-cyan-400 hover:text-cyan-300 font-semibold">
                                <span>Buka Detail Lab</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- Certifications & Milestones Section -->
<section id="certifications" class="py-20 bg-slate-950/60 border-t border-slate-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="font-mono-code text-xs text-cyan-400 mb-2">// VERIFIED_CREDENTIALS</div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                Sertifikasi &amp; Pelatihan Kejuruan
            </h2>
            <p class="text-slate-400 text-sm mt-2">
                Landasan standar kompetensi industri yang telah ditempuh selama masa pendidikan TKJ.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 font-mono-code text-xs">
            
            <div class="p-6 rounded-2xl bg-slate-900/40 border border-slate-800 hover:border-cyan-500/40 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-cyan-400 font-bold text-sm">MIKROTIK ACADEMY</span>
                    <span class="px-2 py-0.5 rounded bg-cyan-500/10 border border-cyan-500/30 text-cyan-400">MTCNA Level</span>
                </div>
                <h4 class="text-white font-bold text-base mb-2">MikroTik Certified Network Associate</h4>
                <p class="text-slate-400 text-xs leading-relaxed mb-4">
                    Kompetensi Routing (Static, Default, OSPF), Firewall Filter, NAT, Mangle, DHCP Server/Client, Hotspot Gateway, dan Wireless PtP/PtMP.
                </p>
                <div class="text-slate-500 text-[11px]">ID Sertifikasi: MT-TKJ-2025-0891</div>
            </div>

            <div class="p-6 rounded-2xl bg-slate-900/40 border border-slate-800 hover:border-emerald-500/40 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-emerald-400 font-bold text-sm">CISCO NETACAD</span>
                    <span class="px-2 py-0.5 rounded bg-emerald-500/10 border border-emerald-500/30 text-emerald-400">CCNA Routing</span>
                </div>
                <h4 class="text-white font-bold text-base mb-2">CCNA: Switching, Routing &amp; Wireless</h4>
                <p class="text-slate-400 text-xs leading-relaxed mb-4">
                    Penguasaan konfigurasi Switch Cisco Catalyst, VLAN, VTP, STP/RSTP, EtherChannel LACP, Inter-VLAN Routing, dan IPv6 Addressing.
                </p>
                <div class="text-slate-500 text-[11px]">Verifikasi: Cisco Networking Academy</div>
            </div>

            <div class="p-6 rounded-2xl bg-slate-900/40 border border-slate-800 hover:border-amber-500/40 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-amber-400 font-bold text-sm">BNSP INDONESIA</span>
                    <span class="px-2 py-0.5 rounded bg-amber-500/10 border border-amber-500/30 text-amber-400">LSP-P1 TKJ</span>
                </div>
                <h4 class="text-white font-bold text-base mb-2">Sertifikat Kompetensi Kejuruan TKJ</h4>
                <p class="text-slate-400 text-xs leading-relaxed mb-4">
                    Uji kompetensi resmi Badan Nasional Sertifikasi Profesi pada skema Teknisi Jaringan Komputer Madya dan Server Administrator.
                </p>
                <div class="text-slate-500 text-[11px]">No. Reg: BNSP-TKJ-7712-YUD</div>
            </div>

        </div>

    </div>
</section>

<!-- Contact Form Section -->
<section id="contact" class="py-20 border-t border-slate-800/80">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12">
            <div class="font-mono-code text-xs text-cyan-400 mb-2">// DIRECT_TRANSMISSION</div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                Hubungi Admin / Kirim Pesan
            </h2>
            <p class="text-slate-400 text-sm mt-2">
                Tertarik berdiskusi seputar lab jaringan, kolaborasi proyek, atau tawaran magang/kerja? Kirim pesan langsung ke sistem.
            </p>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-900/70 backdrop-blur-xl p-6 sm:p-10 shadow-2xl">
            <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="sender_name" class="block font-mono-code text-xs text-slate-300 mb-2">
                            Nama Pengirim <span class="text-rose-400">*</span>
                        </label>
                        <input type="text" name="sender_name" id="sender_name" value="{{ old('sender_name') }}" required
                               placeholder="Nama Lengkap / Instansi"
                               class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 text-sm transition-colors">
                    </div>

                    <div>
                        <label for="email" class="block font-mono-code text-xs text-slate-300 mb-2">
                            Alamat Email <span class="text-rose-400">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               placeholder="nama@domain.com"
                               class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 text-sm transition-colors">
                    </div>
                </div>

                <div>
                    <label for="subject" class="block font-mono-code text-xs text-slate-300 mb-2">
                        Subjek Pesan <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                           placeholder="Misal: Diskusi Lab OSPF / Peluang Magang IT Support"
                           class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 text-sm transition-colors">
                </div>

                <div>
                    <label for="message" class="block font-mono-code text-xs text-slate-300 mb-2">
                        Isi Pesan <span class="text-rose-400">*</span>
                    </label>
                    <textarea name="message" id="message" rows="5" required
                              placeholder="Tuliskan pesan detail Anda di sini..."
                              class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 text-sm transition-colors">{{ old('message') }}</textarea>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <div class="text-[11px] font-mono-code text-slate-500">
                        * Pesan disimpan langsung ke database MariaDB dan dapat diakses admin.
                    </div>

                    <button type="submit" class="px-8 py-3.5 rounded-xl bg-cyan-500 text-black font-bold font-mono-code text-sm hover:bg-cyan-400 hover:shadow-lg hover:shadow-cyan-500/25 transition-all flex items-center gap-2">
                        <span>TRANSMIT_MESSAGE</span>
                        <span>&rarr;</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
    // Client-side category filter for Skill Matrix
    const filterTabs = document.querySelectorAll('#skill-filter-tabs button');
    const skillCards = document.querySelectorAll('.skill-card');

    filterTabs.forEach(btn => {
        btn.addEventListener('click', () => {
            // Update active button styling
            filterTabs.forEach(b => {
                b.classList.remove('bg-cyan-500', 'text-black', 'font-bold');
                b.classList.add('bg-slate-900', 'text-slate-300');
            });
            btn.classList.remove('bg-slate-900', 'text-slate-300');
            btn.classList.add('bg-cyan-500', 'text-black', 'font-bold');

            const filter = btn.getAttribute('data-filter');

            skillCards.forEach(card => {
                const category = card.getAttribute('data-category');
                if (filter === 'all' || filter === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush
