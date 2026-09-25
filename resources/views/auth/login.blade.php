@extends('layouts.app')

@section('title', 'Login Portal Admin TKJ - I Made Yuda Pramana')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8 relative bg-[#F8F5EE] overflow-hidden">
    <!-- Blueprint Grid Mesh -->
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#0C382E0A_1px,transparent_1px),linear-gradient(to_bottom,#0C382E0A_1px,transparent_1px)] bg-[size:32px_32px] pointer-events-none z-0"></div>
    <div class="absolute -top-24 right-1/4 w-96 h-96 rounded-full bg-gradient-to-b from-[#0C382E]/10 via-transparent to-transparent blur-3xl pointer-events-none z-0"></div>

    <div class="max-w-md w-full relative z-10">
        
        <!-- Login Card -->
        <div class="card-earth rounded-3xl bg-white/95 backdrop-blur-xl border border-stone-300/90 p-8 sm:p-10 shadow-xl shadow-stone-900/05">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-[#0C382E] to-[#165B4C] p-3 shadow-lg shadow-[#0C382E]/20 mb-4 group hover:scale-105 transition-transform">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#0C382E]/08 border border-[#0C382E]/20 text-[11px] font-mono text-[#0C382E] font-bold uppercase mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                    <span>Autentikasi Baremetal</span>
                </div>
                <h2 class="text-2xl font-black text-[#1C1917] tracking-tight uppercase">
                    PORTAL ADMIN TKJ
                </h2>
                <p class="text-xs text-[#57534E] font-mono mt-1.5">
                    Sistem Manajemen Portofolio &bull; I Made Yuda Pramana
                </p>
            </div>

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block font-mono text-xs text-stone-700 font-bold mb-2">
                        EMAIL OPERATOR <span class="text-rose-600">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           placeholder="admin@tkj.lan"
                           class="w-full px-4 py-3 rounded-xl bg-stone-50 border border-stone-300 text-stone-900 placeholder-stone-400 font-mono text-sm focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-2 focus:ring-[#0C382E]/20 transition-all">
                </div>

                <div>
                    <label for="password" class="block font-mono text-xs text-stone-700 font-bold mb-2">
                        KATA SANDI <span class="text-rose-600">*</span>
                    </label>
                    <input type="password" name="password" id="password" required
                           placeholder="••••••••••••"
                           class="w-full px-4 py-3 rounded-xl bg-stone-50 border border-stone-300 text-stone-900 placeholder-stone-400 font-mono text-sm focus:bg-white focus:outline-none focus:border-[#0C382E] focus:ring-2 focus:ring-[#0C382E]/20 transition-all">
                </div>

                <div class="flex items-center justify-between font-mono text-xs">
                    <label class="flex items-center gap-2 text-stone-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-stone-300 text-[#0C382E] focus:ring-[#0C382E]">
                        <span>Ingat sesi saya</span>
                    </label>
                </div>

                <button type="submit" class="btn-earth-green w-full py-3.5 text-xs font-mono tracking-wider uppercase justify-center font-bold shadow-md shadow-[#0C382E]/20 cursor-pointer">
                    Masuk Panel Admin &rarr;
                </button>
            </form>

            <div class="mt-6 text-center pt-4 border-t border-stone-200/80">
                <a href="{{ route('home') }}" class="font-mono text-xs text-stone-500 hover:text-[#0C382E] font-semibold transition-colors">
                    &larr; Kembali ke Beranda Publik
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
