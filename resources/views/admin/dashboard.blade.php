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

        <!-- 3 Windows Task Manager Live Streaming Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 sm:gap-6">
            <!-- CPU Utilization -->
            <div class="p-4 sm:p-5 rounded-2xl bg-[#080808] border border-white/10 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <div class="flex items-center gap-1.5 text-xs font-mono text-sky-400 font-semibold uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-sky-400 shadow-[0_0_6px_rgba(56,189,248,0.8)]"></span>
                                <span>CPU Utilization</span>
                            </div>
                            <div class="text-[11px] text-stone-400 font-mono mt-0.5">
                                <span id="metric-cpu-cores">{{ $serverMetrics['system']['cpu']['cores'] }} Cores</span> &bull; <span id="metric-cpu-load">Load: {{ $serverMetrics['system']['cpu']['load_1m'] }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span id="metric-cpu-percent" class="text-2xl sm:text-3xl font-bold text-white font-mono tracking-tight">{{ $serverMetrics['system']['cpu']['percent'] }}%</span>
                            <div class="text-[10px] font-mono text-stone-400">100% Scale</div>
                        </div>
                    </div>
                    <!-- Canvas Chart -->
                    <div class="relative w-full h-28 my-2 rounded-xl bg-[#040404] border border-white/10 overflow-hidden">
                        <canvas id="chart-cpu" class="w-full h-full block"></canvas>
                    </div>
                </div>
                <div class="pt-2 border-t border-white/5 flex items-center justify-between text-[11px] font-mono text-stone-400">
                    <span>60 Detik Terakhir</span>
                    <span class="text-stone-300 font-medium">Beban CPU</span>
                </div>
            </div>

            <!-- Memory RAM -->
            <div class="p-4 sm:p-5 rounded-2xl bg-[#080808] border border-white/10 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <div class="flex items-center gap-1.5 text-xs font-mono text-purple-400 font-semibold uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-400 shadow-[0_0_6px_rgba(192,132,252,0.8)]"></span>
                                <span>Memori RAM</span>
                            </div>
                            <div class="text-[11px] text-stone-400 font-mono mt-0.5">
                                <span id="metric-ram-details">{{ $serverMetrics['system']['ram']['used_formatted'] }} / {{ $serverMetrics['system']['ram']['total_formatted'] }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span id="metric-ram-percent" class="text-2xl sm:text-3xl font-bold text-white font-mono tracking-tight">{{ $serverMetrics['system']['ram']['percent'] }}%</span>
                            <div id="metric-ram-free" class="text-[10px] font-mono text-stone-400">{{ $serverMetrics['system']['ram']['free_formatted'] }} free</div>
                        </div>
                    </div>
                    <!-- Canvas Chart -->
                    <div class="relative w-full h-28 my-2 rounded-xl bg-[#040404] border border-white/10 overflow-hidden">
                        <canvas id="chart-ram" class="w-full h-full block"></canvas>
                    </div>
                </div>
                <div class="pt-2 border-t border-white/5 flex items-center justify-between text-[11px] font-mono text-stone-400">
                    <span>60 Detik Terakhir</span>
                    <span class="text-stone-300 font-medium">Penggunaan RAM</span>
                </div>
            </div>

            <!-- Network Throughput -->
            <div class="p-4 sm:p-5 rounded-2xl bg-[#080808] border border-white/10 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <div class="flex items-center gap-1.5 text-xs font-mono text-emerald-400 font-semibold uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]"></span>
                                <span>Network Throughput</span>
                            </div>
                            <div class="text-[11px] text-stone-400 font-mono mt-0.5 flex items-center gap-2">
                                <span>&darr; RX: <strong id="metric-net-rx" class="text-white">{{ $serverMetrics['system']['network']['rx_formatted'] ?? '0 KB/s' }}</strong></span>
                                <span>&uarr; TX: <strong id="metric-net-tx" class="text-white">{{ $serverMetrics['system']['network']['tx_formatted'] ?? '0 KB/s' }}</strong></span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span id="metric-net-total" class="text-2xl sm:text-3xl font-bold text-white font-mono tracking-tight">{{ $serverMetrics['system']['network']['total_formatted'] ?? '0 KB/s' }}</span>
                            <div class="text-[10px] font-mono text-stone-400">Auto-scale KB/s</div>
                        </div>
                    </div>
                    <!-- Canvas Chart -->
                    <div class="relative w-full h-28 my-2 rounded-xl bg-[#040404] border border-white/10 overflow-hidden">
                        <canvas id="chart-net" class="w-full h-full block"></canvas>
                    </div>
                </div>
                <div class="pt-2 border-t border-white/5 flex items-center justify-between text-[11px] font-mono text-stone-400">
                    <span>60 Detik Terakhir</span>
                    <span class="text-stone-300 font-medium" id="metric-net-interface">Interface: {{ implode(', ', $serverMetrics['system']['network']['interfaces'] ?? ['eth0']) }}</span>
                </div>
            </div>
        </div>

        <!-- 5 LEMP Stack & Storage Statuses -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mt-6 pt-5 border-t border-white/10">
            <!-- Storage NVMe -->
            <div class="p-3.5 rounded-xl bg-[#080808] border border-white/10 flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-400 shadow-[0_0_6px_rgba(251,191,36,0.8)]"></span>
                        <span class="text-xs font-semibold text-white font-body">Disk NVMe</span>
                    </div>
                    <div class="text-[11px] text-stone-400 font-mono mt-1" id="metric-disk-details">{{ $serverMetrics['system']['disk']['used_formatted'] }} / {{ $serverMetrics['system']['disk']['total_formatted'] }}</div>
                </div>
                <span id="metric-disk-percent" class="text-xs font-mono font-bold text-stone-200">{{ $serverMetrics['system']['disk']['percent'] }}%</span>
            </div>

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

</div>
@endsection

@push('admin_scripts')
<script>
class TaskManagerCanvasChart {
    constructor(canvasId, options = {}) {
        this.canvas = document.getElementById(canvasId);
        if (!this.canvas) return;
        this.ctx = this.canvas.getContext('2d');
        this.maxPoints = options.maxPoints || 30; // 30 titik x 3 detik = 90 detik riwayat
        this.strokeColor = options.strokeColor || '#38bdf8';
        this.fillColor = options.fillColor || 'rgba(56, 189, 248, 0.18)';
        this.gridColor = options.gridColor || 'rgba(255, 255, 255, 0.05)';
        this.fixedMax = options.fixedMax ?? 100;
        this.minMax = options.minMax ?? 100;
        this.data = new Array(this.maxPoints).fill(Number(options.initialValue) || 0);
        this.dpr = window.devicePixelRatio || 1;
        this.resize();
        window.addEventListener('resize', () => this.resize());
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

        // Skala vertikal
        let maxVal = this.fixedMax;
        if (maxVal === null || maxVal === undefined) {
            const dataMax = Math.max(...this.data, 0);
            maxVal = Math.max(dataMax * 1.25, this.minMax);
        }

        // 1. Gridlines ala Windows Task Manager (Dotted)
        ctx.strokeStyle = this.gridColor;
        ctx.lineWidth = 1;
        ctx.setLineDash([2, 2]);

        // Horizontal Grid (25%, 50%, 75%)
        for (let i = 1; i <= 3; i++) {
            const y = Math.round((h / 4) * i) + 0.5;
            ctx.beginPath();
            ctx.moveTo(0, y);
            ctx.lineTo(w, y);
            ctx.stroke();
        }

        // Vertical Grid (6 kolom)
        for (let i = 1; i <= 5; i++) {
            const x = Math.round((w / 6) * i) + 0.5;
            ctx.beginPath();
            ctx.moveTo(x, 0);
            ctx.lineTo(x, h);
            ctx.stroke();
        }

        ctx.setLineDash([]);

        // 2. Kalkulasi Koordinat Titik
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

        // 3. Area Fill (Gradient)
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

        // 4. Line Stroke
        ctx.beginPath();
        ctx.moveTo(points[0].x, points[0].y);
        for (let i = 1; i < points.length; i++) {
            ctx.lineTo(points[i].x, points[i].y);
        }
        ctx.strokeStyle = this.strokeColor;
        ctx.lineWidth = 1.75;
        ctx.lineJoin = 'round';
        ctx.stroke();

        // 5. Live Head Dot (Titik Aktif Terkanan)
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

    if (!refreshBtn) return;

    // Inisialisasi 3 Grafik Windows Task Manager
    const cpuChart = new TaskManagerCanvasChart('chart-cpu', {
        initialValue: {{ $serverMetrics['system']['cpu']['percent'] ?? 0 }},
        fixedMax: 100,
        strokeColor: '#38bdf8',
        fillColor: 'rgba(56, 189, 248, 0.18)'
    });

    const ramChart = new TaskManagerCanvasChart('chart-ram', {
        initialValue: {{ $serverMetrics['system']['ram']['percent'] ?? 0 }},
        fixedMax: 100,
        strokeColor: '#c084fc',
        fillColor: 'rgba(192, 132, 252, 0.18)'
    });

    const netChart = new TaskManagerCanvasChart('chart-net', {
        initialValue: {{ $serverMetrics['system']['network']['total_kbps'] ?? 0 }},
        fixedMax: null,
        minMax: 50,
        strokeColor: '#34d399',
        fillColor: 'rgba(52, 211, 153, 0.18)'
    });

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

            // CPU
            const cpu = data.system.cpu;
            if (document.getElementById('metric-cpu-percent')) document.getElementById('metric-cpu-percent').textContent = `${cpu.percent}%`;
            if (document.getElementById('metric-cpu-load')) document.getElementById('metric-cpu-load').textContent = `Load: ${cpu.load_1m}`;
            if (document.getElementById('metric-cpu-cores')) document.getElementById('metric-cpu-cores').textContent = `${cpu.cores} Cores`;
            cpuChart.push(Number(cpu.percent) || 0);

            // RAM
            const ram = data.system.ram;
            if (document.getElementById('metric-ram-percent')) document.getElementById('metric-ram-percent').textContent = `${ram.percent}%`;
            if (document.getElementById('metric-ram-details')) document.getElementById('metric-ram-details').textContent = `${ram.used_formatted} / ${ram.total_formatted}`;
            if (document.getElementById('metric-ram-free')) document.getElementById('metric-ram-free').textContent = `${ram.free_formatted} free`;
            ramChart.push(Number(ram.percent) || 0);

            // Network
            const net = data.system.network;
            if (net) {
                if (document.getElementById('metric-net-total')) document.getElementById('metric-net-total').textContent = net.total_formatted || '0 KB/s';
                if (document.getElementById('metric-net-rx')) document.getElementById('metric-net-rx').textContent = net.rx_formatted || '0 KB/s';
                if (document.getElementById('metric-net-tx')) document.getElementById('metric-net-tx').textContent = net.tx_formatted || '0 KB/s';
                if (document.getElementById('metric-net-interface') && net.interfaces) {
                    document.getElementById('metric-net-interface').textContent = `Interface: ${net.interfaces.join(', ')}`;
                }
                netChart.push(Number(net.total_kbps) || 0);
            }

            // Disk NVMe
            const disk = data.system.disk;
            if (document.getElementById('metric-disk-percent')) document.getElementById('metric-disk-percent').textContent = `${disk.percent}%`;
            if (document.getElementById('metric-disk-details')) document.getElementById('metric-disk-details').textContent = `${disk.used_formatted} / ${disk.total_formatted}`;

            // Latency & Uptime
            const db = data.services.database;
            if (document.getElementById('metric-db-latency')) document.getElementById('metric-db-latency').textContent = `${db.latency_ms ?? '-'}ms latency`;
            if (document.getElementById('metric-host-uptime')) document.getElementById('metric-host-uptime').textContent = `Up ${data.system.uptime.formatted}`;

            // Time
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

    startPolling();
});
</script>
@endpush
