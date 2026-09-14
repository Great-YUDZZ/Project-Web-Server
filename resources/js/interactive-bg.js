/**
 * Interactive Background Canvas for Modern Engineering Clarity
 * High-performance 60 FPS network mesh particle system with mouse repulsion,
 * telemetry connections, upward drifting motes, and soft cursor ambient aura.
 */

export function initInteractiveBackground() {
    const canvas = document.getElementById('interactive-bg');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    let width = 0;
    let height = 0;
    let dpr = 1;
    let animationFrameId = null;
    let isRunning = false;

    // Prefers-reduced-motion check
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Mouse tracking with smooth lerp
    const mouse = {
        x: -9999,
        y: -9999,
        targetX: -9999,
        targetY: -9999,
        radius: 160,
        active: false,
    };

    let particles = [];
    let embers = [];

    class Particle {
        constructor() {
            this.reset(true);
        }

        reset(init = false) {
            this.x = init ? Math.random() * width : Math.random() * width;
            this.y = init ? Math.random() * height : Math.random() * height;
            const speed = prefersReducedMotion ? 0.05 : 0.4;
            this.vx = (Math.random() - 0.5) * speed;
            this.vy = (Math.random() - 0.5) * speed;
            this.radius = Math.random() * 1.5 + 1.0;
            this.baseAlpha = Math.random() * 0.35 + 0.25;
            this.alpha = this.baseAlpha;
            this.pulseSpeed = Math.random() * 0.02 + 0.01;
            this.pulseVal = Math.random() * Math.PI * 2;
            this.isElectricBlue = Math.random() > 0.45;
        }

        update() {
            // Pulse opacity
            this.pulseVal += this.pulseSpeed;
            this.alpha = this.baseAlpha + Math.sin(this.pulseVal) * 0.15;

            // Cursor reaction (smooth repulsion)
            if (mouse.active) {
                const dx = this.x - mouse.x;
                const dy = this.y - mouse.y;
                const dist = Math.sqrt(dx * dx + dy * dy);

                if (dist < mouse.radius && dist > 0) {
                    const force = (1 - dist / mouse.radius) * 1.8;
                    const angle = Math.atan2(dy, dx);
                    this.x += Math.cos(angle) * force * 2.0;
                    this.y += Math.sin(angle) * force * 2.0;
                }
            }

            // Standard velocity
            this.x += this.vx;
            this.y += this.vy;

            // Boundary wrapping
            if (this.x < -20) this.x = width + 20;
            else if (this.x > width + 20) this.x = -20;
            if (this.y < -20) this.y = height + 20;
            else if (this.y > height + 20) this.y = -20;
        }

        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            if (this.isElectricBlue) {
                ctx.fillStyle = `rgba(37, 99, 235, ${Math.max(0, this.alpha)})`;
                ctx.shadowColor = 'rgba(37, 99, 235, 0.4)';
                ctx.shadowBlur = 4;
            } else {
                ctx.fillStyle = `rgba(13, 148, 136, ${Math.max(0, this.alpha * 0.85)})`;
                ctx.shadowColor = 'rgba(13, 148, 136, 0.4)';
                ctx.shadowBlur = 4;
            }
            ctx.fill();
            ctx.shadowBlur = 0;
        }
    }

    class Ember {
        constructor() {
            this.reset(true);
        }

        reset(init = false) {
            this.x = Math.random() * width;
            this.y = init ? Math.random() * height : height + 10;
            this.vy = -(Math.random() * 0.5 + 0.25);
            this.vx = (Math.random() - 0.5) * 0.25;
            this.radius = Math.random() * 1.4 + 0.8;
            this.alpha = Math.random() * 0.4 + 0.15;
            this.sway = Math.random() * Math.PI * 2;
            this.swaySpeed = Math.random() * 0.025 + 0.01;
            this.isTeal = Math.random() > 0.5;
        }

        update() {
            this.sway += this.swaySpeed;
            this.x += this.vx + Math.sin(this.sway) * 0.35;
            this.y += this.vy;

            if (this.y < -10 || this.x < -10 || this.x > width + 10) {
                this.reset(false);
            }
        }

        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            if (this.isTeal) {
                ctx.fillStyle = `rgba(13, 148, 136, ${this.alpha})`;
                ctx.shadowColor = 'rgba(13, 148, 136, 0.4)';
            } else {
                ctx.fillStyle = `rgba(37, 99, 235, ${this.alpha})`;
                ctx.shadowColor = 'rgba(37, 99, 235, 0.4)';
            }
            ctx.shadowBlur = 5;
            ctx.fill();
            ctx.shadowBlur = 0;
        }
    }

    function resize() {
        dpr = Math.min(window.devicePixelRatio || 1, 2);
        width = window.innerWidth;
        height = window.innerHeight;

        canvas.width = Math.floor(width * dpr);
        canvas.height = Math.floor(height * dpr);
        canvas.style.width = `${width}px`;
        canvas.style.height = `${height}px`;
        ctx.scale(dpr, dpr);

        initParticles();
    }

    function initParticles() {
        const count = Math.min(55, Math.max(20, Math.floor(width / 28)));
        const emberCount = Math.min(18, Math.max(8, Math.floor(width / 80)));

        particles = [];
        for (let i = 0; i < count; i++) {
            particles.push(new Particle());
        }

        embers = [];
        for (let i = 0; i < emberCount; i++) {
            embers.push(new Ember());
        }
    }

    function drawConnections() {
        const maxDist = 115;
        const maxDistSq = maxDist * maxDist;

        for (let i = 0; i < particles.length; i++) {
            const p1 = particles[i];

            // Connect particles to nearby particles
            for (let j = i + 1; j < particles.length; j++) {
                const p2 = particles[j];
                const dx = p1.x - p2.x;
                const dy = p1.y - p2.y;
                const distSq = dx * dx + dy * dy;

                if (distSq < maxDistSq) {
                    const dist = Math.sqrt(distSq);
                    const alpha = (1 - dist / maxDist) * 0.16;
                    ctx.beginPath();
                    ctx.moveTo(p1.x, p1.y);
                    ctx.lineTo(p2.x, p2.y);
                    ctx.strokeStyle = (p1.isElectricBlue || p2.isElectricBlue)
                        ? `rgba(37, 99, 235, ${alpha})`
                        : `rgba(13, 148, 136, ${alpha})`;
                    ctx.lineWidth = 0.75;
                    ctx.stroke();
                }
            }

            // Connect nearby particles to cursor
            if (mouse.active) {
                const mdx = p1.x - mouse.x;
                const mdy = p1.y - mouse.y;
                const mDistSq = mdx * mdx + mdy * mdy;
                const cursorDist = mouse.radius;

                if (mDistSq < cursorDist * cursorDist) {
                    const mDist = Math.sqrt(mDistSq);
                    const mAlpha = (1 - mDist / cursorDist) * 0.25;
                    ctx.beginPath();
                    ctx.moveTo(p1.x, p1.y);
                    ctx.lineTo(mouse.x, mouse.y);
                    ctx.strokeStyle = `rgba(37, 99, 235, ${mAlpha})`;
                    ctx.lineWidth = 0.9;
                    ctx.stroke();
                }
            }
        }
    }

    function drawCursorAura() {
        if (!mouse.active) return;

        const auraGradient = ctx.createRadialGradient(
            mouse.x, mouse.y, 0,
            mouse.x, mouse.y, 160
        );
        auraGradient.addColorStop(0, 'rgba(37, 99, 235, 0.05)');
        auraGradient.addColorStop(0.5, 'rgba(13, 148, 136, 0.02)');
        auraGradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

        ctx.beginPath();
        ctx.arc(mouse.x, mouse.y, 160, 0, Math.PI * 2);
        ctx.fillStyle = auraGradient;
        ctx.fill();
    }

    function animate() {
        if (!isRunning) return;

        ctx.clearRect(0, 0, width, height);

        // Smooth mouse position lerping for organic movement
        if (mouse.active) {
            mouse.x += (mouse.targetX - mouse.x) * 0.15;
            mouse.y += (mouse.targetY - mouse.y) * 0.15;
        }

        // Draw cursor light aura
        drawCursorAura();

        // Update & Draw particle mesh
        drawConnections();

        for (let i = 0; i < particles.length; i++) {
            particles[i].update();
            particles[i].draw();
        }

        // Update & Draw drifting motes
        for (let i = 0; i < embers.length; i++) {
            embers[i].update();
            embers[i].draw();
        }

        animationFrameId = requestAnimationFrame(animate);
    }

    function onMouseMove(e) {
        mouse.targetX = e.clientX;
        mouse.targetY = e.clientY;
        if (!mouse.active) {
            mouse.x = e.clientX;
            mouse.y = e.clientY;
            mouse.active = true;
        }
    }

    function onMouseLeave() {
        mouse.active = false;
        mouse.targetX = -9999;
        mouse.targetY = -9999;
    }

    // Touch support
    function onTouchMove(e) {
        if (e.touches && e.touches.length > 0) {
            mouse.targetX = e.touches[0].clientX;
            mouse.targetY = e.touches[0].clientY;
            if (!mouse.active) {
                mouse.x = mouse.targetX;
                mouse.y = mouse.targetY;
                mouse.active = true;
            }
        }
    }

    function onTouchEnd() {
        mouse.active = false;
    }

    // Window blur/focus handling to save battery
    function onVisibilityChange() {
        if (document.hidden) {
            stop();
        } else {
            start();
        }
    }

    function start() {
        if (!isRunning) {
            isRunning = true;
            animate();
        }
    }

    function stop() {
        if (isRunning) {
            isRunning = false;
            if (animationFrameId) {
                cancelAnimationFrame(animationFrameId);
                animationFrameId = null;
            }
        }
    }

    // Debounced resize
    let resizeTimer = null;
    function handleResize() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            resize();
        }, 150);
    }

    // Initialize
    resize();
    start();

    // Event listeners
    window.addEventListener('resize', handleResize, { passive: true });
    window.addEventListener('mousemove', onMouseMove, { passive: true });
    document.addEventListener('mouseleave', onMouseLeave);
    window.addEventListener('touchmove', onTouchMove, { passive: true });
    window.addEventListener('touchend', onTouchEnd);
    document.addEventListener('visibilitychange', onVisibilityChange);
}
