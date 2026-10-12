@php
    $currentPostId = isset($post) ? $post->id : null;
    $mediaItems = isset($post) && $post->media ? $post->media : collect();
    $tempToken = $tempToken ?? (string) \Illuminate\Support\Str::uuid();
@endphp

<!-- Input Tersembunyi Temp Token jika Artikel Baru -->
@if(!$currentPostId)
    <input type="hidden" name="temp_token" id="temp_token_input" value="{{ $tempToken }}">
@endif

<div id="media-manager-container" class="rounded-2xl border border-white/10 bg-[#121212] p-5 sm:p-6 mb-6 font-body text-xs">

    <!-- Header Panel Media Manager -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-white/10 gap-3">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                <h3 class="text-sm font-bold text-white tracking-wide uppercase">Manajer Berkas Media (Foto &amp; Video)</h3>
            </div>
            <p class="text-stone-400 text-xs mt-1">
                Unggah lebih dari satu foto atau video, lalu klik tombol <strong class="text-stone-200">"Sisipkan ke Teks"</strong> untuk menaruhnya bebas di posisi kursor artikel.
            </p>
        </div>

        <!-- Mode Toggle Tabs (Upload File vs Embed Video) -->
        <div class="flex items-center gap-1.5 p-1 rounded-xl bg-[#0a0a0a] border border-white/10 self-start sm:self-auto">
            <button type="button" id="tab-btn-file" class="media-tab-btn active px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-white/10 transition-colors">
                Unggah Berkas
            </button>
            <button type="button" id="tab-btn-embed" class="media-tab-btn px-3 py-1.5 rounded-lg text-xs font-semibold text-stone-400 hover:text-white transition-colors">
                Tautan Video (YouTube/Vimeo)
            </button>
        </div>
    </div>

    <!-- Feedback Toast & Alert Notification -->
    <div id="media-notification-area" class="mt-4 hidden"></div>

    <!-- Upload Section Form -->
    <div class="mt-4">

        <!-- Tab 1: Upload File Fisik (Foto / Video) -->
        <div id="pane-upload-file" class="media-tab-pane">
            <div id="dropzone-area" class="relative rounded-xl border-2 border-dashed border-white/15 bg-[#0a0a0a]/60 hover:border-white/30 hover:bg-[#0a0a0a] transition-all p-6 text-center cursor-pointer group">
                <input type="file" id="media-file-input" multiple accept="image/png,image/jpeg,image/webp,image/gif,video/mp4,video/webm" class="hidden">
                
                <div class="flex flex-col items-center justify-center pointer-events-none">
                    <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-stone-300 group-hover:scale-105 group-hover:border-white/20 transition-all mb-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                    <div class="text-sm font-semibold text-white mb-1">
                        Tarik dan letakkan berkas foto / video di sini, atau <span class="text-stone-300 underline underline-offset-2">pilih berkas</span>
                    </div>
                    <div class="text-stone-400 text-xs font-mono">
                        Mendukung JPG, PNG, WebP, GIF (maks 15MB) &amp; Video MP4, WebM (maks 50MB) &bull; Bisa memilih banyak berkas sekaligus
                    </div>
                </div>

                <!-- Progress Bar Indikator Upload -->
                <div id="upload-progress-container" class="mt-4 hidden pointer-events-none">
                    <div class="flex items-center justify-between text-xs text-stone-300 mb-1">
                        <span id="upload-progress-text">Mengunggah berkas...</span>
                        <span id="upload-progress-percent">0%</span>
                    </div>
                    <div class="w-full h-1.5 rounded-full bg-stone-800 overflow-hidden">
                        <div id="upload-progress-bar" class="h-full bg-white transition-all duration-150" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 2: Tambah Video Embed External (YouTube / Vimeo) -->
        <div id="pane-upload-embed" class="media-tab-pane hidden">
            <div class="rounded-xl border border-white/10 bg-[#0a0a0a] p-4 sm:p-5 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label for="embed-url-input" class="block text-stone-300 font-bold mb-1.5">
                            URL VIDEO (YOUTUBE / VIMEO) <span class="text-rose-400">*</span>
                        </label>
                        <input type="url" id="embed-url-input" placeholder="Contoh: https://www.youtube.com/watch?v=dQw4w9WgXcQ"
                               class="w-full px-3.5 py-2.5 rounded-xl bg-[#141414] border border-white/15 text-white placeholder-stone-600 focus:outline-none focus:border-white text-xs font-mono">
                    </div>
                    <div>
                        <label for="embed-caption-input" class="block text-stone-300 font-bold mb-1.5">
                            KETERANGAN / CAPTION (OPSIONAL)
                        </label>
                        <input type="text" id="embed-caption-input" placeholder="Misal: Demonstrasi Konfigurasi MikroTik"
                               class="w-full px-3.5 py-2.5 rounded-xl bg-[#141414] border border-white/15 text-white placeholder-stone-600 focus:outline-none focus:border-white text-xs">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="btn-save-embed" class="px-5 py-2 rounded-xl bg-white text-black hover:bg-stone-200 text-xs font-bold uppercase tracking-wider transition-all cursor-pointer">
                        Tambahkan Video Embed
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- Daftar Media Terunggah (Gallery Cards) -->
    <div class="mt-6">
        <div class="flex items-center justify-between mb-3">
            <div class="text-xs font-bold text-stone-300 tracking-wider uppercase flex items-center gap-2">
                <span>Daftar Media Artikel</span>
                <span id="media-count-badge" class="px-2 py-0.5 rounded-full bg-white/10 text-white font-mono text-[10px]">
                    {{ count($mediaItems) }} Berkas
                </span>
            </div>
            <span class="text-[11px] text-stone-400 font-mono hidden sm:inline">
                Klik "Sisipkan ke Teks" untuk memasukkan media ke posisi kursor di textarea artikel.
            </span>
        </div>

        <!-- Empty State -->
        <div id="media-empty-state" class="{{ count($mediaItems) > 0 ? 'hidden' : '' }} p-8 rounded-xl border border-white/5 bg-[#0a0a0a]/40 text-center">
            <div class="text-stone-400 text-xs font-mono">
                Belum ada berkas foto atau video yang ditambahkan untuk artikel ini.
            </div>
            <div class="text-stone-500 text-[11px] mt-1">
                Unggah foto/video di atas untuk disematkan ke dalam tulisan blog Anda.
            </div>
        </div>

        <!-- Media Grid Container -->
        <div id="media-items-grid" class="space-y-3">
            @foreach($mediaItems as $media)
                @include('admin.posts.partials.media-item-row', ['media' => $media])
            @endforeach
        </div>
    </div>

