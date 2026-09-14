@extends('layouts.app')

@section('title', 'Katalog Lab & Dokumentasi Proyek | I Made Yuda Pramana')

@section('content')
<div class="w-full bg-[#0F172A] py-8 sm:py-12 md:py-20 relative border-b border-slate-800 min-h-[85vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        
        <!-- Header Title Section -->
        <div class="mb-10 sm:mb-14 md:mb-16 space-y-3 sm:space-y-4">
            <div class="inline-flex items-center gap-2 text-xs font-mono text-sky-400 uppercase tracking-wider">
                <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>
                <span>Arsitektur Jaringan &bull; Server &bull; Virtualisasi</span>
            </div>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-bold text-white tracking-tight leading-[1.15] text-balance">
                Dokumentasi lab dan proyek <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-sky-300 to-teal-400">nyata.</span>
            </h1>
            <p class="text-sm sm:text-base lg:text-lg text-slate-300 max-w-[54ch] text-balance leading-relaxed">
                Katalog topologi jaringan, administrasi server Linux Debian, konfigurasi perangkat jaringan Cisco, dan pengujian protokol routing berkinerja tinggi.
            </p>
        </div>

        <!-- Search and Filter Bar -->
        <div class="mb-10 sm:mb-14 p-3.5 sm:p-4 rounded-2xl bg-slate-900/90 border border-slate-800 shadow-xl">
            <form action="{{ route('projects.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <label for="q" class="sr-only">Cari judul lab</label>
                    <input type="text" name="q" id="q" value="{{ request('q') }}" placeholder="Cari judul lab, teknologi (mis. OSPF, Nginx, VLAN)..."
                           class="w-full px-4 py-3 rounded-xl bg-slate-950/80 border border-slate-700 text-white placeholder:text-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-base sm:text-sm transition-all">
                </div>
                
                <div class="sm:w-64">
                    <label for="category" class="sr-only">Kategori</label>
                    <select name="category" id="category" class="w-full px-4 py-3 rounded-xl bg-slate-950/80 border border-slate-700 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-base sm:text-sm appearance-none cursor-pointer transition-all">
                        <option value="all" class="bg-slate-900 text-white">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" class="bg-slate-900 text-white" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="w-full sm:w-auto shrink-0 text-xs font-semibold py-3 px-6 min-h-[44px] justify-center rounded-xl bg-blue-600 hover:bg-blue-500 text-white shadow-md shadow-blue-600/30 transition-all cursor-pointer flex items-center">
                    Filter Lab
                </button>
                @if(request('q') || request('category'))
                    <a href="{{ route('projects.index') }}" class="w-full sm:w-auto shrink-0 text-xs py-3 px-5 flex items-center justify-center min-h-[44px] rounded-xl border border-slate-700 text-slate-300 hover:text-white hover:bg-slate-800 transition-all cursor-pointer">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Projects Grid -->
        @if($projects->count() > 0)
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($projects as $project)
                    <a href="{{ route('projects.show', $project->slug) }}" class="group block p-5 sm:p-6 rounded-2xl bg-slate-900/90 border border-slate-800 hover:border-blue-500/50 flex flex-col justify-between shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div>
                            <div class="aspect-[16/10] bg-slate-950 border border-slate-800 rounded-2xl overflow-hidden mb-6 flex items-center justify-center p-6 relative">
                                <div class="absolute inset-0 bg-gradient-to-tr from-blue-600/20 via-teal-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500 ease-out">
                            </div>

                            <div class="flex items-center justify-between gap-3 mb-3">
                                <span class="px-2.5 py-0.5 rounded-full bg-blue-950/80 border border-blue-800 text-[11px] font-mono font-medium text-sky-300">
                                    {{ $project->category }}
                                </span>
                                <span class="text-xs text-slate-400 font-mono">
                                    {{ $project->created_at->format('M Y') }}
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-white mb-2 group-hover:text-sky-400 transition-colors">
                                {{ $project->title }}
                            </h3>

                            <p class="text-slate-300 text-xs sm:text-sm line-clamp-2 leading-relaxed">
                                {{ Str::limit(strip_tags($project->description), 120) }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-800 flex items-center justify-between text-xs font-medium text-slate-400 group-hover:text-sky-400 transition-colors">
                            <span>Buka Dokumentasi</span>
                            <span class="w-6 h-6 rounded-full bg-slate-800 text-slate-300 flex items-center justify-center group-hover:translate-x-1 group-hover:bg-blue-600 group-hover:text-white transition-all">&rarr;</span>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <div class="mt-16">
                {{ $projects->links() }}
            </div>
        @else
            <div class="py-24 text-center rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl backdrop-blur-xl">
                <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-blue-950 border border-blue-800 flex items-center justify-center text-sky-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                @if(request('search') || request('category'))
                    <div class="text-white font-semibold mb-2">Tidak ada proyek yang sesuai dengan kriteria pencarian.</div>
                    <p class="text-slate-400 text-xs max-w-sm mx-auto mb-6">Coba gunakan kata kunci lain atau reset filter kategori.</p>
                    <a href="{{ route('projects.index') }}" class="inline-flex px-5 py-2.5 rounded-xl border border-slate-700 text-slate-300 hover:text-white hover:bg-slate-800 text-xs transition-all">
                        Lihat semua lab
                    </a>
                @else
                    <div class="text-white font-semibold mb-2">Dokumentasi Lab Sedang Disiapkan</div>
                    <p class="text-slate-400 text-xs max-w-sm mx-auto">Topologi arsitektur jaringan dan konfigurasi lab server sedang dalam tahap perancangan dan pengujian mandiri.</p>
                @endif
            </div>
        @endif

    </div>
</div>
@endsection
