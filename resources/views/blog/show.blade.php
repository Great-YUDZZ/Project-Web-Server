@extends('layouts.app')

@section('title', $post->title . ' | Jurnal Rekayasa I Made Yuda Pramana')

@section('content')
<div class="w-full py-8 sm:py-12 md:py-20 relative min-h-[85vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 relative z-10">

        <!-- Navigation Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs font-mono text-[#878787] mb-8 sm:mb-12 overflow-x-auto py-1">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors shrink-0">Beranda</a>
            <span>/</span>
            <a href="{{ route('blog.index') }}" class="hover:text-white transition-colors shrink-0">Jurnal Blog</a>
            <span>/</span>
            <span class="text-white font-semibold truncate max-w-[200px] sm:max-w-md">{{ $post->title }}</span>
        </nav>

        <!-- Article Meta Header -->
        <header class="mb-10 sm:mb-14 space-y-4 sm:space-y-6">
            <div class="flex flex-wrap items-center gap-3">
                <span class="px-3 py-1 rounded-full bg-white/10 border border-white/20 text-white text-xs font-mono font-semibold">
                    {{ $post->category }}
                </span>
                <span class="text-xs text-[#878787] font-mono">
                    {{ $post->published_at ? $post->published_at->format('d F Y') : $post->created_at->format('d F Y') }}
                </span>
                <span class="text-[#4D4D4D] font-mono">&bull;</span>
                <span class="text-xs text-[#878787] font-mono flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $post->reading_time }} menit baca
                </span>
                <span class="text-[#4D4D4D] font-mono">&bull;</span>
                <span class="text-xs text-[#878787] font-mono flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    {{ number_format($post->views_count) }} pembaca
                </span>
            </div>

            <h1 class="text-3xl sm:text-5xl lg:text-5xl font-black text-[#f5f5f5] tracking-tight leading-[1.15] text-balance">
                {{ $post->title }}
            </h1>

            @if($post->excerpt)
                <p class="text-base sm:text-xl text-[#a3a3a3] font-light leading-relaxed border-l-2 border-white/20 pl-4 py-1 italic">
                    {{ $post->excerpt }}
                </p>
            @endif

            <!-- Author Bio Card -->
            <div class="flex items-center gap-4 pt-4 border-t border-[#1f1f1f]">
                <div class="w-11 h-11 rounded-full bg-white/10 border border-white/20 flex items-center justify-center font-display italic text-white text-base shadow-inner">
                    YP
                </div>
                <div>
                    <div class="font-bold text-white text-sm">I Made Yuda Pramana</div>
                    <div class="text-xs text-[#878787] font-mono">Teknik Komputer &amp; Jaringan &bull; SMKN 1 Denpasar</div>
                </div>
            </div>
        </header>

        <!-- Article Main Content Body -->
        <div class="p-6 sm:p-10 rounded-[32px] bg-[#141414] border border-[#1f1f1f] shadow-2xl space-y-6">
            <article class="article-prose font-body">
                {!! Str::markdown($post->content) !!}
            </article>

            <!-- Tags Section -->
            @if($post->tags_list)
                <div class="pt-8 mt-8 border-t border-[#1f1f1f]">
                    <div class="text-xs font-mono text-[#878787] uppercase tracking-wider mb-3">
                        Kata Kunci &bull; Topik Terkait:
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->tags_list as $tag)
                            <a href="{{ route('blog.index', ['q' => $tag]) }}" class="px-3 py-1 rounded-lg bg-white/5 border border-white/10 text-stone-300 text-xs font-mono hover:bg-white/10 hover:text-white transition-colors">
                                #{{ $tag }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Article Footer Interactive Action Bar -->
            <div class="pt-6 border-t border-[#1f1f1f] flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-white hover:text-stone-300 transition-colors">
                    <span>&larr;</span>
                    <span>Kembali ke Katalog Jurnal</span>
                </a>

                <div class="flex items-center gap-3">
                    <button type="button" id="copy-article-link-btn" class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-xs font-mono text-stone-300 hover:text-white hover:bg-white/10 transition-colors cursor-pointer flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span id="copy-btn-text">Salin Tautan</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Related Posts Section -->
        @if($relatedPosts->count() > 0)
            <div class="mt-16 sm:mt-24">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-xl sm:text-2xl font-bold text-white font-body">Artikel Lainnya</h3>
                        <p class="text-xs text-[#878787] font-mono mt-1">Eksplorasi dokumentasi terkait topik ini</p>
                    </div>
                    <a href="{{ route('blog.index') }}" class="text-xs font-mono text-white hover:underline flex items-center gap-1">
                        <span>Lihat Semua</span>
                        <span>&rarr;</span>
                    </a>
                </div>

                <div class="grid sm:grid-cols-3 gap-5">
                    @foreach($relatedPosts as $rel)
                        <a href="{{ route('blog.show', $rel->slug) }}" class="p-5 rounded-2xl bg-[#141414] border border-[#1f1f1f] hover:border-white/30 transition-all group flex flex-col justify-between">
                            <div>
                                <div class="text-[10px] font-mono text-stone-400 mb-2">{{ $rel->category }} &bull; {{ $rel->reading_time }} mnt</div>
                                <h4 class="font-bold text-sm text-[#f5f5f5] group-hover:text-white transition-colors line-clamp-2 mb-2">
                                    {{ $rel->title }}
                                </h4>
                                <p class="text-xs text-[#878787] line-clamp-2 font-light">
                                    {{ $rel->excerpt }}
                                </p>
                            </div>
                            <div class="mt-4 pt-3 border-t border-[#1f1f1f] text-[11px] font-mono text-stone-400 group-hover:text-white flex items-center justify-between">
                                <span>Baca</span>
                                <span>&rarr;</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>

