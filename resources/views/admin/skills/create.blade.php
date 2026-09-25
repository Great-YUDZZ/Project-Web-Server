@extends('layouts.admin')

@section('title', 'Tambah Skill Baru - Admin Panel TKJ')
@section('page_title', 'Tambah Skill Baru')

@section('admin_content')
<div class="max-w-2xl">
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-stone-900 tracking-tight">Formulir Skill Baru</h2>
            <p class="text-xs text-stone-500 font-mono mt-0.5">Tambahkan kompetensi teknis ke dalam Skill Matrix.</p>
        </div>
        <a href="{{ route('admin.skills.index') }}" class="font-mono text-xs text-stone-500 hover:text-[#0C382E] transition-colors">
            &larr; Batal &amp; Kembali
        </a>
    </div>

    <div class="rounded-2xl border border-stone-200 bg-white p-6 sm:p-8 shadow-xs">
        <form action="{{ route('admin.skills.store') }}" method="POST" class="space-y-6 font-mono text-xs">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-stone-800 font-bold mb-2">
                    NAMA SKILL / KOMPETENSI <span class="text-rose-600">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       placeholder="Misal: Cisco VLAN &amp; Routing / Nginx SSL Reverse Proxy"
                       class="w-full px-4 py-2.5 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 placeholder-stone-400 focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E] text-sm">
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-stone-800 font-bold mb-2">
                    KATEGORI BIDANG <span class="text-rose-600">*</span>
                </label>
                <select name="category" id="category" required
                        class="w-full px-4 py-2.5 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E] text-sm">
                    <option value="networking" {{ old('category') == 'networking' ? 'selected' : '' }}>Networking (Jaringan, Routing, Switching)</option>
                    <option value="sysadmin" {{ old('category') == 'sysadmin' ? 'selected' : '' }}>Sysadmin (Linux Server, LEMP, Virtualisasi)</option>
                    <option value="hardware" {{ old('category') == 'hardware' ? 'selected' : '' }}>Hardware (Kabel UTP/FO, Perakitan PC/Server)</option>
                    <option value="tools" {{ old('category') == 'tools' ? 'selected' : '' }}>Tools (Simulator GNS3, Wireshark, Monitoring)</option>
                </select>
            </div>

            <!-- Level Slider & Input -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label for="level" class="text-stone-800 font-bold">
                        TINGKAT PENGUASAAN (1 - 100%) <span class="text-rose-600">*</span>
                    </label>
                    <span id="level-display" class="font-bold text-[#0C382E] text-sm">85%</span>
                </div>
                <input type="range" name="level" id="level" min="1" max="100" value="{{ old('level', 85) }}" required
                       class="w-full h-2 bg-stone-200 rounded-lg appearance-none cursor-pointer accent-[#0C382E]"
                       oninput="document.getElementById('level-display').innerText = this.value + '%'">
                <div class="flex justify-between text-[10px] text-stone-500 mt-1">
                    <span>1% (Dasar)</span>
                    <span>50% (Menengah)</span>
                    <span>100% (Mahir / Expert)</span>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-stone-200">
                <a href="{{ route('admin.skills.index') }}" class="px-5 py-2.5 rounded-xl bg-stone-100 border border-stone-200 text-stone-700 hover:bg-stone-200 transition-colors font-medium">
                    Batal
                </a>
                <button type="submit" class="btn-earth-green text-xs py-2.5 px-6 font-mono font-bold">
                    Simpan Skill &rarr;
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
