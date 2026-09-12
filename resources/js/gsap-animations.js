import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

// Check for reduced motion preference
const prefersReducedMotion = () => {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
};

/**
 * 1. Hero Section Cinematic Entry Timeline
 */
const initHeroTimeline = () => {
    if (prefersReducedMotion()) return;

    const heroSection = document.getElementById('home');
    if (!heroSection) return;

    const tl = gsap.timeline({
        defaults: { ease: 'power3.out' },
        delay: 0.05
    });

    // Floating header navbar
    const headerNav = document.querySelector('header');
    if (headerNav) {
        tl.fromTo(headerNav, 
            { y: -25, opacity: 0 },
            { y: 0, opacity: 1, duration: 0.6, clearProps: 'opacity,transform' }
        );
    }

    // Hero eyebrow badge
    const heroBadge = heroSection.querySelector('.glass-pill');
    if (heroBadge) {
        tl.fromTo(heroBadge,
            { scale: 0.9, opacity: 0 },
            { scale: 1, opacity: 1, duration: 0.5, ease: 'back.out(1.5)', clearProps: 'opacity,transform' },
            '-=0.4'
        );
    }

    // Hero headline
    const heroHeading = heroSection.querySelector('h1');
    if (heroHeading) {
        tl.fromTo(heroHeading,
            { y: 30, opacity: 0 },
            { y: 0, opacity: 1, duration: 0.65, clearProps: 'opacity,transform' },
            '-=0.35'
        );
    }

    // Hero description
    const heroDesc = heroSection.querySelector('p');
    if (heroDesc) {
        tl.fromTo(heroDesc,
            { y: 20, opacity: 0 },
            { y: 0, opacity: 1, duration: 0.55, clearProps: 'opacity,transform' },
            '-=0.45'
        );
    }

    // Hero action buttons & social links
    const heroButtons = heroSection.querySelectorAll('.btn-primary, .btn-ghost, a.glass-panel-interactive');
    if (heroButtons.length) {
        tl.fromTo(heroButtons,
            { y: 18, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 0.5,
                stagger: 0.05,
                clearProps: 'opacity,transform'
            },
            '-=0.35'
        );
    }

    // Floating SLA/Metric mini cards
    const metricCards = heroSection.querySelectorAll('.grid-cols-2 > div');
    if (metricCards.length) {
        tl.fromTo(metricCards,
            { y: 22, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 0.55,
                stagger: 0.08,
                clearProps: 'opacity,transform'
            },
            '-=0.3'
        );
    }

    // Right Neofetch terminal window
    const terminalWindow = heroSection.querySelector('.lg\\:col-span-5');
    if (terminalWindow) {
        tl.fromTo(terminalWindow,
            { scale: 0.94, y: 25, opacity: 0 },
            { scale: 1, y: 0, opacity: 1, duration: 0.8, ease: 'power3.out', clearProps: 'opacity,transform' },
            '-=0.9'
        );
    }
};

/**
 * 2. High-Precision ScrollTrigger Section & Element Reveals
 */
