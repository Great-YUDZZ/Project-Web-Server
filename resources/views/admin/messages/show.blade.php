@extends('layouts.admin')

@section('title', 'Detail Pesan - ' . $message->subject)
@section('page_title', 'Detail Pesan Masuk')

@section('admin_content')
<div class="max-w-3xl">
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-stone-900 tracking-tight">Detail Pesan Masuk</h2>
            <p class="text-xs text-stone-500 font-mono mt-0.5">Pesan kontak dari pengunjung portofolio.</p>
        </div>
        <a href="{{ route('admin.messages.index') }}" class="font-mono text-xs text-stone-500 hover:text-[#0C382E] transition-colors">
            &larr; Kembali ke Inbox
        </a>
    </div>

    <div class="rounded-2xl border border-stone-200 bg-white p-6 sm:p-8 space-y-6 font-mono text-xs shadow-xs">
        
        <!-- Sender & Time Header -->
        <div class="border-b border-stone-200 pb-5 space-y-3">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <div class="text-sm font-bold text-stone-900">
                    PENGIRIM: <span class="text-[#0C382E] font-bold">{{ $message->sender_name }}</span>
                </div>
                <span class="text-stone-500 text-[11px]">
                    DITERIMA: {{ $message->created_at->format('d F Y - H:i:s') }} ({{ $message->created_at->diffForHumans() }})
                </span>
            </div>

            <div class="flex items-center gap-2 text-stone-700">
                <span class="text-stone-500 font-semibold">EMAIL:</span>
                <a href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject) }}" class="text-[#0C382E] font-bold hover:underline">
                    {{ $message->email }}
                </a>
            </div>

            <div class="flex items-center gap-2 text-stone-700">
                <span class="text-stone-500 font-semibold">SUBJEK:</span>
                <span class="font-bold text-stone-900 text-sm">{{ $message->subject }}</span>
            </div>
        </div>

        <!-- Message Body -->
        <div class="rounded-2xl bg-[#FAF8F5] border border-stone-200 p-6 text-stone-800 text-sm leading-relaxed whitespace-pre-wrap font-sans">
            {{ $message->message }}
        </div>

        <!-- Action Buttons -->
        <div class="pt-4 border-t border-stone-200 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <a href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject) }}"
                   class="btn-earth-green text-xs py-2.5 px-4.5 flex items-center gap-2 font-mono font-bold">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>BALAS VIA EMAIL</span>
                </a>

                <form action="{{ route('admin.messages.toggle-read', $message->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-stone-100 border border-stone-200 text-stone-700 hover:bg-stone-200 font-medium transition-colors">
                        Tandai {{ $message->is_read ? 'Belum Dibaca' : 'Sudah Dibaca' }}
                    </button>
                </form>
            </div>

            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini secara permanen?');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 hover:bg-rose-100 font-medium transition-colors">
                    Hapus Pesan
                </button>
            </form>
        </div>

    </div>

</div>
@endsection
