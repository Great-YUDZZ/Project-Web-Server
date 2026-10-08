@extends('layouts.app')

@section('title', 'Jurnal Rekayasa & Blog Pribadi | I Made Yuda Pramana')

@section('content')
<div class="w-full py-8 sm:py-12 md:py-20 relative min-h-[85vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">

        <!-- Header Section -->
        <div class="mb-10 sm:mb-14 md:mb-16 space-y-3 sm:space-y-4">
            <div class="inline-flex items-center gap-2 text-xs font-mono text-white bg-white/10 border border-white/20 px-3.5 py-1.5 rounded-full uppercase tracking-wider shadow-sm font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                <span>Jurnal Teknis &bull; Arsitektur &bull; Catatan Lab</span>
            </div>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black uppercase text-[#f5f5f5] tracking-tight leading-[1.1] text-balance">
                Catatan rekayasa dan pemikiran <span class="font-display italic text-white font-normal">sistem.</span>
            </h1>
            <p class="text-sm sm:text-base lg:text-lg text-[#878787] max-w-[62ch] text-balance leading-relaxed font-light">
                Dokumentasi eksplorasi mendalam seputar administrasi server Linux Debian, protokol jaringan deterministik, containerization, dan keandalan infrastruktur server.
            </p>
        </div>

        <!-- Search and Category Filters -->
        <div class="mb-10 sm:mb-14 p-4 sm:p-5 rounded-3xl bg-[#141414] border border-[#1f1f1f] shadow-2xl">
            <form action="{{ route('blog.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <label for="q" class="sr-only">Cari artikel</label>
                    <input type="text" name="q" id="q" value="{{ request('q') }}" placeholder="Cari topik, protokol, konfigurasi (mis. OSPF, Nginx, Debian, BGP)..."
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
                    Saring Artikel
                </button>
                @if(request('q') || (request('category') && request('category') !== 'all'))
                    <a href="{{ route('blog.index') }}" class="border border-[#2a2a2a] text-[#878787] hover:text-white hover:border-white shrink-0 text-xs font-bold uppercase tracking-wider py-3 px-6 flex items-center justify-center min-h-[44px] rounded-full transition-all cursor-pointer">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Featured Post Hero Card -->
        @if($featuredPost && !request('q') && (!request('category') || request('category') === 'all'))
            <div class="mb-12 sm:mb-16">
                <div class="p-6 sm:p-10 rounded-[32px] bg-gradient-to-br from-[#161616] to-[#0f0f0f] border border-white/15 shadow-2xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-96 h-96 bg-white/[0.03] rounded-full blur-3xl pointer-events-none -mr-20 -mt-20"></div>

                    <div class="relative z-10 flex flex-col justify-between">
                        <div>
                            <div class="flex flex-wrap items-center gap-3 mb-4">
                                <span class="px-3 py-1 rounded-full bg-white text-black text-xs font-bold font-mono uppercase tracking-wider">
                                    Artikel Utama
                                </span>
                                <span class="px-2.5 py-1 rounded-full bg-white/10 border border-white/20 text-white text-xs font-mono">
                                    {{ $featuredPost->category }}
                                </span>
                                <span class="text-xs text-[#878787] font-mono">
                                    {{ $featuredPost->published_at ? $featuredPost->published_at->format('d M Y') : $featuredPost->created_at->format('d M Y') }}
                                </span>
                                <span class="text-[#4D4D4D] font-mono">&bull;</span>
                                <span class="text-xs text-[#878787] font-mono flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $featuredPost->reading_time }} mnt baca
                                </span>
                                <span class="text-[#4D4D4D] font-mono">&bull;</span>
                                <span class="text-xs text-[#878787] font-mono">
                                    {{ number_format($featuredPost->views_count) }} tayangan
                                </span>
                            </div>

                            <h2 class="text-2xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-white mb-4 group-hover:text-stone-200 transition-colors leading-[1.15]">
                                <a href="{{ route('blog.show', $featuredPost->slug) }}">
                                    {{ $featuredPost->title }}
                                </a>
                            </h2>

                            <p class="text-[#a3a3a3] text-sm sm:text-base lg:text-lg max-w-4xl leading-relaxed mb-6 font-light">
                                {{ $featuredPost->excerpt }}
                            </p>

                            @if($featuredPost->tags_list)
                                <div class="flex flex-wrap gap-2 mb-6">
                                    @foreach($featuredPost->tags_list as $tag)
                                        <span class="px-2.5 py-0.5 rounded-lg bg-white/5 border border-white/10 text-stone-300 text-[11px] font-mono">
                                            #{{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="pt-6 border-t border-[#262626] flex items-center justify-between">
                            <a href="{{ route('blog.show', $featuredPost->slug) }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wider text-white hover:text-stone-300 transition-colors group-hover:translate-x-1 duration-200">
                                <span>Baca Artikel Lengkap</span>
                                <span>&rarr;</span>
                            </a>
                            <span class="text-[11px] font-mono text-[#525252]">RFC &bull; Technical Paper</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Grid of Blog Posts -->
        @if($posts->count() > 0)
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($posts as $post)
                    <article class="group p-6 rounded-[28px] bg-[#141414] border border-[#1f1f1f] flex flex-col justify-between shadow-xl hover:border-white/40 hover:-translate-y-1.5 transition-all duration-300">
                        <div>
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <span class="px-2.5 py-1 rounded-full bg-white/10 border border-white/20 text-white text-[11px] font-mono">
                                    {{ $post->category }}
                                </span>
                                <div class="flex items-center gap-2 text-[11px] text-[#525252] font-mono">
                                    <span>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $post->reading_time }} mnt</span>
                                </div>
                            </div>

                            <h3 class="text-lg sm:text-xl font-bold tracking-tight text-[#f5f5f5] mb-3 group-hover:text-white transition-colors leading-snug">
                                <a href="{{ route('blog.show', $post->slug) }}" class="focus:outline-none focus:underline">
                                    {{ $post->title }}
                                </a>
                            </h3>

                            <p class="text-[#878787] text-xs sm:text-sm line-clamp-3 leading-relaxed mb-4 font-light">
                                {{ $post->excerpt }}
                            </p>

                            @if($post->tags_list)
                                <div class="flex flex-wrap gap-1.5 mb-6">
                                    @foreach(array_slice($post->tags_list, 0, 3) as $tag)
                                        <span class="px-2 py-0.5 rounded-md bg-white/5 border border-white/10 text-stone-400 text-[10px] font-mono">
                                            #{{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="mt-4 pt-4 border-t border-[#1f1f1f] flex items-center justify-between text-xs font-mono text-[#878787] group-hover:text-white transition-colors">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-stone-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ number_format($post->views_count) }}
                            </span>
                            <a href="{{ route('blog.show', $post->slug) }}" class="flex items-center gap-1 font-semibold group-hover:translate-x-1 transition-transform">
                                <span>Buka Bacaan</span>
                                <span class="text-sm font-bold">&rarr;</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-16">
                {{ $posts->links() }}
            </div>
        @else
            <!-- Empty State (Boundary State) -->
            <div class="py-24 text-center rounded-[32px] bg-[#141414] border border-[#1f1f1f] shadow-xl px-4">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Tidak ada artikel ditemukan</h3>
                <p class="text-sm text-[#878787] max-w-md mx-auto mb-6">
                    Kriteria pencarian atau filter kategori yang dipilih saat ini tidak mencocokkan artikel apapun.
                </p>
                <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-white text-black text-xs font-bold uppercase tracking-wider hover:bg-neutral-200 transition-colors">
                    Tampilkan Semua Artikel
                </a>
            </div>
        @endif

    </div>
</div>
@endsection
