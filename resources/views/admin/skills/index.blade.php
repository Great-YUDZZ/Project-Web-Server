@extends('layouts.admin')

@section('title', 'Kelola Skill Matrix - Admin Panel TKJ')
@section('page_title', 'Kelola Skill Matrix')

@section('admin_content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight">Daftar Kompetensi &amp; Skill TKJ</h2>
            <p class="text-xs text-slate-400 font-mono-code mt-0.5">Kelola keahlian teknis jaringan, administrasi server, dan perangkat keras.</p>
        </div>

        <a href="{{ route('admin.skills.create') }}" class="px-4 py-2.5 rounded-xl bg-emerald-500 text-black font-bold font-mono-code text-xs hover:bg-emerald-400 transition-colors flex items-center gap-2 self-start sm:self-auto">
            <span>+ TAMBAH SKILL</span>
        </a>
    </div>

    <!-- Category Filter Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4 p-4 rounded-xl bg-slate-950 border border-slate-800 font-mono-code text-xs">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.skills.index') }}" class="px-3 py-1.5 rounded-lg {{ !request('category') || request('category') === 'all' ? 'bg-cyan-500 text-black font-bold' : 'bg-slate-900 text-slate-300 hover:text-white' }}">
                Semua ({{ \App\Models\Skill::count() }})
            </a>
            <a href="{{ route('admin.skills.index', ['category' => 'networking']) }}" class="px-3 py-1.5 rounded-lg {{ request('category') === 'networking' ? 'bg-cyan-500 text-black font-bold' : 'bg-slate-900 text-slate-300 hover:text-white' }}">
                Networking ({{ \App\Models\Skill::where('category', 'networking')->count() }})
            </a>
            <a href="{{ route('admin.skills.index', ['category' => 'sysadmin']) }}" class="px-3 py-1.5 rounded-lg {{ request('category') === 'sysadmin' ? 'bg-cyan-500 text-black font-bold' : 'bg-slate-900 text-slate-300 hover:text-white' }}">
                Sysadmin ({{ \App\Models\Skill::where('category', 'sysadmin')->count() }})
            </a>
            <a href="{{ route('admin.skills.index', ['category' => 'hardware']) }}" class="px-3 py-1.5 rounded-lg {{ request('category') === 'hardware' ? 'bg-cyan-500 text-black font-bold' : 'bg-slate-900 text-slate-300 hover:text-white' }}">
                Hardware ({{ \App\Models\Skill::where('category', 'hardware')->count() }})
            </a>
            <a href="{{ route('admin.skills.index', ['category' => 'tools']) }}" class="px-3 py-1.5 rounded-lg {{ request('category') === 'tools' ? 'bg-cyan-500 text-black font-bold' : 'bg-slate-900 text-slate-300 hover:text-white' }}">
                Tools ({{ \App\Models\Skill::where('category', 'tools')->count() }})
            </a>
        </div>

        <form action="{{ route('admin.skills.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama skill..."
                   class="px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-800 text-white placeholder-slate-500 text-xs focus:outline-none focus:border-cyan-500">
            <button type="submit" class="px-3 py-1.5 rounded-lg bg-slate-800 text-slate-200 hover:text-white text-xs">
                Cari
            </button>
        </form>
    </div>

    <!-- Skills Table -->
    <div class="rounded-2xl border border-slate-800 bg-slate-950 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-mono-code text-xs">
                <thead>
                    <tr class="border-b border-slate-800 text-slate-400 bg-slate-900/50">
                        <th class="py-3 px-4">NAMA KEAHLIAN / SKILL</th>
                        <th class="py-3 px-4">KATEGORI</th>
                        <th class="py-3 px-4">TINGKAT PENGUASAAN</th>
                        <th class="py-3 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-850">
                    @forelse($skills as $skill)
                        <tr class="hover:bg-slate-900/40 transition-colors">
                            <td class="py-3.5 px-4 font-semibold text-white">
                                {{ $skill->name }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded border uppercase text-[10px] {{ $skill->category_badge_color }}">
                                    {{ $skill->category }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 w-64">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 bg-slate-900 rounded-full h-2 overflow-hidden border border-slate-800">
                                        <div class="h-2 rounded-full bg-gradient-to-r from-cyan-500 to-emerald-400" style="width: {{ $skill->level }}%"></div>
                                    </div>
                                    <span class="font-bold text-cyan-400 w-10 text-right">{{ $skill->level }}%</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.skills.edit', $skill->id) }}" class="px-2.5 py-1 rounded bg-slate-900 border border-slate-800 text-slate-300 hover:text-cyan-400 hover:border-cyan-500/50 transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.skills.destroy', $skill->id) }}" method="POST" onsubmit="return confirm('Hapus skill {{ $skill->name }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 rounded bg-rose-500/10 border border-rose-500/30 text-rose-400 hover:bg-rose-500 hover:text-white transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-10 text-slate-500">
                                Belum ada skill yang terdaftar di kategori ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($skills->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $skills->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
