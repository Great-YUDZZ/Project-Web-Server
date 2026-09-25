@extends('layouts.app')

@section('title', $project->title . ' | I Made Yuda Pramana')

@section('content')
<div class="w-full py-8 sm:py-12 md:py-20 relative min-h-[85vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs font-mono text-stone-500 mb-6 sm:mb-8 overflow-x-auto py-1">
            <a href="{{ route('home') }}" class="hover:text-[#0C382E] transition-colors shrink-0">Beranda</a>
            <span>/</span>
            <a href="{{ route('projects.index') }}" class="hover:text-[#0C382E] transition-colors shrink-0">Lab &amp; Proyek</a>
            <span>/</span>
            <span class="text-[#1C1917] font-semibold truncate max-w-[150px] sm:max-w-xs">{{ $project->title }}</span>
        </nav>

        <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            <!-- Left Main Column (Details & Topology) -->
            <div class="lg:col-span-8 space-y-6 sm:space-y-10">
                
                <div class="space-y-3 sm:space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="badge-earth-green">
                            {{ $project->category }}
                        </span>
                        <span class="text-xs text-stone-500 font-mono">
                            {{ $project->created_at->format('d F Y') }}
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black uppercase text-[#1C1917] tracking-tight leading-[1.15] text-balance">
                        {{ $project->title }}
                    </h1>
                </div>

                <!-- Topology Preview Frame -->
                <div class="relative rounded-[32px] overflow-hidden card-earth p-4 sm:p-8 flex items-center justify-center shadow-lg">
                    <div class="absolute inset-0 bg-gradient-to-tr from-[#0C382E]/5 via-[#9C6644]/5 to-transparent pointer-events-none"></div>
                    <img src="{{ $project->image_url }}" alt="Topologi {{ $project->title }}" class="w-full h-auto max-h-[520px] object-contain relative z-10 rounded-2xl">
                </div>

                <!-- Description & Documentation -->
                <div class="p-6 sm:p-8 rounded-[32px] card-earth shadow-lg space-y-5 sm:space-y-6">
                    <div class="inline-flex items-center gap-2 text-xs font-mono text-[#0C382E] uppercase tracking-wider font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                        <span>Deskripsi &amp; Metodologi Implementasi</span>
                    </div>

                    <div class="text-stone-700 leading-relaxed text-sm sm:text-base lg:text-lg space-y-4 whitespace-pre-line text-balance font-normal">
                        {!! nl2br(e($project->description)) !!}
                    </div>

                    @if($project->demo_link)
                        <div class="pt-6 border-t border-stone-200">
                            <a href="{{ $project->demo_link }}" target="_blank" rel="noopener noreferrer"
                               class="btn-earth-green w-full sm:w-auto inline-flex items-center justify-center gap-2.5 min-h-[44px] px-8 py-3 rounded-full text-xs font-bold uppercase tracking-wider cursor-pointer">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                <span>Akses Repositori / Demo Langsung</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    @endif
                </div>

            </div>

            <!-- Right Sidebar Specifications Column -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Lab Specs Card -->
                <div class="p-6 sm:p-8 rounded-[32px] card-earth shadow-lg space-y-5 sm:space-y-6">
                    <div class="flex items-center justify-between border-b border-stone-200 pb-4">
                        <div class="text-xs font-mono font-bold text-[#1C1917] uppercase tracking-wider">Spesifikasi Lab</div>
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                    </div>

                    <dl class="space-y-4 font-mono text-xs">
                        <div>
                            <dt class="text-stone-500 uppercase tracking-wider text-[10px] mb-1">Kategori Sistem</dt>
                            <dd class="text-[#1C1917] font-bold text-sm">{{ $project->category }}</dd>
                        </div>

                        <div>
                            <dt class="text-stone-500 uppercase tracking-wider text-[10px] mb-1.5">Tools &amp; Perangkat</dt>
                            <dd class="flex flex-wrap gap-1.5">
                                @foreach($project->tools_list as $tool)
                                    <span class="badge-earth-brown">
                                        {{ $tool }}
                                    </span>
                                @endforeach
                            </dd>
                        </div>

                        <div>
                            <dt class="text-stone-500 uppercase tracking-wider text-[10px] mb-1">Status Pengujian</dt>
                            <dd class="text-emerald-700 font-bold flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                                Diverifikasi &bull; Berhasil
                            </dd>
                        </div>

                        <div>
                            <dt class="text-stone-500 uppercase tracking-wider text-[10px] mb-1">Penyusun Dokumentasi</dt>
                            <dd class="text-[#1C1917] font-bold">I Made Yuda Pramana</dd>
                        </div>
                    </dl>

                    <div class="pt-4 border-t border-stone-200">
                        <a href="{{ route('projects.index') }}" class="btn-earth-outline w-full px-5 py-3 rounded-full text-xs font-bold uppercase tracking-wider min-h-[44px] flex items-center justify-center gap-2 transition-all">
                            <span>&larr;</span>
                            <span>Kembali ke katalog</span>
                        </a>
                    </div>
                </div>

                <!-- Related Labs Card -->
                @if($relatedProjects->count() > 0)
                    <div class="p-6 sm:p-8 rounded-[32px] card-earth shadow-lg space-y-4">
                        <div class="text-xs font-mono font-bold text-[#1C1917] uppercase tracking-wider border-b border-stone-200 pb-3">
                            Lab Terkait
                        </div>

                        <div class="space-y-3">
                            @foreach($relatedProjects as $rel)
                                <a href="{{ route('projects.show', $rel->slug) }}" class="block p-4 rounded-2xl bg-stone-50 border border-stone-200 hover:border-[#0C382E]/40 hover:bg-stone-100 transition-all group">
                                    <div class="text-[10px] font-mono text-stone-500 mb-1">{{ $rel->category }}</div>
                                    <div class="text-sm font-bold text-[#1C1917] group-hover:text-[#0C382E] transition-colors line-clamp-2">
                                        {{ $rel->title }}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

        </div>

    </div>
</div>
@endsection
