<!DOCTYPE html>
<html lang="id" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="theme-color" content="#0a0a0a">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>I Made Yuda Pramana | Network Engineer &amp; Software Developer</title>
    <meta name="description" content="Portofolio rekayasa teknologi I Made Yuda Pramana. Spesialisasi infrastruktur jaringan enterprise, software desktop native, dan utilitas developer berkinerja tinggi.">

    <!-- Favicon & Icons -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Google Fonts: Inter, JetBrains Mono & Outfit (Geometric Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Force Scroll to Top on Page Load & Refresh -->
    <script>
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
        window.scrollTo(0, 0);
        window.addEventListener('beforeunload', function() {
            window.scrollTo(0, 0);
        });
    </script>
</head>
<body class="bg-[#0a0a0a] text-[#f5f5f5] antialiased selection:bg-white/20 selection:text-white relative overflow-x-hidden font-body">

    <!-- Root Dark Portfolio Anchor -->
    <div id="dark-portfolio-root" class="min-h-screen relative overflow-x-hidden">

        <!-- ========================================== -->
        <!-- FIXED INTERACTIVE WHITE STARFIELD          -->
        <!-- ========================================== -->
        <div id="global-starfield-container" class="fixed inset-0 pointer-events-none z-0 overflow-hidden" aria-hidden="true">
            <!-- Deep space cosmic dark backdrop -->
            <div class="absolute inset-0 bg-[#0a0a0a]"></div>
            <!-- Technical precision geometric grid -->
            <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.03)_1px,transparent_1px)] bg-[size:4rem_4rem] opacity-30"></div>
            <!-- Interactive 3D White Starfield Canvas -->
            <canvas id="interactive-bg" class="absolute inset-0 w-full h-full opacity-90"></canvas>
            <!-- Cursor spotlight follower -->
            <div id="bg-cursor-spotlight" class="absolute inset-0 pointer-events-none" style="background: radial-gradient(700px circle at var(--mouse-x, 50%) var(--mouse-y, 30%), rgba(255, 255, 255, 0.035), transparent 70%);"></div>
            <!-- Vignette edge falloff -->
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,transparent_35%,rgba(10,10,10,0.65)_100%)]"></div>
        </div>

        <!-- FIXED FLOATING NAVBAR (Glassmorphism HUD) -->
        <header class="fixed top-0 left-0 right-0 z-50 flex justify-center pt-3 sm:pt-4 md:pt-6 px-3 sm:px-4 pointer-events-none">
            <div id="dark-nav-pill" class="pointer-events-auto inline-flex items-center rounded-full glass-hud px-2 sm:px-4 py-1.5 sm:py-2 transition-all duration-300 gap-1 sm:gap-2 max-w-[calc(100vw-1.5rem)]">
                <!-- Logo: circle with frosted glass badge -->
                <a href="#hero" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white/5 border border-white/15 p-[1px] group hover:scale-110 hover:border-white/50 transition-all flex items-center justify-center shrink-0 shadow-sm" aria-label="Beranda">
                    <div class="w-full h-full bg-[#0a0a0a]/60 backdrop-blur-sm rounded-full flex items-center justify-center text-xs sm:text-[13px] font-display font-black text-[#f5f5f5] group-hover:text-white transition-colors">
                        YP
                    </div>
                </a>

                <!-- Hairline Divider -->
                <div class="w-px h-4 sm:h-5 bg-white/10 mx-0.5 sm:mx-1"></div>

                <!-- Nav Links with Glass Hover Treatments -->
                <nav id="dark-nav-menu" class="flex items-center gap-0.5 sm:gap-1 text-xs sm:text-sm font-medium">
                    <a href="#hero" data-nav-target="hero" class="nav-item px-2.5 sm:px-3.5 py-1 sm:py-1.5 rounded-full text-white font-semibold bg-white/15 shadow-sm transition-all">Beranda</a>
                    <a href="#works" data-nav-target="works" class="nav-item px-2.5 sm:px-3.5 py-1 sm:py-1.5 rounded-full text-[#878787] hover:text-[#f5f5f5] hover:bg-white/10 transition-all">Karya</a>
                    <a href="#skills" data-nav-target="skills" class="nav-item hidden sm:inline-block px-3.5 py-1.5 rounded-full text-[#878787] hover:text-[#f5f5f5] hover:bg-white/10 transition-all">Keahlian</a>
                    <a href="#technologies" data-nav-target="technologies" class="nav-item hidden md:inline-block px-3.5 py-1.5 rounded-full text-[#878787] hover:text-[#f5f5f5] hover:bg-white/10 transition-all">Tech Stack</a>
                    <a href="#contact" data-nav-target="contact" class="nav-item px-2.5 sm:px-3.5 py-1 sm:py-1.5 rounded-full text-[#878787] hover:text-[#f5f5f5] hover:bg-white/10 transition-all">Kontak</a>
                </nav>

                <!-- Hairline Divider -->
                <div class="w-px h-4 sm:h-5 bg-white/10 mx-0.5 sm:mx-1"></div>

                <!-- Hubungi Saya Solid White High-Contrast Glass CTA -->
                <a href="#contact" class="inline-flex items-center gap-1 sm:gap-1.5 px-3 sm:px-4 py-1 sm:py-1.5 bg-white text-black hover:bg-neutral-200 rounded-full text-xs sm:text-sm font-semibold shadow-md transition-all hover:scale-[1.02] active:scale-[0.98] shrink-0">
                    <span class="hidden sm:inline">Hubungi Saya</span>
                    <span class="sm:hidden">Chat</span>
                    <span class="text-xs font-bold">&rarr;</span>
                </a>
            </div>
        </header>

        <!-- ========================================== -->
        <!-- SECTION 2: HERO                            -->
        <!-- ========================================== -->
        <section id="hero" class="min-h-screen relative z-10 flex items-center justify-center overflow-hidden bg-transparent">
            <!-- Background HLS Video (Mux Stream via hls.js) -->
            <video id="hero-hls-video" autoplay muted loop playsinline class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 min-w-full min-h-full object-cover opacity-20 pointer-events-none"></video>

            <!-- Dark Overlay & Subtle Micro-Grid -->
            <div class="absolute inset-0 bg-black/30 pointer-events-none"></div>
            <div class="absolute inset-0 bg-halftone opacity-15 pointer-events-none"></div>

            <!-- Bottom Gradient Fade -->
            <div class="h-48 bg-gradient-to-t from-[#0a0a0a] to-transparent absolute bottom-0 left-0 right-0 pointer-events-none"></div>

            <!-- Hero Centered Content -->
            <div class="relative z-10 text-center max-w-4xl px-6 pt-28 pb-20 flex flex-col items-center">
                <!-- Display Name in Outfit Geometric Sans -->
                <h1 class="name-reveal text-6xl sm:text-7xl md:text-8xl lg:text-9xl font-display font-extrabold leading-[0.9] tracking-tight text-[#f5f5f5] mb-6">
                    I Made Yuda Pramana
                </h1>

                <!-- Cycling Role Subhead -->
                <div class="blur-in text-lg sm:text-xl md:text-2xl text-[#878787] mb-6 font-normal">
                    Seorang <span id="hero-rotating-role" class="font-display font-bold text-[#f5f5f5] animate-role-fade-in inline-block border-b border-white/40 pb-0.5">Network Engineer</span> berbasis di Denpasar.
                </div>

                <!-- Description -->
                <p class="blur-in text-sm md:text-base text-[#878787] max-w-xl mx-auto mb-10 leading-relaxed font-light">
                    Merancang utilitas developer tangguh, aplikasi desktop native, dan sistem perangkat lunak berkinerja tinggi dengan mechanical sympathy.
                </p>

                <!-- CTA Buttons -->
                <div class="blur-in inline-flex flex-wrap items-center justify-center gap-4">
                    <!-- See Works Button -->
                    <a href="#works" class="rounded-full text-sm font-medium px-7 py-3.5 bg-[#f5f5f5] text-[#0a0a0a] hover:bg-[#0a0a0a] hover:text-[#f5f5f5] hover:scale-105 transition-all shadow-xl shadow-white/5 border border-transparent hover:border-white">
                        Lihat Karya
                    </a>

                    <!-- Reach out Button -->
                    <a href="#contact" class="rounded-full text-sm font-medium px-7 py-3.5 border-2 border-[#1f1f1f] bg-[#0a0a0a] text-[#f5f5f5] hover:border-transparent hover:scale-105 transition-all relative group overflow-hidden">
                        <span class="absolute inset-0 accent-gradient opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        <span class="relative">Hubungi Saya</span>
                    </a>
                </div>
            </div>

            <!-- Scroll Indicator -->
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 pointer-events-none z-10">
                <span class="text-[10px] text-[#878787] uppercase tracking-[0.25em] font-mono">GULIR KE BAWAH</span>
                <div class="w-px h-10 bg-[#1f1f1f] relative overflow-hidden">
                    <div class="w-full h-1/2 accent-gradient animate-scroll-down"></div>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 3: SELECTED WORKS (BENTO GRID)     -->
        <!-- ========================================== -->
        <section id="works" class="relative z-10 py-20 md:py-28 bg-transparent">
            <div class="max-w-[1200px] mx-auto px-6 md:px-10 lg:px-16">
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 md:mb-16 gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 mb-3">
                            <span class="w-8 h-px bg-[#1f1f1f]"></span>
                            <span class="text-xs text-[#878787] uppercase tracking-[0.3em] font-mono">KARYA PILIHAN</span>
                        </div>
                        <h2 class="text-3xl md:text-5xl font-sans text-[#f5f5f5] tracking-tight">
                            Proyek <span class="font-display font-bold text-[#f5f5f5]">Unggulan</span>
                            <span class="sr-only">Showcase Lab</span>
                        </h2>
                        <p class="text-sm md:text-base text-[#878787] mt-2 max-w-md font-light">
                            Koleksi proyek perangkat lunak dan utilitas yang saya rancang dan kembangkan, mulai dari perancangan arsitektur hingga deployment produksi.
                        </p>
                    </div>

                    <a href="{{ route('projects.index') }}" class="hidden md:inline-flex items-center gap-2 rounded-full border border-[#1f1f1f] px-5 py-2.5 text-xs text-[#878787] hover:text-[#f5f5f5] hover:border-white transition-all group">
                        <span>Lihat semua proyek</span>
                        <span class="text-xs group-hover:translate-x-1 transition-transform">→</span>
                    </a>
                </div>

                <!-- Bento Grid (Alternating 7/5 and Full Span columns) -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-5 md:gap-6">
                    
                    <!-- Card 1: IT Toolbox (Col Span 7) -->
                    <div class="md:col-span-7 bg-[#141414] border border-[#1f1f1f] rounded-3xl overflow-hidden relative group p-6 sm:p-8 min-h-[380px] flex flex-col justify-between transition-all hover:border-white/40">
                        <div class="absolute inset-0 bg-halftone opacity-15 pointer-events-none"></div>

                        <!-- Card Top Metadata -->
                        <div class="flex justify-between items-start z-10">
                            <div>
                                <span class="text-[11px] font-mono text-[#878787] uppercase tracking-wider">PROYEK 01 · CLI &amp; DESKTOP WORKBENCH</span>
                                <h3 class="text-2xl sm:text-3xl font-sans text-[#f5f5f5] font-semibold mt-1">IT Toolbox</h3>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-mono text-white border border-white/30 bg-white/10">PRODUKSI</span>
                        </div>

                        <!-- Tech Stack Box (Arsitektur & Teknologi Pembuatan) -->
                        <div class="my-6 z-10 bg-[#0a0a0a] rounded-2xl border border-[#1f1f1f] p-4 sm:p-5 font-mono shadow-inner">
                            <div class="flex items-center justify-between pb-3 border-b border-[#1f1f1f] mb-3 text-[11px]">
                                <span class="flex items-center gap-2 text-white font-semibold tracking-wider uppercase">
                                    <span class="w-2 h-2 rounded-full bg-white"></span>
                                    <span>TECH STACK PEMBUATAN</span>
                                </span>
                                <span class="text-[10px] text-[#878787] uppercase">DESKTOP WORKBENCH</span>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                                <div class="p-2.5 rounded-xl bg-[#141414] border border-[#1f1f1f] flex flex-col justify-between">
                                    <span class="text-[10px] text-[#878787] uppercase tracking-wider">BAHASA / INTI</span>
                                    <span class="text-xs font-semibold text-[#f5f5f5] mt-1">Go 1.25+</span>
                                    <span class="text-[9px] text-white/80 font-sans mt-0.5">Goroutines Konkurensi</span>
                                </div>
                                <div class="p-2.5 rounded-xl bg-[#141414] border border-[#1f1f1f] flex flex-col justify-between">
                                    <span class="text-[10px] text-[#878787] uppercase tracking-wider">UI TOOLKIT</span>
                                    <span class="text-xs font-semibold text-[#f5f5f5] mt-1">Fyne GUI v2.8</span>
                                    <span class="text-[9px] text-white font-sans mt-0.5">Hardware Canvas</span>
                                </div>
                                <div class="p-2.5 rounded-xl bg-[#141414] border border-[#1f1f1f] flex flex-col justify-between">
                                    <span class="text-[10px] text-[#878787] uppercase tracking-wider">PERSISTENSI</span>
                                    <span class="text-xs font-semibold text-[#f5f5f5] mt-1">SQLite Driver</span>
                                    <span class="text-[9px] text-white/90 font-sans mt-0.5">ACID Tersemat</span>
                                </div>
                                <div class="p-2.5 rounded-xl bg-[#141414] border border-[#1f1f1f] flex flex-col justify-between">
                                    <span class="text-[10px] text-[#878787] uppercase tracking-wider">ARSITEKTUR</span>
                                    <span class="text-xs font-semibold text-[#f5f5f5] mt-1">Cross-Binary</span>
                                    <span class="text-[9px] text-white font-sans mt-0.5">Linux • Win • Mac</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Bottom Description & Tech Stack -->
                        <div class="z-10 flex flex-col sm:flex-row sm:items-end justify-between gap-3">
                            <p class="text-xs text-[#a3a3a3] max-w-sm font-normal leading-relaxed">
                                Workbench utilitas developer &amp; teknisi IT all-in-one native berbasis Go dan GUI Fyne. Dilengkapi kalkulator subnetting &amp; CIDR, generator Cisco IOS, YouTube downloader, OCR, serta designer DDL database.
                            </p>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-mono text-[#878787] hidden sm:block">GO · FYNE · SQLITE</span>
                                <a href="{{ route('projects.show', ['slug' => 'it-toolbox', 'ref' => 'dark']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#1f1f1f] hover:bg-white hover:text-black text-xs font-mono text-[#f5f5f5] transition-all">
                                    <span>Detail Proyek</span>
                                    <span>→</span>
                                </a>
                            </div>
                        </div>

                        <!-- Hover Overlay with Direct Project Detail Redirection -->
                        <div class="absolute inset-0 bg-[#0a0a0a]/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300 backdrop-blur-md flex items-center justify-center p-6 z-20">
                            <a href="{{ route('projects.show', ['slug' => 'it-toolbox', 'ref' => 'dark']) }}" class="px-6 py-3 rounded-full bg-[#f5f5f5] text-[#0a0a0a] text-xs font-semibold inline-flex items-center gap-2 transform translate-y-3 group-hover:translate-y-0 transition-all shadow-xl hover:scale-105">
                                <span>Buka Detail &amp; Dokumentasi: <span class="font-display font-bold">IT Toolbox</span></span>
                                <span>→</span>
                            </a>
                        </div>
                    </div>

                    <!-- Card 2: VisualStyle Studio (Col Span 5) -->
                    <div class="md:col-span-5 bg-[#141414] border border-[#1f1f1f] rounded-3xl overflow-hidden relative group p-6 sm:p-8 min-h-[380px] flex flex-col justify-between transition-all hover:border-white/40">
                        <div class="absolute inset-0 bg-halftone opacity-15 pointer-events-none"></div>

                        <!-- Card Top Metadata -->
                        <div class="flex justify-between items-start z-10">
                            <div>
                                <span class="text-[11px] font-mono text-[#878787] uppercase tracking-wider">PROYEK 02 · FRONTEND CSS WORKBENCH</span>
                                <h3 class="text-2xl sm:text-3xl font-sans text-[#f5f5f5] font-semibold mt-1">VisualStyle Studio</h3>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-mono text-white border border-white/20 bg-white/5 font-semibold">STABLE</span>
                        </div>

                        <!-- Tech Stack Box (Arsitektur & Teknologi Pembuatan) -->
                        <div class="my-6 z-10 bg-[#0a0a0a] rounded-2xl border border-[#1f1f1f] p-4 sm:p-5 font-mono shadow-inner">
                            <div class="flex items-center justify-between pb-3 border-b border-[#1f1f1f] mb-3 text-[11px]">
                                <span class="flex items-center gap-2 text-white font-semibold tracking-wider uppercase">
                                    <span class="w-2 h-2 rounded-full bg-white"></span>
                                    <span>TECH STACK PEMBUATAN</span>
                                </span>
                                <span class="text-[10px] text-[#878787] uppercase">OFFLINE APP</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <div class="p-2.5 rounded-xl bg-[#141414] border border-[#1f1f1f] flex flex-col justify-between">
                                    <span class="text-[10px] text-[#878787] uppercase tracking-wider">RUNTIME</span>
                                    <span class="text-xs font-semibold text-[#f5f5f5] mt-1">Electron &bull; Node.js</span>
                                    <span class="text-[9px] text-white font-sans mt-0.5">Desktop IPC</span>
                                </div>
                                <div class="p-2.5 rounded-xl bg-[#141414] border border-[#1f1f1f] flex flex-col justify-between">
                                    <span class="text-[10px] text-[#878787] uppercase tracking-wider">ENGINE</span>
                                    <span class="text-xs font-semibold text-[#f5f5f5] mt-1">Vanilla DOM API</span>
                                    <span class="text-[9px] text-white/90 font-sans mt-0.5">Zero-Dependency</span>
                                </div>
                                <div class="p-2.5 rounded-xl bg-[#141414] border border-[#1f1f1f] flex flex-col justify-between">
                                    <span class="text-[10px] text-[#878787] uppercase tracking-wider">ANIMASI</span>
                                    <span class="text-xs font-semibold text-[#f5f5f5] mt-1">CSS3 Keyframes</span>
                                    <span class="text-[9px] text-zinc-400 font-sans mt-0.5">Cubic-Bezier 60 FPS</span>
                                </div>
                                <div class="p-2.5 rounded-xl bg-[#141414] border border-[#1f1f1f] flex flex-col justify-between">
                                    <span class="text-[10px] text-[#878787] uppercase tracking-wider">COLOR SYSTEM</span>
                                    <span class="text-xs font-semibold text-[#f5f5f5] mt-1">Tailwind Tokens</span>
                                    <span class="text-[9px] text-white font-sans mt-0.5">Color Harmonizer</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Bottom Description & Tech Stack -->
                        <div class="z-10 flex flex-col sm:flex-row sm:items-end justify-between gap-3">
                            <p class="text-xs text-[#a3a3a3] font-normal leading-relaxed">
                                Workbench visual styling &amp; animasi CSS desktop offline-first untuk inspeksi DOM real-time, live gradient tuner, dan peracikan tata letak cepat.
                            </p>
                            <a href="{{ route('projects.show', ['slug' => 'visualstyle-studio', 'ref' => 'dark']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#1f1f1f] hover:bg-white hover:text-black text-xs font-mono text-[#f5f5f5] transition-all shrink-0">
                                <span>Detail Proyek</span>
                                <span>→</span>
                            </a>
                        </div>

                        <!-- Hover Overlay with Direct Project Detail Redirection -->
                        <div class="absolute inset-0 bg-[#0a0a0a]/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300 backdrop-blur-md flex items-center justify-center p-6 z-20">
                            <a href="{{ route('projects.show', ['slug' => 'visualstyle-studio', 'ref' => 'dark']) }}" class="px-6 py-3 rounded-full bg-[#f5f5f5] text-[#0a0a0a] text-xs font-semibold inline-flex items-center gap-2 transform translate-y-3 group-hover:translate-y-0 transition-all shadow-xl hover:scale-105">
                                <span>Buka Detail &amp; Dokumentasi: <span class="font-display font-bold">VisualStyle</span></span>
                                <span>→</span>
                            </a>
                        </div>
                    </div>

                    <!-- Card 3: SakuKu (Col Span 12) -->
                    <div class="md:col-span-12 bg-[#141414] border border-[#1f1f1f] rounded-3xl overflow-hidden relative group p-6 sm:p-8 min-h-[380px] flex flex-col justify-between transition-all hover:border-white/40">
                        <div class="absolute inset-0 bg-halftone opacity-15 pointer-events-none"></div>

                        <!-- Card Top Metadata -->
                        <div class="flex justify-between items-start z-10 flex-wrap gap-3">
                            <div>
                                <span class="text-[11px] font-mono text-[#878787] uppercase tracking-wider">PROYEK 03 · FINTECH &amp; MULTIASSET TRACKER</span>
                                <h3 class="text-2xl sm:text-3xl font-sans text-[#f5f5f5] font-semibold mt-1">SakuKu</h3>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-mono text-white border border-white/20 bg-white/5 font-semibold">FLUTTER 3.X</span>
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-mono text-white border border-white/30 bg-white/10">100% OFFLINE</span>
                            </div>
                        </div>

                        <!-- Tech Stack Box (Arsitektur & Teknologi Pembuatan) -->
                        <div class="my-6 z-10 bg-[#0a0a0a] rounded-2xl border border-[#1f1f1f] p-4 sm:p-5 font-mono shadow-inner">
                            <div class="flex items-center justify-between pb-3 border-b border-[#1f1f1f] mb-3 text-[11px]">
                                <span class="flex items-center gap-2 text-white font-semibold tracking-wider uppercase">
                                    <span class="w-2 h-2 rounded-full bg-white"></span>
                                    <span>TECH STACK PEMBUATAN</span>
                                </span>
                                <span class="text-[10px] text-[#878787] uppercase">MOBILE FINTECH</span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                                <div class="p-3.5 rounded-xl bg-[#141414] border border-[#1f1f1f] flex flex-col justify-between">
                                    <div>
                                        <span class="text-[10px] text-[#878787] uppercase tracking-wider">FRONTEND &amp; INTI</span>
                                        <h4 class="text-sm font-semibold text-[#f5f5f5] mt-1">Flutter 3.x &bull; Dart</h4>
                                    </div>
                                    <p class="text-[11px] text-white font-sans mt-2 leading-relaxed">
                                        Multiplatform UI canvas dengan kompilasi native AOT (Ahead-of-Time) untuk animasi 120Hz bebas jank.
                                    </p>
                                </div>
                                <div class="p-3.5 rounded-xl bg-[#141414] border border-[#1f1f1f] flex flex-col justify-between">
                                    <div>
                                        <span class="text-[10px] text-[#878787] uppercase tracking-wider">DATABASE OFFLINE</span>
                                        <h4 class="text-sm font-semibold text-[#f5f5f5] mt-1">SQLite (sqflite)</h4>
                                    </div>
                                    <p class="text-[11px] text-white/90 font-sans mt-2 leading-relaxed">
                                        Penyimpanan lokal 100% offline-first dengan transaksi ACID penuh, enkripsi data, dan tanpa server cloud.
                                    </p>
                                </div>
                                <div class="p-3.5 rounded-xl bg-[#141414] border border-[#1f1f1f] flex flex-col justify-between">
                                    <div>
                                        <span class="text-[10px] text-[#878787] uppercase tracking-wider">UI &amp; ARSITEKTUR</span>
                                        <h4 class="text-sm font-semibold text-[#f5f5f5] mt-1">Neumorphism &bull; MVVM</h4>
                                    </div>
                                    <p class="text-[11px] text-white font-sans mt-2 leading-relaxed">
                                        Sistem desain shadow lembut berestetika tinggi dipadu pola arsitektur MVVM modular dan mudah diuji.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Card Bottom Description & Tech Stack -->
                        <div class="z-10 flex flex-col sm:flex-row sm:items-end justify-between gap-3">
                            <p class="text-xs text-[#a3a3a3] max-w-xl font-normal leading-relaxed">
                                Aplikasi pengelola keuangan pribadi, pencatatan hutang-piutang bertahap, dan pelacak portofolio investasi multiaset offline-first berbasis Flutter &amp; Dart dengan antarmuka Neumorphism Light yang elegan dan aman.
                            </p>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-mono text-[#878787] hidden sm:block">FLUTTER · DART · SQLITE</span>
                                <a href="{{ route('projects.show', ['slug' => 'sakuku', 'ref' => 'dark']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#1f1f1f] hover:bg-white hover:text-black text-xs font-mono text-[#f5f5f5] transition-all shrink-0">
                                    <span>Detail Proyek</span>
                                    <span>→</span>
                                </a>
                            </div>
                        </div>

                        <!-- Hover Overlay with Direct Project Detail Redirection -->
                        <div class="absolute inset-0 bg-[#0a0a0a]/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300 backdrop-blur-md flex items-center justify-center p-6 z-20">
                            <a href="{{ route('projects.show', ['slug' => 'sakuku', 'ref' => 'dark']) }}" class="px-6 py-3 rounded-full bg-[#f5f5f5] text-[#0a0a0a] text-xs font-semibold inline-flex items-center gap-2 transform translate-y-3 group-hover:translate-y-0 transition-all shadow-xl hover:scale-105">
                                <span>Buka Detail &amp; Dokumentasi: <span class="font-display font-bold">SakuKu</span></span>
                                <span>→</span>
                            </a>
                        </div>
                    </div>

                    <!-- Dynamic Extra Projects if Added to Database (Strictly excluding the top 3 authentic projects) -->
                    @php
                        $extraProjects = isset($featuredProjects) ? $featuredProjects->whereNotIn('slug', ['it-toolbox', 'visualstyle-studio', 'sakuku']) : collect();
                    @endphp
                    @if($extraProjects->isNotEmpty())
                        @foreach($extraProjects as $extraIndex => $extraProject)
                            <div class="md:col-span-6 bg-[#141414] border border-[#1f1f1f] rounded-3xl overflow-hidden relative group p-6 sm:p-8 min-h-[340px] flex flex-col justify-between transition-all hover:border-white/40">
                                <div class="absolute inset-0 bg-halftone opacity-15 pointer-events-none"></div>
                                <div class="flex justify-between items-start z-10">
                                    <div>
                                        <span class="text-[11px] font-mono text-[#878787] uppercase tracking-wider">PROYEK 0{{ $extraIndex + 4 }} · {{ strtoupper($extraProject->category ?? 'SOFTWARE') }}</span>
                                        <h3 class="text-2xl font-sans text-[#f5f5f5] font-semibold mt-1">{{ $extraProject->title }}</h3>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-mono text-white border border-white/30 bg-white/10">AKTIF</span>
                                </div>
                                <div class="my-4 z-10 bg-[#0a0a0a] rounded-2xl border border-[#1f1f1f] p-4 text-xs font-mono text-[#878787]">
                                    <p class="text-[#f5f5f5] truncate">{{ $extraProject->tools_used }}</p>
                                </div>
                                <div class="z-10 flex flex-col sm:flex-row sm:items-end justify-between gap-3">
                                    <p class="text-xs text-[#a3a3a3] line-clamp-2 max-w-sm font-normal leading-relaxed">
                                        {{ Str::limit(strip_tags($extraProject->description), 120) }}
                                    </p>
                                    <a href="{{ route('projects.show', ['slug' => $extraProject->slug, 'ref' => 'dark']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#1f1f1f] hover:bg-white hover:text-black text-xs font-mono text-[#f5f5f5] transition-all shrink-0">
                                        <span>Detail Proyek</span>
                                        <span>→</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 4: SKILLS & CERTIFICATIONS MATRIX  -->
        <!-- ========================================== -->
        <section id="skills" class="relative z-10 py-20 md:py-28 border-t border-white/5 bg-transparent">
            <!-- Backward compatibility anchor for #journal -->
            <span id="journal" class="sr-only"></span>

            <div class="max-w-[1200px] mx-auto px-6 md:px-10 lg:px-16">
                <!-- Section Header -->
                <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-12 space-y-3 sm:space-y-4">
                    <div class="inline-flex items-center gap-2 text-xs font-mono text-white uppercase tracking-wider font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                        <span>Penguasaan Perangkat &amp; Protokol</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-sans font-black uppercase text-[#f5f5f5] tracking-tight">
                        Matriks Kompetensi Kejuruan TKJ
                        <span class="sr-only">Skill Matrix</span>
                    </h2>
                    <p class="text-[#878787] text-sm sm:text-base leading-relaxed text-balance">
                        Tingkat penguasaan instrumen jaringan, sistem operasi server, dan perkakas diagnostik kejuruan dari basis data riil.
                    </p>
                </div>

                @if(isset($skills) && $skills->count() > 0)
                    <!-- Filter Pills with 44px Touch Targets -->
                    <div class="flex flex-wrap justify-center gap-2.5 mb-8 sm:mb-12" id="skill-filter-tabs">
                        <button type="button" data-filter="all" class="min-h-[44px] px-5 py-2.5 rounded-full bg-white text-black text-xs font-bold shadow-md transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white cursor-pointer flex items-center justify-center">Semua</button>
                        <button type="button" data-filter="networking" class="min-h-[44px] px-5 py-2.5 rounded-full bg-white/[0.05] border border-white/10 text-neutral-400 hover:text-white hover:bg-white/[0.1] text-xs font-semibold transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white cursor-pointer flex items-center justify-center">Networking</button>
                        <button type="button" data-filter="sysadmin" class="min-h-[44px] px-5 py-2.5 rounded-full bg-white/[0.05] border border-white/10 text-neutral-400 hover:text-white hover:bg-white/[0.1] text-xs font-semibold transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white cursor-pointer flex items-center justify-center">Sysadmin</button>
                        <button type="button" data-filter="hardware" class="min-h-[44px] px-5 py-2.5 rounded-full bg-white/[0.05] border border-white/10 text-neutral-400 hover:text-white hover:bg-white/[0.1] text-xs font-semibold transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white cursor-pointer flex items-center justify-center">Hardware</button>
                        <button type="button" data-filter="tools" class="min-h-[44px] px-5 py-2.5 rounded-full bg-white/[0.05] border border-white/10 text-neutral-400 hover:text-white hover:bg-white/[0.1] text-xs font-semibold transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white cursor-pointer flex items-center justify-center">Tools</button>
                    </div>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6" id="skills-grid">
                        @foreach($skills as $skill)
                            <div class="skill-card p-5 sm:p-6 rounded-3xl bg-[#141414] border border-[#1f1f1f] hover:border-white/60 transition-all duration-300 shadow-sm group" data-category="{{ $skill->category }}">
                                <div class="flex items-baseline justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                        <h3 class="text-[#f5f5f5] font-bold text-sm">{{ $skill->name }}</h3>
                                    </div>
                                    <span class="text-xs text-white font-mono font-bold">{{ $skill->level }}%</span>
                                </div>
                                <div class="w-full bg-[#1f1f1f] rounded-full h-2.5 overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-neutral-300 via-white to-neutral-200 rounded-full transition-all duration-700 shadow-[0_0_10px_rgba(255,255,255,0.4)]" style="width: {{ $skill->level }}%"></div>
                                </div>
                                <div class="mt-2.5 text-[10px] text-[#878787] font-mono uppercase tracking-wider font-semibold">
                                    {{ $skill->category }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-16 px-6 text-center rounded-3xl bg-[#141414] border border-[#1f1f1f] max-w-xl mx-auto">
                        <div class="w-12 h-12 mx-auto mb-4 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white font-mono text-sm font-bold">
                            [#]
                        </div>
                        <div class="text-[#f5f5f5] font-black uppercase text-base mb-1.5">Spesialisasi Kompetensi Sedang Dikurasi</div>
                        <p class="text-[#878787] text-xs leading-relaxed max-w-sm mx-auto">
                            Daftar kompetensi kejuruan dan matriks kemampuan teknis sedang diperbarui melalui Panel Admin.
                        </p>
                    </div>
                @endif

                <!-- ========================================== -->
                <!-- SUBSECTION: SERTIFIKASI KOMPETENSI RESMI   -->
                <!-- ========================================== -->
                <div class="mt-20 md:mt-28 pt-16 md:pt-20 border-t border-[#1f1f1f]">
                    <!-- Subheading -->
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 sm:mb-12">
                        <div>
                            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 text-xs font-mono text-white mb-3 font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                <span>Pengakuan &amp; Kredensial Resmi</span>
                            </div>
                            <h3 class="text-2xl sm:text-3xl lg:text-4xl font-sans font-black uppercase text-[#f5f5f5] tracking-tight">
                                Sertifikasi Kompetensi Terverifikasi
                            </h3>
                            <p class="text-xs sm:text-sm text-[#878787] mt-2 max-w-xl leading-relaxed text-balance">
                                Rekam jejak sertifikasi industri terakreditasi dari Cisco Networking Academy dan Kementerian Komunikasi dan Digital (Komdigi) dengan validasi QR &amp; TTE elektronik resmi.
                            </p>
                        </div>
                        <div class="flex items-center gap-2 px-3.5 py-2 rounded-full bg-white/5 border border-white/15 text-white text-xs font-mono shrink-0 self-start md:self-auto font-bold">
                            <span class="w-2 h-2 rounded-full bg-white"></span>
                            <span>Tervalidasi Resmi</span>
                        </div>
                    </div>

                    <!-- 3D Coverflow Gallery Showcase Component -->
                    <div class="relative rounded-3xl p-4 sm:p-7 lg:p-9 shadow-2xl overflow-hidden bg-[#111111] border border-[#1f1f1f]">
                        <!-- Background Subtle Ambient Glow -->
                        <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-96 h-96 rounded-full bg-gradient-to-b from-white/10 via-white/05 to-transparent blur-3xl pointer-events-none"></div>

                        <!-- Gallery Top Bar: Mode Indicator -->
                        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 mb-2 border-b border-[#1f1f1f]">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-white/5 border border-white/10 text-white">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </span>
                                <div>
                                    <div class="text-xs font-mono text-neutral-400">
                                        Galeri Sertifikat Kompetensi
                                    </div>
                                    <div class="text-sm font-bold text-[#f5f5f5]">
                                        Sertifikat <span id="cert-current-index" class="text-white font-bold font-mono">1</span> dari <span id="cert-total-count" class="text-neutral-400 font-mono">{{ isset($certificates) ? $certificates->count() : 0 }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/[0.05] border border-white/10 text-neutral-300 text-xs font-mono self-start sm:self-auto font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                <span>Putar Berkelanjutan</span>
                            </div>
                        </div>

                        <!-- 3D Swiper Carousel Container -->
                        <div class="cert-coverflow-wrapper">
                            <div class="swiper cert-coverflow-swiper">
                                <div class="swiper-wrapper">
                                    @forelse(($certificates ?? []) as $index => $cert)
                                        <div class="swiper-slide select-none">
                                            <div class="card-interactive p-5 sm:p-6 lg:p-7 flex flex-col justify-between h-full rounded-2xl relative group bg-[#161616] border border-[#262626] hover:border-white shadow-lg transition-all">
                                                <!-- Top Ambient Reflection -->
                                                <div class="absolute -top-12 -right-12 w-36 h-36 rounded-full bg-white/05 blur-2xl pointer-events-none group-hover:bg-white/10 transition-all"></div>

                                                <div>
                                                    <!-- Document Thumbnail with High-Res Lightbox Trigger -->
                                                    @if($cert->preview_image_url)
                                                        <div class="aspect-[16/11] bg-[#0d0d0e] border border-[#262626] rounded-xl overflow-hidden mb-4 sm:mb-5 relative group/preview cursor-pointer shadow-sm"
                                                             onclick="openCertModal('{{ $cert->preview_image_url }}', '{{ addslashes($cert->title) }}', '{{ addslashes($cert->issuer) }}', '{{ addslashes($cert->credential_id) }}', '{{ $cert->file_url }}', '{{ addslashes($cert->verification_status ?? '') }}')"
                                                             role="button" tabindex="0" aria-label="Lihat Pratinjau Sertifikat Asli {{ $cert->title }}">
                                                            <img src="{{ $cert->preview_image_url }}" alt="Dokumen Resmi {{ $cert->title }}" class="w-full h-full object-contain p-2.5 group-hover/preview:scale-[1.03] transition-transform duration-500" loading="lazy">
                                                            
                                                            <!-- Hover Action Overlay -->
                                                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-0 group-hover/preview:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-end pb-4 px-4 text-center">
                                                                <span class="px-4 py-2 rounded-full bg-white text-black text-xs font-bold shadow-lg flex items-center gap-1.5 transform translate-y-2 group-hover/preview:translate-y-0 transition-transform">
                                                                    <svg class="w-3.5 h-3.5 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                    </svg>
                                                                    <span>Lihat Resolusi Penuh</span>
                                                                </span>
                                                                <span class="text-[10px] text-neutral-400 font-mono mt-1">Klik untuk pratinjau modal</span>
                                                            </div>

                                                            <!-- Authentic Seal Pill -->
                                                            <div class="absolute top-2.5 right-2.5 px-2 py-0.5 rounded-full bg-black/80 border border-white/20 backdrop-blur-md text-[10px] font-mono text-white flex items-center gap-1 font-bold shadow-sm">
                                                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                                                <span>Dokumen Asli</span>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <!-- Issuer Badge & Issued Date -->
                                                    <div class="flex items-center justify-between gap-2 mb-2.5">
                                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-mono font-bold bg-white/10 border border-white/20 text-white">
                                                            {{ $cert->issuer }}
                                                        </span>
                                                        @if($cert->issued_date)
                                                            <span class="text-xs text-[#878787] font-mono">
                                                                {{ $cert->issued_date }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    
                                                    <!-- Certificate Title -->
                                                    <h4 class="text-base sm:text-lg font-bold text-[#f5f5f5] mb-2 leading-snug group-hover:text-white transition-colors line-clamp-2">
                                                        {{ $cert->title }}
                                                    </h4>
                                                    
                                                    <!-- Certificate Description -->
                                                    @if($cert->description)
                                                        <p class="text-[#878787] text-xs sm:text-sm leading-relaxed mb-4 line-clamp-3">
                                                            {{ $cert->description }}
                                                        </p>
                                                    @endif
                                                </div>

                                                <!-- Card Footer: Credential Meta & Interactive CTAs -->
                                                <div class="pt-3.5 border-t border-[#262626] flex flex-col gap-2.5 text-[11px] text-[#878787] font-mono">
                                                    @if($cert->credential_id)
                                                        <div class="truncate text-neutral-400 font-mono">
                                                            ID: {{ $cert->credential_id }}
                                                        </div>
                                                    @endif

                                                    <div class="flex items-center justify-between">
                                                        <div class="text-white flex items-center gap-1.5 font-semibold text-xs">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                                            <span>{{ $cert->verification_status ?? 'Terverifikasi Resmi' }} {{ $cert->duration_hours ? '• ' . $cert->duration_hours : '' }}</span>
                                                        </div>
                                                    </div>

                                                    <!-- Actions with 44px Touch Targets -->
                                                    <div class="flex items-center gap-2 pt-1">
                                                        @if($cert->preview_image_url)
                                                            <button type="button"
                                                                    onclick="openCertModal('{{ $cert->preview_image_url }}', '{{ addslashes($cert->title) }}', '{{ addslashes($cert->issuer) }}', '{{ addslashes($cert->credential_id) }}', '{{ $cert->file_url }}', '{{ addslashes($cert->verification_status ?? '') }}')"
                                                                    class="flex-1 min-h-[44px] py-2 px-3 rounded-full bg-white/[0.06] hover:bg-white/[0.12] border border-white/10 text-xs text-[#f5f5f5] font-bold transition-all text-center flex items-center justify-center gap-1.5 cursor-pointer">
                                                                <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                </svg>
                                                                <span>Lihat Detail</span>
                                                            </button>
                                                        @endif

                                                        @if($cert->file_path)
                                                            <a href="{{ $cert->file_url }}" target="_blank" rel="noopener noreferrer"
                                                               class="flex-1 min-h-[44px] py-2 px-3 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 text-xs text-white font-bold transition-all text-center flex items-center justify-center gap-1.5 shadow-sm">
                                                                <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                                </svg>
                                                                <span>PDF Asli &nearr;</span>
                                                            </a>
                                                        @elseif($cert->credential_url)
                                                            <a href="{{ $cert->credential_url }}" target="_blank" rel="noopener noreferrer"
                                                               class="flex-1 min-h-[44px] py-2 px-3 rounded-full bg-white/[0.06] hover:bg-white/[0.12] border border-white/10 text-xs text-neutral-300 font-bold transition-all text-center flex items-center justify-center gap-1.5 shadow-sm">
                                                                <span>Verifikasi &nearr;</span>
                                                            </a>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="w-full py-16 text-center text-[#878787] font-mono text-sm border border-[#1f1f1f] rounded-3xl bg-[#141414]">
                                            Belum ada data sertifikasi yang dipublikasikan.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Navigation & Pagination Controls Bar -->
                        <div class="relative z-10 flex items-center justify-center gap-4 sm:gap-6 pt-2 pb-2">
                            <button type="button"
                                    class="cert-nav-btn cert-coverflow-prev p-2.5 rounded-full bg-[#1a1a1a] border border-[#2a2a2a] text-white hover:bg-white hover:text-black hover:border-white transition-all shadow-sm"
                                    aria-label="Sertifikat Sebelumnya"
                                    title="Sertifikat Sebelumnya">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            <!-- Dot Pagination Bullets in between -->
                            <div class="swiper-pagination cert-coverflow-pagination !m-0 !w-auto"></div>

                            <button type="button"
                                    class="cert-nav-btn cert-coverflow-next p-2.5 rounded-full bg-[#1a1a1a] border border-[#2a2a2a] text-white hover:bg-white hover:text-black hover:border-white transition-all shadow-sm"
                                    aria-label="Sertifikat Berikutnya"
                                    title="Sertifikat Berikutnya">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>

                        <!-- Footer Swipe Hint -->
                        <div class="relative z-10 pt-3 text-center border-t border-[#1f1f1f]">
                            <p class="text-[11px] font-mono text-[#878787] flex items-center justify-center gap-2">
                                <span class="inline-block w-1.5 h-1.5 rounded-full bg-white"></span>
                                <span>Geser kartu atau gunakan tombol panah untuk rotasi 3D. Klik kartu untuk membuka dokumen penuh.</span>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 5: VISUAL PLAYGROUND (TEKNOLOGI PEMBUATAN WEB) -->
        <!-- ========================================== -->
        <section id="technologies" class="relative z-10 bg-transparent border-t border-white/5 overflow-hidden min-h-[820px] lg:min-h-[920px] flex items-center justify-center pt-32 pb-24 sm:py-24 px-4 sm:px-8 select-none">
            <!-- Hidden anchor for backwards compatibility -->
            <span id="explorations" class="absolute -top-24 pointer-events-none"></span>

            <!-- Subtle background matrix dots & radial ambient optic aura -->
            <div class="absolute inset-0 bg-[radial-gradient(#1f1f1f_1px,transparent_1px)] [background-size:32px_32px] opacity-35 pointer-events-none"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[500px] bg-white/5 rounded-full blur-[140px] pointer-events-none"></div>

            <!-- Optical Grid Axis Guides -->
            <div class="absolute inset-x-0 top-1/2 h-px bg-gradient-to-r from-transparent via-[#1f1f1f]/60 to-transparent pointer-events-none"></div>
            <div class="absolute inset-y-0 left-1/2 w-px bg-gradient-to-b from-transparent via-[#1f1f1f]/60 to-transparent pointer-events-none"></div>

            @include('partials.tech-flow-columns')

            <!-- Center Content (Anchor Layer) -->
            <div id="playground-center-anchor" class="relative z-20 max-w-md mx-auto text-center px-16 sm:px-20 lg:px-4">
                
                <!-- Subhead: EKSPLORASI TEKNOLOGI -->
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#141414] border border-[#1f1f1f] text-[11px] font-mono text-[#878787] uppercase tracking-[0.3em] mb-4 shadow-lg">
                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                    <span>EKSPLORASI TEKNOLOGI</span>
                </div>

                <!-- Main Headline: TEKNOLOGI Pembuatan Web -->
                <h2 class="text-4xl sm:text-5xl md:text-6xl font-sans font-extrabold text-[#f5f5f5] tracking-tight leading-[1.1] mb-5">
                    TEKNOLOGI <span class="font-display font-bold text-[#f5f5f5]">Pembuatan Web</span>
                </h2>

                <!-- Short Description -->
                <p class="text-xs sm:text-sm md:text-base text-[#878787] font-light leading-relaxed mb-8 max-w-md mx-auto">
                    Eksplorasi ekosistem teknologi modern yang menjadi fondasi arsitektur website ini, dirancang untuk kecepatan kompilasi kilat, animasi 60 FPS bebas jank, dan keandalan baremetal tingkat enterprise.
                </p>

                <!-- Action Links -->
                <div class="flex flex-wrap items-center justify-center gap-3">
                    <a href="https://dribbble.com" target="_blank" rel="noopener noreferrer" class="group relative inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#141414] border border-[#1f1f1f] hover:border-white/50 text-xs font-mono text-[#f5f5f5] transition-all duration-300 shadow-xl hover:shadow-[0_0_25px_rgba(255,255,255,0.1)] hover:scale-105">
                        <span>Lihat di Dribbble</span>
                        <span class="text-white group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform duration-200">↗</span>
                    </a>
                    
                    <a href="#skills" class="group inline-flex items-center gap-2 px-4 py-2.5 rounded-full text-xs font-mono text-[#878787] hover:text-[#f5f5f5] transition-colors">
                        <span>Matriks Keahlian</span>
                        <span class="text-white group-hover:translate-x-1 transition-transform duration-200">→</span>
                    </a>
                </div>

            </div>

        </section>

        <!-- ========================================== -->
        <!-- INTERACTIVE TELEMETRY MODAL (FOUR BOUNDARY STATES) -->
        <!-- ========================================== -->
        <div id="tech-modal-overlay" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-200" role="dialog" aria-modal="true" aria-labelledby="modal-tech-title">
            <div id="tech-modal-card" class="relative w-full max-w-2xl bg-[#141414] border border-[#1f1f1f] rounded-3xl shadow-[0_25px_70px_rgba(0,0,0,0.95)] p-6 sm:p-8 transform scale-95 transition-all duration-200 backdrop-blur-xl overflow-hidden">
                
                <!-- Ambient Glow inside Modal Header -->
                <div id="modal-glow" class="absolute -top-24 -left-24 w-60 h-60 rounded-full blur-3xl opacity-20 pointer-events-none"></div>

                <!-- 1. LOADING SKELETON STATE (AetherCraft Directive 4) -->
                <div id="modal-skeleton" class="hidden animate-pulse space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-[#1f1f1f]"></div>
                        <div class="space-y-2 flex-1">
                            <div class="h-5 w-40 bg-[#1f1f1f] rounded"></div>
                            <div class="h-3 w-28 bg-[#1f1f1f] rounded"></div>
                        </div>
                    </div>
                    <div class="h-24 bg-[#1f1f1f] rounded-xl"></div>
                    <div class="h-24 bg-[#1f1f1f] rounded-xl"></div>
                    <div class="h-16 bg-[#1f1f1f] rounded-xl"></div>
                </div>

                <!-- 2. ERROR BOUNDARY + RETRY STATE (AetherCraft Directive 4) -->
                <div id="modal-error" class="hidden p-6 rounded-2xl bg-red-950/20 border border-red-800/40 text-center space-y-3 font-mono">
                    <p class="text-sm text-red-400">Gagal memuat telemetri spesifikasi teknologi.</p>
                    <button type="button" id="modal-retry-btn" class="px-4 py-2 rounded-full bg-red-900/40 hover:bg-red-900/60 text-xs text-red-200 transition-colors border border-red-700/50">
                        Muat Ulang Telemetri
                    </button>
                </div>

                <!-- 3. SUCCESS / ACTIVE CONTENT VIEW -->
                <div id="modal-content" class="relative z-10 space-y-6">
                    
                    <!-- Modal Header -->
                    <div class="flex items-start justify-between pb-6 border-b border-[#1f1f1f]">
                        <div class="flex items-center gap-4">
                            <div id="modal-icon-badge" class="w-14 h-14 rounded-2xl bg-[#0a0a0a] border border-[#1f1f1f] p-3 flex items-center justify-center shrink-0 shadow-inner">
                                <div id="modal-icon-slot"></div>
                            </div>
                            <div>
                                <div class="flex items-center gap-2.5 flex-wrap">
                                    <h3 id="modal-tech-title" class="text-xl sm:text-2xl font-sans font-semibold text-[#f5f5f5]">Teknologi</h3>
                                    <span id="modal-badge-slot" class="font-mono text-[10px] tracking-wider uppercase px-2 py-0.5 rounded bg-[#1f1f1f] text-white border border-[#1f1f1f] font-semibold">[ROLE]</span>
                                </div>
                                <p id="modal-tech-subhead" class="text-xs font-mono text-[#878787] mt-1 font-light">Komponen Arsitektur Sistem</p>
                            </div>
                        </div>

                        <!-- Close Actions -->
                        <div class="flex items-center gap-2">
                            <span class="hidden sm:inline-block font-mono text-[11px] text-[#878787] px-2 py-1 rounded bg-[#0a0a0a] border border-[#1f1f1f]">ESC</span>
                            <button type="button" id="modal-close-btn" class="w-9 h-9 rounded-full bg-[#1f1f1f]/80 hover:bg-[#1f1f1f] border border-[#1f1f1f] text-[#878787] hover:text-[#f5f5f5] flex items-center justify-center transition-colors cursor-pointer" aria-label="Tutup jendela telemetri">
                                <span class="text-base font-bold leading-none">✕</span>
                            </button>
                        </div>
                    </div>

                    <!-- Panel 1: Penjelasan Tentang Teknologi -->
                    <div class="rounded-2xl bg-[#0a0a0a] border border-[#1f1f1f] p-4 sm:p-5">
                        <div class="flex items-center gap-2 text-xs font-mono text-[#878787] mb-2 uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            <span class="text-[#f5f5f5] font-semibold">1. Penjelasan Teknologi</span>
                        </div>
                        <p id="modal-explanation-slot" class="text-xs sm:text-sm text-[#878787] leading-relaxed font-light">
                            Deskripsi fungsi dasar teknologi dalam ekosistem web modern.
                        </p>
                    </div>

                    <!-- Panel 2: Alasan Digunakan Pada Web Ini -->
                    <div class="rounded-2xl bg-[#0a0a0a] border border-[#1f1f1f] p-4 sm:p-5">
                        <div class="flex items-center gap-2 text-xs font-mono text-[#878787] mb-2 uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            <span class="text-[#f5f5f5] font-semibold">2. Alasan Digunakan Pada Website Ini</span>
                        </div>
                        <p id="modal-rationale-slot" class="text-xs sm:text-sm text-[#878787] leading-relaxed font-light">
                            Justifikasi teknis mengapa teknologi ini menjadi pilihan utama arsitektur portofolio.
                        </p>
                    </div>

                    <!-- Panel 3: Runtime Telemetry & Benchmark Specs -->
                    <div class="rounded-2xl bg-[#0e0e0e] border border-[#1f1f1f] p-4 sm:p-5 font-mono">
                        <div class="flex items-center justify-between border-b border-[#1f1f1f] pb-2 mb-3 text-[11px] text-[#878787]">
                            <span class="flex items-center gap-1.5 text-white">
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                <span>3. SPESIFIKASI RUNTIME &amp; BENCHMARK</span>
                            </span>
                            <span class="text-[10px] text-[#4D4D4D]">LIVE CONFIG</span>
                        </div>
                        <div id="modal-specs-grid" class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 text-xs">
                            <!-- Injected dynamically -->
                        </div>
                    </div>

                    <!-- Modal Footer & Feedback Toast -->
                    <div class="pt-2 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-[11px] font-mono border-t border-[#1f1f1f]/50">
                        <div id="modal-status-feedback" class="flex items-center gap-1.5 text-white">
                            <span class="text-white">✓</span>
                            <span id="modal-status-text">Telemetri siap diperiksa</span>
                        </div>
                        <button type="button" id="modal-dismiss-btn" class="text-[#878787] hover:text-[#f5f5f5] transition-colors self-end sm:self-auto cursor-pointer">
                            Tutup Panel [ESC]
                        </button>
                    </div>

                </div>

            </div>
        </div>

        <!-- ========================================== -->
        <!-- SECTION 6: STATS                           -->
        <!-- ========================================== -->
        <section id="stats" class="relative z-10 py-20 md:py-28 border-t border-white/5 bg-transparent">
            <div class="max-w-[1200px] mx-auto px-6 md:px-10 lg:px-16">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
                    <!-- Stat 1 -->
                    <div class="p-8 rounded-3xl bg-[#141414] border border-[#1f1f1f] flex flex-col justify-between">
                        <span class="text-xs font-mono text-[#878787] uppercase tracking-wider">PENGAKUAN RESMI</span>
                        <div class="my-6">
                            <span class="font-display font-black text-6xl md:text-8xl text-[#f5f5f5] leading-none">5+</span>
                        </div>
                        <div>
                            <h4 class="text-base font-sans font-semibold text-[#f5f5f5]">Sertifikasi Cisco &amp; Komdigi</h4>
                            <p class="text-xs text-[#878787] mt-1 font-light">Kredensial resmi mencakup Cisco NetAcad Enterprise Networking dan Komdigi CyberOps Associate.</p>
                        </div>
                    </div>

                    <!-- Stat 2 -->
                    <div class="p-8 rounded-3xl bg-[#141414] border border-[#1f1f1f] flex flex-col justify-between">
                        <span class="text-xs font-mono text-[#878787] uppercase tracking-wider">PORTOFOLIO SOFTWARE</span>
                        <div class="my-6">
                            <span class="font-display font-black text-6xl md:text-8xl text-[#f5f5f5] leading-none">{{ $projectsCount ?? \App\Models\Project::count() }}</span>
                        </div>
                        <div>
                            <h4 class="text-base font-sans font-semibold text-[#f5f5f5]">Proyek Software Mandiri</h4>
                            <p class="text-xs text-[#878787] mt-1 font-light">Koleksi software desktop native (Go, Electron), mobile fintech (Flutter), dan utilitas developer yang dikembangkan secara mandiri.</p>
                        </div>
                    </div>

                    <!-- Stat 3 -->
                    <div class="p-8 rounded-3xl bg-[#141414] border border-[#1f1f1f] flex flex-col justify-between">
                        <span class="text-xs font-mono text-[#878787] uppercase tracking-wider">UPTIME BAREMETAL</span>
                        <div class="my-6">
                            <span class="font-display font-black text-6xl md:text-8xl text-[#f5f5f5] leading-none">100%</span>
                        </div>
                        <div>
                            <h4 class="text-base font-sans font-semibold text-[#f5f5f5]">SLA Server Mandiri</h4>
                            <p class="text-xs text-[#878787] mt-1 font-light">Menjaga zero unscheduled downtime pada seluruh layanan server fisik Debian GNU/Linux.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 7: CONTACT / FOOTER                -->
        <!-- ========================================== -->
        <footer id="contact" class="relative z-10 bg-transparent pt-20 md:pt-28 pb-12 overflow-hidden border-t border-white/5">
            <!-- Background Video: Flipped Vertically (scale-y-[-1]) -->
            <video id="footer-hls-video" autoplay muted loop playsinline class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 min-w-full min-h-full object-cover scale-y-[-1] opacity-15 pointer-events-none"></video>
            <div class="absolute inset-0 bg-black/60 pointer-events-none"></div>

            <!-- GSAP Marquee Ticker -->
            <div class="relative z-10 overflow-hidden whitespace-nowrap border-y border-[#1f1f1f] py-4 bg-[#141414]/60 backdrop-blur-md mb-16">
                <div id="footer-marquee-track" class="inline-block whitespace-nowrap will-change-transform">
                    <span class="text-xs sm:text-sm font-mono tracking-[0.25em] text-[#878787]">
                        MEMBANGUN MASA DEPAN • PRESISI ROUTING PAKET • KEANDALAN BAREMETAL • ZERO PACKET LOSS • KETAHANAN SISTEM • MECHANICAL SYMPATHY • INFRASTRUKTUR TEKNOLOGI • MEMBANGUN MASA DEPAN • PRESISI ROUTING PAKET • KEANDALAN BAREMETAL • ZERO PACKET LOSS • KETAHANAN SISTEM • MECHANICAL SYMPATHY • INFRASTRUKTUR TEKNOLOGI • 
                    </span>
                    <span class="text-xs sm:text-sm font-mono tracking-[0.25em] text-[#878787]">
                        MEMBANGUN MASA DEPAN • PRESISI ROUTING PAKET • KEANDALAN BAREMETAL • ZERO PACKET LOSS • KETAHANAN SISTEM • MECHANICAL SYMPATHY • INFRASTRUKTUR TEKNOLOGI • MEMBANGUN MASA DEPAN • PRESISI ROUTING PAKET • KEANDALAN BAREMETAL • ZERO PACKET LOSS • KETAHANAN SISTEM • MECHANICAL SYMPATHY • INFRASTRUKTUR TEKNOLOGI • 
                    </span>
                </div>
            </div>

            <!-- Main Contact Container -->
            <div class="relative z-10 max-w-[1200px] mx-auto px-6 md:px-10 lg:px-16 mb-16">
                <div class="grid lg:grid-cols-12 gap-10 lg:gap-14 items-start">
                    
                    <!-- Left Info with Direct Contact Data -->
                    <div class="lg:col-span-5 space-y-6">
                        <div class="inline-flex items-center gap-2 text-xs font-mono text-white uppercase tracking-wider font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            <span>Hubungi Langsung</span>
                        </div>
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black uppercase text-[#f5f5f5] tracking-tight leading-[1.1]">
                            Mulai Diskusi <span class="text-white">Lab Jaringan.</span>
                        </h2>
                        <p class="text-[#878787] text-sm sm:text-base leading-relaxed text-balance">
                            Tertarik berdiskusi seputar lab arsitektur jaringan, kolaborasi proyek, pengujian performa server LEMP, atau tawaran magang kejuruan? Hubungi saya secara langsung melalui kontak di bawah ini.
                        </p>

                        <!-- User Contact Credentials Cluster -->
                        <div class="pt-2 sm:pt-4 space-y-3 sm:space-y-4 font-mono text-xs">
                            <!-- Status -->
                            <div class="flex items-center gap-3 text-[#878787]">
                                <span class="w-2.5 h-2.5 rounded-full bg-white shrink-0 shadow-[0_0_8px_rgba(255,255,255,0.6)]"></span>
                                <span>Status: Siap Magang &amp; Kolaborasi Riset</span>
                            </div>

                            <!-- Location -->
                            <div class="flex items-center gap-3 text-[#878787]">
                                <span class="w-2.5 h-2.5 rounded-full bg-white shrink-0 shadow-[0_0_8px_rgba(255,255,255,0.5)]"></span>
                                <span>Lokasi: Denpasar, Bali, Indonesia</span>
                            </div>

                            <!-- Email -->
                            <a href="mailto:yuda2010f@gmail.com" class="min-h-[52px] flex items-center gap-3.5 p-4 rounded-2xl bg-[#141414]/90 border border-[#1f1f1f] text-[#f5f5f5] hover:border-white hover:bg-[#1a1a1a] transition-all group shadow-sm">
                                <div class="w-10 h-10 rounded-xl bg-[#1a1a1a] border border-[#2a2a2a] flex items-center justify-center text-white group-hover:scale-105 transition-all shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="flex flex-col truncate min-w-0">
                                    <span class="text-[10px] text-[#878787] uppercase tracking-wider font-bold font-mono">Email Utama</span>
                                    <span class="text-xs font-bold text-white truncate font-mono">yuda2010f@gmail.com</span>
                                </div>
                            </a>

                            <!-- Phone / WhatsApp -->
                            <a href="https://wa.me/6285182691268" target="_blank" rel="noopener noreferrer" class="min-h-[52px] flex items-center gap-3.5 p-4 rounded-2xl bg-[#141414]/90 border border-[#1f1f1f] text-[#f5f5f5] hover:border-white hover:bg-[#1a1a1a] transition-all group shadow-sm">
                                <div class="w-10 h-10 rounded-xl bg-[#1a1a1a] border border-[#2a2a2a] flex items-center justify-center text-white group-hover:scale-105 transition-all shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div class="flex flex-col truncate min-w-0">
                                    <span class="text-[10px] text-[#878787] uppercase tracking-wider font-bold font-mono">No. Telepon / WhatsApp</span>
                                    <span class="text-xs font-bold text-white group-hover:text-stone-300 truncate font-mono">085182691268</span>
                                </div>
                            </a>

                            <!-- GitHub -->
                            <a href="https://github.com/Great-YUDZZ" target="_blank" rel="noopener noreferrer" class="min-h-[52px] flex items-center gap-3.5 p-4 rounded-2xl bg-[#141414]/90 border border-[#1f1f1f] text-[#f5f5f5] hover:border-white hover:bg-[#1a1a1a] transition-all group shadow-sm">
                                <div class="w-10 h-10 rounded-xl bg-[#1a1a1a] border border-[#2a2a2a] flex items-center justify-center text-[#f5f5f5] group-hover:scale-105 transition-all shrink-0">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                                    </svg>
                                </div>
                                <div class="flex flex-col truncate min-w-0">
                                    <span class="text-[10px] text-[#878787] uppercase tracking-wider font-bold font-mono">GitHub Profile</span>
                                    <span class="text-xs font-bold text-[#f5f5f5] group-hover:text-white truncate font-mono">github.com/Great-YUDZZ</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Right Contact Form -->
                    <div class="lg:col-span-7">
                        <div class="p-6 sm:p-8 md:p-10 rounded-3xl bg-[#141414]/90 border border-[#1f1f1f] shadow-2xl relative backdrop-blur-xl">
                            <div class="absolute -top-10 -right-10 w-44 h-44 rounded-full bg-white/05 blur-3xl pointer-events-none"></div>

                            @if(session('success'))
                                <div class="mb-6 p-4 rounded-2xl bg-white/10 border border-white/20 text-white text-xs font-mono flex items-center gap-2.5">
                                    <span class="w-2 h-2 rounded-full bg-white shrink-0 animate-pulse"></span>
                                    <span>{{ session('success') }}</span>
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="mb-6 p-4 rounded-2xl bg-stone-900 border border-stone-700 text-stone-200 text-xs font-mono space-y-1">
                                    <div class="flex items-center gap-2 font-bold text-white">
                                        <span class="w-2 h-2 rounded-full bg-white"></span>
                                        <span>Terdapat kendala pada isian formulir:</span>
                                    </div>
                                    <ul class="list-disc list-inside pl-4 text-[11px] text-stone-300 space-y-0.5">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form id="dark-contact-form" action="{{ route('contact.submit') }}" method="POST" class="space-y-5 sm:space-y-6">
                                @csrf
                                <div class="grid sm:grid-cols-2 gap-4 sm:gap-6">
                                    <div>
                                        <label for="sender_name" class="block text-xs font-mono text-[#878787] font-bold uppercase tracking-wider mb-2">Nama Lengkap</label>
                                        <input type="text" name="sender_name" id="sender_name" value="{{ old('sender_name') }}" required
                                            placeholder="Nama Lengkap / Instansi"
                                            class="w-full px-4 py-3.5 rounded-2xl bg-[#0a0a0a] border border-[#262626] text-[#f5f5f5] placeholder-[#555] focus:bg-[#111111] focus:border-white focus:ring-2 focus:ring-white/20 outline-none transition-all font-sans text-sm">
                                    </div>
                                    <div>
                                        <label for="email" class="block text-xs font-mono text-[#878787] font-bold uppercase tracking-wider mb-2">Alamat Email</label>
                                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                            placeholder="nama@domain.com"
                                            class="w-full px-4 py-3.5 rounded-2xl bg-[#0a0a0a] border border-[#262626] text-[#f5f5f5] placeholder-[#555] focus:bg-[#111111] focus:border-white focus:ring-2 focus:ring-white/20 outline-none transition-all font-sans text-sm">
                                    </div>
                                </div>

                                <div>
                                    <label for="subject" class="block text-xs font-mono text-[#878787] font-bold uppercase tracking-wider mb-2">Subjek Pesan</label>
                                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                                        placeholder="Topik diskusi lab atau tawaran proyek..."
                                        class="w-full px-4 py-3.5 rounded-2xl bg-[#0a0a0a] border border-[#262626] text-[#f5f5f5] placeholder-[#555] focus:bg-[#111111] focus:border-white focus:ring-2 focus:ring-white/20 outline-none transition-all font-sans text-sm">
                                </div>

                                <div>
                                    <label for="message" class="block text-xs font-mono text-[#878787] font-bold uppercase tracking-wider mb-2">Isi Pesan</label>
                                    <textarea name="message" id="message" rows="4" required
                                        placeholder="Tuliskan pesan atau pertanyaan Anda di sini..."
                                        class="w-full px-4 py-3.5 rounded-2xl bg-[#0a0a0a] border border-[#262626] text-[#f5f5f5] placeholder-[#555] focus:bg-[#111111] focus:border-white focus:ring-2 focus:ring-white/20 outline-none transition-all resize-none font-sans text-sm">{{ old('message') }}</textarea>
                                </div>

                                <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-between gap-4 pt-2">
                                    <span class="text-[11px] font-mono text-[#878787] text-center sm:text-left flex items-center justify-center sm:justify-start gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-white/70 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                        <span>Pesan terkirim ke inbox terenkripsi</span>
                                    </span>
                                    <button type="submit" id="dark-submit-btn" class="w-full sm:w-auto min-h-[48px] justify-center text-sm font-bold uppercase tracking-wider px-8 flex items-center gap-2 rounded-2xl bg-white text-black hover:bg-neutral-200 hover:shadow-lg hover:shadow-white/20 transition-all font-mono">
                                        <span id="dark-btn-label">Kirim Pesan</span>
                                        <span id="dark-btn-icon">&rarr;</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Footer Bar -->
                <div class="flex flex-col md:flex-row items-center justify-between gap-6 pt-8 border-t border-[#1f1f1f]/50 text-xs text-[#878787]">
                    <!-- Left: Identity -->
                    <div class="flex items-center gap-3">
                        <span class="font-display font-bold text-lg text-[#f5f5f5] tracking-tight">I Made Yuda Pramana</span>
                        <span class="text-[#4D4D4D] font-mono">/</span>
                        <span class="font-mono text-[11px]">SMKN 1 Denpasar</span>
                    </div>

                    <!-- Center: Social Links -->
                    <div class="flex flex-wrap items-center justify-center gap-6 font-mono text-xs">
                        <a href="https://github.com/Great-YUDZZ" target="_blank" rel="noopener noreferrer" class="hover:text-[#f5f5f5] transition-colors">GitHub</a>
                        <a href="mailto:yuda2010f@gmail.com" class="hover:text-[#f5f5f5] transition-colors">Email</a>
                        <a href="{{ route('archive.classic') }}" class="hover:text-white transition-colors">Arsip Klasik</a>
                        <a href="{{ route('ai.index') }}" class="hover:text-white transition-colors">Yuna AI</a>
                        <a href="{{ route('blog.index') }}" class="hover:text-white transition-colors">Blog Pribadi</a>
                    </div>

                    <!-- Right: Live Status Badge -->
                    <div class="flex items-center gap-2 font-mono text-[11px]">
                        <span class="w-2 h-2 rounded-full bg-white shadow-[0_0_8px_rgba(255,255,255,0.4)]"></span>
                        <span class="text-[#f5f5f5]">TERSEDIA UNTUK PROYEK &amp; KERJASAMA</span>
                    </div>
                </div>

                <div class="text-center md:text-left mt-8 text-[11px] font-mono text-[#4D4D4D]">
                    © 2026 I Made Yuda Pramana. Direkayasa dengan mechanical sympathy di atas Debian GNU/Linux.
                </div>
            </div>
        </footer>

    </div>

    <!-- INTERACTIVE CERTIFICATE LIGHTBOX MODAL -->
    <div id="cert-modal" class="fixed inset-0 z-50 bg-black/85 backdrop-blur-xl hidden items-center justify-center p-3 sm:p-6" role="dialog" aria-modal="true" aria-labelledby="modal-cert-title" onclick="closeCertModal()">
        <div class="cert-modal-card relative w-full max-w-4xl max-h-[92vh] border border-[#1f1f1f] rounded-3xl overflow-hidden shadow-2xl bg-[#111111] text-[#f5f5f5] flex flex-col" onclick="event.stopPropagation()">
            <!-- Modal Header Bar -->
            <div class="p-4 sm:p-5 border-b border-[#1f1f1f] flex items-center justify-between bg-white/[0.02] backdrop-blur-md">
                <div class="flex items-center gap-2.5 sm:gap-3 truncate pr-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-white shrink-0"></span>
                    <div class="truncate">
                        <h3 id="modal-cert-title" class="text-base sm:text-lg font-bold text-[#f5f5f5] truncate">Pratinjau Sertifikat Asli</h3>
                        <p id="modal-cert-issuer" class="text-[11px] sm:text-xs text-[#878787] font-mono truncate">Penerbit Resmi</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <a id="modal-cert-pdf-link" href="#" target="_blank" rel="noopener noreferrer" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 text-xs font-bold text-white transition-all shadow-md">
                        <span>Buka PDF Asli</span>
                        <span>&nearr;</span>
                    </a>
                    <button type="button" onclick="closeCertModal()" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/[0.06] hover:bg-white/[0.12] text-neutral-300 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white cursor-pointer" aria-label="Tutup pratinjau">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Document Viewer Body -->
            <div class="p-3 sm:p-6 overflow-y-auto flex-1 flex items-center justify-center bg-black/60">
                <img id="modal-cert-image" src="" alt="Pratinjau Berkas Asli" class="max-w-full max-h-[50vh] sm:max-h-[65vh] object-contain rounded-2xl border border-white/10 shadow-md">
            </div>

            <!-- Modal Footer Bar -->
            <div class="p-4 border-t border-[#1f1f1f] bg-white/[0.02] backdrop-blur-md flex flex-col sm:flex-row items-center justify-between gap-3 text-xs font-mono text-[#878787]">
                <div class="flex items-center gap-2 text-[#878787] text-center sm:text-left">
                    <span class="text-white flex items-center gap-1.5 font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                        <span id="modal-cert-status">Terverifikasi Resmi</span>
                    </span>
                    <span class="text-neutral-600">/</span>
                    <span id="modal-cert-id" class="text-neutral-300 truncate max-w-xs">No: -</span>
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <a id="modal-cert-pdf-link-mobile" href="#" target="_blank" rel="noopener noreferrer" class="w-full sm:hidden min-h-[44px] py-2.5 px-4 flex items-center justify-center text-center rounded-full bg-white/10 hover:bg-white/20 border border-white/20 font-bold text-xs text-white">
                        Buka File PDF Asli &nearr;
                    </a>
                    <button type="button" onclick="closeCertModal()" class="hidden sm:inline-flex py-2 px-5 rounded-full bg-white/[0.06] hover:bg-white/[0.12] text-neutral-300 transition-colors cursor-pointer font-bold">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Form Interactive State Handler -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('dark-contact-form');
            const submitBtn = document.getElementById('dark-submit-btn');
            const btnLabel = document.getElementById('dark-btn-label');
            const btnIcon = document.getElementById('dark-btn-icon');

            if (form && submitBtn) {
                form.addEventListener('submit', function() {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                    if (btnLabel) btnLabel.textContent = 'MENGIRIMKAN...';
                    if (btnIcon) {
                        btnIcon.innerHTML = `<svg class="animate-spin h-3.5 w-3.5 text-[#0a0a0a]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>`;
                    }
                });
            }
        });
    </script>
</body>
</html>
