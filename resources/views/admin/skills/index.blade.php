@extends('layouts.admin')

@section('title', 'Kelola Skill Matrix | Admin Panel TKJ')
@section('page_title', 'Kelola Skill Matrix')

@section('admin_content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold font-body text-white tracking-tight">Daftar Kompetensi &amp; <span class="font-display italic font-normal text-stone-300">Skill Matrix</span></h2>
            <p class="text-xs text-stone-400 font-body mt-0.5">Kelola keahlian teknis jaringan, administrasi server, dan perangkat keras.</p>
        </div>

        <a href="{{ route('admin.skills.create') }}" class="px-4.5 py-2.5 rounded-xl bg-white text-black text-xs font-body tracking-wider uppercase font-bold hover:bg-neutral-200 transition-all shadow-lg shadow-white/10 flex items-center gap-2 self-start sm:self-auto cursor-pointer">
            <span>+ TAMBAH SKILL</span>
        </a>
    </div>

    <!-- Category Filter Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4 p-4 rounded-2xl bg-[#141414] border border-white/10 shadow-xs font-body text-xs">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.skills.index') }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ !request('category') || request('category') === 'all' ? 'bg-white text-black font-bold shadow-xs' : 'bg-white/5 border border-white/10 text-stone-400 hover:bg-white/10 hover:text-white' }}">
                Semua ({{ \App\Models\Skill::count() }})
            </a>
            <a href="{{ route('admin.skills.index', ['category' => 'networking']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('category') === 'networking' ? 'bg-white text-black font-bold shadow-xs' : 'bg-white/5 border border-white/10 text-stone-400 hover:bg-white/10 hover:text-white' }}">
                Networking ({{ \App\Models\Skill::where('category', 'networking')->count() }})
            </a>
            <a href="{{ route('admin.skills.index', ['category' => 'sysadmin']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('category') === 'sysadmin' ? 'bg-white text-black font-bold shadow-xs' : 'bg-white/5 border border-white/10 text-stone-400 hover:bg-white/10 hover:text-white' }}">
                Sysadmin ({{ \App\Models\Skill::where('category', 'sysadmin')->count() }})
            </a>
            <a href="{{ route('admin.skills.index', ['category' => 'hardware']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('category') === 'hardware' ? 'bg-white text-black font-bold shadow-xs' : 'bg-white/5 border border-white/10 text-stone-400 hover:bg-white/10 hover:text-white' }}">
                Hardware ({{ \App\Models\Skill::where('category', 'hardware')->count() }})
            </a>
            <a href="{{ route('admin.skills.index', ['category' => 'tools']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('category') === 'tools' ? 'bg-white text-black font-bold shadow-xs' : 'bg-white/5 border border-white/10 text-stone-400 hover:bg-white/10 hover:text-white' }}">
                Tools ({{ \App\Models\Skill::where('category', 'tools')->count() }})
            </a>
        </div>

        <form action="{{ route('admin.skills.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama skill..."
                   class="px-3.5 py-1.5 rounded-xl bg-[#0a0a0a] border border-white/15 text-white placeholder-stone-600 text-xs focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 transition-all font-body">
            <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-white/10 border border-white/15 text-stone-200 hover:bg-white hover:text-black text-xs font-medium transition-colors font-body cursor-pointer">
                Cari
            </button>
        </form>
    </div>

    <!-- Skills Table -->
    <div class="rounded-2xl border border-white/10 bg-[#141414] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-body text-xs">
                <thead>
                    <tr class="border-b border-white/10 text-stone-400 bg-white/[0.04] font-semibold">
                        <th class="py-3.5 px-4">NAMA KEAHLIAN / SKILL</th>
                        <th class="py-3.5 px-4">KATEGORI</th>
                        <th class="py-3.5 px-4">TINGKAT PENGUASAAN</th>
                        <th class="py-3.5 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-stone-300">
                    @forelse($skills as $skill)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-3.5 px-4 font-bold text-white text-sm">
                                {{ $skill->name }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-white/10 text-white border border-white/15 uppercase">
                                    {{ $skill->category }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 w-64">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 bg-white/10 rounded-full h-2 overflow-hidden">
                                        <div class="h-2 rounded-full bg-white shadow-[0_0_6px_rgba(255,255,255,0.6)]" style="width: {{ $skill->level }}%;"></div>
                                    </div>
                                    <span class="font-bold text-white w-10 text-right">{{ $skill->level }}%</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.skills.edit', $skill->id) }}" class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/15 text-stone-300 hover:bg-white hover:text-black transition-colors font-medium">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.skills.destroy', $skill->id) }}" method="POST" onsubmit="return confirm('Hapus skill {{ $skill->name }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-950/30 border border-rose-800/40 text-rose-300 hover:bg-rose-900/50 hover:text-white transition-colors font-medium cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-12 text-stone-500">
                                Belum ada skill yang terdaftar di kategori ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($skills->hasPages())
            <div class="p-4 border-t border-white/10 bg-[#0d0d0d]">
                {{ $skills->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