<style>
.article-prose h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #ffffff;
    margin-top: 2rem;
    margin-bottom: 0.75rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #262626;
    letter-spacing: -0.015em;
}
@media (min-width: 640px) {
    .article-prose h2 {
        font-size: 1.75rem;
    }
}
.article-prose h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #e5e5e5;
    margin-top: 1.5rem;
    margin-bottom: 0.5rem;
}
.article-prose p {
    color: #d4d4d4;
    font-size: 0.95rem;
    line-height: 1.75;
    margin-bottom: 1.25rem;
    font-weight: 300;
}
@media (min-width: 640px) {
    .article-prose p {
        font-size: 1rem;
    }
}
.article-prose ul {
    list-style-type: disc;
    padding-left: 1.5rem;
    margin-bottom: 1.25rem;
    color: #d4d4d4;
}
.article-prose ol {
    list-style-type: decimal;
    padding-left: 1.5rem;
    margin-bottom: 1.25rem;
    color: #d4d4d4;
}
.article-prose li {
    margin-bottom: 0.375rem;
    line-height: 1.6;
}
.article-prose pre {
    background-color: #0a0a0a;
    border: 1px solid #262626;
    border-radius: 1rem;
    padding: 1.25rem;
    overflow-x: auto;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.8125rem;
    line-height: 1.65;
    color: #34d399;
    margin: 1.5rem 0;
    box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.4);
}
.article-prose :not(pre) > code {
    background-color: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 0.375rem;
    padding: 0.15rem 0.4rem;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.8125rem;
    color: #ffffff;
}
.article-prose blockquote {
    border-left: 3px solid rgba(255, 255, 255, 0.3);
    padding-left: 1rem;
    font-style: italic;
    color: #a3a3a3;
    margin: 1.5rem 0;
}
.article-prose a {
    color: #ffffff;
    text-decoration: underline;
    text-underline-offset: 3px;
    transition: color 0.2s ease;
}
.article-prose a:hover {
    color: #a3a3a3;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const copyBtn = document.getElementById('copy-article-link-btn');
    const copyText = document.getElementById('copy-btn-text');
    if (copyBtn && copyText) {
        copyBtn.addEventListener('click', () => {
            navigator.clipboard.writeText(window.location.href).then(() => {
                copyText.textContent = 'Tautan Disalin!';
                copyBtn.classList.add('border-white', 'text-white');
                setTimeout(() => {
                    copyText.textContent = 'Salin Tautan';
                    copyBtn.classList.remove('border-white', 'text-white');
                }, 2000);
            }).catch(() => {
                copyText.textContent = 'Gagal Menyalin';
            });
        });
    }
});
</script>
@endpush
@endsection
