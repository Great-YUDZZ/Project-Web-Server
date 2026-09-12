@extends('layouts.admin')

@section('title', 'Kelola Proyek & Lab - Admin Panel TKJ')
@section('page_title', 'Kelola Proyek Lab')

@section('admin_content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight">Daftar Dokumentasi Proyek</h2>
            <p class="text-xs text-zinc-400 font-mono mt-0.5">Kelola dokumentasi lab, konfigurasi perangkat, dan diagram topologi jaringan.</p>
        </div>

        <a href="{{ route('admin.projects.create') }}" class="btn-primary text-xs py-2.5 px-4 flex items-center gap-2 self-start sm:self-auto">
            <span>+ TAMBAH PROYEK</span>
        </a>
    </div>

    <!-- Search / Filter -->
    <div class="p-4 rounded-2xl bg-[#0d0e14]/80 border border-white/[0.08] backdrop-blur-xl">
        <form action="{{ route('admin.projects.index') }}" method="GET" class="flex gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul proyek, kategori, atau tools..."
                   class="flex-1 px-4 py-2 rounded-xl bg-[#070709] border border-white/[0.08] text-white placeholder-zinc-500 text-xs font-mono focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500">
            <button type="submit" class="px-4 py-2 rounded-xl bg-white/[0.04] border border-white/[0.08] text-zinc-300 hover:text-white hover:bg-white/[0.08] text-xs font-mono transition-colors">
                Cari
            </button>
            @if(request('q'))
                <a href="{{ route('admin.projects.index') }}" class="px-3 py-2 rounded-xl bg-white/[0.04] border border-white/[0.08] text-zinc-400 hover:text-white text-xs font-mono flex items-center justify-center">
                    ✕
                </a>
            @endif
        </form>
    </div>

    <!-- Projects Table -->
    <div class="rounded-3xl border border-white/[0.08] bg-[#0d0e14]/80 backdrop-blur-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-mono text-xs">
                <thead>
                    <tr class="border-b border-white/[0.06] text-zinc-400 bg-white/[0.02]">
                        <th class="py-3.5 px-4">TOPOLOGI</th>
                        <th class="py-3.5 px-4">JUDUL PROYEK &amp; SLUG</th>
                        <th class="py-3.5 px-4">KATEGORI</th>
                        <th class="py-3.5 px-4">TOOLS DIGUNAKAN</th>
                        <th class="py-3.5 px-4">STATUS</th>
                        <th class="py-3.5 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.04]">
                    @forelse($projects as $project)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="h-12 w-16 rounded-xl bg-[#070709] overflow-hidden border border-white/[0.08] flex items-center justify-center">
                                    <img src="{{ $project->image_url }}" alt="" class="h-full w-full object-contain">
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-white text-sm hover:text-orange-400 transition-colors">
                                    <a href="{{ route('projects.show', $project->slug) }}" target="_blank">
                                        {{ $project->title }}
                                    </a>
                                </div>
                                <div class="text-[10px] text-zinc-500 mt-0.5">/projects/{{ $project->slug }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full bg-orange-500/10 border border-orange-500/20 text-orange-400 text-[10px] font-semibold">
                                    {{ $project->category }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="text-zinc-300 max-w-xs truncate">{{ $project->tools_used ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($project->is_featured)
                                    <span class="px-2.5 py-0.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-300 text-[10px] font-bold">
                                        ★ UNGGULAN
                                    </span>
                                @else
                                    <span class="text-zinc-500 text-[10px]">Reguler</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="px-2.5 py-1 rounded-lg bg-white/[0.04] border border-white/[0.08] text-zinc-300 hover:text-orange-400 hover:border-orange-500/30 transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek lab ini?');" class="inline">
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
                            <td colspan="6" class="text-center py-12 text-zinc-500">
                                Belum ada proyek lab terdaftar. Klik "+ TAMBAH PROYEK" untuk menambahkan dokumentasi pertama.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($projects->hasPages())
            <div class="p-4 border-t border-white/[0.06]">
                {{ $projects->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
