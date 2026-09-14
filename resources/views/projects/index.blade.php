@extends('layouts.app')

@section('title', 'Katalog Lab & Dokumentasi Proyek | I Made Yuda Pramana')

@section('content')
<div class="w-full bg-[#F1F5F9] py-8 sm:py-12 md:py-20 relative border-b border-slate-200 min-h-[85vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        
        <!-- Header Title Section -->
        <div class="mb-10 sm:mb-14 md:mb-16 space-y-3 sm:space-y-4">
            <div class="inline-flex items-center gap-2 text-xs font-mono text-blue-600 uppercase tracking-wider">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                <span>Arsitektur Jaringan &bull; Server &bull; Virtualisasi</span>
            </div>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-bold text-slate-900 tracking-tight leading-[1.15] text-balance">
                Dokumentasi lab dan proyek <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-teal-600 to-blue-700">nyata.</span>
            </h1>
            <p class="text-sm sm:text-base lg:text-lg text-slate-600 max-w-[54ch] text-balance leading-relaxed">
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
                        <option value="all" class="bg-white text-slate-800">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" class="bg-white text-slate-800" {{ request('category') == $cat ? 'selected' : '' }}>
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
                            <div class="aspect-[16/10] bg-slate-50 border border-slate-200/80 rounded-2xl overflow-hidden mb-6 flex items-center justify-center p-6 relative">
                                <div class="absolute inset-0 bg-gradient-to-tr from-blue-600/10 via-teal-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500 ease-out">
                            </div>

                            <div class="flex items-center justify-between gap-3 mb-3">
                                <span class="px-2.5 py-0.5 rounded-full bg-blue-50 border border-blue-200 text-[11px] font-mono font-medium text-blue-700">
                                    {{ $project->category }}
                                </span>
                                <span class="text-xs text-slate-400 font-mono">
                                    {{ $project->created_at->format('M Y') }}
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition-colors">
                                {{ $project->title }}
                            </h3>

                            <p class="text-slate-600 text-xs sm:text-sm line-clamp-2 leading-relaxed">
                                {{ Str::limit(strip_tags($project->description), 120) }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-medium text-slate-600 group-hover:text-blue-600 transition-colors">
                            <span>Buka Dokumentasi</span>
                            <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center group-hover:translate-x-1 group-hover:bg-blue-600 group-hover:text-white transition-all">&rarr;</span>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <div class="mt-16">
                {{ $projects->links() }}
            </div>
        @else
            <div class="py-24 text-center rounded-3xl bg-white border border-slate-200 shadow-sm backdrop-blur-xl">
                <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-blue-50 border border-blue-200 flex items-center justify-center text-blue-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                @if(request('search') || request('category'))
                    <div class="text-slate-800 font-semibold mb-2">Tidak ada proyek yang sesuai dengan kriteria pencarian.</div>
                    <p class="text-slate-500 text-xs max-w-sm mx-auto mb-6">Coba gunakan kata kunci lain atau reset filter kategori.</p>
                    <a href="{{ route('projects.index') }}" class="btn-ghost text-xs">
                        Lihat semua lab
                    </a>
                @else
                    <div class="text-slate-800 font-semibold mb-2">Dokumentasi Lab Sedang Disiapkan</div>
                    <p class="text-slate-500 text-xs max-w-sm mx-auto">Topologi arsitektur jaringan dan konfigurasi lab server sedang dalam tahap perancangan dan pengujian mandiri.</p>
                @endif
            </div>
        @endif

    </div>
</div>
@endsection
