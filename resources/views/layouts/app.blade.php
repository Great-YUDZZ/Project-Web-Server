<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portofolio Siswa TKJ - Yuda Pratama | Network &amp; Sysadmin')</title>
    <meta name="description" content="Website portofolio kejuruan Teknik Komputer dan Jaringan (TKJ) - Dokumentasi lab MikroTik, Cisco, Linux Debian Server, LEMP Stack, dan Virtualisasi Proxmox.">

    <!-- Fonts: Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #060913;
            color: #e2e8f0;
        }
        .font-mono-code {
            font-family: 'Fira Code', monospace;
        }
        .cyber-grid {
            background-size: 40px 40px;
            background-image: 
                linear-gradient(to right, rgba(0, 240, 255, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(0, 240, 255, 0.03) 1px, transparent 1px);
        }
        .cyber-glow-cyan {
            box-shadow: 0 0 25px -5px rgba(0, 240, 255, 0.25);
        }
        .cyber-glow-emerald {
            box-shadow: 0 0 25px -5px rgba(16, 185, 129, 0.25);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-[#060913] text-slate-200 cyber-grid selection:bg-cyan-500 selection:text-black">

    <!-- Top Status Bar -->
    <div class="border-b border-cyan-950/60 bg-slate-950/80 backdrop-blur-md px-4 py-1.5 text-xs text-slate-400 font-mono-code flex justify-between items-center z-50">
        <div class="flex items-center space-x-3">
            <span class="inline-flex items-center gap-1.5 text-emerald-400">
                <span class="h-2 w-2 rounded-full bg-emerald-400 animate-ping"></span>
                <span>NODE_ONLINE // 127.0.0.1</span>
            </span>
            <span class="hidden sm:inline text-slate-600">|</span>
            <span class="hidden sm:inline text-slate-400">STACK: LEMP (Nginx + MariaDB + PHP 8.4)</span>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-cyan-400">SYS: ACTIVE</span>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="text-emerald-400 hover:text-emerald-300 font-semibold underline decoration-emerald-500/50">
                    [ADMIN_PANEL]
                </a>
            @else
                <a href="{{ route('login') }}" class="text-slate-400 hover:text-cyan-400 transition-colors">
                    [PORTAL_LOGIN]
                </a>
            @endauth
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-40 border-b border-slate-800/80 bg-slate-950/80 backdrop-blur-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-black font-black font-mono-code text-lg shadow-lg shadow-cyan-500/20 group-hover:scale-105 transition-transform">
                    &gt;_
                </div>
                <div>
                    <div class="font-mono-code font-bold text-white tracking-wider flex items-center gap-2">
                        <span>YUDA_PRATAMA</span>
                        <span class="text-[10px] px-1.5 py-0.5 rounded bg-cyan-500/10 border border-cyan-500/30 text-cyan-400">TKJ</span>
                    </div>
                    <p class="text-[11px] text-slate-400">Network &amp; Linux System Administrator</p>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex items-center gap-1 font-mono-code text-sm">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded-md hover:bg-slate-800/70 hover:text-cyan-400 transition-colors {{ request()->routeIs('home') ? 'text-cyan-400 bg-cyan-500/10' : 'text-slate-300' }}">
                    // Beranda
                </a>
                <a href="{{ route('home') }}#about" class="px-3 py-2 rounded-md hover:bg-slate-800/70 hover:text-cyan-400 transition-colors text-slate-300">
                    // Profil
                </a>
                <a href="{{ route('home') }}#skills" class="px-3 py-2 rounded-md hover:bg-slate-800/70 hover:text-cyan-400 transition-colors text-slate-300">
                    // Skill_Matrix
                </a>
                <a href="{{ route('projects.index') }}" class="px-3 py-2 rounded-md hover:bg-slate-800/70 hover:text-cyan-400 transition-colors {{ request()->routeIs('projects.*') ? 'text-cyan-400 bg-cyan-500/10' : 'text-slate-300' }}">
                    // Lab_Proyek
                </a>
                <a href="{{ route('home') }}#certifications" class="px-3 py-2 rounded-md hover:bg-slate-800/70 hover:text-cyan-400 transition-colors text-slate-300">
                    // Sertifikasi
                </a>
                <a href="{{ route('home') }}#contact" class="ml-2 px-4 py-2 rounded-lg bg-cyan-500/10 border border-cyan-500/40 text-cyan-400 hover:bg-cyan-500 hover:text-black font-semibold transition-all">
                    Hubungi_Saya
                </a>
            </nav>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" type="button" class="md:hidden p-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 hover:text-cyan-400 focus:outline-none" aria-label="Toggle navigation">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-800 bg-slate-950/95 px-4 py-3 space-y-2 font-mono-code text-sm">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded hover:bg-slate-800 text-slate-200">Beranda</a>
            <a href="{{ route('home') }}#about" class="block px-3 py-2 rounded hover:bg-slate-800 text-slate-200">Profil Kejuruan</a>
            <a href="{{ route('home') }}#skills" class="block px-3 py-2 rounded hover:bg-slate-800 text-slate-200">Skill Matrix</a>
            <a href="{{ route('projects.index') }}" class="block px-3 py-2 rounded hover:bg-slate-800 text-slate-200">Lab &amp; Proyek</a>
            <a href="{{ route('home') }}#certifications" class="block px-3 py-2 rounded hover:bg-slate-800 text-slate-200">Sertifikasi</a>
            <a href="{{ route('home') }}#contact" class="block px-3 py-2 rounded bg-cyan-500/20 text-cyan-400">Hubungi Saya</a>
        </div>
    </header>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="rounded-xl border border-emerald-500/40 bg-emerald-950/40 p-4 text-emerald-300 flex items-start gap-3 shadow-lg shadow-emerald-950/30 font-mono-code text-sm">
                <span class="text-xl">✔</span>
                <div class="flex-1">
                    <div class="font-bold text-emerald-200">[SUCCESS_ACKNOWLEDGE]</div>
                    <div>{{ session('success') }}</div>
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="rounded-xl border border-rose-500/40 bg-rose-950/40 p-4 text-rose-300 font-mono-code text-sm shadow-lg shadow-rose-950/30">
                <div class="font-bold text-rose-200 flex items-center gap-2">
                    <span>⚠</span> [VALIDATION_ERROR]
                </div>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Content Body -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-20 border-t border-slate-800/80 bg-slate-950 py-12 text-sm text-slate-400 font-mono-code">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <div class="text-white font-bold text-base flex items-center gap-2 mb-3">
                        <span class="text-cyan-400">&gt;</span> YUDA PRATAMA
                    </div>
                    <p class="text-slate-400 text-xs leading-relaxed">
                        Siswa Teknik Komputer &amp; Jaringan (TKJ). Berfokus pada perancangan topologi jaringan (MikroTik, Cisco), konfigurasi server berbasis Linux Debian, virtualisasi Proxmox, dan implementasi web stack LEMP.
                    </p>
                </div>
                <div>
                    <div class="text-white font-bold text-base mb-3">// SERVER_ENVIRONMENT</div>
                    <ul class="space-y-1.5 text-xs text-slate-400">
                        <li><span class="text-cyan-400">OS:</span> Linux Debian/Ubuntu Server</li>
                        <li><span class="text-emerald-400">Web Engine:</span> Nginx 1.26 Reverse Proxy</li>
                        <li><span class="text-amber-400">Database:</span> MariaDB 11.8 Engine</li>
                        <li><span class="text-purple-400">Backend:</span> PHP 8.4 FPM + Laravel 12</li>
                    </ul>
                </div>
                <div>
                    <div class="text-white font-bold text-base mb-3">// SHORTCUTS</div>
                    <div class="flex flex-wrap gap-2 text-xs">
                        <a href="{{ route('home') }}" class="px-2.5 py-1 rounded bg-slate-900 border border-slate-800 text-slate-300 hover:border-cyan-500 hover:text-cyan-400">Home</a>
                        <a href="{{ route('projects.index') }}" class="px-2.5 py-1 rounded bg-slate-900 border border-slate-800 text-slate-300 hover:border-cyan-500 hover:text-cyan-400">Semua Lab</a>
                        <a href="{{ route('login') }}" class="px-2.5 py-1 rounded bg-slate-900 border border-slate-800 text-slate-300 hover:border-emerald-500 hover:text-emerald-400">Admin Login</a>
                        <a href="{{ route('home') }}#contact" class="px-2.5 py-1 rounded bg-slate-900 border border-slate-800 text-slate-300 hover:border-purple-500 hover:text-purple-400">Kirim Pesan</a>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-800/60 pt-6 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-400 gap-4">
                <p>&copy; {{ date('Y') }} Portofolio TKJ Yuda Pratama. Dibangun dengan LEMP Stack &amp; Laravel.</p>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 text-emerald-400">
                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                        HOSTED ON NGINX
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Nav Script -->
    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
    @stack('scripts')
</body>
</html>
