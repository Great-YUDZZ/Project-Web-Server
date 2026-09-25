@extends('layouts.admin')

@section('title', 'Edit Sertifikat - ' . $certificate->title)
@section('page_title', 'Edit Kredensial')

@section('admin_content')
<div class="max-w-4xl">
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-stone-900 tracking-tight">Perbarui Kredensial &amp; Sertifikat</h2>
            <p class="text-xs text-stone-500 font-mono mt-0.5">Perbarui nomor registrasi, status validasi, materi, atau berkas sertifikat.</p>
        </div>
        <a href="{{ route('admin.certificates.index') }}" class="font-mono text-xs text-stone-500 hover:text-[#0C382E] transition-colors">
            &larr; Batal &amp; Kembali
        </a>
    </div>

    <div class="rounded-2xl border border-stone-200 bg-white p-6 sm:p-8 shadow-xs">
        <form action="{{ route('admin.certificates.update', $certificate->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 font-mono text-xs">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label for="title" class="block text-stone-800 font-bold mb-2">
                    NAMA SERTIFIKAT / PROGRAM PELATIHAN <span class="text-rose-600">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title', $certificate->title) }}" required
                       class="w-full px-4 py-2.5 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E] text-sm">
            </div>

            <!-- Issuer & Credential ID Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="issuer" class="block text-stone-800 font-bold mb-2">
                        LEMBAGA PENERBIT / INSTANSI <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" name="issuer" id="issuer" value="{{ old('issuer', $certificate->issuer) }}" required
                            class="w-full px-4 py-2.5 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E] text-sm">
                </div>

                <div>
                    <label for="credential_id" class="block text-stone-800 font-bold mb-2">
                        NOMOR SERTIFIKAT / REGISTRASI KREDENSIAL
                    </label>
                    <input type="text" name="credential_id" id="credential_id" value="{{ old('credential_id', $certificate->credential_id) }}"
                            class="w-full px-4 py-2.5 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E] text-sm">
                </div>
            </div>

            <!-- Issued Date, Duration, and Verification Status Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="issued_date" class="block text-stone-800 font-bold mb-2">
                        TANGGAL / PERIODE TERBIT
                    </label>
                    <input type="text" name="issued_date" id="issued_date" value="{{ old('issued_date', $certificate->issued_date) }}"
                            placeholder="Misal: 3 September 2026"
                            class="w-full px-4 py-2.5 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E] text-sm">
                </div>

                <div>
                    <label for="duration_hours" class="block text-stone-800 font-bold mb-2">
                        BOBOT / DURASI (JAM PELAJARAN)
                    </label>
                    <input type="text" name="duration_hours" id="duration_hours" value="{{ old('duration_hours', $certificate->duration_hours) }}"
                            placeholder="Misal: 9 JP"
                            class="w-full px-4 py-2.5 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E] text-sm">
                </div>

                <div>
                    <label for="verification_status" class="block text-stone-800 font-bold mb-2">
                        STATUS VALIDASI / TTE
                    </label>
                    <input type="text" name="verification_status" id="verification_status" value="{{ old('verification_status', $certificate->verification_status) }}"
                            class="w-full px-4 py-2.5 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E] text-sm">
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-stone-800 font-bold mb-2">
                    MATERI KOMPETENSI / SILABUS YANG DIKUASAI
                </label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-4 py-2.5 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E] text-sm">{{ old('description', $certificate->description) }}</textarea>
            </div>

            <!-- Online Verification URL & Order Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="sm:col-span-2">
                    <label for="credential_url" class="block text-stone-800 font-bold mb-2">
                        LINK VERIFIKASI RESMI ONLINE (OPSIONAL)
                    </label>
                    <input type="url" name="credential_url" id="credential_url" value="{{ old('credential_url', $certificate->credential_url) }}"
                            placeholder="https://komdigi.go.id/verifikasi/..."
                            class="w-full px-4 py-2.5 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E] text-sm">
                </div>

                <div>
                    <label for="order" class="block text-stone-800 font-bold mb-2">
                        URUTAN TAMPILAN
                    </label>
                    <input type="number" name="order" id="order" value="{{ old('order', $certificate->order) }}" min="0"
                            class="w-full px-4 py-2.5 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E] text-sm">
                </div>
            </div>

            <!-- Existing File Preview & Replacement Upload -->
            <div>
                <label for="certificate_file" class="block text-stone-800 font-bold mb-2">
                    BERKAS SERTIFIKAT
                </label>

                @if($certificate->file_path)
                    <div class="mb-3 p-3 rounded-xl bg-stone-50 border border-stone-200 flex items-center justify-between">
                        <div class="flex items-center gap-2.5 text-xs text-stone-700">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span>Berkas tersimpan saat ini:</span>
                            <a href="{{ $certificate->file_url }}" target="_blank" class="text-[#0C382E] font-semibold hover:underline">
                                Buka Dokumen &nearr;
                            </a>
                        </div>
                        <span class="text-[10px] text-stone-400 font-mono">Upload file baru di bawah jika ingin mengganti.</span>
                    </div>
                @endif

                <div class="p-4 rounded-2xl bg-[#FAF8F5] border-2 border-dashed border-stone-300 hover:border-[#0C382E] transition-colors">
                    <input type="file" name="certificate_file" id="certificate_file" accept=".pdf,image/*"
                            class="w-full text-stone-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-mono file:bg-stone-200 file:text-stone-800 hover:file:bg-[#0C382E] hover:file:text-white file:cursor-pointer file:transition-colors">
                    <p class="text-[11px] text-stone-500 mt-2">Biarkan kosong jika tidak ingin mengubah berkas sertifikat yang sudah ada.</p>
                </div>
            </div>

            <!-- Is Featured Checkbox -->
            <div class="p-4 rounded-2xl bg-[#FAF8F5] border border-stone-200 flex items-center gap-3">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $certificate->is_featured) ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-stone-300 text-[#0C382E] focus:ring-[#0C382E]">
                <label for="is_featured" class="text-stone-800 font-bold select-none cursor-pointer">
                    Tampilkan di Bagian "Sertifikasi Kejuruan" Halaman Utama Portofolio
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-stone-200">
                <a href="{{ route('admin.certificates.index') }}" class="px-5 py-2.5 rounded-xl bg-stone-100 border border-stone-200 text-stone-700 hover:bg-stone-200 transition-colors font-medium">
                    Batal
                </a>
                <button type="submit" class="btn-earth-green text-xs py-2.5 px-6 font-mono font-bold">
                    Perbarui Sertifikat &rarr;
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
