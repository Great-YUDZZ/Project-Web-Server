// Interactive 3D Orrery / Orbital Focus Gallery
// Mathematical 3D Elliptical Orbit Engine with Continuous Self-Rotation, Momentum, Drag, and Depth Sorting

export const initOrreryGallery = () => {
    const container = document.getElementById('orrery-container');
    if (!container) return null;

    const stage = document.getElementById('orrery-stage');
    const orbitRingEl = document.getElementById('orrery-orbit-svg');
    const nodesContainer = document.getElementById('orrery-nodes-container');
    const centerDisplay = document.getElementById('orrery-center-display');
    const hudCounter = document.getElementById('orrery-hud-counter');
    const hudDegree = document.getElementById('orrery-hud-degree');
    const canvasStars = document.getElementById('orrery-stars-canvas');

    if (!stage || !nodesContainer) return null;

    // 8 Technology Stack items with verified inline vector SVGs for 100% render reliability
    const technologies = [
        {
            id: 'laravel',
            name: 'Laravel 13',
            role: 'PHP Framework',
            category: 'Backend MVC Architecture',
            color: '#FF2D20',
            badgeBg: 'rgba(255, 45, 32, 0.14)',
            badgeBorder: 'rgba(255, 45, 32, 0.4)',
            badgeText: '#f87171',
            orbImg: '/images/orrery/laravel_orb.webp',
            linkUrl: 'https://laravel.com',
            desc: 'Framework PHP modern dengan arsitektur MVC elegan, routing cepat, middleware otentikasi, proteksi rate-limiting, dan integrasi ORM Eloquent.',
            labNote: 'Menjalankan aplikasi web portofolio dengan arsitektur MVC, Eloquent ORM, rate limiter 5 percobaan pada auth login, dan middleware proteksi rute admin.',
            svg: `<svg class="w-full h-full" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="#FF2D20" d="M23.642 5.43a.364.364 0 01.014.1v5.149c0 .135-.073.26-.189.326l-4.323 2.49v4.934a.378.378 0 01-.188.326L9.93 23.949a.316.316 0 01-.066.027c-.008.002-.016.008-.024.01a.348.348 0 01-.192 0c-.011-.002-.02-.008-.03-.012-.02-.008-.042-.014-.062-.025L.533 18.755a.376.376 0 01-.189-.326V2.974c0-.033.005-.066.014-.098.003-.012.01-.02.014-.032a.369.369 0 01.023-.058c.004-.013.015-.022.023-.033l.033-.045c.012-.01.025-.018.037-.027.014-.012.027-.024.041-.034H.53L5.043.05a.375.375 0 01.375 0L9.93 2.647h.002c.015.01.027.021.04.033l.038.027c.013.014.02.03.033.045.008.011.02.021.025.033.01.02.017.038.024.058.003.011.01.021.013.032.01.031.014.064.014.098v9.652l3.76-2.164V5.527c0-.033.004-.066.013-.098.003-.01.01-.02.013-.032a.487.487 0 01.024-.059c.007-.012.018-.02.025-.033.012-.015.021-.03.033-.043.012-.012.025-.02.037-.028.014-.01.026-.023.041-.032h.001l4.513-2.598a.375.375 0 01.375 0l4.513 2.598c.016.01.027.021.042.031.012.01.025.018.036.028.013.014.022.03.034.044.008.012.019.021.024.033.011.02.018.04.024.06.006.01.012.021.015.032zm-.74 5.032V6.179l-1.578.908-2.182 1.256v4.283zm-4.51 7.75v-4.287l-2.147 1.225-6.126 3.498v4.325zM1.093 3.624v14.588l8.273 4.761v-4.325l-4.322-2.445-.002-.003H5.04c-.014-.01-.025-.021-.04-.031-.011-.01-.024-.018-.035-.027l-.001-.002c-.013-.012-.021-.025-.031-.04-.01-.011-.021-.022-.028-.036h-.002c-.008-.014-.013-.031-.02-.047-.006-.016-.014-.027-.018-.043a.49.49 0 01-.008-.057c-.002-.014-.006-.027-.006-.041V5.789l-2.18-1.257zM5.23.81L1.47 2.974l3.76 2.164 3.758-2.164zm1.956 13.505l2.182-1.256V3.624l-1.58.91-2.182 1.255v9.435zm11.581-10.95l-3.76 2.163 3.76 2.163 3.759-2.164zm-.376 4.978L16.21 7.087 14.63 6.18v4.283l2.182 1.256 1.58.908zm-8.65 9.654l5.514-3.148 2.756-1.572-3.757-2.163-4.323 2.489-3.941 2.27z"/></svg>`
        },
        {
            id: 'php',
            name: 'PHP 8.4',
            role: 'FPM Engine',
            category: 'FastCGI Process Engine',
            color: '#777BB4',
            badgeBg: 'rgba(119, 123, 180, 0.14)',
            badgeBorder: 'rgba(119, 123, 180, 0.4)',
            badgeText: '#a5b4fc',
            orbImg: '/images/orrery/php_orb.webp',
            linkUrl: 'https://www.php.net',
            desc: 'Mesin eksekusi PHP versi 8.4 berkinerja tinggi terhubung langsung ke Nginx melalui UNIX Domain Socket unix:/run/php/php8.4-fpm.sock untuk latensi terendah.',
            labNote: 'Dijalankan sebagai daemon systemd php8.4-fpm, mendengarkan di socket unix:/run/php/php8.4-fpm.sock untuk performa throughput tinggi.',
            svg: `<svg class="w-full h-full" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="#777BB4" d="M7.01 10.207h-.944l-.515 2.648h.838c.556 0 .97-.105 1.242-.314.272-.21.455-.559.55-1.049.092-.47.05-.802-.124-.995-.175-.193-.523-.29-1.047-.29zM12 5.688C5.373 5.688 0 8.514 0 12s5.373 6.313 12 6.313S24 15.486 24 12c0-3.486-5.373-6.312-12-6.312zm-3.26 7.451c-.261.25-.575.438-.917.551-.336.108-.765.164-1.285.164H5.357l-.327 1.681H3.652l1.23-6.326h2.65c.797 0 1.378.209 1.744.628.366.418.476 1.002.33 1.752a2.836 2.836 0 0 1-.305.847c-.143.255-.33.49-.561.703zm4.024.715l.543-2.799c.063-.318.039-.536-.068-.651-.107-.116-.336-.174-.687-.174H11.46l-.704 3.625H9.388l1.23-6.327h1.367l-.327 1.682h1.218c.767 0 1.295.134 1.586.401s.378.7.263 1.299l-.572 2.944h-1.389zm7.597-2.265a2.782 2.782 0 0 1-.305.847c-.143.255-.33.49-.561.703a2.44 2.44 0 0 1-.917.551c-.336.108-.765.164-1.286.164h-1.18l-.327 1.682h-1.378l1.23-6.326h2.649c.797 0 1.378.209 1.744.628.366.417.477 1.001.331 1.751zM17.766 10.207h-.943l-.516 2.648h.838c.557 0 .971-.105 1.242-.314.272-.21.455-.559.551-1.049.092-.47.049-.802-.125-.995s-.524-.29-1.047-.29z"/></svg>`
        },
        {
            id: 'tailwind',
            name: 'Tailwind CSS',
            role: 'v4 Engine',
            category: 'Utility-First Design System',
            color: '#06B6D4',
            badgeBg: 'rgba(6, 182, 212, 0.14)',
            badgeBorder: 'rgba(6, 182, 212, 0.4)',
            badgeText: '#38bdf8',
            orbImg: '/images/orrery/tailwind_orb.webp',
            linkUrl: 'https://tailwindcss.com',
            desc: 'Sistem desain utilitas generasi terbaru (v4) dikompilasi langsung melalui @tailwindcss/vite dengan tema void black, cyber crimson, dan tipografi presisi.',
            labNote: 'Dikompilasi langsung menggunakan @tailwindcss/vite dengan tema gelap void black dan sistem utilitas modern tanpa overhead runtime.',
            svg: `<svg class="w-full h-full" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="#06B6D4" d="M12.001,4.8c-3.2,0-5.2,1.6-6,4.8c1.2-1.6,2.6-2.2,4.2-1.8c0.913,0.228,1.565,0.89,2.288,1.624 C13.666,10.618,15.027,12,18.001,12c3.2,0,5.2-1.6,6-4.8c-1.2,1.6-2.6,2.2-4.2,1.8c-0.913-0.228-1.565-0.89-2.288-1.624 C16.337,6.182,14.976,4.8,12.001,4.8z M6.001,12c-3.2,0-5.2,1.6-6,4.8c1.2-1.6,2.6-2.2,4.2-1.8c0.913,0.228,1.565,0.89,2.288,1.624 c1.177,1.194,2.538,2.576,5.512,2.576c3.2,0,5.2-1.6,6-4.8c-1.2,1.6-2.6,2.2-4.2,1.8c-0.913-0.228-1.565-0.89-2.288-1.624 C10.337,13.382,8.976,12,6.001,12z"/></svg>`
        },
        {
            id: 'vite',
            name: 'Vite',
            role: 'Asset Bundler',
            category: 'Next-Gen Build Toolchain',
            color: '#646CFF',
            badgeBg: 'rgba(100, 108, 255, 0.14)',
            badgeBorder: 'rgba(100, 108, 255, 0.4)',
            badgeText: '#818cf8',
            orbImg: '/images/orrery/vite_orb.webp',
            linkUrl: 'https://vite.dev',
            desc: 'Frontend tooling berbasis ESM native dengan kompilasi instan, modul Hot Module Replacement (HMR) super responsif, dan optimasi bundle aset produksi.',
            labNote: 'Bundler modul modern untuk kompilasi berkas app.css dan app.js dengan Hot Module Replacement (HMR) dan minifikasi aset produksi.',
            svg: `<svg class="w-full h-full" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="#646CFF" d="m8.286 10.578.512-8.657a.306.306 0 0 1 .247-.282L17.377.006a.306.306 0 0 1 .353.385l-1.558 5.403a.306.306 0 0 0 .352.385l2.388-.46a.306.306 0 0 1 .332.438l-6.79 13.55-.123.19a.294.294 0 0 1-.252.14c-.177 0-.35-.152-.305-.369l1.095-5.301a.306.306 0 0 0-.388-.355l-1.433.435a.306.306 0 0 1-.389-.354l.69-3.375a.306.306 0 0 0-.37-.36l-2.32.536a.306.306 0 0 1-.374-.316zm14.976-7.926L17.284 3.74l-.544 1.887 2.077-.4a.8.8 0 0 1 .84.369.8.8 0 0 1 .034.783L12.9 19.93l-.013.025-.015.023-.122.19a.801.801 0 0 1-.672.37.826.826 0 0 1-.634-.302.8.8 0 0 1-.16-.67l1.029-4.981-1.12.34a.81.81 0 0 1-.86-.262.802.802 0 0 1-.165-.67l.63-3.08-2.027.468a.808.808 0 0 1-.768-.233.81.81 0 0 1-.217-.6l.389-6.57-7.44-1.33a.612.612 0 0 0-.64.906L11.58 23.691a.612.612 0 0 0 1.066-.004l11.26-20.135a.612.612 0 0 0-.644-.9z"/></svg>`
        },
        {
            id: 'nginx',
            name: 'Nginx 1.26',
            role: 'Web Server',
            category: 'Reverse Proxy & Static Cache',
            color: '#009639',
            badgeBg: 'rgba(0, 150, 57, 0.14)',
            badgeBorder: 'rgba(0, 150, 57, 0.4)',
            badgeText: '#34d399',
            orbImg: '/images/orrery/nginx_orb.webp',
            linkUrl: 'https://nginx.org',
            desc: 'Web server performa tinggi yang menangani permintaan HTTP/2, caching aset statis 30 hari, penolakan akses dotfiles, dan fastcgi_pass socket aman.',
            labNote: 'Server blok vhost menangani HTTP/2, reverse proxy socket FastCGI PHP-FPM, isolasi dotfiles, serta caching aset statis 30 hari.',
            svg: `<svg class="w-full h-full" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="#009639" d="M12 0L1.605 6v12L12 24l10.395-6V6L12 0zm6 16.59c0 .705-.646 1.29-1.529 1.29-.631 0-1.351-.255-1.801-.81l-6-7.141v6.66c0 .721-.57 1.29-1.274 1.29H7.32c-.721 0-1.29-.6-1.29-1.29V7.41c0-.705.63-1.29 1.5-1.29.646 0 1.38.255 1.83.81l5.97 7.141V7.41c0-.721.6-1.29 1.29-1.29h.075c.72 0 1.29.6 1.29 1.29v9.18H18z"/></svg>`
        },
        {
            id: 'mariadb',
            name: 'MariaDB 11.8',
            role: 'SQL Database',
            category: 'Relational Database Engine',
            color: '#00758F',
            badgeBg: 'rgba(0, 117, 143, 0.14)',
            badgeBorder: 'rgba(0, 117, 143, 0.4)',
            badgeText: '#38bdf8',
            orbImg: '/images/orrery/mariadb_orb.webp',
            linkUrl: 'https://mariadb.org',
            desc: 'Sistem manajemen database relasional SQL dengan storage engine InnoDB untuk persistensi data sertifikat, proyek topologi lab, dan pesan masuk.',
            labNote: 'Database relasional SQL dengan storage engine InnoDB untuk persistensi sertifikat, proyek topologi lab, dan pesan formulir kontak.',
            svg: `<svg class="w-full h-full" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="#00758F" d="M23.157 4.412c-.676.284-.79.31-1.673.372-.65.045-.757.057-1.212.209-.75.246-1.395.75-2.02 1.59-.296.398-1.249 1.913-1.249 1.988 0 .057-.65.998-.915 1.32-.574.713-1.08 1.079-2.14 1.59-.77.36-1.224.524-4.102 1.477-1.073.353-2.133.738-2.367.864-.852.449-1.515 1.036-2.203 1.938-1.003 1.32-.972 1.313-3.042.947a12.264 12.264 0 00-.675-.063c-.644-.05-1.023.044-1.332.334L0 17.193l.177.088c.094.05.353.234.561.398.215.17.461.347.55.391.088.044.17.088.183.101.012.013-.089.17-.228.353-.435.581-.593.871-.574 1.048.019.164.032.17.43.17.517-.006.826-.056 1.261-.208.65-.233 2.058-.94 2.784-1.4.776-.5 1.717-.998 1.956-1.042.082-.02.354-.07.594-.114.58-.107 1.464-.095 2.587.05.108.013.373.045.6.064.227.025.43.057.454.076.026.012.474.037.998.056.934.026 1.104.007 1.3-.189.126-.133.385-.631.498-.985.209-.643.417-.921.366-.492-.113.966-.322 1.692-.713 2.411-.259.499-.663 1.092-.934 1.395-.322.347-.315.36.088.315.619-.063 1.471-.397 2.096-.82.827-.562 1.647-1.691 2.19-3.03.107-.27.22-.22.183.083-.013.094-.038.315-.057.498l-.031.328.353-.202c.833-.48 1.414-1.262 2.127-2.884.227-.518.877-2.922 1.073-3.976a9.64 9.64 0 01.271-1.042c.127-.429.196-.555.48-.858.183-.19.625-.555.978-.808.72-.505.953-.75 1.187-1.205.208-.417.284-1.13.132-1.357-.132-.202-.284-.196-.763.006Z"/></svg>`
        },
        {
            id: 'javascript',
            name: 'JavaScript',
            role: 'Canvas & UI',
            category: 'Interactive Client Engine',
            color: '#F7DF1E',
            badgeBg: 'rgba(247, 223, 30, 0.14)',
            badgeBorder: 'rgba(247, 223, 30, 0.4)',
            badgeText: '#facc15',
            orbImg: '/images/orrery/javascript_orb.webp',
            linkUrl: 'https://developer.mozilla.org/en-US/docs/Web/JavaScript',
            desc: 'Skrip antarmuka modern ES6+ untuk kalkulasi fisika 3D orbit matematis, efek galeri coverflow sentuh, animasi partikel canvas, dan manipulasi DOM dinamis.',
            labNote: 'Skrip antarmuka native ES6+ untuk kalkulasi trigonometri elips 3D orrery, deteksi gestur sentuh, dan animasi canvas 60 FPS.',
            svg: `<svg class="w-full h-full" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="#F7DF1E" d="M0 0h24v24H0V0zm22.034 18.276c-.175-1.095-.888-2.015-3.003-2.873-.736-.345-1.554-.585-1.797-1.14-.091-.33-.105-.51-.046-.705.15-.646.915-.84 1.515-.66.39.12.75.42.976.9 1.034-.676 1.034-.676 1.755-1.125-.27-.42-.404-.601-.586-.78-.63-.705-1.469-1.065-2.834-1.034l-.705.089c-.676.165-1.32.525-1.71 1.005-1.14 1.291-.811 3.541.569 4.471 1.365 1.02 3.361 1.244 3.616 2.205.24 1.17-.87 1.545-1.966 1.41-.811-.18-1.26-.586-1.755-1.336l-1.83 1.051c.21.48.45.689.81 1.109 1.74 1.756 6.09 1.666 6.871-1.004.029-.09.24-.705.074-1.65l.046.067zm-8.983-7.245h-2.248c0 1.938-.009 3.864-.009 5.805 0 1.232.063 2.363-.138 2.711-.33.689-1.18.601-1.566.48-.396-.196-.597-.466-.83-.855-.063-.105-.11-.196-.127-.196l-1.825 1.125c.305.63.75 1.172 1.324 1.517.855.51 2.004.675 3.207.405.783-.226 1.458-.691 1.811-1.411.51-.93.402-2.07.397-3.346.012-2.054 0-4.109 0-6.179l.004-.056z"/></svg>`
        },
        {
            id: 'debian',
            name: 'Debian 13',
            role: 'Host Linux OS',
            category: 'Baremetal Operating System',
            color: '#D70A53',
            badgeBg: 'rgba(215, 10, 83, 0.14)',
            badgeBorder: 'rgba(215, 10, 83, 0.4)',
            badgeText: '#fb7185',
            orbImg: '/images/orrery/debian_orb.webp',
            linkUrl: 'https://www.debian.org',
            desc: 'Sistem operasi Linux Debian 13 (Trixie) baremetal yang stabil, aman, dan menjadi fondasi infrastruktur seluruh tumpukan LEMP server mandiri ini.',
            labNote: 'Sistem operasi baremetal host Linux 64-bit yang menjadi fondasi infrastruktur seluruh tumpukan LEMP server mandiri ini.',
            svg: `<svg class="w-full h-full" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="#D70A53" d="M13.88 12.685c-.4 0 .08.2.601.28.14-.1.27-.22.39-.33a3.001 3.001 0 01-.99.05m2.14-.53c.23-.33.4-.69.47-1.06-.06.27-.2.5-.33.73-.75.47-.07-.27 0-.56-.8 1.01-.11.6-.14.89m.781-2.05c.05-.721-.14-.501-.2-.221.07.04.13.5.2.22M12.38.31c.2.04.45.07.42.12.23-.05.28-.1-.43-.12m.43.12l-.15.03.14-.01V.43m6.633 9.944c.02.64-.2.95-.38 1.5l-.35.181c-.28.54.03.35-.17.78-.44.39-1.34 1.22-1.62 1.301-.201 0 .14-.25.19-.34-.591.4-.481.6-1.371.85l-.03-.06c-2.221 1.04-5.303-1.02-5.253-3.842-.03.17-.07.13-.12.2a3.551 3.552 0 012.001-3.501 3.361 3.362 0 013.732.48 3.341 3.342 0 00-2.721-1.3c-1.18.01-2.281.76-2.651 1.57-.6.38-.67 1.47-.93 1.661-.361 2.601.66 3.722 2.38 5.042.27.19.08.21.12.35a4.702 4.702 0 01-1.53-1.16c.23.33.47.66.8.91-.55-.18-1.27-1.3-1.48-1.35.93 1.66 3.78 2.921 5.261 2.3a6.203 6.203 0 01-2.33-.28c-.33-.16-.77-.51-.7-.57a5.802 5.803 0 005.902-.84c.44-.35.93-.94 1.07-.95-.2.32.04.16-.12.44.44-.72-.2-.3.46-1.24l.24.33c-.09-.6.74-1.321.66-2.262.19-.3.2.3 0 .97.29-.74.08-.85.15-1.46.08.2.18.42.23.63-.18-.7.2-1.2.28-1.6-.09-.05-.28.3-.32-.53 0-.37.1-.2.14-.28-.08-.05-.26-.32-.38-.861.08-.13.22.33.34.34-.08-.42-.2-.75-.2-1.08-.34-.68-.12.1-.4-.3-.34-1.091.3-.25.34-.74.54.77.84 1.96.981 2.46-.1-.6-.28-1.2-.49-1.76.16.07-.26-1.241.21-.37A7.823 7.824 0 0017.702 1.6c.18.17.42.39.33.42-.75-.45-.62-.48-.73-.67-.61-.25-.65.02-1.06 0C15.082.73 14.862.8 13.8.4l.05.23c-.77-.25-.9.1-1.73 0-.05-.04.27-.14.53-.18-.741.1-.701-.14-1.431.03.17-.13.36-.21.55-.32-.6.04-1.44.35-1.18.07C9.6.68 7.847 1.3 6.867 2.22L6.838 2c-.45.54-1.96 1.611-2.08 2.311l-.131.03c-.23.4-.38.85-.57 1.261-.3.52-.45.2-.4.28-.6 1.22-.9 2.251-1.16 3.102.18.27 0 1.65.07 2.76-.3 5.463 3.84 10.776 8.363 12.006.67.23 1.65.23 2.49.25-.99-.28-1.12-.15-2.08-.49-.7-.32-.85-.7-1.34-1.13l.2.35c-.971-.34-.57-.42-1.361-.67l.21-.27c-.31-.03-.83-.53-.97-.81l-.34.01c-.41-.501-.63-.871-.61-1.161l-.111.2c-.13-.21-1.52-1.901-.8-1.511-.13-.12-.31-.2-.5-.55l.14-.17c-.35-.44-.64-1.02-.62-1.2.2.24.32.3.45.33-.88-2.172-.93-.12-1.601-2.202l.15-.02c-.1-.16-.18-.34-.26-.51l.06-.6c-.63-.74-.18-3.102-.09-4.402.07-.54.53-1.1.88-1.981l-.21-.04c.4-.71 2.341-2.872 3.241-2.761.43-.55-.09 0-.18-.14.96-.991 1.26-.7 1.901-.88.7-.401-.6.16-.27-.151 1.2-.3.85-.7 2.421-.85.16.1-.39.14-.52.26 1-.49 3.151-.37 4.562.27 1.63.77 3.461 3.011 3.531 5.132l.08.02c-.04.85.13 1.821-.17 2.711l.2-.42M9.54 13.236l-.05.28c.26.35.47.73.8 1.01-.24-.47-.42-.66-.75-1.3m.62-.02c-.14-.15-.22-.34-.31-.52.08.32.26.6.43.88l-.12-.36m10.945-2.382l-.07.15c-.1.76-.34 1.511-.69 2.212.4-.73.65-1.541.75-2.362M12.45.12c.27-.1.66-.05.95-.12-.37.03-.74.05-1.1.1l.15.02M3.006 5.142c.07.57-.43.8.11.42.3-.66-.11-.18-.1-.42m-.64 2.661c.12-.39.15-.62.2-.84-.35.44-.17.53-.2.83"/></svg>`
        }
    ];

    const totalNodes = technologies.length;
    let rotationAngle = 0; // Current angle in radians
    let targetAngle = null; // Target angle when a specific orb is clicked
    
    // Continuous self-rotation: constant angular speed (radians per second)
    // 0.12 rad/sec corresponds to ~6.9 deg/sec (~52 seconds per full revolution)
    // provides a serene, elegant, and readable rotation
    const baseAutoSpeed = 0.12;
    let currentSpeed = baseAutoSpeed;
    let isDragging = false;
    let lastDragX = 0;
    let activeIndex = -1;
    let autoSpinResumeTimeout = null;
    let lastTime = performance.now();

    // Responsive ellipse dimensions calculated directly from the stage
    let orbitWidth = 440;
    let orbitHeight = 125;
    let centerX = 0;
    let centerY = 0;

    // Subtle background stars canvas
    const initStars = () => {
        if (!canvasStars) return null;
        const ctx = canvasStars.getContext('2d');
        if (!ctx) return null;

        let stars = [];
        const resizeCanvas = () => {
            canvasStars.width = container.clientWidth;
            canvasStars.height = container.clientHeight;
            stars = [];
            const numStars = Math.floor((canvasStars.width * canvasStars.height) / 6000);
            for (let i = 0; i < numStars; i++) {
                stars.push({
                    x: Math.random() * canvasStars.width,
                    y: Math.random() * canvasStars.height,
                    radius: Math.random() * 1.2 + 0.4,
                    alpha: Math.random() * 0.5 + 0.2,
                    speed: Math.random() * 0.002 + 0.001
                });
            }
        };

        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        return () => {
            ctx.clearRect(0, 0, canvasStars.width, canvasStars.height);
            for (let i = 0; i < stars.length; i++) {
                const s = stars[i];
                s.alpha += Math.sin(Date.now() * s.speed) * 0.004;
                const safeAlpha = Math.max(0.1, Math.min(0.7, s.alpha));
                ctx.beginPath();
                ctx.arc(s.x, s.y, s.radius, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(226, 232, 240, ${safeAlpha})`;
                ctx.fill();
            }
        };
    };

    const drawStarsFn = initStars();

    // Clear existing nodes container
    nodesContainer.innerHTML = '';

    // Create DOM nodes for each technology using 3D Blender planetary orbs
    const nodeElements = technologies.map((tech, index) => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'orrery-node group absolute rounded-full cursor-pointer transition-transform duration-300 focus:outline-none select-none';
        btn.setAttribute('aria-label', `Fokus teknologi ${tech.name}`);
        btn.style.width = '88px';
        btn.style.height = '88px';
        btn.style.transform = 'translate(-50%, -50%)';

        btn.innerHTML = `
            <div class="orrery-node-inner relative w-full h-full flex items-center justify-center transition-all duration-300">
                <div class="orrery-node-glow absolute inset-2 rounded-full blur-md opacity-30 group-hover:opacity-90 transition-opacity duration-300 pointer-events-none"
                     style="background: radial-gradient(circle, ${tech.color}90, transparent 70%);"></div>
                <img src="${tech.orbImg}" alt="${tech.name}" width="70" height="70"
                     class="orrery-node-img relative z-10 w-full h-full object-contain pointer-events-none transition-transform duration-300 filter drop-shadow-[0_4px_12px_rgba(15,23,42,0.12)]"
                     loading="eager" decoding="async"
                     onerror="this.onerror=null; this.src='${tech.orbImg.replace('.webp', '.png')}';">
                <div class="orrery-node-badge absolute -bottom-6 left-1/2 -translate-x-1/2 whitespace-nowrap px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold tracking-tight text-slate-800 bg-white/95 border border-slate-200 pointer-events-none shadow-md transition-all duration-300 opacity-85 backdrop-blur-sm">
                    ${tech.name}
                </div>
            </div>
        `;

        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            rotateToNode(index);
        });

        // Double-click on orbiting node opens tech detail modal
        btn.addEventListener('dblclick', (e) => {
            e.stopPropagation();
            if (typeof window.openOrreryTechModal === 'function') {
                window.openOrreryTechModal(tech);
            }
        });

        nodesContainer.appendChild(btn);
        return { el: btn, tech, index };
    });

    // Update dimensions from the stage viewport
    const updateDimensions = () => {
        const stageWidth = stage.clientWidth || container.clientWidth;
        const stageHeight = stage.clientHeight || 560;

        centerX = stageWidth / 2;
        if (stageWidth < 480) {
            orbitWidth = stageWidth * 0.44;
            orbitHeight = 125;
            centerY = stageHeight * 0.44;
        } else if (stageWidth < 768) {
            orbitWidth = stageWidth * 0.42;
            orbitHeight = 138;
            centerY = stageHeight * 0.44;
        } else if (stageWidth < 1024) {
            orbitWidth = Math.min(390, stageWidth * 0.38);
            orbitHeight = 148;
            centerY = stageHeight * 0.44;
        } else {
            orbitWidth = Math.min(460, stageWidth * 0.38);
            orbitHeight = 165;
            centerY = stageHeight * 0.44;
        }

        // Dynamically adjust node element size for mobile vs desktop
        const isMobile = stageWidth < 640;
        const nodeSize = isMobile ? 66 : 88;
        nodeElements.forEach(({ el }) => {
            el.style.width = `${nodeSize}px`;
            el.style.height = `${nodeSize}px`;
        });

        // Update SVG orbit ring
        if (orbitRingEl) {
            orbitRingEl.innerHTML = `
                <!-- Outer subtle guide ring -->
                <ellipse cx="${centerX}" cy="${centerY}" rx="${orbitWidth}" ry="${orbitHeight}"
                         fill="none"
                         stroke="rgba(148, 163, 184, 0.45)"
                         stroke-width="1"
                         class="opacity-60" />
                <!-- Primary astrolabe precision dashed orbit -->
                <ellipse cx="${centerX}" cy="${centerY}" rx="${orbitWidth}" ry="${orbitHeight}"
                         fill="none"
                         stroke="url(#orrery-ring-gradient)"
                         stroke-width="2"
                         stroke-dasharray="5 7"
                         class="opacity-75 animate-pulse" />
                <!-- Subtle cyan neon glow underlay -->
                <ellipse cx="${centerX}" cy="${centerY}" rx="${orbitWidth}" ry="${orbitHeight}"
                         fill="none"
                         stroke="rgba(56, 189, 248, 0.2)"
                         stroke-width="3"
                         class="blur-[2px] opacity-40" />
                <defs>
                    <linearGradient id="orrery-ring-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#FF2D20" stop-opacity="0.85" />
                        <stop offset="25%" stop-color="#0284C7" stop-opacity="0.85" />
                        <stop offset="50%" stop-color="#6366F1" stop-opacity="0.9" />
                        <stop offset="75%" stop-color="#009639" stop-opacity="0.85" />
                        <stop offset="100%" stop-color="#D70A53" stop-opacity="0.85" />
                    </linearGradient>
                </defs>
            `;
        }
    };

    updateDimensions();
    window.addEventListener('resize', updateDimensions);

    // Rotate orbit to land clicked node at the front (theta = PI / 2)
    const rotateToNode = (index) => {
        if (autoSpinResumeTimeout) {
            clearTimeout(autoSpinResumeTimeout);
            autoSpinResumeTimeout = null;
        }

        const baseAngle = (index * 2 * Math.PI) / totalNodes;
        let desiredAngle = (Math.PI / 2) - baseAngle;

        const twoPi = 2 * Math.PI;
        desiredAngle = ((desiredAngle % twoPi) + twoPi) % twoPi;
        let currentNorm = ((rotationAngle % twoPi) + twoPi) % twoPi;
        let diff = desiredAngle - currentNorm;
        if (diff > Math.PI) diff -= twoPi;
        if (diff < -Math.PI) diff += twoPi;

        targetAngle = rotationAngle + diff;
    };

    // Update center focal logo core display
    const updateCenterDisplay = (tech, index) => {
        if (!centerDisplay) return;
        if (activeIndex === index && centerDisplay.dataset.activeId === tech.id) return;

        activeIndex = index;
        centerDisplay.dataset.activeId = tech.id;

        const currentCore = centerDisplay.querySelector('.orrery-center-core');
        if (currentCore) {
            currentCore.style.opacity = '0';
            currentCore.style.transform = 'scale(0.92)';
        }

        setTimeout(() => {
            centerDisplay.innerHTML = `
                <div class="orrery-center-core" data-tech-id="${tech.id}" title="Klik 2x untuk melihat deskripsi lengkap ${tech.name}">
                    <!-- Ambient Radiant Glow Aura -->
                    <div class="orrery-core-glow" style="background: radial-gradient(circle, ${tech.color}45, transparent 70%);"></div>

                    <!-- Focal Central 3D Planetary Orb -->
                    <div class="orrery-core-orb-3d relative z-10 w-28 h-28 sm:w-36 sm:h-36 flex items-center justify-center filter drop-shadow-[0_8px_24px_rgba(15,23,42,0.16)] transition-transform duration-300 hover:scale-105">
                        <img src="${tech.orbImg}" alt="${tech.name} 3D Planetary Orb" width="144" height="144" class="w-full h-full object-contain pointer-events-none select-none" loading="eager" decoding="async" onerror="this.onerror=null; this.src='${tech.orbImg.replace('.webp', '.png')}';">
                    </div>

                    <!-- Tech Identification & High-Contrast Legible Dark Typography -->
                    <div class="orrery-core-info mt-1.5 flex flex-col items-center text-center">
                        <h4 class="text-base sm:text-lg font-extrabold text-slate-950 tracking-tight flex items-center justify-center gap-1.5 drop-shadow-sm">
                            <span>${tech.name}</span>
                            <span class="inline-block w-2 h-2 rounded-full shadow-sm" style="background: ${tech.color}; box-shadow: 0 0 8px ${tech.color}"></span>
                        </h4>
                        <div class="text-[11px] sm:text-xs font-mono font-medium text-slate-600">
                            ${tech.role}
                        </div>
                        <button type="button" class="orrery-core-detail-btn inline-flex items-center gap-1.5 mt-1 sm:mt-1.5 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-[11px] font-mono font-semibold text-slate-800 hover:text-slate-950 bg-white/90 hover:bg-white border border-slate-300/80 hover:border-slate-400 shadow-sm transition-all cursor-pointer backdrop-blur-sm" title="Buka detail teknologi">
                            <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background: ${tech.color}"></span>
                            <span>Klik 2x / tap detail</span>
                        </button>
                    </div>
                </div>
            `;

            const newCore = centerDisplay.querySelector('.orrery-center-core');
            if (newCore) {
                newCore.style.opacity = '1';
                newCore.style.transform = 'scale(1)';

                // Double-click on center core opens modal
                newCore.addEventListener('dblclick', (e) => {
                    e.stopPropagation();
                    if (typeof window.openOrreryTechModal === 'function') {
                        window.openOrreryTechModal(tech);
                    }
                });

                // Detail button click opens modal (for mobile/touch users)
                const detailBtn = newCore.querySelector('.orrery-core-detail-btn');
                if (detailBtn) {
                    detailBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        if (typeof window.openOrreryTechModal === 'function') {
                            window.openOrreryTechModal(tech);
                        }
                    });
                }
            }
        }, 70);

        // Update HUD indicators
        if (hudCounter) {
            hudCounter.textContent = `${String(index + 1).padStart(2, '0')} / ${String(totalNodes).padStart(2, '0')}`;
        }
    };

    // Main animation loop: Runs continuously at constant delta-time velocity
    const render = (now) => {
        const dt = Math.min((now - lastTime) / 1000, 0.1);
        lastTime = now;

        // Background starry canvas
        if (drawStarsFn) drawStarsFn();

        // Smooth physics interpolation
        if (targetAngle !== null) {
            const diff = targetAngle - rotationAngle;
            rotationAngle += diff * Math.min(1, 4.5 * dt);
            if (Math.abs(diff) < 0.0008) {
                rotationAngle = targetAngle;
                targetAngle = null;
                // Schedule auto-spin resumption
                if (!autoSpinResumeTimeout) {
                    autoSpinResumeTimeout = setTimeout(() => {
                        targetAngle = null;
                        autoSpinResumeTimeout = null;
                    }, 4000);
                }
            }
        } else if (!isDragging) {
            // Apply inertial friction or constant cruise speed
            if (Math.abs(currentSpeed) > Math.abs(baseAutoSpeed)) {
                currentSpeed *= Math.pow(0.92, dt * 60);
                rotationAngle += currentSpeed * dt;
            } else {
                rotationAngle += baseAutoSpeed * dt;
            }
        }

        // Keep angle bounded in [0, 2*PI)
        const twoPi = 2 * Math.PI;
        rotationAngle = ((rotationAngle % twoPi) + twoPi) % twoPi;

        // Update HUD degree reading
        if (hudDegree) {
            const deg = Math.round((rotationAngle * 180) / Math.PI) % 360;
            hudDegree.textContent = `${String(deg).padStart(3, '0')}°`;
        }

        // Calculate 3D orbital node positions
        let maxZ = -Infinity;
        let frontNodeIndex = 0;

        const calculatedPositions = nodeElements.map(({ el, tech, index }) => {
            const baseTheta = (index * 2 * Math.PI) / totalNodes;
            const theta = rotationAngle + baseTheta;

            // Parametric ellipse in stage coordinates
            const x = centerX + orbitWidth * Math.cos(theta);
            const y = centerY + orbitHeight * Math.sin(theta);
            const z = Math.sin(theta); // Front is +1, Back is -1

            if (z > maxZ) {
                maxZ = z;
                frontNodeIndex = index;
            }

            // High-visibility depth scaling (responsive for mobile screens)
            const normZ = (z + 1) / 2; // 0 (far) to 1 (near)
            const isMobile = window.innerWidth < 640;
            const minScale = isMobile ? 0.72 : 0.75;
            const addScale = isMobile ? 0.28 : 0.40;
            const scale = minScale + addScale * normZ;
            const opacity = 0.72 + 0.28 * normZ;
            const zIndex = Math.round(15 + normZ * 40);

            return { el, tech, index, x, y, scale, opacity, zIndex, z };
        });

        // Apply transforms, opacities, and highlights
        calculatedPositions.forEach(({ el, tech, index, x, y, scale, opacity, zIndex }) => {
            el.style.left = `${x}px`;
            el.style.top = `${y}px`;
            el.style.transform = `translate(-50%, -50%) scale(${scale.toFixed(3)})`;
            el.style.opacity = opacity.toFixed(3);
            el.style.filter = 'none';
            el.style.zIndex = zIndex;

            const isFrontFocus = (index === frontNodeIndex);
            const glow = el.querySelector('.orrery-node-glow');
            const badge = el.querySelector('.orrery-node-badge');
            const orbImg = el.querySelector('.orrery-node-img');

            if (glow) {
                if (isFrontFocus) {
                    glow.style.opacity = '0.9';
                    glow.style.transform = 'scale(1.2)';
                    if (badge) {
                        badge.style.opacity = '1';
                        badge.style.borderColor = tech.color;
                        badge.style.color = '#020617';
                        badge.style.boxShadow = `0 4px 14px ${tech.color}40`;
                    }
                    if (orbImg) {
                        orbImg.style.filter = `drop-shadow(0 10px 22px ${tech.color}75)`;
                    }
                } else {
                    glow.style.opacity = '0.25';
                    glow.style.transform = 'scale(1)';
                    if (badge) {
                        badge.style.opacity = '0.75';
                        badge.style.borderColor = '#e2e8f0';
                        badge.style.color = '#1e293b';
                        badge.style.boxShadow = '0 2px 6px rgba(0,0,0,0.06)';
                    }
                    if (orbImg) {
                        orbImg.style.filter = 'drop-shadow(0 6px 14px rgba(15,23,42,0.28))';
                    }
                }
            }
        });

        // Update center focused card to match front-most node
        const frontTech = technologies[frontNodeIndex];
        updateCenterDisplay(frontTech, frontNodeIndex);

        requestAnimationFrame(render);
    };

    // User Interaction Handlers: Drag / Swipe
    const onPointerDown = (clientX) => {
        isDragging = true;
        targetAngle = null;
        if (autoSpinResumeTimeout) {
            clearTimeout(autoSpinResumeTimeout);
            autoSpinResumeTimeout = null;
        }
        lastDragX = clientX;
    };

    const onPointerMove = (clientX) => {
        if (!isDragging) return;
        const deltaX = clientX - lastDragX;
        lastDragX = clientX;

        const dragSensitivity = 0.005;
        rotationAngle += deltaX * dragSensitivity;
        currentSpeed = deltaX * 0.12;
    };

    const onPointerUp = () => {
        if (!isDragging) return;
        isDragging = false;
    };

    // Mouse Drag Events
    stage.addEventListener('mousedown', (e) => {
        if (e.target.closest('button') || e.target.closest('a')) return;
        onPointerDown(e.clientX);
    });

    window.addEventListener('mousemove', (e) => {
        onPointerMove(e.clientX);
    });

    window.addEventListener('mouseup', () => {
        onPointerUp();
    });

    // Touch Events for Mobile / Tablet
    stage.addEventListener('touchstart', (e) => {
        if (e.touches.length === 1) {
            onPointerDown(e.touches[0].clientX);
        }
    }, { passive: true });

    window.addEventListener('touchmove', (e) => {
        if (e.touches.length === 1 && isDragging) {
            onPointerMove(e.touches[0].clientX);
        }
    }, { passive: true });

    window.addEventListener('touchend', () => {
        onPointerUp();
    });

    // Passive wheel listener for momentum without hijacking page scrolling
    stage.addEventListener('wheel', (e) => {
        targetAngle = null;
        if (autoSpinResumeTimeout) {
            clearTimeout(autoSpinResumeTimeout);
            autoSpinResumeTimeout = null;
        }

        const delta = e.deltaX || e.deltaY;
        if (Math.abs(delta) > 15) {
            currentSpeed += (delta > 0 ? 0.08 : -0.08);
            currentSpeed = Math.max(-0.6, Math.min(0.6, currentSpeed));
        }
    }, { passive: true });

    // Start continuous animation loop
    requestAnimationFrame(render);

    return {
        technologies,
        rotateToNode
    };
};

// Global modal opener for technology detail dialog (double-click trigger)
export const openOrreryTechModal = (tech) => {
    const modal = document.getElementById('orrery-tech-modal');
    if (!modal || !tech) return;

    const card = document.getElementById('modal-tech-card');
    const glow = document.getElementById('modal-tech-glow');
    const iconBox = document.getElementById('modal-tech-icon-box');
    const svgContainer = document.getElementById('modal-tech-svg-container');
    const title = document.getElementById('modal-tech-title');
    const category = document.getElementById('modal-tech-category');
    const categoryBadge = document.getElementById('modal-tech-category-badge');
    const dot = document.getElementById('modal-tech-dot');
    const role = document.getElementById('modal-tech-role');
    const desc = document.getElementById('modal-tech-desc');
    const labNote = document.getElementById('modal-tech-lab-note');
    const link = document.getElementById('modal-tech-link');

    if (title) title.textContent = tech.name;
    if (category) category.textContent = tech.category;
    if (role) role.textContent = tech.role;
    if (desc) desc.textContent = tech.desc;
    if (labNote) labNote.textContent = tech.labNote || 'Dikonfigurasi langsung pada server baremetal Debian 13 dengan soket UNIX dan optimalisasi produksi.';
    if (link) link.href = tech.linkUrl;
    if (svgContainer) svgContainer.innerHTML = tech.svg;

    if (card) card.style.borderColor = tech.color;
    if (glow) glow.style.background = `radial-gradient(circle, ${tech.color}75, transparent 70%)`;
    if (iconBox) {
        iconBox.style.background = `radial-gradient(circle at 35% 35%, ${tech.color}35, #080c18 90%)`;
        iconBox.style.borderColor = tech.color;
        iconBox.style.boxShadow = `0 0 25px ${tech.color}45`;
    }
    if (categoryBadge) {
        categoryBadge.style.background = tech.badgeBg;
        categoryBadge.style.borderColor = tech.badgeBorder;
        categoryBadge.style.color = tech.badgeText;
    }
    if (dot) dot.style.background = tech.color;

    if (typeof window.animateModalOpen === 'function') {
        window.animateModalOpen(modal, card);
    } else {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
};

// Global modal closer
export const closeOrreryTechModal = () => {
    const modal = document.getElementById('orrery-tech-modal');
    if (!modal) return;
    const card = document.getElementById('modal-tech-card');

    if (typeof window.animateModalClose === 'function') {
        window.animateModalClose(modal, card);
    } else {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }
};

// Bind to window for global access from Blade onclick and event listeners
if (typeof window !== 'undefined') {
    window.openOrreryTechModal = openOrreryTechModal;
    window.closeOrreryTechModal = closeOrreryTechModal;
}
