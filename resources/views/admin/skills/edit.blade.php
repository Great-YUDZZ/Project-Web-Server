@extends('layouts.admin')

@section('title', 'Edit Skill | ' . $skill->name)
@section('page_title', 'Edit Skill Matrix')

@section('admin_content')
<div class="max-w-2xl">
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold font-body text-white tracking-tight">Edit Kompetensi <span class="font-display font-semibold text-stone-300">Skill Matrix</span></h2>
            <p class="text-xs text-stone-400 font-body mt-0.5">Perbarui nama, kategori, atau persentase penguasaan kompetensi.</p>
        </div>
        <a href="{{ route('admin.skills.index') }}" class="font-body text-xs text-stone-400 hover:text-white transition-colors">
            &larr; Batal &amp; Kembali
        </a>
    </div>

    <div class="rounded-2xl border border-white/10 bg-[#141414] p-6 sm:p-8 shadow-xs">
        <form action="{{ route('admin.skills.update', $skill->id) }}" method="POST" class="space-y-6 font-body text-xs">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-stone-300 font-bold mb-2">
                    NAMA SKILL / KOMPETENSI <span class="text-rose-400">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $skill->name) }}" required
                       class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0a] border border-white/15 text-white focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 text-sm transition-all">
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-stone-300 font-bold mb-2">
                    KATEGORI BIDANG <span class="text-rose-400">*</span>
                </label>
                <select name="category" id="category" required
                        class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0a] border border-white/15 text-white focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 text-sm transition-all">
                    <option value="networking" {{ old('category', $skill->category) == 'networking' ? 'selected' : '' }}>Networking (Jaringan, Routing, Switching)</option>
                    <option value="sysadmin" {{ old('category', $skill->category) == 'sysadmin' ? 'selected' : '' }}>Sysadmin (Linux Server, LEMP, Virtualisasi)</option>
                    <option value="hardware" {{ old('category', $skill->category) == 'hardware' ? 'selected' : '' }}>Hardware (Kabel UTP/FO, Perakitan PC/Server)</option>
                    <option value="tools" {{ old('category', $skill->category) == 'tools' ? 'selected' : '' }}>Tools (Simulator GNS3, Wireshark, Monitoring)</option>
                </select>
            </div>

            <!-- Level Slider & Input -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label for="level" class="text-stone-300 font-bold">
                        TINGKAT PENGUASAAN (1 - 100%) <span class="text-rose-400">*</span>
                    </label>
                    <span id="level-display" class="font-bold text-white text-sm">{{ $skill->level }}%</span>
                </div>
                <input type="range" name="level" id="level" min="1" max="100" value="{{ old('level', $skill->level) }}" required
                       class="w-full h-2 bg-white/10 rounded-lg appearance-none cursor-pointer accent-white"
                       oninput="document.getElementById('level-display').innerText = this.value + '%'">
                <div class="flex justify-between text-[10px] text-stone-500 mt-1">
                    <span>1% (Dasar)</span>
                    <span>50% (Menengah)</span>
                    <span>100% (Mahir / Expert)</span>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/10">
                <a href="{{ route('admin.skills.index') }}" class="px-5 py-2.5 rounded-xl bg-white/5 border border-white/15 text-stone-300 hover:bg-white/10 hover:text-white transition-colors font-medium">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-white text-black text-xs font-body tracking-wider uppercase font-bold hover:bg-neutral-200 transition-all shadow-lg shadow-white/10 cursor-pointer">
                    Perbarui Skill &rarr;
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
