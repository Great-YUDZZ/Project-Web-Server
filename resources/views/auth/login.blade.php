@extends('layouts.app')

@section('title', 'Login Portal Admin TKJ | I Made Yuda Pramana')

@section('content')
<div class="min-h-[calc(100vh-14rem)] flex flex-col justify-center items-center py-6 sm:py-10 px-4 sm:px-6 lg:px-8 relative bg-[#0a0a0a] text-stone-100 overflow-hidden">
    <!-- Blueprint Grid Mesh & Low-Emission Radial Ambient -->
    <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.03)_1px,transparent_1px)] bg-[size:32px_32px] pointer-events-none z-0"></div>
    <div class="absolute -top-32 right-1/4 w-[32rem] h-[32rem] rounded-full bg-white/[0.03] blur-3xl pointer-events-none z-0"></div>
    <div class="absolute -bottom-32 left-1/4 w-[28rem] h-[28rem] rounded-full bg-white/[0.02] blur-3xl pointer-events-none z-0"></div>

    <div class="max-w-md w-full relative z-10">
        
        <!-- Enclave Login Card -->
        <div class="rounded-3xl bg-[#141414]/90 backdrop-blur-xl border border-white/10 p-8 sm:p-10 shadow-2xl shadow-black/80">
            
            <!-- Header & Telemetry Identity -->
            <div class="text-center mb-8">
                <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-white/5 border border-white/15 p-3 shadow-lg shadow-black/40 mb-4 group hover:border-white/40 transition-colors">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain filter invert brightness-200">
                </div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/15 text-[11px] font-mono text-stone-300 font-bold uppercase mb-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]"></span>
                    <span>Autentikasi Baremetal | Enclave TLS 1.3</span>
                </div>
                <h2 class="text-2xl font-black text-white tracking-tight uppercase">
                    PORTAL ADMIN TKJ
                </h2>
                <p class="text-xs text-stone-400 font-mono mt-1.5">
                    Sistem Manajemen Portofolio &bull; I Made Yuda Pramana
                </p>
            </div>

            <!-- Error Feedback Boundary -->
            @if($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-rose-950/40 border border-rose-800/60 text-rose-300 text-xs font-mono shadow-xs">
                    <div class="flex items-center gap-2 font-bold mb-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                        <span>Autentikasi Gagal:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 text-[11px] text-rose-300/90">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block font-mono text-xs text-stone-300 font-bold mb-2">
                        EMAIL OPERATOR <span class="text-rose-400">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           placeholder="admin@tkj.lan"
                           class="w-full px-4 py-3 rounded-xl bg-[#0a0a0a] border border-white/15 text-white placeholder-stone-600 font-mono text-sm focus:bg-black focus:outline-none focus:border-white focus:ring-2 focus:ring-white/20 transition-all">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block font-mono text-xs text-stone-300 font-bold">
                            KATA SANDI <span class="text-rose-400">*</span>
                        </label>
                        <span class="text-[10px] font-mono text-stone-500 uppercase">ENKRIPSI AES-256</span>
                    </div>
                    <input type="password" name="password" id="password" required
                           placeholder="••••••••••••"
                           class="w-full px-4 py-3 rounded-xl bg-[#0a0a0a] border border-white/15 text-white placeholder-stone-600 font-mono text-sm focus:bg-black focus:outline-none focus:border-white focus:ring-2 focus:ring-white/20 transition-all">
                </div>

                <div class="flex items-center justify-between font-mono text-xs">
                    <label class="flex items-center gap-2 text-stone-400 cursor-pointer hover:text-stone-200 transition-colors">
                        <input type="checkbox" name="remember" class="rounded border-white/20 bg-[#0a0a0a] text-white focus:ring-white/40 focus:ring-offset-0">
                        <span>Ingat sesi operator</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-xl bg-white text-black text-xs font-mono tracking-wider uppercase font-bold hover:bg-neutral-200 transition-all shadow-lg shadow-white/10 cursor-pointer flex items-center justify-center gap-2 group">
                    <span>Masuk Panel Admin</span>
                    <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                </button>
            </form>

            <div class="mt-6 text-center pt-4 border-t border-white/10">
                <a href="{{ route('home') }}" class="font-mono text-xs text-stone-400 hover:text-white font-semibold transition-colors inline-flex items-center gap-1.5">
                    <span>&larr;</span>
                    <span>Kembali ke Beranda Publik</span>
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
