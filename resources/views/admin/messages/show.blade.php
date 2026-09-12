@extends('layouts.admin')

@section('title', 'Detail Pesan - ' . $message->subject)
@section('page_title', 'Detail Pesan Masuk')

@section('admin_content')
<div class="max-w-3xl">
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight">Detail Pesan Masuk</h2>
            <p class="text-xs text-zinc-400 font-mono mt-0.5">Pesan kontak dari pengunjung portofolio.</p>
        </div>
        <a href="{{ route('admin.messages.index') }}" class="font-mono text-xs text-zinc-400 hover:text-orange-400 transition-colors">
            &larr; Kembali ke Inbox
        </a>
    </div>

    <div class="rounded-3xl border border-white/[0.08] bg-[#0d0e14]/80 backdrop-blur-xl p-6 sm:p-8 space-y-6 font-mono text-xs">
        
        <!-- Sender & Time Header -->
        <div class="border-b border-white/[0.06] pb-5 space-y-3">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <div class="text-sm font-bold text-white">
                    PENGIRIM: <span class="text-orange-400">{{ $message->sender_name }}</span>
                </div>
                <span class="text-zinc-500 text-[11px]">
                    DITERIMA: {{ $message->created_at->format('d F Y - H:i:s') }} ({{ $message->created_at->diffForHumans() }})
                </span>
            </div>

            <div class="flex items-center gap-2 text-zinc-300">
                <span class="text-zinc-500">EMAIL:</span>
                <a href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject) }}" class="text-orange-400 hover:underline">
                    {{ $message->email }}
                </a>
            </div>

            <div class="flex items-center gap-2 text-zinc-300">
                <span class="text-zinc-500">SUBJEK:</span>
                <span class="font-bold text-white text-sm">{{ $message->subject }}</span>
            </div>
        </div>

        <!-- Message Body -->
        <div class="rounded-2xl bg-[#070709] border border-white/[0.08] p-6 text-zinc-200 text-sm leading-relaxed whitespace-pre-wrap font-sans">
            {{ $message->message }}
        </div>

        <!-- Action Buttons -->
        <div class="pt-4 border-t border-white/[0.06] flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <a href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject) }}"
                   class="btn-primary text-xs py-2.5 px-4 flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>BALAS VIA EMAIL</span>
                </a>

                <form action="{{ route('admin.messages.toggle-read', $message->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-white/[0.04] border border-white/[0.08] text-zinc-300 hover:text-white transition-colors">
                        Tandai {{ $message->is_read ? 'Belum Dibaca' : 'Sudah Dibaca' }}
                    </button>
                </form>
            </div>

            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini secara permanen?');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 hover:bg-rose-500 hover:text-white transition-colors">
                    Hapus Pesan
                </button>
            </form>
        </div>

    </div>

</div>
@endsection
