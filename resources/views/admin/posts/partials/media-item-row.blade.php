@php
    $isImage = $media->media_type === 'image';
    $isEmbed = $media->media_type === 'embed';
    $previewUrl = $media->url;
    $tag = $media->markdown_tag;

    $badgeLabel = 'FOTO';
    $badgeColor = 'bg-sky-500/10 text-sky-300 border-sky-500/20';
    if ($media->media_type === 'video') {
        $badgeLabel = 'VIDEO MP4';
        $badgeColor = 'bg-amber-500/10 text-amber-300 border-amber-500/20';
    } elseif ($isEmbed) {
        $badgeLabel = 'EMBED VIDEO';
        $badgeColor = 'bg-rose-500/10 text-rose-300 border-rose-500/20';
    }
@endphp

<div class="media-item-card p-3 sm:p-4 rounded-xl border border-white/10 bg-[#0a0a0a] flex flex-col sm:flex-row sm:items-center justify-between gap-3.5 transition-all"
     data-id="{{ $media->id }}" 
     data-order="{{ $media->order }}">
    
    <div class="flex items-center gap-3.5 min-w-0 flex-1">
        <div class="w-16 h-12 rounded-lg border border-white/10 bg-black/60 overflow-hidden shrink-0 flex items-center justify-center">
            @if($isImage)
                <img src="{{ $previewUrl }}" class="w-full h-full object-cover" alt="Preview">
            @else
                <svg class="w-6 h-6 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                </svg>
            @endif
        </div>
        
        <div class="min-w-0 flex-1">
            <div class="flex items-center gap-2 mb-1 flex-wrap">
                <span class="px-2 py-0.5 rounded text-[10px] font-mono border {{ $badgeColor }}">{{ $badgeLabel }}</span>
                <span class="text-xs font-semibold text-white truncate max-w-[200px] sm:max-w-xs">{{ $media->file_name }}</span>
                <span class="text-[11px] text-stone-400 font-mono">{{ $media->formatted_size }}</span>
            </div>
            <div class="flex items-center gap-2">
                <input type="text" class="media-caption-input px-2.5 py-1 rounded-lg bg-[#141414] border border-white/10 text-stone-300 text-xs w-full max-w-sm focus:border-white focus:outline-none" 
                       placeholder="Tambahkan keterangan/caption..." value="{{ $media->caption }}" data-id="{{ $media->id }}">
            </div>
        </div>
    </div>

    <div class="flex items-center gap-2 shrink-0 flex-wrap sm:flex-nowrap pt-2 sm:pt-0 border-t sm:border-t-0 border-white/5">
        <button type="button" class="btn-insert-media px-3 py-1.5 rounded-lg bg-white text-black hover:bg-stone-200 text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer" data-tag="{{ $tag }}">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Sisipkan ke Teks
        </button>
        <button type="button" class="btn-copy-tag px-2.5 py-1.5 rounded-lg bg-white/5 hover:bg-white/10 border border-white/10 text-stone-300 hover:text-white text-xs font-mono transition-colors" title="Salin Tag Markdown" data-tag="{{ $tag }}">
            Salin Tag
        </button>
        <button type="button" class="btn-delete-media px-2.5 py-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 text-rose-300 text-xs transition-colors" title="Hapus Berkas" data-id="{{ $media->id }}">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </button>
    </div>

</div>
