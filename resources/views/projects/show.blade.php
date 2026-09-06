@extends('layouts.app')

@section('title', $project->title . ' - Dokumentasi Lab TKJ')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 font-mono-code text-xs text-slate-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-cyan-400">HOME</a>
            <span>/</span>
            <a href="{{ route('projects.index') }}" class="hover:text-cyan-400">PROJECTS</a>
            <span>/</span>
            <span class="text-slate-300 truncate max-w-xs sm:max-w-md">{{ strtoupper($project->slug) }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Left Main Content -->
            <div class="lg:col-span-8 space-y-8">
                
                <!-- Title & Meta Header -->
                <div>
                    <div class="flex flex-wrap items-center gap-3 mb-3">
                        <span class="px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 font-mono-code text-xs font-semibold">
                            {{ $project->category }}
                        </span>
                        <span class="text-xs text-slate-500 font-mono-code">
                            DIPOSTING: {{ $project->created_at->format('d F Y') }}
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight">
                        {{ $project->title }}
                    </h1>
                </div>

                <!-- Topology Image Viewer Card -->
                <div class="rounded-2xl border border-slate-800 bg-slate-950 overflow-hidden shadow-2xl p-4 sm:p-6">
                    <div class="flex items-center justify-between mb-4 border-b border-slate-800/80 pb-3 font-mono-code text-xs text-slate-400">
                        <span class="flex items-center gap-2 text-cyan-400">
                            <span class="h-2 w-2 rounded-full bg-cyan-400 animate-pulse"></span>
                            DIAGRAM_TOPOLOGI_JARINGAN
                        </span>
                        <span>[HIGH RES PREVIEW]</span>
                    </div>

                    <div class="relative group bg-slate-900/60 rounded-xl overflow-hidden flex items-center justify-center p-2 sm:p-4">
                        <img src="{{ $project->image_url }}" alt="Topologi {{ $project->title }}" class="w-full max-h-[420px] object-contain rounded-lg">
                    </div>
                </div>

                <!-- Documentation Body -->
                <div class="rounded-2xl border border-slate-800 bg-slate-900/40 p-6 sm:p-8 space-y-6">
                    <div class="font-mono-code text-xs text-cyan-400 border-b border-slate-800 pb-3">
                        // DOKUMENTASI_TEKNIS_DAN_LANGKAH_LAB
                    </div>

                    <div class="prose prose-invert max-w-none text-slate-300 text-sm leading-relaxed space-y-4">
                        {!! nl2br(e($project->description)) !!}
                    </div>

                    @if($project->demo_link)
                        <div class="pt-6 border-t border-slate-800">
                            <a href="{{ $project->demo_link }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-cyan-500 text-black font-bold font-mono-code text-xs hover:bg-cyan-400 transition-colors">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                <span>Akses Repositori / Demo Langsung</span>
                            </a>
                        </div>
                    @endif
                </div>

            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Lab Specifications Box -->
                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6 font-mono-code text-xs space-y-4">
                    <div class="text-cyan-400 font-bold text-sm border-b border-slate-800 pb-3">
                        // SPESIFIKASI_LAB
                    </div>

                    <div class="space-y-3">
                        <div>
                            <div class="text-slate-500 text-[11px]">KATEGORI LAB</div>
                            <div class="text-white font-semibold text-sm mt-0.5">{{ $project->category }}</div>
                        </div>

                        <div>
                            <div class="text-slate-500 text-[11px]">TOOLS &amp; HARDWARE DIGUNAKAN</div>
                            <div class="flex flex-wrap gap-1.5 mt-2">
                                @foreach($project->tools_list as $tool)
                                    <span class="px-2.5 py-1 rounded bg-slate-900 border border-slate-800 text-slate-300 text-[11px]">
                                        {{ $tool }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <div class="text-slate-500 text-[11px]">STATUS PENGUJIAN</div>
                            <div class="text-emerald-400 font-semibold mt-0.5 flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                                100% SUKSES DIVERIFIKASI
                            </div>
                        </div>

                        <div>
                            <div class="text-slate-500 text-[11px]">PENULIS DOKUMENTASI</div>
                            <div class="text-white font-semibold mt-0.5">Muhammad Yuda Pratama (TKJ)</div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-800/80">
                        <a href="{{ route('projects.index') }}" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 hover:text-cyan-400 transition-colors">
                            <span>&larr; Kembali ke Katalog</span>
                        </a>
                    </div>
                </div>

                <!-- Related Labs -->
                @if($relatedProjects->count() > 0)
                    <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6 font-mono-code text-xs space-y-4">
                        <div class="text-white font-bold text-sm border-b border-slate-800 pb-3">
                            // LAB_TERKAIT
                        </div>

                        <div class="space-y-3">
                            @foreach($relatedProjects as $rel)
                                <a href="{{ route('projects.show', $rel->slug) }}" class="block p-3 rounded-lg bg-slate-900/60 border border-slate-800/80 hover:border-cyan-500/50 transition-colors group">
                                    <div class="text-slate-400 text-[10px] mb-1">{{ $rel->category }}</div>
                                    <div class="text-white font-semibold group-hover:text-cyan-400 transition-colors line-clamp-2">
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
