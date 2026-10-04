import { initOrreryGallery } from './orrery-gallery.js';
import { initGsapAnimations } from './gsap-animations.js';
import { initLabsRotator } from './labs-rotator.js';
import { initDarkPortfolio } from './dark-portfolio.js';
import { initInteractiveBackground } from './interactive-bg.js';
import Swiper from 'swiper';
import { EffectCoverflow, Pagination, Navigation, Keyboard, A11y } from 'swiper/modules';


// Portfolio Tab Switcher (ekizr.com signature feature)
const initPortfolioTabs = () => {
    const tabButtons = document.querySelectorAll('[data-portfolio-tab]');
    const tabPanels = document.querySelectorAll('[data-portfolio-panel]');

    if (!tabButtons.length) return;

    tabButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const targetTab = btn.dataset.portfolioTab;

            tabButtons.forEach((b) => {
                const isSelected = b === btn;
                b.setAttribute('aria-selected', isSelected ? 'true' : 'false');
                if (isSelected) {
                    b.classList.remove('text-zinc-400', 'hover:text-white', 'hover:bg-white/[0.04]');
                    b.classList.add('text-white', 'bg-rose-600/20', 'border-rose-500/40', 'shadow-lg', 'shadow-rose-600/10');
                } else {
                    b.classList.remove('text-white', 'bg-rose-600/20', 'border-rose-500/40', 'shadow-lg', 'shadow-rose-600/10');
                    b.classList.add('text-zinc-400', 'hover:text-white', 'hover:bg-white/[0.04]');
                }
            });

            tabPanels.forEach((panel) => {
                if (panel.dataset.portfolioPanel === targetTab) {
                    panel.classList.remove('hidden');
                    panel.classList.add('block', 'animate-fade-in');
                } else {
                    panel.classList.add('hidden');
                    panel.classList.remove('block', 'animate-fade-in');
                }
            });
        });
    });
};

// Modul Penyaring Kategori Matriks Kompetensi (#skills)
const initSkillFilter = () => {
    const filterTabs = document.querySelectorAll('#skill-filter-tabs button');
    const skillCards = document.querySelectorAll('.skill-card');

    if (!filterTabs.length) return;

    const isDark = () => document.documentElement.classList.contains('dark') || document.getElementById('dark-portfolio-root');

    filterTabs.forEach((btn) => {
        btn.addEventListener('click', () => {
            const dark = isDark();
            filterTabs.forEach((b) => {
                if (dark) {
                    b.classList.remove('bg-white', 'text-black', 'border-white', 'font-bold', 'shadow-md');
                    b.classList.add('bg-white/[0.05]', 'border-white/10', 'text-neutral-400', 'hover:text-white', 'hover:bg-white/[0.1]', 'font-semibold');
                } else {
                    b.classList.remove('bg-[#0F172A]', 'text-white', 'border-[#0F172A]', 'shadow-xs', 'font-bold');
                    b.classList.add('bg-white/90', 'border-stone-300', 'text-[#334155]', 'hover:text-[#4E85BF]', 'hover:border-[#4E85BF]/50', 'hover:bg-stone-100', 'font-semibold');
                }
            });

            if (dark) {
                btn.classList.remove('bg-white/[0.05]', 'border-white/10', 'text-neutral-400', 'hover:text-white', 'hover:bg-white/[0.1]', 'font-semibold');
                btn.classList.add('bg-white', 'text-black', 'border-white', 'font-bold', 'shadow-md');
            } else {
                btn.classList.remove('bg-white/90', 'border-stone-300', 'text-[#334155]', 'hover:text-[#4E85BF]', 'hover:border-[#4E85BF]/50', 'hover:bg-stone-100', 'font-semibold');
                btn.classList.add('bg-[#0F172A]', 'text-white', 'border-[#0F172A]', 'shadow-xs', 'font-bold');
            }

            const filter = btn.dataset.filter;
            skillCards.forEach((card) => {
                const category = card.dataset.category;
                const shouldShow = (filter === 'all' || category === filter);
                card.style.display = shouldShow ? 'block' : 'none';
            });
        });
    });
};

