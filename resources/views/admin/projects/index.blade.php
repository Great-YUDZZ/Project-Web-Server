@extends('layouts.admin')

@section('title', 'Kelola Proyek & Lab - Admin Panel TKJ')
@section('page_title', 'Kelola Proyek Lab')

@section('admin_content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-stone-900 tracking-tight">Daftar Dokumentasi Proyek</h2>
            <p class="text-xs text-stone-500 font-mono mt-0.5">Kelola dokumentasi lab, konfigurasi perangkat, dan diagram topologi jaringan.</p>
        </div>

        <a href="{{ route('admin.projects.create') }}" class="btn-earth-green text-xs py-2.5 px-4.5 flex items-center gap-2 self-start sm:self-auto font-mono">
            <span>+ TAMBAH PROYEK</span>
        </a>
    </div>

    <!-- Hero Information Guide Card -->
    <div class="p-4 rounded-2xl bg-[#0C382E]/5 border border-[#0C382E]/20 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs font-mono">
        <div class="flex items-center gap-2.5 text-[#0C382E]">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 animate-pulse"></span>
            <span class="font-bold">Konfigurasi Header Hero Beranda:</span>
            <span class="text-stone-600">Header "Proyek Unggulan Terpilih" menampilkan 2 proyek teratas yang memiliki status <strong>PIN HERO</strong>. Klik tombol status untuk mengubah secara instan.</span>
        </div>
        <span class="text-[10px] text-stone-400 shrink-0">Urutan Berdasarkan Kolom [Order]</span>
    </div>

    <!-- Search / Filter -->
    <div class="p-4 rounded-2xl bg-white border border-stone-200 shadow-xs">
        <form action="{{ route('admin.projects.index') }}" method="GET" class="flex gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul proyek, kategori, atau tools..."
                   class="flex-1 px-4 py-2 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 placeholder-stone-400 text-xs font-mono focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E]">
            <button type="submit" class="px-4 py-2 rounded-xl bg-stone-100 border border-stone-200 text-stone-700 hover:bg-stone-200 text-xs font-mono font-medium transition-colors">
                Cari
            </button>
            @if(request('q'))
                <a href="{{ route('admin.projects.index') }}" class="px-3 py-2 rounded-xl bg-stone-100 border border-stone-200 text-stone-500 hover:text-stone-900 text-xs font-mono flex items-center justify-center">
                    ✕
                </a>
            @endif
        </form>
    </div>

    <!-- Projects Table -->
    <div class="rounded-2xl border border-stone-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-mono text-xs">
                <thead>
                    <tr class="border-b border-stone-200 text-stone-600 bg-stone-50/80 font-bold">
                        <th class="py-3.5 px-4">TOPOLOGI</th>
                        <th class="py-3.5 px-4">JUDUL PROYEK &amp; SLUG</th>
                        <th class="py-3.5 px-4">KATEGORI</th>
                        <th class="py-3.5 px-4 text-center">URUTAN</th>
                        <th class="py-3.5 px-4 text-center">HERO HEADER (PIN 2)</th>
                        <th class="py-3.5 px-4 text-center">SHOWCASE UNGGULAN</th>
                        <th class="py-3.5 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($projects as $project)
                        <tr class="hover:bg-stone-50/60 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="h-12 w-16 rounded-xl bg-stone-100 overflow-hidden border border-stone-200 flex items-center justify-center">
                                    <img src="{{ $project->image_url }}" alt="" class="h-full w-full object-contain">
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-stone-900 text-sm hover:text-[#0C382E] transition-colors">
                                    <a href="{{ route('projects.show', $project->slug) }}" target="_blank">
                                        {{ $project->title }}
                                    </a>
                                </div>
                                <div class="text-[10px] text-stone-500 mt-0.5">/projects/{{ $project->slug }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="badge-earth-green">
                                    {{ $project->category }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-stone-100 border border-stone-200 text-stone-700 font-bold">
                                    #{{ $project->order }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <form action="{{ route('admin.projects.toggle-hero', $project->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    @if($project->is_hero)
                                        <button type="submit" title="Klik untuk melepas dari Hero Header" class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300 hover:bg-emerald-200 transition-all flex items-center gap-1.5 mx-auto cursor-pointer shadow-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                            <span>PIN HERO</span>
                                        </button>
                                    @else
                                        <button type="submit" title="Klik untuk memin ke Hero Header" class="px-2.5 py-1 rounded-full text-[10px] font-medium bg-stone-100 text-stone-500 border border-stone-200 hover:bg-stone-200 transition-colors mx-auto cursor-pointer">
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
                                        <button type="submit" title="Klik untuk mengubah menjadi reguler" class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-300 hover:bg-amber-200 transition-all flex items-center gap-1 mx-auto cursor-pointer shadow-xs">
                                            ★ UNGGULAN
                                        </button>
                                    @else
                                        <button type="submit" title="Klik untuk menjadikan unggulan" class="px-2.5 py-1 rounded-full text-[10px] font-medium bg-stone-100 text-stone-500 border border-stone-200 hover:bg-stone-200 transition-colors mx-auto cursor-pointer">
                                            Reguler
                                        </button>
                                    @endif
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="px-2.5 py-1 rounded-lg bg-stone-100 border border-stone-200 text-stone-700 hover:bg-stone-200 hover:text-stone-900 transition-colors font-medium">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek lab ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 hover:bg-rose-100 transition-colors font-medium cursor-pointer">
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
            <div class="p-4 border-t border-stone-200 bg-stone-50/50">
                {{ $projects->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
