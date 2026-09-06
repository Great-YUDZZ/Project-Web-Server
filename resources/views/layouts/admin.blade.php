<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel TKJ - Yuda Pratama')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #080c18;
            color: #e2e8f0;
        }
        .font-mono-code {
            font-family: 'Fira Code', monospace;
        }
    </style>
</head>
<body class="min-h-screen bg-[#080c18] text-slate-200 flex">

    <!-- Sidebar Navigation -->
    <aside class="w-64 bg-slate-950 border-r border-slate-800/80 flex flex-col shrink-0 min-h-screen">
        <!-- Brand / Sys Header -->
        <div class="p-5 border-b border-slate-800/80">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-lg bg-cyan-500 flex items-center justify-center text-black font-black font-mono-code text-base">
                    #_
                </div>
                <div>
                    <div class="font-mono-code font-bold text-white text-sm">ADMIN_CONTROL</div>
                    <div class="text-[11px] text-cyan-400 font-mono-code">PORTAL TKJ v2.0</div>
                </div>
            </a>
        </div>

        <!-- Current User Info -->
        <div class="px-5 py-4 border-b border-slate-800/50 bg-slate-900/30">
            <div class="text-xs text-slate-400 font-mono-code">LOGGED_AS:</div>
            <div class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</div>
            <div class="text-xs text-emerald-400 flex items-center gap-1.5 mt-1 font-mono-code">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                <span>AUTHENTICATED</span>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 p-4 space-y-1.5 font-mono-code text-sm">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-cyan-500/15 border border-cyan-500/30 text-cyan-400 font-semibold' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.projects.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.projects.*') ? 'bg-cyan-500/15 border border-cyan-500/30 text-cyan-400 font-semibold' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span>Kelola Proyek</span>
            </a>

            <a href="{{ route('admin.skills.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.skills.*') ? 'bg-cyan-500/15 border border-cyan-500/30 text-cyan-400 font-semibold' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                <span>Skill Matrix</span>
            </a>

            <a href="{{ route('admin.messages.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.messages.*') ? 'bg-cyan-500/15 border border-cyan-500/30 text-cyan-400 font-semibold' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>Inbox Pesan</span>
                </div>
                @php $unreadCount = \App\Models\Message::unread()->count(); @endphp
                @if($unreadCount > 0)
                    <span class="px-2 py-0.5 rounded-full bg-rose-500 text-white text-xs font-bold">{{ $unreadCount }}</span>
                @endif
            </a>

            <div class="pt-6 border-t border-slate-800/80 mt-6">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-3.5 py-2 rounded-lg text-slate-400 hover:text-cyan-400 hover:bg-slate-900 text-xs">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    <span>Buka Web Publik &nearr;</span>
                </a>
            </div>
        </nav>

        <!-- Logout Action -->
        <div class="p-4 border-t border-slate-800/80">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-rose-500/10 border border-rose-500/30 text-rose-400 hover:bg-rose-500 hover:text-white font-mono-code text-xs font-semibold transition-all">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>LOGOUT_SESSION</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Admin Workspace -->
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        <!-- Top Admin Header -->
        <header class="h-16 border-b border-slate-800/80 bg-slate-950/70 backdrop-blur-md px-6 flex items-center justify-between sticky top-0 z-30">
            <div class="font-mono-code text-sm">
                <span class="text-slate-500">ADMIN /</span>
                <span class="text-cyan-400 font-semibold">@yield('page_title', 'Dashboard')</span>
            </div>
            <div class="flex items-center gap-4 text-xs font-mono-code">
                <div class="px-3 py-1 rounded bg-slate-900 border border-slate-800 text-slate-300">
                    SERVER: <span class="text-emerald-400 font-bold">127.0.0.1 (Nginx)</span>
                </div>
            </div>
        </header>

        <!-- Alerts -->
        <div class="px-6 pt-4">
            @if(session('success'))
                <div class="rounded-lg border border-emerald-500/40 bg-emerald-950/40 p-3.5 text-emerald-300 font-mono-code text-sm flex items-center gap-2 shadow-md">
                    <span>✔</span> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="rounded-lg border border-rose-500/40 bg-rose-950/40 p-3.5 text-rose-300 font-mono-code text-sm">
                    <div class="font-bold">⚠ Terdapat kesalahan:</div>
                    <ul class="list-disc list-inside mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Body Content -->
        <main class="flex-1 p-6">
            @yield('admin_content')
        </main>
    </div>

    @stack('admin_scripts')
</body>
</html>
