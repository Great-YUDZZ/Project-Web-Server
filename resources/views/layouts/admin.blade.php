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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#070709] text-zinc-300 flex antialiased selection:bg-orange-500/30 selection:text-orange-100">

    <!-- Admin Sidebar -->
    <aside class="w-64 bg-[#0b0c10] border-r border-white/[0.08] flex flex-col shrink-0 min-h-screen relative z-20">
        <!-- Brand Header -->
        <div class="p-5 border-b border-white/[0.06]">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 rounded-lg">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8.5 h-8.5 shrink-0 object-contain group-hover:scale-105 transition-transform duration-300">
                <div class="flex flex-col">
                    <div class="font-bold text-white text-sm tracking-tight group-hover:text-orange-400 transition-colors">Admin Panel</div>
                    <div class="text-[10px] text-zinc-500 font-mono">TKJ Infrastructure</div>
                </div>
            </a>
        </div>

        <!-- Logged In User Info -->
        <div class="px-5 py-3.5 border-b border-white/[0.06] bg-white/[0.02]">
            <div class="text-[10px] font-mono text-zinc-500 uppercase tracking-wider">Logged in as</div>
            <div class="text-xs font-semibold text-white truncate mt-0.5">{{ auth()->user()->name }}</div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 p-3.5 space-y-1.5 text-xs font-medium font-mono">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-orange-500/15 to-amber-500/10 text-orange-400 border-l-2 border-orange-500 font-semibold' : 'text-zinc-400 hover:bg-white/[0.04] hover:text-white' }}">
                <svg class="w-4 h-4 text-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.projects.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 {{ request()->routeIs('admin.projects.*') ? 'bg-gradient-to-r from-orange-500/15 to-amber-500/10 text-orange-400 border-l-2 border-orange-500 font-semibold' : 'text-zinc-400 hover:bg-white/[0.04] hover:text-white' }}">
                <svg class="w-4 h-4 text-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span>Proyek Lab</span>
            </a>

            <a href="{{ route('admin.skills.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 {{ request()->routeIs('admin.skills.*') ? 'bg-gradient-to-r from-orange-500/15 to-amber-500/10 text-orange-400 border-l-2 border-orange-500 font-semibold' : 'text-zinc-400 hover:bg-white/[0.04] hover:text-white' }}">
                <svg class="w-4 h-4 text-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                <span>Skill Matrix</span>
            </a>

            <a href="{{ route('admin.certificates.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 {{ request()->routeIs('admin.certificates.*') ? 'bg-gradient-to-r from-orange-500/15 to-amber-500/10 text-orange-400 border-l-2 border-orange-500 font-semibold' : 'text-zinc-400 hover:bg-white/[0.04] hover:text-white' }}">
                <svg class="w-4 h-4 text-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Sertifikat</span>
            </a>

            <a href="{{ route('admin.messages.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 {{ request()->routeIs('admin.messages.*') ? 'bg-gradient-to-r from-orange-500/15 to-amber-500/10 text-orange-400 border-l-2 border-orange-500 font-semibold' : 'text-zinc-400 hover:bg-white/[0.04] hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>Inbox Pesan</span>
                </div>
                @php $unreadCount = \App\Models\Message::unread()->count(); @endphp
                @if($unreadCount > 0)
                    <span class="px-2 py-0.5 rounded-full bg-orange-500 text-white text-[10px] font-bold">{{ $unreadCount }}</span>
                @endif
            </a>

            <div class="pt-4 border-t border-white/[0.06] mt-4">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-3 py-2 rounded-xl text-zinc-400 hover:text-orange-400 hover:bg-white/[0.04] transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    <span>Buka Web Publik &rarr;</span>
                </a>
            </div>
        </nav>

        <!-- Logout Button -->
        <div class="p-4 border-t border-white/[0.06]">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 hover:bg-rose-500 hover:text-white text-xs font-mono font-medium transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Keluar Sesi</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden relative">
        <!-- Top Glow Ambient -->
        <div class="pointer-events-none absolute top-0 right-0 w-[500px] h-[300px] bg-orange-500/10 blur-[140px] z-0"></div>

        <!-- Admin Top Header Bar -->
        <header class="h-16 border-b border-white/[0.06] bg-[#070709]/80 backdrop-blur-xl px-8 flex items-center justify-between sticky top-0 z-30">
            <div class="text-xs font-mono text-zinc-400 flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                <span class="font-bold text-white tracking-wide">@yield('page_title', 'Dashboard')</span>
            </div>
            <div class="flex items-center gap-4 text-xs font-mono text-zinc-400">
                <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-white/[0.03] border border-white/[0.06]">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>Server Online</span>
                </div>
                <a href="{{ route('home') }}" class="hover:text-orange-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 rounded-sm">Web Publik &nearr;</a>
            </div>
        </header>

        <!-- Session Flash Alerts -->
        <div class="px-8 pt-6 relative z-10">
            @if(session('success'))
                <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-emerald-300 text-xs font-mono flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 p-4 text-rose-300 text-xs font-mono">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Main Body -->
        <main class="flex-1 p-8 relative z-10">
            @yield('admin_content')
        </main>
    </div>

    @stack('admin_scripts')
</body>
</html>
