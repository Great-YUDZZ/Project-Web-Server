@extends('layouts.app')

@section('title', 'Yuna AI | Asisten Cerdas Portofolio | I Made Yuda Pramana')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-4 sm:py-6" id="pramana-console-root" data-csrf="{{ csrf_token() }}" data-endpoint="{{ route('chatbot.message') }}">
    
    <!-- Header Konsol Yuna AI (Dark Monochrome Architecture) -->
    <div class="mb-4 sm:mb-6 rounded-2xl sm:rounded-3xl bg-[#141414] text-white p-4 sm:p-6 border border-[#1f1f1f] shadow-2xl relative overflow-hidden">
        <!-- Pendaran Latar Belakang Melingkar Putih Halus -->
        <div class="absolute -top-12 -right-12 w-64 h-64 rounded-full bg-white/[0.03] blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Identitas Merek Yuna AI -->
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-[#0e0e0e] p-1.5 sm:p-2 border border-white/20 shadow-inner shrink-0 flex items-center justify-center">
                    <img src="{{ asset('images/yuna-logo.svg') }}" alt="Yuna AI" class="w-full h-full object-contain filter drop-shadow">
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h1 class="text-lg sm:text-2xl font-extrabold tracking-tight text-white font-sans">Yuna AI</h1>
                        <span class="text-[10px] font-mono px-2.5 py-0.5 rounded-full bg-white/10 text-white border border-white/20 font-bold">Interactive Assistant</span>
                        <span class="text-[10px] font-mono px-2.5 py-0.5 rounded-full bg-white/5 text-[#a3a3a3] border border-white/10">Linux &amp; Portofolio</span>
                    </div>
                    <p class="text-xs text-[#878787] font-mono mt-0.5">
                        Asisten Cerdas Interaktif &bull; Portofolio I Made Yuda Pramana (SMKN 1 Denpasar)
                    </p>
                </div>
            </div>

            <!-- Status dan Navigasi Kembali -->
            <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-xs font-mono">
                <div class="px-3.5 py-1.5 rounded-full bg-[#0e0e0e] border border-[#2a2a2a] flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-white shadow-[0_0_8px_rgba(255,255,255,0.6)]"></span>
                    <span class="text-[#f5f5f5] font-semibold">ONLINE</span>
                </div>
                <a href="{{ route('home') }}" class="px-4 py-1.5 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold transition-all flex items-center gap-1.5 cursor-pointer">
                    <span>&larr; Portofolio</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Panggung Konsol Yuna AI Khusus (Murni Berisi Antarmuka Yuna AI) -->
    <main class="w-full max-w-5xl mx-auto flex flex-col h-[calc(100dvh-11rem)] min-h-[500px] sm:h-[750px] sm:max-h-[82vh] rounded-2xl sm:rounded-3xl bg-[#111111] border border-[#1f1f1f] shadow-2xl overflow-hidden">
        
        <!-- Sub-Header Konsol -->
        <div class="px-5 py-3.5 bg-[#161616] border-b border-[#1f1f1f] flex items-center justify-between shrink-0">
            <div class="flex items-center gap-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-white shadow-[0_0_6px_rgba(255,255,255,0.4)] inline-block"></span>
                <span class="text-xs font-mono font-bold text-[#f5f5f5]">SESI PERCAKAPAN YUNA AI</span>
            </div>

            <div class="flex items-center gap-2">
                <button id="console-reset-btn" type="button" class="text-xs font-mono text-[#878787] hover:text-white transition-colors flex items-center gap-1.5 cursor-pointer px-3 py-1 rounded-full hover:bg-white/10">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Reset Sesi</span>
                </button>
                <span class="text-[#333333]">|</span>
                <button id="console-export-btn" type="button" class="text-xs font-mono text-[#878787] hover:text-white transition-colors flex items-center gap-1.5 cursor-pointer px-3 py-1 rounded-full hover:bg-white/10">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Simpan Log</span>
                </button>
            </div>
        </div>

        <!-- Aliran Pesan Interaktif (Scrollable Stream) -->
        <div id="console-messages" class="flex-1 p-4 sm:p-6 overflow-y-auto space-y-5 text-xs sm:text-sm leading-relaxed text-[#f5f5f5] scroll-smooth">
            
            <!-- Status 1: Tampilan Awal (Empty State) -->
            <div id="console-empty-state" class="space-y-6 py-3 max-w-3xl mx-auto">
                <div class="p-6 sm:p-7 rounded-3xl bg-[#141414] border border-[#1f1f1f] shadow-lg space-y-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-[#0e0e0e] p-2 flex items-center justify-center shrink-0 border border-white/20 shadow-xs">
                            <img src="{{ asset('images/yuna-logo.svg') }}" alt="Yuna" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h3 class="font-extrabold text-white text-base sm:text-lg">Halo, Selamat Datang! Aku Yuna</h3>
                            <p class="text-xs text-[#878787] font-mono">Asisten AI Portofolio &bull; I Made Yuda Pramana</p>
                        </div>
                    </div>

                    <p class="text-xs sm:text-sm text-[#a3a3a3] leading-relaxed font-sans">
                        Hai! Senang bertemu dengan Anda. Aku adalah <strong class="text-white">Yuna</strong>, asisten cerdas untuk website portofolio <strong class="text-white">I Made Yuda Pramana</strong>. Anda bisa mengobrol atau bertanya seputar <strong class="text-white">Sistem Operasi Linux &amp; Perintah Terminal</strong>, serta seluk-beluk <strong class="text-white">Website Portofolio Ini</strong> (arsitektur server LEMP, framework Laravel 11, Tailwind v4, sertifikasi Cisco, dan aplikasi IT Toolbox). Silakan sapa atau tanyakan hal yang ingin Anda ketahui.
                    </p>
                </div>

                <!-- Tombol Pertanyaan Cepat Rekomendasi (Bentuk Kapsul rounded-full) -->
                <div>
                    <div class="text-[11px] font-mono uppercase tracking-wider text-[#737373] font-semibold mb-3 px-1">Pertanyaan Cepat Rekomendasi:</div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        <button type="button" class="console-quick-prompt text-left px-4 py-3 rounded-full bg-[#161616] hover:bg-[#202020] hover:border-white/40 border border-[#222222] text-[#f5f5f5] text-xs font-semibold transition-all flex items-center justify-between group cursor-pointer shadow-sm">
                            <span>Hai Yuna, kamu bisa bantu apa saja di sini?</span>
                            <span class="text-[#737373] group-hover:text-white group-hover:translate-x-0.5 transition-all">&rarr;</span>
                        </button>
                        <button type="button" class="console-quick-prompt text-left px-4 py-3 rounded-full bg-[#161616] hover:bg-[#202020] hover:border-white/40 border border-[#222222] text-[#f5f5f5] text-xs font-semibold transition-all flex items-center justify-between group cursor-pointer shadow-sm">
                            <span>Apa teknologi yang digunakan untuk membangun web ini?</span>
                            <span class="text-[#737373] group-hover:text-white group-hover:translate-x-0.5 transition-all">&rarr;</span>
                        </button>
                        <button type="button" class="console-quick-prompt text-left px-4 py-3 rounded-full bg-[#161616] hover:bg-[#202020] hover:border-white/40 border border-[#222222] text-[#f5f5f5] text-xs font-semibold transition-all flex items-center justify-between group cursor-pointer shadow-sm">
                            <span>Bagaimana cara kerja perintah chmod dan chown di Linux?</span>
                            <span class="text-[#737373] group-hover:text-white group-hover:translate-x-0.5 transition-all">&rarr;</span>
                        </button>
                        <button type="button" class="console-quick-prompt text-left px-4 py-3 rounded-full bg-[#161616] hover:bg-[#202020] hover:border-white/40 border border-[#222222] text-[#f5f5f5] text-xs font-semibold transition-all flex items-center justify-between group cursor-pointer shadow-sm">
                            <span>Jelaskan fitur aplikasi IT Toolbox buatan Yuda</span>
                            <span class="text-[#737373] group-hover:text-white group-hover:translate-x-0.5 transition-all">&rarr;</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Kontainer Percakapan Dinamis -->
            <div id="console-conversation-list" class="space-y-5 max-w-3xl mx-auto"></div>

            <!-- Status 2: Kerangka Pemuatan (Loading Skeleton) -->
            <div id="console-loading" class="hidden flex items-start gap-3 max-w-3xl mx-auto">
                <div class="w-8 h-8 rounded-xl bg-[#141414] p-1 flex items-center justify-center shrink-0 border border-white/20">
                    <img src="{{ asset('images/yuna-logo.svg') }}" alt="Yuna" class="w-full h-full object-contain">
                </div>
                <div class="p-4 rounded-2xl rounded-tl-sm bg-[#161616] border border-[#262626] shadow-sm flex items-center gap-2.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-white animate-bounce"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-white animate-bounce [animation-delay:0.15s]"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-white animate-bounce [animation-delay:0.3s]"></span>
                    <span class="text-xs font-mono text-[#a3a3a3] ml-1">Yuna sedang menyusun jawaban...</span>
                </div>
            </div>

            <!-- Status 3: Penanganan Batas Kesalahan + Coba Lagi (Error Boundary + Retry) -->
            <div id="console-error-boundary" class="hidden p-4 rounded-2xl bg-[#1f1414] border border-rose-900/50 text-rose-200 text-xs space-y-2 max-w-3xl mx-auto">
                <div class="flex items-center gap-2 font-bold text-rose-400">
                    <svg class="w-4 h-4 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Gagal Mengambil Respon</span>
                </div>
                <p id="console-error-message" class="text-xs text-rose-300/90">
                    Terjadi gangguan koneksi jaringan.
                </p>
                <button id="console-retry-btn" type="button" class="px-4 py-2 rounded-full bg-rose-600 hover:bg-rose-700 text-white font-bold transition-colors cursor-pointer inline-flex items-center gap-1.5 shrink-0">
                    <span>Coba Lagi</span>
                    <span>&circlearrowright;</span>
                </button>
            </div>

        </div>

        <!-- Bar Input Konsol (Sticky Console Input Bar) -->
        <div class="p-3.5 sm:p-4 bg-[#141414] border-t border-[#1f1f1f] shrink-0">
            <form id="console-form" class="max-w-3xl mx-auto flex items-center gap-2 sm:gap-3" autocomplete="off">
                <div class="relative flex-1">
                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-white font-mono font-bold text-xs select-none">
                        $&gt;
                    </div>
                    <input id="console-input" 
                           type="text" 
                           maxlength="600"
                           placeholder="Tanyakan perintah Linux, teknologi web ini, atau proyek Yuda..." 
                           class="w-full pl-9 pr-8 py-3 rounded-full bg-[#0e0e0e] border border-[#262626] text-xs sm:text-sm text-[#f5f5f5] placeholder:text-[#525252] focus:bg-[#0e0e0e] focus:outline-none focus:border-white focus:ring-2 focus:ring-white/20 transition-all font-mono"
                           required>
                    <button id="console-clear-input" type="button" class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-neutral-500 hover:text-white p-1 cursor-pointer" aria-label="Bersihkan input">
                        &times;
                    </button>
                </div>

                <button id="console-submit-btn" 
                        type="submit" 
                        class="px-5 sm:px-7 py-3 rounded-full bg-white hover:bg-neutral-200 active:scale-95 text-black font-bold transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white disabled:opacity-50 disabled:pointer-events-none cursor-pointer shrink-0 shadow-lg shadow-white/10 flex items-center gap-2"
                        aria-label="Kirim Pertanyaan">
                    <span class="hidden sm:inline text-xs font-mono">KIRIM</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>
            <div class="max-w-3xl mx-auto mt-2 flex items-center justify-between text-[11px] text-[#737373] font-mono px-1">
                <span class="hidden sm:inline">Tekan <kbd class="px-1.5 py-0.5 rounded bg-[#222222] text-[#d4d4d4]">Enter ↵</kbd> untuk mengeksekusi</span>
                <span class="sm:hidden text-[#737373]">Yuna AI Terminal</span>
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-white shadow-[0_0_6px_rgba(255,255,255,0.4)]"></span>
                    <span>Yuna AI Siap Membantu</span>
                </span>
            </div>
        </div>

    </main>

</div>

@push('scripts')
<script>
(function() {
    const root = document.getElementById('pramana-console-root');
    if (!root) return;

    const form = document.getElementById('console-form');
    const input = document.getElementById('console-input');
    const clearInputBtn = document.getElementById('console-clear-input');
    const submitBtn = document.getElementById('console-submit-btn');
    const messagesContainer = document.getElementById('console-messages');
    const conversationList = document.getElementById('console-conversation-list');
    const emptyState = document.getElementById('console-empty-state');
    const loadingState = document.getElementById('console-loading');
    const errorBoundary = document.getElementById('console-error-boundary');
    const errorMessage = document.getElementById('console-error-message');
    const retryBtn = document.getElementById('console-retry-btn');
    const resetBtn = document.getElementById('console-reset-btn');
    const exportBtn = document.getElementById('console-export-btn');
    const quickPrompts = document.querySelectorAll('.console-quick-prompt');

    const csrfToken = root.dataset.csrf;
    const endpoint = root.dataset.endpoint;

    let lastSentMessage = '';
    let isSubmitting = false;
    let chatLog = [];

    // Tangani Pertanyaan Cepat Rekomendasi
    quickPrompts.forEach(btn => {
        btn.addEventListener('click', () => {
            const promptText = btn.querySelector('span').textContent.replace(/^[^\w\s]+/, '').trim();
            input.value = promptText;
            sendMessage(promptText);
        });
    });

    // Tangani Input Teks & Tombol Bersihkan
    input.addEventListener('input', () => {
        if (input.value.trim().length > 0) {
            clearInputBtn.classList.remove('hidden');
        } else {
            clearInputBtn.classList.add('hidden');
        }
    });

    clearInputBtn.addEventListener('click', () => {
        input.value = '';
        clearInputBtn.classList.add('hidden');
        input.focus();
    });

    // Reset Sesi Percakapan
    resetBtn.addEventListener('click', () => {
        conversationList.innerHTML = '';
        emptyState.classList.remove('hidden');
        errorBoundary.classList.add('hidden');
        loadingState.classList.add('hidden');
        chatLog = [];
        input.value = '';
        input.focus();
    });

    // Ekspor Log Percakapan (.txt)
    exportBtn.addEventListener('click', () => {
        if (!chatLog.length) {
            alert('Belum ada percakapan untuk diekspor.');
            return;
        }
        let content = "=== YUNA AI SESSION LOG ===\n";
        content += "Waktu: " + new Date().toLocaleString() + "\n";
        content += "Asisten: Yuna AI - Portofolio I Made Yuda Pramana\n\n";
        chatLog.forEach(item => {
            content += "[" + item.time + "] " + item.sender.toUpperCase() + ":\n" + item.text + "\n\n";
        });

        const blob = new Blob([content], { type: 'text/plain;charset=utf-8' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'yuna-session-' + Date.now() + '.txt';
        a.click();
        URL.revokeObjectURL(url);
    });

    // Coba Lagi Pengiriman
    retryBtn.addEventListener('click', () => {
        if (lastSentMessage) {
            sendMessage(lastSentMessage);
        }
    });

    // Kirim Formulir Pertanyaan
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const text = input.value.trim();
        if (!text || isSubmitting) return;
        sendMessage(text);
    });

    function scrollToBottom() {
        setTimeout(() => {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }, 50);
    }

    // Parser Markdown dengan Proteksi XSS Ketat
    function parseMarkdown(text) {
        if (!text) return '';
        
        let html = text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        // Blok kode: ```bahasa...```
        html = html.replace(/```([a-zA-Z0-9_-]*)\n?([\s\S]*?)```/g, function(match, lang, code) {
            const displayLang = lang ? lang.toUpperCase() : 'CODE';
            return '<div class="my-3 rounded-2xl bg-[#0a0a0a] border border-[#2a2a2a] overflow-hidden shadow-sm font-mono text-xs">' +
                   '<div class="px-3.5 py-2 bg-[#000000] border-b border-[#2a2a2a] text-[11px] text-[#878787] font-semibold flex items-center justify-between">' +
                   '<span>' + displayLang + '</span>' +
                   '<button type="button" class="console-code-copy text-neutral-400 hover:text-white transition-colors cursor-pointer">Salin Kode &boxbox;</button>' +
                   '</div>' +
                   '<pre class="p-3.5 text-neutral-200 overflow-x-auto leading-relaxed"><code>' + code.trim() + '</code></pre>' +
                   '</div>';
        });

        // Kode inline: `...`
        html = html.replace(/`([^`]+)`/g, '<code class="px-1.5 py-0.5 rounded bg-white/10 font-mono text-xs text-white font-semibold">$1</code>');

        // Teks tebal: **...**
        html = html.replace(/\*\*([^*]+)\*\*/g, '<strong class="font-bold text-white">$1</strong>');

        // Teks miring: _..._
        html = html.replace(/_([^_]+)_/g, '<em class="italic text-neutral-400">$1</em>');

        // Tautan: [teks](url) yang tervalidasi aman
        html = html.replace(/\[([^\]]+)\]\(([^)]+)\)/g, function(match, linkText, url) {
            const cleanUrl = url.trim();
            if (/^(https?:\/\/|mailto:)/i.test(cleanUrl)) {
                const safeUrl = cleanUrl.replace(/["'<>]/g, '');
                return '<a href="' + safeUrl + '" target="_blank" rel="noopener noreferrer" class="text-white underline font-semibold hover:text-neutral-300">' + linkText + '</a>';
            }
            return linkText;
        });

        // Daftar tidak terurut dan terurut
        html = html.replace(/^\s*[-*]\s+(.+)$/gm, '<li class="ml-5 list-disc text-neutral-300 my-1">$1</li>');
        html = html.replace(/^\s*(\d+)\.\s+(.+)$/gm, '<li class="ml-5 list-decimal text-neutral-300 my-1">$2</li>');

        // Pemisah paragraf
        html = html.replace(/\n\n+/g, '<div class="h-2.5"></div>');
        html = html.replace(/\n/g, '<br>');

        return html;
    }

    function appendMessage(sender, text, source) {
        emptyState.classList.add('hidden');

        const timeStr = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        chatLog.push({ sender, text, time: timeStr });

        const messageWrapper = document.createElement('div');
        messageWrapper.className = 'flex items-start gap-3 sm:gap-4 animate-fade-in';

        if (sender === 'user') {
            messageWrapper.classList.add('justify-end');
            messageWrapper.innerHTML = `
                <div class="max-w-[85%] sm:max-w-[80%] p-4 rounded-2xl rounded-tr-sm bg-white text-black font-medium shadow-md text-xs sm:text-sm leading-relaxed break-words font-sans">
                    ${escapeHtml(text)}
                </div>
            `;
        } else {
            const formattedContent = parseMarkdown(text);
            const sourceBadge = source === 'guardrail_rejection' 
                ? '<span class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-amber-500/10 text-amber-300 border border-amber-500/30">Guardrail Scope</span>'
                : (source === 'security_guardrail'
                    ? '<span class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-rose-500/10 text-rose-300 border border-rose-500/30">Security Guardrail</span>'
                    : '<span class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-white/10 text-white border border-white/20">Verified AI</span>');

            messageWrapper.innerHTML = `
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-2xl bg-[#141414] p-1.5 flex items-center justify-center shrink-0 border border-white/20 shadow-sm mt-0.5">
                    <img src="/images/yuna-logo.svg" alt="Yuna" class="w-full h-full object-contain">
                </div>
                <div class="max-w-[88%] sm:max-w-[85%] p-4 sm:p-5 rounded-2xl rounded-tl-sm bg-[#161616] border border-[#262626] shadow-md text-[#f5f5f5] space-y-3 font-sans">
                    <div class="flex items-center justify-between gap-3 border-b border-[#262626] pb-2">
                        <div class="flex items-center gap-2">
                            <span class="text-xs sm:text-sm font-bold text-white">Yuna</span>
                            ${sourceBadge}
                        </div>
                        <span class="font-mono text-[11px] text-[#737373]">${timeStr}</span>
                    </div>
                    <div class="console-response text-xs sm:text-sm leading-relaxed space-y-1.5">
                        ${formattedContent}
                    </div>
                    <div class="pt-2 flex items-center justify-between border-t border-[#262626] text-[11px] text-[#737373] font-mono">
                        <span>Yuna AI Assistant</span>
                        <button type="button" class="console-copy-btn hover:text-white transition-colors p-1 flex items-center gap-1 cursor-pointer font-medium" title="Salin respon">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <span>Salin Respon</span>
                        </button>
                    </div>
                </div>
            `;

            // Tangani aksi salin untuk seluruh respon
            const copyBtn = messageWrapper.querySelector('.console-copy-btn');
            if (copyBtn) {
                copyBtn.addEventListener('click', () => {
                    navigator.clipboard.writeText(text).then(() => {
                        copyBtn.innerHTML = '<span>Tersalin! ✓</span>';
                        setTimeout(() => {
                            copyBtn.innerHTML = `
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span>Salin Respon</span>
                            `;
                        }, 2000);
                    });
                });
            }

            // Tangani aksi salin untuk blok kode individual
            messageWrapper.querySelectorAll('.console-code-copy').forEach(btn => {
                btn.addEventListener('click', () => {
                    const code = btn.closest('.my-3').querySelector('code').textContent;
                    navigator.clipboard.writeText(code).then(() => {
                        btn.textContent = 'Tersalin!';
                        setTimeout(() => btn.textContent = 'Salin Kode ⧉', 2000);
                    });
                });
            });
        }

        conversationList.appendChild(messageWrapper);
        scrollToBottom();
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    async function sendMessage(messageText) {
        lastSentMessage = messageText;
        isSubmitting = true;
        submitBtn.disabled = true;
        input.value = '';
        clearInputBtn.classList.add('hidden');

        appendMessage('user', messageText);

        loadingState.classList.remove('hidden');
        errorBoundary.classList.add('hidden');
        scrollToBottom();

        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ message: messageText })
            });

            const data = await response.json();

            loadingState.classList.add('hidden');
            isSubmitting = false;
            submitBtn.disabled = false;

            if (response.ok && data.success) {
                appendMessage('bot', data.reply, data.source);
            } else {
                throw new Error(data.message || 'Terjadi kesalahan sistem.');
            }
        } catch (err) {
            loadingState.classList.add('hidden');
            isSubmitting = false;
            submitBtn.disabled = false;

            errorMessage.textContent = err.message || 'Tidak dapat menghubungi server. Periksa koneksi jaringan Anda.';
            errorBoundary.classList.remove('hidden');
            scrollToBottom();
        }
    }
})();
</script>
@endpush
@endsection