// Global Certificate Lightbox Modal Controller
window.openCertModal = (imageSrc, title, issuer, credentialId, pdfUrl, status) => {
    const modal = document.getElementById('cert-modal');
    const modalImg = document.getElementById('modal-cert-image');
    const modalTitle = document.getElementById('modal-cert-title');
    const modalIssuer = document.getElementById('modal-cert-issuer');
    const modalId = document.getElementById('modal-cert-id');
    const modalStatus = document.getElementById('modal-cert-status');
    const pdfLink = document.getElementById('modal-cert-pdf-link');
    const pdfLinkMobile = document.getElementById('modal-cert-pdf-link-mobile');

    if (!modal) return;

    if (modalImg) modalImg.src = imageSrc || '';
    if (modalTitle) modalTitle.textContent = title || '';
    if (modalIssuer) modalIssuer.textContent = issuer || '';
    if (modalId) modalId.textContent = credentialId ? 'ID: ' + credentialId : '';
    if (modalStatus) modalStatus.textContent = status || 'Terverifikasi Resmi';

    if (pdfUrl) {
        if (pdfLink) {
            pdfLink.href = pdfUrl;
            pdfLink.classList.remove('hidden');
        }
        if (pdfLinkMobile) {
            pdfLinkMobile.href = pdfUrl;
            pdfLinkMobile.classList.remove('hidden');
        }
    } else {
        if (pdfLink) pdfLink.classList.add('hidden');
        if (pdfLinkMobile) pdfLinkMobile.classList.add('hidden');
    }

    const card = modal.querySelector('.cert-modal-card, .glass-panel');
    if (typeof window.animateModalOpen === 'function') {
        window.animateModalOpen(modal, card);
    } else {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
};

window.closeCertModal = () => {
    const modal = document.getElementById('cert-modal');
    if (!modal) return;

    const card = modal.querySelector('.cert-modal-card, .glass-panel');
    if (typeof window.animateModalClose === 'function') {
        window.animateModalClose(modal, card);
    } else {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }
};

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        window.closeCertModal();
    }
});

// Active Section Tracking for Floating Navbar (4 Kategori Inti)
const initActiveNavTracking = () => {
    const navLinks = document.querySelectorAll('nav [data-nav-section]');
    const sections = document.querySelectorAll('section[id]');

    if (!navLinks.length || !sections.length) return;

    // Pemetaan ID section ke grup navigasi induk
    const sectionMap = {
        'about': 'about',
        'certifications': 'about',
        'featured-projects': 'featured-projects',
        'labs': 'featured-projects',
        'skills': 'skills',
        'architecture': 'architecture'
    };

    const onScroll = () => {
        const scrollPosition = window.scrollY + 240;
        let activeSectionId = '';

        sections.forEach((section) => {
            const top = section.offsetTop;
            const height = section.offsetHeight;
            if (scrollPosition >= top && scrollPosition < top + height) {
                activeSectionId = section.getAttribute('id');
            }
        });

        const activeGroup = sectionMap[activeSectionId] || '';

        navLinks.forEach((link) => {
            const targetGroup = link.getAttribute('data-nav-section');
            if (targetGroup && targetGroup === activeGroup) {
                link.classList.add('nav-link-active');
            } else {
                link.classList.remove('nav-link-active');
            }
        });
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
};

// Back To Top Floating Button
const initBackToTop = () => {
    const btn = document.getElementById('back-to-top');
    if (!btn) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 400) {
            btn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
            btn.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
        } else {
            btn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
            btn.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
        }
    }, { passive: true });

    btn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
};

