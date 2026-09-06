@extends('layouts.app')

@section('title', 'Katalog Lab & Dokumentasi Proyek TKJ - Yuda Pratama')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-10 text-center sm:text-left">
            <div class="font-mono-code text-xs text-cyan-400 mb-2">// REPOSITORY_ARCHIVE</div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                Dokumentasi Lab &amp; Proyek Jaringan
            </h1>
            <p class="text-slate-400 text-sm mt-2 max-w-2xl">
                Daftar lengkap dokumentasi perancangan topologi, administrasi sistem Linux, konfigurasi router/switch, dan pengujian protokol jaringan.
            </p>
        </div>

        <!-- Filter & Search Bar -->
        <div class="p-6 rounded-2xl border border-slate-800 bg-slate-900/60 backdrop-blur-md mb-10">
            <form action="{{ route('projects.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                
                <!-- Search input -->
                <div class="md:col-span-6 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul lab, tools (e.g. MikroTik, OSPF, Nginx)..."
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 focus:outline-none focus:border-cyan-500 text-sm font-mono-code">
                </div>

                <!-- Category Select -->
                <div class="md:col-span-4">
                    <select name="category" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-slate-300 focus:outline-none focus:border-cyan-500 text-sm font-mono-code">
                        <option value="all">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="md:col-span-2 flex gap-2">
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-cyan-500 text-black font-bold font-mono-code text-xs hover:bg-cyan-400 transition-colors">
                        FILTER
                    </button>
                    @if(request('q') || request('category'))
                        <a href="{{ route('projects.index') }}" class="px-3 py-2.5 rounded-xl bg-slate-800 text-slate-400 hover:text-white font-mono-code text-xs flex items-center justify-center">
                            ✕
                        </a>
                    @endif
                </div>

            </form>
        </div>

        <!-- Project Grid -->
        @if($projects->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($projects as $project)
                    <div class="rounded-2xl border border-slate-800/80 bg-slate-900/50 overflow-hidden hover:border-cyan-500/50 hover:shadow-xl hover:shadow-cyan-950/20 transition-all flex flex-col group">
                        
                        <!-- Topology Graphic Header -->
                        <div class="relative h-48 bg-slate-950 overflow-hidden border-b border-slate-800 flex items-center justify-center p-2">
                            <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500">
                            
                            <div class="absolute top-3 left-3">
                                <span class="px-2 py-0.5 rounded bg-slate-900/90 border border-slate-700 text-cyan-400 font-mono-code text-[11px] font-semibold">
                                    {{ $project->category }}
                                </span>
                            </div>

                            @if($project->is_featured)
                                <div class="absolute top-3 right-3">
                                    <span class="px-2 py-0.5 rounded bg-amber-500/20 border border-amber-500/40 text-amber-300 font-mono-code text-[10px] font-bold">
                                        ★ FEATURED
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-white group-hover:text-cyan-300 transition-colors mb-2.5">
                                    <a href="{{ route('projects.show', $project->slug) }}">
                                        {{ $project->title }}
                                    </a>
                                </h3>

                                <p class="text-slate-400 text-xs line-clamp-3 mb-4 leading-relaxed">
                                    {{ Str::limit(strip_tags($project->description), 130) }}
                                </p>

                                <!-- Tools Tags -->
                                <div class="flex flex-wrap gap-1.5 mb-4">
                                    @foreach($project->tools_list as $tool)
                                        <span class="px-2 py-0.5 rounded bg-slate-950 border border-slate-800 text-[10px] text-slate-300 font-mono-code">
                                            {{ $tool }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between font-mono-code text-xs">
                                <span class="text-slate-500">{{ $project->created_at->format('d M Y') }}</span>
                                <a href="{{ route('projects.show', $project->slug) }}" class="inline-flex items-center gap-1 text-cyan-400 hover:text-cyan-300 font-semibold">
                                    <span>Detail Lab</span>
                                    <span>&rarr;</span>
                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $projects->links() }}
            </div>
        @else
            <div class="text-center py-20 rounded-2xl border border-slate-800/80 bg-slate-900/30 font-mono-code">
                <div class="text-4xl mb-3">🔍</div>
                <div class="text-white text-lg font-bold">TIDAK ADA PROYEK DITEMUKAN</div>
                <p class="text-slate-400 text-sm mt-1">Coba gunakan kata kunci pencarian lain atau pilih kategori Semua.</p>
                <a href="{{ route('projects.index') }}" class="inline-block mt-4 px-4 py-2 rounded-lg bg-cyan-500/10 border border-cyan-500/40 text-cyan-400 text-xs">
                    Reset Filter
                </a>
            </div>
        @endif

    </div>
</div>
@endsection
