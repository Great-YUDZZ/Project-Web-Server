@extends('layouts.admin')

@section('page_title', 'Overview & Metrics')

@section('admin_content')
<div class="space-y-8">
    
    <!-- Top Stats (4-Column Spacious Grid) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        
        <!-- Total Lab -->
        <div class="bg-[#0f0f0f] rounded-2xl border border-white/10 p-5 sm:p-6 shadow-lg shadow-black/40 hover:border-white/25 transition-all flex flex-col justify-between group">
            <div>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-[11px] uppercase tracking-wider font-mono text-stone-400 font-medium">Proyek Lab</span>
                    <span class="bg-white/5 text-stone-300 border border-white/15 px-2.5 py-0.5 rounded-full font-mono text-[10px] font-bold">LABS</span>
                </div>
                <div class="text-3xl sm:text-4xl font-display font-bold text-white tracking-tight">{{ $totalProjects }}</div>
            </div>
            <div class="mt-5 pt-3.5 border-t border-white/10 flex items-center justify-between text-xs font-body">
                <span class="text-stone-400">Arsip Dokumentasi</span>
                <a href="{{ route('admin.projects.index') }}" class="text-stone-200 font-semibold hover:text-white flex items-center gap-1.5 group-hover:translate-x-0.5 transition-transform">
                    <span>Kelola</span>
                    <span class="font-mono">&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Total Skill -->
        <div class="bg-[#0f0f0f] rounded-2xl border border-white/10 p-5 sm:p-6 shadow-lg shadow-black/40 hover:border-white/25 transition-all flex flex-col justify-between group">
            <div>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-[11px] uppercase tracking-wider font-mono text-stone-400 font-medium">Skill Matrix</span>
                    <span class="bg-white/5 text-stone-300 border border-white/15 px-2.5 py-0.5 rounded-full font-mono text-[10px] font-bold">SKILLS</span>
                </div>
                <div class="text-3xl sm:text-4xl font-display font-bold text-white tracking-tight">{{ $totalSkills }}</div>
            </div>
            <div class="mt-5 pt-3.5 border-t border-white/10 flex items-center justify-between text-xs font-body">
                <span class="text-stone-400">Tingkat Kemahiran</span>
                <a href="{{ route('admin.skills.index') }}" class="text-stone-200 font-semibold hover:text-white flex items-center gap-1.5 group-hover:translate-x-0.5 transition-transform">
                    <span>Kelola</span>
                    <span class="font-mono">&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Sertifikat -->
        <div class="bg-[#0f0f0f] rounded-2xl border border-white/10 p-5 sm:p-6 shadow-lg shadow-black/40 hover:border-white/25 transition-all flex flex-col justify-between group">
            <div>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-[11px] uppercase tracking-wider font-mono text-stone-400 font-medium">Sertifikat Resmi</span>
                    <span class="bg-white/5 text-stone-300 border border-white/15 px-2.5 py-0.5 rounded-full font-mono text-[10px] font-bold">AWARDS</span>
                </div>
                <div class="text-3xl sm:text-4xl font-display font-bold text-white tracking-tight">{{ $totalCertificates }}</div>
            </div>
            <div class="mt-5 pt-3.5 border-t border-white/10 flex items-center justify-between text-xs font-body">
                <span class="text-stone-400">Kredensial BNSP &amp; IT</span>
                <a href="{{ route('admin.certificates.index') }}" class="text-stone-200 font-semibold hover:text-white flex items-center gap-1.5 group-hover:translate-x-0.5 transition-transform">
                    <span>Kelola</span>
                    <span class="font-mono">&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Pesan Masuk & Status Unread -->
        <div class="bg-[#0f0f0f] rounded-2xl border border-white/10 p-5 sm:p-6 shadow-lg shadow-black/40 hover:border-white/25 transition-all flex flex-col justify-between group">
            <div>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-[11px] uppercase tracking-wider font-mono text-stone-400 font-medium">Pesan Masuk</span>
                    @if($unreadMessages > 0)
                        <span class="px-2 py-0.5 rounded-full bg-emerald-950/80 text-emerald-300 border border-emerald-800/50 text-[10px] font-bold font-mono">{{ $unreadMessages }} BARU</span>
                    @else
                        <span class="bg-white/5 text-stone-400 border border-white/15 px-2.5 py-0.5 rounded-full font-mono text-[10px]">INBOX</span>
                    @endif
                </div>
                <div class="flex items-baseline gap-2">
                    <div class="text-3xl sm:text-4xl font-display font-bold text-white tracking-tight">{{ $totalMessages }}</div>
                    @if($unreadMessages > 0)
                        <span class="text-xs font-mono text-stone-400">({{ $unreadMessages }} unread)</span>
                    @endif
                </div>
            </div>
            <div class="mt-5 pt-3.5 border-t border-white/10 flex items-center justify-between text-xs font-body">
                <span class="text-stone-400">{{ $unreadMessages > 0 ? 'Perlu tindakan' : 'Kotak masuk' }}</span>
                <a href="{{ route('admin.messages.index') }}" class="text-stone-200 font-semibold hover:text-white flex items-center gap-1.5 group-hover:translate-x-0.5 transition-transform">
                    <span>Buka</span>
                    <span class="font-mono">&rarr;</span>
                </a>
            </div>
        </div>

    </div>

    <!-- Server Health (Engineering Telemetry Center) -->
    <div class="bg-[#0f0f0f] rounded-2xl border border-white/10 p-6 sm:p-7 shadow-lg shadow-black/40">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-white/10 pb-5 mb-6">
            <div>
                <div class="text-[11px] uppercase tracking-wider font-mono text-stone-400 mb-1 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]"></span>
                    <span>Live Telemetry &bull; Debian 13 Baremetal</span>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold font-body text-white tracking-tight">Status Mesin &amp; <span class="font-display font-semibold text-stone-300">Layanan LEMP</span></h2>
            </div>
            <div class="flex items-center gap-2.5 text-xs font-body">
                <span id="metric-last-updated" class="text-stone-400 text-[11px] font-mono mr-1">
                    Sync: {{ now()->format('H:i:s') }}
                </span>
                <button id="btn-toggle-live" class="flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/15 text-stone-200 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/20 cursor-pointer">
                    <span id="toggle-live-dot" class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]"></span>
                    <span id="toggle-live-text" class="font-semibold text-xs font-mono">Live</span>
                </button>
                <button id="btn-refresh-metrics" class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/15 text-stone-200 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/20 cursor-pointer" title="Perbarui metrik manual">
                    <svg id="refresh-icon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span class="font-semibold text-xs font-mono">Sync</span>
                </button>
            </div>
        </div>

        <!-- Master-Detail Windows Task Manager Container -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6">
            
            <!-- Sisi Kiri: 4 Kartu Metrik Bertumpuk (Master Stack - 4 Kolom di lg) -->
            <div class="lg:col-span-4 space-y-3">
                <!-- 1. CPU Item -->
                <button type="button" data-tm-tab="cpu" class="tm-tab-btn w-full text-left p-3.5 sm:p-4 rounded-xl border transition-all cursor-pointer bg-sky-950/20 border-sky-500/50 shadow-md shadow-sky-950/30">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center gap-1.5 text-xs font-mono font-bold uppercase tracking-wider text-sky-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-sky-400 shadow-[0_0_6px_rgba(56,189,248,0.8)]"></span>
                                <span>CPU</span>
                            </div>
                            <div class="text-[11px] font-mono text-stone-400 mt-0.5" id="tm-list-cpu-sub">
                                <span id="metric-cpu-cores">{{ $serverMetrics['system']['cpu']['cores'] }} Cores</span> &bull; <span id="metric-cpu-load">Load: {{ $serverMetrics['system']['cpu']['load_1m'] }}</span>
                            </div>
                        </div>
                        <span id="metric-cpu-percent" class="text-xl sm:text-2xl font-bold font-mono text-white tracking-tight">{{ $serverMetrics['system']['cpu']['percent'] }}%</span>
                    </div>
                    <div class="mt-2.5 h-7 w-full rounded bg-[#040404] border border-white/5 overflow-hidden">
                        <canvas id="mini-cpu-canvas" class="w-full h-full block"></canvas>
                    </div>
                </button>

                <!-- 2. Memory Item -->
                <button type="button" data-tm-tab="ram" class="tm-tab-btn w-full text-left p-3.5 sm:p-4 rounded-xl border border-white/10 bg-[#080808] hover:border-white/20 hover:bg-white/[0.02] transition-all cursor-pointer">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center gap-1.5 text-xs font-mono font-bold uppercase tracking-wider text-purple-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-400 shadow-[0_0_6px_rgba(192,132,252,0.8)]"></span>
                                <span>Memori RAM</span>
                            </div>
                            <div class="text-[11px] font-mono text-stone-400 mt-0.5 truncate" id="metric-ram-details">
                                {{ $serverMetrics['system']['ram']['used_formatted'] }} / {{ $serverMetrics['system']['ram']['total_formatted'] }}
                            </div>
                        </div>
                        <span id="metric-ram-percent" class="text-xl sm:text-2xl font-bold font-mono text-white tracking-tight">{{ $serverMetrics['system']['ram']['percent'] }}%</span>
                    </div>
                    <div class="mt-2.5 h-7 w-full rounded bg-[#040404] border border-white/5 overflow-hidden">
                        <canvas id="mini-ram-canvas" class="w-full h-full block"></canvas>
                    </div>
                </button>

                <!-- 3. Network Item -->
                <button type="button" data-tm-tab="net" class="tm-tab-btn w-full text-left p-3.5 sm:p-4 rounded-xl border border-white/10 bg-[#080808] hover:border-white/20 hover:bg-white/[0.02] transition-all cursor-pointer">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center gap-1.5 text-xs font-mono font-bold uppercase tracking-wider text-emerald-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]"></span>
                                <span>Network</span>
                            </div>
                            <div class="text-[11px] font-mono text-stone-400 mt-0.5 truncate" id="tm-list-net-sub">
                                &darr; <span id="metric-net-rx">{{ $serverMetrics['system']['network']['rx_formatted'] ?? '0 KB/s' }}</span> &bull; &uarr; <span id="metric-net-tx">{{ $serverMetrics['system']['network']['tx_formatted'] ?? '0 KB/s' }}</span>
                            </div>
                        </div>
                        <span id="metric-net-total" class="text-xl sm:text-2xl font-bold font-mono text-white tracking-tight">{{ $serverMetrics['system']['network']['total_formatted'] ?? '0 KB/s' }}</span>
                    </div>
                    <div class="mt-2.5 h-7 w-full rounded bg-[#040404] border border-white/5 overflow-hidden">
                        <canvas id="mini-net-canvas" class="w-full h-full block"></canvas>
                    </div>
                </button>

                <!-- 4. Disk Item -->
                <button type="button" data-tm-tab="disk" class="tm-tab-btn w-full text-left p-3.5 sm:p-4 rounded-xl border border-white/10 bg-[#080808] hover:border-white/20 hover:bg-white/[0.02] transition-all cursor-pointer">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center gap-1.5 text-xs font-mono font-bold uppercase tracking-wider text-amber-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 shadow-[0_0_6px_rgba(251,191,36,0.8)]"></span>
                                <span>Disk NVMe</span>
                            </div>
                            <div class="text-[11px] font-mono text-stone-400 mt-0.5 truncate" id="metric-disk-details">
                                {{ $serverMetrics['system']['disk']['used_formatted'] }} / {{ $serverMetrics['system']['disk']['total_formatted'] }}
                            </div>
                        </div>
                        <span id="metric-disk-percent" class="text-xl sm:text-2xl font-bold font-mono text-white tracking-tight">{{ $serverMetrics['system']['disk']['percent'] }}%</span>
                    </div>
                    <div class="mt-2.5 h-7 w-full rounded bg-[#040404] border border-white/5 overflow-hidden">
                        <canvas id="mini-disk-canvas" class="w-full h-full block"></canvas>
                    </div>
                </button>
            </div>

            <!-- Sisi Kanan: Detail Panel Grafik Besar (Detail View - 8 Kolom di lg) -->
            <div class="lg:col-span-8 bg-[#080808] rounded-2xl border border-white/10 p-5 sm:p-6 flex flex-col justify-between">
                <div>
                    <!-- Detail Header -->
                    <div class="flex items-start justify-between border-b border-white/5 pb-4 mb-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <span id="tm-detail-badge" class="w-2.5 h-2.5 rounded-full bg-sky-400 shadow-[0_0_8px_rgba(56,189,248,0.8)]"></span>
                                <h3 id="tm-detail-title" class="text-base sm:text-lg font-bold text-white font-body">CPU Utilization</h3>
                            </div>
                            <div id="tm-detail-subtitle" class="text-xs font-mono text-stone-400 mt-1">
                                Debian 13 Baremetal &bull; 60 Detik Terakhir
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <div id="tm-detail-big-value" class="text-2xl sm:text-3xl font-mono font-bold text-white tracking-tight">
                                    {{ $serverMetrics['system']['cpu']['percent'] }}%
                                </div>
                                <div id="tm-detail-scale-label" class="text-[10px] font-mono text-stone-400">Skala 0-100%</div>
                            </div>
                            <button type="button" id="btn-maximize-chart" class="p-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/15 text-stone-300 hover:text-white transition-colors cursor-pointer" title="Perbesar / Maximize Grafik">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Large Task Manager Canvas Chart -->
                    <div class="relative w-full h-56 sm:h-64 rounded-xl bg-[#030303] border border-white/10 overflow-hidden">
                        <canvas id="main-taskmanager-canvas" class="w-full h-full block"></canvas>
                    </div>
                </div>

                <!-- Technical Deep Stats (Grid Bawah) -->
                <div id="tm-detail-stats" class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-5 pt-4 border-t border-white/10">
                    <div class="p-2.5 rounded-lg bg-[#040404] border border-white/5">
                        <span class="block text-[10px] uppercase font-mono text-stone-500">Beban CPU</span>
                        <span id="tm-stat-1" class="block font-mono text-xs sm:text-sm font-bold text-white mt-0.5">{{ $serverMetrics['system']['cpu']['percent'] }}%</span>
                    </div>
                    <div class="p-2.5 rounded-lg bg-[#040404] border border-white/5">
                        <span class="block text-[10px] uppercase font-mono text-stone-500">Cores</span>
                        <span id="tm-stat-2" class="block font-mono text-xs sm:text-sm font-bold text-white mt-0.5">{{ $serverMetrics['system']['cpu']['cores'] }} Cores</span>
                    </div>
                    <div class="p-2.5 rounded-lg bg-[#040404] border border-white/5">
                        <span class="block text-[10px] uppercase font-mono text-stone-500">Load 1m / 5m</span>
                        <span id="tm-stat-3" class="block font-mono text-xs sm:text-sm font-bold text-white mt-0.5">{{ $serverMetrics['system']['cpu']['load_1m'] }} / {{ $serverMetrics['system']['cpu']['load_5m'] ?? 0 }}</span>
                    </div>
                    <div class="p-2.5 rounded-lg bg-[#040404] border border-white/5">
                        <span class="block text-[10px] uppercase font-mono text-stone-500">Host Uptime</span>
                        <span id="tm-stat-4" class="block font-mono text-xs sm:text-sm font-bold text-white mt-0.5">{{ $serverMetrics['system']['uptime']['formatted'] }}</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- 4 LEMP Stack Daemons -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6 pt-5 border-t border-white/10">
            <div class="p-3.5 rounded-xl bg-[#080808] border border-white/10 flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full {{ $serverMetrics['services']['database']['status'] === 'online' ? 'bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]' : 'bg-rose-500' }}"></span>
                        <span class="text-xs font-semibold text-white font-body">MariaDB</span>
                    </div>
                    <div class="text-[11px] text-stone-400 font-mono mt-1" id="metric-db-latency">{{ $serverMetrics['services']['database']['latency_ms'] ?? '-' }}ms latency</div>
                </div>
                <span class="text-[10px] font-mono text-stone-400 uppercase">Port 3306</span>
            </div>

            <div class="p-3.5 rounded-xl bg-[#080808] border border-white/10 flex items-center justify-between">
                <div class="min-w-0 pr-2">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full {{ $serverMetrics['services']['web_server']['status'] === 'online' ? 'bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]' : 'bg-rose-500' }}"></span>
                        <span class="text-xs font-semibold text-white font-body">Nginx</span>
                    </div>
                    <div class="text-[11px] text-stone-400 font-mono mt-1 truncate">{{ $serverMetrics['services']['web_server']['software'] }}</div>
                </div>
                <span class="text-[10px] font-mono text-stone-400 uppercase">Port 80/443</span>
            </div>

            <div class="p-3.5 rounded-xl bg-[#080808] border border-white/10 flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full {{ $serverMetrics['services']['php_fpm']['status'] === 'online' ? 'bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]' : 'bg-rose-500' }}"></span>
                        <span class="text-xs font-semibold text-white font-body">PHP 8.4-FPM</span>
                    </div>
                    <div class="text-[11px] text-stone-400 font-mono mt-1">Unix Socket</div>
                </div>
                <span class="text-[10px] font-mono text-stone-400 uppercase">FastCGI</span>
            </div>

            <div class="p-3.5 rounded-xl bg-[#080808] border border-white/10 flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]"></span>
                        <span class="text-xs font-semibold text-white font-body">{{ $serverMetrics['host']['os'] }}</span>
                    </div>
                    <div class="text-[11px] text-stone-400 font-mono mt-1" id="metric-host-uptime">Up {{ $serverMetrics['system']['uptime']['formatted'] }}</div>
                </div>
                <span class="text-[10px] font-mono text-stone-400 uppercase">Host</span>
            </div>
        </div>

    </div>

    <!-- Main Grid: Recent Projects & Recent Messages -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">
        
        <!-- Recent Projects (7 Cols) -->
        <div class="lg:col-span-7 bg-[#0f0f0f] rounded-2xl border border-white/10 p-6 shadow-lg shadow-black/40">
            <div class="flex justify-between items-center border-b border-white/10 pb-4 mb-5">
                <div class="flex items-center gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-white shadow-[0_0_6px_rgba(255,255,255,0.8)]"></span>
                    <h3 class="text-base font-bold font-body text-white tracking-tight">Dokumentasi <span class="font-display font-semibold text-stone-300">Lab Terbaru</span></h3>
                </div>
                <a href="{{ route('admin.projects.index') }}" class="text-xs font-body text-stone-300 hover:text-white hover:underline font-semibold flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <span class="font-mono">&rarr;</span>
                </a>
            </div>

            <div class="space-y-3">
                @forelse($recentProjects as $p)
                    <div class="flex items-center justify-between p-3.5 rounded-xl border border-white/10 bg-[#080808]/70 hover:border-white/25 hover:bg-white/[0.02] transition-all group">
                        <div class="min-w-0 pr-4">
                            <div class="font-semibold text-white text-sm mb-1 group-hover:text-stone-200 transition-colors truncate font-body">{{ $p->title }}</div>
                            <div class="text-xs text-stone-400 font-mono flex items-center gap-2">
                                <span class="bg-white/10 text-stone-200 border border-white/15 text-[9px] px-2 py-0.5 rounded-full font-mono">{{ $p->category }}</span>
                                <span>{{ $p->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ route('admin.projects.edit', $p->id) }}" class="text-xs font-body font-medium text-stone-300 hover:text-black px-3 py-1.5 rounded-lg bg-white/5 hover:bg-white border border-white/15 transition-all">Edit</a>
                            <a href="{{ route('projects.show', $p->slug) }}" target="_blank" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white hover:text-black flex items-center justify-center text-stone-300 transition-all border border-white/15" title="Buka di web publik">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-stone-500 text-xs font-body">Belum ada proyek terdokumentasi.</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Messages (5 Cols) -->
        <div class="lg:col-span-5 bg-[#0f0f0f] rounded-2xl border border-white/10 p-6 shadow-lg shadow-black/40">
            <div class="flex justify-between items-center border-b border-white/10 pb-4 mb-5">
                <div class="flex items-center gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-white shadow-[0_0_6px_rgba(255,255,255,0.8)]"></span>
                    <h3 class="text-base font-bold font-body text-white tracking-tight">Pesan Masuk <span class="font-display font-semibold text-stone-300">Terbaru</span></h3>
                </div>
                <a href="{{ route('admin.messages.index') }}" class="text-xs font-body text-stone-300 hover:text-white hover:underline font-semibold flex items-center gap-1">
                    <span>Inbox</span>
                    <span class="font-mono">&rarr;</span>
                </a>
            </div>

            <div class="space-y-3">
                @forelse($recentMessages as $msg)
                    <a href="{{ route('admin.messages.show', $msg->id) }}" class="block p-3.5 rounded-xl border {{ $msg->is_read ? 'border-white/10 bg-[#080808]/70 hover:border-white/20' : 'border-white/25 bg-white/[0.03] hover:border-white/40' }} transition-all">
                        <div class="flex justify-between items-start mb-1">
                            <span class="font-semibold text-sm text-white truncate max-w-[180px] font-body">{{ $msg->sender_name }}</span>
                            <span class="text-[10px] text-stone-400 font-mono">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="text-xs text-stone-300 truncate font-body">{{ $msg->subject }}</div>
                        @if(!$msg->is_read)
                            <div class="mt-2 inline-block px-2 py-0.5 rounded-full text-[9px] uppercase font-bold text-black bg-white shadow-xs font-mono">Belum Dibaca</div>
                        @endif
                    </a>
                @empty
                    <div class="py-8 text-center text-stone-500 text-xs font-body">Inbox kosong.</div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Modal Maximize Telemetry Inspection -->
    <div id="modal-telemetry-maximize" class="fixed inset-0 z-50 bg-black/90 backdrop-blur-md hidden flex items-center justify-center p-4 sm:p-8">
        <div class="w-full max-w-5xl bg-[#0a0a0a] border border-white/15 rounded-2xl p-5 sm:p-7 shadow-2xl flex flex-col justify-between max-h-[92vh]">
            <div class="flex items-center justify-between border-b border-white/10 pb-4 mb-4">
                <div class="flex items-center gap-3">
                    <span id="modal-tm-badge" class="w-2.5 h-2.5 rounded-full bg-sky-400 shadow-[0_0_10px_rgba(56,189,248,0.8)]"></span>
                    <div>
                        <h3 id="modal-tm-title" class="text-base sm:text-lg font-bold font-body text-white">CPU Utilization - Inspeksi Resolusi Tinggi</h3>
                        <div id="modal-tm-subtitle" class="text-xs font-mono text-stone-400">Live 60 Detik Telemetri Baremetal Linux</div>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span id="modal-tm-value" class="text-2xl sm:text-3xl font-mono font-bold text-white tracking-tight">0%</span>
                    <button type="button" id="btn-close-maximize" class="p-2 rounded-xl bg-white/5 hover:bg-white/15 text-stone-300 hover:text-white transition-colors cursor-pointer" title="Tutup Modal (ESC)">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            <div class="relative w-full h-80 sm:h-96 rounded-xl bg-[#030303] border border-white/10 overflow-hidden my-2">
                <canvas id="modal-taskmanager-canvas" class="w-full h-full block"></canvas>
            </div>
            <div class="flex items-center justify-between text-xs font-mono text-stone-400 pt-3 border-t border-white/10">
                <span>Tekan ESC atau tombol silang untuk kembali</span>
                <span id="modal-tm-status" class="text-emerald-400 flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Live Streaming 3s</span>
            </div>
        </div>
    </div>

