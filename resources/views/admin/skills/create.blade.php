@extends('layouts.admin')

@section('title', 'Tambah Skill Baru - Admin Panel TKJ')
@section('page_title', 'Tambah Skill Baru')

@section('admin_content')
<div class="max-w-2xl">
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight">Formulir Skill Baru</h2>
            <p class="text-xs text-zinc-400 font-mono mt-0.5">Tambahkan kompetensi teknis ke dalam Skill Matrix.</p>
        </div>
        <a href="{{ route('admin.skills.index') }}" class="font-mono text-xs text-zinc-400 hover:text-orange-400 transition-colors">
            &larr; Batal &amp; Kembali
        </a>
    </div>

    <div class="rounded-3xl border border-white/[0.08] bg-[#0d0e14]/80 backdrop-blur-xl p-6 sm:p-8">
        <form action="{{ route('admin.skills.store') }}" method="POST" class="space-y-6 font-mono text-xs">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-zinc-300 font-bold mb-2">
                    NAMA SKILL / KOMPETENSI <span class="text-rose-400">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       placeholder="Misal: Cisco VLAN &amp; Routing / Nginx SSL Reverse Proxy"
                       class="w-full px-4 py-2.5 rounded-xl bg-[#070709] border border-white/[0.08] text-white placeholder-zinc-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-sm">
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-zinc-300 font-bold mb-2">
                    KATEGORI BIDANG <span class="text-rose-400">*</span>
                </label>
                <select name="category" id="category" required
                        class="w-full px-4 py-2.5 rounded-xl bg-[#070709] border border-white/[0.08] text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-sm">
                    <option value="networking" {{ old('category') == 'networking' ? 'selected' : '' }}>Networking (Jaringan, Routing, Switching)</option>
                    <option value="sysadmin" {{ old('category') == 'sysadmin' ? 'selected' : '' }}>Sysadmin (Linux Server, LEMP, Virtualisasi)</option>
                    <option value="hardware" {{ old('category') == 'hardware' ? 'selected' : '' }}>Hardware (Kabel UTP/FO, Perakitan PC/Server)</option>
                    <option value="tools" {{ old('category') == 'tools' ? 'selected' : '' }}>Tools (Simulator GNS3, Wireshark, Monitoring)</option>
                </select>
            </div>

            <!-- Level Slider & Input -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label for="level" class="text-zinc-300 font-bold">
                        TINGKAT PENGUASAAN (1 - 100%) <span class="text-rose-400">*</span>
                    </label>
                    <span id="level-display" class="font-bold text-orange-400 text-sm">85%</span>
                </div>
                <input type="range" name="level" id="level" min="1" max="100" value="{{ old('level', 85) }}" required
                       class="w-full h-2 bg-[#070709] rounded-lg appearance-none cursor-pointer accent-orange-500 border border-white/[0.08]"
                       oninput="document.getElementById('level-display').innerText = this.value + '%'">
                <div class="flex justify-between text-[10px] text-zinc-500 mt-1">
                    <span>1% (Dasar)</span>
                    <span>50% (Menengah)</span>
                    <span>100% (Mahir / Expert)</span>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/[0.06]">
                <a href="{{ route('admin.skills.index') }}" class="px-5 py-2.5 rounded-xl bg-white/[0.04] border border-white/[0.08] text-zinc-300 hover:text-white transition-colors">
                    Batal
                </a>
                <button type="submit" class="btn-primary text-xs py-2.5 px-6">
                    Simpan Skill &rarr;
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
