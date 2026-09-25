@extends('layouts.app')

@section('title', 'Katalog Lab & Dokumentasi Proyek | I Made Yuda Pramana')

@section('content')
<div class="w-full py-8 sm:py-12 md:py-20 relative min-h-[85vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
        
        <!-- Header Title Section -->
        <div class="mb-10 sm:mb-14 md:mb-16 space-y-3 sm:space-y-4">
            <div class="inline-flex items-center gap-2 text-xs font-mono text-[#0C382E] bg-[#0C382E]/10 border border-[#0C382E]/20 px-3.5 py-1.5 rounded-full uppercase tracking-wider shadow-sm font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                <span>Arsitektur Jaringan &bull; Server &bull; Virtualisasi</span>
            </div>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black uppercase text-[#1C1917] tracking-tight leading-[1.1] text-balance">
                Dokumentasi lab dan proyek <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#0C382E] via-[#165B4C] to-[#9C6644]">nyata.</span>
            </h1>
            <p class="text-sm sm:text-base lg:text-lg text-stone-600 max-w-[58ch] text-balance leading-relaxed">
                Katalog utilitas sistem native, aplikasi mobile finansial, workbench visual front-end, dan administrasi server Linux berkinerja tinggi.
            </p>
        </div>

        <!-- Search and Filter Bar (Earth-tone) -->
        <div class="mb-10 sm:mb-14 p-4 sm:p-5 rounded-[28px] card-earth shadow-lg">
            <form action="{{ route('projects.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <label for="q" class="sr-only">Cari judul lab</label>
                    <input type="text" name="q" id="q" value="{{ request('q') }}" placeholder="Cari judul lab, teknologi (mis. OSPF, Nginx, VLAN)..."
                           class="w-full px-4 py-3 rounded-2xl bg-[#F8F5EE] border border-stone-300 text-[#1C1917] placeholder:text-stone-400 focus:outline-none focus:bg-white focus:border-[#0C382E] focus:ring-2 focus:ring-[#0C382E]/30 text-base sm:text-sm transition-all">
                </div>
                
                <div class="sm:w-64">
                    <label for="category" class="sr-only">Kategori</label>
                    <select name="category" id="category" class="w-full px-4 py-3 rounded-2xl bg-[#F8F5EE] border border-stone-300 text-[#1C1917] focus:outline-none focus:bg-white focus:border-[#0C382E] focus:ring-2 focus:ring-[#0C382E]/30 text-base sm:text-sm appearance-none cursor-pointer transition-all">
                        <option value="all" class="bg-white text-stone-900">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" class="bg-white text-stone-900" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="btn-earth-green shrink-0 text-xs font-bold uppercase tracking-wider py-3 px-6 rounded-full cursor-pointer flex items-center justify-center min-h-[44px]">
                    Filter Lab
                </button>
                @if(request('q') || request('category'))
                    <a href="{{ route('projects.index') }}" class="btn-earth-outline shrink-0 text-xs font-bold uppercase tracking-wider py-3 px-5 flex items-center justify-center min-h-[44px] rounded-full transition-all cursor-pointer">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Projects Grid -->
        @if($projects->count() > 0)
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($projects as $project)
                    <a href="{{ route('projects.show', $project->slug) }}" class="card-earth group block p-5 sm:p-6 rounded-[28px] flex flex-col justify-between shadow-md hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                        <div>
                            <div class="aspect-[16/10] bg-stone-100 border border-stone-200 rounded-2xl overflow-hidden mb-6 flex items-center justify-center p-6 relative">
                                <div class="absolute inset-0 bg-gradient-to-tr from-[#0C382E]/10 via-[#9C6644]/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500 ease-out">
                            </div>

                            <div class="flex items-center justify-between gap-3 mb-3">
                                <span class="badge-earth-green">
                                    {{ $project->category }}
                                </span>
                                <span class="text-xs text-stone-400 font-mono">
                                    {{ $project->created_at->format('M Y') }}
                                </span>
                            </div>

                            <h3 class="text-lg font-bold tracking-tight text-[#1C1917] mb-2 group-hover:text-[#0C382E] transition-colors leading-snug">
                                {{ $project->title }}
                            </h3>

                            <p class="text-stone-600 text-xs sm:text-sm line-clamp-2 leading-relaxed">
                                {{ Str::limit(strip_tags($project->description), 120) }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-stone-200 flex items-center justify-between text-xs font-bold uppercase tracking-wider text-stone-500 group-hover:text-[#0C382E] transition-colors">
                            <span>Buka Dokumentasi</span>
                            <span class="w-7 h-7 rounded-full bg-stone-100 text-stone-600 flex items-center justify-center group-hover:translate-x-1 group-hover:bg-[#0C382E] group-hover:text-white transition-all">&rarr;</span>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <div class="mt-16">
                {{ $projects->links() }}
            </div>
        @else
            <div class="py-24 text-center rounded-[32px] card-earth shadow-lg">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-[#0C382E]/10 border border-[#0C382E]/20 flex items-center justify-center text-[#0C382E]">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                @if(request('q') || request('category'))
                    <div class="text-[#1C1917] font-black uppercase tracking-tight text-lg mb-2">Tidak ada proyek yang sesuai dengan kriteria pencarian.</div>
                    <p class="text-stone-600 text-xs sm:text-sm max-w-sm mx-auto mb-6">Coba gunakan kata kunci lain atau reset filter kategori.</p>
                    <a href="{{ route('projects.index') }}" class="btn-earth-green inline-flex px-6 py-3 rounded-full text-xs font-bold uppercase tracking-wider transition-all">
                        Lihat semua lab
                    </a>
                @else
                    <div class="text-[#1C1917] font-black uppercase tracking-tight text-lg mb-2">Dokumentasi Lab Sedang Disiapkan</div>
                    <p class="text-stone-600 text-xs sm:text-sm max-w-sm mx-auto">Topologi arsitektur jaringan dan konfigurasi lab server sedang dalam tahap perancangan dan pengujian mandiri.</p>
                @endif
            </div>
        @endif

    </div>
</div>
@endsection