</div>

<!-- Client-side Script untuk Media Manager -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('media-manager-container');
    if (!container) return;

    const currentPostId = @json($currentPostId);
    const tempToken = @json($tempToken);
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

    const tabBtnFile = document.getElementById('tab-btn-file');
    const tabBtnEmbed = document.getElementById('tab-btn-embed');
    const paneFile = document.getElementById('pane-upload-file');
    const paneEmbed = document.getElementById('pane-upload-embed');

    const dropzone = document.getElementById('dropzone-area');
    const fileInput = document.getElementById('media-file-input');
    const progressContainer = document.getElementById('upload-progress-container');
    const progressBar = document.getElementById('upload-progress-bar');
    const progressText = document.getElementById('upload-progress-text');
    const progressPercent = document.getElementById('upload-progress-percent');

    const embedUrlInput = document.getElementById('embed-url-input');
    const embedCaptionInput = document.getElementById('embed-caption-input');
    const btnSaveEmbed = document.getElementById('btn-save-embed');

    const mediaGrid = document.getElementById('media-items-grid');
    const emptyState = document.getElementById('media-empty-state');
    const countBadge = document.getElementById('media-count-badge');
    const notifArea = document.getElementById('media-notification-area');

    const contentTextarea = document.getElementById('content');

    // Tab Switcher
    tabBtnFile.addEventListener('click', function () {
        tabBtnFile.classList.add('bg-white/10', 'text-white');
        tabBtnFile.classList.remove('text-stone-400');
        tabBtnEmbed.classList.remove('bg-white/10', 'text-white');
        tabBtnEmbed.classList.add('text-stone-400');
        paneFile.classList.remove('hidden');
        paneEmbed.classList.add('hidden');
    });

    tabBtnEmbed.addEventListener('click', function () {
        tabBtnEmbed.classList.add('bg-white/10', 'text-white');
        tabBtnEmbed.classList.remove('text-stone-400');
        tabBtnFile.classList.remove('bg-white/10', 'text-white');
        tabBtnFile.classList.add('text-stone-400');
        paneEmbed.classList.remove('hidden');
        paneFile.classList.add('hidden');
    });

    // Dropzone Click & Drag/Drop
    dropzone.addEventListener('click', function (e) {
        if (e.target.tagName !== 'INPUT') {
            fileInput.click();
        }
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.add('border-white', 'bg-white/5');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.remove('border-white', 'bg-white/5');
        });
    });

    dropzone.addEventListener('drop', function (e) {
        const files = e.dataTransfer.files;
        if (files && files.length > 0) {
            handleUploadFiles(files);
        }
    });

    fileInput.addEventListener('change', function () {
        if (fileInput.files && fileInput.files.length > 0) {
            handleUploadFiles(fileInput.files);
        }
    });

    // Upload Files Queue Handler
    async function handleUploadFiles(files) {
        progressContainer.classList.remove('hidden');
        progressBar.style.width = '0%';

        let total = files.length;
        let successCount = 0;

        for (let i = 0; i < total; i++) {
            const file = files[i];
            const percent = Math.round(((i) / total) * 100);
            progressBar.style.width = percent + '%';
            progressPercent.textContent = percent + '%';
            progressText.textContent = `Mengunggah (${i + 1}/${total}): ${file.name}`;

            const formData = new FormData();
            formData.append('file', file);
            if (currentPostId) {
                formData.append('post_id', currentPostId);
            } else {
                formData.append('temp_token', tempToken);
            }

            try {
                const response = await fetch('{{ route("admin.posts.media.upload") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const data = await response.json();
                if (data.success && data.media) {
                    appendMediaItemRow(data.media);
                    successCount++;
                } else {
                    showNotification(data.message || 'Gagal mengunggah ' + file.name, 'error');
                }
            } catch (err) {
                console.error(err);
                showNotification('Terjadi kesalahan koneksi saat mengunggah ' + file.name, 'error');
            }
        }

        progressBar.style.width = '100%';
        progressPercent.textContent = '100%';
        progressText.textContent = `Selesai! ${successCount} berkas berhasil diunggah.`;

        setTimeout(() => {
            progressContainer.classList.add('hidden');
            fileInput.value = '';
        }, 1500);

        updateCountBadge();
        showNotification(`${successCount} berkas media berhasil diunggah. Klik tombol "Sisipkan ke Teks" untuk menaruhnya ke dalam artikel.`, 'success');
    }

    // Embed Video Submit Handler
    btnSaveEmbed.addEventListener('click', async function () {
        const url = embedUrlInput.value.trim();
        const caption = embedCaptionInput.value.trim();

        if (!url) {
            showNotification('Harap masukkan URL video YouTube atau Vimeo yang valid.', 'error');
            return;
        }

        btnSaveEmbed.disabled = true;
        btnSaveEmbed.textContent = 'Menyimpan...';

        const formData = new FormData();
        formData.append('media_type', 'embed');
        formData.append('embed_url', url);
        if (caption) formData.append('caption', caption);
        if (currentPostId) {
            formData.append('post_id', currentPostId);
        } else {
            formData.append('temp_token', tempToken);
        }

        try {
            const response = await fetch('{{ route("admin.posts.media.upload") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await response.json();
            if (data.success && data.media) {
                appendMediaItemRow(data.media);
                embedUrlInput.value = '';
                embedCaptionInput.value = '';
                updateCountBadge();
                showNotification('Tautan video berhasil ditambahkan ke daftar media!', 'success');
            } else {
                showNotification(data.message || 'Gagal menambahkan tautan video', 'error');
            }
        } catch (err) {
            console.error(err);
            showNotification('Terjadi kesalahan saat menyimpan tautan video.', 'error');
        } finally {
            btnSaveEmbed.disabled = false;
            btnSaveEmbed.textContent = 'Tambahkan Video Embed';
        }
    });

    // Helper: Tambah Baris Kartu Media ke DOM
    function appendMediaItemRow(media) {
        emptyState.classList.add('hidden');

        const row = document.createElement('div');
        row.className = 'media-item-card p-3 sm:p-4 rounded-xl border border-white/10 bg-[#0a0a0a] flex flex-col sm:flex-row sm:items-center justify-between gap-3.5 transition-all';
        row.dataset.id = media.id;
        row.dataset.order = media.order || 0;

        const isImage = media.media_type === 'image';
        const isEmbed = media.media_type === 'embed';
        const previewUrl = media.url;
        const tag = media.markdown_tag;

        let badgeLabel = 'FOTO';
        let badgeColor = 'bg-sky-500/10 text-sky-300 border-sky-500/20';
        if (media.media_type === 'video') {
            badgeLabel = 'VIDEO MP4';
            badgeColor = 'bg-amber-500/10 text-amber-300 border-amber-500/20';
        } else if (isEmbed) {
            badgeLabel = 'EMBED VIDEO';
            badgeColor = 'bg-rose-500/10 text-rose-300 border-rose-500/20';
        }

        row.innerHTML = `
            <div class="flex items-center gap-3.5 min-w-0 flex-1">
                <div class="w-16 h-12 rounded-lg border border-white/10 bg-black/60 overflow-hidden shrink-0 flex items-center justify-center">
                    ${isImage ? `<img src="${previewUrl}" class="w-full h-full object-cover" alt="Preview">` : `
                        <svg class="w-6 h-6 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        </svg>
                    `}
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 mb-1 flex-wrap">
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono border ${badgeColor}">${badgeLabel}</span>
                        <span class="text-xs font-semibold text-white truncate max-w-[200px] sm:max-w-xs">${escapeHtml(media.file_name)}</span>
                        <span class="text-[11px] text-stone-400 font-mono">${media.formatted_size || ''}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="text" class="media-caption-input px-2.5 py-1 rounded-lg bg-[#141414] border border-white/10 text-stone-300 text-xs w-full max-w-sm focus:border-white focus:outline-none" 
                               placeholder="Tambahkan keterangan/caption..." value="${escapeHtml(media.caption || '')}" data-id="${media.id}">
                        <button type="button" class="btn-save-caption hidden text-[10px] px-2 py-1 bg-white/10 text-white rounded hover:bg-white/20">Simpan</button>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2 shrink-0 flex-wrap sm:flex-nowrap pt-2 sm:pt-0 border-t sm:border-t-0 border-white/5">
                <button type="button" class="btn-insert-media px-3 py-1.5 rounded-lg bg-white text-black hover:bg-stone-200 text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer" data-tag="${escapeHtml(tag)}">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Sisipkan ke Teks
                </button>
                <button type="button" class="btn-copy-tag px-2.5 py-1.5 rounded-lg bg-white/5 hover:bg-white/10 border border-white/10 text-stone-300 hover:text-white text-xs font-mono transition-colors" title="Salin Tag Markdown" data-tag="${escapeHtml(tag)}">
                    Salin Tag
                </button>
                <button type="button" class="btn-delete-media px-2.5 py-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 text-rose-300 text-xs transition-colors" title="Hapus Berkas" data-id="${media.id}">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        `;

        mediaGrid.appendChild(row);
        bindMediaRowEvents(row);
    }

    // Bind event handlers untuk baris media
    function bindMediaRowEvents(row) {
        const id = row.dataset.id;
        const captionInput = row.querySelector('.media-caption-input');
        const insertBtn = row.querySelector('.btn-insert-media');
        const copyBtn = row.querySelector('.btn-copy-tag');
        const deleteBtn = row.querySelector('.btn-delete-media');

        // Insert to Textarea Cursor
        insertBtn?.addEventListener('click', function () {
            const tag = insertBtn.dataset.tag;
            insertTextAtCursor(contentTextarea, "\n\n" + tag + "\n\n");
            showNotification('Tag media berhasil disisipkan tepat di posisi kursor artikel!', 'success');
        });

        // Copy Tag to Clipboard
        copyBtn?.addEventListener('click', function () {
            const tag = copyBtn.dataset.tag;
            navigator.clipboard.writeText(tag).then(() => {
                showNotification('Kode tag media berhasil disalin ke papan klip.', 'success');
            });
        });

        // Update Caption on Change/Blur
        captionInput?.addEventListener('change', async function () {
            const newCaption = captionInput.value.trim();
            try {
                const response = await fetch(`/admin/posts/media/${id}`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ caption: newCaption }),
                });
                const resData = await response.json();
                if (resData.success && resData.media) {
                    insertBtn.dataset.tag = resData.media.markdown_tag;
                    copyBtn.dataset.tag = resData.media.markdown_tag;
                    showNotification('Keterangan media berhasil diperbarui!', 'success');
                }
            } catch (err) {
                console.error(err);
            }
        });

        // Delete Media
        deleteBtn?.addEventListener('click', async function () {
            if (!confirm('Apakah Anda yakin ingin menghapus berkas media ini?')) return;

            try {
                const response = await fetch(`/admin/posts/media/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                });
                const resData = await response.json();
                if (resData.success) {
                    row.remove();
                    updateCountBadge();
                    showNotification('Berkas media berhasil dihapus.', 'success');
                } else {
                    showNotification(resData.message || 'Gagal menghapus berkas media.', 'error');
                }
            } catch (err) {
                console.error(err);
                showNotification('Terjadi kesalahan saat menghapus media.', 'error');
            }
        });
    }

    // Helper: Sisipkan teks ke posisi kursor textarea
    function insertTextAtCursor(input, textToInsert) {
        if (!input) return;
        input.focus();

        const start = input.selectionStart;
        const end = input.selectionEnd;
        const val = input.value;

        input.value = val.substring(0, start) + textToInsert + val.substring(end);
        input.selectionStart = input.selectionEnd = start + textToInsert.length;

        // Trigger input event jika ada autosave
        input.dispatchEvent(new Event('input', { bubbles: true }));
    }

    // Helper: Hitung jumlah baris media aktif
    function updateCountBadge() {
        const rows = mediaGrid.querySelectorAll('.media-item-card');
        countBadge.textContent = `${rows.length} Berkas`;
        if (rows.length === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }

    // Helper: Tampilkan notifikasi toast/alert
    function showNotification(msg, type) {
        notifArea.className = `mt-4 p-3 rounded-xl border text-xs font-mono flex items-center justify-between ${
            type === 'success' 
                ? 'bg-emerald-950/40 border-emerald-500/30 text-emerald-200' 
                : 'bg-rose-950/40 border-rose-500/30 text-rose-200'
        }`;
        notifArea.innerHTML = `
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full ${type === 'success' ? 'bg-emerald-400' : 'bg-rose-400'}"></span>
                <span>${escapeHtml(msg)}</span>
            </div>
            <button type="button" class="text-stone-400 hover:text-white" onclick="this.parentElement.classList.add('hidden')">&times;</button>
        `;
        notifArea.classList.remove('hidden');

        setTimeout(() => {
            notifArea.classList.add('hidden');
        }, 5000);
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // Bind event awal untuk item yang sudah dirender server-side
    document.querySelectorAll('.media-item-card').forEach(bindMediaRowEvents);
});
</script>
