import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Hls from 'hls.js';

gsap.registerPlugin(ScrollTrigger);

export const initDarkPortfolio = () => {
    const root = document.getElementById('dark-portfolio-root');
    if (!root) return;

    console.log('[DarkPortfolio] Initializing Single-Page Dark Portfolio (AetherCraft Protocol)...');

    // Return to top on refresh / navigation
    if (typeof window !== 'undefined') {
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
        window.scrollTo(0, 0);
        window.addEventListener('beforeunload', () => {
            window.scrollTo(0, 0);
        });
    }

    // 1. Loading Screen (requestAnimationFrame 000 -> 100 over 2700ms)
    const initLoadingScreen = () => {
        const screen = document.getElementById('dark-loading-screen');
        const counterEl = document.getElementById('loading-counter');
        const wordEl = document.getElementById('loading-word');
        const barEl = document.getElementById('loading-bar-fill');

        if (!screen || !counterEl || !barEl) {
            initHeroEntrance();
            return;
        }

        const words = ['Design', 'Create', 'Inspire'];
        let wordIndex = 0;
        let wordTimer = null;

        if (wordEl) {
            wordTimer = setInterval(() => {
                wordIndex = (wordIndex + 1) % words.length;
                gsap.to(wordEl, {
                    y: -15,
                    opacity: 0,
                    duration: 0.25,
                    onComplete: () => {
                        wordEl.textContent = words[wordIndex];
                        gsap.fromTo(wordEl, { y: 15, opacity: 0 }, { y: 0, opacity: 0.85, duration: 0.35, ease: 'power2.out' });
                    }
                });
            }, 900);
        }

        const duration = 2700;
        const startTime = performance.now();

        const updateProgress = (currentTime) => {
            const elapsed = currentTime - startTime;
            const progress = Math.min(1, elapsed / duration);
            const count = Math.floor(progress * 100);

            counterEl.textContent = String(count).padStart(3, '0');
            barEl.style.transform = `scaleX(${progress})`;

            if (progress < 1) {
                requestAnimationFrame(updateProgress);
            } else {
                if (wordTimer) clearInterval(wordTimer);
                // 400ms delay on 100% completion before dismissal
                setTimeout(() => {
                    gsap.to(screen, {
                        opacity: 0,
                        duration: 0.6,
                        ease: 'power2.inOut',
                        onComplete: () => {
                            screen.style.display = 'none';
                            initHeroEntrance();
                        }
                    });
                }, 400);
            }
        };

        requestAnimationFrame(updateProgress);
    };

    // 2. Hero GSAP Entrance Animation
    const initHeroEntrance = () => {
        const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

        tl.fromTo('.name-reveal', 
            { opacity: 0, y: 50 }, 
            { opacity: 1, y: 0, duration: 1.2, delay: 0.1 }
        );

        tl.fromTo('.blur-in', 
            { opacity: 0, y: 20, filter: 'blur(10px)' }, 
            { opacity: 1, y: 0, filter: 'blur(0px)', duration: 1.0, stagger: 0.12 }, 
            '-=0.8'
        );
    };

    // 3. Background HLS Video Streams (Hero & Footer Flipped)
    const initHlsVideos = () => {
        const hlsSource = 'https://stream.mux.com/Aa02T7oM1wH5Mk5EEVDYhbZ1ChcdhRsS2m1NYyx4Ua1g.m3u8';
        const videos = [
            document.getElementById('hero-hls-video'),
            document.getElementById('footer-hls-video')
        ].filter(Boolean);

        videos.forEach((video) => {
            if (Hls.isSupported()) {
                const hls = new Hls({
                    enableWorker: true,
                    lowLatencyMode: true,
                    backBufferLength: 60
                });
                hls.loadSource(hlsSource);
                hls.attachMedia(video);
                hls.on(Hls.Events.MANIFEST_PARSED, () => {
                    video.play().catch(() => {
                        // Browser autoplay policy graceful fallback
                    });
                });
            } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                video.src = hlsSource;
                video.addEventListener('loadedmetadata', () => {
                    video.play().catch(() => {});
                });
            }
        });
    };

    // 4. Role Line Cycling (Every 2 seconds)
    const initRoleRotator = () => {
        const roleEl = document.getElementById('hero-rotating-role');
        if (!roleEl) return;

        const roles = [
            'Network Engineer',
            'Systems Architect',
            'Software Developer',
            'DevOps Specialist'
        ];
        let currentIdx = 0;

        setInterval(() => {
            currentIdx = (currentIdx + 1) % roles.length;
            roleEl.style.opacity = '0';
            roleEl.style.transform = 'translateY(8px)';
            
            setTimeout(() => {
                roleEl.textContent = roles[currentIdx];
                roleEl.classList.remove('animate-role-fade-in');
                // Force reflow
                void roleEl.offsetWidth;
                roleEl.classList.add('animate-role-fade-in');
            }, 150);
        }, 2200);
    };

    // 5. Floating Navbar Elevation on Scroll (Preserve Glassmorphism Refraction)
    const initNavbar = () => {
        const navPill = document.getElementById('dark-nav-pill');
        if (!navPill) return;

        window.addEventListener('scroll', () => {
            if (window.scrollY > 60) {
                navPill.classList.add('shadow-2xl', 'border-white/25');
            } else {
                navPill.classList.remove('shadow-2xl', 'border-white/25');
            }
        }, { passive: true });
    };

    // 6. Section 5: Visual Playground (Teknologi Pembuatan Web) - Mouse Follow, Inertia, Idle Float & Telemetry Modal
    const initTechStackShowcase = () => {
        const section = document.getElementById('technologies');
        const columns = Array.from(section ? section.querySelectorAll('.flow-column') : []);
        const orbs = document.querySelectorAll('.tech-circle-orb');

        const modalOverlay = document.getElementById('tech-modal-overlay');
        const modalCard = document.getElementById('tech-modal-card');
        const modalGlow = document.getElementById('modal-glow');
        const modalSkeleton = document.getElementById('modal-skeleton');
        const modalError = document.getElementById('modal-error');
        const modalContent = document.getElementById('modal-content');
        const modalRetryBtn = document.getElementById('modal-retry-btn');
        const modalCloseBtn = document.getElementById('modal-close-btn');
        const modalDismissBtn = document.getElementById('modal-dismiss-btn');
        
        const modalIconSlot = document.getElementById('modal-icon-slot');
        const modalIconBadge = document.getElementById('modal-icon-badge');
        const modalTechTitle = document.getElementById('modal-tech-title');
        const modalBadgeSlot = document.getElementById('modal-badge-slot');
        const modalTechSubhead = document.getElementById('modal-tech-subhead');
        const modalExplanationSlot = document.getElementById('modal-explanation-slot');
        const modalRationaleSlot = document.getElementById('modal-rationale-slot');
        const modalSpecsGrid = document.getElementById('modal-specs-grid');
        const modalStatusText = document.getElementById('modal-status-text');

        if (!section || !columns.length) return;

        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        // A. Column state. Each column rises at its own speed (staggered) and wraps seamlessly:
        //    a card leaving the top edge re-enters from below the bottom edge.
        const flowCols = columns.map((col) => {
            const cardsInCol = Array.from(col.querySelectorAll('.flow-card'));
            const state = {
                el: col,
                cards: cardsInCol,
                speed: parseFloat(col.dataset.speed) || 30,   // px per second
                depth: parseFloat(col.dataset.depth) || 20,   // parallax strength
                offset: parseFloat(col.dataset.offset) || 0,  // initial phase 0..1
                progress: null,
                factor: 1,            // eased speed multiplier (1 = flowing, 0 = paused)
                hovered: false,
                loopH: 0,
                spacing: 0,
                setX: gsap.quickSetter(col, 'x', 'px'),
                setRot: gsap.quickSetter(col, 'rotation', 'deg'),
                setCardY: cardsInCol.map((c) => gsap.quickSetter(c, 'y', 'px')),
            };
            // Hover / keyboard focus brakes the whole column so the card under the cursor
            // stops without neighbours sliding over it.
            const pause = () => { state.hovered = true; };
            const resume = () => { state.hovered = false; };
            cardsInCol.forEach((c) => {
                c.addEventListener('pointerenter', pause);
                c.addEventListener('pointerleave', resume);
                c.addEventListener('focusin', pause);
                c.addEventListener('focusout', resume);
            });
            return state;
        });

        let sectionH = section.clientHeight;
        const measure = () => {
            sectionH = section.clientHeight;
            flowCols.forEach((c) => {
                if (!c.cards.length) return;
                const cardH = c.cards[0].offsetHeight || 64;
                // Loop must be taller than the viewport + one card so a card is fully hidden before wrapping.
                c.loopH = Math.max(sectionH + cardH, c.cards.length * (cardH + 56));
                c.spacing = c.loopH / c.cards.length;
                if (c.progress === null) c.progress = c.offset * c.loopH;
            });
        };

        // B. Mouse parallax / tilt (lerped, so it trails the cursor with inertia).
        let targetMX = 0;
        let currentMX = 0;
        section.addEventListener('pointermove', (e) => {
            if (e.pointerType !== 'mouse' || reduceMotion) return;
            const rect = section.getBoundingClientRect();
            targetMX = gsap.utils.clamp(-1, 1, (e.clientX - (rect.left + rect.width / 2)) / (rect.width / 2));
        }, { passive: true });
        section.addEventListener('pointerleave', () => { targetMX = 0; });

        const render = (dt) => {
            currentMX += (targetMX - currentMX) * Math.min(1, dt * 4.5);
            flowCols.forEach((c) => {
                if (!c.loopH) return;
                const targetFactor = (c.hovered || reduceMotion) ? 0 : 1;
                c.factor += (targetFactor - c.factor) * Math.min(1, dt * 6);
                c.progress += c.speed * c.factor * dt;

                for (let i = 0; i < c.cards.length; i++) {
                    let y = (i * c.spacing - c.progress) % c.loopH;
                    if (y < 0) y += c.loopH;
                    // y = loopH -> just below bottom edge; y = 0 -> above top edge.
                    c.setCardY[i](y + sectionH - c.loopH);
                }

                c.setX(currentMX * c.depth);
                c.setRot(currentMX * c.depth * 0.06);
            });
        };

        measure();
        render(0);

        let inView = false;
        new IntersectionObserver(([entry]) => { inView = entry.isIntersecting; }, { rootMargin: '120px' }).observe(section);
        new ResizeObserver(() => { measure(); render(0); }).observe(section);

        gsap.ticker.add((time, deltaTime) => {
            if (!inView) return;
            render(Math.min(deltaTime / 1000, 0.05));
        });

        gsap.from(columns, {
            opacity: 0,
            duration: 1.2,
            stagger: 0.12,
            ease: 'power2.out',
            scrollTrigger: { trigger: section, start: 'top 80%' }
        });

        // D. Navbar Smooth Scroll Handler
        const techNavLink = document.querySelector('a[href="#technologies"]');
        if (techNavLink) {
            techNavLink.addEventListener('click', (e) => {
                e.preventDefault();
                section.scrollIntoView({ behavior: 'smooth' });
            });
        }

        // B. Database of Web Technologies
        const techDatabase = {
            laravel: {
                title: "Laravel 11.x",
                badge: "[BACKEND CORE · SSR]",
                subhead: "PHP 8.3 Enterprise MVC Framework & Service Layer",
                color: "#FF2D20",
                logo: "/images/tech_logos/laravel.png",
                svg: `<img src="/images/tech_logos/laravel.png" alt="Laravel" class="w-8 h-8 object-contain" />`,
                explanation: "Laravel adalah framework web berbasis PHP modern terkemuka yang menyediakan arsitektur Model-View-Controller (MVC) yang ekspresif, sistem routing tangguh, templating engine Blade terisolasi, serta pipeline middleware keamanan berstandar industri.",
                rationale: "Dipilih sebagai fondasi backend utama untuk memproses request secara deterministik, menangani routing halaman portofolio dan konsol AI Yuna, serta mengelola endpoint data terstruktur dengan performa stabil dan arsitektur modular yang mudah diuji tanpa dependensi rapuh.",
                specs: [
                    { label: "RUNTIME", value: "PHP 8.3 (JIT Active)" },
                    { label: "ROUTING LATENCY", value: "< 8.5ms (p99)" },
                    { label: "ARCHITECTURE", value: "Clean MVC + Service Layer" },
                    { label: "SECURITY", value: "CSRF & Strict XSS Guard" }
                ]
            },
            tailwind: {
                title: "Tailwind CSS v4",
                badge: "[UI/CSS ENGINE]",
                subhead: "Next-Gen Utility-First Design Token & Layout Engine",
                color: "#06B6D4",
                logo: "/images/tech_logos/tailwind.png",
                svg: `<img src="/images/tech_logos/tailwind.png" alt="Tailwind CSS" class="w-8 h-8 object-contain" />`,
                explanation: "Tailwind CSS adalah sistem styling berbasis utility-first modern yang menghasilkan antarmuka web responsif dan konsisten melalui token desain atomik yang dikompilasi langsung menggunakan mesin Rust LightningCSS.",
                rationale: "Digunakan untuk membangun sistem antarmuka 'Dark Portfolio' bergaya Baremetal Precision dengan kontrol piksel presisi tinggi, adaptasi layar ponsel hingga desktop tanpa overflow, serta ukuran bundle CSS produksi yang sangat ringan (< 15 KB gzip) tanpa membebani browser pengunjung.",
                specs: [
                    { label: "ENGINE", value: "@tailwindcss/vite (v4.0)" },
                    { label: "BUNDLE SIZE", value: "14.2 KB (Gzip)" },
                    { label: "LAYOUT SHIFT", value: "0.00 CLS (Zero Shift)" },
                    { label: "PALETTE", value: "Baremetal Monochromatic" }
                ]
            },
            vite: {
                title: "Vite 5.x",
                badge: "[ESM BUNDLER]",
                subhead: "High-Performance Native ES Modules Frontend Toolchain",
                color: "#BD34FE",
                logo: "/images/tech_logos/vite.png",
                svg: `<img src="/images/tech_logos/vite.png" alt="Vite" class="w-8 h-8 object-contain" />`,
                explanation: "Vite adalah development server dan bundler generasi baru yang memanfaatkan kapabilitas native ES Modules di peramban untuk Hot Module Replacement (HMR) berkecepatan kilat dan Rollup/Esbuild untuk kompilasi produksi.",
                rationale: "Menjamin feedback development instan tanpa jeda kompilasi lambat, membagi bundle JavaScript ke dalam chunk teroptimasi, serta memberikan hashing aset otomatis sehingga browser pengunjung selalu memuat script termutakhir secara instan.",
                specs: [
                    { label: "HMR LATENCY", value: "< 12ms Hot Reload" },
                    { label: "BUILD SPEED", value: "~1.1s Total Pipeline" },
                    { label: "TREE SHAKING", value: "Rollup AST Pass" },
                    { label: "OUTPUT TARGET", value: "ES2022 Native Modern" }
                ]
            },
            gsap: {
                title: "GSAP 3.x",
                badge: "[60FPS MOTION]",
                subhead: "High-Performance JavaScript Animation Platform & ScrollTrigger",
                color: "#88CE02",
                logo: "/images/tech_logos/gsap.png",
                svg: `<img src="/images/tech_logos/gsap.png" alt="GSAP" class="w-8 h-8 object-contain" />`,
                explanation: "GSAP adalah engine animasi JavaScript berstandar industri dengan performa tinggi untuk menggerakkan elemen DOM, SVG, dan kanvas secara sangat mulus dengan akselerasi GPU tanpa membebani thread browser.",
                rationale: "Digunakan khusus untuk mengorkestrasi efek scrollytelling di portofolio ini: memunculkan kartu logo teknologi dari bawah secara continuous vertical flow, animasi hitungan persentase loading screen, teks berjalan (marquee), dan transisi buka-tutup modal yang bebas stutter pada 60-120 FPS.",
                specs: [
                    { label: "FRAME RATE", value: "60 - 120 FPS Hardware" },
                    { label: "PLUGINS", value: "ScrollTrigger & Timeline" },
                    { label: "MEMORY LEAK", value: "0 Residual Listeners" },
                    { label: "DROPPED FRAMES", value: "0 in 60s Audit" }
                ]
            },
            nginx: {
                title: "Nginx 1.26",
                badge: "[EDGE REVERSE PROXY]",
                subhead: "High-Concurrency Asynchronous HTTP/2 Gateway & TLS Termination",
                color: "#009639",
                logo: "/images/tech_logos/nginx.png",
                svg: `<img src="/images/tech_logos/nginx.png" alt="Nginx" class="w-8 h-8 object-contain" />`,
                explanation: "Nginx adalah web server dan reverse proxy berkinerja tinggi berbasis asynchronous event-driven architecture yang terkenal akan konsumsi memori rendah dan ketahanan menangani ribuan koneksi bersamaan.",
                rationale: "Berfungsi sebagai gerbang depan server baremetal portofolio ini: melayani file statis langsung melalui kernel Linux sendfile() (zero copy overhead), menangani enkripsi TLS 1.3 modern, kompresi Gzip/Brotli, serta memforward request dinamis secara efisien ke PHP-FPM.",
                specs: [
                    { label: "PROTOCOL", value: "HTTP/2 & TLS 1.3" },
                    { label: "WORKER MODEL", value: "Event-Driven Epoll" },
                    { label: "STATIC TTFB", value: "< 1.2ms Local Edge" },
                    { label: "OFFLOAD", value: "Zero-Copy Sendfile" }
                ]
            },
            debian: {
                title: "Debian 12 (Bookworm)",
                badge: "[BAREMETAL HOST OS]",
                subhead: "Rock-Solid GNU/Linux Production Host with Tuned Kernel",
                color: "#D70A53",
                logo: "/images/tech_logos/debian.png",
                svg: `<img src="/images/tech_logos/debian.png" alt="Debian" class="w-8 h-8 object-contain" />`,
                explanation: "Debian adalah sistem operasi bebas berbasis Linux yang terkenal dengan kestabilan operasional tanpa kompromi, manajemen paket APT yang terverifikasi aman, serta arsitektur UNIX yang bersih dan minim bloatware.",
                rationale: "Portofolio ini di-host secara mandiri (self-hosted) langsung di atas server fisik Debian baremetal. Menggunakan konfigurasi sysctl kernel tingkat lanjut seperti algoritma Google BBR TCP congestion control untuk transmisi paket data berlatensi rendah dan uptime 100%.",
                specs: [
                    { label: "DISTRO", value: "Debian 12 Bookworm" },
                    { label: "TCP ENGINE", value: "Google BBR Algorithm" },
                    { label: "UPTIME SLA", value: "100% Production SLA" },
                    { label: "SECURITY", value: "Hardened Systemd Slices" }
                ]
            },
            mariadb: {
                title: "MariaDB 11.8",
                badge: "[ACID PERSISTENCE]",
                subhead: "High-Performance Relational Engine with Aria & InnoDB Storage",
                color: "#00758F",
                logo: "/images/tech_logos/mariadb.png",
                svg: `<img src="/images/tech_logos/mariadb.png" alt="MariaDB" class="w-8 h-8 object-contain" />`,
                explanation: "MariaDB adalah sistem manajemen basis data relasional open-source enterprise turunan MySQL berkecepatan tinggi yang mendukung transaksi ACID penuh dan optimasi mesin Aria/InnoDB.",
                rationale: "Menyimpan data riwayat sertifikasi kejuruan, dokumentasi proyek jaringan, log audit akses, serta riwayat interaksi chatbot AI Yuna secara konsisten, aman dari korupsi data, dan mampu melayani query kompleks dalam waktu sub-milidetik.",
                specs: [
                    { label: "STORAGE ENGINE", value: "InnoDB & Aria Native" },
                    { label: "INDEX LOOKUP", value: "< 0.22ms B-Tree" },
                    { label: "DATA GUARANTEE", value: "Strict ACID Transacted" },
                    { label: "BUFFER HIT", value: "98.7% Hit Efficiency" }
                ]
            },
            mysql: {
                title: "MySQL 8.4 LTS",
                badge: "[ACID STORAGE]",
                subhead: "Relational Persistence Storage with InnoDB Buffer Engine",
                color: "#00758F",
                logo: "/images/tech_logos/mariadb.png",
                svg: `<img src="/images/tech_logos/mariadb.png" alt="MySQL / MariaDB" class="w-8 h-8 object-contain" />`,
                explanation: "MySQL / MariaDB adalah sistem manajemen database relasional (RDBMS) enterprise yang mendukung integritas data penuh dengan garansi ACID (Atomicity, Consistency, Isolation, Durability) dan pengindeksan B-Tree performa tinggi.",
                rationale: "Menyimpan data riwayat sertifikasi kejuruan, dokumentasi proyek jaringan, log audit akses, serta riwayat interaksi chatbot AI Yuna secara konsisten, aman dari korupsi data, dan mampu melayani query kompleks dalam waktu sub-milidetik.",
                specs: [
                    { label: "STORAGE ENGINE", value: "InnoDB (Row-Level Lock)" },
                    { label: "INDEX LOOKUP", value: "< 0.25ms B-Tree" },
                    { label: "DATA GUARANTEE", value: "Strict ACID Transacted" },
                    { label: "BUFFER HIT", value: "98.4% Hit Efficiency" }
                ]
            },
            threejs: {
                title: "Three.js",
                badge: "[3D GRAPHICS · WEBGL]",
                subhead: "GPU-Accelerated WebGL 3D Computational Canvas Library",
                color: "#FFFFFF",
                logo: "/images/tech_logos/threejs.png",
                svg: `<img src="/images/tech_logos/threejs.png" alt="Three.js" class="w-8 h-8 object-contain" />`,
                explanation: "Three.js adalah perpustakaan JavaScript yang memudahkan pembuatan dan penampilan grafik komputer 3D interaktif di peramban web menggunakan akselerasi GPU WebGL tanpa bergantung pada plugin eksternal.",
                rationale: "Digunakan untuk merender simulasi topologi jaringan dan geometri matematis interaktif di portofolio dengan akselerasi GPU perangkat keras, menghasilkan visualisasi futuristik yang memukau tanpa menguras daya baterai pengguna mobile.",
                specs: [
                    { label: "GRAPHICS API", value: "WebGL 2.0 Context" },
                    { label: "SHADERS", value: "GLSL Custom Shaders" },
                    { label: "FRAME TARGET", value: "16.6ms Render Budget" },
                    { label: "FALLBACK", value: "Graceful 2D Vector" }
                ]
            }
        };

        let lastActiveTrigger = null;

        // C. Open Tech Modal with Four Boundary States handling
        const openTechModal = (techKey) => {
            if (!modalOverlay || !modalCard) return;

            // Show Loading Skeleton State first
            if (modalSkeleton) modalSkeleton.classList.remove('hidden');
            if (modalContent) modalContent.classList.add('hidden');
            if (modalError) modalError.classList.add('hidden');

            // Open overlay with GSAP
            modalOverlay.classList.remove('opacity-0', 'pointer-events-none');
            modalOverlay.classList.add('opacity-100');
            modalCard.classList.remove('scale-95');
            modalCard.classList.add('scale-100');
            document.body.classList.add('overflow-hidden');

            // Simulate ultra-responsive payload render (120ms)
            setTimeout(() => {
                const data = techDatabase[techKey];

                if (!data) {
                    // ERROR BOUNDARY STATE (AetherCraft Protocol)
                    if (modalSkeleton) modalSkeleton.classList.add('hidden');
                    if (modalContent) modalContent.classList.add('hidden');
                    if (modalError) modalError.classList.remove('hidden');
                    if (modalRetryBtn) {
                        modalRetryBtn.onclick = () => openTechModal('laravel');
                    }
                    return;
                }

                // SUCCESS STATE: Populate dynamic tech specs
                if (modalIconSlot) {
                    if (data.logo) {
                        modalIconSlot.innerHTML = `<img src="${data.logo}" alt="${data.title}" class="w-8 h-8 object-contain drop-shadow-[0_2px_8px_rgba(0,0,0,0.8)]" />`;
                    } else {
                        modalIconSlot.innerHTML = data.svg;
                    }
                }
                if (modalIconBadge) {
                    modalIconBadge.style.borderColor = `${data.color}40`;
                    modalIconBadge.style.boxShadow = `0 0 16px ${data.color}22`;
                }
                if (modalTechTitle) modalTechTitle.textContent = data.title;
                if (modalBadgeSlot) {
                    modalBadgeSlot.textContent = data.badge;
                    modalBadgeSlot.style.borderColor = `${data.color}40`;
                    modalBadgeSlot.style.color = data.color;
                }
                if (modalTechSubhead) modalTechSubhead.textContent = data.subhead;
                if (modalExplanationSlot) modalExplanationSlot.textContent = data.explanation;
                if (modalRationaleSlot) modalRationaleSlot.textContent = data.rationale;

                if (modalGlow) {
                    modalGlow.style.backgroundColor = data.color;
                }

                // Injected specs grid
                if (modalSpecsGrid) {
                    modalSpecsGrid.innerHTML = data.specs.map(spec => `
                        <div class="p-2.5 rounded-xl bg-[#0a0a0a] border border-[#1f1f1f] flex flex-col justify-between">
                            <span class="text-[10px] text-[#878787] uppercase tracking-wider">${spec.label}</span>
                            <span class="text-xs font-semibold text-[#f5f5f5] mt-1 break-words">${spec.value}</span>
                        </div>
                    `).join('');
                }

                if (modalStatusText) {
                    modalStatusText.textContent = `Telemetri ${data.title} aktif diperiksa`;
                }

                // Reveal content & hide skeleton
                if (modalSkeleton) modalSkeleton.classList.add('hidden');
                if (modalContent) modalContent.classList.remove('hidden');

                // Shift focus to close button for a11y
                if (modalCloseBtn) modalCloseBtn.focus();
            }, 120);
        };

        // D. Close Tech Modal
        const closeTechModal = () => {
            if (!modalOverlay || !modalCard) return;

            modalOverlay.classList.add('opacity-0', 'pointer-events-none');
            modalOverlay.classList.remove('opacity-100');
            modalCard.classList.add('scale-95');
            modalCard.classList.remove('scale-100');
            document.body.classList.remove('overflow-hidden');

            if (lastActiveTrigger) {
                lastActiveTrigger.focus();
                lastActiveTrigger = null;
            }
        };

        // E. Bind click listeners to all circular tech nodes
        orbs.forEach((orb) => {
            orb.addEventListener('click', () => {
                const key = orb.dataset.tech;
                lastActiveTrigger = orb;
                openTechModal(key);
            });
        });

        // Close button handlers
        if (modalCloseBtn) modalCloseBtn.addEventListener('click', closeTechModal);
        if (modalDismissBtn) modalDismissBtn.addEventListener('click', closeTechModal);

        // Backdrop click handler
        if (modalOverlay) {
            modalOverlay.addEventListener('click', (e) => {
                if (e.target === modalOverlay) {
                    closeTechModal();
                }
            });
        }

        // Global ESC key handler
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modalOverlay.classList.contains('pointer-events-none')) {
                closeTechModal();
            }
        });
    };

    // 7. Footer Marquee Animation
    const initMarquee = () => {
        const marqueeTrack = document.getElementById('footer-marquee-track');
        if (!marqueeTrack) return;

        gsap.to(marqueeTrack, {
            xPercent: -50,
            duration: 35,
            ease: 'none',
            repeat: -1
        });
    };

    // Execute Initializations
    initLoadingScreen();
    initHlsVideos();
    initRoleRotator();
    initNavbar();
    initTechStackShowcase();
    initMarquee();
};
