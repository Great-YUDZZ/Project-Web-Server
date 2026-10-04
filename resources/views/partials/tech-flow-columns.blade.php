@php
    // Single source of truth for the flowing tech cards using official authentic brand logos.
    $flowTech = [
        'laravel'  => [
            'name'  => 'Laravel 11',
            'role'  => 'Core SSR API',
            'color' => '#FF2D20',
            'rgb'   => '255,45,32',
            'logo'  => 'images/tech_logos/laravel.png',
            'svg'   => 'images/tech/laravel.svg',
        ],
        'tailwind' => [
            'name'  => 'Tailwind v4',
            'role'  => 'UI Design Tokens',
            'color' => '#06B6D4',
            'rgb'   => '6,182,212',
            'logo'  => 'images/tech_logos/tailwind.png',
            'svg'   => 'images/tech/tailwindcss.svg',
        ],
        'vite'     => [
            'name'  => 'Vite 5.x',
            'role'  => '&lt; 12ms HMR',
            'color' => '#BD34FE',
            'rgb'   => '189,52,254',
            'logo'  => 'images/tech_logos/vite.png',
            'svg'   => 'images/tech/vite.svg',
        ],
        'debian'   => [
            'name'  => 'Debian 13',
            'role'  => 'Baremetal Host',
            'color' => '#D70A53',
            'rgb'   => '215,10,83',
            'logo'  => 'images/tech_logos/debian.png',
            'svg'   => 'images/tech/debian.svg',
        ],
        'gsap'     => [
            'name'  => 'GSAP 3',
            'role'  => '60 FPS Motion',
            'color' => '#88CE02',
            'rgb'   => '136,206,2',
            'logo'  => 'images/tech_logos/gsap.png',
            'svg'   => 'images/tech/gsap.svg',
        ],
        'nginx'    => [
            'name'  => 'Nginx 1.26',
            'role'  => 'epoll() Proxy',
            'color' => '#009639',
            'rgb'   => '0,150,57',
            'logo'  => 'images/tech_logos/nginx.png',
            'svg'   => 'images/tech/nginx.svg',
        ],
        'mysql'    => [
            'name'  => 'MySQL 8.4',
            'role'  => 'ACID Storage',
            'color' => '#00758F',
            'rgb'   => '0,117,143',
            'logo'  => 'images/tech_logos/mysql.png',
            'svg'   => 'images/tech/mysql.svg',
        ],
        'threejs'  => [
            'name'  => 'Three.js',
            'role'  => '3D WebGL Canvas',
            'color' => '#FFFFFF',
            'rgb'   => '255,255,255',
            'logo'  => 'images/tech_logos/threejs.png',
            'svg'   => 'images/tech/threejs.svg',
        ],
    ];

    // Columns: outer = always visible (primary, focusable); inner = xl only (decorative duplicates).
    // speed = px/second upward, depth = mouse parallax strength, offset = initial phase (0..1).
    $flowColumns = [
        ['id' => 'left-outer',  'pos' => 'left-[3%] lg:left-[2%]',       'vis' => 'flex',           'speed' => 34, 'depth' => 26,  'offset' => 0.00, 'primary' => true,  'items' => ['laravel', 'gsap', 'debian', 'mysql']],
        ['id' => 'left-inner',  'pos' => 'left-[17%]',                    'vis' => 'hidden xl:flex', 'speed' => 22, 'depth' => 14,  'offset' => 0.55, 'primary' => false, 'items' => ['vite', 'threejs', 'tailwind', 'nginx']],
        ['id' => 'right-inner', 'pos' => 'right-[17%]',                   'vis' => 'hidden xl:flex', 'speed' => 27, 'depth' => -16, 'offset' => 0.30, 'primary' => false, 'items' => ['mysql', 'laravel', 'gsap', 'debian']],
        ['id' => 'right-outer', 'pos' => 'right-[3%] lg:right-[2%]',     'vis' => 'flex',           'speed' => 40, 'depth' => -28, 'offset' => 0.78, 'primary' => true,  'items' => ['tailwind', 'vite', 'nginx', 'threejs']],
    ];
@endphp

<!-- Infinite Vertical Flow Columns (cards rise from bottom, exit at top, re-enter from bottom) -->
<div id="playground-cards-container"
     class="absolute inset-0 w-full max-w-[1400px] mx-auto pointer-events-none [mask-image:linear-gradient(to_bottom,transparent_0%,#000_14%,#000_86%,transparent_100%)]">
    @foreach ($flowColumns as $col)
        <div class="flow-column absolute top-0 bottom-0 {{ $col['pos'] }} {{ $col['vis'] }} w-14 lg:w-[188px] will-change-transform"
             data-column="{{ $col['id'] }}" data-speed="{{ $col['speed'] }}" data-depth="{{ $col['depth'] }}" data-offset="{{ $col['offset'] }}">
            @foreach ($col['items'] as $key)
                @php $t = $flowTech[$key]; @endphp
                <div class="flow-card playground-card absolute left-0 top-0 w-full pointer-events-auto will-change-transform" data-tech-card="{{ $key }}">
                    <button type="button" data-tech="{{ $key }}" aria-haspopup="dialog"
                            aria-label="Lihat detail teknologi {{ $t['name'] }}"
                            @unless ($col['primary']) tabindex="-1" @endunless
                            style="--brand: {{ $t['color'] }}; --brand-rgb: {{ $t['rgb'] }};"
                            class="tech-circle-orb group w-full flex items-center justify-center lg:justify-start gap-3 p-2 lg:p-3 rounded-2xl bg-[#141414]/90 border border-[#1f1f1f] shadow-[0_15px_35px_rgba(0,0,0,0.6)] backdrop-blur-xl cursor-pointer transition-[transform,border-color,box-shadow,background-color] duration-300 hover:scale-[1.06] hover:bg-[#1a1a1a] hover:border-[var(--brand)] hover:shadow-[0_0_32px_rgba(var(--brand-rgb),0.35)] focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--brand)]">
                        <span class="w-10 h-10 lg:w-11 lg:h-11 rounded-xl bg-[#0e0e0e] border border-[#1f1f1f] p-1.5 lg:p-2 flex items-center justify-center shrink-0 transition-all duration-300 group-hover:border-[rgba(var(--brand-rgb),0.6)] group-hover:bg-[#141414] group-hover:shadow-[0_0_16px_rgba(var(--brand-rgb),0.35)]">
                            <img src="{{ asset($t['logo']) }}" alt="{{ $t['name'] }} Logo" class="w-6 h-6 lg:w-7 lg:h-7 object-contain drop-shadow-[0_2px_8px_rgba(0,0,0,0.7)] transition-transform duration-300 group-hover:scale-110" loading="lazy" />
                        </span>
                        <span class="hidden lg:block text-left min-w-0">
                            <span class="flex items-center gap-1.5">
                                <span class="text-sm font-semibold text-[#f5f5f5] group-hover:text-white truncate">{{ $t['name'] }}</span>
                                <span class="w-1.5 h-1.5 rounded-full shrink-0" style="background: {{ $t['color'] }}; box-shadow: 0 0 6px {{ $t['color'] }};"></span>
                            </span>
                            <span class="text-[10px] font-mono text-[#878787] block mt-0.5 truncate">{!! $t['role'] !!}</span>
                        </span>
                    </button>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
