{{-- Yuna AI - Interactive Linux & Portofolio Assistant --}}
<div id="tkj-chatbot-root" class="fixed bottom-6 right-6 z-50 font-sans" data-csrf="{{ csrf_token() }}" data-endpoint="{{ route('chatbot.message') }}" data-page-url="{{ route('ai.index') }}">
    
    <!-- Floating Trigger Button -->
    <button id="chatbot-toggle-btn" 
            type="button" 
            class="group relative flex items-center gap-3 px-4 py-3 rounded-full bg-[#0C382E] hover:bg-[#144D3F] text-white shadow-2xl shadow-[#0C382E]/40 border border-[#165B4C] transition-all duration-300 hover:scale-[1.03] active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#0C382E] cursor-pointer"
            aria-label="Buka Yuna AI"
            aria-expanded="false"
            aria-controls="chatbot-modal">
        
        <!-- Official Yuna AI Emblem with Pulsing Status LED -->
        <div class="relative w-8 h-8 flex items-center justify-center shrink-0">
            <img src="{{ asset('images/yuna-logo.svg') }}" alt="Yuna AI" class="w-full h-full object-contain filter drop-shadow">
            <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
            <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-emerald-500 border-2 border-[#0C382E]"></span>
        </div>

        <div class="flex flex-col text-left">
            <div class="flex items-center gap-1.5">
                <span class="text-xs font-bold tracking-tight text-[#F8F5EE] group-hover:text-emerald-200 transition-colors">Yuna AI</span>
                <span class="text-[9px] font-mono px-1.5 py-0.2 rounded bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">Linux // Web</span>
            </div>
            <span class="text-[10px] text-emerald-300/80 font-mono hidden sm:inline">Asisten AI Portofolio &amp; Linux</span>
        </div>

        <div class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center text-xs text-white/80 group-hover:translate-x-0.5 transition-transform">
            &rarr;
        </div>
    </button>

    <!-- Chat Dialog Window (Standard Floating or Maximized Fullscreen) -->
    <div id="chatbot-modal" 
         class="hidden fixed bottom-6 right-6 w-[calc(100vw-2rem)] sm:w-[430px] max-w-[430px] h-[580px] max-h-[calc(100vh-4rem)] rounded-3xl bg-[#FAF8F5] border border-stone-300/90 shadow-2xl shadow-stone-900/30 flex-col overflow-hidden backdrop-blur-2xl transition-all duration-300 animate-scale-in z-50">
        
        <!-- Header: Deep Forest Green (#0C382E) Editorial Glass -->
        <div class="px-4.5 py-3 bg-[#0C382E] text-white flex items-center justify-between border-b border-[#144D3F] shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-[#07241E] p-1 border border-emerald-400/30 flex items-center justify-center shadow-inner">
                    <img src="{{ asset('images/yuna-logo.svg') }}" alt="Yuna" class="w-full h-full object-contain">
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <h3 class="text-xs sm:text-sm font-extrabold text-white tracking-tight">Yuna</h3>
                        <span class="text-[9px] font-mono px-1.5 py-0.5 rounded-full bg-emerald-500/25 text-emerald-300 border border-emerald-500/40 font-semibold">Active</span>
                    </div>
                    <p class="text-[10px] text-emerald-100/70 font-mono">Interactive AI &bull; Linux &amp; Portofolio</p>
                </div>
            </div>

            <!-- Header Action Controls -->
            <div class="flex items-center gap-1">
                <!-- Dedicated Full Page Link -->
                <a href="{{ route('ai.index') }}" 
                   class="p-1.5 rounded-lg text-emerald-200 hover:text-white hover:bg-white/10 transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-white" 
                   title="Buka Halaman Penuh Tersendiri (/ai)"
                   aria-label="Buka Halaman Khusus AI">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>

                <!-- Fullscreen Toggle Button -->
                <button id="chatbot-fullscreen-btn" 
                        type="button" 
                        class="p-1.5 rounded-lg text-emerald-200 hover:text-white hover:bg-white/10 transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-white cursor-pointer" 
                        title="Perbesar Layar Penuh"
                        aria-label="Toggle Fullscreen">
                    <!-- Maximize Icon -->
                    <svg id="fullscreen-expand-icon" class="w-4 h-4 block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                    </svg>
                    <!-- Minimize Icon -->
                    <svg id="fullscreen-compress-icon" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9L4 4m0 5h5V4m6 5l5-5m-5 5h5V4m-5 11l5 5m-5-5v5h5m-11 0l-5 5m5-5H4v5" />
                    </svg>
                </button>

                <!-- Reset Conversation Button -->
                <button id="chatbot-reset-btn" 
                        type="button" 
                        class="p-1.5 rounded-lg text-emerald-200 hover:text-white hover:bg-white/10 transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-white cursor-pointer" 
                        title="Bersihkan percakapan"
                        aria-label="Bersihkan obrolan">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>

                <!-- Close Button -->
                <button id="chatbot-close-btn" 
                        type="button" 
                        class="p-1.5 rounded-lg text-emerald-200 hover:text-white hover:bg-white/10 transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-white cursor-pointer" 
                        title="Tutup jendela chat"
                        aria-label="Tutup chatbot">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Topic Indicator Banner -->
        <div class="bg-emerald-500/10 border-b border-emerald-500/20 px-4 py-1.5 text-[11px] text-[#0C382E] flex items-center justify-between gap-2 shrink-0">
            <div class="flex items-center gap-2 truncate">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                <span class="truncate">Asisten Cerdas: <strong>Linux</strong>, <strong>Jaringan &amp; Infrastruktur</strong>, serta <strong>Portofolio Yuda</strong></span>
            </div>
            <a href="{{ route('ai.index') }}" class="text-[10px] text-[#0C382E] font-bold underline hover:text-[#144D3F] shrink-0 font-mono">Halaman Penuh &rarr;</a>
        </div>

        <!-- Chat Stream Messages (Scrollable) -->
        <div id="chatbot-messages" class="flex-1 p-4 sm:p-5 overflow-y-auto space-y-4 text-xs leading-relaxed text-[#1C1917] scroll-smooth">
            
            <!-- State 1: Empty State / Initial Greeting -->
            <div id="chatbot-empty-state" class="space-y-4 py-1">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-[#0C382E] p-1 flex items-center justify-center shrink-0 mt-0.5 shadow-sm border border-emerald-500/30">
                        <img src="{{ asset('images/yuna-logo.svg') }}" alt="Yuna" class="w-full h-full object-contain">
                    </div>
                    <div class="p-4 rounded-2xl rounded-tl-sm bg-white border border-stone-200/90 shadow-xs text-[#1C1917] space-y-2">
                        <p class="font-medium text-xs sm:text-sm">
                            Halo! Aku <strong>Yuna</strong>, asisten AI cerdas untuk website portofolio <strong>I Made Yuda Pramana</strong>.
                        </p>
                        <p class="text-[11px] text-stone-600 leading-relaxed">
                            Kamu bisa menyapa Yuna, bertanya seputar <strong>perintah Linux</strong>, administrasi server Debian LEMP, hingga sertifikasi dan proyek Yuda.
                        </p>
                    </div>
                </div>

                <!-- Suggested Prompt Pills -->
                <div class="pt-1">
                    <div class="text-[10px] font-mono uppercase tracking-wider text-stone-500 font-semibold mb-2 px-1">Pertanyaan Cepat:</div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <button type="button" class="chatbot-quick-prompt text-left px-3 py-2.5 rounded-xl bg-white hover:bg-stone-100 border border-stone-200/90 text-[#0C382E] text-xs font-medium transition-colors flex items-center justify-between group cursor-pointer shadow-2xs">
                            <span>Hai Yuna, kamu bisa apa saja?</span>
                            <span class="text-stone-400 group-hover:text-[#0C382E] group-hover:translate-x-0.5 transition-all">&rarr;</span>
                        </button>
                        <button type="button" class="chatbot-quick-prompt text-left px-3 py-2.5 rounded-xl bg-white hover:bg-stone-100 border border-stone-200/90 text-[#0C382E] text-xs font-medium transition-colors flex items-center justify-between group cursor-pointer shadow-2xs">
                            <span>Apa teknologi pembangun web ini?</span>
                            <span class="text-stone-400 group-hover:text-[#0C382E] group-hover:translate-x-0.5 transition-all">&rarr;</span>
                        </button>
                        <button type="button" class="chatbot-quick-prompt text-left px-3 py-2.5 rounded-xl bg-white hover:bg-stone-100 border border-stone-200/90 text-[#0C382E] text-xs font-medium transition-colors flex items-center justify-between group cursor-pointer shadow-2xs">
                            <span>Bagaimana cara kerja chmod dan chown?</span>
                            <span class="text-stone-400 group-hover:text-[#0C382E] group-hover:translate-x-0.5 transition-all">&rarr;</span>
                        </button>
                        <button type="button" class="chatbot-quick-prompt text-left px-3 py-2.5 rounded-xl bg-white hover:bg-stone-100 border border-stone-200/90 text-[#0C382E] text-xs font-medium transition-colors flex items-center justify-between group cursor-pointer shadow-2xs">
                            <span>Jelaskan fitur aplikasi IT Toolbox</span>
                            <span class="text-stone-400 group-hover:text-[#0C382E] group-hover:translate-x-0.5 transition-all">&rarr;</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Dynamic Message Container -->
            <div id="chatbot-conversation-list" class="space-y-4"></div>

            <!-- State 2: Loading Skeleton -->
            <div id="chatbot-loading" class="hidden flex items-start gap-3">
                <div class="w-8 h-8 rounded-xl bg-[#0C382E] p-1 flex items-center justify-center shrink-0 border border-emerald-500/30">
                    <img src="{{ asset('images/yuna-logo.svg') }}" alt="Yuna" class="w-full h-full object-contain">
                </div>
                <div class="p-3.5 rounded-2xl rounded-tl-sm bg-white border border-stone-200/80 shadow-xs flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-600 animate-bounce"></span>
                    <span class="w-2 h-2 rounded-full bg-emerald-600 animate-bounce [animation-delay:0.15s]"></span>
                    <span class="w-2 h-2 rounded-full bg-emerald-600 animate-bounce [animation-delay:0.3s]"></span>
                    <span class="text-[11px] font-mono text-stone-600 ml-1">Yuna sedang mengetik respon...</span>
                </div>
            </div>

            <!-- State 3: Error Boundary + Retry -->
            <div id="chatbot-error-boundary" class="hidden p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-2">
                <div class="flex items-center gap-2 font-bold text-rose-700">
                    <svg class="w-4 h-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Gagal Mengambil Respon</span>
                </div>
                <p id="chatbot-error-message" class="text-[11px] text-rose-700/90">
                    Koneksi terganggu atau permintaan tidak dapat diproses.
                </p>
                <button id="chatbot-retry-btn" type="button" class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-[11px] font-bold transition-colors cursor-pointer inline-flex items-center gap-1">
                    <span>Coba Lagi</span>
                    <span>&circlearrowright;</span>
                </button>
            </div>

        </div>

        <!-- Input Bar (Sticky Footer) -->
        <div class="p-3.5 bg-white border-t border-stone-200/90 shrink-0">
            <form id="chatbot-form" class="flex items-center gap-2" autocomplete="off">
                <div class="relative flex-1">
                    <input id="chatbot-input" 
                           type="text" 
                           maxlength="500"
                           placeholder="Tanyakan perintah Linux, teknologi web ini, spek server, atau proyek Yuda..." 
                           class="w-full pl-3.5 pr-8 py-2.5 rounded-xl bg-stone-100 border border-stone-200 text-xs text-[#1C1917] placeholder:text-stone-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0C382E] transition-all"
                           required>
                    <button id="chatbot-clear-input" type="button" class="hidden absolute right-2.5 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-600 p-0.5" aria-label="Bersihkan input">
                        &times;
                    </button>
                </div>
                
                <button id="chatbot-submit-btn" 
                        type="submit" 
                        class="p-2.5 rounded-xl bg-[#0C382E] hover:bg-[#144D3F] active:scale-95 text-white transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0C382E] disabled:opacity-50 disabled:pointer-events-none cursor-pointer shrink-0 shadow-md shadow-[#0C382E]/20"
                        aria-label="Kirim Pesan">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>
            <div class="mt-2 flex items-center justify-between text-[10px] text-stone-500 font-mono px-1">
                <span>Tekan <kbd class="px-1 py-0.5 rounded bg-stone-200 text-stone-700">Enter</kbd> untuk kirim</span>
                <a href="{{ route('ai.index') }}" class="hover:text-[#0C382E] transition-colors font-semibold">Buka Halaman Penuh (/ai) &rarr;</a>
            </div>
        </div>

    </div>

</div>

<!-- Chatbot Script & Reactivity with Fullscreen Mode -->
<script>
(function() {
    const root = document.getElementById('tkj-chatbot-root');
    if (!root) return;

    const toggleBtn = document.getElementById('chatbot-toggle-btn');
    const modal = document.getElementById('chatbot-modal');
    const closeBtn = document.getElementById('chatbot-close-btn');
    const resetBtn = document.getElementById('chatbot-reset-btn');
    const fullscreenBtn = document.getElementById('chatbot-fullscreen-btn');
    const expandIcon = document.getElementById('fullscreen-expand-icon');
    const compressIcon = document.getElementById('fullscreen-compress-icon');
    const form = document.getElementById('chatbot-form');
    const input = document.getElementById('chatbot-input');
    const clearInputBtn = document.getElementById('chatbot-clear-input');
    const submitBtn = document.getElementById('chatbot-submit-btn');
    const messagesContainer = document.getElementById('chatbot-messages');
    const conversationList = document.getElementById('chatbot-conversation-list');
    const emptyState = document.getElementById('chatbot-empty-state');
    const loadingState = document.getElementById('chatbot-loading');
    const errorBoundary = document.getElementById('chatbot-error-boundary');
    const errorMessage = document.getElementById('chatbot-error-message');
    const retryBtn = document.getElementById('chatbot-retry-btn');
    const quickPrompts = document.querySelectorAll('.chatbot-quick-prompt');

    const csrfToken = root.dataset.csrf;
    const endpoint = root.dataset.endpoint;

    let isFullscreen = false;
    let lastSentMessage = '';
    let isSubmitting = false;

    // Toggle Modal
    function openChat() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        toggleBtn.setAttribute('aria-expanded', 'true');
        setTimeout(() => input.focus(), 100);
        scrollToBottom();
    }

    function closeChat() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        toggleBtn.setAttribute('aria-expanded', 'false');
    }

    toggleBtn.addEventListener('click', () => {
        if (modal.classList.contains('hidden')) {
            openChat();
        } else {
            closeChat();
        }
    });

    closeBtn.addEventListener('click', closeChat);

    // Fullscreen Toggle
    function setFullscreen(enable) {
        isFullscreen = enable;
        if (isFullscreen) {
            // Expand modal to comfortable high-density broadsheet
            modal.classList.remove('sm:w-[430px]', 'max-w-[430px]', 'h-[580px]', 'max-h-[calc(100vh-4rem)]', 'bottom-6', 'right-6');
            modal.classList.add('inset-3', 'sm:inset-6', 'w-auto', 'max-w-5xl', 'h-auto', 'max-h-none', 'mx-auto');
            expandIcon.classList.add('hidden');
            expandIcon.classList.remove('block');
            compressIcon.classList.remove('hidden');
            compressIcon.classList.add('block');
            fullscreenBtn.setAttribute('title', 'Kecilkan Tampilan');
        } else {
            // Return to compact floating widget
            modal.classList.add('sm:w-[430px]', 'max-w-[430px]', 'h-[580px]', 'max-h-[calc(100vh-4rem)]', 'bottom-6', 'right-6');
            modal.classList.remove('inset-3', 'sm:inset-6', 'w-auto', 'max-w-5xl', 'h-auto', 'max-h-none', 'mx-auto');
            expandIcon.classList.remove('hidden');
            expandIcon.classList.add('block');
            compressIcon.classList.add('hidden');
            compressIcon.classList.remove('block');
            fullscreenBtn.setAttribute('title', 'Perbesar Layar Penuh');
        }
        scrollToBottom();
    }

    if (fullscreenBtn) {
        fullscreenBtn.addEventListener('click', () => {
            setFullscreen(!isFullscreen);
        });
    }

    // Close on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            if (isFullscreen) {
                setFullscreen(false);
            } else {
                closeChat();
            }
        }
    });

    // Reset Chat
    resetBtn.addEventListener('click', () => {
        conversationList.innerHTML = '';
        emptyState.classList.remove('hidden');
        errorBoundary.classList.add('hidden');
        loadingState.classList.add('hidden');
        input.value = '';
        input.focus();
    });

    // Input Clear
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

    // Quick Prompts
    quickPrompts.forEach(btn => {
        btn.addEventListener('click', () => {
            const promptText = btn.querySelector('span').textContent.replace(/^[^\w\s]+/, '').trim();
            input.value = promptText;
            sendMessage(promptText);
        });
    });

    // Retry
    retryBtn.addEventListener('click', () => {
        if (lastSentMessage) {
            sendMessage(lastSentMessage);
        }
    });

    // Form Submit
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

    // Markdown Parser with strict XSS immunity
    function parseMarkdown(text) {
        if (!text) return '';
        
        let html = text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        // Code blocks: ```language...```
        html = html.replace(/```([a-zA-Z0-9_-]*)\n?([\s\S]*?)```/g, function(match, lang, code) {
            const displayLang = lang ? lang.toUpperCase() : 'CODE';
            return '<div class="my-2.5 rounded-xl bg-stone-900 border border-stone-800 overflow-hidden shadow-sm font-mono text-[11px]">' +
                   '<div class="px-3 py-1.5 bg-stone-950/80 border-b border-stone-800 text-[10px] text-stone-400 font-semibold flex items-center justify-between">' +
                   '<span>' + displayLang + '</span>' +
                   '<button type="button" class="chatbot-code-copy hover:text-emerald-400 transition-colors cursor-pointer">Salin</button>' +
                   '</div>' +
                   '<pre class="p-3 text-emerald-300 overflow-x-auto leading-relaxed"><code>' + code.trim() + '</code></pre>' +
                   '</div>';
        });

        // Inline code: `...`
        html = html.replace(/`([^`]+)`/g, '<code class="px-1.5 py-0.5 rounded bg-stone-200 font-mono text-[11px] text-[#0C382E] font-semibold">$1</code>');

        // Bold: **...**
        html = html.replace(/\*\*([^*]+)\*\*/g, '<strong class="font-bold text-[#1C1917]">$1</strong>');

        // Italic: _..._
        html = html.replace(/_([^_]+)_/g, '<em class="italic text-stone-600">$1</em>');

        // Links: [text](url) - Strictly whitelisted to prevent javascript: or data: injection
        html = html.replace(/\[([^\]]+)\]\(([^)]+)\)/g, function(match, linkText, url) {
            const cleanUrl = url.trim();
            if (/^(https?:\/\/|mailto:)/i.test(cleanUrl)) {
                const safeUrl = cleanUrl.replace(/["'<>]/g, '');
                return '<a href="' + safeUrl + '" target="_blank" rel="noopener noreferrer" class="text-emerald-700 underline font-semibold hover:text-[#0C382E]">' + linkText + '</a>';
            }
            return linkText;
        });

        // Unordered lists (- or *)
        html = html.replace(/^\s*[-*]\s+(.+)$/gm, '<li class="ml-4 list-disc text-stone-700 my-0.5">$1</li>');

        // Ordered lists (1. 2.)
        html = html.replace(/^\s*(\d+)\.\s+(.+)$/gm, '<li class="ml-4 list-decimal text-stone-700 my-0.5">$2</li>');

        // Paragraphs / line breaks
        html = html.replace(/\n\n+/g, '<div class="h-2"></div>');
        html = html.replace(/\n/g, '<br>');

        return html;
    }

    // Append Message to UI
    function appendMessage(sender, text, source) {
        emptyState.classList.add('hidden');

        const messageWrapper = document.createElement('div');
        messageWrapper.className = 'flex items-start gap-3 animate-fade-in';

        if (sender === 'user') {
            messageWrapper.classList.add('justify-end');
            messageWrapper.innerHTML = `
                <div class="max-w-[85%] p-3.5 rounded-2xl rounded-tr-sm bg-[#0C382E] text-white shadow-sm text-xs leading-relaxed break-words">
                    ${escapeHtml(text)}
                </div>
            `;
        } else {
            const formattedContent = parseMarkdown(text);
            const sourceBadge = source === 'guardrail_rejection' 
                ? '<span class="text-[9px] font-mono px-1.5 py-0.5 rounded bg-amber-100 text-amber-800 border border-amber-300">Guardrail Scope</span>'
                : (source === 'security_guardrail'
                    ? '<span class="text-[9px] font-mono px-1.5 py-0.5 rounded bg-rose-100 text-rose-800 border border-rose-300">Security Guardrail</span>'
                    : '<span class="text-[9px] font-mono px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 border border-emerald-300">AI Response</span>');

            messageWrapper.innerHTML = `
                <div class="w-8 h-8 rounded-xl bg-[#0C382E] p-1 flex items-center justify-center shrink-0 mt-0.5 border border-emerald-500/30 shadow-sm">
                    <img src="/images/yuna-logo.svg" alt="Yuna" class="w-full h-full object-contain">
                </div>
                <div class="max-w-[88%] p-4 rounded-2xl rounded-tl-sm bg-white border border-stone-200/90 shadow-xs text-[#1C1917] space-y-2.5">
                    <div class="flex items-center justify-between gap-2 border-b border-stone-100 pb-1.5">
                        <span class="text-[11px] font-bold text-[#0C382E]">Yuna</span>
                        ${sourceBadge}
                    </div>
                    <div class="chatbot-content text-xs leading-relaxed space-y-1">
                        ${formattedContent}
                    </div>
                    <div class="pt-1.5 flex items-center justify-between border-t border-stone-100 text-[10px] text-stone-400">
                        <span class="font-mono">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                        <button type="button" class="chatbot-copy-btn hover:text-[#0C382E] transition-colors p-1 flex items-center gap-1 cursor-pointer font-medium" title="Salin jawaban">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <span>Salin</span>
                        </button>
                    </div>
                </div>
            `;

            // Setup copy action for entire reply
            const copyBtn = messageWrapper.querySelector('.chatbot-copy-btn');
            if (copyBtn) {
                copyBtn.addEventListener('click', () => {
                    navigator.clipboard.writeText(text).then(() => {
                        copyBtn.innerHTML = '<span>Tersalin! ✓</span>';
                        setTimeout(() => {
                            copyBtn.innerHTML = `
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span>Salin</span>
                            `;
                        }, 2000);
                    });
                });
            }

            // Setup copy action for individual code blocks
            messageWrapper.querySelectorAll('.chatbot-code-copy').forEach(btn => {
                btn.addEventListener('click', () => {
                    const code = btn.closest('.my-2.5').querySelector('code').textContent;
                    navigator.clipboard.writeText(code).then(() => {
                        btn.textContent = 'Tersalin!';
                        setTimeout(() => btn.textContent = 'Salin', 2000);
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

    // Send Message via AJAX Fetch
    async function sendMessage(messageText) {
        lastSentMessage = messageText;
        isSubmitting = true;
        submitBtn.disabled = true;
        input.value = '';
        clearInputBtn.classList.add('hidden');

        // Render user message
        appendMessage('user', messageText);

        // State 2: Show loading skeleton
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
