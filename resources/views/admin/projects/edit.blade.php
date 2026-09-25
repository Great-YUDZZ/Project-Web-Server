@extends('layouts.admin')

@section('title', 'Edit Proyek - ' . $project->title)
@section('page_title', 'Edit Proyek Lab')

@section('admin_content')
<div class="max-w-4xl">
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-stone-900 tracking-tight">Edit Dokumentasi Proyek</h2>
            <p class="text-xs text-stone-500 font-mono mt-0.5">Perbarui informasi konfigurasi, perangkat, atau diagram topologi.</p>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="font-mono text-xs text-stone-500 hover:text-[#0C382E] transition-colors">
            &larr; Batal &amp; Kembali
        </a>
    </div>

    <div class="rounded-2xl border border-stone-200 bg-white p-6 sm:p-8 shadow-xs">
        <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 font-mono text-xs">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label for="title" class="block text-stone-800 font-bold mb-2">
                    JUDUL PROYEK / LAB <span class="text-rose-600">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" required
                       class="w-full px-4 py-2.5 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E] text-sm">
            </div>

            <!-- Slug & Category Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="slug" class="block text-stone-800 font-bold mb-2">
                        SLUG URL <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $project->slug) }}" required
                           class="w-full px-4 py-2.5 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E] text-sm">
                </div>

                <div>
                    <label for="category" class="block text-stone-800 font-bold mb-2">
                        KATEGORI LAB <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" name="category" id="category" value="{{ old('category', $project->category) }}" required
                           class="w-full px-4 py-2.5 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E] text-sm">
                </div>
            </div>

            <!-- Tools Used & Demo Link -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="tools_used" class="block text-stone-800 font-bold mb-2">
                        TOOLS &amp; HARDWARE (PISAHKAN KOMA)
                    </label>
                    <input type="text" name="tools_used" id="tools_used" value="{{ old('tools_used', $project->tools_used) }}"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E] text-sm">
                </div>

                <div>
                    <label for="demo_link" class="block text-stone-800 font-bold mb-2">
                        LINK DEMO / REPOSITORI GITHUB (OPSIONAL)
                    </label>
                    <input type="url" name="demo_link" id="demo_link" value="{{ old('demo_link', $project->demo_link) }}"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E] text-sm">
                </div>
            </div>

            <!-- Current Image & Upload Replacement -->
            <div class="space-y-3">
                <label class="block text-stone-800 font-bold">
                    GAMBAR TOPOLOGI SAAT INI:
                </label>
                <div class="h-44 max-w-md rounded-2xl bg-stone-100 border border-stone-200 overflow-hidden flex items-center justify-center p-3">
                    <img src="{{ $project->image_url }}" alt="" class="h-full object-contain">
                </div>

                <label for="topology_image" class="block text-stone-800 font-bold pt-2">
                    GANTI FILE GAMBAR TOPOLOGI (OPSIONAL)
                </label>
                <div class="p-4 rounded-2xl bg-[#FAF8F5] border-2 border-dashed border-stone-300 hover:border-[#0C382E] transition-colors">
                    <input type="file" name="topology_image" id="topology_image" accept="image/*"
                           class="w-full text-stone-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-mono file:bg-stone-200 file:text-stone-800 hover:file:bg-[#0C382E] hover:file:text-white file:cursor-pointer file:transition-colors">
                </div>
            </div>

            <!-- Visibility, Hero Pin & Order Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Hero Pin Checkbox -->
                <div class="p-4 rounded-2xl bg-[#0C382E]/5 border border-[#0C382E]/30 flex items-start gap-3">
                    <input type="checkbox" name="is_hero" id="is_hero" value="1" {{ old('is_hero', $project->is_hero) ? 'checked' : '' }}
                           class="h-4 w-4 rounded border-stone-300 text-[#0C382E] focus:ring-[#0C382E] mt-0.5">
                    <div>
                        <label for="is_hero" class="text-stone-900 font-bold cursor-pointer select-none block">
                            ★ Pin ke Hero Header
                        </label>
                        <p class="text-[10px] text-stone-500 font-mono mt-0.5">Tampilkan di kartu utama header beranda (Maksimal 2 proyek).</p>
                    </div>
                </div>

                <!-- Featured Checkbox -->
                <div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200/80 flex items-start gap-3">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}
                           class="h-4 w-4 rounded border-stone-300 text-amber-600 focus:ring-amber-500 mt-0.5">
                    <div>
                        <label for="is_featured" class="text-stone-900 font-bold cursor-pointer select-none block">
                            Proyek Unggulan
                        </label>
                        <p class="text-[10px] text-stone-500 font-mono mt-0.5">Tampilkan di section Showcase Lab &amp; Proyek Unggulan.</p>
                    </div>
                </div>

                <!-- Order Input -->
                <div class="p-4 rounded-2xl bg-[#FAF8F5] border border-stone-200 flex flex-col justify-between">
                    <label for="order" class="text-stone-800 font-bold block mb-1">
                        NOMOR URUTAN TAMPIL
                    </label>
                    <input type="number" name="order" id="order" value="{{ old('order', $project->order ?? 0) }}" min="0"
                           class="w-full px-3 py-1.5 rounded-xl bg-white border border-stone-300 text-stone-900 focus:outline-none focus:border-[#0C382E] text-xs font-mono font-bold">
                    <span class="text-[10px] text-stone-400 font-mono mt-1">Semakin kecil (1, 2, 3) semakin di depan.</span>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-stone-800 font-bold mb-2">
                    DOKUMENTASI LANGKAH &amp; DESKRIPSI TEKNIS <span class="text-rose-600">*</span>
                </label>
                <textarea name="description" id="description" rows="12" required
                          class="w-full px-4 py-3 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E] text-sm leading-relaxed">{{ old('description', $project->description) }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-stone-200">
                <a href="{{ route('admin.projects.index') }}" class="px-5 py-2.5 rounded-xl bg-stone-100 border border-stone-200 text-stone-700 hover:bg-stone-200 transition-colors font-medium">
                    Batal
                </a>
                <button type="submit" class="btn-earth-green text-xs py-2.5 px-6 font-mono font-bold">
                    Perbarui Proyek &rarr;
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