</div>
@endsection

@push('admin_scripts')
<script>
class TaskManagerCanvasChart {
    constructor(canvasId, options = {}) {
        this.canvas = document.getElementById(canvasId);
        if (!this.canvas) return;
        this.ctx = this.canvas.getContext('2d');
        this.maxPoints = options.maxPoints || 30;
        this.strokeColor = options.strokeColor || '#38bdf8';
        this.fillColor = options.fillColor || 'rgba(56, 189, 248, 0.18)';
        this.gridColor = options.gridColor || 'rgba(255, 255, 255, 0.05)';
        this.fixedMax = options.fixedMax ?? 100;
        this.minMax = options.minMax ?? 100;
        this.data = options.initialData ? [...options.initialData] : new Array(this.maxPoints).fill(Number(options.initialValue) || 0);
        this.dpr = window.devicePixelRatio || 1;
        this.resize();
        window.addEventListener('resize', () => this.resize());
    }

    setOptions(opts = {}) {
        if (opts.strokeColor) this.strokeColor = opts.strokeColor;
        if (opts.fillColor) this.fillColor = opts.fillColor;
        if (opts.fixedMax !== undefined) this.fixedMax = opts.fixedMax;
        if (opts.minMax !== undefined) this.minMax = opts.minMax;
        this.draw();
    }

