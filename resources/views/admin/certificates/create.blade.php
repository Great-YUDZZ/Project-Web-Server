@extends('layouts.admin')

@section('title', 'Tambah Sertifikat Baru - Admin Panel TKJ')
@section('page_title', 'Tambah Kredensial Baru')

@section('admin_content')
<div class="max-w-4xl">
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight">Formulir Kredensial &amp; Sertifikat Baru</h2>
            <p class="text-xs text-zinc-400 font-mono mt-0.5">Tambahkan sertifikat pelatihan resmi, kredensial industri, dan dokumen bukti.</p>
        </div>
        <a href="{{ route('admin.certificates.index') }}" class="font-mono text-xs text-zinc-400 hover:text-orange-400 transition-colors">
            &larr; Batal &amp; Kembali
        </a>
    </div>

    <div class="rounded-3xl border border-white/[0.08] bg-[#0d0e14]/80 backdrop-blur-xl p-6 sm:p-8">
        <form action="{{ route('admin.certificates.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 font-mono text-xs">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block text-zinc-300 font-bold mb-2">
                    NAMA SERTIFIKAT / PROGRAM PELATIHAN <span class="text-rose-400">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                       placeholder="Misal: Fundamental of Optic Installation &amp; Activation Technician"
                       class="w-full px-4 py-2.5 rounded-xl bg-[#070709] border border-white/[0.08] text-white placeholder-zinc-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-sm">
            </div>

            <!-- Issuer & Credential ID Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="issuer" class="block text-zinc-300 font-bold mb-2">
                        LEMBAGA PENERBIT / INSTANSI <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" name="issuer" id="issuer" value="{{ old('issuer') }}" required
                           placeholder="Misal: BLSDM Komdigi Yogyakarta / Cisco Networking Academy"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#070709] border border-white/[0.08] text-white placeholder-zinc-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-sm">
                </div>

                <div>
                    <label for="credential_id" class="block text-zinc-300 font-bold mb-2">
                        NOMOR SERTIFIKAT / REGISTRASI KREDENSIAL
                    </label>
                    <input type="text" name="credential_id" id="credential_id" value="{{ old('credential_id') }}"
                           placeholder="Misal: 212131071110-18/DTA/BLSDM.Komdigi/2026"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#070709] border border-white/[0.08] text-white placeholder-zinc-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-sm">
                </div>
            </div>

            <!-- Issued Date, Duration, and Verification Status Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="issued_date" class="block text-zinc-300 font-bold mb-2">
                        TANGGAL / PERIODE TERBIT
                    </label>
                    <input type="text" name="issued_date" id="issued_date" value="{{ old('issued_date') }}"
                           placeholder="Misal: 3 September 2026"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#070709] border border-white/[0.08] text-white placeholder-zinc-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-sm">
                </div>

                <div>
                    <label for="duration_hours" class="block text-zinc-300 font-bold mb-2">
                        BOBOT / DURASI (JAM PELAJARAN)
                    </label>
                    <input type="text" name="duration_hours" id="duration_hours" value="{{ old('duration_hours') }}"
                           placeholder="Misal: 9 JP / 32 Jam"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#070709] border border-white/[0.08] text-white placeholder-zinc-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-sm">
                </div>

                <div>
                    <label for="verification_status" class="block text-zinc-300 font-bold mb-2">
                        STATUS VALIDASI / TTE
                    </label>
                    <input type="text" name="verification_status" id="verification_status" value="{{ old('verification_status', 'TTE Elektronik BSrE BSSN Valid') }}"
                           placeholder="Misal: BSrE BSSN Valid / QR Validated"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#070709] border border-white/[0.08] text-white placeholder-zinc-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-sm">
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-zinc-300 font-bold mb-2">
                    MATERI KOMPETENSI / SILABUS YANG DIKUASAI
                </label>
                <textarea name="description" id="description" rows="3"
                          placeholder="Misal: Penerapan Prosedur K3 (3 JP), Penyusunan Laporan Tertulis (3 JP), dan Instalasi Kabel Fiber Optik Ruangan/Gedung (3 JP)."
                          class="w-full px-4 py-2.5 rounded-xl bg-[#070709] border border-white/[0.08] text-white placeholder-zinc-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-sm">{{ old('description') }}</textarea>
            </div>

            <!-- Online Verification URL & Order Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="sm:col-span-2">
                    <label for="credential_url" class="block text-zinc-300 font-bold mb-2">
                        LINK VERIFIKASI RESMI ONLINE (OPSIONAL)
                    </label>
                    <input type="url" name="credential_url" id="credential_url" value="{{ old('credential_url') }}"
                           placeholder="https://komdigi.go.id/verifikasi/..."
                           class="w-full px-4 py-2.5 rounded-xl bg-[#070709] border border-white/[0.08] text-white placeholder-zinc-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-sm">
                </div>

                <div>
                    <label for="order" class="block text-zinc-300 font-bold mb-2">
                        URUTAN TAMPILAN
                    </label>
                    <input type="number" name="order" id="order" value="{{ old('order', 0) }}" min="0"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#070709] border border-white/[0.08] text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-sm">
                </div>
            </div>

            <!-- Certificate File Upload -->
            <div>
                <label for="certificate_file" class="block text-zinc-300 font-bold mb-2">
                    UNGGAH BERKAS SERTIFIKAT (PDF / JPG / PNG, MAKS 5MB)
                </label>
                <div class="p-4 rounded-2xl bg-[#070709] border border-dashed border-white/[0.12] hover:border-orange-500/50 transition-colors">
                    <input type="file" name="certificate_file" id="certificate_file" accept=".pdf,image/*"
                           class="w-full text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-mono file:bg-white/[0.08] file:text-white hover:file:bg-orange-500 hover:file:text-black file:cursor-pointer file:transition-colors">
                    <p class="text-[11px] text-zinc-500 mt-2">Dukungan format PDF e-sertifikat bertandatangan digital atau tangkapan gambar piagam resmi.</p>
                </div>
            </div>

            <!-- Is Featured Checkbox -->
            <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/[0.06] flex items-center gap-3">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', true) ? 'checked' : '' }}
                       class="h-4 w-4 rounded bg-[#070709] border-white/20 text-orange-500 focus:ring-orange-500">
                <label for="is_featured" class="text-zinc-300 font-bold select-none cursor-pointer">
                    Tampilkan di Bagian "Sertifikasi Kejuruan" Halaman Utama Portofolio
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/[0.06]">
                <a href="{{ route('admin.certificates.index') }}" class="px-5 py-2.5 rounded-xl bg-white/[0.04] border border-white/[0.08] text-zinc-300 hover:text-white transition-colors">
                    Batal
                </a>
                <button type="submit" class="btn-primary text-xs py-2.5 px-6">
                    Simpan Sertifikat
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
