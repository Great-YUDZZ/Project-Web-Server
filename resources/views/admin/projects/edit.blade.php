@extends('layouts.admin')

@section('title', 'Edit Proyek - ' . $project->title)
@section('page_title', 'Edit Proyek Lab')

@section('admin_content')
<div class="max-w-4xl">
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight">Edit Dokumentasi Proyek</h2>
            <p class="text-xs text-zinc-400 font-mono mt-0.5">Perbarui informasi konfigurasi, perangkat, atau diagram topologi.</p>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="font-mono text-xs text-zinc-400 hover:text-orange-400 transition-colors">
            &larr; Batal &amp; Kembali
        </a>
    </div>

    <div class="rounded-3xl border border-white/[0.08] bg-[#0d0e14]/80 backdrop-blur-xl p-6 sm:p-8">
        <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 font-mono text-xs">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label for="title" class="block text-zinc-300 font-bold mb-2">
                    JUDUL PROYEK / LAB <span class="text-rose-400">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" required
                       class="w-full px-4 py-2.5 rounded-xl bg-[#070709] border border-white/[0.08] text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-sm">
            </div>

            <!-- Slug & Category Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="slug" class="block text-zinc-300 font-bold mb-2">
                        SLUG URL <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $project->slug) }}" required
                           class="w-full px-4 py-2.5 rounded-xl bg-[#070709] border border-white/[0.08] text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-sm">
                </div>

                <div>
                    <label for="category" class="block text-zinc-300 font-bold mb-2">
                        KATEGORI LAB <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" name="category" id="category" value="{{ old('category', $project->category) }}" required
                           class="w-full px-4 py-2.5 rounded-xl bg-[#070709] border border-white/[0.08] text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-sm">
                </div>
            </div>

            <!-- Tools Used & Demo Link -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="tools_used" class="block text-zinc-300 font-bold mb-2">
                        TOOLS &amp; HARDWARE (PISAHKAN KOMA)
                    </label>
                    <input type="text" name="tools_used" id="tools_used" value="{{ old('tools_used', $project->tools_used) }}"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#070709] border border-white/[0.08] text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-sm">
                </div>

                <div>
                    <label for="demo_link" class="block text-zinc-300 font-bold mb-2">
                        LINK DEMO / REPOSITORI GITHUB (OPSIONAL)
                    </label>
                    <input type="url" name="demo_link" id="demo_link" value="{{ old('demo_link', $project->demo_link) }}"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#070709] border border-white/[0.08] text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-sm">
                </div>
            </div>

            <!-- Current Image & Upload Replacement -->
            <div class="space-y-3">
                <label class="block text-zinc-300 font-bold">
                    GAMBAR TOPOLOGI SAAT INI:
                </label>
                <div class="h-44 max-w-md rounded-2xl bg-[#070709] border border-white/[0.08] overflow-hidden flex items-center justify-center p-3">
                    <img src="{{ $project->image_url }}" alt="" class="h-full object-contain">
                </div>

                <label for="topology_image" class="block text-zinc-300 font-bold pt-2">
                    GANTI FILE GAMBAR TOPOLOGI (OPSIONAL)
                </label>
                <div class="p-4 rounded-2xl bg-[#070709] border border-dashed border-white/[0.12] hover:border-orange-500/50 transition-colors">
                    <input type="file" name="topology_image" id="topology_image" accept="image/*"
                           class="w-full text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-mono file:bg-white/[0.08] file:text-white hover:file:bg-orange-500 hover:file:text-black file:cursor-pointer file:transition-colors">
                </div>
            </div>

            <!-- Featured Checkbox -->
            <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/[0.06] flex items-center gap-3">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}
                       class="h-4 w-4 rounded bg-[#070709] border-white/20 text-orange-500 focus:ring-orange-500">
                <label for="is_featured" class="text-zinc-300 font-bold cursor-pointer select-none">
                    Jadikan sebagai <span class="text-amber-400">Proyek Unggulan</span> di halaman beranda
                </label>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-zinc-300 font-bold mb-2">
                    DOKUMENTASI LANGKAH &amp; DESKRIPSI TEKNIS <span class="text-rose-400">*</span>
                </label>
                <textarea name="description" id="description" rows="12" required
                          class="w-full px-4 py-3 rounded-xl bg-[#070709] border border-white/[0.08] text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-sm leading-relaxed">{{ old('description', $project->description) }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/[0.06]">
                <a href="{{ route('admin.projects.index') }}" class="px-5 py-2.5 rounded-xl bg-white/[0.04] border border-white/[0.08] text-zinc-300 hover:text-white transition-colors">
                    Batal
                </a>
                <button type="submit" class="btn-primary text-xs py-2.5 px-6">
                    Perbarui Proyek &rarr;
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
