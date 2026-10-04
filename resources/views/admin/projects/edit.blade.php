@extends('layouts.admin')

@section('title', 'Edit Proyek | ' . $project->title)
@section('page_title', 'Edit Proyek Lab')

@section('admin_content')
<div class="max-w-4xl">
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold font-body text-white tracking-tight">Edit Dokumentasi <span class="font-display italic font-normal text-stone-300">Proyek Lab</span></h2>
            <p class="text-xs text-stone-400 font-body mt-0.5">Perbarui informasi konfigurasi, perangkat, atau diagram topologi.</p>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="font-body text-xs text-stone-400 hover:text-white transition-colors">
            &larr; Batal &amp; Kembali
        </a>
    </div>

    <div class="rounded-2xl border border-white/10 bg-[#141414] p-6 sm:p-8 shadow-xs">
        <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 font-body text-xs">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label for="title" class="block text-stone-300 font-bold mb-2">
                    JUDUL PROYEK / LAB <span class="text-rose-400">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" required
                       class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0a] border border-white/15 text-white focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 text-sm transition-all">
            </div>

            <!-- Slug & Category Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="slug" class="block text-stone-300 font-bold mb-2">
                        SLUG URL <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $project->slug) }}" required
                           class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0a] border border-white/15 text-white focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 text-sm transition-all">
                </div>

                <div>
                    <label for="category" class="block text-stone-300 font-bold mb-2">
                        KATEGORI LAB <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" name="category" id="category" value="{{ old('category', $project->category) }}" required
                           class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0a] border border-white/15 text-white focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 text-sm transition-all">
                </div>
            </div>

            <!-- Tools Used & Demo Link -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="tools_used" class="block text-stone-300 font-bold mb-2">
                        TOOLS &amp; HARDWARE (PISAHKAN KOMA)
                    </label>
                    <input type="text" name="tools_used" id="tools_used" value="{{ old('tools_used', $project->tools_used) }}"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0a] border border-white/15 text-white focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 text-sm transition-all">
                </div>

                <div>
                    <label for="demo_link" class="block text-stone-300 font-bold mb-2">
                        LINK DEMO / REPOSITORI GITHUB (OPSIONAL)
                    </label>
                    <input type="url" name="demo_link" id="demo_link" value="{{ old('demo_link', $project->demo_link) }}"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0a] border border-white/15 text-white focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 text-sm transition-all">
                </div>
            </div>

            <!-- Current Image & Upload Replacement -->
            <div class="space-y-3">
                <label class="block text-stone-300 font-bold">
                    GAMBAR TOPOLOGI SAAT INI:
                </label>
                <div class="h-44 max-w-md rounded-2xl bg-[#0a0a0a] border border-white/10 overflow-hidden flex items-center justify-center p-3">
                    <img src="{{ $project->image_url }}" alt="" class="h-full object-contain">
                </div>

                <label for="topology_image" class="block text-stone-300 font-bold pt-2">
                    GANTI FILE GAMBAR TOPOLOGI (OPSIONAL)
                </label>
                <div class="p-4 rounded-2xl bg-[#0a0a0a] border-2 border-dashed border-white/15 hover:border-white/40 transition-colors">
                    <input type="file" name="topology_image" id="topology_image" accept="image/*"
                           class="w-full text-stone-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-mono file:bg-white/10 file:text-white hover:file:bg-white hover:file:text-black file:cursor-pointer file:transition-colors">
                </div>
            </div>

            <!-- Visibility, Hero Pin & Order Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Hero Pin Checkbox -->
                <div class="p-4 rounded-2xl bg-white/5 border border-white/15 flex items-start gap-3">
                    <input type="checkbox" name="is_hero" id="is_hero" value="1" {{ old('is_hero', $project->is_hero) ? 'checked' : '' }}
                           class="h-4 w-4 rounded border-white/20 bg-[#0a0a0a] text-white focus:ring-white/40 mt-0.5">
                    <div>
                        <label for="is_hero" class="text-white font-bold cursor-pointer select-none block">
                            ★ Pin ke Hero Header
                        </label>
                        <p class="text-[10px] text-stone-400 font-mono mt-0.5">Tampilkan di kartu utama header beranda (Maksimal 2 proyek).</p>
                    </div>
                </div>

                <!-- Featured Checkbox -->
                <div class="p-4 rounded-2xl bg-white/5 border border-white/15 flex items-start gap-3">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}
                           class="h-4 w-4 rounded border-white/20 bg-[#0a0a0a] text-white focus:ring-white/40 mt-0.5">
                    <div>
                        <label for="is_featured" class="text-white font-bold cursor-pointer select-none block">
                            Proyek Unggulan
                        </label>
                        <p class="text-[10px] text-stone-400 font-mono mt-0.5">Tampilkan di section Showcase Lab &amp; Proyek Unggulan.</p>
                    </div>
                </div>

                <!-- Order Input -->
                <div class="p-4 rounded-2xl bg-[#0a0a0a] border border-white/15 flex flex-col justify-between">
                    <label for="order" class="text-stone-300 font-bold block mb-1">
                        NOMOR URUTAN TAMPIL
                    </label>
                    <input type="number" name="order" id="order" value="{{ old('order', $project->order ?? 0) }}" min="0"
                           class="w-full px-3 py-1.5 rounded-xl bg-[#141414] border border-white/20 text-white focus:outline-none focus:border-white text-xs font-mono font-bold">
                    <span class="text-[10px] text-stone-500 font-mono mt-1">Semakin kecil (1, 2, 3) semakin di depan.</span>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-stone-300 font-bold mb-2">
                    DOKUMENTASI LANGKAH &amp; DESKRIPSI TEKNIS <span class="text-rose-400">*</span>
                </label>
                <textarea name="description" id="description" rows="12" required
                          class="w-full px-4 py-3 rounded-xl bg-[#0a0a0a] border border-white/15 text-white focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 text-sm leading-relaxed">{{ old('description', $project->description) }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/10">
                <a href="{{ route('admin.projects.index') }}" class="px-5 py-2.5 rounded-xl bg-white/5 border border-white/15 text-stone-300 hover:bg-white/10 hover:text-white transition-colors font-medium">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-white text-black text-xs font-body tracking-wider uppercase font-bold hover:bg-neutral-200 transition-all shadow-lg shadow-white/10 cursor-pointer">
                    Perbarui Proyek &rarr;
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
