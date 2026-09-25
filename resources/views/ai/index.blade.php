@extends('layouts.app')

@section('title', 'Yuna AI // Linux & Portofolio Workstation - I Made Yuda Pramana')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-4 sm:py-6" id="pramana-console-root" data-csrf="{{ csrf_token() }}" data-endpoint="{{ route('chatbot.message') }}">
    
    <!-- Top Engineering Console Header (AetherCraft Precision Ledger) -->
    <div class="mb-4 sm:mb-6 rounded-2xl sm:rounded-3xl bg-[#0C382E] text-white p-4 sm:p-6 border border-[#144D3F] shadow-xl shadow-[#0C382E]/20 relative overflow-hidden">
        <!-- Ambient Circuit Glow -->
        <div class="absolute -top-12 -right-12 w-64 h-64 rounded-full bg-emerald-500/10 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Brand & Identity -->
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-[#07241E] p-1.5 sm:p-2 border border-emerald-400/40 shadow-inner shrink-0">
                    <img src="{{ asset('images/yuna-logo.svg') }}" alt="Yuna AI" class="w-full h-full object-contain filter drop-shadow">
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h1 class="text-lg sm:text-2xl font-extrabold tracking-tight text-white font-sans">Yuna AI</h1>
                        <span class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-emerald-500/25 text-emerald-300 border border-emerald-500/40 font-bold">Interactive Assistant</span>
                        <span class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30">Linux &amp; Portofolio</span>
                    </div>
                    <p class="text-xs text-emerald-100/80 font-mono mt-0.5">
                        Interactive AI Assistant &bull; Portofolio I Made Yuda Pramana (SMKN 1 Denpasar)
                    </p>
                </div>
            </div>

            <!-- Header Quick Telemetry & Actions -->
            <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-xs font-mono">
                <div class="px-3 py-1.5 rounded-xl bg-white/10 border border-white/10 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-emerald-200">SOCKET: ONLINE</span>
                </div>
                <div class="hidden sm:flex px-3 py-1.5 rounded-xl bg-white/10 border border-white/10 items-center gap-2 text-stone-200">
                    <span>HOST: Debian 13 LEMP</span>
                </div>
                <a href="{{ route('home') }}" class="px-3.5 py-1.5 rounded-xl bg-white/15 hover:bg-white/25 border border-white/20 text-white font-bold transition-all flex items-center gap-1.5 cursor-pointer">
                    <span>&larr; Portofolio</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Two-Column Engineering Console Workstation -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6 items-start">
        
        <!-- Left Sidebar: Linux Telemetry & Quick Cheat Sheets (4 Cols on Desktop) -->
        <aside class="lg:col-span-4 space-y-4 sm:space-y-5">
            
            <!-- Server Specs & Telemetry Card -->
            <div class="rounded-2xl sm:rounded-3xl bg-white border border-stone-200/90 p-4 sm:p-5 shadow-xs space-y-3 font-sans">
                <div class="flex items-center justify-between border-b border-stone-100 pb-2.5">
                    <div class="flex items-center gap-2">
                        <span class="text-emerald-700 font-bold text-xs font-mono">01 //</span>
                        <h2 class="text-xs sm:text-sm font-extrabold text-[#0C382E] uppercase tracking-wide">Spesifikasi Server</h2>
                    </div>
                    <span class="text-[10px] font-mono text-emerald-800 bg-emerald-100 px-2 py-0.5 rounded-full font-bold">Baremetal</span>
                </div>

                <div class="space-y-2 text-xs font-mono">
                    <div class="flex justify-between py-1 border-b border-stone-100">
                        <span class="text-stone-500">Hardware CPU:</span>
                        <span class="font-bold text-stone-800">AMD Ryzen 5 6600H</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-stone-100">
                        <span class="text-stone-500">Memory RAM:</span>
                        <span class="font-bold text-stone-800">16GB DDR5 High-Speed</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-stone-100">
                        <span class="text-stone-500">Operating System:</span>
                        <span class="font-bold text-stone-800">Debian 13 (Trixie)</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-stone-100">
                        <span class="text-stone-500">Web Server:</span>
                        <span class="font-bold text-stone-800">Nginx 1.26 + Microcache</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-stone-100">
                        <span class="text-stone-500">PHP Runtime:</span>
                        <span class="font-bold text-stone-800">PHP 8.4-FPM OPcache</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-stone-500">Database Engine:</span>
                        <span class="font-bold text-stone-800">MariaDB 10.11 InnoDB</span>
                    </div>
                </div>
            </div>

            <!-- Linux CLI Cheat Sheet & Knowledge Cards -->
            <div class="rounded-2xl sm:rounded-3xl bg-white border border-stone-200/90 p-4 sm:p-5 shadow-xs space-y-3 font-sans">
                <div class="flex items-center justify-between border-b border-stone-100 pb-2.5">
                    <div class="flex items-center gap-2">
                        <span class="text-emerald-700 font-bold text-xs font-mono">02 //</span>
                        <h2 class="text-xs sm:text-sm font-extrabold text-[#0C382E] uppercase tracking-wide">Linux Cheat Sheet</h2>
                    </div>
                    <span class="text-[10px] font-mono text-stone-500">Klik untuk salin</span>
                </div>

                <div class="space-y-2 text-xs">
                    <!-- Cheat 1 -->
                    <div class="p-2.5 rounded-xl bg-stone-50 border border-stone-200 group hover:border-[#0C382E] transition-colors cursor-pointer console-snippet" data-copy="chmod 755 /var/www && chmod 644 /var/www/index.php">
                        <div class="text-[11px] font-bold text-[#0C382E] flex justify-between">
                            <span>Hak Akses Web (chmod)</span>
                            <span class="text-stone-400 font-mono text-[10px] group-hover:text-[#0C382E]">Salin &boxbox;</span>
                        </div>
                        <code class="text-[11px] font-mono text-stone-700 block mt-1">chmod 755 dir && chmod 644 file</code>
                    </div>

                    <!-- Cheat 2 -->
                    <div class="p-2.5 rounded-xl bg-stone-50 border border-stone-200 group hover:border-[#0C382E] transition-colors cursor-pointer console-snippet" data-copy="systemctl status nginx && systemctl restart php8.4-fpm">
                        <div class="text-[11px] font-bold text-[#0C382E] flex justify-between">
                            <span>Manajemen Service (systemctl)</span>
                            <span class="text-stone-400 font-mono text-[10px] group-hover:text-[#0C382E]">Salin &boxbox;</span>
                        </div>
                        <code class="text-[11px] font-mono text-stone-700 block mt-1">systemctl status nginx</code>
                    </div>

                    <!-- Cheat 3 -->
                    <div class="p-2.5 rounded-xl bg-stone-50 border border-stone-200 group hover:border-[#0C382E] transition-colors cursor-pointer console-snippet" data-copy="ss -tulpn | grep LISTEN">
                        <div class="text-[11px] font-bold text-[#0C382E] flex justify-between">
                            <span>Inspeksi Port Jaringan (ss)</span>
                            <span class="text-stone-400 font-mono text-[10px] group-hover:text-[#0C382E]">Salin &boxbox;</span>
                        </div>
                        <code class="text-[11px] font-mono text-stone-700 block mt-1">ss -tulpn | grep LISTEN</code>
                    </div>

                    <!-- Cheat 4 -->
                    <div class="p-2.5 rounded-xl bg-stone-50 border border-stone-200 group hover:border-[#0C382E] transition-colors cursor-pointer console-snippet" data-copy="journalctl -u nginx -f">
                        <div class="text-[11px] font-bold text-[#0C382E] flex justify-between">
                            <span>Live Logging (journalctl)</span>
                            <span class="text-stone-400 font-mono text-[10px] group-hover:text-[#0C382E]">Salin &boxbox;</span>
                        </div>
                        <code class="text-[11px] font-mono text-stone-700 block mt-1">journalctl -u nginx -f</code>
                    </div>
                </div>
            </div>

            <!-- Security Hardening Badge -->
            <div class="rounded-2xl sm:rounded-3xl bg-[#07241E] text-[#F8F5EE] p-4.5 border border-[#144D3F] shadow-sm space-y-2 font-mono text-xs">
                <div class="flex items-center gap-2 text-emerald-400 font-bold">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>CYBER DEFENSE: ACTIVE</span>
                </div>
                <p class="text-[11px] text-emerald-200/80 leading-relaxed">
                    Kebal injeksi SQL (PDO Parameter Binding) &bull; Kebal JavaScript Injection (CSP &amp; Input Sanitizer) &bull; Proteksi Anti-Prompt Injection.
                </p>
            </div>

        </aside>

        <!-- Right / Center: Dedicated Full-Height Conversational Stream (8 Cols on Desktop) -->
        <main class="lg:col-span-8 flex flex-col h-[750px] max-h-[82vh] rounded-2xl sm:rounded-3xl bg-white border border-stone-200/90 shadow-lg overflow-hidden">
            
            <!-- Console Sub-Header -->
            <div class="px-5 py-3.5 bg-stone-50 border-b border-stone-200/90 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-2.5">
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></div>
                    <span class="text-xs font-mono font-bold text-stone-700">SESI KONSOL TERMINAL // LIVE</span>
                </div>

                <div class="flex items-center gap-2">
                    <button id="console-reset-btn" type="button" class="text-xs font-mono text-stone-500 hover:text-stone-800 transition-colors flex items-center gap-1 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span>Reset Sesi</span>
                    </button>
                    <span class="text-stone-300">|</span>
                    <button id="console-export-btn" type="button" class="text-xs font-mono text-stone-500 hover:text-[#0C382E] transition-colors flex items-center gap-1 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Simpan Log</span>
                    </button>
                </div>
            </div>

            <!-- Scrollable Message Stream -->
            <div id="console-messages" class="flex-1 p-4 sm:p-6 overflow-y-auto space-y-5 text-xs sm:text-sm leading-relaxed text-[#1C1917] scroll-smooth">
                
                <!-- State 1: Empty State Greeting -->
                <div id="console-empty-state" class="space-y-5 py-2">
                    <div class="p-5 sm:p-6 rounded-2xl bg-[#FAF8F5] border border-stone-200/90 shadow-2xs space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-[#0C382E] p-1.5 flex items-center justify-center shrink-0 border border-emerald-500/30">
                                <img src="{{ asset('images/yuna-logo.svg') }}" alt="Yuna" class="w-full h-full object-contain">
                            </div>
                            <div>
                                <h3 class="font-extrabold text-[#0C382E] text-sm sm:text-base">Halo, Selamat Datang! Aku Yuna</h3>
                                <p class="text-xs text-stone-500 font-mono">Interactive Linux &amp; Portofolio AI Assistant</p>
                            </div>
                        </div>

                        <p class="text-xs text-stone-700 leading-relaxed font-sans">
                            Hai! Senang bertemu dengan Anda. Aku adalah <strong>Yuna</strong>, asisten cerdas untuk website portofolio <strong>I Made Yuda Pramana</strong>. Anda bisa mengobrol atau bertanya seputar <strong>Sistem Operasi Linux &amp; Perintah Terminal</strong>, serta seluk-beluk <strong>Website Portofolio Ini</strong> (arsitektur server LEMP, framework Laravel 11, Tailwind v4, sertifikasi Cisco, dan aplikasi IT Toolbox). Silakan sapa atau tanyakan hal yang ingin Anda ketahui.
                        </p>
                    </div>

                    <!-- Quick Prompt Pills -->
                    <div>
                        <div class="text-[11px] font-mono uppercase tracking-wider text-stone-500 font-semibold mb-2.5 px-1">Pertanyaan Cepat Rekomendasi:</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            <button type="button" class="console-quick-prompt text-left p-3 rounded-xl bg-stone-50 hover:bg-white hover:border-[#0C382E] border border-stone-200 text-[#0C382E] text-xs font-semibold transition-all flex items-center justify-between group cursor-pointer shadow-2xs">
                                <span>Hai Yuna, kamu bisa bantu apa saja di sini?</span>
                                <span class="text-stone-400 group-hover:text-[#0C382E] group-hover:translate-x-0.5 transition-all">&rarr;</span>
                            </button>
                            <button type="button" class="console-quick-prompt text-left p-3 rounded-xl bg-stone-50 hover:bg-white hover:border-[#0C382E] border border-stone-200 text-[#0C382E] text-xs font-semibold transition-all flex items-center justify-between group cursor-pointer shadow-2xs">
                                <span>Apa teknologi yang digunakan untuk membangun web ini?</span>
                                <span class="text-stone-400 group-hover:text-[#0C382E] group-hover:translate-x-0.5 transition-all">&rarr;</span>
                            </button>
                            <button type="button" class="console-quick-prompt text-left p-3 rounded-xl bg-stone-50 hover:bg-white hover:border-[#0C382E] border border-stone-200 text-[#0C382E] text-xs font-semibold transition-all flex items-center justify-between group cursor-pointer shadow-2xs">
                                <span>Bagaimana cara kerja perintah chmod dan chown di Linux?</span>
                                <span class="text-stone-400 group-hover:text-[#0C382E] group-hover:translate-x-0.5 transition-all">&rarr;</span>
                            </button>
                            <button type="button" class="console-quick-prompt text-left p-3 rounded-xl bg-stone-50 hover:bg-white hover:border-[#0C382E] border border-stone-200 text-[#0C382E] text-xs font-semibold transition-all flex items-center justify-between group cursor-pointer shadow-2xs">
                                <span>Jelaskan fitur aplikasi IT Toolbox buatan Yuda</span>
                                <span class="text-stone-400 group-hover:text-[#0C382E] group-hover:translate-x-0.5 transition-all">&rarr;</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Chat Container -->
                <div id="console-conversation-list" class="space-y-5"></div>

                <!-- State 2: Loading Skeleton -->
                <div id="console-loading" class="hidden flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-[#0C382E] p-1 flex items-center justify-center shrink-0 border border-emerald-500/30">
                        <img src="{{ asset('images/yuna-logo.svg') }}" alt="Yuna" class="w-full h-full object-contain">
                    </div>
                    <div class="p-4 rounded-2xl rounded-tl-sm bg-white border border-stone-200 shadow-xs flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 animate-bounce"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 animate-bounce [animation-delay:0.15s]"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 animate-bounce [animation-delay:0.3s]"></span>
                        <span class="text-xs font-mono text-stone-600 ml-1">Yuna sedang mengetik respon...</span>
                    </div>
                </div>

                <!-- State 3: Error Boundary + Retry -->
                <div id="console-error-boundary" class="hidden p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-2">
                    <div class="flex items-center gap-2 font-bold text-rose-700">
                        <svg class="w-4 h-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Gagal Mengambil Respon</span>
                    </div>
                    <p id="console-error-message" class="text-xs text-rose-700/90">
                        Terjadi gangguan koneksi jaringan.
                    </p>
                    <button id="console-retry-btn" type="button" class="px-3.5 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold transition-colors cursor-pointer inline-flex items-center gap-1.5">
                        <span>Coba Lagi</span>
                        <span>&circlearrowright;</span>
                    </button>
                </div>

            </div>

            <!-- Sticky Console Input Bar -->
            <div class="p-3.5 sm:p-4 bg-white border-t border-stone-200/90 shrink-0">
                <form id="console-form" class="flex items-center gap-2 sm:gap-3" autocomplete="off">
                    <div class="relative flex-1">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-emerald-700 font-mono font-bold text-xs select-none">
                            $&gt;
                        </div>
                        <input id="console-input" 
                               type="text" 
                               maxlength="600"
                               placeholder="Tanyakan perintah Linux, teknologi web ini, konfigurasi Nginx, atau proyek Yuda..." 
                               class="w-full pl-9 pr-8 py-3 rounded-xl sm:rounded-2xl bg-stone-100 border border-stone-200 text-xs sm:text-sm text-[#1C1917] placeholder:text-stone-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0C382E] transition-all font-mono"
                               required>
                        <button id="console-clear-input" type="button" class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-600 p-1" aria-label="Bersihkan input">
                            &times;
                        </button>
                    </div>

                    <button id="console-submit-btn" 
                            type="submit" 
                            class="px-4.5 sm:px-6 py-3 rounded-xl sm:rounded-2xl bg-[#0C382E] hover:bg-[#144D3F] active:scale-95 text-white font-bold transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0C382E] disabled:opacity-50 disabled:pointer-events-none cursor-pointer shrink-0 shadow-md shadow-[#0C382E]/20 flex items-center gap-2"
                            aria-label="Kirim Pertanyaan">
                        <span class="hidden sm:inline text-xs font-mono">KIRIM</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </form>
                <div class="mt-2 flex items-center justify-between text-[11px] text-stone-500 font-mono px-1">
                    <span>Tekan <kbd class="px-1.5 py-0.5 rounded bg-stone-200 text-stone-700">Enter ↵</kbd> untuk mengeksekusi</span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>Isolated Guardrail Active</span>
                    </span>
                </div>
            </div>

        </main>

    </div>

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
    const snippets = document.querySelectorAll('.console-snippet');

    const csrfToken = root.dataset.csrf;
    const endpoint = root.dataset.endpoint;

    let lastSentMessage = '';
    let isSubmitting = false;
    let chatLog = [];

    // Copy Cheat Sheet Snippets to Input
    snippets.forEach(item => {
        item.addEventListener('click', () => {
            const text = item.dataset.copy;
            input.value = text;
            input.focus();
            if (clearInputBtn) clearInputBtn.classList.remove('hidden');
        });
    });

    // Quick Prompts
    quickPrompts.forEach(btn => {
        btn.addEventListener('click', () => {
            const promptText = btn.querySelector('span').textContent.replace(/^[^\w\s]+/, '').trim();
            input.value = promptText;
            sendMessage(promptText);
        });
    });

    // Clear input
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

    // Reset Chat Session
    resetBtn.addEventListener('click', () => {
        conversationList.innerHTML = '';
        emptyState.classList.remove('hidden');
        errorBoundary.classList.add('hidden');
        loadingState.classList.add('hidden');
        chatLog = [];
        input.value = '';
        input.focus();
    });

    // Export Chat Log (.txt)
    exportBtn.addEventListener('click', () => {
        if (!chatLog.length) {
            alert('Belum ada percakapan untuk diekspor.');
            return;
        }
        let content = "=== YUNA AI CONSOLE SESSION LOG ===\n";
        content += "Waktu: " + new Date().toLocaleString() + "\n";
        content += "Host: Debian 13 (Trixie) LEMP Stack // I Made Yuda Pramana\n\n";
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

    // Retry
    retryBtn.addEventListener('click', () => {
        if (lastSentMessage) {
            sendMessage(lastSentMessage);
        }
    });

    // Submit form
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
            return '<div class="my-3 rounded-xl bg-stone-900 border border-stone-800 overflow-hidden shadow-sm font-mono text-xs">' +
                   '<div class="px-3.5 py-2 bg-stone-950 border-b border-stone-800 text-[11px] text-stone-400 font-semibold flex items-center justify-between">' +
                   '<span>' + displayLang + '</span>' +
                   '<button type="button" class="console-code-copy hover:text-emerald-400 transition-colors cursor-pointer">Salin Kode &boxbox;</button>' +
                   '</div>' +
                   '<pre class="p-3.5 text-emerald-300 overflow-x-auto leading-relaxed"><code>' + code.trim() + '</code></pre>' +
                   '</div>';
        });

        // Inline code: `...`
        html = html.replace(/`([^`]+)`/g, '<code class="px-1.5 py-0.5 rounded bg-stone-200 font-mono text-xs text-[#0C382E] font-semibold">$1</code>');

        // Bold: **...**
        html = html.replace(/\*\*([^*]+)\*\*/g, '<strong class="font-bold text-[#1C1917]">$1</strong>');

        // Italic: _..._
        html = html.replace(/_([^_]+)_/g, '<em class="italic text-stone-600">$1</em>');

        // Links: [text](url) - strictly whitelisted
        html = html.replace(/\[([^\]]+)\]\(([^)]+)\)/g, function(match, linkText, url) {
            const cleanUrl = url.trim();
            if (/^(https?:\/\/|mailto:)/i.test(cleanUrl)) {
                const safeUrl = cleanUrl.replace(/["'<>]/g, '');
                return '<a href="' + safeUrl + '" target="_blank" rel="noopener noreferrer" class="text-emerald-700 underline font-semibold hover:text-[#0C382E]">' + linkText + '</a>';
            }
            return linkText;
        });

        // Lists
        html = html.replace(/^\s*[-*]\s+(.+)$/gm, '<li class="ml-5 list-disc text-stone-700 my-1">$1</li>');
        html = html.replace(/^\s*(\d+)\.\s+(.+)$/gm, '<li class="ml-5 list-decimal text-stone-700 my-1">$2</li>');

        // Paragraph breaks
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
                <div class="max-w-[85%] sm:max-w-[80%] p-4 rounded-2xl rounded-tr-sm bg-[#0C382E] text-white shadow-sm text-xs sm:text-sm leading-relaxed break-words font-sans">
                    ${escapeHtml(text)}
                </div>
            `;
        } else {
            const formattedContent = parseMarkdown(text);
            const sourceBadge = source === 'guardrail_rejection' 
                ? '<span class="text-[10px] font-mono px-2 py-0.5 rounded bg-amber-100 text-amber-800 border border-amber-300">Guardrail Scope</span>'
                : (source === 'security_guardrail'
                    ? '<span class="text-[10px] font-mono px-2 py-0.5 rounded bg-rose-100 text-rose-800 border border-rose-300">Security Guardrail</span>'
                    : '<span class="text-[10px] font-mono px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 border border-emerald-300">Verified AI</span>');

            messageWrapper.innerHTML = `
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-2xl bg-[#0C382E] p-1.5 flex items-center justify-center shrink-0 border border-emerald-500/30 shadow-sm mt-0.5">
                    <img src="/images/yuna-logo.svg" alt="Yuna" class="w-full h-full object-contain">
                </div>
                <div class="max-w-[88%] sm:max-w-[85%] p-4 sm:p-5 rounded-2xl rounded-tl-sm bg-[#FAF8F5] border border-stone-200 shadow-xs text-[#1C1917] space-y-3 font-sans">
                    <div class="flex items-center justify-between gap-3 border-b border-stone-200/80 pb-2">
                        <div class="flex items-center gap-2">
                            <span class="text-xs sm:text-sm font-bold text-[#0C382E]">Yuna</span>
                            ${sourceBadge}
                        </div>
                        <span class="font-mono text-[11px] text-stone-400">${timeStr}</span>
                    </div>
                    <div class="console-response text-xs sm:text-sm leading-relaxed space-y-1.5">
                        ${formattedContent}
                    </div>
                    <div class="pt-2 flex items-center justify-between border-t border-stone-200/80 text-[11px] text-stone-400 font-mono">
                        <span>Yuna AI Assistant</span>
                        <button type="button" class="console-copy-btn hover:text-[#0C382E] transition-colors p-1 flex items-center gap-1 cursor-pointer font-medium" title="Salin respon">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <span>Salin Respon</span>
                        </button>
                    </div>
                </div>
            `;

            // Setup copy action for entire response
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

            // Setup copy action for individual code blocks
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