    setData(arr) {
        if (Array.isArray(arr)) {
            this.data = [...arr];
            this.draw();
        }
    }

    resize() {
        if (!this.canvas) return;
        const rect = this.canvas.getBoundingClientRect();
        this.width = rect.width || 300;
        this.height = rect.height || 100;
        this.canvas.width = Math.floor(this.width * this.dpr);
        this.canvas.height = Math.floor(this.height * this.dpr);
        this.ctx.setTransform(1, 0, 0, 1, 0, 0);
        this.ctx.scale(this.dpr, this.dpr);
        this.draw();
    }

    push(val) {
        const num = typeof val === 'number' && !isNaN(val) ? val : 0;
        this.data.push(num);
        if (this.data.length > this.maxPoints) {
            this.data.shift();
        }
        this.draw();
    }

    draw() {
        if (!this.ctx || !this.width || !this.height) return;
        const ctx = this.ctx;
        const w = this.width;
        const h = this.height;

        ctx.clearRect(0, 0, w, h);

        let maxVal = this.fixedMax;
        if (maxVal === null || maxVal === undefined) {
            const dataMax = Math.max(...this.data, 0);
            maxVal = Math.max(dataMax * 1.25, this.minMax);
        }

        ctx.strokeStyle = this.gridColor;
        ctx.lineWidth = 1;
        ctx.setLineDash([2, 2]);

        for (let i = 1; i <= 3; i++) {
            const y = Math.round((h / 4) * i) + 0.5;
            ctx.beginPath();
            ctx.moveTo(0, y);
            ctx.lineTo(w, y);
            ctx.stroke();
        }

        for (let i = 1; i <= 6; i++) {
            const x = Math.round((w / 7) * i) + 0.5;
            ctx.beginPath();
            ctx.moveTo(x, 0);
            ctx.lineTo(x, h);
            ctx.stroke();
        }

        ctx.setLineDash([]);

        const step = w / (this.maxPoints - 1);
        const points = [];
        for (let i = 0; i < this.data.length; i++) {
            const val = Math.max(0, this.data[i]);
            const normalized = Math.min(1, val / maxVal);
            const x = i * step;
            const y = h - (normalized * (h - 8)) - 4;
            points.push({ x, y });
        }

        if (points.length < 2) return;

        const gradient = ctx.createLinearGradient(0, 0, 0, h);
        gradient.addColorStop(0, this.fillColor);
        gradient.addColorStop(1, 'rgba(0, 0, 0, 0)');

        ctx.beginPath();
        ctx.moveTo(points[0].x, points[0].y);
        for (let i = 1; i < points.length; i++) {
            ctx.lineTo(points[i].x, points[i].y);
        }
        ctx.lineTo(w, h);
        ctx.lineTo(0, h);
        ctx.closePath();
        ctx.fillStyle = gradient;
        ctx.fill();

        ctx.beginPath();
        ctx.moveTo(points[0].x, points[0].y);
        for (let i = 1; i < points.length; i++) {
            ctx.lineTo(points[i].x, points[i].y);
        }
        ctx.strokeStyle = this.strokeColor;
        ctx.lineWidth = 1.75;
        ctx.lineJoin = 'round';
        ctx.stroke();

        const lastPoint = points[points.length - 1];
        ctx.beginPath();
        ctx.arc(lastPoint.x - 2, lastPoint.y, 2.5, 0, Math.PI * 2);
        ctx.fillStyle = this.strokeColor;
        ctx.shadowColor = this.strokeColor;
        ctx.shadowBlur = 6;
        ctx.fill();
        ctx.shadowBlur = 0;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const refreshBtn = document.getElementById('btn-refresh-metrics');
    const refreshIcon = document.getElementById('refresh-icon');
    const lastUpdated = document.getElementById('metric-last-updated');
    const toggleLiveBtn = document.getElementById('btn-toggle-live');
    const toggleLiveDot = document.getElementById('toggle-live-dot');
    const toggleLiveText = document.getElementById('toggle-live-text');
    const maximizeBtn = document.getElementById('btn-maximize-chart');
    const maximizeModal = document.getElementById('modal-telemetry-maximize');
    const closeMaximizeBtn = document.getElementById('btn-close-maximize');

    if (!refreshBtn) return;

    let activeTab = 'cpu';
    const buffers = {
        cpu: new Array(30).fill({{ $serverMetrics['system']['cpu']['percent'] ?? 0 }}),
        ram: new Array(30).fill({{ $serverMetrics['system']['ram']['percent'] ?? 0 }}),
        net: new Array(30).fill({{ $serverMetrics['system']['network']['total_kbps'] ?? 0 }}),
        disk: new Array(30).fill({{ $serverMetrics['system']['disk']['percent'] ?? 0 }})
    };

    let latestMetrics = {
        cpu: { percent: {{ $serverMetrics['system']['cpu']['percent'] ?? 0 }}, cores: {{ $serverMetrics['system']['cpu']['cores'] ?? 1 }}, load_1m: '{{ $serverMetrics['system']['cpu']['load_1m'] ?? 0 }}', load_5m: '{{ $serverMetrics['system']['cpu']['load_5m'] ?? 0 }}' },
        ram: { percent: {{ $serverMetrics['system']['ram']['percent'] ?? 0 }}, used: '{{ $serverMetrics['system']['ram']['used_formatted'] }}', total: '{{ $serverMetrics['system']['ram']['total_formatted'] }}', free: '{{ $serverMetrics['system']['ram']['free_formatted'] }}' },
        net: { total_kbps: {{ $serverMetrics['system']['network']['total_kbps'] ?? 0 }}, total_fmt: '{{ $serverMetrics['system']['network']['total_formatted'] ?? '0 KB/s' }}', rx_fmt: '{{ $serverMetrics['system']['network']['rx_formatted'] ?? '0 KB/s' }}', tx_fmt: '{{ $serverMetrics['system']['network']['tx_formatted'] ?? '0 KB/s' }}', interfaces: @json($serverMetrics['system']['network']['interfaces'] ?? ['eth0']) },
        disk: { percent: {{ $serverMetrics['system']['disk']['percent'] ?? 0 }}, used: '{{ $serverMetrics['system']['disk']['used_formatted'] }}', total: '{{ $serverMetrics['system']['disk']['total_formatted'] }}', free: '{{ $serverMetrics['system']['disk']['free_formatted'] }}' },
        uptime: '{{ $serverMetrics['system']['uptime']['formatted'] }}'
    };

    const tabConfig = {
        cpu: {
            title: 'CPU Utilization',
            subtitle: 'Debian 13 Baremetal &bull; 60 Detik Terakhir',
            color: '#38bdf8',
            fill: 'rgba(56, 189, 248, 0.18)',
            fixedMax: 100,
            scaleText: 'Skala 0-100%',
            badgeClass: 'bg-sky-400 shadow-[0_0_8px_rgba(56,189,248,0.8)]',
            activeClass: 'bg-sky-950/20 border-sky-500/50 shadow-md shadow-sky-950/30'
        },
        ram: {
            title: 'Memori RAM Allocation',
            subtitle: 'Alokasi Fisik DDR &bull; 60 Detik Terakhir',
            color: '#c084fc',
            fill: 'rgba(192, 132, 252, 0.18)',
            fixedMax: 100,
            scaleText: 'Skala 0-100%',
            badgeClass: 'bg-purple-400 shadow-[0_0_8px_rgba(192,132,252,0.8)]',
            activeClass: 'bg-purple-950/20 border-purple-500/50 shadow-md shadow-purple-950/30'
        },
        net: {
            title: 'Network Throughput (I/O)',
            subtitle: 'Throughput Linux Kernel `/proc/net/dev`',
            color: '#34d399',
            fill: 'rgba(52, 211, 153, 0.18)',
            fixedMax: null,
            minMax: 50,
            scaleText: 'Auto-scale KB/s',
            badgeClass: 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]',
            activeClass: 'bg-emerald-950/20 border-emerald-500/50 shadow-md shadow-emerald-950/30'
        },
        disk: {
            title: 'Disk Storage NVMe',
            subtitle: 'Partisi Root Mount `/` Filesystem',
            color: '#fbbf24',
            fill: 'rgba(251, 191, 36, 0.18)',
            fixedMax: 100,
            scaleText: 'Skala 0-100%',
            badgeClass: 'bg-amber-400 shadow-[0_0_8px_rgba(251,191,36,0.8)]',
            activeClass: 'bg-amber-950/20 border-amber-500/50 shadow-md shadow-amber-950/30'
        }
    };

