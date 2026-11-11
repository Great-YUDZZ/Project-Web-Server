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

        <!-- 3 Hardware Resource Bars -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6">
            <!-- CPU -->
            <div class="space-y-3 p-4 sm:p-5 rounded-xl bg-[#080808] border border-white/10">
                <div class="flex justify-between items-baseline">
                    <span class="text-xs font-mono text-stone-400 uppercase tracking-wider">Beban CPU</span>
                    <span id="metric-cpu-percent" class="text-2xl font-bold text-white font-mono">{{ $serverMetrics['system']['cpu']['percent'] }}%</span>
                </div>
                <div class="h-2 w-full bg-white/10 rounded-full overflow-hidden">
                    <div id="metric-cpu-bar" class="h-full rounded-full bg-white transition-all duration-700" style="width: {{ $serverMetrics['system']['cpu']['percent'] }}%;"></div>
                </div>
                <div class="flex justify-between text-[11px] text-stone-400 font-mono pt-1">
                    <span id="metric-cpu-load">Load: {{ $serverMetrics['system']['cpu']['load_1m'] }}</span>
                    <span id="metric-cpu-cores">{{ $serverMetrics['system']['cpu']['cores'] }} Cores</span>
                </div>
            </div>

            <!-- RAM -->
            <div class="space-y-3 p-4 sm:p-5 rounded-xl bg-[#080808] border border-white/10">
                <div class="flex justify-between items-baseline">
                    <span class="text-xs font-mono text-stone-400 uppercase tracking-wider">Memori RAM</span>
                    <span id="metric-ram-percent" class="text-2xl font-bold text-white font-mono">{{ $serverMetrics['system']['ram']['percent'] }}%</span>
                </div>
                <div class="h-2 w-full bg-white/10 rounded-full overflow-hidden">
                    <div id="metric-ram-bar" class="h-full rounded-full bg-white transition-all duration-700" style="width: {{ $serverMetrics['system']['ram']['percent'] }}%;"></div>
                </div>
                <div class="flex justify-between text-[11px] text-stone-400 font-mono pt-1">
                    <span id="metric-ram-details">{{ $serverMetrics['system']['ram']['used_formatted'] }} / {{ $serverMetrics['system']['ram']['total_formatted'] }}</span>
                    <span id="metric-ram-free">{{ $serverMetrics['system']['ram']['free_formatted'] }} free</span>
                </div>
            </div>

            <!-- Disk -->
            <div class="space-y-3 p-4 sm:p-5 rounded-xl bg-[#080808] border border-white/10">
                <div class="flex justify-between items-baseline">
                    <span class="text-xs font-mono text-stone-400 uppercase tracking-wider">Storage NVMe</span>
                    <span id="metric-disk-percent" class="text-2xl font-bold text-white font-mono">{{ $serverMetrics['system']['disk']['percent'] }}%</span>
                </div>
                <div class="h-2 w-full bg-white/10 rounded-full overflow-hidden">
                    <div id="metric-disk-bar" class="h-full rounded-full bg-white transition-all duration-700" style="width: {{ $serverMetrics['system']['disk']['percent'] }}%;"></div>
                </div>
                <div class="flex justify-between text-[11px] text-stone-400 font-mono pt-1">
                    <span id="metric-disk-details">{{ $serverMetrics['system']['disk']['used_formatted'] }} / {{ $serverMetrics['system']['disk']['total_formatted'] }}</span>
                    <span id="metric-disk-free">{{ $serverMetrics['system']['disk']['free_formatted'] }} free</span>
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

</div>
@endsection

@push('admin_scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const refreshBtn = document.getElementById('btn-refresh-metrics');
    const refreshIcon = document.getElementById('refresh-icon');
    const lastUpdated = document.getElementById('metric-last-updated');
    const toggleLiveBtn = document.getElementById('btn-toggle-live');
    const toggleLiveDot = document.getElementById('toggle-live-dot');
    const toggleLiveText = document.getElementById('toggle-live-text');

    if (!refreshBtn) return;

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
            if (document.getElementById('metric-cpu-bar')) {
                const bar = document.getElementById('metric-cpu-bar');
                bar.style.width = `${cpu.percent}%`;
                bar.style.backgroundColor = cpu.percent >= 85 ? '#E11D48' : '#FFFFFF';
            }
            if (document.getElementById('metric-cpu-load')) document.getElementById('metric-cpu-load').textContent = `Load: ${cpu.load_1m}`;
            
            // RAM
            const ram = data.system.ram;
            if (document.getElementById('metric-ram-percent')) document.getElementById('metric-ram-percent').textContent = `${ram.percent}%`;
            if (document.getElementById('metric-ram-bar')) {
                const bar = document.getElementById('metric-ram-bar');
                bar.style.width = `${ram.percent}%`;
                bar.style.backgroundColor = ram.percent >= 85 ? '#E11D48' : '#FFFFFF';
            }
            if (document.getElementById('metric-ram-details')) document.getElementById('metric-ram-details').textContent = `${ram.used_formatted} / ${ram.total_formatted}`;
            if (document.getElementById('metric-ram-free')) document.getElementById('metric-ram-free').textContent = `${ram.free_formatted} free`;

            // Disk
            const disk = data.system.disk;
            if (document.getElementById('metric-disk-percent')) document.getElementById('metric-disk-percent').textContent = `${disk.percent}%`;
            if (document.getElementById('metric-disk-bar')) {
                const bar = document.getElementById('metric-disk-bar');
                bar.style.width = `${disk.percent}%`;
                bar.style.backgroundColor = disk.percent >= 85 ? '#E11D48' : '#FFFFFF';
            }
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
