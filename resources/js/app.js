import { initInteractiveBackground } from './interactive-bg.js';
import { initOrreryGallery } from './orrery-gallery.js';
import Swiper from 'swiper';
import { EffectCoverflow, Pagination, Navigation, Keyboard, A11y } from 'swiper/modules';

// Reveal animation on scroll
const revealElements = () => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    document.querySelectorAll('.reveal, .reveal-slide-left, .reveal-slide-right, .reveal-scale').forEach((el) => {
        observer.observe(el);
    });
};

// Animated numerical counters
const animateCounters = () => {
    const counters = document.querySelectorAll('[data-counter]');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.dataset.counter, 10);
                const duration = 1600;
                const start = performance.now();

                const update = (now) => {
                    const elapsed = now - start;
                    const progress = Math.min(elapsed / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    el.textContent = Math.floor(target * eased);
                    if (progress < 1) {
                        requestAnimationFrame(update);
                    } else {
                        el.textContent = target;
                    }
                };

                requestAnimationFrame(update);
                observer.unobserve(el);
            }
        });
    }, { threshold: 0.3 });

    counters.forEach((el) => observer.observe(el));
};

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

// Skill filter buttons inside Tech Stack tab
const initSkillFilter = () => {
    const filterTabs = document.querySelectorAll('#skill-filter-tabs button');
    const skillCards = document.querySelectorAll('.skill-card');

    if (!filterTabs.length) return;

    filterTabs.forEach((btn) => {
        btn.addEventListener('click', () => {
            filterTabs.forEach((b) => {
                b.classList.remove('bg-rose-600', 'text-white', 'shadow-md', 'shadow-rose-600/30');
                b.classList.add('bg-white/[0.04]', 'border', 'border-white/[0.08]', 'text-zinc-400');
            });
            btn.classList.remove('bg-white/[0.04]', 'border', 'border-white/[0.08]', 'text-zinc-400');
            btn.classList.add('bg-rose-600', 'text-white', 'shadow-md', 'shadow-rose-600/30');

            const filter = btn.dataset.filter;
            skillCards.forEach((card) => {
                const category = card.dataset.category;
                const shouldShow = (filter === 'all' || category === filter);
                card.style.display = shouldShow ? 'block' : 'none';
            });
        });
    });
};

// Active Section Tracking for Floating Navbar
const initActiveNavTracking = () => {
    const navLinks = document.querySelectorAll('nav [data-nav-section]');
    const sections = document.querySelectorAll('section[id]');

    if (!navLinks.length || !sections.length) return;

    const onScroll = () => {
        const scrollPosition = window.scrollY + 200;
        let currentSectionId = '';

        sections.forEach((section) => {
            const top = section.offsetTop;
            const height = section.offsetHeight;
            if (scrollPosition >= top && scrollPosition < top + height) {
                currentSectionId = section.getAttribute('id');
            }
        });

        navLinks.forEach((link) => {
            const targetSection = link.getAttribute('data-nav-section');
            if (targetSection === currentSectionId) {
                link.classList.add('text-white', 'bg-white/[0.08]');
                link.classList.remove('text-zinc-400');
            } else {
                link.classList.remove('text-white', 'bg-white/[0.08]');
                link.classList.add('text-zinc-400');
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

document.addEventListener('DOMContentLoaded', () => {
    initInteractiveBackground();
    revealElements();
    animateCounters();
    initPortfolioTabs();
    initSkillFilter();
    initActiveNavTracking();
    initBackToTop();
    initMobileMenu();
    initCertificateCoverflow();
    initOrreryGallery();
});