// Mobile Navigation Menu Toggle
const initMobileMenu = () => {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const openIcon = document.getElementById('menu-open-icon');
    const closeIcon = document.getElementById('menu-close-icon');

    if (!btn || !menu) return;

    const toggleMenu = (forceOpen) => {
        const isOpen = forceOpen !== undefined ? forceOpen : menu.classList.contains('hidden');
        if (isOpen) {
            menu.classList.remove('hidden');
            menu.classList.add('block');
            btn.setAttribute('aria-expanded', 'true');
            if (openIcon && closeIcon) {
                openIcon.classList.add('hidden');
                openIcon.classList.remove('block');
                closeIcon.classList.remove('hidden');
                closeIcon.classList.add('block');
            }
        } else {
            menu.classList.add('hidden');
            menu.classList.remove('block');
            btn.setAttribute('aria-expanded', 'false');
            if (openIcon && closeIcon) {
                openIcon.classList.remove('hidden');
                openIcon.classList.add('block');
                closeIcon.classList.add('hidden');
                closeIcon.classList.remove('block');
            }
        }
    };

    btn.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleMenu();
    });

    // Close when clicking any nav link inside mobile-menu
    menu.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            toggleMenu(false);
        });
    });

    // Close when clicking outside of the drawer
    document.addEventListener('click', (e) => {
        if (!menu.classList.contains('hidden') && !menu.contains(e.target) && !btn.contains(e.target)) {
            toggleMenu(false);
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !menu.classList.contains('hidden')) {
            toggleMenu(false);
        }
    });
};

// 3D Coverflow Interactive Gallery for Certifications
const initCertificateCoverflow = () => {
    const swiperEl = document.querySelector('.cert-coverflow-swiper');
    if (!swiperEl) return null;

    const currentIndexEl = document.getElementById('cert-current-index');
    const totalCountEl = document.getElementById('cert-total-count');

    const swiper = new Swiper(swiperEl, {
        modules: [EffectCoverflow, Pagination, Navigation, Keyboard, A11y],
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',
        initialSlide: 0,
        loop: true,
        speed: 600,
        slideToClickedSlide: true,
        watchSlidesProgress: true,
        coverflowEffect: {
            rotate: 35,
            stretch: 0,
            depth: 220,
            modifier: 1,
            scale: 0.82,
            slideShadows: true,
        },
        keyboard: {
            enabled: true,
            onlyInViewport: true,
        },
        pagination: {
            el: '.cert-coverflow-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.cert-coverflow-next',
            prevEl: '.cert-coverflow-prev',
        },
        a11y: {
            enabled: true,
            prevSlideMessage: 'Sertifikat sebelumnya',
            nextSlideMessage: 'Sertifikat berikutnya',
        },
        on: {
            init: function () {
                if (currentIndexEl) {
                    currentIndexEl.textContent = this.realIndex + 1;
                }
                if (totalCountEl) {
                    const realTotal = swiperEl.querySelectorAll('.swiper-slide:not(.swiper-slide-duplicate)').length;
                    if (realTotal > 0) {
                        totalCountEl.textContent = realTotal;
                    }
                }
            },
            slideChange: function () {
                if (currentIndexEl) {
                    currentIndexEl.textContent = this.realIndex + 1;
                }
            }
        }
    });

    window.swiperCertInstance = swiper;
    return swiper;
};

