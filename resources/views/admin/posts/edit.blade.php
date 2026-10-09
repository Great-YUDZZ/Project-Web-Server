@extends('layouts.admin')

@section('title', 'Sunting Artikel Blog | Admin Panel TKJ')
@section('page_title', 'Sunting Artikel Blog')

@section('admin_content')
<div class="max-w-4xl">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold font-body text-white tracking-tight">Sunting Dokumen <span class="font-display font-semibold text-stone-300">Artikel Blog</span></h2>
            <p class="text-xs text-stone-400 font-body mt-0.5">Perbarui isi konten, metadata, kategori, atau status publikasi artikel.</p>
        </div>
        <div class="flex items-center gap-3">
            @if($post->is_published)
                <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="font-body text-xs text-stone-300 hover:text-white flex items-center gap-1.5 transition-colors">
                    <span>Lihat Publik</span>
                    <span>&rarr;</span>
                </a>
            @endif
            <a href="{{ route('admin.posts.index') }}" class="font-body text-xs text-stone-400 hover:text-white transition-colors">
                &larr; Batal &amp; Kembali
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-rose-950/40 border border-rose-500/30 text-rose-200 text-xs font-body">
            <div class="font-bold mb-1">Terdapat kesalahan validasi:</div>
            <ul class="list-disc pl-4 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-2xl border border-white/10 bg-[#141414] p-6 sm:p-8 shadow-xs">
        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" class="space-y-6 font-body text-xs">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label for="title" class="block text-stone-300 font-bold mb-2">
                    JUDUL ARTIKEL <span class="text-rose-400">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required
                       placeholder="Misal: Optimasi Linux Kernel Network Stack pada Debian 13"
                       class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0a] border border-white/15 text-white placeholder-stone-600 focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 text-sm transition-all">
            </div>

            <!-- Slug & Category Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="slug" class="block text-stone-300 font-bold mb-2">
                        SLUG URL
                    </label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $post->slug) }}"
                           placeholder="slug-url-artikel"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0a] border border-white/15 text-white placeholder-stone-600 focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 text-sm transition-all">
                </div>

                <div>
                    <label for="category" class="block text-stone-300 font-bold mb-2">
                        KATEGORI <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" name="category" id="category" value="{{ old('category', $post->category) }}" required
                           placeholder="Linux & Sysadmin / Networking & Routing / Container & Virtualization"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0a] border border-white/15 text-white placeholder-stone-600 focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 text-sm transition-all">
                </div>
            </div>

            <!-- Excerpt -->
            <div>
                <label for="excerpt" class="block text-stone-300 font-bold mb-2">
                    RINGKASAN SINGKAT (EXCERPT)
                </label>
                <textarea name="excerpt" id="excerpt" rows="2"
                          placeholder="Ringkasan 1-2 kalimat untuk pratinjau kartu artikel..."
                          class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0a] border border-white/15 text-white placeholder-stone-600 focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 text-sm transition-all">{{ old('excerpt', $post->excerpt) }}</textarea>
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-stone-300 font-bold mb-2">
                    KONTEN ARTIKEL (MENDUKUNG MARKDOWN HEADING ##, KODE ```, DAFTAR -) <span class="text-rose-400">*</span>
                </label>
                <textarea name="content" id="content" rows="14" required
                          placeholder="Tulis artikel teknis Anda di sini... Gunakan ## untuk Sub-judul, ```bash untuk blok kode terminal, dan - untuk daftar poin."
                          class="w-full px-4 py-3 rounded-xl bg-[#0a0a0a] border border-white/15 text-white placeholder-stone-600 font-mono focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 text-xs sm:text-sm leading-relaxed transition-all">{{ old('content', $post->content) }}</textarea>
            </div>

            <!-- Tags & Reading Time -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="tags" class="block text-stone-300 font-bold mb-2">
                        TAGS / KATA KUNCI (PISAHKAN KOMA)
                    </label>
                    <input type="text" name="tags" id="tags" value="{{ old('tags', $post->tags) }}"
                           placeholder="debian13, sysctl, performance, bbr"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0a] border border-white/15 text-white placeholder-stone-600 focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 text-sm transition-all">
                </div>

                <div>
                    <label for="reading_time" class="block text-stone-300 font-bold mb-2">
                        ESTIMASI BACA (MENIT)
                    </label>
                    <input type="number" name="reading_time" id="reading_time" value="{{ old('reading_time', $post->reading_time) }}" min="1"
                           placeholder="kosongkan untuk kalkulasi otomatis"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0a] border border-white/15 text-white placeholder-stone-600 focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 text-sm transition-all">
                </div>
            </div>

            <!-- Publication Status Toggle -->
            <div class="p-4 rounded-xl bg-white/[0.03] border border-white/10 flex items-center justify-between">
                <div>
                    <span class="font-bold text-white block text-sm">Status Publikasi Online</span>
                    <span class="text-stone-400 text-xs">Artikel dengan status Terbit dapat diakses publik pada katalog /blog</span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-stone-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-white/10 flex justify-end gap-3">
                <a href="{{ route('admin.posts.index') }}" class="px-5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-stone-300 hover:text-white hover:bg-white/10 text-xs font-bold uppercase tracking-wider transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-white text-black hover:bg-neutral-200 text-xs font-bold uppercase tracking-wider transition-all shadow-lg cursor-pointer">
                    Perbarui Artikel
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
