@extends('layouts.admin')

@section('title', 'Kelola Proyek & Lab - Admin Panel TKJ')
@section('page_title', 'Kelola Proyek Lab')

@section('admin_content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight">Daftar Dokumentasi Proyek</h2>
            <p class="text-xs text-slate-400 font-mono-code mt-0.5">Kelola dokumentasi lab, konfigurasi, dan file topologi jaringan.</p>
        </div>

        <a href="{{ route('admin.projects.create') }}" class="px-4 py-2.5 rounded-xl bg-cyan-500 text-black font-bold font-mono-code text-xs hover:bg-cyan-400 transition-colors flex items-center gap-2 self-start sm:self-auto">
            <span>+ TAMBAH PROYEK</span>
        </a>
    </div>

    <!-- Search / Filter -->
    <div class="p-4 rounded-xl bg-slate-950 border border-slate-800">
        <form action="{{ route('admin.projects.index') }}" method="GET" class="flex gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul proyek, kategori, atau tools..."
                   class="flex-1 px-4 py-2 rounded-lg bg-slate-900 border border-slate-800 text-white placeholder-slate-500 text-xs font-mono-code focus:outline-none focus:border-cyan-500">
            <button type="submit" class="px-4 py-2 rounded-lg bg-slate-800 text-slate-200 hover:text-white text-xs font-mono-code">
                Cari
            </button>
            @if(request('q'))
                <a href="{{ route('admin.projects.index') }}" class="px-3 py-2 rounded-lg bg-slate-900 text-slate-400 hover:text-white text-xs font-mono-code flex items-center justify-center">
                    ✕
                </a>
            @endif
        </form>
    </div>

    <!-- Projects Table -->
    <div class="rounded-2xl border border-slate-800 bg-slate-950 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-mono-code text-xs">
                <thead>
                    <tr class="border-b border-slate-800 text-slate-400 bg-slate-900/50">
                        <th class="py-3 px-4">TOPOLOGI</th>
                        <th class="py-3 px-4">JUDUL PROYEK &amp; SLUG</th>
                        <th class="py-3 px-4">KATEGORI</th>
                        <th class="py-3 px-4">TOOLS DIGUNAKAN</th>
                        <th class="py-3 px-4">STATUS</th>
                        <th class="py-3 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-850">
                    @forelse($projects as $project)
                        <tr class="hover:bg-slate-900/40 transition-colors">
                            <td class="py-3 px-4">
                                <div class="h-12 w-16 rounded bg-slate-900 overflow-hidden border border-slate-800 flex items-center justify-center">
                                    <img src="{{ $project->image_url }}" alt="" class="h-full w-full object-contain">
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-bold text-white text-sm hover:text-cyan-400">
                                    <a href="{{ route('projects.show', $project->slug) }}" target="_blank">
                                        {{ $project->title }}
                                    </a>
                                </div>
                                <div class="text-[10px] text-slate-500 mt-0.5">/projects/{{ $project->slug }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 rounded bg-slate-900 border border-slate-800 text-cyan-400 text-[10px]">
                                    {{ $project->category }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-slate-300 max-w-xs truncate">{{ $project->tools_used ?? '-' }}</div>
                            </td>
                            <td class="py-3 px-4">
                                @if($project->is_featured)
                                    <span class="px-2 py-0.5 rounded bg-amber-500/15 border border-amber-500/30 text-amber-300 text-[10px] font-bold">
                                        ★ UNGGULAN
                                    </span>
                                @else
                                    <span class="text-slate-500 text-[10px]">Reguler</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="px-2.5 py-1 rounded bg-slate-900 border border-slate-800 text-slate-300 hover:text-cyan-400 hover:border-cyan-500/50 transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek lab ini?');" class="inline">
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
                            <td colspan="6" class="text-center py-10 text-slate-500">
                                Belum ada proyek lab terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($projects->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $projects->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
