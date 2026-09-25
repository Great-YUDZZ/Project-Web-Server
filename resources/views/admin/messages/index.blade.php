@extends('layouts.admin')

@section('title', 'Inbox Pesan Masuk - Admin Panel TKJ')
@section('page_title', 'Inbox Pesan Kontak')

@section('admin_content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-stone-900 tracking-tight">Inbox Pesan Masuk</h2>
            <p class="text-xs text-stone-500 font-mono mt-0.5">Pesan dan transmisi kontak dari pengunjung portofolio.</p>
        </div>

        @if($unreadCount > 0)
            <div class="px-3.5 py-1.5 rounded-full bg-rose-50 border border-rose-200 text-rose-700 font-mono text-xs font-semibold self-start sm:self-auto flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-rose-600 animate-ping"></span>
                <span>{{ $unreadCount }} PESAN BELUM DIBACA</span>
            </div>
        @endif
    </div>

    <!-- Filter Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4 p-4 rounded-2xl bg-white border border-stone-200 shadow-xs font-mono text-xs">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.messages.index') }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ !request('status') ? 'text-white font-semibold shadow-xs' : 'bg-stone-100 border border-stone-200 text-stone-600 hover:bg-stone-200 hover:text-stone-900' }}"
               style="{{ !request('status') ? 'background-color: #0C382E;' : '' }}">
                Semua Pesan ({{ \App\Models\Message::count() }})
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('status') === 'unread' ? 'text-white font-semibold shadow-xs' : 'bg-stone-100 border border-stone-200 text-stone-600 hover:bg-stone-200 hover:text-stone-900' }}"
               style="{{ request('status') === 'unread' ? 'background-color: #9C6644;' : '' }}">
                Belum Dibaca ({{ $unreadCount }})
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'read']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('status') === 'read' ? 'bg-stone-800 text-white font-semibold' : 'bg-stone-100 border border-stone-200 text-stone-600 hover:bg-stone-200 hover:text-stone-900' }}">
                Sudah Dibaca
            </a>
        </div>

        <form action="{{ route('admin.messages.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, subjek..."
                   class="px-3.5 py-1.5 rounded-xl bg-[#FAF8F5] border border-stone-300 text-stone-900 placeholder-stone-400 text-xs focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-1 focus:ring-[#0C382E]">
            <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-stone-100 border border-stone-200 text-stone-700 hover:bg-stone-200 text-xs font-medium transition-colors">
                Cari
            </button>
        </form>
    </div>

    <!-- Messages Table -->
    <div class="rounded-2xl border border-stone-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-mono text-xs">
                <thead>
                    <tr class="border-b border-stone-200 text-stone-600 bg-stone-50/80 font-bold">
                        <th class="py-3.5 px-4">PENGIRIM &amp; EMAIL</th>
                        <th class="py-3.5 px-4">SUBJEK PESAN</th>
                        <th class="py-3.5 px-4">WAKTU TERIMA</th>
                        <th class="py-3.5 px-4">STATUS</th>
                        <th class="py-3.5 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-stone-50/60 transition-colors {{ !$msg->is_read ? 'bg-[#9C6644]/5' : '' }}">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-stone-900 text-sm">{{ $msg->sender_name }}</div>
                                <div class="text-[11px] text-[#0C382E] font-medium mt-0.5">{{ $msg->email }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <a href="{{ route('admin.messages.show', $msg->id) }}" class="font-semibold text-stone-800 hover:text-[#0C382E] transition-colors line-clamp-1">
                                    {{ $msg->subject }}
                                </a>
                                <div class="text-stone-500 text-[10px] line-clamp-1 mt-0.5">{{ $msg->message }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-stone-600 whitespace-nowrap">
                                <div>{{ $msg->created_at->format('d M Y, H:i') }}</div>
                                <div class="text-[10px] text-stone-400">{{ $msg->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($msg->is_read)
                                    <span class="px-2.5 py-0.5 rounded-full bg-stone-100 border border-stone-200 text-stone-500 text-[10px]">
                                        DIBACA
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-rose-50 border border-rose-200 text-rose-700 text-[10px] font-bold flex items-center gap-1.5 w-fit">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-pulse"></span>
                                        <span>BELUM DIBACA</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.messages.show', $msg->id) }}" class="px-2.5 py-1 rounded-lg bg-stone-100 border border-stone-200 text-stone-700 hover:bg-stone-200 hover:text-stone-900 transition-colors font-medium">
                                        Buka
                                    </a>

                                    <form action="{{ route('admin.messages.toggle-read', $msg->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-2.5 py-1 rounded-lg bg-stone-100 border border-stone-200 text-stone-600 hover:bg-stone-200 transition-colors font-medium" title="Tandai Status">
                                            {{ $msg->is_read ? 'Tandai Baru' : 'Tandai Baca' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 hover:bg-rose-100 transition-colors font-medium">
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
            <div class="p-4 border-t border-stone-200 bg-stone-50/50">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
