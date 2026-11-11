@extends('layouts.admin')

@section('page_title', 'Hosting & cPanel')

@section('admin_content')
<div class="space-y-6" id="hosting-root" data-tab="{{ $tab ?? 'cpanel' }}">

    <div id="toast" class="fixed bottom-6 right-6 z-50 hidden max-w-sm rounded-xl border px-4 py-3 shadow-2xl font-mono text-xs"></div>

    <div id="hosting-error" class="hidden rounded-2xl border border-rose-800/60 bg-rose-950/40 p-4 text-rose-300 text-xs font-body">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <span id="hosting-error-text">Gagal memuat data hosting.</span>
            <button type="button" id="hosting-retry" class="cursor-pointer rounded-full border border-rose-700/60 px-3 py-1 text-xs font-semibold text-white hover:bg-rose-900/40">Coba Lagi</button>
        </div>
    </div>

    <div id="hosting-skeleton" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="h-28 animate-pulse rounded-2xl bg-white/5 border border-white/10"></div>
        <div class="h-28 animate-pulse rounded-2xl bg-white/5 border border-white/10"></div>
        <div class="h-28 animate-pulse rounded-2xl bg-white/5 border border-white/10"></div>
        <div class="h-28 animate-pulse rounded-2xl bg-white/5 border border-white/10"></div>
    </div>

    <!-- Compact Server Ribbon Header -->
    <div class="rounded-2xl bg-[#0f0f0f] border border-white/10 p-5 sm:p-6 shadow-lg shadow-black/40">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <div class="text-[11px] uppercase tracking-wider font-mono text-stone-400 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]"></span>
                    <span>cPanel &amp; WHM &bull; Debian 13 Baremetal</span>
                </div>
                <h2 class="mt-1 text-xl sm:text-2xl font-bold font-body text-white tracking-tight">Server &amp; Web Hosting Control Center</h2>
                <p class="mt-1 text-xs text-stone-400 font-body">Manajemen virtualhost Nginx, kontrol panel aaPanel, DNS zone BIND9, dan daemon layanan.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <button type="button" id="btn-heal" class="flex cursor-pointer items-center gap-2 rounded-full bg-white px-4 py-2 text-xs font-bold text-black transition-colors hover:bg-stone-200 disabled:opacity-50">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    <span>Verify &amp; Heal All</span>
                </button>
                <button type="button" id="btn-refresh" class="flex cursor-pointer items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-2 text-xs font-semibold text-stone-200 transition-colors hover:bg-white/10">
                    <svg id="refresh-icon" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    <span>Sync</span>
                </button>
            </div>
        </div>

        <div class="mt-5 grid grid-cols-2 gap-3 border-t border-white/10 pt-4 font-mono text-xs sm:grid-cols-3 lg:grid-cols-6">
            <div class="p-2.5 rounded-xl bg-[#080808] border border-white/5">
                <span class="block text-[10px] uppercase text-stone-500 font-medium">Primary Domain</span>
                <span class="block truncate font-bold text-white mt-0.5">great-yuda.my.id</span>
            </div>
            <div class="p-2.5 rounded-xl bg-[#080808] border border-white/5">
                <span class="block text-[10px] uppercase text-stone-500 font-medium">DNS Recovery</span>
                <span class="block font-bold text-white mt-0.5">yuda.local</span>
            </div>
            <div class="p-2.5 rounded-xl bg-[#080808] border border-white/5">
                <span class="block text-[10px] uppercase text-stone-500 font-medium">Server IP</span>
                <span id="strip-ip" class="block font-bold text-white mt-0.5">{{ $overview['server']['sharedIp'] ?? '127.0.0.1' }}</span>
            </div>
            <div class="p-2.5 rounded-xl bg-[#080808] border border-white/5">
                <span class="block text-[10px] uppercase text-stone-500 font-medium">Web Server</span>
                <span class="block font-bold text-white mt-0.5">Nginx 1.22 (HTTP/2)</span>
            </div>
            <div class="p-2.5 rounded-xl bg-[#080808] border border-white/5">
                <span class="block text-[10px] uppercase text-stone-500 font-medium">Database</span>
                <span class="block font-bold text-white mt-0.5">MariaDB (:3306)</span>
            </div>
            <div class="p-2.5 rounded-xl bg-[#080808] border border-white/5">
                <span class="block text-[10px] uppercase text-stone-500 font-medium">Uptime</span>
                <span id="strip-uptime" class="block font-bold text-white mt-0.5">{{ $overview['server']['uptimeSeconds'] ?? 0 }}s</span>
            </div>
        </div>
    </div>

    <!-- 4 Telemetry Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="rounded-2xl border border-white/10 bg-[#0f0f0f] p-5 shadow-lg shadow-black/40">
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase tracking-wider font-mono text-stone-400">CPU Load</span>
                <span id="stat-cpu" class="font-mono text-lg font-bold text-white">{{ $overview['server']['cpuLoadPercent'] ?? 0 }}%</span>
            </div>
            <div class="mt-3 h-1.5 w-full overflow-hidden rounded-full bg-white/10"><div id="bar-cpu" class="h-full rounded-full bg-white transition-all duration-500" style="width:{{ min(100, max(0, $overview['server']['cpuLoadPercent'] ?? 0)) }}%"></div></div>
            <div id="stat-cpu-detail" class="mt-2 text-[11px] font-mono text-stone-500">{{ $overview['server']['cpuCores'] ?? 1 }} cores active</div>
        </div>
        <div class="rounded-2xl border border-white/10 bg-[#0f0f0f] p-5 shadow-lg shadow-black/40">
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase tracking-wider font-mono text-stone-400">RAM Usage</span>
                <span id="stat-ram" class="font-mono text-lg font-bold text-white">{{ $overview['server']['memory']['percent'] ?? 0 }}%</span>
            </div>
            <div class="mt-3 h-1.5 w-full overflow-hidden rounded-full bg-white/10"><div id="bar-ram" class="h-full rounded-full bg-white transition-all duration-500" style="width:{{ min(100, max(0, $overview['server']['memory']['percent'] ?? 0)) }}%"></div></div>
            <div id="stat-ram-detail" class="mt-2 text-[11px] font-mono text-stone-500">{{ $overview['server']['memory']['usedMb'] ?? 0 }} / {{ $overview['server']['memory']['totalMb'] ?? 0 }} MB</div>
        </div>
        <div class="rounded-2xl border border-white/10 bg-[#0f0f0f] p-5 shadow-lg shadow-black/40">
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase tracking-wider font-mono text-stone-400">Disk NVMe</span>
                <span id="stat-disk" class="font-mono text-lg font-bold text-white">{{ $overview['server']['disks'][0]['usePercent'] ?? 0 }}%</span>
            </div>
            <div class="mt-3 h-1.5 w-full overflow-hidden rounded-full bg-white/10"><div id="bar-disk" class="h-full rounded-full bg-white transition-all duration-500" style="width:{{ min(100, max(0, $overview['server']['disks'][0]['usePercent'] ?? 0)) }}%"></div></div>
            <div id="stat-disk-detail" class="mt-2 text-[11px] font-mono text-stone-500">{{ $overview['server']['disks'][0]['usedGb'] ?? 0 }} / {{ $overview['server']['disks'][0]['sizeGb'] ?? 0 }} GB</div>
        </div>
        <div class="rounded-2xl border border-white/10 bg-[#0f0f0f] p-5 shadow-lg shadow-black/40">
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase tracking-wider font-mono text-stone-400">Active Services</span>
                <span id="stat-svc" class="font-mono text-lg font-bold text-white">{{ count(array_filter($overview['services'] ?? [], fn ($s) => ($s['status'] ?? '') === 'running')) }}/{{ count($overview['services'] ?? []) }}</span>
            </div>
            <div class="mt-3 h-1.5 w-full overflow-hidden rounded-full bg-white/10"><div id="bar-svc" class="h-full rounded-full bg-emerald-400 transition-all duration-500" style="width:100%"></div></div>
            <div class="mt-2 text-[11px] font-mono text-stone-500">WHM allowlist daemons</div>
        </div>
    </div>

    <!-- Segmented Module Categories & Tabs -->
    <div class="bg-[#0f0f0f] p-4 sm:p-5 rounded-2xl border border-white/10 shadow-lg shadow-black/40 space-y-3" id="tabs">
        <div class="flex items-center justify-between border-b border-white/10 pb-3">
            <div class="text-xs font-mono font-bold text-white uppercase tracking-wider flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]"></span>
                <span>Modul Kendali Server &amp; Hosting</span>
            </div>
            <span class="text-[11px] font-mono text-stone-400 hidden sm:inline">Pilih modul untuk mengelola komponen</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- 1. Web & Domains -->
            <div class="p-3 rounded-xl bg-[#080808] border border-white/10 flex flex-col justify-between">
                <div class="text-[10px] font-mono uppercase text-stone-400 tracking-wider mb-2.5 flex items-center justify-between">
                    <span>1. Web &amp; Domains</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-400 shadow-[0_0_6px_rgba(56,189,248,0.8)]"></span>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button type="button" data-tab="domains" class="hosting-tab flex-1 flex cursor-pointer items-center justify-center gap-1.5 rounded-lg px-2.5 py-1.5 font-mono text-xs font-semibold transition-all">Domains</button>
                    <button type="button" data-tab="dns" class="hosting-tab flex-1 flex cursor-pointer items-center justify-center gap-1.5 rounded-lg px-2.5 py-1.5 font-mono text-xs font-semibold transition-all">DNS &amp; Sinkhole</button>
                </div>
            </div>

            <!-- 2. Server & WHM -->
            <div class="p-3 rounded-xl bg-[#080808] border border-white/10 flex flex-col justify-between">
                <div class="text-[10px] font-mono uppercase text-stone-400 tracking-wider mb-2.5 flex items-center justify-between">
                    <span>2. Server &amp; WHM</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]"></span>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button type="button" data-tab="cpanel" class="hosting-tab flex-1 flex cursor-pointer items-center justify-center gap-1.5 rounded-lg px-2.5 py-1.5 font-mono text-xs font-semibold transition-all">Overview</button>
                    <button type="button" data-tab="services" class="hosting-tab flex-1 flex cursor-pointer items-center justify-center gap-1.5 rounded-lg px-2.5 py-1.5 font-mono text-xs font-semibold transition-all">Services</button>
                    <button type="button" data-tab="storage" class="hosting-tab flex-1 flex cursor-pointer items-center justify-center gap-1.5 rounded-lg px-2.5 py-1.5 font-mono text-xs font-semibold transition-all">Storage</button>
                </div>
            </div>

            <!-- 3. Keamanan -->
            <div class="p-3 rounded-xl bg-[#080808] border border-white/10 flex flex-col justify-between">
                <div class="text-[10px] font-mono uppercase text-stone-400 tracking-wider mb-2.5 flex items-center justify-between">
                    <span>3. Keamanan</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 shadow-[0_0_6px_rgba(251,191,36,0.8)]"></span>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button type="button" data-tab="firewall" class="hosting-tab w-full flex cursor-pointer items-center justify-center gap-1.5 rounded-lg px-2.5 py-1.5 font-mono text-xs font-semibold transition-all">Firewall &amp; Ports</button>
                </div>
            </div>

            <!-- 4. Data & Otomasi -->
            <div class="p-3 rounded-xl bg-[#080808] border border-white/10 flex flex-col justify-between">
                <div class="text-[10px] font-mono uppercase text-stone-400 tracking-wider mb-2.5 flex items-center justify-between">
                    <span>4. Data &amp; Studio</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-purple-400 shadow-[0_0_6px_rgba(192,132,252,0.8)]"></span>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button type="button" data-tab="databases" class="hosting-tab flex-1 flex cursor-pointer items-center justify-center gap-1.5 rounded-lg px-2.5 py-1.5 font-mono text-xs font-semibold transition-all">MariaDB</button>
                    <button type="button" data-tab="cron" class="hosting-tab flex-1 flex cursor-pointer items-center justify-center gap-1.5 rounded-lg px-2.5 py-1.5 font-mono text-xs font-semibold transition-all">Cron</button>
                    <button type="button" data-tab="nginx" class="hosting-tab flex-1 flex cursor-pointer items-center justify-center gap-1.5 rounded-lg px-2.5 py-1.5 font-mono text-xs font-semibold transition-all">Nginx</button>
                </div>
            </div>
        </div>
    </div>

    <section data-panel="cpanel" class="hosting-panel space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="rounded-2xl border border-white/10 bg-[#141414] p-5">
                <h3 class="font-mono text-sm font-bold text-white">Storage Debian</h3>
                <p class="mt-1 text-xs text-stone-400">Partisi, kuota folder per domain, dan pemakaian disk.</p>
                <button type="button" data-goto="storage" class="mt-3 cursor-pointer text-xs font-semibold text-white underline">Buka Storage &rarr;</button>
            </div>
            <div class="rounded-2xl border border-white/10 bg-[#141414] p-5">
                <h3 class="font-mono text-sm font-bold text-white">Domains &amp; Sinkhole</h3>
                <p class="mt-1 text-xs text-stone-400">VHosts Nginx aktif dan penutupan domain online lain di DNS lokal.</p>
                <button type="button" data-goto="domains" class="mt-3 cursor-pointer text-xs font-semibold text-white underline">Buka Domains &rarr;</button>
            </div>
            <div class="rounded-2xl border border-white/10 bg-[#141414] p-5">
                <h3 class="font-mono text-sm font-bold text-white">Service Manager</h3>
                <p class="mt-1 text-xs text-stone-400">Start, restart, reload, stop untuk daemon allowlist.</p>
                <button type="button" data-goto="services" class="mt-3 cursor-pointer text-xs font-semibold text-white underline">Buka Services &rarr;</button>
            </div>
            <div class="rounded-2xl border border-white/10 bg-[#141414] p-5">
                <h3 class="font-mono text-sm font-bold text-white">DNS Zone Editor</h3>
                <p class="mt-1 text-xs text-stone-400">Record A/CNAME zona yuda.local dan great-yuda.my.id.</p>
                <button type="button" data-goto="dns" class="mt-3 cursor-pointer text-xs font-semibold text-white underline">Buka DNS &rarr;</button>
            </div>
            <div class="rounded-2xl border border-white/10 bg-[#141414] p-5">
                <h3 class="font-mono text-sm font-bold text-white">Firewall UFW</h3>
                <p class="mt-1 text-xs text-stone-400">Status UFW dan soket listening lokal.</p>
                <button type="button" data-goto="firewall" class="mt-3 cursor-pointer text-xs font-semibold text-white underline">Buka Firewall &rarr;</button>
            </div>
            <div class="rounded-2xl border border-white/10 bg-[#141414] p-5">
                <h3 class="font-mono text-sm font-bold text-white">Nginx Studio</h3>
                <p class="mt-1 text-xs text-stone-400">Edit konfigurasi vhost utama dengan validasi nginx -t.</p>
                <button type="button" data-goto="nginx" class="mt-3 cursor-pointer text-xs font-semibold text-white underline">Buka Nginx &rarr;</button>
            </div>
        </div>
        <div class="rounded-2xl border border-white/10 bg-[#141414] p-5">
            <div class="flex items-center justify-between">
                <h3 class="font-mono text-sm font-bold text-white">Audit Terakhir</h3>
                <span class="text-[11px] font-mono text-stone-500" id="audit-count">{{ count($overview['activityLogs'] ?? []) }} log</span>
            </div>
            <div id="audit-list" class="mt-3 space-y-2">
                @forelse($overview['activityLogs'] ?? [] as $log)
                    <div class="flex flex-wrap items-center justify-between gap-2 rounded-xl border border-white/10 bg-[#0a0a0a] p-3 font-mono text-xs">
                        <span class="font-bold text-white">[{{ $log['category'] ?? 'SYSTEM' }}] {{ $log['action'] }}</span>
                        <span class="text-stone-400">{{ $log['target'] ?? '—' }}</span>
                        <span class="{{ ($log['result'] ?? '') === 'ok' ? 'text-emerald-400' : 'text-rose-400' }}">{{ $log['result'] ?? '' }}</span>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-white/15 p-6 text-center text-xs text-stone-500">Belum ada aktivitas hosting teraudit. Aksi pertama akan muncul di sini.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section data-panel="storage" class="hosting-panel hidden space-y-4">
        <div class="grid grid-cols-2 gap-3 font-mono text-xs sm:grid-cols-3 lg:grid-cols-6">
            <div class="rounded-xl border border-white/10 bg-[#0a0a0a] p-3"><span class="block text-[10px] text-stone-500">OS</span><span class="mt-1 block font-bold text-white" id="storage-os">{{ $overview['server']['distro'] ?? 'Debian 13' }}</span><span class="text-stone-500">Kernel: <span id="storage-kernel">{{ $overview['server']['kernel'] ?? '' }}</span></span></div>
            <div class="rounded-xl border border-white/10 bg-[#0a0a0a] p-3"><span class="block text-[10px] text-stone-500">Hostname &amp; IP</span><span class="mt-1 block truncate font-bold text-white" id="storage-host">{{ $overview['server']['hostname'] ?? '' }}</span><span class="text-stone-500" id="storage-ip">{{ $overview['server']['sharedIp'] ?? '' }}</span></div>
            <div class="rounded-xl border border-white/10 bg-[#0a0a0a] p-3"><span class="block text-[10px] text-stone-500">CPU Load</span><span class="mt-1 block font-bold text-white" id="storage-cpu">{{ $overview['server']['cpuLoadPercent'] ?? 0 }}%</span><span class="text-stone-500" id="storage-load">{{ implode(' / ', $overview['server']['loadAvg'] ?? []) }}</span></div>
            <div class="rounded-xl border border-white/10 bg-[#0a0a0a] p-3"><span class="block text-[10px] text-stone-500">RAM</span><span class="mt-1 block font-bold text-white" id="storage-ram">{{ $overview['server']['memory']['usedMb'] ?? 0 }} MB</span><span class="text-stone-500">Total: {{ $overview['server']['memory']['totalMb'] ?? 0 }} MB</span></div>
            <div class="rounded-xl border border-white/10 bg-[#0a0a0a] p-3"><span class="block text-[10px] text-stone-500">Disk</span><span class="mt-1 block font-bold text-white" id="storage-disk">{{ $overview['server']['disks'][0]['usePercent'] ?? 0 }}%</span><span class="text-stone-500" id="storage-disk-detail">{{ $overview['server']['disks'][0]['usedGb'] ?? 0 }} / {{ $overview['server']['disks'][0]['sizeGb'] ?? 0 }} GB</span></div>
            <div class="rounded-xl border border-white/10 bg-[#0a0a0a] p-3"><span class="block text-[10px] text-stone-500">Uptime</span><span class="mt-1 block font-bold text-white" id="storage-uptime">{{ $overview['server']['uptimeSeconds'] ?? 0 }}s</span><span class="text-stone-500">Host baremetal</span></div>
        </div>
        <div class="overflow-x-auto rounded-2xl border border-white/10 bg-[#141414]">
            <table class="w-full text-left font-mono text-xs">
                <thead><tr class="border-b border-white/10 text-stone-500"><th class="px-4 py-3">Mount</th><th class="px-4 py-3">Fs</th><th class="px-4 py-3">Size</th><th class="px-4 py-3">Used</th><th class="px-4 py-3">%</th></tr></thead>
                <tbody id="storage-disks">
                    @foreach($overview['server']['disks'] ?? [] as $disk)
                        <tr class="border-b border-white/5"><td class="px-4 py-3 text-white">{{ $disk['mount'] ?? '/' }}</td><td class="px-4 py-3 text-stone-400">{{ $disk['fs'] ?? '' }}</td><td class="px-4 py-3">{{ $disk['sizeGb'] ?? 0 }} GB</td><td class="px-4 py-3">{{ $disk['usedGb'] ?? 0 }} GB</td><td class="px-4 py-3">{{ $disk['usePercent'] ?? 0 }}%</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section data-panel="domains" class="hosting-panel hidden space-y-4">
        <!-- Kartu Integrasi Control Panel aaPanel -->
        <div class="rounded-2xl border border-white/10 bg-[#141414] p-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-start gap-3">
                    <div class="mt-0.5 flex h-9 w-9 items-center justify-center rounded-xl border border-white/10 bg-white/5 font-mono text-xs font-bold text-white">
                        aaP
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-mono text-sm font-bold text-white">aaPanel Hosting Control Panel</h3>
                            <span id="aapanel-badge" class="rounded-full px-2 py-0.5 text-[10px] font-bold {{ !empty($overview['aapanel']['connected']) ? 'bg-emerald-950/60 text-emerald-300 border border-emerald-800/40' : 'bg-stone-800 text-stone-400' }}">
                                {{ !empty($overview['aapanel']['connected']) ? 'TERHUBUNG' : 'STANDBY / OFFLINE' }}
                            </span>
                        </div>
                        <p id="aapanel-msg" class="mt-1 text-xs text-stone-400 font-body">
                            {{ $overview['aapanel']['message'] ?? 'Menghubungkan ke aaPanel daemon...' }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ $overview['aapanelUrl'] ?? 'http://127.0.0.1:7800' }}" target="_blank" rel="noopener" class="inline-flex cursor-pointer items-center gap-1.5 rounded-full border border-white/15 bg-white/5 px-3.5 py-1.5 font-mono text-xs font-semibold text-white transition-colors hover:bg-white/10">
                        <span>Buka aaPanel</span>
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="lg:col-span-2 space-y-4">
                <div class="overflow-x-auto rounded-2xl border border-white/10 bg-[#0f0f0f]">
                    <table class="w-full text-left font-mono text-xs">
                        <thead>
                            <tr class="border-b border-white/10 text-stone-400 bg-white/[0.02]">
                                <th class="px-5 py-3.5">Domain &amp; Aliases</th>
                                <th class="px-5 py-3.5">Engine</th>
                                <th class="px-5 py-3.5">Root / Target</th>
                                <th class="px-5 py-3.5">Status</th>
                                <th class="px-5 py-3.5 text-right">Kendali Web</th>
                            </tr>
                        </thead>
                        <tbody id="domains-body">
                            @forelse($overview['domains'] ?? [] as $domain)
                                <tr class="border-b border-white/5 hover:bg-white/[0.02] transition-colors">
                                    <td class="px-5 py-3.5">
                                        <div class="font-bold text-white">{{ $domain['domain'] }}</div>
                                        @if(!empty($domain['aliases']))
                                            <div class="text-[10px] text-stone-500">{{ implode(', ', $domain['aliases']) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if(($domain['engine'] ?? 'nginx') === 'aapanel')
                                            <span class="rounded-full border border-purple-500/30 bg-purple-950/40 px-2 py-0.5 text-[10px] font-semibold text-purple-300">aaPanel</span>
                                        @else
                                            <span class="rounded-full border border-sky-500/30 bg-sky-950/40 px-2 py-0.5 text-[10px] font-semibold text-sky-300">Nginx Native</span>
                                        @endif
                                    </td>
                                    <td class="max-w-60 truncate px-5 py-3.5 text-stone-400" title="{{ $domain['root'] ?? '' }}">
                                        {{ $domain['root'] ?? '—' }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="rounded-full px-2.5 py-0.5 text-[10px] font-bold {{ !empty($domain['suspended']) ? 'bg-rose-950/60 text-rose-300 border border-rose-800/40' : 'bg-emerald-950/60 text-emerald-300 border border-emerald-800/40' }}">
                                            {{ !empty($domain['suspended']) ? 'TER-SUSPEND (503)' : 'ACTIVE' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        @if(!empty($domain['canSuspend']))
                                            @if(!empty($domain['suspended']))
                                                <button type="button"
                                                    data-vhost-toggle="unsuspend"
                                                    data-domain="{{ $domain['domain'] }}"
                                                    data-engine="{{ $domain['engine'] ?? 'nginx' }}"
                                                    data-site-id="{{ $domain['siteId'] ?? '' }}"
                                                    class="cursor-pointer rounded-full bg-white px-3.5 py-1 text-[11px] font-bold text-black hover:bg-stone-200">
                                                    Hidupkan
                                                </button>
                                            @else
                                                <button type="button"
                                                    data-vhost-toggle="suspend"
                                                    data-domain="{{ $domain['domain'] }}"
                                                    data-engine="{{ $domain['engine'] ?? 'nginx' }}"
                                                    data-site-id="{{ $domain['siteId'] ?? '' }}"
                                                    class="cursor-pointer rounded-full border border-rose-800/60 bg-rose-950/30 px-3.5 py-1 text-[11px] font-bold text-rose-300 hover:bg-rose-900/40">
                                                    Suspend
                                                </button>
                                            @endif
                                        @else
                                            <span class="rounded-full border border-white/10 px-3 py-1 text-[11px] text-stone-500" title="Domain utama dilindungi agar admin tidak lockout">Dilindungi</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-5 py-8 text-center text-stone-500">Tidak ada vhost terbaca dari server.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="rounded-2xl border border-white/10 bg-[#141414] p-5">
                    <h3 class="font-mono text-sm font-bold text-white">Sinkhole DNS Lokal (BIND9)</h3>
                    <p class="mt-1 text-xs text-stone-400">Blokir atau arahkan domain tertentu khusus untuk klien di jaringan LAN lokal. Domain terlindungi: yuda.local, great-yuda.my.id.</p>
                    <form id="form-sinkhole" class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-[1fr_180px_auto]">
                        <label class="block"><span class="mb-1 block text-xs font-mono text-stone-400">Domain target</span><input name="domain" required placeholder="contoh: google.com" class="w-full rounded-xl border border-white/10 bg-[#0a0a0a] px-3 py-2.5 font-mono text-xs text-white"></label>
                        <label class="block"><span class="mb-1 block text-xs font-mono text-stone-400">Target IP</span><select name="target_ip" class="w-full rounded-xl border border-white/10 bg-[#0a0a0a] px-3 py-2.5 font-mono text-xs text-white"><option value="0.0.0.0">0.0.0.0 (block)</option><option value="127.0.0.1">127.0.0.1 (local)</option><option value="{{ $overview['server']['sharedIp'] ?? '' }}">{{ $overview['server']['sharedIp'] ?? 'server IP' }}</option></select></label>
                        <button type="submit" class="cursor-pointer self-end rounded-full bg-white px-5 py-2.5 text-xs font-bold text-black hover:bg-stone-200">Tambah Sinkhole</button>
                    </form>
                    <div class="mt-4 space-y-2" id="sinkholes-list">
                        @forelse($overview['sinkholes'] ?? [] as $sinkhole)
                            <div class="flex flex-wrap items-center justify-between gap-2 rounded-xl border border-white/10 bg-[#0a0a0a] p-3 font-mono text-xs">
                                <span class="font-bold text-white">{{ $sinkhole['domain'] }} &rarr; {{ $sinkhole['target_ip'] }} <span class="ml-1 rounded-full bg-rose-950/60 px-2 py-0.5 text-[10px] text-rose-300">TER-SUSPEND</span></span>
                                <button type="button" data-del-sinkhole="{{ $sinkhole['domain'] }}" class="cursor-pointer rounded-full bg-white px-3 py-1 text-xs font-bold text-black hover:bg-stone-200">Hidupkan</button>
                            </div>
                        @empty
                            <div class="rounded-xl border border-dashed border-white/15 p-6 text-center text-xs text-stone-500">Belum ada domain ter-sinkhole di DNS lokal.</div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-white/10 bg-[#141414] p-5 space-y-4">
                <div>
                    <h3 class="font-mono text-sm font-bold text-white">Mekanisme Kendali Suspend</h3>
                    <ol class="mt-3 list-decimal space-y-2 pl-5 text-xs text-stone-400 font-body">
                        <li><strong class="text-white">Nginx Native:</strong> Ketika disuspend, konfigurasi vhost dialihkan ke blok respons HTTP 503 custom maintenance di <span class="font-mono text-white">/maintenance/suspended.html</span> tanpa menghapus file proyek aslinya.</li>
                        <li><strong class="text-white">aaPanel:</strong> Ketika disuspend, panel mengirim perintah <span class="font-mono text-white">SiteStop</span> via aaPanel REST API langsung ke daemon aaPanel.</li>
                        <li><strong class="text-white">Proteksi Self-Lockout:</strong> Domain inti <span class="font-mono text-white">great-yuda.my.id</span> dan <span class="font-mono text-white">yuda.local</span> dilindungi secara sistem dan tidak bisa disuspend.</li>
                    </ol>
                </div>
                <div class="border-t border-white/10 pt-4">
                    <h4 class="font-mono text-xs font-bold text-white">Perintah Cek di Terminal</h4>
                    <pre class="mt-2 overflow-x-auto rounded-lg bg-black/60 p-2.5 font-mono text-[11px] text-stone-300">sudo hosting-ctl vhost status yudzz-app
curl -I http://yudzz-app.my.id</pre>
                </div>
            </div>
        </div>
    </section>

    <section data-panel="dns" class="hosting-panel hidden space-y-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="rounded-2xl border border-white/10 bg-[#141414] p-5">
                <h3 class="font-mono text-sm font-bold text-white">Tambah Record</h3>
                <form id="form-dns" class="mt-4 space-y-3">
                    <label class="block"><span class="mb-1 block text-xs font-mono text-stone-400">Zona</span><select name="zone" class="w-full rounded-xl border border-white/10 bg-[#0a0a0a] px-3 py-2.5 font-mono text-xs text-white"><option value="yuda.local">yuda.local</option><option value="great-yuda.my.id">great-yuda.my.id</option></select></label>
                    <label class="block"><span class="mb-1 block text-xs font-mono text-stone-400">Nama (@ atau sub-label)</span><input name="name" required placeholder="contoh: app" class="w-full rounded-xl border border-white/10 bg-[#0a0a0a] px-3 py-2.5 font-mono text-xs text-white"></label>
                    <label class="block"><span class="mb-1 block text-xs font-mono text-stone-400">Tipe</span><select name="type" class="w-full rounded-xl border border-white/10 bg-[#0a0a0a] px-3 py-2.5 font-mono text-xs text-white"><option value="A">A</option><option value="CNAME">CNAME</option></select></label>
                    <label class="block"><span class="mb-1 block text-xs font-mono text-stone-400">Content (IP / domain)</span><input name="content" required placeholder="contoh: 10.10.22.99" class="w-full rounded-xl border border-white/10 bg-[#0a0a0a] px-3 py-2.5 font-mono text-xs text-white"></label>
                    <label class="block"><span class="mb-1 block text-xs font-mono text-stone-400">TTL</span><input name="ttl" type="number" min="60" max="86400" value="3600" class="w-full rounded-xl border border-white/10 bg-[#0a0a0a] px-3 py-2.5 font-mono text-xs text-white"></label>
                    <button type="submit" class="w-full cursor-pointer rounded-full bg-white py-2.5 text-xs font-bold text-black hover:bg-stone-200">Simpan Record</button>
                </form>
            </div>
            <div class="lg:col-span-2 overflow-x-auto rounded-2xl border border-white/10 bg-[#141414]">
                <table class="w-full text-left font-mono text-xs">
                    <thead><tr class="border-b border-white/10 text-stone-500"><th class="px-4 py-3">Name</th><th class="px-4 py-3">Type</th><th class="px-4 py-3">Content</th><th class="px-4 py-3">Zone</th><th class="px-4 py-3 text-right">Aksi</th></tr></thead>
                    <tbody id="dns-body">
                        @forelse($overview['dnsRecords'] ?? [] as $record)
                            @if(($record['type'] ?? '') !== 'SINKHOLE')
                                <tr class="border-b border-white/5"><td class="px-4 py-3 font-bold text-white">{{ $record['name'] }}</td><td class="px-4 py-3">{{ $record['type'] }}</td><td class="max-w-60 truncate px-4 py-3 text-stone-300">{{ $record['content'] }}</td><td class="px-4 py-3 text-stone-500">{{ $record['zone'] }}</td><td class="px-4 py-3 text-right"><button type="button" data-del-dns-zone="{{ $record['zone'] }}" data-del-dns-name="{{ $record['name'] }}" data-del-dns-type="{{ $record['type'] }}" class="cursor-pointer rounded-full border border-white/15 px-3 py-1 text-[11px] text-stone-200 hover:bg-white/10">Hapus</button></td></tr>
                            @endif
                        @empty
                            <tr><td colspan="5" class="px-4 py-8 text-center text-stone-500">Belum ada DNS record terbaca. Zona mungkin belum terisi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section data-panel="services" class="hosting-panel hidden space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="text-base font-bold text-white">WHM Service Manager</h3>
                <p class="text-xs text-stone-400">Semua kontrol lewat allowlist hosting-ctl. Stop service protected butuh konfirmasi.</p>
            </div>
            <button type="button" id="btn-heal-2" class="flex cursor-pointer items-center gap-2 self-start rounded-full bg-white px-4 py-2 text-xs font-bold text-black hover:bg-stone-200 sm:self-center">Heal yang berhenti</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="services-grid">
            @forelse($overview['services'] ?? [] as $service)
                <div class="rounded-2xl border {{ ($service['status'] ?? '') === 'running' ? 'border-white/10' : 'border-rose-800/60' }} bg-[#141414] p-4">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <div class="font-mono text-sm font-bold text-white">{{ $service['displayName'] }}</div>
                            <div class="mt-0.5 text-[11px] text-stone-400">{{ $service['description'] ?? '' }}</div>
                        </div>
                        <span class="rounded-full px-2.5 py-0.5 font-mono text-[10px] font-bold {{ ($service['status'] ?? '') === 'running' ? 'bg-emerald-950/60 text-emerald-300' : 'bg-rose-950/60 text-rose-300' }}">{{ strtoupper($service['status'] ?? '') }}</span>
                    </div>
                    <div class="mt-3 grid grid-cols-3 gap-1.5 font-mono text-[11px]">
                        <div class="rounded-lg bg-[#0a0a0a] p-2"><span class="block text-[10px] text-stone-500">Port</span><span class="text-white">{{ isset($service['port']) ? ':' . $service['port'] : 'socket' }}</span></div>
                        <div class="rounded-lg bg-[#0a0a0a] p-2"><span class="block text-[10px] text-stone-500">Unit</span><span class="truncate text-white">{{ $service['name'] }}</span></div>
                        <div class="rounded-lg bg-[#0a0a0a] p-2"><span class="block text-[10px] text-stone-500">Manager</span><span class="text-white">{{ $service['manager'] ?? 'systemd' }}</span></div>
                    </div>
                    <div class="mt-3 flex items-center gap-1 border-t border-white/10 pt-3">
                        @foreach(['start', 'restart', 'reload', 'stop'] as $action)
                            <button type="button" data-service="{{ $service['id'] }}" data-action="{{ $action }}" data-protected="{{ !empty($service['protected']) ? '1' : '0' }}" class="svc-btn flex-1 cursor-pointer rounded-full border border-white/15 px-2 py-1.5 text-[11px] font-mono capitalize text-stone-200 hover:bg-white/10 disabled:opacity-50">{{ $action }}</button>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-dashed border-white/15 p-8 text-center text-xs text-stone-500">Tidak ada service pada allowlist. Periksa config/hosting.php.</div>
            @endforelse
        </div>
    </section>

    <section data-panel="databases" class="hosting-panel hidden space-y-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="space-y-4">
                <div class="rounded-2xl border border-white/10 bg-[#141414] p-5">
                    <h3 class="font-mono text-sm font-bold text-white">Buat Database</h3>
                    <p class="mt-1 text-xs text-stone-400">Butuh <span class="font-mono">HOSTING_DB_ADMIN_ENABLED=true</span> di .env.</p>
                    <form id="form-database" class="mt-4 space-y-3">
                        <label class="block"><span class="mb-1 block text-xs font-mono text-stone-400">Nama DB</span><input name="name" required placeholder="contoh: lab_db" class="w-full rounded-xl border border-white/10 bg-[#0a0a0a] px-3 py-2.5 font-mono text-xs text-white"></label>
                        <label class="block"><span class="mb-1 block text-xs font-mono text-stone-400">Username</span><input name="username" required placeholder="contoh: lab_user" class="w-full rounded-xl border border-white/10 bg-[#0a0a0a] px-3 py-2.5 font-mono text-xs text-white"></label>
                        <button type="submit" class="w-full cursor-pointer rounded-full bg-white py-2.5 text-xs font-bold text-black hover:bg-stone-200">Buat DB &amp; User</button>
                    </form>
                    <button type="button" id="btn-backup" class="mt-3 w-full cursor-pointer rounded-full border border-white/15 py-2.5 text-xs font-semibold text-stone-200 hover:bg-white/5">Backup Sekarang</button>
                    <div id="backups-list" class="mt-3 space-y-1.5 font-mono text-[11px] text-stone-400">
                        @forelse($overview['databases']['backups'] ?? [] as $backup)
                            <div class="rounded-lg border border-white/10 p-2">{{ $backup['filename'] }} ({{ round(($backup['sizeBytes'] ?? 0) / 1024, 1) }} KB)</div>
                        @empty
                            <div class="text-stone-500">Belum ada backup di storage/backups.</div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2 space-y-4">
                <div class="space-y-2.5" id="db-instances">
                    @foreach($overview['databases']['instances'] ?? [] as $instance)
                        <div class="flex flex-wrap items-center justify-between gap-2 rounded-2xl border border-white/10 bg-[#141414] p-4">
                            <div><div class="font-mono text-sm font-bold text-white">{{ $instance['name'] }} <span class="ml-1 text-xs text-stone-400">{{ $instance['engine'] }} {{ $instance['host'] }}:{{ $instance['port'] }}</span></div><div class="mt-1 font-mono text-xs text-stone-400">User: {{ $instance['username'] }} &bull; {{ $instance['charset'] ?? '' }}</div></div>
                            @if(($instance['id'] ?? '') !== 'db-main')
                                <button type="button" data-del-db="{{ $instance['name'] }}" class="cursor-pointer rounded-full border border-rose-800/60 px-3 py-1.5 text-xs text-rose-300 hover:bg-rose-900/30">Hapus</button>
                            @else
                                <span class="font-mono text-[11px] text-stone-500">DB utama dilindungi</span>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="overflow-x-auto rounded-2xl border border-white/10 bg-[#141414]">
                    <table class="w-full text-left font-mono text-xs">
                        <thead><tr class="border-b border-white/10 text-stone-500"><th class="px-4 py-3">Tabel</th><th class="px-4 py-3">Engine</th><th class="px-4 py-3">Rows</th><th class="px-4 py-3">Size</th></tr></thead>
                        <tbody id="db-tables">
                            @forelse($overview['databases']['tables'] ?? [] as $table)
                                <tr class="border-b border-white/5"><td class="px-4 py-2.5 font-bold text-white">{{ $table['tableName'] }}</td><td class="px-4 py-2.5">{{ $table['engine'] }}</td><td class="px-4 py-2.5">{{ $table['rows'] }}</td><td class="px-4 py-2.5">{{ $table['sizeKb'] }} KB</td></tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-8 text-center text-stone-500">Tidak bisa membaca information_schema. Koneksi MySQL mungkin offline.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <section data-panel="firewall" class="hosting-panel hidden space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-white/10 bg-[#141414] p-5">
            <div>
                <h3 class="font-mono text-sm font-bold text-white">UFW / Netfilter</h3>
                <p id="fw-status" class="mt-1 text-xs text-stone-400">{{ !empty($overview['firewall']['enabled']) ? 'FIREWALL ACTIVE' : 'FIREWALL DISABLED / UFW tidak terinstall' }}</p>
            </div>
            <button type="button" id="btn-fw-toggle" class="cursor-pointer rounded-full bg-white px-4 py-2 text-xs font-bold text-black hover:bg-stone-200">{{ !empty($overview['firewall']['enabled']) ? 'Matikan Firewall' : 'Aktifkan Firewall' }}</button>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="rounded-2xl border border-white/10 bg-[#141414] p-5">
                <h3 class="font-mono text-sm font-bold text-white">Tambah Aturan</h3>
                <form id="form-fw" class="mt-4 space-y-3">
                    <label class="block"><span class="mb-1 block text-xs font-mono text-stone-400">Port / Rentang</span><input name="port" required placeholder="contoh: 8080 atau 5000:5010" class="w-full rounded-xl border border-white/10 bg-[#0a0a0a] px-3 py-2.5 font-mono text-xs text-white"></label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="block"><span class="mb-1 block text-xs font-mono text-stone-400">Protokol</span><select name="protocol" class="w-full rounded-xl border border-white/10 bg-[#0a0a0a] px-3 py-2.5 font-mono text-xs text-white"><option>TCP</option><option>UDP</option></select></label>
                        <label class="block"><span class="mb-1 block text-xs font-mono text-stone-400">Action</span><select name="action" class="w-full rounded-xl border border-white/10 bg-[#0a0a0a] px-3 py-2.5 font-mono text-xs text-white"><option>ALLOW</option><option>LIMIT</option><option>DENY</option></select></label>
                    </div>
                    <label class="block"><span class="mb-1 block text-xs font-mono text-stone-400">Source IP / CIDR</span><input name="source" value="0.0.0.0/0" class="w-full rounded-xl border border-white/10 bg-[#0a0a0a] px-3 py-2.5 font-mono text-xs text-white"></label>
                    <label class="block"><span class="mb-1 block text-xs font-mono text-stone-400">Deskripsi</span><input name="service" required placeholder="contoh: Custom App" class="w-full rounded-xl border border-white/10 bg-[#0a0a0a] px-3 py-2.5 font-mono text-xs text-white"></label>
                    <button type="submit" class="w-full cursor-pointer rounded-full bg-white py-2.5 text-xs font-bold text-black hover:bg-stone-200">Tambah Aturan UFW</button>
                </form>
            </div>
            <div class="lg:col-span-2 space-y-4">
                <div class="overflow-x-auto rounded-2xl border border-white/10 bg-[#141414]">
                    <table class="w-full text-left font-mono text-xs">
                        <thead><tr class="border-b border-white/10 text-stone-500"><th class="px-4 py-3">Port</th><th class="px-4 py-3">Action</th><th class="px-4 py-3">Source</th><th class="px-4 py-3">Service</th><th class="px-4 py-3 text-right">Aksi</th></tr></thead>
                        <tbody id="fw-rules">
                            @forelse($overview['firewall']['rules'] ?? [] as $rule)
                                <tr class="border-b border-white/5"><td class="px-4 py-2.5 font-bold text-white">{{ $rule['port'] }}/{{ strtolower($rule['protocol'] ?? 'tcp') }}</td><td class="px-4 py-2.5">{{ $rule['action'] }}</td><td class="px-4 py-2.5">{{ $rule['source'] }}</td><td class="px-4 py-2.5 text-stone-400">{{ $rule['service'] }}</td><td class="px-4 py-2.5 text-right"><button type="button" data-del-fw-port="{{ $rule['port'] }}" data-del-fw-protocol="{{ $rule['protocol'] ?? 'TCP' }}" class="cursor-pointer rounded-full border border-white/15 px-3 py-1 text-[11px]">Hapus</button></td></tr>
                            @empty
                                <tr><td colspan="5" class="px-4 py-8 text-center text-stone-500">Tidak ada aturan UFW terbaca (UFW belum terinstall atau sudo belum dikonfigurasi).</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="rounded-2xl border border-white/10 bg-[#141414] p-5">
                    <h3 class="font-mono text-sm font-bold text-white">Listening Sockets (ss -tuln)</h3>
                    <div id="fw-ports" class="mt-3 flex flex-wrap gap-2">
                        @forelse($overview['firewall']['listeningPorts'] ?? [] as $port)
                            <span class="rounded-full border border-white/10 px-3 py-1.5 font-mono text-xs text-stone-300">:{{ $port['localPort'] }} ({{ $port['protocol'] ?? 'tcp' }})</span>
                        @empty
                            <span class="text-xs text-stone-500">Port aktif: :80 (nginx), :53 (bind9), :3306 (mariadb)</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section data-panel="cron" class="hosting-panel hidden space-y-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="rounded-2xl border border-white/10 bg-[#141414] p-5">
                <h3 class="font-mono text-sm font-bold text-white">Buat Cron Job</h3>
                <p class="mt-1 text-xs text-stone-400">Command dibatasi allowlist: php artisan, curl, wget, php di root project.</p>
                <form id="form-cron" class="mt-4 space-y-3">
                    <label class="block"><span class="mb-1 block text-xs font-mono text-stone-400">Nama</span><input name="name" required placeholder="contoh: Clear Cache" class="w-full rounded-xl border border-white/10 bg-[#0a0a0a] px-3 py-2.5 font-mono text-xs text-white"></label>
                    <label class="block"><span class="mb-1 block text-xs font-mono text-stone-400">Ekspresi Cron</span><input name="schedule" required value="0 * * * *" class="w-full rounded-xl border border-white/10 bg-[#0a0a0a] px-3 py-2.5 font-mono text-xs text-white"></label>
                    <label class="block"><span class="mb-1 block text-xs font-mono text-stone-400">Command</span><input name="command" required placeholder="php artisan cache:clear" class="w-full rounded-xl border border-white/10 bg-[#0a0a0a] px-3 py-2.5 font-mono text-xs text-white"></label>
                    <label class="block"><span class="mb-1 block text-xs font-mono text-stone-400">Deskripsi</span><input name="description" placeholder="Penjelasan tugas..." class="w-full rounded-xl border border-white/10 bg-[#0a0a0a] px-3 py-2.5 font-mono text-xs text-white"></label>
                    <button type="submit" class="w-full cursor-pointer rounded-full bg-white py-2.5 text-xs font-bold text-black hover:bg-stone-200">Simpan Cron Job</button>
                </form>
            </div>
            <div class="lg:col-span-2 space-y-3" id="cron-list">
                @forelse($overview['cronJobs'] ?? [] as $job)
                    <div class="rounded-2xl border border-white/10 bg-[#141414] p-4">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div class="flex items-center gap-2"><span class="font-mono text-sm font-bold text-white">{{ $job['name'] }}</span><span class="rounded-full border border-white/10 px-2 py-0.5 font-mono text-[11px] text-stone-300">{{ $job['schedule'] }}</span><span class="rounded-full px-2 py-0.5 font-mono text-[10px] {{ ($job['last_status'] ?? '') === 'success' ? 'bg-emerald-950/60 text-emerald-300' : (($job['last_status'] ?? '') === 'failed' ? 'bg-rose-950/60 text-rose-300' : 'bg-white/10 text-stone-300') }}">{{ strtoupper($job['last_status'] ?? 'never') }}</span></div>
                            <div class="flex items-center gap-2">
                                <button type="button" data-run-cron="{{ $job['id'] }}" class="cursor-pointer rounded-full bg-white px-3 py-1.5 text-xs font-bold text-black">Run Now</button>
                                <button type="button" data-del-cron="{{ $job['id'] }}" class="cursor-pointer rounded-full border border-white/15 px-3 py-1.5 text-xs text-stone-200">Hapus</button>
                            </div>
                        </div>
                        <div class="mt-2 overflow-x-auto rounded-lg bg-[#0a0a0a] p-2.5 font-mono text-xs text-white">$ {{ $job['command'] }}</div>
                        @if(!empty($job['last_output']))
                            <div class="mt-2 font-mono text-[11px] text-stone-500">Output: {{ \Illuminate\Support\Str::limit($job['last_output'], 200) }}</div>
                        @endif
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-white/15 p-8 text-center text-xs text-stone-500">Belum ada cron job. Buat yang pertama di form kiri.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section data-panel="nginx" class="hosting-panel hidden space-y-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="lg:col-span-2 rounded-2xl border border-white/10 bg-[#141414] p-5">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <h3 class="font-mono text-sm font-bold text-white">Nginx VHost Editor</h3>
                        <p class="font-mono text-[11px] text-stone-500">Path: {{ $overview['nginx']['configPath'] ?? '' }}</p>
                    </div>
                    <button type="button" id="btn-nginx-save" class="cursor-pointer rounded-full bg-white px-4 py-2 text-xs font-bold text-black hover:bg-stone-200">Simpan &amp; Reload</button>
                </div>
                <textarea id="nginx-editor" rows="18" spellcheck="false" class="mt-4 w-full rounded-xl border border-white/10 bg-[#0a0a0a] p-4 font-mono text-xs leading-relaxed text-white focus:border-white/30 focus:outline-none">{{ $overview['nginx']['currentConfig'] ?? '' }}</textarea>
                <p class="mt-2 text-[11px] text-stone-500">Disimpan lewat hosting-ctl dengan backup + nginx -t. Gagal validasi berarti tidak ter-deploy.</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-[#141414] p-5">
                <h3 class="font-mono text-sm font-bold text-white">Audit Logs</h3>
                <div id="audit-list-2" class="mt-3 max-h-100 space-y-2 overflow-y-auto pr-1">
                    @forelse($overview['activityLogs'] ?? [] as $log)
                        <div class="rounded-xl border border-white/10 bg-[#0a0a0a] p-3 font-mono text-xs">
                            <div class="flex items-center justify-between"><span class="font-bold text-white">[{{ $log['category'] ?? 'SYSTEM' }}]</span><span class="text-[10px] text-stone-500">{{ $log['timestamp'] ?? '' }}</span></div>
                            <div class="mt-1 font-semibold text-white">{{ $log['action'] }}</div>
                            <div class="text-stone-500">{{ $log['target'] ?? '—' }} &bull; {{ $log['result'] ?? '' }}</div>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-white/15 p-6 text-center text-xs text-stone-500">Audit kosong.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

</div>
@endsection

@push('admin_scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const overviewUrl = @json(route('admin.hosting.overview'));
    const toastEl = document.getElementById('toast');
    const skeleton = document.getElementById('hosting-skeleton');
    const errorBox = document.getElementById('hosting-error');
    const errorText = document.getElementById('hosting-error-text');
    let currentTab = document.getElementById('hosting-root')?.dataset.tab || 'cpanel';
    let fetching = false;
    let pollTimer = null;

    const tabs = [...document.querySelectorAll('.hosting-tab')];
    const panels = [...document.querySelectorAll('.hosting-panel')];

    function showToast(text, type = 'success') {
        toastEl.textContent = text;
        toastEl.className = 'fixed bottom-6 right-6 z-50 max-w-sm rounded-xl border px-4 py-3 shadow-2xl font-mono text-xs ' + (type === 'success' ? 'border-emerald-800 bg-emerald-950 text-emerald-200' : 'border-rose-800 bg-rose-950 text-rose-200');
        toastEl.classList.remove('hidden');
        setTimeout(() => toastEl.classList.add('hidden'), 4000);
    }

    function setTab(name) {
        currentTab = name;
        tabs.forEach((t) => {
            const active = t.dataset.tab === name;
            t.className = 'hosting-tab flex cursor-pointer items-center justify-center gap-1.5 rounded-lg px-2.5 py-1.5 font-mono text-xs font-semibold transition-all ' + (active ? 'bg-white text-black font-bold shadow-md shadow-black/40' : 'bg-white/5 border border-white/10 text-stone-400 hover:text-white hover:bg-white/10');
        });
        panels.forEach((p) => p.classList.toggle('hidden', p.dataset.panel !== name));
        try { history.replaceState(null, '', '?tab=' + name); } catch (e) {}
    }

    tabs.forEach((t) => t.addEventListener('click', () => setTab(t.dataset.tab)));
    document.querySelectorAll('[data-goto]').forEach((b) => b.addEventListener('click', () => setTab(b.dataset.goto)));
    setTab(currentTab);

    async function api(url, options = {}) {
        const res = await fetch(url, {
            ...options,
            headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, ...(options.headers || {}) },
            credentials: 'same-origin',
        });
        const data = await res.json().catch(() => ({}));
        if (!res.ok) throw new Error(data.message || 'Request gagal (' + res.status + ')');
        return data;
    }

    function formatUptime(seconds) {
        const n = Number(seconds) || 0;
        const d = Math.floor(n / 86400);
        const h = Math.floor((n % 86400) / 3600);
        const m = Math.floor((n % 3600) / 60);
        if (d > 0) return d + 'd ' + h + 'h ' + m + 'm';
        if (h > 0) return h + 'h ' + m + 'm';
        return m + 'm';
    }

    function renderOverview(data) {
        const server = data.server || {};
        const disks = server.disks?.[0] || {};
        const set = (id, text) => { const el = document.getElementById(id); if (el) el.textContent = text; };
        const setWidth = (id, val) => { const el = document.getElementById(id); if (el) el.style.width = Math.min(100, Math.max(0, Number(val) || 0)) + '%'; };

        set('strip-ip', server.sharedIp || '');
        set('strip-uptime', formatUptime(server.uptimeSeconds));
        set('stat-cpu', (server.cpuLoadPercent ?? 0) + '%');
        setWidth('bar-cpu', server.cpuLoadPercent);
        set('stat-cpu-detail', (server.cpuCores || 1) + ' cores');
        set('stat-ram', (server.memory?.percent ?? 0) + '%');
        setWidth('bar-ram', server.memory?.percent);
        set('stat-ram-detail', (server.memory?.usedMb ?? 0) + ' / ' + (server.memory?.totalMb ?? 0) + ' MB');
        set('stat-disk', (disks.usePercent ?? 0) + '%');
        setWidth('bar-disk', disks.usePercent);
        set('stat-disk-detail', (disks.usedGb ?? 0) + ' / ' + (disks.sizeGb ?? 0) + ' GB');

        const services = data.services || [];
        const running = services.filter((s) => s.status === 'running').length;
        set('stat-svc', running + '/' + services.length);
        setWidth('bar-svc', services.length ? (running / services.length) * 100 : 0);

        set('storage-os', server.distro || '');
        set('storage-kernel', server.kernel || '');
        set('storage-host', server.hostname || '');
        set('storage-ip', server.sharedIp || '');
        set('storage-cpu', (server.cpuLoadPercent ?? 0) + '%');
        set('storage-load', (server.loadAvg || []).join(' / '));
        set('storage-ram', (server.memory?.usedMb ?? 0) + ' MB');
        set('storage-disk', (disks.usePercent ?? 0) + '%');
        set('storage-disk-detail', (disks.usedGb ?? 0) + ' / ' + (disks.sizeGb ?? 0) + ' GB');
        set('storage-uptime', formatUptime(server.uptimeSeconds));

        const fw = data.firewall || {};
        const fwStatus = document.getElementById('fw-status');
        if (fwStatus) fwStatus.textContent = fw.enabled ? 'FIREWALL ACTIVE' : 'FIREWALL DISABLED / UFW tidak terinstall';
        const fwToggle = document.getElementById('btn-fw-toggle');
        if (fwToggle) fwToggle.textContent = fw.enabled ? 'Matikan Firewall' : 'Aktifkan Firewall';

        const nginxEditor = document.getElementById('nginx-editor');
        if (nginxEditor && data.nginx?.currentConfig && !nginxEditor.dataset.dirty) nginxEditor.value = data.nginx.currentConfig;
        const auditCount = document.getElementById('audit-count');
        if (auditCount) auditCount.textContent = (data.activityLogs?.length || 0) + ' log';

        const aa = data.aapanel || {};
        const aaBadge = document.getElementById('aapanel-badge');
        if (aaBadge) {
            aaBadge.textContent = aa.connected ? 'TERHUBUNG (' + (aa.version || 'Active') + ')' : 'STANDBY / OFFLINE';
            aaBadge.className = 'rounded-full px-2 py-0.5 text-[10px] font-bold ' + (aa.connected ? 'bg-emerald-950/60 text-emerald-300 border border-emerald-800/40' : 'bg-stone-800 text-stone-400');
        }
        const aaMsg = document.getElementById('aapanel-msg');
        if (aaMsg && aa.message) {
            aaMsg.textContent = aa.message;
        }

        renderDomains(data.domains || []);
        renderSinkholes(data.sinkholes || []);
    }

    function escHtml(s) {
        return String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    }

    function renderDomains(domains) {
        const body = document.getElementById('domains-body');
        if (!body) return;
        if (!domains.length) {
            body.innerHTML = '<tr><td colspan="5" class="px-4 py-8 text-center text-stone-500">Tidak ada vhost terbaca dari server.</td></tr>';
            return;
        }
        body.innerHTML = domains.map((d) => {
            const suspended = !!d.suspended;
            const badge = suspended
                ? '<span class="rounded-full bg-rose-950/60 px-2.5 py-0.5 text-[10px] font-bold text-rose-300 border border-rose-800/40">TER-SUSPEND (503)</span>'
                : '<span class="rounded-full bg-emerald-950/60 px-2.5 py-0.5 text-[10px] font-bold text-emerald-300 border border-emerald-800/40">ACTIVE</span>';

            const engineBadge = d.engine === 'aapanel'
                ? '<span class="rounded-full border border-purple-500/30 bg-purple-950/40 px-2 py-0.5 text-[10px] font-semibold text-purple-300">aaPanel</span>'
                : '<span class="rounded-full border border-sky-500/30 bg-sky-950/40 px-2 py-0.5 text-[10px] font-semibold text-sky-300">Nginx Native</span>';

            const action = d.canSuspend
                ? (suspended
                    ? '<button type="button" data-vhost-toggle="unsuspend" data-domain="' + escHtml(d.domain) + '" data-engine="' + escHtml(d.engine || 'nginx') + '" data-site-id="' + escHtml(d.siteId || '') + '" class="cursor-pointer rounded-full bg-white px-3.5 py-1 text-[11px] font-bold text-black hover:bg-stone-200">Hidupkan</button>'
                    : '<button type="button" data-vhost-toggle="suspend" data-domain="' + escHtml(d.domain) + '" data-engine="' + escHtml(d.engine || 'nginx') + '" data-site-id="' + escHtml(d.siteId || '') + '" class="cursor-pointer rounded-full border border-rose-800/60 bg-rose-950/30 px-3.5 py-1 text-[11px] font-bold text-rose-300 hover:bg-rose-900/40">Suspend</button>')
                : '<span class="rounded-full border border-white/10 px-3 py-1 text-[11px] text-stone-500" title="Domain utama dilindungi agar admin tidak lockout">Dilindungi</span>';

            const aliasesText = (d.aliases || []).length ? '<div class="text-[10px] text-stone-500">' + escHtml((d.aliases || []).join(', ')) + '</div>' : '';

            return '<tr class="border-b border-white/5 hover:bg-white/[0.02] transition-colors">' +
                '<td class="px-5 py-3.5"><div class="font-bold text-white">' + escHtml(d.domain) + '</div>' + aliasesText + '</td>' +
                '<td class="px-5 py-3.5">' + engineBadge + '</td>' +
                '<td class="max-w-60 truncate px-5 py-3.5 text-stone-400" title="' + escHtml(d.root || '') + '">' + escHtml(d.root || '—') + '</td>' +
                '<td class="px-5 py-3.5">' + badge + '</td>' +
                '<td class="px-5 py-3.5 text-right">' + action + '</td>' +
                '</tr>';
        }).join('');
    }

    function renderSinkholes(sinkholes) {
        const list = document.getElementById('sinkholes-list');
        if (!list) return;
        if (!sinkholes.length) {
            list.innerHTML = '<div class="rounded-xl border border-dashed border-white/15 p-6 text-center text-xs text-stone-500">Belum ada domain ter-suspend. Pakai tombol Suspend di tabel atau form di atas.</div>';
            return;
        }
        list.innerHTML = sinkholes.map((s) => '<div class="flex flex-wrap items-center justify-between gap-2 rounded-xl border border-white/10 bg-[#0a0a0a] p-3 font-mono text-xs"><span class="font-bold text-white">' + escHtml(s.domain) + ' &rarr; ' + escHtml(s.target_ip) + ' <span class="ml-1 rounded-full bg-rose-950/60 px-2 py-0.5 text-[10px] text-rose-300">TER-SUSPEND</span></span><button type="button" data-del-sinkhole="' + escHtml(s.domain) + '" class="cursor-pointer rounded-full bg-white px-3 py-1 text-xs font-bold text-black hover:bg-stone-200">Hidupkan</button></div>').join('');
    }

    async function refreshOverview(manual = false) {
        if (fetching) return;
        fetching = true;
        if (skeleton) skeleton.classList.remove('hidden');
        if (errorBox) errorBox.classList.add('hidden');
        const btn = document.getElementById('btn-refresh');
        const icon = document.getElementById('refresh-icon');
        if (manual && icon) icon.classList.add('animate-spin');
        try {
            const data = await api(overviewUrl);
            renderOverview(data);
            if (skeleton) skeleton.classList.add('hidden');
        } catch (err) {
            if (errorText) errorText.textContent = err.message || 'Gagal memuat data hosting.';
            errorBox?.classList.remove('hidden');
            skeleton?.classList.add('hidden');
        } finally {
            fetching = false;
            if (manual && icon) icon.classList.remove('animate-spin');
            if (btn) btn.disabled = false;
        }
    }

    function startPolling() {
        if (pollTimer) clearInterval(pollTimer);
        pollTimer = setInterval(() => { if (!document.hidden) refreshOverview(); }, 5000);
    }

    document.getElementById('btn-refresh')?.addEventListener('click', () => { refreshOverview(true); startPolling(); });
    document.getElementById('hosting-retry')?.addEventListener('click', () => refreshOverview(true));

    const heal = async () => {
        try { await api(@json(route('admin.hosting.services.heal')), { method: 'POST', body: '{}' }); showToast('Verify & Heal selesai.'); await refreshOverview(true); }
        catch (err) { showToast(err.message, 'error'); }
    };
    document.getElementById('btn-heal')?.addEventListener('click', heal);
    document.getElementById('btn-heal-2')?.addEventListener('click', heal);

    document.addEventListener('click', async (e) => {
        const svcBtn = e.target.closest('.svc-btn');
        if (svcBtn) {
            const id = svcBtn.dataset.service;
            const action = svcBtn.dataset.action;
            const isProtectedStop = action === 'stop' && svcBtn.dataset.protected === '1';
            if (isProtectedStop && !window.confirm('Stop service protected "' + id + '"? Panel ini akan terputus jika nginx/php-fpm/mariadb mati. Lanjut?')) return;
            svcBtn.disabled = true;
            try {
                const payload = { action, confirm: isProtectedStop ? 1 : 0 };
                const url = @json(route('admin.hosting.services.control', ['id' => '__ID__'])).replace('__ID__', encodeURIComponent(id));
                await api(url, { method: 'POST', body: JSON.stringify(payload) });
                showToast('Service ' + id + ' ' + action + ' berhasil.');
                await refreshOverview(true);
            } catch (err) { showToast(err.message, 'error'); }
            finally { svcBtn.disabled = false; }
        }
        const vhostToggleBtn = e.target.closest('[data-vhost-toggle]');
        if (vhostToggleBtn) {
            const action = vhostToggleBtn.dataset.vhostToggle;
            const domain = vhostToggleBtn.dataset.domain;
            const engine = vhostToggleBtn.dataset.engine || 'nginx';
            const siteId = vhostToggleBtn.dataset.siteId || '';

            const confirmMsg = action === 'suspend'
                ? 'Matikan (Suspend) website "' + domain + '"? Pengunjung akan dialihkan ke tampilan HTTP 503 Maintenance.'
                : 'Hidupkan kembali website "' + domain + '" ke kondisi normal?';

            if (!window.confirm(confirmMsg)) return;

            vhostToggleBtn.disabled = true;
            try {
                const url = @json(route('admin.hosting.vhosts.toggle', ['domain' => '__D__'])).replace('__D__', encodeURIComponent(domain));
                const res = await api(url, {
                    method: 'POST',
                    body: JSON.stringify({ action, engine, site_id: siteId })
                });
                showToast(res.message || ('Website ' + domain + ' berhasil di-' + action + '.'));
                await refreshOverview(true);
            } catch (err) {
                showToast(err.message, 'error');
            } finally {
                vhostToggleBtn.disabled = false;
            }
        }
        const suspBtn = e.target.closest('[data-suspend-domain]');
        if (suspBtn) {
            if (!window.confirm('Suspend ' + suspBtn.dataset.suspendDomain + ' di DNS lokal (LAN)? Panel tetap bisa dibuka via yuda.local untuk menghidupkan lagi.')) return;
            suspBtn.disabled = true;
            try {
                await api(@json(route('admin.hosting.sinkholes.store')), { method: 'POST', body: JSON.stringify({ domain: suspBtn.dataset.suspendDomain, target_ip: '0.0.0.0' }) });
                showToast(suspBtn.dataset.suspendDomain + ' di-suspend di DNS lokal.'); await refreshOverview(true);
            } catch (err) { showToast(err.message, 'error'); }
            finally { suspBtn.disabled = false; }
        }
        const unsuspBtn = e.target.closest('[data-unsuspend-domain]');
        if (unsuspBtn) {
            if (!window.confirm('Hidupkan ' + unsuspBtn.dataset.unsuspendDomain + ' lagi?')) return;
            unsuspBtn.disabled = true;
            try {
                const url = @json(route('admin.hosting.sinkholes.destroy', ['domain' => '__D__'])).replace('__D__', encodeURIComponent(unsuspBtn.dataset.unsuspendDomain));
                await api(url, { method: 'DELETE' });
                showToast(unsuspBtn.dataset.unsuspendDomain + ' dihidupkan lagi.'); await refreshOverview(true);
            } catch (err) { showToast(err.message, 'error'); }
            finally { unsuspBtn.disabled = false; }
        }
        const delSink = e.target.closest('[data-del-sinkhole]');
        if (delSink) {
            if (!window.confirm('Hidupkan ' + delSink.dataset.delSinkhole + ' lagi?')) return;
            try {
                const url = @json(route('admin.hosting.sinkholes.destroy', ['domain' => '__D__'])).replace('__D__', encodeURIComponent(delSink.dataset.delSinkhole));
                await api(url, { method: 'DELETE' });
                showToast(delSink.dataset.delSinkhole + ' dihidupkan lagi.'); await refreshOverview(true);
            } catch (err) { showToast(err.message, 'error'); }
        }
        const delDns = e.target.closest('[data-del-dns-zone]');
        if (delDns) {
            if (!window.confirm('Hapus record ' + delDns.dataset.delDnsName + ' (' + delDns.dataset.delDnsType + ')?')) return;
            try {
                await api(@json(route('admin.hosting.dns.destroy')), { method: 'DELETE', body: JSON.stringify({ zone: delDns.dataset.delDnsZone, name: delDns.dataset.delDnsName, type: delDns.dataset.delDnsType }) });
                showToast('Record DNS dihapus.'); await refreshOverview(true);
            } catch (err) { showToast(err.message, 'error'); }
        }
        const delFw = e.target.closest('[data-del-fw-port]');
        if (delFw) {
            if (!window.confirm('Hapus aturan firewall port ' + delFw.dataset.delFwPort + '?')) return;
            try {
                await api(@json(route('admin.hosting.firewall.destroy')), { method: 'DELETE', body: JSON.stringify({ port: delFw.dataset.delFwPort, protocol: delFw.dataset.delFwProtocol }) });
                showToast('Aturan firewall dihapus.'); await refreshOverview(true);
            } catch (err) { showToast(err.message, 'error'); }
        }
        const delDb = e.target.closest('[data-del-db]');
        if (delDb) {
            if (!window.confirm('Hapus database ' + delDb.dataset.delDb + '? Seluruh tabel akan hilang.')) return;
            try {
                await api(@json(route('admin.hosting.databases.destroy', ['name' => '__N__'])).replace('__N__', encodeURIComponent(delDb.dataset.delDb)), { method: 'DELETE' });
                showToast('Database dihapus.'); await refreshOverview(true);
            } catch (err) { showToast(err.message, 'error'); }
        }
        const runCron = e.target.closest('[data-run-cron]');
        if (runCron) {
            try {
                const url = @json(route('admin.hosting.cron.run', ['id' => '__ID__'])).replace('__ID__', encodeURIComponent(runCron.dataset.runCron));
                await api(url, { method: 'POST', body: '{}' });
                showToast('Cron dieksekusi.'); await refreshOverview(true);
            } catch (err) { showToast(err.message, 'error'); }
        }
        const delCron = e.target.closest('[data-del-cron]');
        if (delCron) {
            if (!window.confirm('Hapus cron job ini?')) return;
            try {
                const url = @json(route('admin.hosting.cron.destroy', ['id' => '__ID__'])).replace('__ID__', encodeURIComponent(delCron.dataset.delCron));
                await api(url, { method: 'DELETE' });
                showToast('Cron job dihapus.'); await refreshOverview(true);
            } catch (err) { showToast(err.message, 'error'); }
        }
    });

    document.getElementById('form-sinkhole')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const fd = new FormData(e.target);
        try {
            await api(@json(route('admin.hosting.sinkholes.store')), { method: 'POST', body: JSON.stringify({ domain: fd.get('domain'), target_ip: fd.get('target_ip') }) });
            showToast('Sinkhole ditambahkan ke BIND9 lokal.'); e.target.reset(); await refreshOverview(true);
        } catch (err) { showToast(err.message, 'error'); }
    });

    document.getElementById('form-dns')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const fd = new FormData(e.target);
        try {
            await api(@json(route('admin.hosting.dns.store')), { method: 'POST', body: JSON.stringify({ zone: fd.get('zone'), name: fd.get('name'), type: fd.get('type'), content: fd.get('content'), ttl: Number(fd.get('ttl')) }) });
            showToast('Record DNS disimpan.'); e.target.reset(); await refreshOverview(true);
        } catch (err) { showToast(err.message, 'error'); }
    });

    document.getElementById('form-fw')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const fd = new FormData(e.target);
        try {
            await api(@json(route('admin.hosting.firewall.store')), { method: 'POST', body: JSON.stringify({ port: fd.get('port'), protocol: fd.get('protocol'), action: fd.get('action'), source: fd.get('source'), service: fd.get('service') }) });
            showToast('Aturan firewall disimpan.'); e.target.reset(); await refreshOverview(true);
        } catch (err) { showToast(err.message, 'error'); }
    });

    document.getElementById('btn-fw-toggle')?.addEventListener('click', async () => {
        const enabledText = document.getElementById('fw-status')?.textContent || '';
        const enabled = !enabledText.includes('ACTIVE');
        if (!window.confirm((enabled ? 'Aktifkan' : 'Matikan') + ' firewall UFW?')) return;
        try {
            await api(@json(route('admin.hosting.firewall.toggle')), { method: 'POST', body: JSON.stringify({ enabled }) });
            showToast('Firewall ' + (enabled ? 'diaktifkan' : 'dinonaktifkan') + '.'); await refreshOverview(true);
        } catch (err) { showToast(err.message, 'error'); }
    });

    document.getElementById('form-cron')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const fd = new FormData(e.target);
        try {
            await api(@json(route('admin.hosting.cron.store')), { method: 'POST', body: JSON.stringify({ name: fd.get('name'), schedule: fd.get('schedule'), command: fd.get('command'), description: fd.get('description') }) });
            showToast('Cron job disimpan.'); e.target.reset(); await refreshOverview(true);
        } catch (err) { showToast(err.message, 'error'); }
    });

    document.getElementById('form-database')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const fd = new FormData(e.target);
        try {
            await api(@json(route('admin.hosting.databases.store')), { method: 'POST', body: JSON.stringify({ name: fd.get('name'), username: fd.get('username') }) });
            showToast('Database dibuat.'); e.target.reset(); await refreshOverview(true);
        } catch (err) { showToast(err.message, 'error'); }
    });

    document.getElementById('btn-backup')?.addEventListener('click', async () => {
        try { await api(@json(route('admin.hosting.databases.backup')), { method: 'POST', body: '{}' }); showToast('Snapshot backup dibuat.'); await refreshOverview(true); }
        catch (err) { showToast(err.message, 'error'); }
    });

    const nginxEditor = document.getElementById('nginx-editor');
    nginxEditor?.addEventListener('input', () => { nginxEditor.dataset.dirty = '1'; });
    document.getElementById('btn-nginx-save')?.addEventListener('click', async () => {
        if (!window.confirm('Simpan konfigurasi nginx ini dan reload? File asli akan dibackup dan divalidasi nginx -t.')) return;
        try {
            await api(@json(route('admin.hosting.nginx.save')), { method: 'POST', body: JSON.stringify({ content: nginxEditor.value }) });
            if (nginxEditor) delete nginxEditor.dataset.dirty;
            showToast('Nginx disimpan dan reload.'); await refreshOverview(true);
        } catch (err) { showToast(err.message, 'error'); }
    });

    refreshOverview(true);
    startPolling();
});
</script>
@endpush
