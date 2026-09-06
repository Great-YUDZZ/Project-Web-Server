@extends('layouts.admin')

@section('title', 'Inbox Pesan Masuk - Admin Panel TKJ')
@section('page_title', 'Inbox Pesan Kontak')

@section('admin_content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight">Inbox Pesan Masuk</h2>
            <p class="text-xs text-slate-400 font-mono-code mt-0.5">Pesan dan transmisi kontak dari pengunjung portofolio.</p>
        </div>

        @if($unreadCount > 0)
            <div class="px-3.5 py-1.5 rounded-full bg-rose-500/15 border border-rose-500/30 text-rose-400 font-mono-code text-xs font-semibold self-start sm:self-auto flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-rose-500 animate-ping"></span>
                <span>{{ $unreadCount }} PESAN BELUM DIBACA</span>
            </div>
        @endif
    </div>

    <!-- Filter Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4 p-4 rounded-xl bg-slate-950 border border-slate-800 font-mono-code text-xs">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.messages.index') }}" class="px-3 py-1.5 rounded-lg {{ !request('status') ? 'bg-cyan-500 text-black font-bold' : 'bg-slate-900 text-slate-300 hover:text-white' }}">
                Semua Pesan ({{ \App\Models\Message::count() }})
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" class="px-3 py-1.5 rounded-lg {{ request('status') === 'unread' ? 'bg-rose-500 text-white font-bold' : 'bg-slate-900 text-slate-300 hover:text-white' }}">
                Belum Dibaca ({{ $unreadCount }})
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'read']) }}" class="px-3 py-1.5 rounded-lg {{ request('status') === 'read' ? 'bg-slate-800 text-white font-bold' : 'bg-slate-900 text-slate-300 hover:text-white' }}">
                Sudah Dibaca
            </a>
        </div>

        <form action="{{ route('admin.messages.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, subjek..."
                   class="px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-800 text-white placeholder-slate-500 text-xs focus:outline-none focus:border-cyan-500">
            <button type="submit" class="px-3 py-1.5 rounded-lg bg-slate-800 text-slate-200 hover:text-white text-xs">
                Cari
            </button>
        </form>
    </div>

    <!-- Messages Table -->
    <div class="rounded-2xl border border-slate-800 bg-slate-950 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-mono-code text-xs">
                <thead>
                    <tr class="border-b border-slate-800 text-slate-400 bg-slate-900/50">
                        <th class="py-3 px-4">PENGIRIM &amp; EMAIL</th>
                        <th class="py-3 px-4">SUBJEK PESAN</th>
                        <th class="py-3 px-4">WAKTU TERIMA</th>
                        <th class="py-3 px-4">STATUS</th>
                        <th class="py-3 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-850">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-slate-900/40 transition-colors {{ !$msg->is_read ? 'bg-cyan-950/10' : '' }}">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-white text-sm">{{ $msg->sender_name }}</div>
                                <div class="text-[11px] text-cyan-400 mt-0.5">{{ $msg->email }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <a href="{{ route('admin.messages.show', $msg->id) }}" class="font-semibold text-slate-200 hover:text-cyan-400 line-clamp-1">
                                    {{ $msg->subject }}
                                </a>
                                <div class="text-slate-500 text-[10px] line-clamp-1 mt-0.5">{{ $msg->message }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-400 whitespace-nowrap">
                                <div>{{ $msg->created_at->format('d M Y, H:i') }}</div>
                                <div class="text-[10px] text-slate-500">{{ $msg->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($msg->is_read)
                                    <span class="px-2 py-0.5 rounded bg-slate-900 border border-slate-800 text-slate-400 text-[10px]">
                                        DIBACA
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded bg-rose-500/20 border border-rose-500/40 text-rose-300 text-[10px] font-bold">
                                        ● BELUM DIBACA
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.messages.show', $msg->id) }}" class="px-2.5 py-1 rounded bg-slate-900 border border-slate-800 text-cyan-400 hover:border-cyan-500/50 transition-colors">
                                        Buka
                                    </a>

                                    <form action="{{ route('admin.messages.toggle-read', $msg->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-2 py-1 rounded bg-slate-900 border border-slate-800 text-slate-400 hover:text-white" title="Tandai Status">
                                            {{ $msg->is_read ? 'Tandai Baru' : 'Tandai Baca' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 rounded bg-rose-500/10 border border-rose-500/30 text-rose-400 hover:bg-rose-500 hover:text-white transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-slate-500">
                                Belum ada pesan masuk di kotak inbox.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
