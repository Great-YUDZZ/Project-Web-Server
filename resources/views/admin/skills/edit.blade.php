@extends('layouts.admin')

@section('title', 'Edit Skill - ' . $skill->name)
@section('page_title', 'Edit Skill Matrix')

@section('admin_content')
<div class="max-w-2xl">
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight">Edit Kompetensi Skill</h2>
            <p class="text-xs text-slate-400 font-mono-code mt-0.5">Perbarui nama, kategori, atau persentase penguasaan.</p>
        </div>
        <a href="{{ route('admin.skills.index') }}" class="font-mono-code text-xs text-slate-400 hover:text-white">
            &larr; Batal &amp; Kembali
        </a>
    </div>

    <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6 sm:p-8">
        <form action="{{ route('admin.skills.update', $skill->id) }}" method="POST" class="space-y-6 font-mono-code text-xs">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-slate-300 font-bold mb-2">
                    NAMA SKILL / KOMPETENSI <span class="text-rose-400">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $skill->name) }}" required
                       class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white focus:outline-none focus:border-cyan-500 text-sm">
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-slate-300 font-bold mb-2">
                    KATEGORI BIDANG <span class="text-rose-400">*</span>
                </label>
                <select name="category" id="category" required
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white focus:outline-none focus:border-cyan-500 text-sm">
                    <option value="networking" {{ old('category', $skill->category) == 'networking' ? 'selected' : '' }}>Networking (Jaringan, Routing, Switching)</option>
                    <option value="sysadmin" {{ old('category', $skill->category) == 'sysadmin' ? 'selected' : '' }}>Sysadmin (Linux Server, LEMP, Virtualisasi)</option>
                    <option value="hardware" {{ old('category', $skill->category) == 'hardware' ? 'selected' : '' }}>Hardware (Kabel UTP/FO, Perakitan PC/Server)</option>
                    <option value="tools" {{ old('category', $skill->category) == 'tools' ? 'selected' : '' }}>Tools (Simulator GNS3, Wireshark, Monitoring)</option>
                </select>
            </div>

            <!-- Level Slider & Input -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label for="level" class="text-slate-300 font-bold">
                        TINGKAT PENGUASAAN (1 - 100%) <span class="text-rose-400">*</span>
                    </label>
                    <span id="level-display" class="font-bold text-cyan-400 text-sm">{{ $skill->level }}%</span>
                </div>
                <input type="range" name="level" id="level" min="1" max="100" value="{{ old('level', $skill->level) }}" required
                       class="w-full h-2 bg-slate-900 rounded-lg appearance-none cursor-pointer accent-cyan-500"
                       oninput="document.getElementById('level-display').innerText = this.value + '%'">
                <div class="flex justify-between text-[10px] text-slate-500 mt-1">
                    <span>1% (Pemula)</span>
                    <span>50% (Menengah)</span>
                    <span>100% (Mahir / Expert)</span>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('admin.skills.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-300 hover:text-white">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-cyan-500 text-black font-bold hover:bg-cyan-400 transition-colors">
                    PERBARUI SKILL &rarr;
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
