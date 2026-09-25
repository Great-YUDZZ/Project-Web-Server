import * as THREE from 'three';

/**
 * Three.js Interactive 3D Cosmic Network & Telemetry Topology Engine
 * Powered by Three.js (r186) and Creative Coding Motion Principles.
 *
 * Features:
 * - Real 3D spatial network topology with dynamic Euclidean line interlinks
 * - Deep cosmic starfield with soft circular glows and Discord chromatic colors
 * - 60 FPS compositor-level performance with zero per-frame memory allocation
 * - Responsive 3D mouse parallax and smooth scroll-depth interpolation
 * - Strict prefers-reduced-motion accessibility support
 * - Graceful fallback to 2D Canvas if WebGL is unavailable
 */

export function initInteractiveBackground() {
    const canvas = document.getElementById('interactive-bg');
    if (!canvas) return;

    // Check if WebGL is supported
    const isWebGLSupported = () => {
        try {
            const testCanvas = document.createElement('canvas');
            return !!(window.WebGLRenderingContext && (testCanvas.getContext('webgl') || testCanvas.getContext('experimental-webgl')));
        } catch {
            return false;
        }
    };

    if (!isWebGLSupported()) {
        init2DFallback(canvas);
        return;
    }

    try {
        initThreeJsBackground(canvas);
    } catch (e) {
        console.warn('Three.js background initialization failed, falling back to 2D:', e);
        init2DFallback(canvas);
    }
}

/**
 * High-Performance Three.js 3D Background Engine
 */