// Interactive Technical Telemetry Console (WAI-ARIA Tab switching with keyboard support)
const initTelemetryConsole = () => {
    const tabs = [
        { btnId: 'tab-system-btn', panelId: 'panel-system' },
        { btnId: 'tab-network-btn', panelId: 'panel-network' },
        { btnId: 'tab-services-btn', panelId: 'panel-services' }
    ];

    const tabButtons = tabs.map(t => document.getElementById(t.btnId)).filter(Boolean);
    if (tabButtons.length !== 3) return;

    const selectTab = (index, shouldFocus = false) => {
        tabs.forEach((tab, i) => {
            const btn = document.getElementById(tab.btnId);
            const panel = document.getElementById(tab.panelId);
            if (!btn || !panel) return;

            const isSelected = (i === index);
            btn.setAttribute('aria-selected', isSelected ? 'true' : 'false');
            if (isSelected) {
                btn.classList.add('bg-[#165B4C]', 'text-white', 'font-bold');
                btn.classList.remove('text-stone-300', 'font-medium');
                panel.classList.remove('hidden');
                if (shouldFocus) btn.focus();
            } else {
                btn.classList.remove('bg-[#165B4C]', 'text-white', 'font-bold');
                btn.classList.add('text-stone-300', 'font-medium');
                panel.classList.add('hidden');
            }
        });
    };

    tabs.forEach((tab, index) => {
        const btn = document.getElementById(tab.btnId);
        if (!btn) return;

        btn.addEventListener('click', () => selectTab(index, false));

        btn.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight') {
                e.preventDefault();
                const next = (index + 1) % tabs.length;
                selectTab(next, true);
            } else if (e.key === 'ArrowLeft') {
                e.preventDefault();
                const prev = (index - 1 + tabs.length) % tabs.length;
                selectTab(prev, true);
            } else if (e.key === 'Home') {
                e.preventDefault();
                selectTab(0, true);
            } else if (e.key === 'End') {
                e.preventDefault();
                selectTab(tabs.length - 1, true);
            }
        });
    });
};

// Live Server Telemetry AJAX Updater
const initLiveTelemetry = () => {
    const refreshBtn = document.getElementById('telemetry-refresh-btn');
    const refreshIcon = document.getElementById('telemetry-refresh-icon');
    if (!refreshBtn) return;

    let isFetching = false;

    const fetchTelemetry = async () => {
        if (isFetching) return;
        isFetching = true;
        if (refreshIcon) refreshIcon.classList.add('animate-spin');

        try {
            const res = await fetch('/api/telemetry');
            if (!res.ok) throw new Error('Network response not ok');
            const data = await res.json();

            if (data?.system?.cpu) {
                const loadEl = document.getElementById('telemetry-load');
                const load5El = document.getElementById('telemetry-load5');
                const load15El = document.getElementById('telemetry-load15');
                if (loadEl) loadEl.textContent = data.system.cpu.load_1m;
                if (load5El) load5El.textContent = data.system.cpu.load_5m;
                if (load15El) load15El.textContent = data.system.cpu.load_15m;
            }

            if (data?.system?.ram) {
                const ramEl = document.getElementById('telemetry-ram');
                const ramPctEl = document.getElementById('telemetry-ram-pct');
                if (ramEl) ramEl.textContent = data.system.ram.used_formatted;
                if (ramPctEl) ramPctEl.textContent = `${data.system.ram.percent}%`;
            }

            if (data?.system?.uptime) {
                const uptimeEl = document.getElementById('telemetry-uptime');
                if (uptimeEl) uptimeEl.textContent = data.system.uptime.formatted;
            }

            if (data?.services?.database) {
                const latencyEl = document.getElementById('telemetry-latency');
                if (latencyEl && data.services.database.latency_ms !== null) {
                    latencyEl.textContent = `${data.services.database.latency_ms} ms`;
                }
            }
        } catch (err) {
            console.error('Failed to update live telemetry:', err);
        } finally {
            isFetching = false;
            if (refreshIcon) {
                setTimeout(() => refreshIcon.classList.remove('animate-spin'), 300);
            }
        }
    };

    refreshBtn.addEventListener('click', fetchTelemetry);
};

document.addEventListener('DOMContentLoaded', () => {
    initGsapAnimations();
    initPortfolioTabs();
    initSkillFilter();
    initActiveNavTracking();
    initBackToTop();
    initMobileMenu();
    initCertificateCoverflow();
    initOrreryGallery();
    initLabsRotator();
    initTelemetryConsole();
    initLiveTelemetry();

    if (document.getElementById('dark-portfolio-root')) {
        initDarkPortfolio();
    }

    // Initialize interactive white starfield canvas if present
    if (document.getElementById('interactive-bg')) {
        initInteractiveBackground();
    }

    // Trigger ScrollTrigger refresh after initial DOM setup
    if (window.ScrollTrigger) {
        window.ScrollTrigger.refresh();
    }
});


