@extends('layouts.admin')

@section('title', 'Kelola Artikel Blog & Jurnal | Admin Panel TKJ')
@section('page_title', 'Kelola Artikel Blog')

@section('admin_content')
<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold font-body text-white tracking-tight">Daftar Artikel <span class="font-display italic font-normal text-stone-300">Blog &amp; Jurnal Teknis</span></h2>
            <p class="text-xs text-stone-400 font-body mt-0.5">Kelola tulisan ilmiah, catatan konfigurasi Debian, RFC jaringan, dan artikel lab.</p>
        </div>

        <a href="{{ route('admin.posts.create') }}" class="px-4.5 py-2.5 rounded-xl bg-white text-black text-xs font-body tracking-wider uppercase font-bold hover:bg-neutral-200 transition-all shadow-lg shadow-white/10 flex items-center gap-2 self-start sm:self-auto cursor-pointer">
            <span>+ TULIS ARTIKEL BARU</span>
        </a>
    </div>

    <!-- Feedback Notification Banner -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-950/40 border border-emerald-500/30 text-emerald-200 text-xs font-body flex items-center gap-3">
            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Search & Filter Bar -->
    <div class="p-4 rounded-2xl bg-[#141414] border border-white/10 shadow-xs">
        <form action="{{ route('admin.posts.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul artikel, topik, atau kategori..."
                       class="w-full px-4 py-2 rounded-xl bg-[#0a0a0a] border border-white/15 text-white placeholder-stone-600 text-xs font-body focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 transition-all">
            </div>

            <div class="sm:w-56">
                <select name="category" class="w-full px-4 py-2 rounded-xl bg-[#0a0a0a] border border-white/15 text-white text-xs font-body focus:outline-none focus:border-white transition-all">
                    <option value="all">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-4 py-2 rounded-xl bg-white/10 border border-white/15 text-stone-200 hover:bg-white hover:text-black text-xs font-body font-medium transition-colors cursor-pointer">
                Saring
            </button>
            @if(request('q') || (request('category') && request('category') !== 'all'))
                <a href="{{ route('admin.posts.index') }}" class="px-3 py-2 rounded-xl bg-white/5 border border-white/10 text-stone-400 hover:text-white text-xs font-body flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Posts Table -->
    <div class="rounded-2xl border border-white/10 bg-[#141414] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-body text-xs">
                <thead>
                    <tr class="border-b border-white/10 text-stone-400 bg-white/[0.04] font-semibold">
                        <th class="py-3.5 px-4">JUDUL ARTIKEL &amp; SLUG</th>
                        <th class="py-3.5 px-4">KATEGORI</th>
                        <th class="py-3.5 px-4 text-center">STATUS</th>
                        <th class="py-3.5 px-4 text-center">ESTIMASI BACA</th>
                        <th class="py-3.5 px-4 text-center">TAYANGAN</th>
                        <th class="py-3.5 px-4">TANGGAL TERBIT</th>
                        <th class="py-3.5 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-stone-300">
                    @forelse($posts as $post)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-white text-sm hover:text-stone-300 transition-colors">
                                    <a href="{{ route('admin.posts.edit', $post->id) }}">
                                        {{ $post->title }}
                                    </a>
                                </div>
                                <div class="text-[10px] text-stone-500 font-mono mt-0.5">/blog/{{ $post->slug }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-white/10 text-white border border-white/15 font-mono">
                                    {{ $post->category }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <form action="{{ route('admin.posts.toggle-publish', $post->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider transition-all cursor-pointer {{ $post->is_published ? 'bg-emerald-950/60 text-emerald-300 border border-emerald-500/40 hover:bg-emerald-900' : 'bg-stone-900 text-stone-400 border border-stone-700 hover:bg-stone-800' }}">
                                        {{ $post->is_published ? 'TERBIT' : 'DRAF' }}
                                    </button>
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-center font-mono text-stone-400">
                                {{ $post->reading_time }} mnt
                            </td>
                            <td class="py-3.5 px-4 text-center font-mono text-stone-400">
                                {{ number_format($post->views_count) }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-[11px] text-stone-400">
                                {{ $post->published_at ? $post->published_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($post->is_published)
                                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="p-1.5 rounded-lg bg-white/5 hover:bg-white/15 text-stone-400 hover:text-white transition-colors" title="Buka Publik">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="p-1.5 rounded-lg bg-white/5 hover:bg-white/15 text-stone-300 hover:text-white transition-colors" title="Sunting">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-950/30 hover:bg-rose-900/50 text-rose-300 transition-colors cursor-pointer" title="Hapus">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-stone-500">
                                Belum ada artikel blog yang tercatat. Klik <strong class="text-white">+ TULIS ARTIKEL BARU</strong> untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
            <div class="p-4 border-t border-white/5">
                {{ $posts->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
