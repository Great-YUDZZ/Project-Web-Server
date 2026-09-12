@extends('layouts.app')

@section('title', 'Katalog Lab & Dokumentasi Proyek | I Made Yuda Pramana')

@section('content')
<div class="px-4 sm:px-6 py-8 sm:py-12 md:py-20 relative">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header Title Section -->
        <div class="mb-10 sm:mb-14 md:mb-16 space-y-3 sm:space-y-4">
            <div class="inline-flex items-center gap-2 text-xs font-mono text-rose-400 uppercase tracking-wider">
                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                <span>Arsitektur Jaringan &bull; Server &bull; Virtualisasi</span>
            </div>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-bold text-white tracking-tight leading-[1.15] text-balance">
                Dokumentasi lab dan proyek <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-rose-400 to-red-400">nyata.</span>
            </h1>
            <p class="text-sm sm:text-base lg:text-lg text-zinc-400 max-w-[54ch] text-balance leading-relaxed">
                Katalog topologi jaringan, administrasi server Linux Debian, konfigurasi perangkat jaringan Cisco, dan pengujian protokol routing berkinerja tinggi.
            </p>
        </div>

        <!-- Search and Filter Bar -->
        <div class="mb-10 sm:mb-14 p-3.5 sm:p-4 rounded-2xl glass-panel">
            <form action="{{ route('projects.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <label for="q" class="sr-only">Cari judul lab</label>
                    <input type="text" name="q" id="q" value="{{ request('q') }}" placeholder="Cari judul lab, teknologi (mis. OSPF, Nginx, VLAN)..."
                           class="glass-input text-base sm:text-sm">
                </div>
                
                <div class="sm:w-64">
                    <label for="category" class="sr-only">Kategori</label>
                    <select name="category" id="category" class="glass-input text-base sm:text-sm appearance-none cursor-pointer">
                        <option value="all" class="bg-[#0c0d18] text-white">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" class="bg-[#0c0d18] text-white" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="btn-primary w-full sm:w-auto shrink-0 text-xs font-semibold py-3 px-6 min-h-[44px] justify-center">
                    Filter Lab
                </button>
                @if(request('q') || request('category'))
                    <a href="{{ route('projects.index') }}" class="btn-ghost w-full sm:w-auto shrink-0 text-xs py-3 px-5 flex items-center justify-center min-h-[44px]">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Projects Grid -->
        @if($projects->count() > 0)
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($projects as $project)
                    <a href="{{ route('projects.show', $project->slug) }}" class="card-interactive group block p-5 sm:p-6 flex flex-col justify-between">
                        <div>
                            <div class="aspect-[16/10] bg-[#08080d] border border-white/[0.08] rounded-2xl overflow-hidden mb-6 flex items-center justify-center p-6 relative">
                                <div class="absolute inset-0 bg-gradient-to-tr from-rose-600/15 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500 ease-out">
                            </div>

                            <div class="flex items-center justify-between gap-3 mb-3">
                                <span class="px-2.5 py-0.5 rounded-full bg-rose-500/10 border border-rose-500/20 text-[11px] font-mono font-medium text-rose-400">
                                    {{ $project->category }}
                                </span>
                                <span class="text-xs text-zinc-500 font-mono">
                                    {{ $project->created_at->format('M Y') }}
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-white mb-2 group-hover:text-rose-400 transition-colors">
                                {{ $project->title }}
                            </h3>

                            <p class="text-zinc-400 text-xs sm:text-sm line-clamp-2 leading-relaxed">
                                {{ Str::limit(strip_tags($project->description), 120) }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-white/[0.06] flex items-center justify-between text-xs font-medium text-zinc-400 group-hover:text-rose-400 transition-colors">
                            <span>Buka Dokumentasi</span>
                            <span class="w-5 h-5 rounded-full bg-white/[0.04] flex items-center justify-center group-hover:translate-x-1 group-hover:bg-rose-600 group-hover:text-white transition-all">&rarr;</span>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <div class="mt-16">
                {{ $projects->links() }}
            </div>
        @else
            <div class="py-24 text-center rounded-3xl bg-[#0c0c12]/60 border border-white/[0.06] backdrop-blur-xl">
                <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                @if(request('search') || request('category'))
                    <div class="text-zinc-300 font-semibold mb-2">Tidak ada proyek yang sesuai dengan kriteria pencarian.</div>
                    <p class="text-zinc-500 text-xs max-w-sm mx-auto mb-6">Coba gunakan kata kunci lain atau reset filter kategori.</p>
                    <a href="{{ route('projects.index') }}" class="btn-ghost text-xs">
                        Lihat semua lab
                    </a>
                @else
                    <div class="text-zinc-300 font-semibold mb-2">Dokumentasi Lab Sedang Disiapkan</div>
                    <p class="text-zinc-500 text-xs max-w-sm mx-auto">Topologi arsitektur jaringan dan konfigurasi lab server sedang dalam tahap perancangan dan pengujian mandiri.</p>
                @endif
            </div>
        @endif

    </div>
</div>
@endsection
