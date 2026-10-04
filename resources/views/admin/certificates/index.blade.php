@extends('layouts.admin')

@section('title', 'Kelola Sertifikat | Admin Panel TKJ')
@section('page_title', 'Kelola Kredensial & Sertifikasi')

@section('admin_content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold font-body text-white tracking-tight">Kredensial &amp; Sertifikasi Resmi</h2>
            <p class="text-xs text-stone-400 font-body mt-0.5">Kelola sertifikat pelatihan resmi, nomor registrasi kredensial, dan dokumen validasi.</p>
        </div>

        <a href="{{ route('admin.certificates.create') }}" class="px-4.5 py-2.5 rounded-xl bg-white text-black text-xs font-body tracking-wider uppercase font-bold hover:bg-neutral-200 transition-all shadow-lg shadow-white/10 flex items-center gap-2 self-start sm:self-auto cursor-pointer">
            <span>+ TAMBAH SERTIFIKAT</span>
        </a>
    </div>

    <!-- Search / Filter -->
    <div class="p-4 rounded-2xl bg-[#141414] border border-white/10 shadow-xs">
        <form action="{{ route('admin.certificates.index') }}" method="GET" class="flex gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama sertifikat, penerbit, nomor registrasi, atau kompetensi..."
                   class="flex-1 px-4 py-2 rounded-xl bg-[#0a0a0a] border border-white/15 text-white placeholder-stone-600 text-xs font-body focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 transition-all">
            <button type="submit" class="px-4 py-2 rounded-xl bg-white/10 border border-white/15 text-stone-200 hover:bg-white hover:text-black text-xs font-body font-medium transition-colors cursor-pointer">
                Cari
            </button>
            @if(request('q'))
                <a href="{{ route('admin.certificates.index') }}" class="px-3 py-2 rounded-xl bg-white/5 border border-white/10 text-stone-400 hover:text-white text-xs font-body flex items-center justify-center">
                    ✕
                </a>
            @endif
        </form>
    </div>

    <!-- Certificates Table -->
    <div class="rounded-2xl border border-white/10 bg-[#141414] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-body text-xs">
                <thead>
                    <tr class="border-b border-white/10 text-stone-400 bg-white/[0.04] font-semibold">
                        <th class="py-3.5 px-4">DOKUMEN</th>
                        <th class="py-3.5 px-4">JUDUL SERTIFIKAT &amp; PENERBIT</th>
                        <th class="py-3.5 px-4">NOMOR KREDENSIAL</th>
                        <th class="py-3.5 px-4">PERIODE &amp; JP</th>
                        <th class="py-3.5 px-4">STATUS VALIDASI</th>
                        <th class="py-3.5 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-stone-300">
                    @forelse($certificates as $cert)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="h-11 w-11 rounded-xl bg-[#0a0a0a] border border-white/10 flex items-center justify-center text-white overflow-hidden">
                                    @if($cert->file_path)
                                        @if($cert->is_pdf)
                                            <svg class="w-5 h-5 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        @else
                                            <img src="{{ $cert->file_url }}" alt="" class="h-full w-full object-cover">
                                        @endif
                                    @else
                                        <svg class="w-5 h-5 text-stone-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-white text-sm hover:text-stone-300 transition-colors">
                                    {{ $cert->title }}
                                </div>
                                <div class="text-[11px] text-stone-500 mt-0.5">{{ $cert->issuer }}</div>
                                @if($cert->is_featured)
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[9px] font-bold bg-white/20 text-white border border-white/30">
                                        ★ DITAMPILKAN DI PUBLIK
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                @if($cert->credential_id)
                                    <span class="text-stone-300 text-[11px]">{{ $cert->credential_id }}</span>
                                @else
                                    <span class="text-stone-500">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-stone-400 text-[11px]">
                                <div>{{ $cert->issued_date ?? '-' }}</div>
                                @if($cert->duration_hours)
                                    <div class="text-stone-300 font-bold text-[10px] mt-0.5">{{ $cert->duration_hours }}</div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                @if($cert->verification_status)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-white/10 text-white border border-white/15 w-fit flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]"></span>
                                        <span>{{ $cert->verification_status }}</span>
                                    </span>
                                @else
                                    <span class="text-stone-500 text-[10px]">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($cert->file_path)
                                        <a href="{{ $cert->file_url }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/15 text-stone-300 hover:bg-white hover:text-black transition-colors font-medium" title="Lihat Dokumen">
                                            Berkas &nearr;
                                        </a>
                                    @elseif($cert->credential_url)
                                        <a href="{{ $cert->credential_url }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/15 text-stone-300 hover:bg-white hover:text-black transition-colors font-medium" title="Verifikasi Online">
                                            Link &nearr;
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.certificates.edit', $cert->id) }}" class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/15 text-stone-300 hover:bg-white hover:text-black transition-colors font-medium">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.certificates.destroy', $cert->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-950/30 border border-rose-800/40 text-rose-300 hover:bg-rose-900/50 hover:text-white transition-colors font-medium cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-stone-500">
                                Belum ada sertifikat terdaftar. Klik "+ TAMBAH SERTIFIKAT" untuk menambahkan kredensial pertama.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($certificates->hasPages())
            <div class="p-4 border-t border-white/10 bg-[#0d0d0d]">
                {{ $certificates->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
