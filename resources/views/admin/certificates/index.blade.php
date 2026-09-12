@extends('layouts.admin')

@section('title', 'Kelola Sertifikat - Admin Panel TKJ')
@section('page_title', 'Kelola Kredensial & Sertifikasi')

@section('admin_content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight">Kredensial &amp; Sertifikasi Resmi</h2>
            <p class="text-xs text-zinc-400 font-mono mt-0.5">Kelola sertifikat pelatihan resmi, nomor registrasi kredensial, dan dokumen validasi.</p>
        </div>

        <a href="{{ route('admin.certificates.create') }}" class="btn-primary text-xs py-2.5 px-4 flex items-center gap-2 self-start sm:self-auto">
            <span>+ TAMBAH SERTIFIKAT</span>
        </a>
    </div>

    <!-- Search / Filter -->
    <div class="p-4 rounded-2xl bg-[#0d0e14]/80 border border-white/[0.08] backdrop-blur-xl">
        <form action="{{ route('admin.certificates.index') }}" method="GET" class="flex gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama sertifikat, penerbit, nomor registrasi, atau kompetensi..."
                   class="flex-1 px-4 py-2 rounded-xl bg-[#070709] border border-white/[0.08] text-white placeholder-zinc-500 text-xs font-mono focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500">
            <button type="submit" class="px-4 py-2 rounded-xl bg-white/[0.04] border border-white/[0.08] text-zinc-300 hover:text-white hover:bg-white/[0.08] text-xs font-mono transition-colors">
                Cari
            </button>
            @if(request('q'))
                <a href="{{ route('admin.certificates.index') }}" class="px-3 py-2 rounded-xl bg-white/[0.04] border border-white/[0.08] text-zinc-400 hover:text-white text-xs font-mono flex items-center justify-center">
                    ✕
                </a>
            @endif
        </form>
    </div>

    <!-- Certificates Table -->
    <div class="rounded-3xl border border-white/[0.08] bg-[#0d0e14]/80 backdrop-blur-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-mono text-xs">
                <thead>
                    <tr class="border-b border-white/[0.06] text-zinc-400 bg-white/[0.02]">
                        <th class="py-3.5 px-4">DOKUMEN</th>
                        <th class="py-3.5 px-4">JUDUL SERTIFIKAT &amp; PENERBIT</th>
                        <th class="py-3.5 px-4">NOMOR KREDENSIAL</th>
                        <th class="py-3.5 px-4">PERIODE &amp; JP</th>
                        <th class="py-3.5 px-4">STATUS VALIDASI</th>
                        <th class="py-3.5 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.04]">
                    @forelse($certificates as $cert)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="h-11 w-11 rounded-xl bg-white/[0.03] border border-white/[0.08] flex items-center justify-center text-orange-400 overflow-hidden">
                                    @if($cert->file_path)
                                        @if($cert->is_pdf)
                                            <svg class="w-5 h-5 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        @else
                                            <img src="{{ $cert->file_url }}" alt="" class="h-full w-full object-cover">
                                        @endif
                                    @else
                                        <svg class="w-5 h-5 text-orange-400/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-white text-sm hover:text-orange-400 transition-colors">
                                    {{ $cert->title }}
                                </div>
                                <div class="text-[11px] text-zinc-400 mt-0.5">{{ $cert->issuer }}</div>
                                @if($cert->is_featured)
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-[9px] font-bold">
                                        ★ DITAMPILKAN DI PUBLIK
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-zinc-300">
                                @if($cert->credential_id)
                                    <span class="text-zinc-300 text-[11px]">{{ $cert->credential_id }}</span>
                                @else
                                    <span class="text-zinc-600">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-zinc-400 text-[11px]">
                                <div>{{ $cert->issued_date ?? '-' }}</div>
                                @if($cert->duration_hours)
                                    <div class="text-orange-400/90 text-[10px] mt-0.5">{{ $cert->duration_hours }}</div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                @if($cert->verification_status)
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-semibold flex items-center gap-1.5 w-fit">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                        <span>{{ $cert->verification_status }}</span>
                                    </span>
                                @else
                                    <span class="text-zinc-600 text-[10px]">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($cert->file_path)
                                        <a href="{{ $cert->file_url }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-white/[0.04] border border-white/[0.08] text-zinc-300 hover:text-white hover:border-white/20 transition-colors" title="Lihat Dokumen">
                                            Berkas &nearr;
                                        </a>
                                    @elseif($cert->credential_url)
                                        <a href="{{ $cert->credential_url }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-white/[0.04] border border-white/[0.08] text-zinc-300 hover:text-white hover:border-white/20 transition-colors" title="Verifikasi Online">
                                            Link &nearr;
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.certificates.edit', $cert->id) }}" class="px-2.5 py-1 rounded-lg bg-white/[0.04] border border-white/[0.08] text-zinc-300 hover:text-orange-400 hover:border-orange-500/30 transition-colors">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.certificates.destroy', $cert->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-500/10 border border-rose-500/20 text-rose-400 hover:bg-rose-500 hover:text-white transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-zinc-500">
                                Belum ada sertifikat terdaftar. Klik "+ TAMBAH SERTIFIKAT" untuk menambahkan kredensial pertama.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($certificates->hasPages())
            <div class="p-4 border-t border-white/[0.06]">
                {{ $certificates->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
