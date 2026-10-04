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
        defaults: { ease: 'power2.out' },
        delay: 0
    });

    // Floating header navbar
    const headerNav = document.querySelector('header');
    if (headerNav) {
        tl.from(headerNav, 
            { y: -15, opacity: 0.7, duration: 0.4, clearProps: 'all' }
        );
    }

    // Hero headline and description (LCP optimized: never zero out text completely)
    const heroHeading = heroSection.querySelector('h1');
    if (heroHeading) {
        tl.from(heroHeading,
            { y: 15, opacity: 0.6, duration: 0.4, clearProps: 'all' },
            '-=0.2'
        );
    }

    const heroDesc = heroSection.querySelector('p');
    if (heroDesc) {
        tl.from(heroDesc,
            { y: 10, opacity: 0.7, duration: 0.35, clearProps: 'all' },
            '-=0.2'
        );
    }

    // Hero action buttons & earth cards
    const heroInteractive = heroSection.querySelectorAll('.btn-earth-green, .btn-earth-outline, .card-earth');
    if (heroInteractive.length) {
        tl.from(heroInteractive,
            { y: 12, opacity: 0.7, duration: 0.35, stagger: 0.04, clearProps: 'all' },
            '-=0.2'
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
 * 5. High-Performance 3D Perspective Tilt via GSAP quickTo
 * Follows GreenSock official skill recommendations for zero-churn 60 FPS mouse tracking.
 */
const initInteractiveTilt = () => {
    if (prefersReducedMotion()) return;
    if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;

    const tiltCards = document.querySelectorAll('.card-interactive, .glass-panel-interactive, .discord-card, .skill-card');
    tiltCards.forEach((card) => {
        let bounds = null;

        const rotateXTo = gsap.quickTo(card, 'rotateX', { duration: 0.25, ease: 'power2.out' });
        const rotateYTo = gsap.quickTo(card, 'rotateY', { duration: 0.25, ease: 'power2.out' });
        const scaleTo = gsap.quickTo(card, 'scale', { duration: 0.28, ease: 'power2.out' });

        const onMouseEnter = () => {
            bounds = card.getBoundingClientRect();
            card.style.transformPerspective = '1000px';
            scaleTo(1.014);
        };

        const onMouseMove = (e) => {
            if (!bounds) bounds = card.getBoundingClientRect();
            const mouseX = e.clientX - bounds.left;
            const mouseY = e.clientY - bounds.top;
            const xPct = (mouseX / bounds.width) - 0.5;
            const yPct = (mouseY / bounds.height) - 0.5;

            // Update CSS custom properties for dynamic light sheen
            card.style.setProperty('--mouse-x', `${(mouseX / bounds.width * 100).toFixed(1)}%`);
            card.style.setProperty('--mouse-y', `${(mouseY / bounds.height * 100).toFixed(1)}%`);

            rotateXTo(-yPct * 6.5);
            rotateYTo(xPct * 6.5);
        };

        const onMouseLeave = () => {
            bounds = null;
            rotateXTo(0);
            rotateYTo(0);
            scaleTo(1);
        };

        card.addEventListener('mouseenter', onMouseEnter);
        card.addEventListener('mousemove', onMouseMove, { passive: true });
        card.addEventListener('mouseleave', onMouseLeave);
    });
};

/**
 * 6. Magnetic Buttons & Micro-Interactions via GSAP quickTo
 * Delivers tactile physical responsiveness to primary interactive elements.
 */
const initMagneticButtons = () => {
    if (prefersReducedMotion()) return;
    if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;

    const magneticElements = document.querySelectorAll('.btn-discord-white, .btn-discord-blurple, #back-to-top, .btn-primary');
    magneticElements.forEach((el) => {
        const xTo = gsap.quickTo(el, 'x', { duration: 0.35, ease: 'power2.out' });
        const yTo = gsap.quickTo(el, 'y', { duration: 0.35, ease: 'power2.out' });

        const onMouseMove = (e) => {
            const rect = el.getBoundingClientRect();
            const relX = e.clientX - (rect.left + rect.width / 2);
            const relY = e.clientY - (rect.top + rect.height / 2);

            const pullX = Math.max(-10, Math.min(10, relX * 0.28));
            const pullY = Math.max(-8, Math.min(8, relY * 0.28));

            xTo(pullX);
            yTo(pullY);
        };

        const onMouseLeave = () => {
            gsap.to(el, {
                x: 0,
                y: 0,
                duration: 0.55,
                ease: 'elastic.out(1, 0.4)',
                overwrite: 'auto'
            });
        };

        el.addEventListener('mousemove', onMouseMove, { passive: true });
        el.addEventListener('mouseleave', onMouseLeave);
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
 * 7. Discord-Style 3D Hardware Assets & Scrollytelling Animations
 */
const initDiscord3DAnimations = () => {
    // Slide-out Animation for Corner LAN Cable (Emerging from top-left corner into #skills)
    const lanCable = document.getElementById('floating-lan-cable');
    if (lanCable && !prefersReducedMotion()) {
        gsap.fromTo(lanCable,
            { x: -60, y: -60, rotation: -4 },
            {
                x: 8,
                y: 8,
                rotation: 0,
                ease: 'power1.out',
                scrollTrigger: {
                    trigger: '#skills',
                    start: 'top bottom',
                    end: 'top 25%',
                    scrub: 1.2
                }
            }
        );
    }

    // Parallax Scroll for Floating Enterprise Server Unit
    const serverRack = document.getElementById('floating-server-rack');
    if (serverRack && !prefersReducedMotion()) {
        gsap.to(serverRack, {
            y: -70,
            rotation: 4,
            ease: 'none',
            scrollTrigger: {
                trigger: '#about',
                start: 'top bottom',
                end: 'bottom top',
                scrub: 1.5
            }
        });
    }
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
    initMagneticButtons();
    initDiscord3DAnimations();

    // Refresh ScrollTrigger after fonts and layout settle
    window.addEventListener('load', () => {
        ScrollTrigger.refresh();
    });

    window.addEventListener('resize', () => {
        ScrollTrigger.refresh();
    });
};
