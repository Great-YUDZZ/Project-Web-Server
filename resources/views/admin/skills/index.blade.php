@extends('layouts.admin')

@section('title', 'Kelola Skill Matrix - Admin Panel TKJ')
@section('page_title', 'Kelola Skill Matrix')

@section('admin_content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight">Daftar Kompetensi &amp; Skill TKJ</h2>
            <p class="text-xs text-zinc-400 font-mono mt-0.5">Kelola keahlian teknis jaringan, administrasi server, dan perangkat keras.</p>
        </div>

        <a href="{{ route('admin.skills.create') }}" class="btn-primary text-xs py-2.5 px-4 flex items-center gap-2 self-start sm:self-auto">
            <span>+ TAMBAH SKILL</span>
        </a>
    </div>

    <!-- Category Filter Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4 p-4 rounded-2xl bg-[#0d0e14]/80 border border-white/[0.08] backdrop-blur-xl font-mono text-xs">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.skills.index') }}" class="px-3 py-1.5 rounded-xl transition-all {{ !request('category') || request('category') === 'all' ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white font-semibold shadow-md shadow-orange-500/20' : 'bg-white/[0.04] border border-white/[0.08] text-zinc-400 hover:text-white hover:bg-white/[0.08]' }}">
                Semua ({{ \App\Models\Skill::count() }})
            </a>
            <a href="{{ route('admin.skills.index', ['category' => 'networking']) }}" class="px-3 py-1.5 rounded-xl transition-all {{ request('category') === 'networking' ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white font-semibold shadow-md shadow-orange-500/20' : 'bg-white/[0.04] border border-white/[0.08] text-zinc-400 hover:text-white hover:bg-white/[0.08]' }}">
                Networking ({{ \App\Models\Skill::where('category', 'networking')->count() }})
            </a>
            <a href="{{ route('admin.skills.index', ['category' => 'sysadmin']) }}" class="px-3 py-1.5 rounded-xl transition-all {{ request('category') === 'sysadmin' ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white font-semibold shadow-md shadow-orange-500/20' : 'bg-white/[0.04] border border-white/[0.08] text-zinc-400 hover:text-white hover:bg-white/[0.08]' }}">
                Sysadmin ({{ \App\Models\Skill::where('category', 'sysadmin')->count() }})
            </a>
            <a href="{{ route('admin.skills.index', ['category' => 'hardware']) }}" class="px-3 py-1.5 rounded-xl transition-all {{ request('category') === 'hardware' ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white font-semibold shadow-md shadow-orange-500/20' : 'bg-white/[0.04] border border-white/[0.08] text-zinc-400 hover:text-white hover:bg-white/[0.08]' }}">
                Hardware ({{ \App\Models\Skill::where('category', 'hardware')->count() }})
            </a>
            <a href="{{ route('admin.skills.index', ['category' => 'tools']) }}" class="px-3 py-1.5 rounded-xl transition-all {{ request('category') === 'tools' ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white font-semibold shadow-md shadow-orange-500/20' : 'bg-white/[0.04] border border-white/[0.08] text-zinc-400 hover:text-white hover:bg-white/[0.08]' }}">
                Tools ({{ \App\Models\Skill::where('category', 'tools')->count() }})
            </a>
        </div>

        <form action="{{ route('admin.skills.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama skill..."
                   class="px-3 py-1.5 rounded-xl bg-[#070709] border border-white/[0.08] text-white placeholder-zinc-500 text-xs focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500">
            <button type="submit" class="px-3 py-1.5 rounded-xl bg-white/[0.04] border border-white/[0.08] text-zinc-300 hover:text-white text-xs transition-colors">
                Cari
            </button>
        </form>
    </div>

    <!-- Skills Table -->
    <div class="rounded-3xl border border-white/[0.08] bg-[#0d0e14]/80 backdrop-blur-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-mono text-xs">
                <thead>
                    <tr class="border-b border-white/[0.06] text-zinc-400 bg-white/[0.02]">
                        <th class="py-3.5 px-4">NAMA KEAHLIAN / SKILL</th>
                        <th class="py-3.5 px-4">KATEGORI</th>
                        <th class="py-3.5 px-4">TINGKAT PENGUASAAN</th>
                        <th class="py-3.5 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.04]">
                    @forelse($skills as $skill)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-3.5 px-4 font-semibold text-white">
                                {{ $skill->name }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full border uppercase text-[10px] bg-orange-500/10 border-orange-500/20 text-orange-400 font-semibold">
                                    {{ $skill->category }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 w-64">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 bg-white/[0.05] rounded-full h-2 overflow-hidden">
                                        <div class="h-2 rounded-full bg-gradient-to-r from-orange-500 to-amber-400" style="width: {{ $skill->level }}%"></div>
                                    </div>
                                    <span class="font-bold text-orange-400 w-10 text-right">{{ $skill->level }}%</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.skills.edit', $skill->id) }}" class="px-2.5 py-1 rounded-lg bg-white/[0.04] border border-white/[0.08] text-zinc-300 hover:text-orange-400 hover:border-orange-500/30 transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.skills.destroy', $skill->id) }}" method="POST" onsubmit="return confirm('Hapus skill {{ $skill->name }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-500/10 border border-rose-500/20 text-rose-400 hover:bg-rose-500 hover:text-white transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-12 text-zinc-500">
                                Belum ada skill yang terdaftar di kategori ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($skills->hasPages())
            <div class="p-4 border-t border-white/[0.06]">
                {{ $skills->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
