@extends('layouts.app')

@section('content')
<!-- SECTION 1: HERO SECTION (#home) - Technical Slate Dark -->
<section id="home" class="w-full bg-[#0F172A] pt-6 sm:pt-10 md:pt-16 pb-16 sm:pb-20 md:pb-28 relative border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 grid lg:grid-cols-12 gap-8 lg:gap-8 items-center">
            
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 space-y-6 sm:space-y-7 relative z-10">
                
                <!-- Eyebrow Pill Badge -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-emerald-500/30 bg-emerald-950/60 text-[11px] sm:text-xs font-mono text-emerald-400 shadow-xs max-w-full">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="tracking-wide text-emerald-300 font-semibold truncate sm:whitespace-normal">TEKNIK KOMPUTER &amp; JARINGAN / SMKN 1 DENPASAR</span>
                </div>

                <!-- Hero Main Headline -->
                <h1 class="text-3xl xs:text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight text-white leading-[1.1] text-balance">
                    NETWORK &amp; <br class="hidden sm:inline">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-sky-400 to-teal-300">INFRASTRUCTURE</span>
                </h1>

                <!-- Hero Description -->
                <p class="text-sm sm:text-base md:text-lg text-slate-300 max-w-[50ch] leading-relaxed text-balance">
                    Halo, saya <span class="text-white font-semibold">I Made Yuda Pramana</span>. Siswa Teknik Komputer &amp; Jaringan yang berfokus pada switching &amp; routing Cisco, administrasi baremetal server Debian LEMP, dan implementasi infrastruktur jaringan terstruktur.
                </p>

                <!-- CTA Actions & Social Cluster -->
                <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                    <a href="#certifications" class="btn-primary group w-full sm:w-auto text-center justify-center">
                        <span>Lihat Sertifikasi Resmi</span>
                        <span class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center text-xs group-hover:translate-x-0.5 transition-transform">&rarr;</span>
                    </a>
                    <a href="#labs" class="inline-flex items-center justify-center min-h-[44px] px-5 py-2.5 rounded-full bg-slate-800/90 border border-slate-700 text-slate-200 hover:text-white hover:bg-slate-700 hover:border-slate-600 text-xs sm:text-sm font-semibold transition-all duration-200 shadow-xs active:scale-[0.98] w-full sm:w-auto text-center">
                        Eksplorasi Lab
                    </a>

                    <!-- Social Glass Cluster with Direct Contact Info -->
                    <div class="flex items-center justify-center sm:justify-start gap-2 pt-1 sm:pt-0 sm:pl-2">
                        <!-- GitHub -->
                        <a href="https://github.com/Great-YUDZZ" target="_blank" rel="noopener noreferrer" class="p-2.5 rounded-full bg-slate-800/80 border border-slate-700 text-slate-400 hover:text-white hover:border-slate-500 hover:bg-slate-700 transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500" aria-label="GitHub Great-YUDZZ" title="GitHub: Great-YUDZZ">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                            </svg>
                        </a>

                        <!-- Email -->
                        <a href="mailto:yuda2010f@gmail.com" class="p-2.5 rounded-full bg-slate-800/80 border border-slate-700 text-slate-400 hover:text-white hover:border-slate-500 hover:bg-slate-700 transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500" aria-label="Email yuda2010f@gmail.com" title="Email: yuda2010f@gmail.com">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </a>

                        <!-- WhatsApp / Phone -->
                        <a href="https://wa.me/6285182691268" target="_blank" rel="noopener noreferrer" class="p-2.5 rounded-full bg-slate-800/80 border border-slate-700 text-slate-400 hover:text-teal-300 hover:border-teal-500 hover:bg-slate-700 transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-teal-500" aria-label="WhatsApp 085182691268" title="WhatsApp: 085182691268">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Grounded Engineering Metrics -->
                <div class="pt-2 sm:pt-4 grid grid-cols-2 gap-3 sm:gap-4 max-w-md">
                    <div class="p-3.5 sm:p-4 rounded-2xl glass-panel-dark-interactive">
                        <div class="flex items-baseline justify-between">
                            <span class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight text-white font-mono">5</span>
                            <span class="text-emerald-400 text-xs font-mono font-semibold">Resmi</span>
                        </div>
                        <div class="text-[11px] sm:text-xs text-slate-300 mt-1 font-medium leading-tight">Sertifikasi Cisco NetAcad &amp; Komdigi</div>
                    </div>

                    <div class="p-3.5 sm:p-4 rounded-2xl glass-panel-dark-interactive">
                        <div class="flex items-baseline justify-between">
                            <span class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight text-white font-mono">4+</span>
                            <span class="text-sky-400 text-xs font-mono font-semibold">Lab</span>
                        </div>
                        <div class="text-[11px] sm:text-xs text-slate-300 mt-1 font-medium leading-tight">Topologi Jaringan Enterprise &amp; LEMP</div>
                    </div>
                </div>

            </div>

            <!-- Right Hero Visual (Real-Time Terminal / Neofetch) -->
            <div class="lg:col-span-5 relative">
                <!-- Ambient Glow behind Terminal -->
                <div class="absolute -inset-2 bg-gradient-to-r from-blue-600/15 via-teal-600/10 to-blue-500/10 rounded-3xl blur-2xl opacity-70 pointer-events-none"></div>

                <div class="w-full max-w-lg mx-auto lg:max-w-none rounded-2xl overflow-hidden glass-panel-dark shadow-2xl font-mono text-xs sm:text-sm relative z-10" id="neofetch-console">
                    <!-- Window Header -->
                    <div class="flex items-center justify-between px-4 py-2.5 bg-slate-950/50 backdrop-blur-md border-b border-white/10">
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 rounded-full bg-[#ff5f56] inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-[#ffbd2e] inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-[#27c93f] inline-block"></span>
                        </div>
                        <span class="text-slate-400 text-xs select-none">yuda@yudz: ~</span>
                        <div class="w-10"></div>
                    </div>

                    <!-- Terminal Content -->
                    <div class="p-4 sm:p-5 space-y-3 text-slate-300 leading-relaxed overflow-x-auto text-xs sm:text-sm">
                        <div>
                            <span class="text-emerald-400 font-semibold">yuda@yudz</span>:<span class="text-sky-400">~</span>$ neofetch
                        </div>

                        <div class="space-y-1 text-slate-300 pl-2 border-l-2 border-amber-500">
                            <p><span class="text-white font-bold">OS:</span> Debian GNU/Linux 13 (Trixie)</p>
                            <p><span class="text-white font-bold">Host:</span> yudz</p>
                            <p><span class="text-white font-bold">Kernel:</span> Linux 6.12-amd64</p>
                            <p><span class="text-white font-bold">DE:</span> GNOME (Wayland)</p>
                            <p><span class="text-white font-bold">CPU:</span> AMD Ryzen 5 6600H</p>
                            <p><span class="text-white font-bold">Memory:</span> 16GB</p>
                            <p><span class="text-white font-bold">Stack:</span> Nginx 1.26, MariaDB, PHP 8.4-FPM</p>
                        </div>

                        <div class="pt-2">
                            <span class="text-emerald-400 font-semibold">yuda@yudz</span>:<span class="text-sky-400">~</span>$ 
                            <span class="inline-block w-2 h-4 ml-1 align-middle bg-amber-500 animate-pulse"></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <!-- SECTION 2: ABOUT & STATS GRID (#about) - Soft Slate -->
    <section id="about" class="w-full bg-[#F1F5F9] py-16 sm:py-24 md:py-32 border-y border-slate-200/80 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 items-center mb-12 sm:mb-16">
                <!-- Left: Technical Identity & Engineering Profile Card -->
                <div class="lg:col-span-5 reveal-slide-left">
                    <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden glass-panel-interactive p-5 sm:p-7 lg:p-8 space-y-5 sm:space-y-6 hover:border-blue-300 transition-all group">
                        <!-- Ambient Glow behind Card -->
                        <div class="absolute -inset-1 bg-gradient-to-tr from-blue-600/10 via-transparent to-teal-500/5 blur-xl opacity-60 pointer-events-none"></div>

                        <!-- Header Avatar & Bio -->
                        <div class="relative z-10 flex items-center gap-4 border-b border-slate-100 pb-5 sm:pb-6">
                            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-teal-600 flex items-center justify-center text-white text-lg sm:text-xl font-bold tracking-wider shadow-md shadow-blue-500/20 font-mono shrink-0">
                                YP
                            </div>
                            <div class="min-w-0">
                                <div class="text-[11px] sm:text-xs font-mono text-blue-600 mb-1 flex items-center gap-1.5 truncate font-semibold">
                                    <span class="truncate">PROFIL &amp; DEDIKASI TEKNIK</span>
                                </div>
                                <div class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight truncate">I Made Yuda Pramana</div>
                                <div class="text-xs text-slate-500 mt-0.5 truncate">Teknik Komputer &amp; Jaringan / SMKN 1 Denpasar</div>
                            </div>
                        </div>

                        <!-- Telemetry & Credential Specs -->
                        <div class="relative z-10 space-y-2.5 sm:space-y-3 text-xs font-mono">
                            <div class="p-3 sm:p-3.5 rounded-xl glass-pill bg-slate-50/80 border-slate-200 flex flex-col xs:flex-row xs:items-center justify-between gap-1">
                                <span class="text-slate-500">STATUS:</span>
                                <span class="text-emerald-600 font-semibold flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    SIAP KERJA &amp; MAGANG
                                </span>
                            </div>
                            <div class="p-3 sm:p-3.5 rounded-xl glass-pill bg-slate-50/80 border-slate-200 flex flex-col xs:flex-row xs:items-center justify-between gap-1">
                                <span class="text-slate-500">SPESIALISASI:</span>
                                <span class="text-slate-900 font-semibold">Network &amp; Systems Engineering</span>
                            </div>
                            <div class="p-3 sm:p-3.5 rounded-xl glass-pill bg-slate-50/80 border-slate-200 flex flex-col xs:flex-row xs:items-center justify-between gap-1">
                                <span class="text-slate-500">HARDWARE / STACK:</span>
                                <span class="text-blue-600 font-semibold">Cisco IOS, Linux Debian, LEMP</span>
                            </div>
                            <div class="p-3 sm:p-3.5 rounded-xl glass-pill bg-slate-50/80 border-slate-200 flex flex-col xs:flex-row xs:items-center justify-between gap-1">
                                <span class="text-slate-500">LOKASI:</span>
                                <span class="text-slate-700">Denpasar, Bali, Indonesia</span>
                            </div>
                        </div>

                        <!-- Terminal Footer Badge -->
                        <div class="relative z-10 pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Tersertifikasi Cisco &amp; KOMDIGI
                            </span>
                            <span class="text-slate-400 font-mono text-[11px]">BSrE / Cisco NetAcad</span>
                        </div>
                    </div>
                </div>

                <!-- Right Editorial Description -->
                <div class="lg:col-span-7 space-y-6 sm:space-y-8 reveal-slide-right">
                    <div class="space-y-3 sm:space-y-4">
                        <div class="inline-flex items-center gap-2 text-xs font-mono text-blue-600 uppercase tracking-wider font-semibold">
                            <span>Dedikasi Pada Keandalan Infrastruktur</span>
                        </div>
                        <h2 class="text-2xl sm:text-4xl lg:text-5xl font-bold text-slate-900 tracking-tight leading-[1.15]">
                            Keahlian Teruji di Balik Setiap <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-sky-600 to-teal-600">Topologi.</span>
                        </h2>
                    </div>

                    <div class="space-y-4 sm:space-y-5 text-slate-600 text-sm sm:text-base lg:text-lg leading-relaxed text-balance">
                        <p>
                            Sebagai siswa jurusan <span class="text-slate-900 font-semibold">Teknik Komputer dan Jaringan</span>, fokus saya tertuju pada perancangan sistem yang tahan banting di dunia nyata, mulai dari konfigurasi switch layer 2/3 Cisco Catalyst, keamanan jaringan, hingga administrasi server Linux Debian mandiri.
                        </p>
                        <p>
                            Saya terbiasa memecahkan bottleneck latensi, mengamankan perimeter jaringan dari unauthorized access, serta mengotomatisasi deployment web server berarsitektur LEMP berkinerja tinggi.
                        </p>
                    </div>

                    <div class="pt-2 flex flex-wrap items-center gap-2.5 sm:gap-4 text-xs font-mono text-slate-600">
                        <div class="px-3.5 py-1.5 rounded-full glass-pill flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Denpasar, Bali, Indonesia</span>
                        </div>
                        <div class="px-3.5 py-1.5 rounded-full glass-pill border-blue-200 text-blue-700 bg-blue-50/60 flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-blue-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Tersertifikasi Resmi Cisco &amp; KOMDIGI</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STATS GRID -->
            <div class="mt-10 sm:mt-14">
                <div class="flex items-center gap-3 mb-6 sm:mb-8">
                    <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-slate-900 tracking-tight">Metrik &amp; Kredensial Portofolio</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    
                    <!-- Stat Card 1: Metric Graph -->
                    <div class="p-5 sm:p-6 rounded-2xl sm:rounded-3xl glass-panel-interactive hover:border-blue-300 transition-all duration-300 flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="h-20 w-full relative flex items-center justify-center overflow-hidden">
                                <svg class="w-full h-full" viewBox="0 0 180 60" fill="none">
                                    <path d="M5 45 Q 45 40 85 28 T 140 18 T 175 10" stroke="rgba(37, 99, 235, 0.2)" stroke-width="2" stroke-dasharray="3 3"/>
                                    <path d="M5 45 Q 45 40 85 28 T 140 18 T 175 10" stroke="#2563eb" stroke-width="2.5"/>
                                    <circle cx="85" cy="28" r="4.5" fill="#2563eb" class="animate-pulse"/>
                                    <circle cx="85" cy="28" r="9" stroke="#2563eb" stroke-opacity="0.3" stroke-width="1.5"/>
                                </svg>
                            </div>
                            <div class="text-xs text-slate-500 font-mono">Total Proyek Lab &amp; Topologi</div>
                        </div>
                        <div class="pt-4 border-t border-slate-100">
                            <div class="text-3xl sm:text-4xl font-bold text-slate-900 font-mono flex items-baseline gap-1">
                                <span data-counter="{{ $stats['total_projects'] }}">{{ $stats['total_projects'] }}</span>
                                <span class="text-blue-600 text-2xl font-bold">+</span>
                            </div>
                        </div>
                    </div>

                    <!-- Stat Card 2: Domain Keahlian -->
                    <div class="p-5 sm:p-6 rounded-2xl sm:rounded-3xl glass-panel-interactive hover:border-blue-300 transition-all duration-300 flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="space-y-1.5 py-1">
                                <div class="px-3 py-1 rounded-lg bg-slate-50 border border-slate-200 text-[10px] font-mono text-slate-600 flex items-center justify-between">
                                    <span>Networking</span>
                                    <span class="text-blue-600 font-semibold">Routing/Switching</span>
                                </div>
                                <div class="px-3 py-1 rounded-lg bg-blue-50/60 border border-blue-200 text-[10px] font-mono text-blue-700 flex items-center justify-between">
                                    <span>Sysadmin</span>
                                    <span class="text-blue-600 font-semibold">Linux LEMP</span>
                                </div>
                                <div class="px-3 py-1 rounded-lg bg-teal-50 border border-teal-200 text-[10px] font-mono text-teal-800 flex items-center justify-between font-bold">
                                    <span>Core Infrastructure</span>
                                    <span class="text-teal-600">Security</span>
                                </div>
                            </div>
                            <div class="text-xs text-slate-500 font-mono">Domain Keahlian</div>
                        </div>
                        <div class="pt-4 border-t border-slate-100">
                            <div class="text-3xl sm:text-4xl font-bold text-slate-900 font-mono flex items-baseline gap-1">
                                <span>4</span>
                                <span class="text-blue-600 text-xl font-bold font-sans">Tiers</span>
                            </div>
                        </div>
                    </div>

                    <!-- Stat Card 3: Kompetensi Teruji -->
                    <div class="p-5 sm:p-6 rounded-2xl sm:rounded-3xl glass-panel-interactive hover:border-blue-300 transition-all duration-300 flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="h-16 flex items-center">
                                <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-200 flex items-center justify-center text-blue-600">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-xs text-slate-500 font-mono">Kompetensi Teruji (Skill Matrix)</div>
                        </div>
                        <div class="pt-4 border-t border-slate-100">
                            <div class="text-3xl sm:text-4xl font-bold text-slate-900 font-mono flex items-baseline gap-1">
                                <span data-counter="{{ $stats['total_skills'] }}">{{ $stats['total_skills'] }}</span>
                                <span class="text-blue-600 text-2xl font-bold">+</span>
                            </div>
                        </div>
                    </div>

                    <!-- Stat Card 4: Kredensial Resmi -->
                    <div class="p-5 sm:p-6 rounded-2xl sm:rounded-3xl glass-panel-interactive hover:border-blue-300 transition-all duration-300 flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="h-16 flex items-center">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-600">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-xs text-slate-500 font-mono">Sertifikasi &amp; Kredensial Resmi</div>
                        </div>
                        <div class="pt-4 border-t border-slate-100">
                            <div class="text-3xl sm:text-4xl font-bold text-slate-900 font-mono flex items-baseline gap-1">
                                <span data-counter="{{ $stats['total_certificates'] ?? count($certificates) }}">{{ $stats['total_certificates'] ?? count($certificates) }}</span>
                                <span class="text-emerald-600 text-xl font-bold">Kredensial</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>


    <!-- SECTION 3: SERTIFIKASI RESMI & KREDENSIAL KOMDIGI (#certifications) - Technical Slate Dark -->
    <section id="certifications" class="w-full bg-[#0F172A] py-16 sm:py-20 md:py-28 relative border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8 sm:mb-10">
                <div class="space-y-3 max-w-2xl">
                    <div class="inline-flex items-center gap-2 text-xs font-mono text-sky-400 uppercase tracking-wider font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>
                        <span>Kredensial &amp; Standarisasi Resmi</span>
                    </div>
                    <h2 class="text-2xl sm:text-4xl lg:text-5xl font-bold text-white tracking-tight">
                        Sertifikasi Kejuruan &amp; Pelatihan Resmi
                    </h2>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed text-balance">
                        Kredensial resmi sertifikasi jaringan internasional dari Cisco Networking Academy dan pelatihan kejuruan Komdigi RI. Geser kartu 3D atau gunakan tombol navigasi untuk meninjau berkas asli.
                    </p>
                </div>

                <div class="shrink-0 flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-950/80 border border-emerald-500/40 text-emerald-400 text-xs font-mono self-start md:self-auto font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Kredensial Resmi Terverifikasi</span>
                </div>
            </div>

            <!-- 3D Coverflow Gallery Showcase Component -->
            <div class="relative rounded-3xl p-4 sm:p-7 lg:p-9 shadow-2xl overflow-hidden glass-panel-dark">
                <!-- Background Ambient Glow -->
                <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-96 h-96 rounded-full bg-gradient-to-b from-blue-600/20 via-teal-500/10 to-transparent blur-3xl pointer-events-none"></div>

                <!-- Gallery Top Bar: Mode Indicator -->
                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 mb-2 border-b border-slate-800">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-950/80 border border-blue-500/30 text-blue-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </span>
                        <div>
                            <div class="text-xs font-mono text-slate-400">
                                Galeri Sertifikat Kompetensi
                            </div>
                            <div class="text-sm font-semibold text-white">
                                Sertifikat <span id="cert-current-index" class="text-sky-400 font-bold font-mono">1</span> dari <span id="cert-total-count" class="text-slate-400 font-mono">{{ $certificates->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-800/80 border border-slate-700 text-slate-300 text-xs font-mono self-start sm:self-auto">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                        <span>Putar Berkelanjutan</span>
                    </div>
                </div>

                <!-- 3D Swiper Carousel Container -->
                <div class="cert-coverflow-wrapper">
                    <div class="swiper cert-coverflow-swiper">
                        <div class="swiper-wrapper">
                            @forelse($certificates as $index => $cert)
                                <div class="swiper-slide select-none">
                                    <div class="card-interactive p-5 sm:p-6 lg:p-7 flex flex-col justify-between h-full rounded-2xl relative group glass-panel-dark-interactive hover:border-blue-500/50">
                                        <!-- Top Ambient Reflection -->
                                        <div class="absolute -top-12 -right-12 w-36 h-36 rounded-full bg-blue-600/10 blur-2xl pointer-events-none group-hover:bg-blue-600/20 transition-all"></div>

                                        <div>
                                            <!-- Document Thumbnail with High-Res Lightbox Trigger -->
                                            @if($cert->preview_image_url)
                                                <div class="aspect-[16/11] bg-slate-950 border border-slate-800 rounded-xl overflow-hidden mb-4 sm:mb-5 relative group/preview cursor-pointer shadow-md shadow-slate-950/40"
                                                     onclick="openCertModal('{{ $cert->preview_image_url }}', '{{ addslashes($cert->title) }}', '{{ addslashes($cert->issuer) }}', '{{ addslashes($cert->credential_id) }}', '{{ $cert->file_url }}', '{{ addslashes($cert->verification_status ?? '') }}')"
                                                     role="button" tabindex="0" aria-label="Lihat Pratinjau Sertifikat Asli {{ $cert->title }}">
                                                    <img src="{{ $cert->preview_image_url }}" alt="Dokumen Resmi {{ $cert->title }}" class="w-full h-full object-contain p-2.5 group-hover/preview:scale-[1.03] transition-transform duration-500" loading="lazy">
                                                    
                                                    <!-- Hover Action Overlay -->
                                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-slate-950/40 to-transparent opacity-0 group-hover/preview:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-end pb-4 px-4 text-center">
                                                        <span class="px-3.5 py-1.5 rounded-full bg-blue-600 text-white text-xs font-semibold shadow-lg shadow-blue-600/40 flex items-center gap-1.5 transform translate-y-2 group-hover/preview:translate-y-0 transition-transform">
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                            <span>Lihat Resolusi Penuh</span>
                                                        </span>
                                                        <span class="text-[10px] text-slate-300 font-mono mt-1">Klik untuk pratinjau modal</span>
                                                    </div>

                                                    <!-- Authentic Seal Pill -->
                                                    <div class="absolute top-2.5 right-2.5 px-2 py-0.5 rounded-full bg-slate-950/85 border border-emerald-500/40 backdrop-blur-md text-[10px] font-mono text-emerald-400 flex items-center gap-1">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                                        <span>Dokumen Asli</span>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Issuer Badge & Issued Date -->
                                            <div class="flex items-center justify-between gap-2 mb-2.5">
                                                <span class="inline-flex items-center gap-1.5 text-xs font-mono font-bold text-sky-300 bg-blue-950/80 border border-blue-500/30 px-2.5 py-0.5 rounded-full">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>
                                                    {{ $cert->issuer }}
                                                </span>
                                                @if($cert->issued_date)
                                                    <span class="text-xs text-slate-400 font-mono">
                                                        {{ $cert->issued_date }}
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <!-- Certificate Title -->
                                            <h3 class="text-base sm:text-lg font-bold text-white mb-2 leading-snug group-hover:text-sky-400 transition-colors line-clamp-2">
                                                {{ $cert->title }}
                                            </h3>
                                            
                                            <!-- Certificate Description -->
                                            @if($cert->description)
                                                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed mb-4 line-clamp-3">
                                                    {{ $cert->description }}
                                                </p>
                                            @endif
                                        </div>

                                        <!-- Card Footer: Credential Meta & Interactive CTAs -->
                                        <div class="pt-3.5 border-t border-slate-800 flex flex-col gap-2.5 text-[11px] text-slate-400 font-mono">
                                            @if($cert->credential_id)
                                                <div class="truncate text-slate-400 font-mono">
                                                    ID: {{ $cert->credential_id }}
                                                </div>
                                            @endif

                                            <div class="flex items-center justify-between">
                                                <div class="text-emerald-400 flex items-center gap-1.5 font-semibold text-xs">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                                    <span>{{ $cert->verification_status ?? 'Terverifikasi Resmi' }} {{ $cert->duration_hours ? '• ' . $cert->duration_hours : '' }}</span>
                                                </div>
                                            </div>

                                            <!-- Actions with 44px Touch Targets -->
                                            <div class="flex items-center gap-2 pt-1">
                                                @if($cert->preview_image_url)
                                                    <button type="button"
                                                            onclick="openCertModal('{{ $cert->preview_image_url }}', '{{ addslashes($cert->title) }}', '{{ addslashes($cert->issuer) }}', '{{ addslashes($cert->credential_id) }}', '{{ $cert->file_url }}', '{{ addslashes($cert->verification_status ?? '') }}')"
                                                            class="flex-1 min-h-[44px] py-2 px-3 rounded-full bg-slate-800/90 hover:bg-slate-700 border border-slate-700 hover:border-slate-600 text-xs text-slate-200 hover:text-white font-medium transition-all text-center flex items-center justify-center gap-1.5 cursor-pointer">
                                                        <svg class="w-3.5 h-3.5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                        <span>Lihat Detail</span>
                                                    </button>
                                                @endif

                                                @if($cert->file_path)
                                                    <a href="{{ $cert->file_url }}" target="_blank" rel="noopener noreferrer"
                                                       class="flex-1 min-h-[44px] py-2 px-3 rounded-full bg-blue-600 hover:bg-blue-500 text-white font-semibold transition-all text-center flex items-center justify-center gap-1.5 shadow-md shadow-blue-600/30 hover:shadow-lg hover:shadow-blue-600/40">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                        </svg>
                                                        <span>PDF Asli &nearr;</span>
                                                    </a>
                                                @elseif($cert->credential_url)
                                                    <a href="{{ $cert->credential_url }}" target="_blank" rel="noopener noreferrer"
                                                       class="flex-1 min-h-[44px] py-2 px-3 rounded-full bg-blue-600 hover:bg-blue-500 text-white font-semibold transition-all text-center flex items-center justify-center gap-1.5 shadow-md shadow-blue-600/30">
                                                        <span>Verifikasi &nearr;</span>
                                                    </a>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="w-full py-16 text-center text-slate-400 font-mono text-sm border border-slate-800 rounded-3xl bg-slate-900">
                                    Belum ada data sertifikasi yang dipublikasikan.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Bottom Navigation & Pagination Controls Bar -->
                <div class="relative z-10 flex items-center justify-center gap-4 sm:gap-6 pt-2 pb-2">
                    <button type="button"
                            class="cert-nav-btn cert-coverflow-prev"
                            aria-label="Sertifikat Sebelumnya"
                            title="Sertifikat Sebelumnya">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <!-- Dot Pagination Bullets in between -->
                    <div class="swiper-pagination cert-coverflow-pagination !m-0 !w-auto"></div>

                    <button type="button"
                            class="cert-nav-btn cert-coverflow-next"
                            aria-label="Sertifikat Berikutnya"
                            title="Sertifikat Berikutnya">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <!-- Footer Swipe Hint -->
                <div class="relative z-10 pt-3 text-center border-t border-slate-800">
                    <p class="text-[11px] font-mono text-slate-400 flex items-center justify-center gap-2">
                        <span class="inline-block w-1.5 h-1.5 rounded-full bg-sky-400 animate-ping"></span>
                        <span>Geser kartu atau gunakan tombol panah untuk rotasi 3D. Klik kartu untuk membuka dokumen penuh.</span>
                    </p>
                </div>
            </div>

        </div>
    </section>


    <!-- SECTION 4: SHOWCASE LAB & PROYEK (#labs) - Soft Slate -->
    <section id="labs" class="w-full bg-[#F1F5F9] py-16 sm:py-24 md:py-32 border-y border-slate-200/80 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-14 space-y-3 sm:space-y-4">
                <div class="inline-flex items-center gap-2 text-xs font-mono text-blue-600 uppercase tracking-wider font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                    <span>Arsitektur Topologi &amp; Implementasi</span>
                </div>
                <h2 class="text-2xl sm:text-4xl lg:text-5xl font-bold text-slate-900 tracking-tight">
                    Showcase Lab &amp; Proyek Unggulan
                </h2>
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed text-balance">
                    Dokumentasi proyek dan topologi jaringan nyata, konfigurasi perangkat jaringan Cisco, serta deployment server Linux LEMP mandiri.
                </p>
            </div>

            @if($featuredProjects->count() > 0)
                <div class="grid sm:grid-cols-2 gap-6 sm:gap-8">
                    @foreach($featuredProjects as $project)
                        <a href="{{ route('projects.show', $project->slug) }}" class="card-interactive group block p-5 sm:p-7 lg:p-8 glass-panel-interactive hover:border-blue-300">
                            <div class="aspect-[16/10] bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden mb-5 sm:mb-6 flex items-center justify-center p-4 sm:p-6 relative">
                                <div class="absolute inset-0 bg-gradient-to-tr from-blue-600/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500 ease-out">
                            </div>
                            
                            <div class="flex items-center justify-between gap-3 mb-3">
                                <span class="px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-[11px] font-mono font-semibold text-blue-700">
                                    {{ $project->category }}
                                </span>
                                <span class="text-xs text-slate-500 font-mono">
                                    {{ $project->created_at->format('M Y') }}
                                </span>
                            </div>

                            <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition-colors">
                                {{ $project->title }}
                            </h3>

                            <p class="text-slate-600 text-xs sm:text-sm line-clamp-2 leading-relaxed mb-4">
                                {{ Str::limit(strip_tags($project->description), 120) }}
                            </p>

                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-slate-600 group-hover:text-blue-600 transition-colors">
                                <span>Buka Spesifikasi Lab</span>
                                <span class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center group-hover:translate-x-1 group-hover:bg-blue-600 group-hover:text-white transition-all">&rarr;</span>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="text-center mt-10 sm:mt-12">
                    <a href="{{ route('projects.index') }}" class="btn-ghost w-full sm:w-auto inline-flex items-center justify-center gap-2 text-xs font-semibold min-h-[44px]">
                        <span>Buka Semua Lab di Katalog Lengkap</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            @else
                <div class="py-16 px-6 text-center rounded-3xl bg-white border border-slate-200 shadow-sm max-w-xl mx-auto">
                    <div class="w-12 h-12 mx-auto mb-4 rounded-2xl bg-blue-50 border border-blue-200 flex items-center justify-center text-blue-600 font-mono text-base font-bold">
                        &lt;/&gt;
                    </div>
                    <div class="text-slate-900 font-bold text-base mb-1.5">Dokumentasi Lab Sedang Disiapkan</div>
                    <p class="text-slate-500 text-xs leading-relaxed max-w-sm mx-auto">
                        Topologi arsitektur jaringan dan konfigurasi lab server sedang dalam tahap pengujian mandiri.
                    </p>
                </div>
            @endif

        </div>
    </section>


    <!-- SECTION 5: SKILL MATRIX (#skills) - Technical Slate Dark -->
    <section id="skills" class="w-full bg-[#0F172A] py-16 sm:py-24 md:py-32 relative border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-12 space-y-3 sm:space-y-4">
                <div class="inline-flex items-center gap-2 text-xs font-mono text-sky-400 uppercase tracking-wider font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>
                    <span>Penguasaan Perangkat &amp; Protokol</span>
                </div>
                <h2 class="text-2xl sm:text-4xl lg:text-5xl font-bold text-white tracking-tight">
                    Matriks Kompetensi Kejuruan TKJ
                </h2>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed text-balance">
                    Tingkat penguasaan instrumen jaringan, sistem operasi server, dan perkakas diagnostik kejuruan.
                </p>
            </div>

            <!-- Filter Pills with 44px Touch Targets -->
            <div class="flex flex-wrap justify-center gap-2 mb-8 sm:mb-10" id="skill-filter-tabs">
                <button type="button" data-filter="all" class="min-h-[44px] px-5 py-2.5 rounded-full bg-blue-600 text-white text-xs font-semibold shadow-lg shadow-blue-600/30 transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 cursor-pointer flex items-center justify-center">Semua</button>
                <button type="button" data-filter="networking" class="min-h-[44px] px-5 py-2.5 rounded-full bg-slate-900/60 backdrop-blur-md border border-white/10 text-slate-300 hover:text-white hover:bg-slate-800/80 text-xs font-medium transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 cursor-pointer flex items-center justify-center">Networking</button>
                <button type="button" data-filter="sysadmin" class="min-h-[44px] px-5 py-2.5 rounded-full bg-slate-900/60 backdrop-blur-md border border-white/10 text-slate-300 hover:text-white hover:bg-slate-800/80 text-xs font-medium transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 cursor-pointer flex items-center justify-center">Sysadmin</button>
                <button type="button" data-filter="hardware" class="min-h-[44px] px-5 py-2.5 rounded-full bg-slate-900/60 backdrop-blur-md border border-white/10 text-slate-300 hover:text-white hover:bg-slate-800/80 text-xs font-medium transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 cursor-pointer flex items-center justify-center">Hardware</button>
                <button type="button" data-filter="tools" class="min-h-[44px] px-5 py-2.5 rounded-full bg-slate-900/60 backdrop-blur-md border border-white/10 text-slate-300 hover:text-white hover:bg-slate-800/80 text-xs font-medium transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 cursor-pointer flex items-center justify-center">Tools</button>
            </div>

            @if($skills->count() > 0)
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6" id="skills-grid">
                    @foreach($skills as $skill)
                        <div class="skill-card p-4 sm:p-5 rounded-2xl glass-panel-dark-interactive hover:border-blue-500/50 transition-all duration-300 shadow-xl" data-category="{{ $skill->category }}">
                            <div class="flex items-baseline justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>
                                    <h3 class="text-white font-semibold text-sm">{{ $skill->name }}</h3>
                                </div>
                                <span class="text-xs text-sky-400 font-mono font-bold">{{ $skill->level }}%</span>
                            </div>
                            <div class="w-full bg-slate-800 rounded-full h-2 overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-blue-500 via-sky-400 to-teal-400 rounded-full transition-all duration-700" style="width: {{ $skill->level }}%"></div>
                            </div>
                            <div class="mt-2 text-[10px] text-slate-400 font-mono uppercase tracking-wider">
                                {{ $skill->category }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-16 px-6 text-center rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl max-w-xl mx-auto">
                    <div class="w-12 h-12 mx-auto mb-4 rounded-2xl bg-blue-950/80 border border-blue-500/30 flex items-center justify-center text-blue-400 font-mono text-sm font-bold">
                        [#]
                    </div>
                    <div class="text-white font-bold text-base mb-1.5">Spesialisasi Kompetensi Sedang Dikurasi</div>
                    <p class="text-slate-400 text-xs leading-relaxed max-w-sm mx-auto">
                        Daftar kompetensi kejuruan dan matriks kemampuan teknis sedang diperbarui.
                    </p>
                </div>
            @endif

        </div>
    </section>


    <!-- SECTION 6: ARSITEKTUR & TEKNOLOGI PEMBANGUN WEBSITE (#architecture) - Soft Slate -->
    <section id="architecture" class="w-full bg-[#F1F5F9] py-16 sm:py-24 md:py-32 border-y border-slate-200/80 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 sm:mb-10">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full glass-pill text-xs font-mono text-blue-600 mb-3 bg-blue-50/60 border-blue-200 font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                        <span>Arsitektur &amp; Stack Website</span>
                    </div>
                    <h2 class="text-2xl sm:text-4xl lg:text-5xl font-bold text-slate-900 tracking-tight">
                        Teknologi Pembangun Website Ini
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-2 max-w-xl leading-relaxed text-balance">
                        Portofolio ini dibangun secara mandiri (self-hosted) menggunakan arsitektur LEMP stack berkinerja tinggi, framework PHP modern, sistem desain utilitas, dan kompilasi aset generasi terbaru.
                    </p>
                </div>
                <div class="flex items-center gap-2 px-3.5 py-2 rounded-full glass-pill text-emerald-700 bg-emerald-50 border-emerald-200 text-xs font-mono shrink-0 self-start md:self-auto font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Self-Hosted LEMP Stack</span>
                </div>
            </div>

            <!-- 3D Orrery Orbital Focus Gallery -->
            <div class="orrery-wrapper relative" id="orrery-container">
                <!-- Background Canvas -->
                <canvas id="orrery-stars-canvas" class="absolute inset-0 w-full h-full pointer-events-none z-0"></canvas>

                <!-- Top Ambient Glow -->
                <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-96 h-96 rounded-full bg-gradient-to-b from-blue-600/10 via-teal-500/5 to-transparent blur-3xl pointer-events-none z-0"></div>

                <!-- Top Status Bar -->
                <div class="relative z-20 flex items-center justify-between p-3.5 sm:p-5 border-b border-slate-200 bg-white/90 backdrop-blur-xl">
                    <div class="flex items-center gap-2.5">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                        <span class="text-xs font-mono font-semibold tracking-wider text-emerald-700 uppercase">
                            Orbital Engine Aktif
                        </span>
                        <span class="text-xs text-slate-400 hidden sm:inline">/</span>
                        <span class="text-xs font-mono text-slate-500 hidden sm:inline">
                            Berputar Otomatis
                        </span>
                    </div>
                    <div class="text-[11px] font-mono text-slate-500 font-semibold">
                        8 Node Teknologi Terhubung
                    </div>
                </div>

                <!-- Interactive Orbit Stage -->
                <div class="orrery-orbit-container relative overflow-hidden z-10" id="orrery-stage">
                    <!-- SVG Orbit Ellipse Path -->
                    <svg id="orrery-orbit-svg" class="absolute inset-0 w-full h-full pointer-events-none z-10"></svg>

                    <!-- Center Projected Tech Card -->
                    <div id="orrery-center-display" class="orrery-center-wrapper"></div>

                    <!-- Orbiting Nodes Container -->
                    <div id="orrery-nodes-container" class="absolute inset-0 w-full h-full pointer-events-auto"></div>
                </div>

                <!-- Bottom HUD Bar -->
                <div class="relative z-20 flex flex-col sm:flex-row items-center justify-between gap-3 px-4 sm:px-6 py-3.5 border-t border-slate-200 bg-white/95 backdrop-blur-xl">
                    <div class="flex items-baseline gap-2">
                        <span class="font-bold text-lg sm:text-xl tracking-tight text-slate-900">
                            Orrery
                        </span>
                        <span class="text-[10px] font-mono uppercase tracking-widest text-slate-500 font-semibold">
                            Orbital Architecture
                        </span>
                    </div>

                    <div class="text-[11px] font-mono text-slate-600 text-center flex items-center gap-1.5">
                        <span>Drag untuk memutar / Klik logo untuk fokus / Klik 2x untuk detail teknologi</span>
                    </div>

                    <div class="font-mono text-xs font-semibold text-slate-700 flex items-center gap-2">
                        <span id="orrery-hud-counter" class="text-blue-600">01 / 08</span>
                        <span class="text-slate-300">/</span>
                        <span id="orrery-hud-degree" class="text-teal-600">090°</span>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <!-- SECTION 7: CONTACT (#contact) - Technical Slate Dark -->
    <section id="contact" class="w-full bg-[#0F172A] py-16 sm:py-24 md:py-32 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid lg:grid-cols-12 gap-10 lg:gap-16 items-start">
                
                <!-- Left Info with Direct Contact Data -->
                <div class="lg:col-span-5 reveal-slide-left space-y-6">
                    <div class="inline-flex items-center gap-2 text-xs font-mono text-sky-400 uppercase tracking-wider font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>
                        <span>Hubungi Langsung</span>
                    </div>
                    <h2 class="text-2xl sm:text-4xl lg:text-5xl font-bold text-white tracking-tight leading-[1.15]">
                        Mulai Diskusi <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-sky-400 to-teal-300">Lab Jaringan.</span>
                    </h2>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed text-balance">
                        Tertarik berdiskusi seputar lab arsitektur jaringan, kolaborasi proyek, pengujian performa server LEMP, atau tawaran magang kejuruan? Hubungi saya secara langsung melalui kontak di bawah ini.
                    </p>

                    <!-- User Contact Credentials Cluster -->
                    <div class="pt-2 sm:pt-4 space-y-3 sm:space-y-4 font-mono text-xs">
                        <!-- Status -->
                        <div class="flex items-center gap-3 text-slate-300">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>
                            <span>Status: Siap Magang &amp; Kolaborasi Riset</span>
                        </div>

                        <!-- Location -->
                        <div class="flex items-center gap-3 text-slate-300">
                            <span class="w-2.5 h-2.5 rounded-full bg-sky-400 shrink-0"></span>
                            <span>Lokasi: Denpasar, Bali, Indonesia</span>
                        </div>

                        <!-- Email -->
                        <a href="mailto:yuda2010f@gmail.com" class="glass-panel-dark-interactive min-h-[52px] flex items-center gap-3 p-3.5 rounded-2xl text-slate-300 hover:text-white transition-all group">
                            <div class="w-9 h-9 rounded-xl bg-slate-800/80 border border-slate-700 flex items-center justify-center text-sky-400 group-hover:scale-105 transition-transform shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex flex-col truncate min-w-0">
                                <span class="text-[10px] text-slate-400 uppercase tracking-wider">Email Utama</span>
                                <span class="text-xs font-semibold text-sky-400 group-hover:text-sky-300 truncate">yuda2010f@gmail.com</span>
                            </div>
                        </a>

                        <!-- Phone / WhatsApp -->
                        <a href="https://wa.me/6285182691268" target="_blank" rel="noopener noreferrer" class="glass-panel-dark-interactive min-h-[52px] flex items-center gap-3 p-3.5 rounded-2xl text-slate-300 hover:text-white transition-all group">
                            <div class="w-9 h-9 rounded-xl bg-slate-800/80 border border-slate-700 flex items-center justify-center text-teal-400 group-hover:scale-105 transition-transform shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div class="flex flex-col truncate min-w-0">
                                <span class="text-[10px] text-slate-400 uppercase tracking-wider">No. Telepon / WhatsApp</span>
                                <span class="text-xs font-semibold text-teal-400 group-hover:text-teal-300">085182691268</span>
                            </div>
                        </a>

                        <!-- GitHub -->
                        <a href="https://github.com/Great-YUDZZ" target="_blank" rel="noopener noreferrer" class="glass-panel-dark-interactive min-h-[52px] flex items-center gap-3 p-3.5 rounded-2xl text-slate-300 hover:text-white transition-all group">
                            <div class="w-9 h-9 rounded-xl bg-slate-800/80 border border-slate-700 flex items-center justify-center text-slate-300 group-hover:scale-105 transition-transform shrink-0">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                                </svg>
                            </div>
                            <div class="flex flex-col truncate min-w-0">
                                <span class="text-[10px] text-slate-400 uppercase tracking-wider">GitHub Profile</span>
                                <span class="text-xs font-semibold text-slate-200 group-hover:text-blue-400">github.com/Great-YUDZZ</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Right Contact Form -->
                <div class="lg:col-span-7 reveal-slide-right">
                    <div class="p-5 sm:p-8 md:p-10 rounded-2xl sm:rounded-3xl glass-panel-dark shadow-2xl relative">
                        <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-blue-600/10 blur-3xl pointer-events-none"></div>

                        @if(session('success'))
                            <div class="mb-6 p-4 rounded-xl bg-emerald-950/80 border border-emerald-500/40 text-emerald-400 text-xs font-mono flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5 sm:space-y-6">
                            @csrf
                            <div class="grid sm:grid-cols-2 gap-4 sm:gap-6">
                                <div>
                                    <label for="sender_name" class="block text-xs font-mono text-slate-300 font-semibold mb-2">Nama Lengkap</label>
                                    <input type="text" name="sender_name" id="sender_name" value="{{ old('sender_name') }}" required
                                        placeholder="Nama Lengkap / Instansi"
                                        class="w-full px-4 py-3 rounded-xl bg-slate-950/60 backdrop-blur-md border border-slate-700/80 text-white placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">
                                </div>
                                <div>
                                    <label for="email" class="block text-xs font-mono text-slate-300 font-semibold mb-2">Alamat Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                        placeholder="nama@domain.com"
                                        class="w-full px-4 py-3 rounded-xl bg-slate-950/60 backdrop-blur-md border border-slate-700/80 text-white placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">
                                </div>
                            </div>

                            <div>
                                <label for="subject" class="block text-xs font-mono text-slate-300 font-semibold mb-2">Subjek Pesan</label>
                                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                                    placeholder="Topik diskusi lab atau tawaran proyek..."
                                    class="w-full px-4 py-3 rounded-xl bg-slate-950/60 backdrop-blur-md border border-slate-700/80 text-white placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">
                            </div>

                            <div>
                                <label for="message" class="block text-xs font-mono text-slate-300 font-semibold mb-2">Isi Pesan</label>
                                <textarea name="message" id="message" rows="4" required
                                    placeholder="Tuliskan pesan atau pertanyaan Anda di sini..."
                                    class="w-full px-4 py-3 rounded-xl bg-slate-950/60 backdrop-blur-md border border-slate-700/80 text-white placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all resize-none">{{ old('message') }}</textarea>
                            </div>

                            <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-between gap-4 pt-2">
                                <span class="text-[11px] font-mono text-slate-400 text-center sm:text-left">Pesan terkirim ke inbox terenkripsi</span>
                                <button type="submit" class="btn-primary w-full sm:w-auto min-h-[44px] justify-center">
                                    <span>Kirim Pesan</span>
                                    <span>&rarr;</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

<!-- INTERACTIVE CERTIFICATE LIGHTBOX MODAL -->
<div id="cert-modal" class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-md hidden items-center justify-center p-3 sm:p-6" role="dialog" aria-modal="true" aria-labelledby="modal-cert-title">
    <div class="relative w-full max-w-4xl max-h-[92vh] glass-panel border border-slate-200 rounded-2xl sm:rounded-3xl overflow-hidden shadow-2xl bg-white flex flex-col" onclick="event.stopPropagation()">
        
        <!-- Modal Header Bar -->
        <div class="p-3.5 sm:p-5 border-b border-slate-200 flex items-center justify-between bg-slate-50">
            <div class="flex items-center gap-2.5 sm:gap-3 truncate pr-3">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-600 shrink-0"></span>
                <div class="truncate">
                    <h3 id="modal-cert-title" class="text-sm sm:text-lg font-bold text-slate-900 truncate">Pratinjau Sertifikat Asli</h3>
                    <p id="modal-cert-issuer" class="text-[11px] sm:text-xs text-slate-500 font-mono truncate">Penerbit Resmi</p>
                </div>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <a id="modal-cert-pdf-link" href="#" target="_blank" rel="noopener noreferrer" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-md shadow-blue-500/20 transition-all">
                    <span>Buka PDF Asli</span>
                    <span>&nearr;</span>
                </a>
                <button type="button" onclick="closeCertModal()" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-900 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 cursor-pointer" aria-label="Tutup pratinjau">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Modal Document Viewer Body -->
        <div class="p-3 sm:p-6 overflow-y-auto flex-1 flex items-center justify-center bg-slate-100/60">
            <img id="modal-cert-image" src="" alt="Pratinjau Berkas Asli" class="max-w-full max-h-[50vh] sm:max-h-[65vh] object-contain rounded-xl border border-slate-200 shadow-md">
        </div>

        <!-- Modal Footer Bar -->
        <div class="p-3.5 sm:p-4 border-t border-slate-200 bg-white flex flex-col sm:flex-row items-center justify-between gap-3 text-xs font-mono">
            <div class="flex items-center gap-2 text-slate-500 text-center sm:text-left">
                <span class="text-emerald-700 flex items-center gap-1.5 font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span id="modal-cert-status">Terverifikasi Resmi BSrE</span>
                </span>
                <span class="text-slate-300">/</span>
                <span id="modal-cert-id" class="text-slate-600 truncate max-w-xs">No: -</span>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <a id="modal-cert-pdf-link-mobile" href="#" target="_blank" rel="noopener noreferrer" class="w-full sm:hidden min-h-[44px] py-2.5 px-4 flex items-center justify-center text-center rounded-full bg-blue-600 text-white font-semibold">
                    Buka File PDF Asli &nearr;
                </a>
                <button type="button" onclick="closeCertModal()" class="hidden sm:inline-flex py-1.5 px-4 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 transition-colors cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>

    </div>
</div>

<!-- 3D ORRERY TECHNOLOGY DETAIL MODAL (DOUBLE-CLICK DIALOG) -->
<div id="orrery-tech-modal" class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-md hidden items-center justify-center p-3 sm:p-6" role="dialog" aria-modal="true" aria-labelledby="modal-tech-title">
    <div id="modal-tech-card" class="relative w-full max-w-2xl max-h-[92vh] glass-panel border border-slate-200 rounded-2xl sm:rounded-3xl overflow-hidden shadow-2xl bg-white flex flex-col" onclick="event.stopPropagation()">
        
        <!-- Ambient Top Glow -->
        <div id="modal-tech-glow" class="absolute -top-16 left-1/2 -translate-x-1/2 w-64 h-64 rounded-full blur-3xl pointer-events-none opacity-30"></div>

        <!-- Modal Header Bar -->
        <div class="relative z-10 p-4 sm:p-6 border-b border-slate-200 flex items-center justify-between bg-slate-50">
            <div class="flex items-center gap-3.5 sm:gap-4 truncate pr-3">
                <!-- SVG Icon Box -->
                <div id="modal-tech-icon-box" class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center p-2.5 border shrink-0 relative shadow-sm bg-white border-slate-200">
                    <div id="modal-tech-svg-container" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center pointer-events-none"></div>
                </div>

                <div class="truncate">
                    <div class="flex items-center gap-2 mb-1">
                        <span id="modal-tech-category-badge" class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] sm:text-[11px] font-mono font-semibold border bg-blue-50 border-blue-200 text-blue-700">
                            <span id="modal-tech-dot" class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                            <span id="modal-tech-category">Category</span>
                        </span>
                    </div>
                    <h3 id="modal-tech-title" class="text-lg sm:text-2xl font-bold text-slate-900 tracking-tight truncate">Tech Title</h3>
                </div>
            </div>

            <button type="button" onclick="closeOrreryTechModal()" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-900 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 cursor-pointer shrink-0" aria-label="Tutup jendela detail">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Modal Tech Body -->
        <div class="relative z-10 p-5 sm:p-7 overflow-y-auto flex-1 space-y-5 bg-white">
            <!-- Role & Spec Monospace Pill -->
            <div class="flex flex-wrap items-center justify-between gap-2 p-3 rounded-xl bg-slate-50 border border-slate-200">
                <div class="flex items-center gap-2 text-xs font-mono text-slate-600">
                    <span class="text-slate-500">Peran Arsitektur:</span>
                    <span id="modal-tech-role" class="text-slate-900 font-semibold">Role Description</span>
                </div>
                <div class="inline-flex items-center gap-1.5 text-[11px] font-mono text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>Terkonfigurasi Aktif</span>
                </div>
            </div>

            <!-- Full Technical Description -->
            <div>
                <h4 class="text-xs font-mono uppercase tracking-wider text-slate-500 mb-2 font-semibold">Deskripsi Teknis</h4>
                <p id="modal-tech-desc" class="text-sm sm:text-base text-slate-700 leading-relaxed text-pretty">
                    Deskripsi lengkap mengenai implementasi teknologi ini pada arsitektur sistem LEMP stack mandiri.
                </p>
            </div>

            <!-- Lab Implementation Info -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                <div class="text-xs font-mono text-slate-600 flex items-center gap-1.5 font-semibold">
                    <span class="text-blue-600 font-bold">&gt;</span>
                    <span>Catatan Implementasi TKJ Lab:</span>
                </div>
                <p id="modal-tech-lab-note" class="text-xs text-slate-600 leading-relaxed">
                    Dikonfigurasi langsung pada server baremetal Debian 13 dengan soket UNIX dan optimalisasi produksi.
                </p>
            </div>
        </div>

        <!-- Modal Footer Bar -->
        <div class="relative z-10 p-4 sm:p-5 border-t border-slate-200 bg-slate-50 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs font-mono">
            <div class="text-slate-500 text-[11px]">
                Portofolio Teknik Komputer &amp; Jaringan
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto">
                <button type="button" onclick="closeOrreryTechModal()" class="w-1/2 sm:w-auto py-2 px-4 rounded-full bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 hover:text-slate-900 transition-colors cursor-pointer text-center font-medium">
                    Tutup
                </button>
                <a id="modal-tech-link" href="#" target="_blank" rel="noopener noreferrer" class="w-1/2 sm:w-auto inline-flex items-center justify-center gap-1.5 py-2 px-5 rounded-full bg-blue-600 text-white font-bold hover:bg-blue-700 transition-all shadow-sm">
                    <span>Situs Resmi</span>
                    <span>&nearr;</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function openCertModal(imageSrc, title, issuer, credentialId, pdfUrl, status) {
        const modal = document.getElementById('cert-modal');
        const modalImg = document.getElementById('modal-cert-image');
        const modalTitle = document.getElementById('modal-cert-title');
        const modalIssuer = document.getElementById('modal-cert-issuer');
        const modalId = document.getElementById('modal-cert-id');
        const modalStatus = document.getElementById('modal-cert-status');
        const pdfLink = document.getElementById('modal-cert-pdf-link');
        const pdfLinkMobile = document.getElementById('modal-cert-pdf-link-mobile');

        if (!modal) return;

        modalImg.src = imageSrc;
        modalTitle.textContent = title;
        modalIssuer.textContent = issuer;
        modalId.textContent = credentialId ? 'No: ' + credentialId : '';
        modalStatus.textContent = status || 'Terverifikasi Resmi';

        if (pdfUrl) {
            pdfLink.href = pdfUrl;
            pdfLink.classList.remove('hidden');
            pdfLinkMobile.href = pdfUrl;
            pdfLinkMobile.classList.remove('hidden');
        } else {
            pdfLink.classList.add('hidden');
            pdfLinkMobile.classList.add('hidden');
        }

        const card = modal.querySelector('.glass-panel');
        if (typeof window.animateModalOpen === 'function') {
            window.animateModalOpen(modal, card);
        } else {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeCertModal() {
        const modal = document.getElementById('cert-modal');
        if (!modal) return;

        const card = modal.querySelector('.glass-panel');
        if (typeof window.animateModalClose === 'function') {
            window.animateModalClose(modal, card);
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
    }

    // Close on backdrop click
    document.getElementById('cert-modal')?.addEventListener('click', (e) => {
        if (e.target === e.currentTarget) {
            closeCertModal();
        }
    });

    // Close on backdrop click for orrery tech modal
    document.getElementById('orrery-tech-modal')?.addEventListener('click', (e) => {
        if (e.target === e.currentTarget) {
            if (typeof window.closeOrreryTechModal === 'function') {
                window.closeOrreryTechModal();
            }
        }
    });

    // Close modals on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeCertModal();
            if (typeof window.closeOrreryTechModal === 'function') {
                window.closeOrreryTechModal();
            }
        }
    });
</script>
@endpush
