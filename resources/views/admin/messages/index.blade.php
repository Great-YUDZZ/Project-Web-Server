@extends('layouts.admin')

@section('title', 'Inbox Pesan Masuk - Admin Panel TKJ')
@section('page_title', 'Inbox Pesan Kontak')

@section('admin_content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight">Inbox Pesan Masuk</h2>
            <p class="text-xs text-zinc-400 font-mono mt-0.5">Pesan dan transmisi kontak dari pengunjung portofolio.</p>
        </div>

        @if($unreadCount > 0)
            <div class="px-3.5 py-1.5 rounded-full bg-rose-500/15 border border-rose-500/30 text-rose-400 font-mono text-xs font-semibold self-start sm:self-auto flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-rose-500 animate-ping"></span>
                <span>{{ $unreadCount }} PESAN BELUM DIBACA</span>
            </div>
        @endif
    </div>

    <!-- Filter Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4 p-4 rounded-2xl bg-[#0d0e14]/80 border border-white/[0.08] backdrop-blur-xl font-mono text-xs">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.messages.index') }}" class="px-3 py-1.5 rounded-xl transition-all {{ !request('status') ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white font-semibold shadow-md shadow-orange-500/20' : 'bg-white/[0.04] border border-white/[0.08] text-zinc-400 hover:text-white hover:bg-white/[0.08]' }}">
                Semua Pesan ({{ \App\Models\Message::count() }})
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" class="px-3 py-1.5 rounded-xl transition-all {{ request('status') === 'unread' ? 'bg-rose-500 text-white font-semibold shadow-md shadow-rose-500/20' : 'bg-white/[0.04] border border-white/[0.08] text-zinc-400 hover:text-white hover:bg-white/[0.08]' }}">
                Belum Dibaca ({{ $unreadCount }})
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'read']) }}" class="px-3 py-1.5 rounded-xl transition-all {{ request('status') === 'read' ? 'bg-white/[0.12] text-white font-semibold' : 'bg-white/[0.04] border border-white/[0.08] text-zinc-400 hover:text-white hover:bg-white/[0.08]' }}">
                Sudah Dibaca
            </a>
        </div>

        <form action="{{ route('admin.messages.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, subjek..."
                   class="px-3 py-1.5 rounded-xl bg-[#070709] border border-white/[0.08] text-white placeholder-zinc-500 text-xs focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500">
            <button type="submit" class="px-3 py-1.5 rounded-xl bg-white/[0.04] border border-white/[0.08] text-zinc-300 hover:text-white text-xs transition-colors">
                Cari
            </button>
        </form>
    </div>

    <!-- Messages Table -->
    <div class="rounded-3xl border border-white/[0.08] bg-[#0d0e14]/80 backdrop-blur-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-mono text-xs">
                <thead>
                    <tr class="border-b border-white/[0.06] text-zinc-400 bg-white/[0.02]">
                        <th class="py-3.5 px-4">PENGIRIM &amp; EMAIL</th>
                        <th class="py-3.5 px-4">SUBJEK PESAN</th>
                        <th class="py-3.5 px-4">WAKTU TERIMA</th>
                        <th class="py-3.5 px-4">STATUS</th>
                        <th class="py-3.5 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.04]">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-white/[0.02] transition-colors {{ !$msg->is_read ? 'bg-orange-500/[0.02]' : '' }}">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-white text-sm">{{ $msg->sender_name }}</div>
                                <div class="text-[11px] text-orange-400/90 mt-0.5">{{ $msg->email }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <a href="{{ route('admin.messages.show', $msg->id) }}" class="font-semibold text-zinc-200 hover:text-orange-400 transition-colors line-clamp-1">
                                    {{ $msg->subject }}
                                </a>
                                <div class="text-zinc-500 text-[10px] line-clamp-1 mt-0.5">{{ $msg->message }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-zinc-400 whitespace-nowrap">
                                <div>{{ $msg->created_at->format('d M Y, H:i') }}</div>
                                <div class="text-[10px] text-zinc-500">{{ $msg->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($msg->is_read)
                                    <span class="px-2.5 py-0.5 rounded-full bg-white/[0.04] border border-white/[0.08] text-zinc-400 text-[10px]">
                                        DIBACA
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-rose-500/15 border border-rose-500/30 text-rose-300 text-[10px] font-bold flex items-center gap-1.5 w-fit">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                        <span>BELUM DIBACA</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.messages.show', $msg->id) }}" class="px-2.5 py-1 rounded-lg bg-white/[0.04] border border-white/[0.08] text-zinc-300 hover:text-orange-400 hover:border-orange-500/30 transition-colors">
                                        Buka
                                    </a>

                                    <form action="{{ route('admin.messages.toggle-read', $msg->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-2.5 py-1 rounded-lg bg-white/[0.04] border border-white/[0.08] text-zinc-400 hover:text-white transition-colors" title="Tandai Status">
                                            {{ $msg->is_read ? 'Tandai Baru' : 'Tandai Baca' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?');" class="inline">
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
                            <td colspan="5" class="text-center py-12 text-zinc-500">
                                Belum ada pesan masuk di kotak inbox.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="p-4 border-t border-white/[0.06]">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