    // Mini Sparklines
    const miniCpuChart = new TaskManagerCanvasChart('mini-cpu-canvas', {
        initialValue: buffers.cpu[buffers.cpu.length - 1],
        fixedMax: 100,
        strokeColor: '#38bdf8',
        fillColor: 'rgba(56, 189, 248, 0.15)'
    });
    const miniRamChart = new TaskManagerCanvasChart('mini-ram-canvas', {
        initialValue: buffers.ram[buffers.ram.length - 1],
        fixedMax: 100,
        strokeColor: '#c084fc',
        fillColor: 'rgba(192, 132, 252, 0.15)'
    });
    const miniNetChart = new TaskManagerCanvasChart('mini-net-canvas', {
        initialValue: buffers.net[buffers.net.length - 1],
        fixedMax: null,
        minMax: 50,
        strokeColor: '#34d399',
        fillColor: 'rgba(52, 211, 153, 0.15)'
    });
    const miniDiskChart = new TaskManagerCanvasChart('mini-disk-canvas', {
        initialValue: buffers.disk[buffers.disk.length - 1],
        fixedMax: 100,
        strokeColor: '#fbbf24',
        fillColor: 'rgba(251, 191, 36, 0.15)'
    });

    // Main Big Chart
    const mainChart = new TaskManagerCanvasChart('main-taskmanager-canvas', {
        initialData: buffers.cpu,
        fixedMax: 100,
        strokeColor: tabConfig.cpu.color,
        fillColor: tabConfig.cpu.fill
    });