function initThreeJsBackground(canvas) {
    let width = window.innerWidth;
    let height = window.innerHeight;
    let animationFrameId = null;
    let isRunning = false;

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // 1. Renderer Setup
    const renderer = new THREE.WebGLRenderer({
        canvas,
        alpha: true,
        antialias: true,
        powerPreference: 'high-performance'
    });
    renderer.setSize(width, height, false);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));

    // 2. Camera & Scene Setup
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(55, width / height, 1, 3000);
    camera.position.z = 650;

    // Mouse coordinates with smooth lerp
    const mouse = {
        targetX: 0,
        targetY: 0,
        currentX: 0,
        currentY: 0,
        active: false
    };

    // Helper texture: circular glowing sprite without jagged pixel edges
    const createCircleTexture = () => {
        const texCanvas = document.createElement('canvas');
        texCanvas.width = 64;
        texCanvas.height = 64;
        const ctx = texCanvas.getContext('2d');
        const grad = ctx.createRadialGradient(32, 32, 0, 32, 32, 32);
        grad.addColorStop(0, 'rgba(255, 255, 255, 1)');
        grad.addColorStop(0.35, 'rgba(255, 255, 255, 0.85)');
        grad.addColorStop(0.7, 'rgba(255, 255, 255, 0.25)');
        grad.addColorStop(1, 'rgba(255, 255, 255, 0)');
        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, 64, 64);
        const texture = new THREE.CanvasTexture(texCanvas);
        texture.needsUpdate = true;
        return texture;
    };

    const circleTexture = createCircleTexture();

    // 3. Deep Starfield Layer
    const starCount = window.innerWidth < 768 ? 280 : 550;
    const starGeometry = new THREE.BufferGeometry();
    const starPositions = new Float32Array(starCount * 3);
    const starColors = new Float32Array(starCount * 3);

    // Color palette: Sage Green (#2D5A47), Deep Forest Green (#0C382E), Terracotta (#9C6644), Warm Amber (#B45309), Warm Stone (#78716C)
    const colorPalette = [
        new THREE.Color('#2D5A47'),
        new THREE.Color('#0C382E'),
        new THREE.Color('#9C6644'),
        new THREE.Color('#B45309'),
        new THREE.Color('#78716C'),
        new THREE.Color('#446B5A')
    ];

    for (let i = 0; i < starCount; i++) {
        const i3 = i * 3;
        starPositions[i3] = (Math.random() - 0.5) * 1600;
        starPositions[i3 + 1] = (Math.random() - 0.5) * 1400;
        starPositions[i3 + 2] = (Math.random() - 0.5) * 800 - 200;

        const col = colorPalette[Math.floor(Math.random() * colorPalette.length)];
        starColors[i3] = col.r;
        starColors[i3 + 1] = col.g;
        starColors[i3 + 2] = col.b;
    }

    starGeometry.setAttribute('position', new THREE.BufferAttribute(starPositions, 3));
    starGeometry.setAttribute('color', new THREE.BufferAttribute(starColors, 3));

    const starMaterial = new THREE.PointsMaterial({
        size: 3.5,
        map: circleTexture,
        vertexColors: true,
        transparent: true,
        opacity: 0.45,
        blending: THREE.NormalBlending,
        depthWrite: false
    });

    const starPoints = new THREE.Points(starGeometry, starMaterial);
    scene.add(starPoints);

    // 4. Foreground 3D Network Telemetry Topology (Nodes & Connecting Fibers)
    const nodeCount = window.innerWidth < 768 ? 36 : 64;
    const nodeGeometry = new THREE.BufferGeometry();
    const nodePositions = new Float32Array(nodeCount * 3);
    const nodeColors = new Float32Array(nodeCount * 3);
    const nodeVelocities = [];

    const bounds = {
        x: 580,
        y: 460,
        z: 260
    };

    for (let i = 0; i < nodeCount; i++) {
        const i3 = i * 3;
        nodePositions[i3] = (Math.random() - 0.5) * bounds.x * 2;
        nodePositions[i3 + 1] = (Math.random() - 0.5) * bounds.y * 2;
        nodePositions[i3 + 2] = (Math.random() - 0.5) * bounds.z * 2;

        const col = colorPalette[i % colorPalette.length];
        nodeColors[i3] = col.r;
        nodeColors[i3 + 1] = col.g;
        nodeColors[i3 + 2] = col.b;

        const speed = prefersReducedMotion ? 0.04 : 0.28;
        nodeVelocities.push({
            vx: (Math.random() - 0.5) * speed,
            vy: (Math.random() - 0.5) * speed,
            vz: (Math.random() - 0.5) * speed * 0.7
        });
    }

    nodeGeometry.setAttribute('position', new THREE.BufferAttribute(nodePositions, 3));
    nodeGeometry.setAttribute('color', new THREE.BufferAttribute(nodeColors, 3));

    const nodeMaterial = new THREE.PointsMaterial({
        size: 6.5,
        map: circleTexture,
        vertexColors: true,
        transparent: true,
        opacity: 0.65,
        blending: THREE.NormalBlending,
        depthWrite: false
    });

    const nodePoints = new THREE.Points(nodeGeometry, nodeMaterial);
    scene.add(nodePoints);

    // 5. Dynamic 3D Interlink Lines (LineSegments)
    // Pre-allocate maximum possible lines to prevent per-frame garbage collection
    const maxLineSegments = nodeCount * 4;
    const linePositions = new Float32Array(maxLineSegments * 6); // 2 vertices * 3 coords
    const lineColors = new Float32Array(maxLineSegments * 6);

    const lineGeometry = new THREE.BufferGeometry();
    lineGeometry.setAttribute('position', new THREE.BufferAttribute(linePositions, 3));
    lineGeometry.setAttribute('color', new THREE.BufferAttribute(lineColors, 3));

    const lineMaterial = new THREE.LineBasicMaterial({
        vertexColors: true,
        transparent: true,
        opacity: 0.22,
        blending: THREE.NormalBlending,
        depthWrite: false
    });

    const lineMesh = new THREE.LineSegments(lineGeometry, lineMaterial);
    scene.add(lineMesh);

    // Pre-allocated distance and vector caches
    const connectionDistLimit = window.innerWidth < 768 ? 140 : 180;
    const connectionDistLimitSq = connectionDistLimit * connectionDistLimit;

    // Clock for delta-time independence
    const clock = new THREE.Clock();

    // 6. Animation Frame Loop
    const animate = () => {
        if (!isRunning) return;

        animationFrameId = requestAnimationFrame(animate);

        const delta = Math.min(clock.getDelta(), 0.1);
        const time = clock.getElapsedTime();

        // Smooth mouse lerping
        mouse.currentX += (mouse.targetX - mouse.currentX) * 0.05;
        mouse.currentY += (mouse.targetY - mouse.currentY) * 0.05;

        // Camera subtle 3D orbital tilt based on cursor
        if (!prefersReducedMotion) {
            camera.position.x = mouse.currentX * 55;
            camera.position.y = -mouse.currentY * 45;

            // Scroll parallax depth effect
            const scrollNorm = window.scrollY / Math.max(1, document.body.scrollHeight - window.innerHeight);
            camera.position.y -= (scrollNorm - 0.5) * 60;
        }
        camera.lookAt(0, 0, 0);

        // Ambient starfield rotation
        if (!prefersReducedMotion) {
            starPoints.rotation.y = time * 0.015;
            starPoints.rotation.x = Math.sin(time * 0.01) * 0.03;
        }

        // Update 3D network node positions
        const posAttr = nodeGeometry.attributes.position;
        const posArr = posAttr.array;

        for (let i = 0; i < nodeCount; i++) {
            const i3 = i * 3;
            const vel = nodeVelocities[i];

            if (!prefersReducedMotion) {
                posArr[i3] += vel.vx * (delta * 60);
                posArr[i3 + 1] += vel.vy * (delta * 60);
                posArr[i3 + 2] += vel.vz * (delta * 60);

                // Boundary reflection with soft turn
                if (posArr[i3] < -bounds.x || posArr[i3] > bounds.x) vel.vx *= -1;
                if (posArr[i3 + 1] < -bounds.y || posArr[i3 + 1] > bounds.y) vel.vy *= -1;
                if (posArr[i3 + 2] < -bounds.z || posArr[i3 + 2] > bounds.z) vel.vz *= -1;
            }
        }
        posAttr.needsUpdate = true;

        // Recompute dynamic interlink lines between nearby nodes
        let lineVertexCount = 0;
        const linePosArr = lineGeometry.attributes.position.array;
        const lineColArr = lineGeometry.attributes.color.array;

        for (let i = 0; i < nodeCount && lineVertexCount < maxLineSegments * 2; i++) {
            const i3 = i * 3;
            const x1 = posArr[i3];
            const y1 = posArr[i3 + 1];
            const z1 = posArr[i3 + 2];

            for (let j = i + 1; j < nodeCount && lineVertexCount < maxLineSegments * 2; j++) {
                const j3 = j * 3;
                const dx = x1 - posArr[j3];
                const dy = y1 - posArr[j3 + 1];
                const dz = z1 - posArr[j3 + 2];
                const distSq = dx * dx + dy * dy + dz * dz;

                if (distSq < connectionDistLimitSq) {
                    const alpha = 1.0 - Math.sqrt(distSq) / connectionDistLimit;

                    // Vertex 1
                    linePosArr[lineVertexCount * 3] = x1;
                    linePosArr[lineVertexCount * 3 + 1] = y1;
                    linePosArr[lineVertexCount * 3 + 2] = z1;

                    lineColArr[lineVertexCount * 3] = nodeColors[i3] * alpha;
                    lineColArr[lineVertexCount * 3 + 1] = nodeColors[i3 + 1] * alpha;
                    lineColArr[lineVertexCount * 3 + 2] = nodeColors[i3 + 2] * alpha;
                    lineVertexCount++;

                    // Vertex 2
                    linePosArr[lineVertexCount * 3] = posArr[j3];
                    linePosArr[lineVertexCount * 3 + 1] = posArr[j3 + 1];
                    linePosArr[lineVertexCount * 3 + 2] = posArr[j3 + 2];

                    lineColArr[lineVertexCount * 3] = nodeColors[j3] * alpha;
                    lineColArr[lineVertexCount * 3 + 1] = nodeColors[j3 + 1] * alpha;
                    lineColArr[lineVertexCount * 3 + 2] = nodeColors[j3 + 2] * alpha;
                    lineVertexCount++;
                }
            }
        }

        lineGeometry.setDrawRange(0, lineVertexCount);
        lineGeometry.attributes.position.needsUpdate = true;
        lineGeometry.attributes.color.needsUpdate = true;

        renderer.render(scene, camera);
    };

    // 7. Event Handlers
    const onMouseMove = (e) => {
        mouse.targetX = (e.clientX / window.innerWidth) * 2 - 1;
        mouse.targetY = (e.clientY / window.innerHeight) * 2 - 1;
        mouse.active = true;
    };

    const onMouseLeave = () => {
        mouse.targetX = 0;
        mouse.targetY = 0;
        mouse.active = false;
    };

    const onTouchMove = (e) => {
        if (e.touches.length > 0) {
            mouse.targetX = (e.touches[0].clientX / window.innerWidth) * 2 - 1;
            mouse.targetY = (e.touches[0].clientY / window.innerHeight) * 2 - 1;
            mouse.active = true;
        }
    };

    const onTouchEnd = () => {
        mouse.targetX = 0;
        mouse.targetY = 0;
        mouse.active = false;
    };

    let resizeTimer = null;
    const onResize = () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            width = window.innerWidth;
            height = window.innerHeight;
            camera.aspect = width / height;
            camera.updateProjectionMatrix();
            renderer.setSize(width, height, false);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
        }, 120);
    };

    const onVisibilityChange = () => {
        if (document.hidden) {
            isRunning = false;
            if (animationFrameId) {
                cancelAnimationFrame(animationFrameId);
                animationFrameId = null;
            }
        } else {
            if (!isRunning) {
                isRunning = true;
                clock.start();
                animate();
            }
        }
    };

    // Attach listeners
    window.addEventListener('mousemove', onMouseMove, { passive: true });
    document.addEventListener('mouseleave', onMouseLeave);
    window.addEventListener('touchmove', onTouchMove, { passive: true });
    window.addEventListener('touchend', onTouchEnd);
    window.addEventListener('resize', onResize, { passive: true });
    document.addEventListener('visibilitychange', onVisibilityChange);

    // Start render
    isRunning = true;
    clock.start();
    animate();
}

