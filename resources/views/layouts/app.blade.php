<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="theme-color" content="#f8fafc">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-[#0F172A] text-slate-700 antialiased selection:bg-blue-600/20 selection:text-blue-900 relative overflow-x-hidden font-sans">

    <!-- Interactive Background Canvas (Modern Engineering Clarity Mesh) -->
    <canvas id="interactive-bg" class="fixed inset-0 pointer-events-none z-0" aria-hidden="true"></canvas>

    <!-- Top Ambient Atmosphere Glow -->
    <div class="pointer-events-none fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[580px] bg-clarity-glow opacity-80 z-0"></div>

    <!-- Ambient Chromatic Refraction Nodes for Visual Atmosphere -->
    <div class="pointer-events-none fixed top-24 left-1/4 w-96 h-96 rounded-full bg-blue-600/[0.04] blur-[120px] z-0"></div>
    <div class="pointer-events-none fixed top-[45%] right-8 w-[450px] h-[450px] rounded-full bg-teal-600/[0.04] blur-[140px] z-0"></div>
    <div class="pointer-events-none fixed bottom-32 left-8 w-[400px] h-[400px] rounded-full bg-sky-500/[0.03] blur-[130px] z-0"></div>

    <!-- Floating Pill Navigation (Modern Engineering Clarity) -->
    <div class="fixed top-3 sm:top-6 left-0 right-0 z-50 flex justify-center px-3 sm:px-4 pointer-events-none">
        <header class="pointer-events-auto w-full max-w-6xl xl:max-w-7xl rounded-full glass-panel px-4 sm:px-7 py-2 sm:py-2.5 flex items-center justify-between transition-all duration-300">
            <!-- Brand Identity Cluster -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 rounded-xl mr-2 lg:mr-3 xl:mr-8 shrink-0" aria-label="I Made Yuda Pramana Home">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shadow-md shadow-orange-500/20 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <div class="font-bold text-slate-950 text-xs sm:text-sm lg:text-[14px] xl:text-[15px] tracking-normal group-hover:text-blue-600 transition-colors flex items-center gap-1.5 whitespace-nowrap">
                        <span>I Made Yuda Pramana</span>
                    </div>
                    <div class="text-[10px] text-slate-700 font-mono hidden sm:flex items-center gap-1 font-medium whitespace-nowrap">
                        <span>Teknik Komputer &amp; Jaringan</span>
                    </div>
                </div>
            </a>

            <!-- Desktop Pill Navigation -->
            <nav class="hidden lg:flex items-center gap-0.5 xl:gap-1 px-2 xl:px-3 py-1 rounded-full bg-slate-200/50 border border-slate-300/60 backdrop-blur-md text-[11px] xl:text-xs font-semibold shrink-0">
                <a href="{{ request()->routeIs('home') ? '#home' : route('home').'#home' }}" data-nav-section="home" class="px-2 xl:px-3 py-1.5 rounded-full text-slate-800 hover:text-slate-950 hover:bg-white/80 hover:shadow-xs transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                    Home
                </a>
                <a href="{{ request()->routeIs('home') ? '#about' : route('home').'#about' }}" data-nav-section="about" class="px-2 xl:px-3 py-1.5 rounded-full text-slate-800 hover:text-slate-950 hover:bg-white/80 hover:shadow-xs transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                    About
                </a>
                <a href="{{ request()->routeIs('home') ? '#certifications' : route('home').'#certifications' }}" data-nav-section="certifications" class="px-2 xl:px-3 py-1.5 rounded-full text-slate-800 hover:text-slate-950 hover:bg-white/80 hover:shadow-xs transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                    Sertifikasi
                </a>
                <a href="{{ request()->routeIs('home') ? '#labs' : route('home').'#labs' }}" data-nav-section="labs" class="px-2 xl:px-3 py-1.5 rounded-full text-slate-800 hover:text-slate-950 hover:bg-white/80 hover:shadow-xs transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                    Showcase Lab
                </a>
                <a href="{{ request()->routeIs('home') ? '#skills' : route('home').'#skills' }}" data-nav-section="skills" class="px-2 xl:px-3 py-1.5 rounded-full text-slate-800 hover:text-slate-950 hover:bg-white/80 hover:shadow-xs transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                    Skill Matrix
                </a>
                <a href="{{ request()->routeIs('home') ? '#architecture' : route('home').'#architecture' }}" data-nav-section="architecture" class="px-2 xl:px-3 py-1.5 rounded-full text-slate-800 hover:text-slate-950 hover:bg-white/80 hover:shadow-xs transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                    Arsitektur
                </a>
                <a href="{{ route('projects.index') }}" class="px-2 xl:px-3 py-1.5 rounded-full {{ request()->routeIs('projects.*') ? 'text-slate-950 bg-white/95 shadow-xs font-bold border border-slate-200/80' : 'text-slate-800 hover:text-slate-950 hover:bg-white/80 hover:shadow-xs' }} transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                    Katalog
                </a>
                <a href="{{ request()->routeIs('home') ? '#contact' : route('home').'#contact' }}" data-nav-section="contact" class="px-2 xl:px-3 py-1.5 rounded-full text-slate-800 hover:text-slate-950 hover:bg-white/80 hover:shadow-xs transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                    Contact
                </a>
            </nav>

            <!-- Action Cluster -->
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <a href="{{ request()->routeIs('home') ? '#contact' : route('home').'#contact' }}" class="hidden sm:inline-flex items-center gap-1.5 xl:gap-2 px-3.5 xl:px-5 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-full shadow-md shadow-blue-500/20 hover:shadow-blue-500/30 transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 active:scale-95 whitespace-nowrap">
                    <span>Hubungi Saya</span>
                    <span class="w-4 h-4 rounded-full bg-white/20 flex items-center justify-center text-[10px]">&rarr;</span>
                </a>

                <!-- Mobile Menu Button (Accessible 44px Tap Target) -->
                <button id="mobile-menu-btn" type="button" class="lg:hidden w-10 h-10 flex items-center justify-center text-slate-900 hover:text-blue-600 bg-white/90 hover:bg-white border border-slate-200/80 rounded-full shadow-xs transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 cursor-pointer" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="mobile-menu">
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
    <div id="mobile-menu" class="hidden fixed top-18 sm:top-20 inset-x-3 sm:inset-x-4 z-40 md:hidden rounded-2xl sm:rounded-3xl glass-panel p-4 sm:p-5 space-y-1.5 text-sm font-semibold shadow-2xl shadow-slate-900/15 border border-white/80 animate-scale-in" role="region" aria-label="Mobile navigation menu">
        <a href="{{ request()->routeIs('home') ? '#home' : route('home').'#home' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-slate-900 hover:text-blue-600 hover:bg-slate-100/80 rounded-xl transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Home</a>
        <a href="{{ request()->routeIs('home') ? '#about' : route('home').'#about' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-slate-900 hover:text-blue-600 hover:bg-slate-100/80 rounded-xl transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">About</a>
        <a href="{{ request()->routeIs('home') ? '#certifications' : route('home').'#certifications' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-slate-900 hover:text-blue-600 hover:bg-slate-100/80 rounded-xl transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Sertifikasi</a>
        <a href="{{ request()->routeIs('home') ? '#labs' : route('home').'#labs' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-slate-900 hover:text-blue-600 hover:bg-slate-100/80 rounded-xl transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Showcase Lab</a>
        <a href="{{ request()->routeIs('home') ? '#skills' : route('home').'#skills' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-slate-900 hover:text-blue-600 hover:bg-slate-100/80 rounded-xl transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Skill Matrix</a>
        <a href="{{ request()->routeIs('home') ? '#architecture' : route('home').'#architecture' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-slate-900 hover:text-blue-600 hover:bg-slate-100/80 rounded-xl transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Arsitektur Stack</a>
        <a href="{{ route('projects.index') }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-slate-900 hover:text-blue-600 hover:bg-slate-100/80 rounded-xl transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Katalog Lengkap</a>
        <a href="{{ request()->routeIs('home') ? '#contact' : route('home').'#contact' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-slate-900 hover:text-blue-600 hover:bg-slate-100/80 rounded-xl transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Contact</a>
        <div class="pt-2">
            <a href="{{ request()->routeIs('home') ? '#contact' : route('home').'#contact' }}" class="min-h-[44px] flex items-center justify-center px-4 py-3 text-center rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-lg shadow-blue-600/25 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Hubungi Saya &rarr;</a>
        </div>
    </div>

    <!-- Main Page Content -->
    <main class="flex-1 relative z-10 pt-16 sm:pt-24">
        @yield('content')
    </main>

    <!-- Floating Back-To-Top Button -->
    <button id="back-to-top" type="button" class="fixed bottom-6 right-6 z-40 p-3.5 rounded-full glass-panel text-blue-600 hover:text-blue-700 hover:border-blue-300 hover:shadow-blue-500/20 shadow-lg transition-all duration-300 opacity-0 pointer-events-none translate-y-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 cursor-pointer" aria-label="Scroll to top">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    <!-- Footer -->
    <footer class="pb-10 sm:pb-14 pt-12 sm:pt-16 border-t border-slate-800 text-sm relative z-10 bg-[#0F172A] rounded-none">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-end">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-7 h-7 shrink-0 object-contain">
                        <span class="font-bold text-white tracking-tight text-base">I Made Yuda Pramana</span>
                    </div>
                    <p class="text-slate-400 max-w-md leading-relaxed text-xs">
                        Arsitektur topologi jaringan berkecepatan tinggi, administrasi server Linux Debian, protokol routing dinamis, dan virtualisasi mandiri. Portofolio resmi kejuruan Teknik Komputer dan Jaringan.
                    </p>
                    <div class="mt-4 flex flex-wrap items-center gap-4 text-xs font-mono text-slate-400">
                        <a href="mailto:yuda2010f@gmail.com" class="hover:text-sky-400 transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>yuda2010f@gmail.com</span>
                        </a>
                        <a href="https://wa.me/6285182691268" target="_blank" rel="noopener noreferrer" class="hover:text-teal-400 transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>085182691268</span>
                        </a>
                        <a href="https://github.com/Great-YUDZZ" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                            </svg>
                            <span>Great-YUDZZ</span>
                        </a>
                    </div>
                </div>
                
                <div class="flex flex-wrap md:justify-end gap-8 text-xs font-medium text-slate-400">
                    <a href="{{ request()->routeIs('home') ? '#home' : route('home') }}" class="py-1 hover:text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Home</a>
                    <a href="{{ request()->routeIs('home') ? '#about' : route('home').'#about' }}" class="py-1 hover:text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">About</a>
                    <a href="{{ request()->routeIs('home') ? '#certifications' : route('home').'#certifications' }}" class="py-1 hover:text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Sertifikasi</a>
                    <a href="{{ request()->routeIs('home') ? '#labs' : route('home').'#labs' }}" class="py-1 hover:text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Showcase Lab</a>
                    <a href="{{ request()->routeIs('home') ? '#skills' : route('home').'#skills' }}" class="py-1 hover:text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Skill Matrix</a>
                    <a href="{{ request()->routeIs('home') ? '#architecture' : route('home').'#architecture' }}" class="py-1 hover:text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Arsitektur</a>
                    <a href="{{ route('projects.index') }}" class="py-1 hover:text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Katalog Lab</a>
                    <a href="{{ request()->routeIs('home') ? '#contact' : route('home').'#contact' }}" class="py-1 hover:text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Contact</a>
                </div>
            </div>

            <div class="max-w-7xl mx-auto mt-10 pt-6 border-t border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-400 font-mono">
                <div>&copy; {{ date('Y') }} I Made Yuda Pramana. All rights reserved.</div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>LEMP Stack (Debian 13, Nginx 1.26, MariaDB, PHP 8.4)</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
