<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel | I Made Yuda Pramana')</title>

    <!-- Favicon & Icons -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Google Fonts: Inter, Outfit, JetBrains Mono (Matches Main Web Page) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen text-[#f5f5f5] flex antialiased bg-[#0a0a0a] selection:bg-white/20 selection:text-white font-body">

    <!-- Mobile Backdrop -->
    <div id="admin-backdrop" class="fixed inset-0 bg-black/70 backdrop-blur-xs z-40 hidden lg:hidden transition-opacity"></div>

    <!-- Admin Sidebar (Obsidian Minimalist & Technical Craft) -->
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 border-r flex flex-col shrink-0 min-h-screen bg-[#0d0d0d] border-white/10 shadow-2xl transition-transform duration-300 -translate-x-full lg:translate-x-0 lg:static">
        <!-- Brand Header -->
        <div class="p-5 border-b border-white/10 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/20 rounded-xl">
                <div class="w-9 h-9 rounded-xl bg-white/5 border border-white/15 flex items-center justify-center shadow-lg shadow-black/40 group-hover:border-white/40 transition-colors">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-5 h-5 object-contain filter invert brightness-200">
                </div>
                <div class="flex flex-col">
                    <div class="font-bold text-sm tracking-tight text-white group-hover:text-stone-300 transition-colors font-body">Admin <span class="font-display font-semibold text-stone-300 text-base">Panel</span></div>
                    <div class="text-[10px] text-stone-400 font-mono font-medium flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-white shadow-[0_0_6px_rgba(255,255,255,0.6)]"></span>
                        <span>TKJ Infrastructure</span>
                    </div>
                </div>
            </a>
            <button type="button" id="sidebar-close" class="lg:hidden p-1.5 rounded-lg text-stone-400 hover:text-white hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/20" aria-label="Tutup Navigasi">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Logged In User Info -->
        <div class="px-5 py-3 border-b border-white/10 bg-white/[0.02]">
            <div class="text-[10px] font-mono text-stone-500 uppercase tracking-wider">Operator Sesi</div>
            <div class="text-xs font-semibold text-white truncate mt-0.5 font-body">{{ auth()->user()->name }}</div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 p-3.5 space-y-1.5 text-xs font-medium font-body">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/20 {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white font-bold shadow-md shadow-black/40 border border-white/20' : 'text-stone-400 hover:bg-white/[0.05] hover:text-white' }}">
                <svg class="w-4 h-4 text-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.projects.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/20 {{ request()->routeIs('admin.projects.*') ? 'bg-white/10 text-white font-bold shadow-md shadow-black/40 border border-white/20' : 'text-stone-400 hover:bg-white/[0.05] hover:text-white' }}">
                <svg class="w-4 h-4 text-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span>Proyek Lab</span>
            </a>

            <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/20 {{ request()->routeIs('admin.posts.*') ? 'bg-white/10 text-white font-bold shadow-md shadow-black/40 border border-white/20' : 'text-stone-400 hover:bg-white/[0.05] hover:text-white' }}">
                <svg class="w-4 h-4 text-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <span>Artikel Blog</span>
            </a>

            <a href="{{ route('admin.skills.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/20 {{ request()->routeIs('admin.skills.*') ? 'bg-white/10 text-white font-bold shadow-md shadow-black/40 border border-white/20' : 'text-stone-400 hover:bg-white/[0.05] hover:text-white' }}">
                <svg class="w-4 h-4 text-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                <span>Skill Matrix</span>
            </a>

            <a href="{{ route('admin.certificates.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/20 {{ request()->routeIs('admin.certificates.*') ? 'bg-white/10 text-white font-bold shadow-md shadow-black/40 border border-white/20' : 'text-stone-400 hover:bg-white/[0.05] hover:text-white' }}">
                <svg class="w-4 h-4 text-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Sertifikat</span>
            </a>

            <a href="{{ route('admin.messages.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/20 {{ request()->routeIs('admin.messages.*') ? 'bg-white/10 text-white font-bold shadow-md shadow-black/40 border border-white/20' : 'text-stone-400 hover:bg-white/[0.05] hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>Inbox Pesan</span>
                </div>
                @php $unreadCount = \App\Models\Message::unread()->count(); @endphp
                @if($unreadCount > 0)
                    <span class="px-2 py-0.5 rounded-full bg-white text-black text-[10px] font-bold shadow-xs font-mono">{{ $unreadCount }}</span>
                @endif
            </a>

            <div class="pt-4 border-t border-white/10 mt-4">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-stone-400 hover:text-white hover:bg-white/[0.05] transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/20">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    <span>Buka Web Publik &rarr;</span>
                </a>
            </div>
        </nav>

        <!-- Logout Button -->
        <div class="p-4 border-t border-white/10">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-rose-950/30 border border-rose-800/40 text-rose-300 hover:bg-rose-900/50 hover:text-white text-xs font-body font-medium transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Keluar Sesi</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area with Blueprint Mesh -->
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden relative bg-[#0a0a0a]">
        <!-- Subtle Architectural Blueprint Grid Background -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.03)_1px,transparent_1px)] bg-[size:28px_28px] pointer-events-none z-0"></div>

        <!-- Admin Top Header Bar (HUD Style) -->
        <header class="h-16 border-b border-white/10 bg-[#0d0d0d]/85 backdrop-blur-xl px-4 sm:px-8 flex items-center justify-between sticky top-0 z-30 shadow-xs">
            <div class="flex items-center gap-3">
                <button type="button" id="sidebar-toggle" class="lg:hidden p-2 rounded-xl text-stone-400 hover:text-white hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/20" aria-label="Buka Navigasi">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="text-xs font-body text-stone-400 flex items-center gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-white shadow-[0_0_8px_rgba(255,255,255,0.8)]"></span>
                    <span class="font-bold text-white tracking-wide text-sm font-body">@yield('page_title', 'Dashboard')</span>
                </div>
            </div>
            <div class="flex items-center gap-3 sm:gap-4 text-xs font-body text-stone-400">
                <div class="flex items-center gap-2 px-3 py-1.5 sm:px-3.5 rounded-full bg-white/5 border border-white/15 text-stone-200 font-medium font-mono text-[11px] shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]"></span>
                    <span class="hidden sm:inline">Server LEMP Online</span>
                    <span class="sm:hidden">LEMP Online</span>
                </div>
                <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1 text-stone-300 font-semibold hover:text-white transition-colors font-body">
                    <span>Web Publik</span>
                    <span>&nearr;</span>
                </a>
            </div>
        </header>

        <!-- Session Flash Alerts -->
        <div class="px-6 sm:px-8 pt-6 relative z-10">
            @if(session('success'))
                <div class="rounded-2xl border border-emerald-800/60 bg-emerald-950/40 p-4 text-emerald-300 text-xs font-body flex items-center gap-3 shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]"></span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="rounded-2xl border border-rose-800/60 bg-rose-950/40 p-4 text-rose-300 text-xs font-body shadow-xs">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Main Body -->
        <main class="flex-1 p-6 sm:p-8 relative z-10">
            @yield('admin_content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('sidebar-toggle');
            const closeBtn = document.getElementById('sidebar-close');
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('admin-backdrop');

            function toggleSidebar(open) {
                if (!sidebar || !backdrop) return;
                if (open) {
                    sidebar.classList.remove('-translate-x-full');
                    backdrop.classList.remove('hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.add('hidden');
                }
            }

            toggleBtn?.addEventListener('click', () => toggleSidebar(true));
            closeBtn?.addEventListener('click', () => toggleSidebar(false));
            backdrop?.addEventListener('click', () => toggleSidebar(false));
        });
    </script>
    @stack('admin_scripts')
</body>
</html>