/**
 * Lightweight 2D Canvas Fallback
 * Used only if browser lacks WebGL capability.
 */
function init2DFallback(canvas) {
    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    let width = 0;
    let height = 0;
    let animationFrameId = null;
    let isRunning = false;

    const resize = () => {
        width = window.innerWidth;
        height = window.innerHeight;
        canvas.width = width;
        canvas.height = height;
    };

    const particles = Array.from({ length: 40 }, () => ({
        x: Math.random() * window.innerWidth,
        y: Math.random() * window.innerHeight,
        vx: (Math.random() - 0.5) * 0.3,
        vy: (Math.random() - 0.5) * 0.3,
        radius: Math.random() * 2 + 1,
        color: Math.random() > 0.5 ? 'rgba(12, 56, 46, 0.22)' : 'rgba(156, 102, 68, 0.22)'
    }));

    const render = () => {
        if (!isRunning) return;
        ctx.clearRect(0, 0, width, height);

        for (let i = 0; i < particles.length; i++) {
            const p = particles[i];
            p.x += p.vx;
            p.y += p.vy;
            if (p.x < 0) p.x = width;
            if (p.x > width) p.x = 0;
            if (p.y < 0) p.y = height;
            if (p.y > height) p.y = 0;

            ctx.beginPath();
            ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
            ctx.fillStyle = p.color;
            ctx.fill();
        }

        animationFrameId = requestAnimationFrame(render);
    };

    resize();
    window.addEventListener('resize', resize);
    isRunning = true;
    render();
}
