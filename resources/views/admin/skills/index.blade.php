@extends('layouts.admin')

@section('title', 'Kelola Skill Matrix - Admin Panel TKJ')
@section('page_title', 'Kelola Skill Matrix')

@section('admin_content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-stone-900 tracking-tight">Daftar Kompetensi &amp; Skill TKJ</h2>
            <p class="text-xs text-stone-500 font-mono mt-0.5">Kelola keahlian teknis jaringan, administrasi server, dan perangkat keras.</p>
        </div>

        <a href="{{ route('admin.skills.create') }}" class="btn-earth-green text-xs py-2.5 px-4.5 flex items-center gap-2 self-start sm:self-auto font-mono">
            <span>+ TAMBAH SKILL</span>
        </a>
    </div>

    <!-- Category Filter Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4 p-4 rounded-2xl bg-white border border-stone-200 shadow-xs font-mono text-xs">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.skills.index') }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ !request('category') || request('category') === 'all' ? 'text-white font-semibold shadow-xs' : 'bg-stone-100 border border-stone-200 text-stone-600 hover:bg-stone-200 hover:text-stone-900' }}"
               style="{{ !request('category') || request('category') === 'all' ? 'background-color: #0C382E;' : '' }}">
                Semua ({{ \App\Models\Skill::count() }})
            </a>
            <a href="{{ route('admin.skills.index', ['category' => 'networking']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('category') === 'networking' ? 'text-white font-semibold shadow-xs' : 'bg-stone-100 border border-stone-200 text-stone-600 hover:bg-stone-200 hover:text-stone-900' }}"
               style="{{ request('category') === 'networking' ? 'background-color: #0C382E;' : '' }}">
                Networking ({{ \App\Models\Skill::where('category', 'networking')->count() }})
            </a>
            <a href="{{ route('admin.skills.index', ['category' => 'sysadmin']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('category') === 'sysadmin' ? 'text-white font-semibold shadow-xs' : 'bg-stone-100 border border-stone-200 text-stone-600 hover:bg-stone-200 hover:text-stone-900' }}"
               style="{{ request('category') === 'sysadmin' ? 'background-color: #0C382E;' : '' }}">
                Sysadmin ({{ \App\Models\Skill::where('category', 'sysadmin')->count() }})
            </a>
            <a href="{{ route('admin.skills.index', ['category' => 'hardware']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('category') === 'hardware' ? 'text-white font-semibold shadow-xs' : 'bg-stone-100 border border-stone-200 text-stone-600 hover:bg-stone-200 hover:text-stone-900' }}"
               style="{{ request('category') === 'hardware' ? 'background-color: #0C382E;' : '' }}">
                Hardware ({{ \App\Models\Skill::where('category', 'hardware')->count() }})
            </a>
            <a href="{{ route('admin.skills.index', ['category' => 'tools']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('category') === 'tools' ? 'text-white font-semibold shadow-xs' : 'bg-stone-100 border border-stone-200 text-stone-600 hover:bg-stone-200 hover:text-stone-900' }}"
               style="{{ request('category') === 'tools' ? 'background-color: #0C382E;' : '' }}">
                Tools ({{ \App\Models\Skill::where('category', 'tools')->count() }})
            </a>
        </div>

        <form action="{{ route('admin.skills.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama skill..."
                   class="px-3.5 py-1.5 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 placeholder-stone-400 text-xs focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E]">
            <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-stone-100 border border-stone-200 text-stone-700 hover:bg-stone-200 text-xs font-medium transition-colors">
                Cari
            </button>
        </form>
    </div>

    <!-- Skills Table -->
    <div class="rounded-2xl border border-stone-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-mono text-xs">
                <thead>
                    <tr class="border-b border-stone-200 text-stone-600 bg-stone-50/80 font-bold">
                        <th class="py-3.5 px-4">NAMA KEAHLIAN / SKILL</th>
                        <th class="py-3.5 px-4">KATEGORI</th>
                        <th class="py-3.5 px-4">TINGKAT PENGUASAAN</th>
                        <th class="py-3.5 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($skills as $skill)
                        <tr class="hover:bg-stone-50/60 transition-colors">
                            <td class="py-3.5 px-4 font-bold text-stone-900 text-sm">
                                {{ $skill->name }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="badge-earth-brown uppercase">
                                    {{ $skill->category }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 w-64">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 bg-stone-100 rounded-full h-2 overflow-hidden">
                                        <div class="h-2 rounded-full" style="width: {{ $skill->level }}%; background-color: #0C382E;"></div>
                                    </div>
                                    <span class="font-bold text-stone-800 w-10 text-right">{{ $skill->level }}%</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.skills.edit', $skill->id) }}" class="px-2.5 py-1 rounded-lg bg-stone-100 border border-stone-200 text-stone-700 hover:bg-stone-200 hover:text-stone-900 transition-colors font-medium">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.skills.destroy', $skill->id) }}" method="POST" onsubmit="return confirm('Hapus skill {{ $skill->name }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 hover:bg-rose-100 transition-colors font-medium">
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
            <div class="p-4 border-t border-stone-200 bg-stone-50/50">
                {{ $skills->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