    // Modal Maximize Chart
    let modalChart = null;

    function renderDetailView() {
        const cfg = tabConfig[activeTab];
        if (!cfg) return;

        // Header detail
        const titleEl = document.getElementById('tm-detail-title');
        const subEl = document.getElementById('tm-detail-subtitle');
        const badgeEl = document.getElementById('tm-detail-badge');
        const scaleEl = document.getElementById('tm-detail-scale-label');
        const bigValEl = document.getElementById('tm-detail-big-value');

        if (titleEl) titleEl.textContent = cfg.title;
        if (subEl) subEl.innerHTML = cfg.subtitle;
        if (badgeEl) badgeEl.className = 'w-2.5 h-2.5 rounded-full ' + cfg.badgeClass;
        if (scaleEl) scaleEl.textContent = cfg.scaleText;

        // Big value & bottom stats grid
        const s1 = document.getElementById('tm-stat-1');
        const s2 = document.getElementById('tm-stat-2');
        const s3 = document.getElementById('tm-stat-3');
        const s4 = document.getElementById('tm-stat-4');
        const p1 = s1?.previousElementSibling;
        const p2 = s2?.previousElementSibling;
        const p3 = s3?.previousElementSibling;
        const p4 = s4?.previousElementSibling;

        if (activeTab === 'cpu') {
            if (bigValEl) bigValEl.textContent = `${latestMetrics.cpu.percent}%`;
            if (p1) p1.textContent = 'Beban CPU';
            if (s1) s1.textContent = `${latestMetrics.cpu.percent}%`;
            if (p2) p2.textContent = 'Cores';
            if (s2) s2.textContent = `${latestMetrics.cpu.cores} Cores`;
            if (p3) p3.textContent = 'Load 1m / 5m';
            if (s3) s3.textContent = `${latestMetrics.cpu.load_1m} / ${latestMetrics.cpu.load_5m}`;
            if (p4) p4.textContent = 'Host Uptime';
            if (s4) s4.textContent = latestMetrics.uptime;
        } else if (activeTab === 'ram') {
            if (bigValEl) bigValEl.textContent = `${latestMetrics.ram.percent}%`;
            if (p1) p1.textContent = 'Memori Terpakai';
            if (s1) s1.textContent = latestMetrics.ram.used;
            if (p2) p2.textContent = 'Total RAM';
            if (s2) s2.textContent = latestMetrics.ram.total;
            if (p3) p3.textContent = 'Free RAM';
            if (s3) s3.textContent = latestMetrics.ram.free;
            if (p4) p4.textContent = 'Persentase';
            if (s4) s4.textContent = `${latestMetrics.ram.percent}%`;
        } else if (activeTab === 'net') {
            if (bigValEl) bigValEl.textContent = latestMetrics.net.total_fmt;
            if (p1) p1.textContent = 'Download (RX)';
            if (s1) s1.textContent = latestMetrics.net.rx_fmt;
            if (p2) p2.textContent = 'Upload (TX)';
            if (s2) s2.textContent = latestMetrics.net.tx_fmt;
            if (p3) p3.textContent = 'Throughput Total';
            if (s3) s3.textContent = latestMetrics.net.total_fmt;
            if (p4) p4.textContent = 'Interface Aktif';
            if (s4) s4.textContent = latestMetrics.net.interfaces.join(', ');
        } else if (activeTab === 'disk') {
            if (bigValEl) bigValEl.textContent = `${latestMetrics.disk.percent}%`;
            if (p1) p1.textContent = 'Disk Digunakan';
            if (s1) s1.textContent = latestMetrics.disk.used;
            if (p2) p2.textContent = 'Total Kapasitas';
            if (s2) s2.textContent = latestMetrics.disk.total;
            if (p3) p3.textContent = 'Sisa Bebas';
            if (s3) s3.textContent = latestMetrics.disk.free;
            if (p4) p4.textContent = 'Mount Point';
            if (s4) s4.textContent = '/ (NVMe Root)';
        }

        // Switch main chart options & buffer
        mainChart.setOptions({
            strokeColor: cfg.color,
            fillColor: cfg.fill,
            fixedMax: cfg.fixedMax,
            minMax: cfg.minMax ?? 100
        });
        mainChart.setData(buffers[activeTab]);

        // If modal open, update modal too
        if (modalChart && maximizeModal && !maximizeModal.classList.contains('hidden')) {
            updateModalView();
        }
    }

