@extends('layouts.admin')

@section('page_title', 'Overview & Metrics')

@section('admin_content')
<div class="space-y-12">
    
<!-- Top Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            
            <div class="group relative rounded-[2rem] p-1.5 bg-slate-900 border border-white/5 shadow-sm">
                <div class="h-full bg-slate-950 rounded-[calc(2rem-0.375rem)] p-6 shadow-[inset_0_1px_1px_rgba(255,255,255,0.05)] transition-colors duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] group-hover:bg-slate-900 flex flex-col justify-between">
                    <div class="flex justify-between items-start mb-2">
                        <div class="text-[10px] uppercase tracking-[0.2em] font-medium text-slate-500">Total Lab</div>
                        <div class="px-2 py-0.5 rounded-lg bg-cyan-500/10 text-cyan-400 text-xs font-bold border border-cyan-500/20">LABS</div>
                    </div>
                    <div class="text-4xl font-light text-white">{{ $totalProjects }}</div>
                    <div class="mt-4 pt-4 border-t border-white/5 flex items-center justify-between text-xs">
                        <span class="text-cyan-400">Proyek</span>
                        <a href="{{ route('admin.projects.index') }}" class="text-cyan-400 hover:text-cyan-300 transition-colors">Kelola &rarr;</a>
                    </div>
                </div>
            </div>

        <div class="group relative rounded-[2rem] p-1.5 bg-slate-900 border border-white/5 shadow-sm">
            <div class="h-full bg-slate-950 rounded-[calc(2rem-0.375rem)] p-6 shadow-[inset_0_1px_1px_rgba(255,255,255,0.05)] transition-colors duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] group-hover:bg-slate-900 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-2">
                    <div class="text-[10px] uppercase tracking-[0.2em] font-medium text-slate-500">Total Skill</div>
                    <div class="px-2 py-0.5 rounded-lg bg-emerald-500/10 text-emerald-400 text-xs font-bold border border-emerald-500/20">MATRIX</div>
                </div>
                <div class="text-4xl font-light text-white">{{ $totalSkills }}</div>
                <div class="mt-4 pt-4 border-t border-white/5 flex items-center justify-between text-xs">
                    <span class="text-emerald-400">Kompetensi</span>
                    <a href="{{ route('admin.skills.index') }}" class="text-emerald-400 hover:text-emerald-300 transition-colors">Kelola &rarr;</a>
                </div>
            </div>
        </div>

        <div class="group relative rounded-[2rem] p-1.5 bg-slate-900 border border-white/5 shadow-sm">
            <div class="h-full bg-slate-950 rounded-[calc(2rem-0.375rem)] p-6 shadow-[inset_0_1px_1px_rgba(255,255,255,0.05)] transition-colors duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] group-hover:bg-slate-900 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-2">
                    <div class="text-[10px] uppercase tracking-[0.2em] font-medium text-slate-500">Sertifikat</div>
                    <div class="px-2 py-0.5 rounded-lg bg-amber-500/10 text-amber-400 text-xs font-bold border border-amber-500/20">RESMI</div>
                </div>
                <div class="text-4xl font-light text-white">{{ $totalCertificates }}</div>
                <div class="mt-4 pt-4 border-t border-white/5 flex items-center justify-between text-xs">
                    <span class="text-amber-400">Kredensial</span>
                    <a href="{{ route('admin.certificates.index') }}" class="text-amber-400 hover:text-amber-300 transition-colors">Kelola &rarr;</a>
                </div>
            </div>
        </div>

        <div class="group relative rounded-[2rem] p-1.5 bg-slate-900 border border-white/5 shadow-sm">
            <div class="h-full bg-slate-950 rounded-[calc(2rem-0.375rem)] p-6 shadow-[inset_0_1px_1px_rgba(255,255,255,0.05)] transition-colors duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] group-hover:bg-slate-900 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-2">
                    <div class="text-[10px] uppercase tracking-[0.2em] font-medium text-slate-500">Pesan Masuk</div>
                    <div class="px-2 py-0.5 rounded-lg bg-blue-500/10 text-blue-400 text-xs font-bold border border-blue-500/20">INBOX</div>
                </div>
                <div class="text-4xl font-light text-white">{{ $totalMessages }}</div>
                <div class="mt-4 pt-4 border-t border-white/5 flex items-center justify-between text-xs">
                    <span class="text-blue-400">Pengunjung</span>
                    <a href="{{ route('admin.messages.index') }}" class="text-blue-400 hover:text-blue-300 transition-colors">Lihat &rarr;</a>
                </div>
            </div>
        </div>

        <div class="group relative rounded-[2rem] p-1.5 bg-slate-900 border border-white/5 shadow-sm">
            <div class="h-full bg-slate-950 rounded-[calc(2rem-0.375rem)] p-6 shadow-[inset_0_1px_1px_rgba(255,255,255,0.05)] transition-colors duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] group-hover:bg-slate-900 flex flex-col justify-between">
                <div class="flex justify-between items-center mb-4">
                    <div class="text-[10px] uppercase tracking-[0.2em] font-medium text-slate-500">Belum Dibaca</div>
                    @if($unreadMessages > 0)
                        <div class="w-1.5 h-1.5 rounded-full bg-rose-500"></div>
                    @endif
                </div>
                <div class="text-4xl font-light {{ $unreadMessages > 0 ? 'text-rose-400' : 'text-white' }}">{{ $unreadMessages }}</div>
                <div class="mt-4 pt-4 border-t border-white/5 flex items-center justify-between text-xs">
                    <span class="text-rose-400">Perlu Aksi</span>
                    <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" class="text-rose-400 hover:text-rose-300 transition-colors">Buka &rarr;</a>
                </div>
            </div>
        </div>

    </div>

    <!-- Server Health -->
    <div class="rounded-[2rem] p-1.5 bg-slate-900 border border-white/5 shadow-sm">
        <div class="bg-slate-950 rounded-[calc(2rem-0.375rem)] p-8 shadow-[inset_0_1px_1px_rgba(255,255,255,0.05)]">
            
            <div class="flex flex-wrap items-end justify-between gap-6 border-b border-white/5 pb-8 mb-8">
                <div>
                    <div class="text-[10px] uppercase tracking-[0.2em] font-medium text-cyan-400 mb-2">Live Telemetry</div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Status Server</h2>
                    <p class="text-sm text-slate-500 mt-2">LEMP Stack utilitas &amp; ketersediaan (3s poll)</p>
                </div>
                <div class="flex items-center gap-4 text-xs font-mono">
                    <span id="metric-last-updated" class="text-slate-500">
                        Sync: {{ now()->format('H:i:s') }}
                    </span>
                    <button id="btn-toggle-live" class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-900 border border-white/5 hover:bg-slate-800 transition-colors ease-[cubic-bezier(0.32,0.72,0,1)] text-cyan-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500">
                        <span id="toggle-live-dot" class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                        <span id="toggle-live-text">Live</span>
                    </button>
                    <button id="btn-refresh-metrics" class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-900 border border-white/5 hover:bg-slate-800 transition-colors ease-[cubic-bezier(0.32,0.72,0,1)] text-slate-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500">
                        <svg id="refresh-icon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <span>Sync</span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- CPU -->
                <div class="space-y-4">
                    <div class="flex justify-between items-baseline">
                        <div class="text-sm font-medium text-white">Beban CPU</div>
                        <div id="metric-cpu-percent" class="text-2xl font-light text-slate-300 font-mono">{{ $serverMetrics['system']['cpu']['percent'] }}%</div>
                    </div>
                    <div class="h-1 w-full bg-slate-900 rounded-full overflow-hidden">
                        <div id="metric-cpu-bar" class="h-full bg-cyan-400 rounded-full transition-all duration-700 ease-[cubic-bezier(0.32,0.72,0,1)]" style="width: {{ $serverMetrics['system']['cpu']['percent'] }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-slate-500 font-mono">
                        <span id="metric-cpu-load">Load: {{ $serverMetrics['system']['cpu']['load_1m'] }}</span>
                        <span id="metric-cpu-cores">{{ $serverMetrics['system']['cpu']['cores'] }}C</span>
                    </div>
                </div>

                <!-- RAM -->
                <div class="space-y-4">
                    <div class="flex justify-between items-baseline">
                        <div class="text-sm font-medium text-white">Memori</div>
                        <div id="metric-ram-percent" class="text-2xl font-light text-slate-300 font-mono">{{ $serverMetrics['system']['ram']['percent'] }}%</div>
                    </div>
                    <div class="h-1 w-full bg-slate-900 rounded-full overflow-hidden">
                        <div id="metric-ram-bar" class="h-full bg-cyan-400 rounded-full transition-all duration-700 ease-[cubic-bezier(0.32,0.72,0,1)]" style="width: {{ $serverMetrics['system']['ram']['percent'] }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-slate-500 font-mono">
                        <span id="metric-ram-details">{{ $serverMetrics['system']['ram']['used_formatted'] }} / {{ $serverMetrics['system']['ram']['total_formatted'] }}</span>
                        <span id="metric-ram-free">{{ $serverMetrics['system']['ram']['free_formatted'] }} free</span>
                    </div>
                </div>

                <!-- Disk -->
                <div class="space-y-4">
                    <div class="flex justify-between items-baseline">
                        <div class="text-sm font-medium text-white">Disk</div>
                        <div id="metric-disk-percent" class="text-2xl font-light text-slate-300 font-mono">{{ $serverMetrics['system']['disk']['percent'] }}%</div>
                    </div>
                    <div class="h-1 w-full bg-slate-900 rounded-full overflow-hidden">
                        <div id="metric-disk-bar" class="h-full bg-cyan-400 rounded-full transition-all duration-700 ease-[cubic-bezier(0.32,0.72,0,1)]" style="width: {{ $serverMetrics['system']['disk']['percent'] }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-slate-500 font-mono">
                        <span id="metric-disk-details">{{ $serverMetrics['system']['disk']['used_formatted'] }} / {{ $serverMetrics['system']['disk']['total_formatted'] }}</span>
                        <span id="metric-disk-free">{{ $serverMetrics['system']['disk']['free_formatted'] }} free</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-12 pt-8 border-t border-white/5">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-1.5 h-1.5 rounded-full {{ $serverMetrics['services']['database']['status'] === 'online' ? 'bg-cyan-400' : 'bg-rose-500' }}"></div>
                        <div class="text-sm font-medium text-white">MariaDB</div>
                    </div>
                    <div class="text-xs text-slate-500 font-mono" id="metric-db-latency">{{ $serverMetrics['services']['database']['latency_ms'] ?? '-' }}ms latency</div>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-1.5 h-1.5 rounded-full {{ $serverMetrics['services']['web_server']['status'] === 'online' ? 'bg-cyan-400' : 'bg-rose-500' }}"></div>
                        <div class="text-sm font-medium text-white">Nginx</div>
                    </div>
                    <div class="text-xs text-slate-500 font-mono truncate">{{ $serverMetrics['services']['web_server']['software'] }}</div>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-1.5 h-1.5 rounded-full {{ $serverMetrics['services']['php_fpm']['status'] === 'online' ? 'bg-cyan-400' : 'bg-rose-500' }}"></div>
                        <div class="text-sm font-medium text-white">PHP 8.4</div>
                    </div>
                    <div class="text-xs text-slate-500 font-mono">FPM Socket</div>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-cyan-400"></div>
                        <div class="text-sm font-medium text-white">{{ $serverMetrics['host']['os'] }}</div>
                    </div>
                    <div class="text-xs text-slate-500 font-mono" id="metric-host-uptime">Up {{ $serverMetrics['system']['uptime']['formatted'] }}</div>
                </div>
            </div>

        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Recent Projects -->
        <div class="lg:col-span-7 rounded-[2rem] p-1.5 bg-slate-900 border border-white/5 shadow-sm">
            <div class="h-full bg-slate-950 rounded-[calc(2rem-0.375rem)] p-8 shadow-[inset_0_1px_1px_rgba(255,255,255,0.05)]">
                <div class="flex justify-between items-end border-b border-white/5 pb-6 mb-6">
                    <h3 class="text-lg font-bold text-white tracking-tight">Dokumentasi Terbaru</h3>
                    <a href="{{ route('admin.projects.index') }}" class="text-sm text-cyan-400 hover:text-cyan-300 transition-colors">Lihat Semua</a>
                </div>

                <div class="space-y-4">
                    @forelse($recentProjects as $p)
                        <div class="flex items-center justify-between p-4 rounded-xl hover:bg-white/5 transition-colors duration-300 ease-[cubic-bezier(0.32,0.72,0,1)] group">
                            <div>
                                <div class="font-medium text-white mb-1 group-hover:text-cyan-400 transition-colors">{{ $p->title }}</div>
                                <div class="text-xs text-slate-500 font-mono">{{ $p->category }} &bull; {{ $p->created_at->format('d M Y') }}</div>
                            </div>
                            <div class="flex items-center gap-4">
                                <a href="{{ route('admin.projects.edit', $p->id) }}" class="text-sm text-slate-400 hover:text-white transition-colors">Edit</a>
                                <a href="{{ route('projects.show', $p->slug) }}" target="_blank" class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-slate-400 hover:bg-white/10 hover:text-white transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-slate-500 text-sm">Belum ada proyek.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Messages -->
        <div class="lg:col-span-5 rounded-[2rem] p-1.5 bg-slate-900 border border-white/5 shadow-sm">
            <div class="h-full bg-slate-950 rounded-[calc(2rem-0.375rem)] p-8 shadow-[inset_0_1px_1px_rgba(255,255,255,0.05)]">
                <div class="flex justify-between items-end border-b border-white/5 pb-6 mb-6">
                    <h3 class="text-lg font-bold text-white tracking-tight">Pesan Masuk</h3>
                    <a href="{{ route('admin.messages.index') }}" class="text-sm text-cyan-400 hover:text-cyan-300 transition-colors">Inbox</a>
                </div>

                <div class="space-y-4">
                    @forelse($recentMessages as $msg)
                        <a href="{{ route('admin.messages.show', $msg->id) }}" class="block p-5 rounded-xl border {{ $msg->is_read ? 'border-white/5 bg-transparent hover:bg-white/5' : 'border-cyan-500/30 bg-cyan-500/5 hover:bg-cyan-500/10' }} transition-colors duration-300 ease-[cubic-bezier(0.32,0.72,0,1)]">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-medium text-white truncate max-w-[150px]">{{ $msg->sender_name }}</span>
                                <span class="text-xs text-slate-500 font-mono">{{ $msg->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="text-sm text-slate-300 truncate">{{ $msg->subject }}</div>
                            @if(!$msg->is_read)
                                <div class="mt-3 text-[10px] uppercase tracking-[0.2em] font-bold text-cyan-400">Baru</div>
                            @endif
                        </a>
                    @empty
                        <div class="py-8 text-center text-slate-500 text-sm">Inbox kosong.</div>
                    @endforelse
                </div>
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
                bar.className = `h-full rounded-full transition-all duration-700 ease-[cubic-bezier(0.32,0.72,0,1)] ${cpu.percent >= 85 ? 'bg-rose-500' : 'bg-cyan-400'}`;
            }
            if (document.getElementById('metric-cpu-load')) document.getElementById('metric-cpu-load').textContent = `Load: ${cpu.load_1m}`;
            
            // RAM
            const ram = data.system.ram;
            if (document.getElementById('metric-ram-percent')) document.getElementById('metric-ram-percent').textContent = `${ram.percent}%`;
            if (document.getElementById('metric-ram-bar')) {
                const bar = document.getElementById('metric-ram-bar');
                bar.style.width = `${ram.percent}%`;
                bar.className = `h-full rounded-full transition-all duration-700 ease-[cubic-bezier(0.32,0.72,0,1)] ${ram.percent >= 85 ? 'bg-rose-500' : 'bg-cyan-400'}`;
            }
            if (document.getElementById('metric-ram-details')) document.getElementById('metric-ram-details').textContent = `${ram.used_formatted} / ${ram.total_formatted}`;
            if (document.getElementById('metric-ram-free')) document.getElementById('metric-ram-free').textContent = `${ram.free_formatted} free`;

            // Disk
            const disk = data.system.disk;
            if (document.getElementById('metric-disk-percent')) document.getElementById('metric-disk-percent').textContent = `${disk.percent}%`;
            if (document.getElementById('metric-disk-bar')) {
                const bar = document.getElementById('metric-disk-bar');
                bar.style.width = `${disk.percent}%`;
                bar.className = `h-full rounded-full transition-all duration-700 ease-[cubic-bezier(0.32,0.72,0,1)] ${disk.percent >= 85 ? 'bg-rose-500' : 'bg-cyan-400'}`;
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
                if (toggleLiveDot) toggleLiveDot.className = 'w-1.5 h-1.5 rounded-full bg-cyan-400';
                if (toggleLiveText) toggleLiveText.textContent = 'Live';
                if (toggleLiveBtn) toggleLiveBtn.classList.add('text-cyan-400');
                if (toggleLiveBtn) toggleLiveBtn.classList.remove('text-slate-500');
                fetchMetrics(true);
                startPolling();
            } else {
                if (toggleLiveDot) toggleLiveDot.className = 'w-1.5 h-1.5 rounded-full bg-slate-600';
                if (toggleLiveText) toggleLiveText.textContent = 'Paused';
                if (toggleLiveBtn) toggleLiveBtn.classList.remove('text-cyan-400');
                if (toggleLiveBtn) toggleLiveBtn.classList.add('text-slate-500');
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

