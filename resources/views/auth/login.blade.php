@extends('layouts.app')

@section('title', 'Login Portal Admin TKJ - I Made Yuda Pramana')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
    
    <!-- Ambient Blue Glow -->
    <div class="absolute w-[450px] h-[450px] bg-blue-500/10 blur-[140px] rounded-full pointer-events-none"></div>

    <div class="max-w-md w-full relative z-10">
        
        <!-- Login Card -->
        <div class="rounded-3xl glass-panel p-8 sm:p-10 shadow-xl shadow-slate-200/60">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex h-16 w-16 items-center justify-center mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">
                    PORTAL ADMIN TKJ
                </h2>
                <p class="text-xs text-slate-500 font-mono mt-1.5">
                    Sistem Manajemen Portofolio &bull; I Made Yuda Pramana
                </p>
            </div>

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block font-mono text-xs text-slate-600 mb-2">
                        EMAIL ADMIN <span class="text-blue-600">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           placeholder="admin@tkj.lan"
                           class="glass-input font-mono text-sm">
                </div>

                <div>
                    <label for="password" class="block font-mono text-xs text-slate-600 mb-2">
                        KATA SANDI <span class="text-blue-600">*</span>
                    </label>
                    <input type="password" name="password" id="password" required
                           placeholder="••••••••••••"
                           class="glass-input font-mono text-sm">
                </div>

                <div class="flex items-center justify-between font-mono text-xs">
                    <label class="flex items-center gap-2 text-slate-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-0">
                        <span>Ingat sesi saya</span>
                    </label>
                </div>

                <button type="submit" class="btn-primary w-full py-3.5 text-xs tracking-wider uppercase justify-center">
                    Masuk Panel Admin &rarr;
                </button>
            </form>

            <div class="mt-5 text-center">
                <a href="{{ route('home') }}" class="font-mono text-xs text-slate-500 hover:text-blue-600 transition-colors">
                    &larr; Kembali ke Beranda Publik
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
