<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="theme-color" content="#050508">
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
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-[#050508] text-zinc-300 antialiased selection:bg-rose-600/30 selection:text-rose-100 relative overflow-x-hidden">

    <!-- Interactive Background Canvas (Cyber Mesh & Embers) -->
    <canvas id="interactive-bg" class="fixed inset-0 pointer-events-none z-0" aria-hidden="true"></canvas>

    <!-- Top Ambient Atmosphere Glow (Digital Kensei Cyber Crimson) -->
    <div class="pointer-events-none fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[580px] bg-kensei-glow opacity-80 z-0"></div>

    <!-- Ambient Chromatic Refraction Nodes for Glassmorphism Depth -->
    <div class="pointer-events-none fixed top-24 left-1/4 w-96 h-96 rounded-full bg-rose-600/[0.12] blur-[120px] z-0"></div>
    <div class="pointer-events-none fixed top-[45%] right-8 w-[450px] h-[450px] rounded-full bg-indigo-600/[0.10] blur-[140px] z-0"></div>
    <div class="pointer-events-none fixed bottom-32 left-8 w-[400px] h-[400px] rounded-full bg-cyan-600/[0.08] blur-[130px] z-0"></div>

    <!-- Floating Pill Navigation (ekizr.com signature concept) -->
    <div class="fixed top-3 sm:top-6 left-0 right-0 z-50 flex justify-center px-3 sm:px-4 pointer-events-none">
        <header class="pointer-events-auto w-full max-w-5xl rounded-full glass-panel px-3.5 sm:px-6 py-2 sm:py-2.5 flex items-center justify-between transition-all duration-300">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500 rounded-full shrink-0">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-7 h-7 sm:w-8 sm:h-8 shrink-0 object-contain group-hover:scale-105 transition-transform duration-300">
                <div class="flex flex-col">
                    <div class="font-bold text-white text-xs sm:text-base tracking-tight group-hover:text-rose-400 transition-colors flex items-center gap-1.5">
                        <span class="truncate max-w-[150px] xs:max-w-[200px] sm:max-w-none">I Made Yuda Pramana</span>
                    </div>
                    <div class="text-[10px] text-zinc-500 font-mono hidden sm:flex items-center gap-1">
                        <span>Teknik Komputer &amp; Jaringan</span>
                    </div>
                </div>
            </a>

            <!-- Desktop Pill Navigation -->
            <nav class="hidden md:flex items-center gap-1 px-3 py-1 rounded-full bg-white/[0.03] border border-white/[0.08] backdrop-blur-md text-xs font-medium shadow-[inset_0_1px_0_rgba(255,255,255,0.08)]">
                <a href="{{ request()->routeIs('home') ? '#home' : route('home').'#home' }}" data-nav-section="home" class="px-3.5 py-1.5 rounded-full text-zinc-400 hover:text-white hover:bg-white/[0.06] transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">
                    Home
                </a>
                <a href="{{ request()->routeIs('home') ? '#about' : route('home').'#about' }}" data-nav-section="about" class="px-3.5 py-1.5 rounded-full text-zinc-400 hover:text-white hover:bg-white/[0.06] transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">
                    About
                </a>
                <a href="{{ request()->routeIs('home') ? '#certifications' : route('home').'#certifications' }}" data-nav-section="certifications" class="px-3.5 py-1.5 rounded-full text-zinc-400 hover:text-white hover:bg-white/[0.06] transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">
                    Sertifikasi
                </a>
                <a href="{{ request()->routeIs('home') ? '#labs' : route('home').'#labs' }}" data-nav-section="labs" class="px-3.5 py-1.5 rounded-full text-zinc-400 hover:text-white hover:bg-white/[0.06] transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">
                    Showcase Lab
                </a>
                <a href="{{ request()->routeIs('home') ? '#skills' : route('home').'#skills' }}" data-nav-section="skills" class="px-3.5 py-1.5 rounded-full text-zinc-400 hover:text-white hover:bg-white/[0.06] transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">
                    Skill Matrix
                </a>
                <a href="{{ request()->routeIs('home') ? '#architecture' : route('home').'#architecture' }}" data-nav-section="architecture" class="px-3.5 py-1.5 rounded-full text-zinc-400 hover:text-white hover:bg-white/[0.06] transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">
                    Arsitektur
                </a>
                <a href="{{ route('projects.index') }}" class="px-3.5 py-1.5 rounded-full {{ request()->routeIs('projects.*') ? 'text-white bg-white/[0.08]' : 'text-zinc-400 hover:text-white hover:bg-white/[0.06]' }} transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">
                    Katalog
                </a>
                <a href="{{ request()->routeIs('home') ? '#contact' : route('home').'#contact' }}" data-nav-section="contact" class="px-3.5 py-1.5 rounded-full text-zinc-400 hover:text-white hover:bg-white/[0.06] transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">
                    Contact
                </a>
            </nav>

            <!-- Action Cluster -->
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ request()->routeIs('home') ? '#contact' : route('home').'#contact' }}" class="hidden sm:inline-flex items-center gap-2 px-4 sm:px-5 py-2 text-xs font-semibold text-white bg-gradient-to-r from-red-600 via-rose-600 to-red-500 hover:from-red-500 hover:to-rose-500 rounded-full shadow-md shadow-rose-600/25 hover:shadow-rose-600/40 transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500 active:scale-95">
                    <span>Hubungi Saya</span>
                    <span class="w-4 h-4 rounded-full bg-black/20 flex items-center justify-center text-[10px]">&rarr;</span>
                </a>

                <!-- Mobile Menu Button (Accessible 44px Tap Target) -->
                <button id="mobile-menu-btn" type="button" class="md:hidden w-10 h-10 flex items-center justify-center text-zinc-300 hover:text-white bg-white/[0.04] hover:bg-white/[0.08] border border-white/10 rounded-full transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500 cursor-pointer" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="mobile-menu">
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

    <!-- Mobile Navigation Drawer (Phone Optimized with Touch Targets) -->
    <div id="mobile-menu" class="hidden fixed top-18 sm:top-20 inset-x-3 sm:inset-x-4 z-40 md:hidden rounded-2xl sm:rounded-3xl glass-panel p-4 sm:p-5 space-y-1.5 text-sm font-medium shadow-2xl shadow-black animate-scale-in" role="region" aria-label="Mobile navigation menu">
        <a href="{{ request()->routeIs('home') ? '#home' : route('home').'#home' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-zinc-200 hover:text-white hover:bg-white/[0.06] rounded-xl transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">Home</a>
        <a href="{{ request()->routeIs('home') ? '#about' : route('home').'#about' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-zinc-200 hover:text-white hover:bg-white/[0.06] rounded-xl transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">About</a>
        <a href="{{ request()->routeIs('home') ? '#certifications' : route('home').'#certifications' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-zinc-200 hover:text-white hover:bg-white/[0.06] rounded-xl transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">Sertifikasi</a>
        <a href="{{ request()->routeIs('home') ? '#labs' : route('home').'#labs' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-zinc-200 hover:text-white hover:bg-white/[0.06] rounded-xl transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">Showcase Lab</a>
        <a href="{{ request()->routeIs('home') ? '#skills' : route('home').'#skills' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-zinc-200 hover:text-white hover:bg-white/[0.06] rounded-xl transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">Skill Matrix</a>
        <a href="{{ request()->routeIs('home') ? '#architecture' : route('home').'#architecture' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-zinc-200 hover:text-white hover:bg-white/[0.06] rounded-xl transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">Arsitektur Stack</a>
        <a href="{{ route('projects.index') }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-zinc-200 hover:text-white hover:bg-white/[0.06] rounded-xl transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">Katalog Lengkap</a>
        <a href="{{ request()->routeIs('home') ? '#contact' : route('home').'#contact' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-zinc-200 hover:text-white hover:bg-white/[0.06] rounded-xl transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">Contact</a>
        <div class="pt-2">
            <a href="{{ request()->routeIs('home') ? '#contact' : route('home').'#contact' }}" class="min-h-[44px] flex items-center justify-center px-4 py-3 text-center rounded-xl bg-gradient-to-r from-red-600 via-rose-600 to-red-500 text-white font-semibold shadow-lg shadow-rose-600/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">Hubungi Saya &rarr;</a>
        </div>
    </div>

    <!-- Main Page Content -->
    <main class="flex-1 relative z-10 pt-16 sm:pt-24">
        @yield('content')
    </main>

    <!-- Floating Back-To-Top Button (ekizr.com feature) -->
    <button id="back-to-top" type="button" class="fixed bottom-6 right-6 z-40 p-3.5 rounded-full glass-panel text-rose-400 hover:text-white hover:border-rose-500 hover:shadow-rose-600/30 shadow-xl transition-all duration-300 opacity-0 pointer-events-none translate-y-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500 cursor-pointer" aria-label="Scroll to top">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    <!-- Footer -->
    <footer class="mt-20 sm:mt-32 pb-10 sm:pb-14 pt-12 sm:pt-16 border-t border-white/[0.08] text-sm relative z-10 glass-panel border-x-0 border-b-0 rounded-none">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-end">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-7 h-7 shrink-0 object-contain">
                        <span class="font-bold text-white tracking-tight text-base">I Made Yuda Pramana</span>
                    </div>
                    <p class="text-zinc-500 max-w-md leading-relaxed text-xs">
                        Arsitektur topologi jaringan berkecepatan tinggi, administrasi server Linux Debian, protokol routing dinamis, dan virtualisasi mandiri. Portofolio resmi kejuruan Teknik Komputer dan Jaringan.
                    </p>
                    <div class="mt-4 flex flex-wrap items-center gap-4 text-xs font-mono text-zinc-400">
                        <a href="mailto:yuda2010f@gmail.com" class="hover:text-rose-400 transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>yuda2010f@gmail.com</span>
                        </a>
                        <a href="https://wa.me/6285182691268" target="_blank" rel="noopener noreferrer" class="hover:text-emerald-400 transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>085182691268</span>
                        </a>
                        <a href="https://github.com/Great-YUDZZ" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-zinc-400" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                            </svg>
                            <span>Great-YUDZZ</span>
                        </a>
                    </div>
                </div>
                
                <div class="flex flex-wrap md:justify-end gap-8 text-xs font-medium text-zinc-500">
                    <a href="{{ request()->routeIs('home') ? '#home' : route('home') }}" class="py-1 hover:text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">Home</a>
                    <a href="{{ request()->routeIs('home') ? '#about' : route('home').'#about' }}" class="py-1 hover:text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">About</a>
                    <a href="{{ request()->routeIs('home') ? '#certifications' : route('home').'#certifications' }}" class="py-1 hover:text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">Sertifikasi</a>
                    <a href="{{ request()->routeIs('home') ? '#labs' : route('home').'#labs' }}" class="py-1 hover:text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">Showcase Lab</a>
                    <a href="{{ request()->routeIs('home') ? '#skills' : route('home').'#skills' }}" class="py-1 hover:text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">Skill Matrix</a>
                    <a href="{{ request()->routeIs('home') ? '#architecture' : route('home').'#architecture' }}" class="py-1 hover:text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">Arsitektur</a>
                    <a href="{{ route('projects.index') }}" class="py-1 hover:text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">Katalog Lab</a>
                    <a href="{{ request()->routeIs('home') ? '#contact' : route('home').'#contact' }}" class="py-1 hover:text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">Contact</a>
                </div>
            </div>

            <div class="max-w-7xl mx-auto mt-10 pt-6 border-t border-white/[0.04] flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-zinc-600 font-mono">
                <div>&copy; {{ date('Y') }} I Made Yuda Pramana. All rights reserved.</div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>LEMP Stack (Debian 13, Nginx 1.26, MariaDB, PHP 8.4)</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
