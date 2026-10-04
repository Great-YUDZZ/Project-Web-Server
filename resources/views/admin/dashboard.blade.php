@extends('layouts.admin')

@section('page_title', 'Overview & Metrics')

@section('admin_content')
<div class="space-y-8">
    
    <!-- Top Stats (AetherCraft Control Center Metrics) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-5">
        
        <!-- Total Lab -->
        <div class="bg-[#141414] rounded-2xl border border-white/10 p-5 shadow-lg shadow-black/40 hover:border-white/30 transition-all flex flex-col justify-between group">
            <div>
                <div class="flex justify-between items-start mb-2">
                    <div class="text-[11px] uppercase tracking-wider font-body font-semibold text-stone-400">Total Lab</div>
                    <span class="bg-white/10 text-white border border-white/15 px-2.5 py-0.5 rounded-full font-mono text-[10px] font-bold">LABS</span>
                </div>
                <div class="text-4xl sm:text-5xl font-display italic text-white mt-1.5 leading-none">{{ $totalProjects }}</div>
            </div>
            <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between text-xs font-body">
                <span class="text-stone-400">Proyek Lab</span>
                <a href="{{ route('admin.projects.index') }}" class="text-white font-semibold hover:underline flex items-center gap-1 group-hover:translate-x-0.5 transition-transform">
                    <span>Kelola</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Total Skill -->
        <div class="bg-[#141414] rounded-2xl border border-white/10 p-5 shadow-lg shadow-black/40 hover:border-white/30 transition-all flex flex-col justify-between group">
            <div>
                <div class="flex justify-between items-start mb-2">
                    <div class="text-[11px] uppercase tracking-wider font-body font-semibold text-stone-400">Total Skill</div>
                    <span class="bg-white/10 text-white border border-white/15 px-2.5 py-0.5 rounded-full font-mono text-[10px] font-bold">MATRIX</span>
                </div>
                <div class="text-4xl sm:text-5xl font-display italic text-white mt-1.5 leading-none">{{ $totalSkills }}</div>
            </div>
            <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between text-xs font-body">
                <span class="text-stone-400">Kompetensi</span>
                <a href="{{ route('admin.skills.index') }}" class="text-white font-semibold hover:underline flex items-center gap-1 group-hover:translate-x-0.5 transition-transform">
                    <span>Kelola</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Sertifikat -->
        <div class="bg-[#141414] rounded-2xl border border-white/10 p-5 shadow-lg shadow-black/40 hover:border-white/30 transition-all flex flex-col justify-between group">
            <div>
                <div class="flex justify-between items-start mb-2">
                    <div class="text-[11px] uppercase tracking-wider font-body font-semibold text-stone-400">Sertifikat</div>
                    <span class="bg-white/10 text-white border border-white/15 px-2.5 py-0.5 rounded-full font-mono text-[10px] font-bold">RESMI</span>
                </div>
                <div class="text-4xl sm:text-5xl font-display italic text-white mt-1.5 leading-none">{{ $totalCertificates }}</div>
            </div>
            <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between text-xs font-body">
                <span class="text-stone-400">Kredensial</span>
                <a href="{{ route('admin.certificates.index') }}" class="text-white font-semibold hover:underline flex items-center gap-1 group-hover:translate-x-0.5 transition-transform">
                    <span>Kelola</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Pesan Masuk -->
        <div class="bg-[#141414] rounded-2xl border border-white/10 p-5 shadow-lg shadow-black/40 hover:border-white/30 transition-all flex flex-col justify-between group">
            <div>
                <div class="flex justify-between items-start mb-2">
                    <div class="text-[11px] uppercase tracking-wider font-body font-semibold text-stone-400">Pesan Masuk</div>
                    <span class="bg-white/10 text-white border border-white/15 px-2.5 py-0.5 rounded-full font-mono text-[10px] font-bold">INBOX</span>
                </div>
                <div class="text-4xl sm:text-5xl font-display italic text-white mt-1.5 leading-none">{{ $totalMessages }}</div>
            </div>
            <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between text-xs font-body">
                <span class="text-stone-400">Pengunjung</span>
                <a href="{{ route('admin.messages.index') }}" class="text-white font-semibold hover:underline flex items-center gap-1 group-hover:translate-x-0.5 transition-transform">
                    <span>Lihat</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Belum Dibaca -->
        <div class="bg-[#141414] rounded-2xl border border-white/10 p-5 shadow-lg shadow-black/40 hover:border-white/30 transition-all flex flex-col justify-between group">
            <div>
                <div class="flex justify-between items-center mb-2">
                    <div class="text-[11px] uppercase tracking-wider font-body font-semibold text-stone-400">Belum Dibaca</div>
                    @if($unreadMessages > 0)
                        <span class="px-2.5 py-0.5 rounded-full bg-white text-black text-[10px] font-bold font-mono">BARU</span>
                    @endif
                </div>
                <div class="text-4xl sm:text-5xl font-display italic text-white mt-1.5 leading-none">{{ $unreadMessages }}</div>
            </div>
            <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between text-xs font-body">
                <span class="{{ $unreadMessages > 0 ? 'text-white font-semibold' : 'text-stone-400' }}">Perlu Aksi</span>
                <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" class="text-white font-semibold hover:underline flex items-center gap-1 group-hover:translate-x-0.5 transition-transform">
                    <span>Buka</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

    </div>

    <!-- Server Health (Engineering Telemetry Center) -->
    <div class="bg-[#141414] rounded-2xl border border-white/10 p-6 sm:p-7 shadow-lg shadow-black/40">
        <div class="flex flex-wrap items-end justify-between gap-4 border-b border-white/10 pb-5 mb-6">
            <div>
                <div class="text-[11px] uppercase tracking-wider font-mono font-medium text-stone-300 mb-1 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]"></span>
                    <span>Live Telemetry &bull; Debian 13 Baremetal</span>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold font-body text-white tracking-tight">Status Mesin &amp; <span class="font-display italic font-normal text-stone-300">Layanan LEMP</span></h2>
                <p class="text-xs text-stone-400 mt-1 font-body">Poll interval otomatis setiap 3 detik via soket lokal</p>
            </div>
            <div class="flex items-center gap-2.5 text-xs font-body">
                <span id="metric-last-updated" class="text-stone-400 text-[11px] font-mono">
                    Sync: {{ now()->format('H:i:s') }}
                </span>
                <button id="btn-toggle-live" class="flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/15 text-stone-200 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/20 cursor-pointer">
                    <span id="toggle-live-dot" class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]"></span>
                    <span id="toggle-live-text" class="font-semibold text-xs">Live</span>
                </button>
                <button id="btn-refresh-metrics" class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/15 text-stone-200 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/20 cursor-pointer" title="Perbarui metrik manual">
                    <svg id="refresh-icon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span class="font-semibold text-xs">Sync</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
            <!-- CPU -->
            <div class="space-y-3 p-4 rounded-xl bg-[#0a0a0a] border border-white/10">
                <div class="flex justify-between items-baseline">
                    <div class="text-xs font-body font-semibold text-stone-300 uppercase tracking-wider">Beban CPU</div>
                    <div id="metric-cpu-percent" class="text-2xl font-bold text-white font-mono">{{ $serverMetrics['system']['cpu']['percent'] }}%</div>
                </div>
                <div class="h-2 w-full bg-white/10 rounded-full overflow-hidden">
                    <div id="metric-cpu-bar" class="h-full rounded-full bg-white transition-all duration-700" style="width: {{ $serverMetrics['system']['cpu']['percent'] }}%;"></div>
                </div>
                <div class="flex justify-between text-[11px] text-stone-400 font-mono">
                    <span id="metric-cpu-load">Load: {{ $serverMetrics['system']['cpu']['load_1m'] }}</span>
                    <span id="metric-cpu-cores">{{ $serverMetrics['system']['cpu']['cores'] }} Cores</span>
                </div>
            </div>

            <!-- RAM -->
            <div class="space-y-3 p-4 rounded-xl bg-[#0a0a0a] border border-white/10">
                <div class="flex justify-between items-baseline">
                    <div class="text-xs font-body font-semibold text-stone-300 uppercase tracking-wider">Memori RAM</div>
                    <div id="metric-ram-percent" class="text-2xl font-bold text-white font-mono">{{ $serverMetrics['system']['ram']['percent'] }}%</div>
                </div>
                <div class="h-2 w-full bg-white/10 rounded-full overflow-hidden">
                    <div id="metric-ram-bar" class="h-full rounded-full bg-white transition-all duration-700" style="width: {{ $serverMetrics['system']['ram']['percent'] }}%;"></div>
                </div>
                <div class="flex justify-between text-[11px] text-stone-400 font-mono">
                    <span id="metric-ram-details">{{ $serverMetrics['system']['ram']['used_formatted'] }} / {{ $serverMetrics['system']['ram']['total_formatted'] }}</span>
                    <span id="metric-ram-free">{{ $serverMetrics['system']['ram']['free_formatted'] }} free</span>
                </div>
            </div>

            <!-- Disk -->
            <div class="space-y-3 p-4 rounded-xl bg-[#0a0a0a] border border-white/10">
                <div class="flex justify-between items-baseline">
                    <div class="text-xs font-body font-semibold text-stone-300 uppercase tracking-wider">Penyimpanan NVMe</div>
                    <div id="metric-disk-percent" class="text-2xl font-bold text-white font-mono">{{ $serverMetrics['system']['disk']['percent'] }}%</div>
                </div>
                <div class="h-2 w-full bg-white/10 rounded-full overflow-hidden">
                    <div id="metric-disk-bar" class="h-full rounded-full bg-white transition-all duration-700" style="width: {{ $serverMetrics['system']['disk']['percent'] }}%;"></div>
                </div>
                <div class="flex justify-between text-[11px] text-stone-400 font-mono">
                    <span id="metric-disk-details">{{ $serverMetrics['system']['disk']['used_formatted'] }} / {{ $serverMetrics['system']['disk']['total_formatted'] }}</span>
                    <span id="metric-disk-free">{{ $serverMetrics['system']['disk']['free_formatted'] }} free</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mt-6 pt-5 border-t border-white/10">
            <div class="p-3 rounded-xl bg-[#0a0a0a] border border-white/10">
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-2 h-2 rounded-full {{ $serverMetrics['services']['database']['status'] === 'online' ? 'bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]' : 'bg-rose-500' }}"></div>
                    <div class="text-xs font-semibold text-white font-body">MariaDB Database</div>
                </div>
                <div class="text-[11px] text-stone-400 font-mono" id="metric-db-latency">{{ $serverMetrics['services']['database']['latency_ms'] ?? '-' }}ms latency</div>
            </div>
            <div class="p-3 rounded-xl bg-[#0a0a0a] border border-white/10">
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-2 h-2 rounded-full {{ $serverMetrics['services']['web_server']['status'] === 'online' ? 'bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]' : 'bg-rose-500' }}"></div>
                    <div class="text-xs font-semibold text-white font-body">Nginx Web Server</div>
                </div>
                <div class="text-[11px] text-stone-400 font-mono truncate">{{ $serverMetrics['services']['web_server']['software'] }}</div>
            </div>
            <div class="p-3 rounded-xl bg-[#0a0a0a] border border-white/10">
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-2 h-2 rounded-full {{ $serverMetrics['services']['php_fpm']['status'] === 'online' ? 'bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]' : 'bg-rose-500' }}"></div>
                    <div class="text-xs font-semibold text-white font-body">PHP Engine</div>
                </div>
                <div class="text-[11px] text-stone-400 font-mono">PHP 8.4-FPM Socket</div>
            </div>
            <div class="p-3 rounded-xl bg-[#0a0a0a] border border-white/10">
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]"></div>
                    <div class="text-xs font-semibold text-white font-body">{{ $serverMetrics['host']['os'] }}</div>
                </div>
                <div class="text-[11px] text-stone-400 font-mono" id="metric-host-uptime">Up {{ $serverMetrics['system']['uptime']['formatted'] }}</div>
            </div>
        </div>

    </div>

    <!-- Main Grid: Recent Projects & Recent Messages -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">
        
        <!-- Recent Projects -->
        <div class="lg:col-span-7 bg-[#141414] rounded-2xl border border-white/10 p-6 shadow-lg shadow-black/40">
            <div class="flex justify-between items-center border-b border-white/10 pb-4 mb-5">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-white shadow-[0_0_6px_rgba(255,255,255,0.8)]"></span>
                    <h3 class="text-base font-bold font-body text-white tracking-tight">Dokumentasi <span class="font-display italic font-normal text-stone-300">Lab Terbaru</span></h3>
                </div>
                <a href="{{ route('admin.projects.index') }}" class="text-xs font-body text-stone-300 hover:text-white hover:underline font-semibold">Lihat Semua &rarr;</a>
            </div>

            <div class="space-y-3">
                @forelse($recentProjects as $p)
                    <div class="flex items-center justify-between p-3.5 rounded-xl border border-white/10 bg-[#0a0a0a]/60 hover:border-white/30 hover:bg-white/[0.03] transition-all group">
                        <div class="min-w-0 pr-4">
                            <div class="font-semibold text-white text-sm mb-0.5 group-hover:text-stone-200 transition-colors truncate font-body">{{ $p->title }}</div>
                            <div class="text-xs text-stone-400 font-mono flex items-center gap-2">
                                <span class="bg-white/10 text-white border border-white/15 text-[9px] px-2 py-0.5 rounded-full font-mono">{{ $p->category }}</span>
                                <span>{{ $p->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5 shrink-0">
                            <a href="{{ route('admin.projects.edit', $p->id) }}" class="text-xs font-body font-medium text-stone-300 hover:text-black px-2.5 py-1 rounded-lg bg-white/5 hover:bg-white border border-white/15 transition-all">Edit</a>
                            <a href="{{ route('projects.show', $p->slug) }}" target="_blank" class="w-7 h-7 rounded-lg bg-white/5 hover:bg-white hover:text-black flex items-center justify-center text-stone-300 transition-all border border-white/15" title="Buka spesifikasi di web publik">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-stone-500 text-xs font-body">Belum ada proyek terdokumentasi.</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Messages -->
        <div class="lg:col-span-5 bg-[#141414] rounded-2xl border border-white/10 p-6 shadow-lg shadow-black/40">
            <div class="flex justify-between items-center border-b border-white/10 pb-4 mb-5">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-white shadow-[0_0_6px_rgba(255,255,255,0.8)]"></span>
                    <h3 class="text-base font-bold font-body text-white tracking-tight">Pesan &amp; <span class="font-display italic font-normal text-stone-300">Inquiry Pengunjung</span></h3>
                </div>
                <a href="{{ route('admin.messages.index') }}" class="text-xs font-body text-stone-300 hover:text-white hover:underline font-semibold">Inbox &rarr;</a>
            </div>

            <div class="space-y-3">
                @forelse($recentMessages as $msg)
                    <a href="{{ route('admin.messages.show', $msg->id) }}" class="block p-3.5 rounded-xl border {{ $msg->is_read ? 'border-white/10 bg-[#0a0a0a]/60 hover:bg-white/[0.03]' : 'border-white/30 bg-white/[0.04] hover:bg-white/[0.08]' }} transition-all">
                        <div class="flex justify-between items-start mb-1">
                            <span class="font-semibold text-white truncate max-w-[170px] text-xs font-body">{{ $msg->sender_name }}</span>
                            <span class="text-[11px] text-stone-400 font-mono">{{ $msg->created_at->diffForHumans() }}</span>
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
