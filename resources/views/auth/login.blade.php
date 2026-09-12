@extends('layouts.app')

@section('title', 'Login Portal Admin TKJ - I Made Yuda Pramana')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
    
    <!-- Ambient Warm Orange Glow -->
    <div class="absolute w-[450px] h-[450px] bg-orange-500/15 blur-[140px] rounded-full pointer-events-none"></div>

    <div class="max-w-md w-full relative z-10">
        
        <!-- Login Card -->
        <div class="rounded-3xl glass-panel p-8 sm:p-10 shadow-2xl shadow-black/90">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex h-16 w-16 items-center justify-center mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <h2 class="text-2xl font-bold text-white tracking-tight">
                    PORTAL ADMIN TKJ
                </h2>
                <p class="text-xs text-zinc-400 font-mono mt-1.5">
                    Sistem Manajemen Portofolio &bull; I Made Yuda Pramana
                </p>
            </div>

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block font-mono text-xs text-zinc-400 mb-2">
                        EMAIL ADMIN <span class="text-orange-400">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           placeholder="admin@tkj.lan"
                           class="input-field font-mono text-sm">
                </div>

                <div>
                    <label for="password" class="block font-mono text-xs text-zinc-400 mb-2">
                        KATA SANDI <span class="text-orange-400">*</span>
                    </label>
                    <input type="password" name="password" id="password" required
                           placeholder="••••••••••••"
                           class="input-field font-mono text-sm">
                </div>

                <div class="flex items-center justify-between font-mono text-xs">
                    <label class="flex items-center gap-2 text-zinc-400 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded bg-neutral-900 border-white/10 text-orange-500 focus:ring-0">
                        <span>Ingat sesi saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-full bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold font-mono text-xs tracking-wider uppercase shadow-lg shadow-orange-500/25 hover:shadow-orange-500/40 hover:scale-[1.01] active:scale-[0.99] transition-all">
                    Masuk Panel Admin &rarr;
                </button>
            </form>

            <div class="mt-5 text-center">
                <a href="{{ route('home') }}" class="font-mono text-xs text-zinc-500 hover:text-orange-400 transition-colors">
                    &larr; Kembali ke Beranda Publik
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