    function switchTab(name) {
        if (!tabConfig[name]) return;
        activeTab = name;

        document.querySelectorAll('.tm-tab-btn').forEach(btn => {
            const tab = btn.dataset.tmTab;
            if (tab === name) {
                btn.className = `tm-tab-btn w-full text-left p-3.5 sm:p-4 rounded-xl border transition-all cursor-pointer ${tabConfig[name].activeClass}`;
            } else {
                btn.className = 'tm-tab-btn w-full text-left p-3.5 sm:p-4 rounded-xl border border-white/10 bg-[#080808] hover:border-white/20 hover:bg-white/[0.02] transition-all cursor-pointer';
            }
        });

        renderDetailView();
    }

    document.querySelectorAll('.tm-tab-btn').forEach(btn => {
        btn.addEventListener('click', () => switchTab(btn.dataset.tmTab));
    });

    // Maximize Modal Logic
    function updateModalView() {
        const cfg = tabConfig[activeTab];
        if (!cfg) return;
        const mTitle = document.getElementById('modal-tm-title');
        const mBadge = document.getElementById('modal-tm-badge');
        const mVal = document.getElementById('modal-tm-value');
        if (mTitle) mTitle.textContent = `${cfg.title} - Inspeksi Resolusi Tinggi`;
        if (mBadge) mBadge.className = `w-2.5 h-2.5 rounded-full ${cfg.badgeClass}`;
        
        if (activeTab === 'net') {
            if (mVal) mVal.textContent = latestMetrics.net.total_fmt;
        } else {
            if (mVal) mVal.textContent = `${latestMetrics[activeTab].percent}%`;
        }

        if (modalChart) {
            modalChart.setOptions({
                strokeColor: cfg.color,
                fillColor: cfg.fill,
                fixedMax: cfg.fixedMax,
                minMax: cfg.minMax ?? 100
            });
            modalChart.setData(buffers[activeTab]);
        }
    }

