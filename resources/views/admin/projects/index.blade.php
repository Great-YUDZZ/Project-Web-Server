@extends('layouts.admin')

@section('title', 'Kelola Proyek & Lab | Admin Panel TKJ')
@section('page_title', 'Kelola Proyek Lab')

@section('admin_content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold font-body text-white tracking-tight">Daftar Dokumentasi <span class="font-display font-semibold text-stone-300">Proyek Lab</span></h2>
            <p class="text-xs text-stone-400 font-body mt-0.5">Kelola dokumentasi lab, konfigurasi perangkat, dan diagram topologi jaringan.</p>
        </div>

        <a href="{{ route('admin.projects.create') }}" class="px-4.5 py-2.5 rounded-xl bg-white text-black text-xs font-body tracking-wider uppercase font-bold hover:bg-neutral-200 transition-all shadow-lg shadow-white/10 flex items-center gap-2 self-start sm:self-auto cursor-pointer">
            <span>+ TAMBAH PROYEK</span>
        </a>
    </div>

    <!-- Hero Information Guide Card -->
    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs font-body">
        <div class="flex items-center gap-2.5 text-stone-300">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]"></span>
            <span class="font-semibold text-white">Konfigurasi Header Hero Beranda:</span>
            <span class="text-stone-400">Header "Proyek Unggulan Terpilih" menampilkan 2 proyek teratas yang memiliki status <strong class="text-white">PIN HERO</strong>. Klik tombol status untuk mengubah secara instan.</span>
        </div>
        <span class="text-[10px] text-stone-500 shrink-0 font-mono">Urutan Berdasarkan Kolom [Order]</span>
    </div>

    <!-- Search / Filter -->
    <div class="p-4 rounded-2xl bg-[#141414] border border-white/10 shadow-xs">
        <form action="{{ route('admin.projects.index') }}" method="GET" class="flex gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul proyek, kategori, atau tools..."
                   class="flex-1 px-4 py-2 rounded-xl bg-[#0a0a0a] border border-white/15 text-white placeholder-stone-600 text-xs font-body focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 transition-all">
            <button type="submit" class="px-4 py-2 rounded-xl bg-white/10 border border-white/15 text-stone-200 hover:bg-white hover:text-black text-xs font-body font-medium transition-colors cursor-pointer">
                Cari
            </button>
            @if(request('q'))
                <a href="{{ route('admin.projects.index') }}" class="px-3 py-2 rounded-xl bg-white/5 border border-white/10 text-stone-400 hover:text-white text-xs font-body flex items-center justify-center">
                    ✕
                </a>
            @endif
        </form>
    </div>

    <!-- Projects Table -->
    <div class="rounded-2xl border border-white/10 bg-[#141414] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-body text-xs">
                <thead>
                    <tr class="border-b border-white/10 text-stone-400 bg-white/[0.04] font-semibold">
                        <th class="py-3.5 px-4">TOPOLOGI</th>
                        <th class="py-3.5 px-4">JUDUL PROYEK &amp; SLUG</th>
                        <th class="py-3.5 px-4">KATEGORI</th>
                        <th class="py-3.5 px-4 text-center">URUTAN</th>
                        <th class="py-3.5 px-4 text-center">HERO HEADER (PIN 2)</th>
                        <th class="py-3.5 px-4 text-center">SHOWCASE UNGGULAN</th>
                        <th class="py-3.5 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-stone-300">
                    @forelse($projects as $project)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="h-12 w-16 rounded-xl bg-[#0a0a0a] overflow-hidden border border-white/10 flex items-center justify-center">
                                    <img src="{{ $project->image_url }}" alt="" class="h-full w-full object-contain">
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-white text-sm hover:text-stone-300 transition-colors">
                                    <a href="{{ route('projects.show', $project->slug) }}" target="_blank">
                                        {{ $project->title }}
                                    </a>
                                </div>
                                <div class="text-[10px] text-stone-500 mt-0.5">/projects/{{ $project->slug }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-white/10 text-white border border-white/15">
                                    {{ $project->category }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-white/5 border border-white/10 text-stone-300 font-bold">
                                    #{{ $project->order }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <form action="{{ route('admin.projects.toggle-hero', $project->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    @if($project->is_hero)
                                        <button type="submit" title="Klik untuk melepas dari Hero Header" class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-white text-black border border-white hover:bg-neutral-200 transition-all flex items-center gap-1.5 mx-auto cursor-pointer shadow-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>PIN HERO</span>
                                        </button>
                                    @else
                                        <button type="submit" title="Klik untuk memin ke Hero Header" class="px-2.5 py-1 rounded-full text-[10px] font-medium bg-white/5 text-stone-400 border border-white/10 hover:bg-white/10 hover:text-white transition-colors mx-auto cursor-pointer">
                                            + Pin Hero
                                        </button>
                                    @endif
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <form action="{{ route('admin.projects.toggle-featured', $project->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    @if($project->is_featured)
                                        <button type="submit" title="Klik untuk mengubah menjadi reguler" class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/20 text-white border border-white/30 hover:bg-white/30 transition-all flex items-center gap-1 mx-auto cursor-pointer shadow-xs">
                                            ★ UNGGULAN
                                        </button>
                                    @else
                                        <button type="submit" title="Klik untuk menjadikan unggulan" class="px-2.5 py-1 rounded-full text-[10px] font-medium bg-white/5 text-stone-400 border border-white/10 hover:bg-white/10 hover:text-white transition-colors mx-auto cursor-pointer">
                                            Reguler
                                        </button>
                                    @endif
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/15 text-stone-300 hover:bg-white hover:text-black transition-colors font-medium">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek lab ini?');" class="inline">
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
                            <td colspan="7" class="text-center py-12 text-stone-500">
                                Belum ada proyek lab terdaftar. Klik "+ TAMBAH PROYEK" untuk menambahkan dokumentasi pertama.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($projects->hasPages())
            <div class="p-4 border-t border-white/10 bg-[#0d0d0d]">
                {{ $projects->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