const initScrollReveals = () => {
    if (prefersReducedMotion()) {
        document.querySelectorAll('.reveal, .reveal-slide-left, .reveal-slide-right, .reveal-scale').forEach((el) => {
            el.style.opacity = '1';
            el.style.transform = 'none';
        });
        return;
    }

    // Register legacy reveal classes with ScrollTrigger
    document.querySelectorAll('.reveal, .reveal-slide-left, .reveal-slide-right, .reveal-scale').forEach((el) => {
        ScrollTrigger.create({
            trigger: el,
            start: 'top 88%',
            once: true,
            onEnter: () => {
                el.classList.add('is-visible');
            }
        });
    });

    // Smooth section headers reveal
    const sections = document.querySelectorAll('section[id]:not(#home)');
    sections.forEach((sec) => {
        const headerElements = sec.querySelectorAll('h2, p.text-zinc-400, .inline-flex.items-center');
        if (headerElements.length) {
            gsap.fromTo(headerElements,
                { y: 30, opacity: 0 },
                {
                    scrollTrigger: {
                        trigger: sec,
                        start: 'top 82%',
                        toggleActions: 'play none none none'
                    },
                    y: 0,
                    opacity: 1,
                    duration: 0.85,
                    stagger: 0.1,
                    ease: 'power3.out',
                    clearProps: 'opacity,transform'
                }
            );
        }
    });

    // About section cards
    const aboutSection = document.getElementById('about');
    if (aboutSection) {
        const profileCard = aboutSection.querySelector('.glass-panel');
        if (profileCard) {
            gsap.fromTo(profileCard,
                { x: -35, opacity: 0 },
                {
                    scrollTrigger: {
                        trigger: profileCard,
                        start: 'top 85%'
                    },
                    x: 0,
                    opacity: 1,
                    duration: 0.9,
                    ease: 'power3.out',
                    clearProps: 'opacity,transform'
                }
            );
        }

        const statCards = aboutSection.querySelectorAll('.grid > div.glass-panel-interactive');
        if (statCards.length) {
            gsap.fromTo(statCards,
                { y: 35, opacity: 0 },
                {
                    scrollTrigger: {
                        trigger: aboutSection.querySelector('.grid'),
                        start: 'top 85%'
                    },
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    stagger: 0.12,
                    ease: 'power2.out',
                    clearProps: 'opacity,transform'
                }
            );
        }
    }

    // Certifications 3D Coverflow container
    const certsSection = document.getElementById('certifications');
    if (certsSection) {
        const coverflowCard = certsSection.querySelector('.glass-panel');
        if (coverflowCard) {
            gsap.fromTo(coverflowCard,
                { y: 40, opacity: 0 },
                {
                    scrollTrigger: {
                        trigger: coverflowCard,
                        start: 'top 80%'
                    },
                    y: 0,
                    opacity: 1,
                    duration: 1,
                    ease: 'power3.out',
                    clearProps: 'opacity,transform'
                }
            );
        }
    }

    // Lab showcase cards
    const labsSection = document.getElementById('labs');
    if (labsSection) {
        const labCards = labsSection.querySelectorAll('.grid > a.card-interactive');
        if (labCards.length) {
            gsap.fromTo(labCards,
                { y: 40, opacity: 0 },
                {
                    scrollTrigger: {
                        trigger: labsSection.querySelector('.grid'),
                        start: 'top 80%'
                    },
                    y: 0,
                    opacity: 1,
                    duration: 0.9,
                    stagger: 0.16,
                    ease: 'power3.out',
                    clearProps: 'opacity,transform'
                }
            );
        }
    }

    // Architecture Orrery container
    const archSection = document.getElementById('architecture');
    if (archSection) {
        const orreryWrapper = archSection.querySelector('.orrery-wrapper');
        if (orreryWrapper) {
            gsap.fromTo(orreryWrapper,
                { y: 40, opacity: 0 },
                {
                    scrollTrigger: {
                        trigger: orreryWrapper,
                        start: 'top 82%'
                    },
                    y: 0,
                    opacity: 1,
                    duration: 1,
                    ease: 'power3.out',
                    clearProps: 'opacity,transform'
                }
            );
        }
    }

    // Contact cards and form
    const contactSection = document.getElementById('contact');
    if (contactSection) {
        const contactLinks = contactSection.querySelectorAll('.space-y-3 > a, .space-y-4 > a');
        if (contactLinks.length) {
            gsap.fromTo(contactLinks,
                { x: -30, opacity: 0 },
                {
                    scrollTrigger: {
                        trigger: contactSection,
                        start: 'top 80%'
                    },
                    x: 0,
                    opacity: 1,
                    duration: 0.8,
                    stagger: 0.1,
                    ease: 'power2.out',
                    clearProps: 'opacity,transform'
                }
            );
        }

        const contactFormCard = contactSection.querySelector('.glass-panel');
        if (contactFormCard) {
            gsap.fromTo(contactFormCard,
                { x: 35, opacity: 0 },
                {
                    scrollTrigger: {
                        trigger: contactFormCard,
                        start: 'top 80%'
                    },
                    x: 0,
                    opacity: 1,
                    duration: 0.9,
                    ease: 'power3.out',
                    clearProps: 'opacity,transform'
                }
            );
        }
    }
};

/**
 * 3. GSAP Animated Numerical Counters
 */
const initGsapCounters = () => {
    const counterElements = document.querySelectorAll('[data-counter]');
    if (!counterElements.length) return;

    counterElements.forEach((el) => {
        const targetValue = parseInt(el.dataset.counter, 10) || 0;

        ScrollTrigger.create({
            trigger: el,
            start: 'top 88%',
            once: true,
            onEnter: () => {
                const counterObj = { val: 0 };
                gsap.to(counterObj, {
                    val: targetValue,
                    duration: 1.8,
                    ease: 'power2.out',
                    onUpdate: () => {
                        el.textContent = Math.round(counterObj.val);
                    }
                });
            }
        });
    });
};

/**
 * 4. GSAP Skill Matrix Dynamic Progress Bars
 */
const initGsapSkillBars = () => {
    const skillsSection = document.getElementById('skills');
    if (!skillsSection) return;

    const skillCards = skillsSection.querySelectorAll('.skill-card');
    if (!skillCards.length) return;

    // Save target widths from inline styles and reset to 0
    const barData = [];
    skillCards.forEach((card) => {
        const bar = card.querySelector('.h-full.bg-gradient-to-r');
        if (bar) {
            const targetWidth = bar.style.width || '100%';
            bar.style.width = '0%';
            barData.push({ bar, targetWidth });
        }
    });

    ScrollTrigger.create({
        trigger: '#skills-grid',
        start: 'top 80%',
        once: true,
        onEnter: () => {
            barData.forEach(({ bar, targetWidth }, idx) => {
                gsap.to(bar, {
                    width: targetWidth,
                    duration: 1.2,
                    delay: idx * 0.04,
                    ease: 'power2.out'
                });
            });
        }
    });
};

