@extends('layouts.app')

@section('title', 'Login Portal Admin TKJ - Yuda Pratama')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
    
    <!-- Ambient Glow -->
    <div class="absolute w-[400px] h-[400px] bg-cyan-500/10 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="max-w-md w-full relative z-10">
        
        <!-- Login Card -->
        <div class="rounded-2xl border border-cyan-500/30 bg-slate-950/80 backdrop-blur-xl p-8 shadow-2xl shadow-cyan-950/50">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex h-12 w-12 rounded-xl bg-cyan-500/20 border border-cyan-500/40 items-center justify-center text-cyan-400 font-mono-code font-black text-xl mb-3">
                    #_
                </div>
                <h2 class="text-2xl font-black text-white tracking-tight">
                    PORTAL ADMIN TKJ
                </h2>
                <p class="text-xs text-slate-400 font-mono-code mt-1">
                    // AUTHENTICATION_GATEWAY
                </p>
            </div>

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block font-mono-code text-xs text-slate-300 mb-2">
                        EMAIL ADMIN <span class="text-rose-400">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', 'admin@tkj.lan') }}" required autofocus
                           placeholder="admin@tkj.lan"
                           class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 text-sm font-mono-code transition-colors">
                </div>

                <div>
                    <label for="password" class="block font-mono-code text-xs text-slate-300 mb-2">
                        KATA SANDI <span class="text-rose-400">*</span>
                    </label>
                    <input type="password" name="password" id="password" required
                           placeholder="••••••••••••"
                           class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 text-sm font-mono-code transition-colors">
                </div>

                <div class="flex items-center justify-between font-mono-code text-xs">
                    <label class="flex items-center gap-2 text-slate-400 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded bg-slate-900 border-slate-800 text-cyan-500 focus:ring-0">
                        <span>Ingat sesi saya</span>
                    </label>
                    <span class="text-slate-500 text-[11px]">RATE_LIMITED</span>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-black font-bold font-mono-code text-sm hover:shadow-lg hover:shadow-cyan-500/25 transition-all">
                    MASUK_ADMIN_PANEL &rarr;
                </button>
            </form>

            <!-- Default Credential Notice for School Evaluation -->
            <div class="mt-8 pt-6 border-t border-slate-800/80 rounded-xl bg-slate-900/40 p-4 font-mono-code text-xs text-slate-400">
                <div class="text-cyan-400 font-bold mb-1 flex items-center gap-1.5">
                    <span>ℹ</span> KREDENSIAL DEFAULT AKUN:
                </div>
                <div class="text-slate-300">Email: <span class="text-white font-semibold">admin@tkj.lan</span></div>
                <div class="text-slate-300">Password: <span class="text-white font-semibold">AdminTKJ2026!</span></div>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" class="font-mono-code text-xs text-slate-500 hover:text-slate-300">
                    &larr; Kembali ke Beranda Publik
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
