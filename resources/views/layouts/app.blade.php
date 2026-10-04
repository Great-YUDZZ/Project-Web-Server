<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="theme-color" content="#0a0a0a">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'I Made Yuda Pramana | Network Systems & Infrastructure')</title>
    <meta name="description" content="Portofolio Teknik Komputer dan Jaringan (TKJ). Arsitektur topologi jaringan berkecepatan tinggi, administrasi server Linux, dan virtualisasi.">

    <!-- Favicon & Icons -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-[#0a0a0a] text-[#f5f5f5] antialiased selection:bg-white/20 selection:text-white relative overflow-x-hidden font-body">

    <!-- Ambient Subtle Noise & Gradient Glow -->
    <div class="fixed inset-0 bg-halftone opacity-10 pointer-events-none z-0"></div>
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-[800px] h-[350px] bg-gradient-to-b from-white/[0.04] to-transparent blur-3xl pointer-events-none z-0"></div>

    <!-- Floating Pill Navigation (Glassmorphism HUD) -->
    <div class="fixed top-3 sm:top-6 left-0 right-0 z-50 flex justify-center px-3 sm:px-4 pointer-events-none">
        <header class="pointer-events-auto w-full max-w-6xl xl:max-w-7xl rounded-full glass-hud px-4 sm:px-7 py-2 sm:py-2.5 flex items-center justify-between">
            <!-- Brand Identity Cluster -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white rounded-xl mr-2 lg:mr-3 xl:mr-8 shrink-0" aria-label="I Made Yuda Pramana Home">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white/5 border border-white/15 flex items-center justify-center shadow-md group-hover:scale-105 group-hover:border-white/50 transition-all">
                    <span class="font-display italic text-sm text-[#f5f5f5]">YP</span>
                </div>
                <div class="flex flex-col">
                    <div class="font-bold text-[#f5f5f5] text-xs sm:text-sm lg:text-[14px] xl:text-[15px] tracking-tight group-hover:text-white transition-colors flex items-center gap-1.5 whitespace-nowrap">
                        <span>I Made Yuda Pramana</span>
                    </div>
                    <div class="text-[11px] text-[#878787] font-mono hidden sm:flex items-center gap-1 font-normal whitespace-nowrap">
                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                        <span>Teknik Komputer &amp; Jaringan</span>
                    </div>
                </div>
            </a>

            <!-- Desktop Pill Navigation -->
            <nav class="hidden lg:flex items-center gap-1 xl:gap-1.5 px-2.5 xl:px-3 py-1.5 rounded-full glass-nav-subcontainer text-[11px] xl:text-xs shrink-0">
                <a href="{{ route('home') }}" class="px-2.5 xl:px-3 py-1.5 rounded-full {{ request()->routeIs('home') ? 'text-white font-semibold bg-white/15 shadow-sm' : 'text-[#878787] hover:text-[#f5f5f5] hover:bg-white/10' }} focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white transition-colors">
                    Beranda
                </a>
                <a href="{{ route('home') }}#works" class="px-2.5 xl:px-3 py-1.5 rounded-full text-[#878787] hover:text-[#f5f5f5] hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white transition-colors">
                    Karya
                </a>
                <a href="{{ route('home') }}#skills" class="px-2.5 xl:px-3 py-1.5 rounded-full text-[#878787] hover:text-[#f5f5f5] hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white transition-colors">
                    Keahlian
                </a>
                <a href="{{ route('projects.index') }}" class="px-2.5 xl:px-3 py-1.5 rounded-full {{ request()->routeIs('projects.*') ? 'text-white font-semibold bg-white/15 shadow-sm' : 'text-[#878787] hover:text-[#f5f5f5] hover:bg-white/10' }} focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white transition-colors">
                    Katalog Lab
                </a>
                <a href="{{ route('ai.index') }}" class="px-2.5 xl:px-3 py-1.5 rounded-full {{ request()->routeIs('ai.*') ? 'text-white font-semibold bg-white/15 shadow-sm' : 'text-[#878787] hover:text-[#f5f5f5] hover:bg-white/10' }} flex items-center gap-1.5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white transition-colors">
                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                    <span class="font-semibold text-[#f5f5f5]">Yuna AI</span>
                </a>
                <a href="{{ route('home') }}#contact" class="px-2.5 xl:px-3 py-1.5 rounded-full text-[#878787] hover:text-[#f5f5f5] hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white transition-colors">
                    Kontak
                </a>
            </nav>

            <!-- Action Cluster -->
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <a href="{{ route('home') }}#contact" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white text-black hover:bg-neutral-200 text-xs font-semibold shadow-md transition-all hover:scale-[1.02] active:scale-[0.98]">
                    <span>Hubungi Saya</span>
                    <span class="text-xs font-bold">&rarr;</span>
                </a>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" type="button" class="lg:hidden w-10 h-10 flex items-center justify-center text-[#f5f5f5] hover:text-white bg-white/5 hover:bg-white/10 border border-white/15 rounded-full shadow-xs transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white cursor-pointer" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="mobile-menu">
                    <svg id="menu-open-icon" class="w-5 h-5 block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="menu-close-icon" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </header>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div id="mobile-menu" class="hidden fixed top-18 sm:top-20 inset-x-3 sm:inset-x-4 z-40 lg:hidden rounded-3xl glass-hud p-4 sm:p-5 space-y-1.5 text-sm font-semibold shadow-2xl text-[#f5f5f5] animate-scale-in max-h-[calc(100dvh-5.5rem)] overflow-y-auto" role="region" aria-label="Mobile navigation menu">
        <a href="{{ route('home') }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-[#f5f5f5] hover:bg-white/10 rounded-xl transition-colors font-semibold">Beranda</a>
        <a href="{{ route('home') }}#works" class="min-h-[44px] flex items-center px-4 py-2.5 text-[#a3a3a3] hover:text-[#f5f5f5] hover:bg-white/10 rounded-xl transition-colors font-semibold">Karya Pilihan</a>
        <a href="{{ route('home') }}#skills" class="min-h-[44px] flex items-center px-4 py-2.5 text-[#a3a3a3] hover:text-[#f5f5f5] hover:bg-white/10 rounded-xl transition-colors font-semibold">Matriks Keahlian</a>
        <a href="{{ route('projects.index') }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-[#a3a3a3] hover:text-[#f5f5f5] hover:bg-white/10 rounded-xl transition-colors font-semibold">Katalog Lengkap</a>
        <a href="{{ route('ai.index') }}" class="min-h-[44px] flex items-center justify-between px-4 py-2.5 text-white bg-white/10 hover:bg-white/15 rounded-xl transition-colors font-bold">
            <span class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-white"></span>
                <span>Yuna AI Console</span>
            </span>
            <span class="text-xs font-mono font-bold text-black bg-white px-2 py-0.5 rounded-full">AI</span>
        </a>
        <a href="{{ route('home') }}#contact" class="min-h-[44px] flex items-center px-4 py-2.5 text-[#a3a3a3] hover:text-[#f5f5f5] hover:bg-white/10 rounded-xl transition-colors font-semibold">Kontak</a>
        <div class="pt-2">
            <a href="{{ route('home') }}#contact" class="w-full min-h-[44px] flex items-center justify-center px-4 py-3 text-center rounded-full font-bold bg-white text-black hover:bg-neutral-200 transition-colors">Hubungi Saya &rarr;</a>
        </div>
    </div>

    <!-- Main Page Content -->
    <main class="flex-1 relative z-10 pt-20 sm:pt-28">
        @yield('content')
    </main>

    <!-- Floating Back-To-Top Button -->
    <button id="back-to-top" type="button" class="fixed bottom-22 right-6 z-40 p-3.5 rounded-full bg-[#141414] text-[#f5f5f5] border border-[#2a2a2a] hover:border-white hover:bg-[#202020] shadow-xl transition-all duration-300 opacity-0 pointer-events-none translate-y-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white cursor-pointer" aria-label="Scroll to top">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    @if(!request()->routeIs('ai.*'))
    <!-- AI Chatbot Assistant Widget (TKJ Knowledge Core) -->
    <x-chatbot-widget />
    @endif

    <!-- Footer: Clean Monochrome Dark (#0a0a0a) -->
    <footer class="pb-10 sm:pb-14 pt-12 sm:pt-16 text-sm relative z-10 bg-[#0a0a0a] border-t border-[#1f1f1f] text-[#878787]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-end">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="font-display italic text-xl text-[#f5f5f5]">I Made Yuda Pramana</span>
                        <span class="text-[#4D4D4D] font-mono">/</span>
                        <span class="font-mono text-xs text-[#a3a3a3]">SMKN 1 Denpasar</span>
                    </div>
                    <p class="text-[#878787] max-w-md leading-relaxed text-xs">
                        Arsitektur topologi jaringan berkecepatan tinggi, administrasi server Linux Debian, protokol routing dinamis, dan utilitas developer berkinerja tinggi.
                    </p>
                    <div class="mt-4 flex flex-wrap items-center gap-4 text-xs font-mono text-[#a3a3a3]">
                        <a href="mailto:yuda2010f@gmail.com" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>yuda2010f@gmail.com</span>
                        </a>
                        <a href="https://wa.me/6285182691268" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>085182691268</span>
                        </a>
                        <a href="https://github.com/Great-YUDZZ" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                            </svg>
                            <span>Great-YUDZZ</span>
                        </a>
                    </div>
                </div>
                
                <div class="flex flex-wrap md:justify-end gap-6 text-xs font-medium text-[#878787]">
                    <a href="{{ route('home') }}" class="py-1 hover:text-white transition-colors">Beranda</a>
                    <a href="{{ route('home') }}#works" class="py-1 hover:text-white transition-colors">Karya</a>
                    <a href="{{ route('home') }}#skills" class="py-1 hover:text-white transition-colors">Keahlian</a>
                    <a href="{{ route('projects.index') }}" class="py-1 hover:text-white transition-colors">Katalog Lab</a>
                    <a href="{{ route('ai.index') }}" class="py-1 text-white font-bold hover:text-neutral-300 transition-colors flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                        <span>Yuna AI</span>
                    </a>
                    <a href="{{ route('archive.classic') }}" class="py-1 hover:text-white transition-colors">Arsip Klasik</a>
                    <a href="{{ route('home') }}#contact" class="py-1 hover:text-white transition-colors">Kontak</a>
                </div>
            </div>

            <div class="max-w-7xl mx-auto mt-10 pt-6 border-t border-[#1f1f1f] flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-[#525252] font-mono">
                <div>&copy; {{ date('Y') }} I Made Yuda Pramana. Direkayasa dengan mechanical sympathy di atas Debian GNU/Linux.</div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-white shadow-[0_0_8px_rgba(255,255,255,0.4)]"></span>
                    <span class="text-[#a3a3a3]">STATUS SISTEM ONLINE</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
