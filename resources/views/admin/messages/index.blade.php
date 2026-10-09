@extends('layouts.admin')

@section('title', 'Inbox Pesan Masuk | Admin Panel TKJ')
@section('page_title', 'Inbox Pesan Kontak')

@section('admin_content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold font-body text-white tracking-tight">Inbox <span class="font-display font-semibold text-stone-300">Pesan Masuk</span></h2>
            <p class="text-xs text-stone-400 font-body mt-0.5">Pesan dan transmisi kontak dari pengunjung portofolio.</p>
        </div>

        @if($unreadCount > 0)
            <div class="px-3.5 py-1.5 rounded-full bg-white text-black font-mono text-xs font-bold self-start sm:self-auto flex items-center gap-2 shadow-xs">
                <span class="h-2 w-2 rounded-full bg-white shadow-[0_0_6px_rgba(0,0,0,0.5)]"></span>
                <span>{{ $unreadCount }} PESAN BELUM DIBACA</span>
            </div>
        @endif
    </div>

    <!-- Filter Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4 p-4 rounded-2xl bg-[#141414] border border-white/10 shadow-xs font-body text-xs">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.messages.index') }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ !request('status') ? 'bg-white text-black font-bold shadow-xs' : 'bg-white/5 border border-white/10 text-stone-400 hover:bg-white/10 hover:text-white' }}">
                Semua Pesan ({{ \App\Models\Message::count() }})
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('status') === 'unread' ? 'bg-white text-black font-bold shadow-xs' : 'bg-white/5 border border-white/10 text-stone-400 hover:bg-white/10 hover:text-white' }}">
                Belum Dibaca ({{ $unreadCount }})
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'read']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('status') === 'read' ? 'bg-white text-black font-bold shadow-xs' : 'bg-white/5 border border-white/10 text-stone-400 hover:bg-white/10 hover:text-white' }}">
                Sudah Dibaca
            </a>
        </div>

        <form action="{{ route('admin.messages.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, subjek..."
                   class="px-3.5 py-1.5 rounded-xl bg-[#0a0a0a] border border-white/15 text-white placeholder-stone-600 text-xs focus:bg-black focus:outline-none focus:border-white focus:ring-1 focus:ring-white/20 transition-all font-body">
            <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-white/10 border border-white/15 text-stone-200 hover:bg-white hover:text-black text-xs font-medium transition-colors font-body cursor-pointer">
                Cari
            </button>
        </form>
    </div>

    <!-- Messages Table -->
    <div class="rounded-2xl border border-white/10 bg-[#141414] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-body text-xs">
                <thead>
                    <tr class="border-b border-white/10 text-stone-400 bg-white/[0.04] font-semibold">
                        <th class="py-3.5 px-4">PENGIRIM &amp; EMAIL</th>
                        <th class="py-3.5 px-4">SUBJEK PESAN</th>
                        <th class="py-3.5 px-4">WAKTU TERIMA</th>
                        <th class="py-3.5 px-4">STATUS</th>
                        <th class="py-3.5 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-stone-300">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-white/[0.02] transition-colors {{ !$msg->is_read ? 'bg-white/[0.03]' : '' }}">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-white text-sm">{{ $msg->sender_name }}</div>
                                <div class="text-[11px] text-stone-400 font-medium mt-0.5">{{ $msg->email }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <a href="{{ route('admin.messages.show', $msg->id) }}" class="font-semibold text-stone-200 hover:text-white transition-colors line-clamp-1">
                                    {{ $msg->subject }}
                                </a>
                                <div class="text-stone-500 text-[10px] line-clamp-1 mt-0.5">{{ $msg->message }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-stone-400 whitespace-nowrap">
                                <div>{{ $msg->created_at->format('d M Y, H:i') }}</div>
                                <div class="text-[10px] text-stone-500">{{ $msg->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($msg->is_read)
                                    <span class="px-2.5 py-0.5 rounded-full bg-white/5 border border-white/10 text-stone-400 text-[10px]">
                                        DIBACA
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-white text-black text-[10px] font-bold flex items-center gap-1.5 w-fit">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>BELUM DIBACA</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.messages.show', $msg->id) }}" class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/15 text-stone-300 hover:bg-white hover:text-black transition-colors font-medium">
                                        Buka
                                    </a>

                                    <form action="{{ route('admin.messages.toggle-read', $msg->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/15 text-stone-400 hover:bg-white/15 hover:text-white transition-colors font-medium cursor-pointer" title="Tandai Status">
                                            {{ $msg->is_read ? 'Tandai Baru' : 'Tandai Baca' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?');" class="inline">
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
                            <td colspan="5" class="text-center py-12 text-stone-500">
                                Belum ada pesan masuk di kotak inbox.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="p-4 border-t border-white/10 bg-[#0d0d0d]">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
