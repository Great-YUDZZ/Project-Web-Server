@extends('layouts.app')

@section('title', 'Katalog Lab & Dokumentasi Proyek | I Made Yuda Pramana')

@section('content')
<div class="w-full py-8 sm:py-12 md:py-20 relative min-h-[85vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
        
        <!-- Bagian Judul Header Halaman Katalog -->
        <div class="mb-10 sm:mb-14 md:mb-16 space-y-3 sm:space-y-4">
            <div class="inline-flex items-center gap-2 text-xs font-mono text-white bg-white/10 border border-white/20 px-3.5 py-1.5 rounded-full uppercase tracking-wider shadow-sm font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                <span>Arsitektur Jaringan &bull; Server &bull; Virtualisasi</span>
            </div>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black uppercase text-[#f5f5f5] tracking-tight leading-[1.1] text-balance">
                Dokumentasi lab dan proyek <span class="font-display italic text-white font-normal">nyata.</span>
            </h1>
            <p class="text-sm sm:text-base lg:text-lg text-[#878787] max-w-[58ch] text-balance leading-relaxed font-light">
                Katalog utilitas sistem native, aplikasi mobile finansial, workbench visual front-end, dan administrasi server Linux berkinerja tinggi.
            </p>
        </div>

        <!-- Bilah Pencarian & Penyaring Kategori (Dark Monochrome) -->
        <div class="mb-10 sm:mb-14 p-4 sm:p-5 rounded-3xl bg-[#141414] border border-[#1f1f1f] shadow-2xl">
            <form action="{{ route('projects.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <label for="q" class="sr-only">Cari judul lab</label>
                    <input type="text" name="q" id="q" value="{{ request('q') }}" placeholder="Cari judul lab, teknologi (mis. OSPF, Nginx, VLAN)..."
                           class="w-full px-4 py-3 rounded-2xl bg-[#0e0e0e] border border-[#1f1f1f] text-[#f5f5f5] placeholder:text-[#525252] focus:outline-none focus:border-white focus:ring-2 focus:ring-white/20 text-base sm:text-sm transition-all">
                </div>
                
                <div class="sm:w-64">
                    <label for="category" class="sr-only">Kategori</label>
                    <select name="category" id="category" class="w-full px-4 py-3 rounded-2xl bg-[#0e0e0e] border border-[#1f1f1f] text-[#f5f5f5] focus:outline-none focus:border-white focus:ring-2 focus:ring-white/20 text-base sm:text-sm appearance-none cursor-pointer transition-all">
                        <option value="all" class="bg-[#141414] text-white">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" class="bg-[#141414] text-white" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="bg-white text-black hover:bg-neutral-200 shrink-0 text-xs font-bold uppercase tracking-wider py-3 px-7 rounded-full cursor-pointer flex items-center justify-center min-h-[44px] transition-all">
                    Filter Lab
                </button>
                @if(request('q') || request('category'))
                    <a href="{{ route('projects.index') }}" class="border border-[#2a2a2a] text-[#878787] hover:text-white hover:border-white shrink-0 text-xs font-bold uppercase tracking-wider py-3 px-6 flex items-center justify-center min-h-[44px] rounded-full transition-all cursor-pointer">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Kisi Daftar Proyek Lab -->
        @if($projects->count() > 0)
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($projects as $project)
                    <a href="{{ route('projects.show', $project->slug) }}" class="group block p-5 sm:p-6 rounded-[28px] bg-[#141414] border border-[#1f1f1f] flex flex-col justify-between shadow-xl hover:border-white/40 hover:-translate-y-1.5 transition-all duration-300">
                        <div>
                            <div class="aspect-[16/10] bg-[#0e0e0e] border border-[#1f1f1f] rounded-2xl overflow-hidden mb-6 flex items-center justify-center p-6 relative">
                                <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500 ease-out" loading="lazy">
                            </div>

                            <div class="flex items-center justify-between gap-3 mb-3">
                                <span class="px-2.5 py-1 rounded-full bg-white/10 border border-white/20 text-white text-[11px] font-mono">
                                    {{ $project->category }}
                                </span>
                                <span class="text-xs text-[#525252] font-mono">
                                    {{ $project->created_at->format('M Y') }}
                                </span>
                            </div>

                            <h3 class="text-lg font-bold tracking-tight text-[#f5f5f5] mb-2 group-hover:text-white transition-colors leading-snug">
                                {{ $project->title }}
                            </h3>

                            <p class="text-[#878787] text-xs sm:text-sm line-clamp-2 leading-relaxed">
                                {{ Str::limit(strip_tags($project->description), 120) }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-[#1f1f1f] flex items-center justify-between text-xs font-mono text-[#878787] group-hover:text-white transition-colors">
                            <span>Buka Dokumentasi</span>
                            <span class="text-sm font-semibold transition-transform group-hover:translate-x-1 duration-200">&rarr;</span>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <div class="mt-16">
                {{ $projects->links() }}
            </div>
        @else
            <div class="py-24 text-center rounded-[32px] bg-[#141414] border border-[#1f1f1f] shadow-xl">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-[#f5f5f5] mb-1">Tidak Ada Lab Ditemukan</h3>
                <p class="text-xs text-[#878787] max-w-sm mx-auto mb-6">
                    Tidak ditemukan proyek lab yang sesuai dengan kata kunci atau filter yang Anda pilih.
                </p>
                <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-white text-black hover:bg-neutral-200 text-xs font-bold transition-all">
                    Reset Filter Pencarian
                </a>
            </div>
        @endif

    </div>
</div>
@endsection