/**
 * 5. Interactive 3D Parallax & Magnetic Tilt on Glass Cards
 */
const initInteractiveTilt = () => {
    if (prefersReducedMotion()) return;
    if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;

    const tiltCards = document.querySelectorAll('.card-interactive, .glass-panel-interactive');
    tiltCards.forEach((card) => {
        let bounds = null;

        const onMouseEnter = () => {
            bounds = card.getBoundingClientRect();
            // Temporarily disable CSS transition during mouse tracking for fluid 60fps response
            card.style.transition = 'background-color 300ms ease, border-color 300ms ease, box-shadow 300ms ease';
        };

        const onMouseMove = (e) => {
            if (!bounds) bounds = card.getBoundingClientRect();
            const mouseX = e.clientX - bounds.left;
            const mouseY = e.clientY - bounds.top;
            const xPct = (mouseX / bounds.width) - 0.5;
            const yPct = (mouseY / bounds.height) - 0.5;

            const rotateX = -yPct * 6.5;
            const rotateY = xPct * 6.5;

            gsap.to(card, {
                rotateX: rotateX,
                rotateY: rotateY,
                transformPerspective: 1000,
                scale: 1.012,
                duration: 0.3,
                ease: 'power1.out',
                overwrite: 'auto'
            });
        };

        const onMouseLeave = () => {
            bounds = null;
            gsap.to(card, {
                rotateX: 0,
                rotateY: 0,
                scale: 1,
                duration: 0.6,
                ease: 'power2.out',
                overwrite: 'auto',
                onComplete: () => {
                    card.style.transition = '';
                }
            });
        };

        card.addEventListener('mouseenter', onMouseEnter);
        card.addEventListener('mousemove', onMouseMove);
        card.addEventListener('mouseleave', onMouseLeave);
    });
};

/**
 * 6. GSAP Modal Transitions for Lightbox & Technology Dialog
 */
export const animateModalOpen = (modalEl, cardEl) => {
    if (!modalEl || !cardEl) return;

    modalEl.classList.remove('hidden');
    modalEl.classList.add('flex');
    document.body.style.overflow = 'hidden';

    if (prefersReducedMotion()) {
        modalEl.style.opacity = '1';
        cardEl.style.transform = 'none';
        return;
    }

    gsap.killTweensOf([modalEl, cardEl]);

    gsap.fromTo(modalEl, 
        { opacity: 0 }, 
        { opacity: 1, duration: 0.35, ease: 'power2.out' }
    );

    gsap.fromTo(cardEl, 
        { scale: 0.92, y: 25, opacity: 0 }, 
        { scale: 1, y: 0, opacity: 1, duration: 0.45, ease: 'back.out(1.5)' }
    );
};

export const animateModalClose = (modalEl, cardEl, onComplete) => {
    if (!modalEl || !cardEl) return;

    if (prefersReducedMotion()) {
        modalEl.classList.add('hidden');
        modalEl.classList.remove('flex');
        document.body.style.overflow = '';
        if (typeof onComplete === 'function') onComplete();
        return;
    }

    gsap.killTweensOf([modalEl, cardEl]);

    gsap.to(cardEl, {
        scale: 0.94,
        y: 15,
        opacity: 0,
        duration: 0.25,
        ease: 'power2.in'
    });

    gsap.to(modalEl, {
        opacity: 0,
        duration: 0.28,
        ease: 'power2.in',
        onComplete: () => {
            modalEl.classList.add('hidden');
            modalEl.classList.remove('flex');
            document.body.style.overflow = '';
            // Reset styles for next open
            gsap.set([modalEl, cardEl], { clearProps: 'all' });
            if (typeof onComplete === 'function') onComplete();
        }
    });
};

/**
 * Master Initialization
 */
export const initGsapAnimations = () => {
    // Expose GSAP and ScrollTrigger globally for testing and interactive hooks
    window.gsap = gsap;
    window.ScrollTrigger = ScrollTrigger;
    window.animateModalOpen = animateModalOpen;
    window.animateModalClose = animateModalClose;

    initHeroTimeline();
    initScrollReveals();
    initGsapCounters();
    initGsapSkillBars();
    initInteractiveTilt();

    // Refresh ScrollTrigger after fonts and layout settle
    window.addEventListener('load', () => {
        ScrollTrigger.refresh();
    });

    window.addEventListener('resize', () => {
        ScrollTrigger.refresh();
    });
};
