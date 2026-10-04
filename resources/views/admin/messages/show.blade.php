@extends('layouts.admin')

@section('title', 'Detail Pesan | ' . $message->subject)
@section('page_title', 'Detail Pesan Masuk')

@section('admin_content')
<div class="max-w-3xl">
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold font-body text-white tracking-tight">Detail <span class="font-display italic font-normal text-stone-300">Pesan Masuk</span></h2>
            <p class="text-xs text-stone-400 font-body mt-0.5">Pesan kontak dari pengunjung portofolio.</p>
        </div>
        <a href="{{ route('admin.messages.index') }}" class="font-body text-xs text-stone-400 hover:text-white transition-colors">
            &larr; Kembali ke Inbox
        </a>
    </div>

    <div class="rounded-2xl border border-white/10 bg-[#141414] p-6 sm:p-8 space-y-6 font-body text-xs shadow-xs">
        
        <!-- Sender & Time Header -->
        <div class="border-b border-white/10 pb-5 space-y-3">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <div class="text-sm font-bold text-white font-body">
                    PENGIRIM: <span class="text-white font-bold">{{ $message->sender_name }}</span>
                </div>
                <span class="text-stone-400 text-[11px] font-mono">
                    DITERIMA: {{ $message->created_at->format('d F Y | H:i:s') }} ({{ $message->created_at->diffForHumans() }})
                </span>
            </div>

            <div class="flex items-center gap-2 text-stone-300">
                <span class="text-stone-500 font-semibold">EMAIL:</span>
                <a href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject) }}" class="text-white font-bold hover:underline font-mono">
                    {{ $message->email }}
                </a>
            </div>

            <div class="flex items-center gap-2 text-stone-300">
                <span class="text-stone-500 font-semibold">SUBJEK:</span>
                <span class="font-bold text-white text-sm font-body">{{ $message->subject }}</span>
            </div>
        </div>

        <!-- Message Body -->
        <div class="rounded-2xl bg-[#0a0a0a] border border-white/10 p-6 text-stone-200 text-sm leading-relaxed whitespace-pre-wrap font-body">
            {{ $message->message }}
        </div>

        <!-- Action Buttons -->
        <div class="pt-4 border-t border-white/10 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <a href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject) }}"
                   class="px-4.5 py-2.5 rounded-xl bg-white text-black text-xs font-body tracking-wider uppercase font-bold hover:bg-neutral-200 transition-all shadow-lg shadow-white/10 flex items-center gap-2 cursor-pointer">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>BALAS VIA EMAIL</span>
                </a>

                <form action="{{ route('admin.messages.toggle-read', $message->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-white/5 border border-white/15 text-stone-300 hover:bg-white hover:text-black font-medium transition-colors cursor-pointer">
                        Tandai {{ $message->is_read ? 'Belum Dibaca' : 'Sudah Dibaca' }}
                    </button>
                </form>
            </div>

            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini secara permanen?');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-rose-950/30 border border-rose-800/40 text-rose-300 hover:bg-rose-900/50 hover:text-white font-medium transition-colors cursor-pointer">
                    Hapus Pesan
                </button>
            </form>
        </div>

    </div>

</div>
@endsection
