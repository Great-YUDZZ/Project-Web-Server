@extends('layouts.admin')

@section('title', 'Dashboard Overview - Admin Panel TKJ')
@section('page_title', 'Overview &amp; Metrics')

@section('admin_content')
<div class="space-y-8">
    
    <!-- Top Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 font-mono-code">
        
        <div class="p-5 rounded-2xl bg-slate-900/60 border border-slate-800 hover:border-cyan-500/40 transition-colors">
            <div class="flex justify-between items-start mb-2">
                <span class="text-xs text-slate-400">TOTAL PROYEK</span>
                <span class="p-1.5 rounded-lg bg-cyan-500/10 text-cyan-400 text-xs">LABS</span>
            </div>
            <div class="text-3xl font-black text-white">{{ $totalProjects }}</div>
            <div class="text-[11px] text-cyan-400 mt-2 flex items-center justify-between">
                <span>Dokumentasi Aktif</span>
                <a href="{{ route('admin.projects.index') }}" class="underline hover:text-white">&rarr; Kelola</a>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-slate-900/60 border border-slate-800 hover:border-emerald-500/40 transition-colors">
            <div class="flex justify-between items-start mb-2">
                <span class="text-xs text-slate-400">TOTAL SKILL</span>
                <span class="p-1.5 rounded-lg bg-emerald-500/10 text-emerald-400 text-xs">MATRIX</span>
            </div>
            <div class="text-3xl font-black text-white">{{ $totalSkills }}</div>
            <div class="text-[11px] text-emerald-400 mt-2 flex items-center justify-between">
                <span>Kompetensi Terdaftar</span>
                <a href="{{ route('admin.skills.index') }}" class="underline hover:text-white">&rarr; Kelola</a>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-slate-900/60 border border-slate-800 hover:border-amber-500/40 transition-colors">
            <div class="flex justify-between items-start mb-2">
                <span class="text-xs text-slate-400">PESAN MASUK</span>
                <span class="p-1.5 rounded-lg bg-amber-500/10 text-amber-400 text-xs">INBOX</span>
            </div>
            <div class="text-3xl font-black text-white">{{ $totalMessages }}</div>
            <div class="text-[11px] text-amber-400 mt-2 flex items-center justify-between">
                <span>Dari Pengunjung</span>
                <a href="{{ route('admin.messages.index') }}" class="underline hover:text-white">&rarr; Lihat</a>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-slate-900/60 border border-slate-800 hover:border-rose-500/40 transition-colors">
            <div class="flex justify-between items-start mb-2">
                <span class="text-xs text-slate-400">BELUM DIBACA</span>
                <span class="p-1.5 rounded-lg bg-rose-500/10 text-rose-400 text-xs">UNREAD</span>
            </div>
            <div class="text-3xl font-black {{ $unreadMessages > 0 ? 'text-rose-400' : 'text-white' }}">{{ $unreadMessages }}</div>
            <div class="text-[11px] text-rose-400 mt-2 flex items-center justify-between">
                <span>Perlu Tindakan</span>
                <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" class="underline hover:text-white">&rarr; Buka</a>
            </div>
        </div>

    </div>

    <!-- Quick Actions Bar -->
    <div class="p-5 rounded-2xl bg-slate-900/40 border border-slate-800 flex flex-wrap items-center justify-between gap-4 font-mono-code text-xs">
        <div class="flex items-center gap-2 text-slate-300">
            <span class="text-cyan-400 font-bold">&gt;_ QUICK_ACTIONS:</span>
            <span>Tambah data dan dokumentasi baru ke portofolio.</span>
        </div>
        <div class="flex flex-wrap gap-2.5">
            <a href="{{ route('admin.projects.create') }}" class="px-4 py-2 rounded-lg bg-cyan-500 text-black font-bold hover:bg-cyan-400 transition-colors">
                + Tambah Proyek Baru
            </a>
            <a href="{{ route('admin.skills.create') }}" class="px-4 py-2 rounded-lg bg-emerald-500 text-black font-bold hover:bg-emerald-400 transition-colors">
                + Tambah Skill Baru
            </a>
        </div>
    </div>

    <!-- Main Grid: Recent Projects & Recent Messages -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left: Recent Projects -->
        <div class="lg:col-span-7 rounded-2xl border border-slate-800 bg-slate-950 p-6 space-y-4">
            <div class="flex justify-between items-center border-b border-slate-800 pb-3">
                <h3 class="font-mono-code font-bold text-white text-sm flex items-center gap-2">
                    <span class="text-cyan-400">&gt;</span> DOKUMENTASI PROYEK TERBARU
                </h3>
                <a href="{{ route('admin.projects.index') }}" class="font-mono-code text-xs text-cyan-400 hover:text-cyan-300">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left font-mono-code text-xs">
                    <thead>
                        <tr class="border-b border-slate-800 text-slate-500">
                            <th class="py-2.5 px-3">JUDUL LAB</th>
                            <th class="py-2.5 px-3">KATEGORI</th>
                            <th class="py-2.5 px-3 text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-850">
                        @forelse($recentProjects as $p)
                            <tr class="hover:bg-slate-900/50">
                                <td class="py-3 px-3">
                                    <div class="font-semibold text-white truncate max-w-xs">{{ $p->title }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $p->created_at->format('d M Y') }}</div>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="px-2 py-0.5 rounded bg-slate-900 border border-slate-800 text-cyan-400 text-[10px]">
                                        {{ $p->category }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-right space-x-2">
                                    <a href="{{ route('admin.projects.edit', $p->id) }}" class="text-slate-400 hover:text-cyan-400">Edit</a>
                                    <a href="{{ route('projects.show', $p->slug) }}" target="_blank" class="text-slate-500 hover:text-white">&nearr;</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-6 text-slate-500">Belum ada proyek yang ditambahkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Recent Messages -->
        <div class="lg:col-span-5 rounded-2xl border border-slate-800 bg-slate-950 p-6 space-y-4">
            <div class="flex justify-between items-center border-b border-slate-800 pb-3">
                <h3 class="font-mono-code font-bold text-white text-sm flex items-center gap-2">
                    <span class="text-amber-400">&gt;</span> INBOX TERBARU
                </h3>
                <a href="{{ route('admin.messages.index') }}" class="font-mono-code text-xs text-amber-400 hover:text-amber-300">
                    Buka Inbox &rarr;
                </a>
            </div>

            <div class="space-y-3 font-mono-code text-xs">
                @forelse($recentMessages as $msg)
                    <div class="p-3.5 rounded-xl border {{ $msg->is_read ? 'border-slate-800/80 bg-slate-900/30' : 'border-cyan-500/30 bg-cyan-950/10' }} transition-colors">
                        <div class="flex justify-between items-start mb-1">
                            <span class="font-bold text-white truncate max-w-[150px]">{{ $msg->sender_name }}</span>
                            <span class="text-[10px] text-slate-500">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="text-slate-300 font-semibold truncate">{{ $msg->subject }}</div>
                        <div class="text-slate-400 text-[11px] line-clamp-1 mt-1">{{ $msg->message }}</div>
                        <div class="mt-2.5 pt-2 border-t border-slate-800/60 flex justify-between items-center text-[10px]">
                            <span class="{{ $msg->is_read ? 'text-slate-500' : 'text-cyan-400 font-bold' }}">
                                {{ $msg->is_read ? 'SUDAH DIBACA' : '● BELUM DIBACA' }}
                            </span>
                            <a href="{{ route('admin.messages.show', $msg->id) }}" class="text-cyan-400 hover:underline">
                                Buka Pesan &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-slate-500">
                        Belum ada pesan yang masuk.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