    if (maximizeBtn && maximizeModal) {
        maximizeBtn.addEventListener('click', () => {
            maximizeModal.classList.remove('hidden');
            if (!modalChart) {
                modalChart = new TaskManagerCanvasChart('modal-taskmanager-canvas', {
                    initialData: buffers[activeTab],
                    fixedMax: tabConfig[activeTab].fixedMax,
                    strokeColor: tabConfig[activeTab].color,
                    fillColor: tabConfig[activeTab].fill
                });
            } else {
                modalChart.resize();
            }
            updateModalView();
        });
    }

    if (closeMaximizeBtn && maximizeModal) {
        closeMaximizeBtn.addEventListener('click', () => {
            maximizeModal.classList.add('hidden');
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && maximizeModal && !maximizeModal.classList.contains('hidden')) {
            maximizeModal.classList.add('hidden');
        }
    });

    // Polling System
    let isLive = true;
    let pollTimer = null;
    let isFetching = false;
    const POLL_INTERVAL = 3000;

    const fetchMetrics = async (isManual = false) => {
        if (isFetching) return;
        isFetching = true;

        if (isManual) {
            refreshBtn.disabled = true;
            refreshIcon.classList.add('animate-spin');
        }

        try {
            const res = await fetch("{{ route('admin.dashboard.server-metrics') }}", {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            if (!res.ok) throw new Error('Failed to fetch');
            const data = await res.json();

            // 1. CPU
            const cpu = data.system.cpu;
            latestMetrics.cpu = {
                percent: Number(cpu.percent) || 0,
                cores: cpu.cores,
                load_1m: cpu.load_1m,
                load_5m: cpu.load_5m || 0
            };
            buffers.cpu.push(latestMetrics.cpu.percent);
            if (buffers.cpu.length > 30) buffers.cpu.shift();
            miniCpuChart.push(latestMetrics.cpu.percent);
            if (document.getElementById('metric-cpu-percent')) document.getElementById('metric-cpu-percent').textContent = `${latestMetrics.cpu.percent}%`;
            if (document.getElementById('metric-cpu-load')) document.getElementById('metric-cpu-load').textContent = `Load: ${latestMetrics.cpu.load_1m}`;
            if (document.getElementById('metric-cpu-cores')) document.getElementById('metric-cpu-cores').textContent = `${latestMetrics.cpu.cores} Cores`;

            // 2. RAM
            const ram = data.system.ram;
            latestMetrics.ram = {
                percent: Number(ram.percent) || 0,
                used: ram.used_formatted,
                total: ram.total_formatted,
                free: ram.free_formatted
            };
            buffers.ram.push(latestMetrics.ram.percent);
            if (buffers.ram.length > 30) buffers.ram.shift();
            miniRamChart.push(latestMetrics.ram.percent);
            if (document.getElementById('metric-ram-percent')) document.getElementById('metric-ram-percent').textContent = `${latestMetrics.ram.percent}%`;
            if (document.getElementById('metric-ram-details')) document.getElementById('metric-ram-details').textContent = `${ram.used_formatted} / ${ram.total_formatted}`;

            // 3. Network
            const net = data.system.network;
            if (net) {
                latestMetrics.net = {
                    total_kbps: Number(net.total_kbps) || 0,
                    total_fmt: net.total_formatted || '0 KB/s',
                    rx_fmt: net.rx_formatted || '0 KB/s',
                    tx_fmt: net.tx_formatted || '0 KB/s',
                    interfaces: net.interfaces || ['eth0']
                };
                buffers.net.push(latestMetrics.net.total_kbps);
                if (buffers.net.length > 30) buffers.net.shift();
                miniNetChart.push(latestMetrics.net.total_kbps);
                if (document.getElementById('metric-net-total')) document.getElementById('metric-net-total').textContent = latestMetrics.net.total_fmt;
                if (document.getElementById('metric-net-rx')) document.getElementById('metric-net-rx').textContent = latestMetrics.net.rx_fmt;
                if (document.getElementById('metric-net-tx')) document.getElementById('metric-net-tx').textContent = latestMetrics.net.tx_fmt;
            }

            // 4. Disk
            const disk = data.system.disk;
            latestMetrics.disk = {
                percent: Number(disk.percent) || 0,
                used: disk.used_formatted,
                total: disk.total_formatted,
                free: disk.free_formatted
            };
            buffers.disk.push(latestMetrics.disk.percent);
            if (buffers.disk.length > 30) buffers.disk.shift();
            miniDiskChart.push(latestMetrics.disk.percent);
            if (document.getElementById('metric-disk-percent')) document.getElementById('metric-disk-percent').textContent = `${latestMetrics.disk.percent}%`;
            if (document.getElementById('metric-disk-details')) document.getElementById('metric-disk-details').textContent = `${disk.used_formatted} / ${disk.total_formatted}`;

            // Uptime & LEMP daemons
            latestMetrics.uptime = data.system.uptime.formatted;
            const db = data.services.database;
            if (document.getElementById('metric-db-latency')) document.getElementById('metric-db-latency').textContent = `${db.latency_ms ?? '-'}ms latency`;
            if (document.getElementById('metric-host-uptime')) document.getElementById('metric-host-uptime').textContent = `Up ${latestMetrics.uptime}`;

            // Render detail view
            renderDetailView();

            const now = new Date();
            if (lastUpdated) lastUpdated.textContent = `Sync: ${now.toTimeString().split(' ')[0]}`;
        } catch (err) {
            console.error('Metrics fetch error:', err);
        } finally {
            isFetching = false;
            if (isManual) {
                refreshBtn.disabled = false;
                refreshIcon.classList.remove('animate-spin');
            }
        }
    };

    const startPolling = () => {
        if (pollTimer) clearInterval(pollTimer);
        pollTimer = setInterval(() => {
            if (isLive && !document.hidden) fetchMetrics(false);
        }, POLL_INTERVAL);
    };

    if (toggleLiveBtn) {
        toggleLiveBtn.addEventListener('click', () => {
            isLive = !isLive;
            if (isLive) {
                if (toggleLiveDot) {
                    toggleLiveDot.className = 'w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]';
                }
                if (toggleLiveText) toggleLiveText.textContent = 'Live';
                fetchMetrics(true);
                startPolling();
            } else {
                if (toggleLiveDot) {
                    toggleLiveDot.className = 'w-2 h-2 rounded-full bg-stone-500';
                }
                if (toggleLiveText) toggleLiveText.textContent = 'Paused';
                if (pollTimer) clearInterval(pollTimer);
            }
        });
    }

    refreshBtn.addEventListener('click', () => {
        fetchMetrics(true);
        if (isLive) startPolling();
    });

    document.addEventListener('visibilitychange', () => {
        if (!document.hidden && isLive) {
            fetchMetrics(false);
            startPolling();
        } else {
            if (pollTimer) clearInterval(pollTimer);
        }
    });

    renderDetailView();
    startPolling();
});
</script>
@endpush
