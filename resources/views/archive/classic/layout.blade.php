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
<body class="min-h-screen flex flex-col bg-[#F8F5EE] text-[#1C1917] antialiased selection:bg-[#0C382E]/20 selection:text-[#0C382E] relative overflow-x-hidden font-sans">

    <!-- Archive Mode Banner -->
    <div class="w-full bg-[#1C1917] text-stone-200 text-xs py-2.5 px-4 text-center font-mono flex flex-wrap items-center justify-center gap-2 sm:gap-3 border-b border-stone-800 relative z-50">
        <span class="w-2 h-2 rounded-full bg-amber-400 shrink-0"></span>
        <span>Arsip Desain Portofolio (Versi Earth Tone Klasik)</span>
        <span class="text-stone-500 hidden sm:inline">|</span>
        <a href="{{ route('home') }}" class="underline font-bold text-white hover:text-amber-300 transition-colors">Kembali ke Desain Utama Dark Mode &rarr;</a>
    </div>

    <!-- Floating Pill Navigation (AetherCraft Pure Craft Frosted HUD) -->
    <div class="fixed top-12 sm:top-14 left-0 right-0 z-40 flex justify-center px-3 sm:px-4 pointer-events-none">
        <header class="pointer-events-auto w-full max-w-6xl xl:max-w-7xl rounded-full border border-stone-300/80 bg-white/92 backdrop-blur-2xl shadow-xl shadow-stone-900/08 px-4 sm:px-7 py-2 sm:py-2.5 flex items-center justify-between transition-all duration-300">
            <!-- Brand Identity Cluster -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0C382E] rounded-xl mr-2 lg:mr-3 xl:mr-8 shrink-0" aria-label="I Made Yuda Pramana Home">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-br from-[#0C382E] to-[#165B4C] flex items-center justify-center shadow-md shadow-[#0C382E]/20 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 text-[#F8F5EE]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <div class="font-extrabold text-[#1C1917] text-xs sm:text-sm lg:text-[14px] xl:text-[15px] tracking-tight group-hover:text-[#0C382E] transition-colors flex items-center gap-1.5 whitespace-nowrap">
                        <span>I Made Yuda Pramana</span>
                    </div>
                    <div class="text-[11px] text-[#57534E] font-mono hidden sm:flex items-center gap-1 font-semibold whitespace-nowrap">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                        <span>Teknik Komputer &amp; Jaringan</span>
                    </div>
                </div>
            </a>

            <!-- Desktop Pill Navigation -->
            <nav class="classic-nav hidden lg:flex items-center gap-1 xl:gap-1.5 px-2.5 xl:px-3 py-1.5 rounded-full bg-stone-100/90 border border-stone-200/90 backdrop-blur-md text-[11px] xl:text-xs shrink-0 shadow-inner">
                <a href="{{ request()->routeIs('home') ? '#home' : route('home').'#home' }}" data-nav-section="home" class="nav-link px-2.5 xl:px-3 py-1.5 rounded-full focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0C382E]">
                    Home
                </a>
                <a href="{{ request()->routeIs('home') ? '#about' : route('home').'#about' }}" data-nav-section="about" class="nav-link px-2.5 xl:px-3 py-1.5 rounded-full focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0C382E]">
                    About
                </a>
                <a href="{{ request()->routeIs('home') ? '#certifications' : route('home').'#certifications' }}" data-nav-section="certifications" class="nav-link px-2.5 xl:px-3 py-1.5 rounded-full focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0C382E]">
                    Sertifikasi
                </a>
                <a href="{{ request()->routeIs('home') ? '#labs' : route('home').'#labs' }}" data-nav-section="labs" class="nav-link px-2.5 xl:px-3 py-1.5 rounded-full focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0C382E]">
                    Showcase Lab
                </a>
                <a href="{{ request()->routeIs('home') ? '#skills' : route('home').'#skills' }}" data-nav-section="skills" class="nav-link px-2.5 xl:px-3 py-1.5 rounded-full focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0C382E]">
                    Skill Matrix
                </a>
                <a href="{{ request()->routeIs('home') ? '#architecture' : route('home').'#architecture' }}" data-nav-section="architecture" class="nav-link px-2.5 xl:px-3 py-1.5 rounded-full focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0C382E]">
                    Arsitektur
                </a>
                <a href="{{ route('projects.index') }}" class="nav-link px-2.5 xl:px-3 py-1.5 rounded-full {{ request()->routeIs('projects.*') ? 'nav-link-active' : '' }} focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0C382E]">
                    Katalog
                </a>
                <a href="{{ route('ai.index') }}" class="nav-link px-2.5 xl:px-3 py-1.5 rounded-full {{ request()->routeIs('ai.*') ? 'nav-link-active' : '' }} flex items-center gap-1.5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0C382E]">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span class="font-bold text-[#0C382E]">Yuna AI</span>
                </a>
                <a href="{{ request()->routeIs('home') ? '#contact' : route('home').'#contact' }}" data-nav-section="contact" class="nav-link px-2.5 xl:px-3 py-1.5 rounded-full focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0C382E]">
                    Contact
                </a>
            </nav>

            <!-- Action Cluster -->
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">

                <a href="{{ route('dark.preview') }}" class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-full bg-[#0a0a0a] text-[#f5f5f5] hover:bg-black hover:scale-105 text-[11px] font-mono border border-stone-800 shadow-sm transition-all" title="Lihat Tampilan Portofolio Minimalis Dark Mode '26">
                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                    <span class="hidden xs:inline">Dark '26</span>
                    <span class="text-[10px] text-white">↗</span>
                </a>

                <a href="{{ request()->routeIs('home') ? '#contact' : route('home').'#contact' }}" class="btn-earth-green hidden sm:inline-flex items-center gap-1.5 xl:gap-2 px-4 xl:px-5 py-2 text-xs font-bold whitespace-nowrap">
                    <span>Hubungi Saya</span>
                    <span class="w-4 h-4 rounded-full bg-white/20 flex items-center justify-center text-[10px] text-white">&rarr;</span>
                </a>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" type="button" class="lg:hidden w-10 h-10 flex items-center justify-center text-[#0C382E] hover:text-[#144D3F] bg-stone-100 hover:bg-stone-200 border border-stone-300 rounded-full shadow-xs transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0C382E] cursor-pointer" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="mobile-menu">
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
    <div id="mobile-menu" class="hidden fixed top-18 sm:top-20 inset-x-3 sm:inset-x-4 z-40 lg:hidden rounded-3xl bg-[#FAF8F5]/98 border border-stone-200/90 backdrop-blur-3xl p-4 sm:p-5 space-y-1.5 text-sm font-semibold shadow-2xl text-[#1C1917] animate-scale-in max-h-[calc(100dvh-5.5rem)] overflow-y-auto" role="region" aria-label="Mobile navigation menu">
        <a href="{{ request()->routeIs('home') ? '#home' : route('home').'#home' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-[#1C1917] hover:text-[#0C382E] hover:bg-stone-200/70 rounded-xl transition-colors font-semibold">Home</a>
        <a href="{{ request()->routeIs('home') ? '#about' : route('home').'#about' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-[#1C1917] hover:text-[#0C382E] hover:bg-stone-200/70 rounded-xl transition-colors font-semibold">About</a>
        <a href="{{ request()->routeIs('home') ? '#certifications' : route('home').'#certifications' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-[#1C1917] hover:text-[#0C382E] hover:bg-stone-200/70 rounded-xl transition-colors font-semibold">Sertifikasi</a>
        <a href="{{ request()->routeIs('home') ? '#labs' : route('home').'#labs' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-[#1C1917] hover:text-[#0C382E] hover:bg-stone-200/70 rounded-xl transition-colors font-semibold">Showcase Lab</a>
        <a href="{{ request()->routeIs('home') ? '#skills' : route('home').'#skills' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-[#1C1917] hover:text-[#0C382E] hover:bg-stone-200/70 rounded-xl transition-colors font-semibold">Skill Matrix</a>
        <a href="{{ request()->routeIs('home') ? '#architecture' : route('home').'#architecture' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-[#1C1917] hover:text-[#0C382E] hover:bg-stone-200/70 rounded-xl transition-colors font-semibold">Arsitektur Stack</a>
        <a href="{{ route('projects.index') }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-[#1C1917] hover:text-[#0C382E] hover:bg-stone-200/70 rounded-xl transition-colors font-semibold">Katalog Lengkap</a>
        <a href="{{ route('ai.index') }}" class="min-h-[44px] flex items-center justify-between px-4 py-2.5 text-[#0C382E] bg-emerald-500/10 hover:bg-emerald-500/20 rounded-xl transition-colors font-bold">
            <span class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Yuna AI Console</span>
            </span>
            <span class="text-xs font-mono font-bold text-emerald-800 bg-emerald-200/80 px-2 py-0.5 rounded-full">AI</span>
        </a>
        <a href="{{ route('dark.preview') }}" class="min-h-[44px] flex items-center justify-between px-4 py-2.5 text-[#f5f5f5] bg-[#0a0a0a] hover:bg-stone-900 rounded-xl transition-colors font-mono text-xs">
            <span class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-white"></span>
                <span>Dark Portfolio '26</span>
            </span>
            <span class="text-[10px] text-stone-400">Preview ↗</span>
        </a>
        <a href="{{ request()->routeIs('home') ? '#contact' : route('home').'#contact' }}" class="min-h-[44px] flex items-center px-4 py-2.5 text-[#1C1917] hover:text-[#0C382E] hover:bg-stone-200/70 rounded-xl transition-colors font-semibold">Contact</a>
        <div class="pt-2">
            <a href="{{ request()->routeIs('home') ? '#contact' : route('home').'#contact' }}" class="btn-earth-green w-full min-h-[44px] flex items-center justify-center px-4 py-3 text-center rounded-xl font-bold">Hubungi Saya &rarr;</a>
        </div>
    </div>

    <!-- Main Page Content -->
    <main class="flex-1 relative z-10 pt-16 sm:pt-24">
        @yield('content')
    </main>

    <!-- Floating Back-To-Top Button -->
    <button id="back-to-top" type="button" class="fixed bottom-22 right-6 z-40 p-3.5 rounded-full bg-[#0C382E] text-[#F8F5EE] border border-[#144D3F] hover:bg-[#144D3F] shadow-xl transition-all duration-300 opacity-0 pointer-events-none translate-y-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0C382E] cursor-pointer" aria-label="Scroll to top">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    @if(!request()->routeIs('ai.*'))
    <!-- AI Chatbot Assistant Widget (TKJ Knowledge Core) -->
    <x-chatbot-widget />
    @endif

    <!-- Footer: Deep Forest Green (#0C382E) Minimalist Editorial -->
    <footer class="pb-10 sm:pb-14 pt-12 sm:pt-16 text-sm relative z-10 bg-[#071E18] text-[#F8F5EE]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-end">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-7 h-7 shrink-0 object-contain brightness-0 invert">
                        <span class="font-bold text-white tracking-tight text-base">I Made Yuda Pramana</span>
                    </div>
                    <p class="text-[#E7EFEA]/80 max-w-md leading-relaxed text-xs">
                        Arsitektur topologi jaringan berkecepatan tinggi, administrasi server Linux Debian, protokol routing dinamis, dan virtualisasi mandiri. Portofolio resmi kejuruan Teknik Komputer dan Jaringan.
                    </p>
                    <div class="mt-4 flex flex-wrap items-center gap-4 text-xs font-mono text-[#E7EFEA]/75">
                        <a href="mailto:yuda2010f@gmail.com" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>yuda2010f@gmail.com</span>
                        </a>
                        <a href="https://wa.me/6285182691268" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>085182691268</span>
                        </a>
                        <a href="https://github.com/Great-YUDZZ" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-300" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                            </svg>
                            <span>Great-YUDZZ</span>
                        </a>
                    </div>
                </div>
                
                <div class="flex flex-wrap md:justify-end gap-8 text-xs font-medium text-[#E7EFEA]/80">
                    <a href="{{ request()->routeIs('home') ? '#home' : route('home') }}" class="py-1 hover:text-white transition-colors">Home</a>
                    <a href="{{ request()->routeIs('home') ? '#about' : route('home').'#about' }}" class="py-1 hover:text-white transition-colors">About</a>
                    <a href="{{ request()->routeIs('home') ? '#certifications' : route('home').'#certifications' }}" class="py-1 hover:text-white transition-colors">Sertifikasi</a>
                    <a href="{{ request()->routeIs('home') ? '#labs' : route('home').'#labs' }}" class="py-1 hover:text-white transition-colors">Showcase Lab</a>
                    <a href="{{ request()->routeIs('home') ? '#skills' : route('home').'#skills' }}" class="py-1 hover:text-white transition-colors">Skill Matrix</a>
                    <a href="{{ request()->routeIs('home') ? '#architecture' : route('home').'#architecture' }}" class="py-1 hover:text-white transition-colors">Arsitektur</a>
                    <a href="{{ route('projects.index') }}" class="py-1 hover:text-white transition-colors">Katalog Lab</a>
                    <a href="{{ route('ai.index') }}" class="py-1 text-emerald-400 font-bold hover:text-emerald-300 transition-colors flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        <span>Yuna AI</span>
                    </a>
                    <a href="{{ request()->routeIs('home') ? '#contact' : route('home').'#contact' }}" class="py-1 hover:text-white transition-colors">Contact</a>
                </div>
            </div>

            <div class="max-w-7xl mx-auto mt-10 pt-6 border-t border-[#0A2D22] flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-[#E7EFEA]/70 font-mono">
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
