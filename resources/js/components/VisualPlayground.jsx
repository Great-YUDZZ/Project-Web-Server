'use client';

import React, { useState, useRef, useEffect } from 'react';
import { motion, useMotionValue, useSpring, useTransform, AnimatePresence } from 'framer-motion';

/**
 * Visual Playground - Web Technology Showcase Component
 * Built for React / Next.js with Tailwind CSS & Framer Motion.
 * 
 * Features:
 * - Infinite Vertical Flow: Cards rise continuously from bottom to top (seamless vertical loop)
 * - Asymmetrical Multi-Column Layout: Placed on left & right sides with staggered speeds
 * - Fixed/Sticky Center Anchor: "TEKNOLOGI Pembuatan Web" remains static and unobstructed in the center
 * - Mouse Parallax & Tilt: Subtle inertial horizontal tilt based on cursor position
 * - Hover Pause & Slowdown: Hovering any card halts/slows down the flow for comfortable reading & clicking
 * - Interactive Telemetry Modal with 4 Boundary States (AetherCraft Protocol)
 */

// 1. Curated Web Technologies Data with Official Brand Logos
const TECHNOLOGIES = {
  laravel: {
    id: 'laravel',
    name: 'Laravel 11',
    role: 'Core SSR API',
    category: 'Backend Architecture',
    color: '#FF2D20',
    rgb: '255,45,32',
    logo: '/images/tech_logos/laravel.png',
    svg: '/images/tech/laravel.svg',
    explanation: 'Framework backend berbasis PHP modern dengan arsitektur Model-View-Controller (MVC) terisolasi, routing deterministik, dan middleware keamanan tingkat enterprise.',
    rationale: 'Menjamin pemrosesan request berkecepatan tinggi dengan pipeline data terstruktur dan proteksi CSRF/XSS bawaan.',
    specs: [
      { label: 'RUNTIME', value: 'PHP 8.3 JIT' },
      { label: 'LATENCY', value: '< 8.5ms p99' },
      { label: 'PATTERN', value: 'Clean MVC' },
      { label: 'SECURITY', value: 'Strict Guard' }
    ]
  },
  tailwind: {
    id: 'tailwind',
    name: 'Tailwind v4',
    role: 'UI Design Tokens',
    category: 'CSS Styling Engine',
    color: '#06B6D4',
    rgb: '6,182,212',
    logo: '/images/tech_logos/tailwind.png',
    svg: '/images/tech/tailwindcss.svg',
    explanation: 'Mesin styling utility-first generasi terbaru yang dikompilasi langsung menggunakan Rust LightningCSS untuk ukuran bundel ultra-ringan.',
    rationale: 'Memberikan kontrol layout mikroskopis, adaptasi responsif tanpa scrollbar overflow, dan 0.00 Cumulative Layout Shift (CLS).',
    specs: [
      { label: 'ENGINE', value: 'Vite Rust Pass' },
      { label: 'BUNDLE', value: '14.2 KB Gzip' },
      { label: 'SHIFT', value: '0.00 CLS' },
      { label: 'PALETTE', value: 'Monochrome Jet' }
    ]
  },
  vite: {
    id: 'vite',
    name: 'Vite 5.x',
    role: '< 12ms HMR',
    category: 'Native ESM Toolchain',
    color: '#BD34FE',
    rgb: '189,52,254',
    logo: '/images/tech_logos/vite.png',
    svg: '/images/tech/vite.svg',
    explanation: 'Toolchain frontend berbasis native ES Modules yang memicu reload sub-milidetik dan pemecahan chunk JavaScript teroptimasi.',
    rationale: 'Menjamin feedback kode instan saat proses pairing dan pembuatan aset web modern tanpa overhead bundler konvensional.',
    specs: [
      { label: 'HMR SPEED', value: '< 12ms Hot' },
      { label: 'BUILD TIME', value: '1.14s Total' },
      { label: 'MODULES', value: 'ES2022 Native' },
      { label: 'TREE SHAKING', value: 'Rollup AST' }
    ]
  },
  debian: {
    id: 'debian',
    name: 'Debian 13',
    role: 'Baremetal Host',
    category: 'Operating System',
    color: '#D70A53',
    rgb: '215,10,83',
    logo: '/images/tech_logos/debian.png',
    svg: '/images/tech/debian.svg',
    explanation: 'Sistem operasi Linux mandiri (self-hosted) dengan kernel yang disetel khusus untuk throughput jaringan tinggi.',
    rationale: 'Menjamin server portofolio berjalan dengan latensi kernel minimal dan stabilitas 100% tanpa ketergantungan cloud pihak ketiga.',
    specs: [
      { label: 'CONGESTION', value: 'Google BBR' },
      { label: 'SOCKETS', value: 'Unix Domain' },
      { label: 'UPTIME', value: '100% Verified' },
      { label: 'ISOLATION', value: 'Systemd Slice' }
    ]
  },
  gsap: {
    id: 'gsap',
    name: 'GSAP 3',
    role: '60 FPS Motion',
    category: 'Kinetic Physics',
    color: '#88CE02',
    rgb: '136,206,2',
    logo: '/images/tech_logos/gsap.png',
    svg: '/images/tech/gsap.svg',
    explanation: 'Platform animasi performa tinggi berakselerasi GPU untuk mengorkestrasi transisi antarmuka yang sangat mulus tanpa frame drop.',
    rationale: 'Digunakan untuk kalkulasi physics lerp inersia, marquee dinamis, serta transisi modal tanpa stuttering.',
    specs: [
      { label: 'FPS TARGET', value: '60 - 120 FPS' },
      { label: 'ACCELERATION', value: 'Hardware GPU' },
      { label: 'JANK', value: 'Zero Dropped' },
      { label: 'PRECISION', value: 'Sub-Pixel' }
    ]
  },
  nginx: {
    id: 'nginx',
    name: 'Nginx 1.26',
    role: 'epoll() Proxy',
    category: 'Gateway Server',
    color: '#009639',
    rgb: '0,150,57',
    logo: '/images/tech_logos/nginx.png',
    svg: '/images/tech/nginx.svg',
    explanation: 'Reverse proxy asinkron event-driven yang menangani ribuan koneksi bersamaan dengan konsumsi RAM minimal.',
    rationale: 'Mengirimkan aset statis langsung via kernel sendfile() zero-copy dan terminasi TLS 1.3 berkecepatan tinggi.',
    specs: [
      { label: 'PROTOCOL', value: 'HTTP/2 + TLS1.3' },
      { label: 'TTFB', value: '< 1.2ms Edge' },
      { label: 'MODEL', value: 'Epoll Async' },
      { label: 'OFFLOAD', value: 'Zero-Copy' }
    ]
  },
  mariadb: {
    id: 'mariadb',
    name: 'MariaDB 11.8',
    role: 'ACID Persistence',
    category: 'Database Engine',
    color: '#00758F',
    rgb: '0,117,143',
    logo: '/images/tech_logos/mariadb.png',
    svg: '/images/tech/mariadb.svg',
    explanation: 'Penyimpanan relasional dengan jaminan transaksi ACID penuh, penguncian baris InnoDB/Aria, dan cache buffer efisien.',
    rationale: 'Menjamin keandalan data riwayat portofolio dan interaksi AI dengan waktu pencarian indeks B-Tree sub-milidetik.',
    specs: [
      { label: 'STORAGE', value: 'InnoDB ACID' },
      { label: 'LOOKUP', value: '< 0.22ms B-Tree' },
      { label: 'BUFFER', value: '98.7% Hit' },
      { label: 'SAFETY', value: 'Crash-Safe' }
    ]
  },
  mysql: {
    id: 'mysql',
    name: 'MySQL 8.4',
    role: 'ACID Storage',
    category: 'Database Engine',
    color: '#00758F',
    rgb: '0,117,143',
    logo: '/images/tech_logos/mariadb.png',
    svg: '/images/tech/mariadb.svg',
    explanation: 'Penyimpanan relasional dengan jaminan transaksi ACID penuh, penguncian baris InnoDB, dan cache buffer efisien.',
    rationale: 'Menjamin keandalan data riwayat portofolio dan interaksi AI dengan waktu pencarian indeks B-Tree sub-milidetik.',
    specs: [
      { label: 'STORAGE', value: 'InnoDB ACID' },
      { label: 'LOOKUP', value: '< 0.25ms B-Tree' },
      { label: 'BUFFER', value: '98.4% Hit' },
      { label: 'SAFETY', value: 'Crash-Safe' }
    ]
  },
  threejs: {
    id: 'threejs',
    name: 'Three.js',
    role: '3D WebGL Canvas',
    category: 'Spatial Graphics',
    color: '#FFFFFF',
    rgb: '255,255,255',
    logo: '/images/tech_logos/threejs.png',
    svg: '/images/tech/threejs.svg',
    explanation: 'Perpustakaan grafik 3D WebGL akselerasi GPU untuk merender model geometris dan simulasi topologi interaktif di browser.',
    rationale: 'Digunakan untuk kalkulasi koordinat spasial dan render geometri interaktif dengan konsumsi daya perangkat efisien.',
    specs: [
      { label: 'API', value: 'WebGL 2.0' },
      { label: 'SHADERS', value: 'GLSL Custom' },
      { label: 'FRAME BUDGET', value: '16.6ms' },
    ]
  }
};

// 2. Definisi 4 Kolom Vertikal Aliran Bebas (Staggered Speeds)
const FLOW_COLUMNS = [
  { id: 'left-outer',  position: 'left-[3%] lg:left-[2%]',       visibility: 'flex',          speed: 34, depth: 26,  offset: 0.00, items: ['laravel', 'gsap', 'debian', 'mysql'] },
  { id: 'left-inner',  position: 'left-[17%]',                    visibility: 'hidden xl:flex', speed: 22, depth: 14,  offset: 0.55, items: ['vite', 'threejs', 'tailwind', 'nginx'] },
  { id: 'right-inner', position: 'right-[17%]',                   visibility: 'hidden xl:flex', speed: 27, depth: -16, offset: 0.30, items: ['mysql', 'laravel', 'gsap', 'debian'] },
  { id: 'right-outer', position: 'right-[3%] lg:right-[2%]',     visibility: 'flex',          speed: 40, depth: -28, offset: 0.78, items: ['tailwind', 'vite', 'nginx', 'threejs'] },
];

// 3. Sub-Komponen Kolom Vertikal Mengalir
function FlowingColumn({ column, mouseX, onSelectTech }) {
  const columnRef = useRef(null);
  const [isPaused, setIsPaused] = useState(false);
  const [cardPositions, setCardPositions] = useState([]);
  
  // Parallax horizontal & tilt
  const tiltX = useTransform(mouseX, [-1, 1], [-column.depth, column.depth]);
  const tiltRot = useTransform(mouseX, [-1, 1], [-column.depth * 0.06, column.depth * 0.06]);

  const cards = column.items.map((k) => TECHNOLOGIES[k]);
  const progressRef = useRef(0);
  const factorRef = useRef(1);

  useEffect(() => {
    let animId;
    let lastTime = performance.now();
    const sectionH = 860;
    const cardH = 72;
    const loopH = Math.max(sectionH + cardH, cards.length * (cardH + 56));
    const spacing = loopH / cards.length;
    progressRef.current = column.offset * loopH;

    const tick = (now) => {
      const dt = Math.min((now - lastTime) / 1000, 0.05);
      lastTime = now;

      // Eased slowdown / pause on hover
      const targetFactor = isPaused ? 0 : 1;
      factorRef.current += (targetFactor - factorRef.current) * Math.min(1, dt * 6);
      progressRef.current += column.speed * factorRef.current * dt;

      const newPositions = cards.map((_, i) => {
        let y = (i * spacing - progressRef.current) % loopH;
        if (y < 0) y += loopH;
        return y + sectionH - loopH;
      });

      setCardPositions(newPositions);
      animId = requestAnimationFrame(tick);
    };

    animId = requestAnimationFrame(tick);
    return () => cancelAnimationFrame(animId);
  }, [isPaused, cards.length, column.speed, column.offset]);

  return (
    <motion.div
      ref={columnRef}
      style={{ x: tiltX, rotate: tiltRot }}
      className={`absolute top-0 bottom-0 ${column.position} ${column.visibility} w-14 lg:w-[188px] pointer-events-none will-change-transform`}
    >
      {cards.map((tech, i) => {
        const topY = cardPositions[i] ?? 0;
        return (
          <div
            key={`${column.id}-${tech.id}-${i}`}
            style={{ transform: `translate3d(0, ${topY}px, 0)` }}
            className="absolute left-0 top-0 w-full pointer-events-auto will-change-transform"
            onMouseEnter={() => setIsPaused(true)}
            onMouseLeave={() => setIsPaused(false)}
            onFocus={() => setIsPaused(true)}
            onBlur={() => setIsPaused(false)}
          >
            <button
              type="button"
              onClick={() => onSelectTech(tech)}
              aria-label={`Lihat detail teknologi ${tech.name}`}
              className="group w-full flex items-center justify-center lg:justify-start gap-3 p-2 lg:p-3 rounded-2xl bg-[#141414]/90 border border-[#1f1f1f] shadow-[0_15px_35px_rgba(0,0,0,0.6)] backdrop-blur-xl cursor-pointer transition-[transform,border-color,box-shadow,background-color] duration-300 hover:scale-[1.06] hover:bg-[#1a1a1a] focus:outline-none focus-visible:ring-2"
              onMouseEnter={(e) => {
                e.currentTarget.style.borderColor = tech.color;
                e.currentTarget.style.boxShadow = `0 0 32px rgba(${tech.rgb}, 0.35)`;
              }}
              onMouseLeave={(e) => {
                e.currentTarget.style.borderColor = '#1f1f1f';
                e.currentTarget.style.boxShadow = '0 15px 35px rgba(0,0,0,0.6)';
              }}
            >
              <span className="w-10 h-10 lg:w-11 lg:h-11 rounded-xl bg-[#0e0e0e] border border-[#1f1f1f] p-1.5 lg:p-2 flex items-center justify-center shrink-0 transition-all duration-300 group-hover:border-opacity-50" style={{ color: tech.color }}>
                {tech.logo ? (
                  <img src={tech.logo} alt={tech.name} className="w-6 h-6 lg:w-7 lg:h-7 object-contain drop-shadow-[0_2px_8px_rgba(0,0,0,0.7)] transition-transform duration-300 group-hover:scale-110" loading="lazy" />
                ) : (
                  tech.icon
                )}
              </span>
              <span className="hidden lg:block text-left min-w-0">
                <span className="flex items-center gap-1.5">
                  <span className="text-sm font-semibold text-[#f5f5f5] group-hover:text-white truncate">
                    {tech.name}
                  </span>
                  <span
                    className="w-1.5 h-1.5 rounded-full shrink-0"
                    style={{ backgroundColor: tech.color, boxShadow: `0 0 6px ${tech.color}` }}
                  />
                </span>
                <span className="text-[10px] font-mono text-[#878787] block mt-0.5 truncate">
                  {tech.role}
                </span>
              </span>
            </button>
          </div>
        );
      })}
    </motion.div>
  );
}

// 4. Komponen Utama Visual Playground
export default function VisualPlayground({ dribbbleUrl = 'https://dribbble.com' }) {
  const containerRef = useRef(null);
  const [selectedTech, setSelectedTech] = useState(null);
  const [modalState, setModalState] = useState('idle');

  // Mouse Parallax Lerp Spring
  const rawMouseX = useMotionValue(0);
  const smoothMouseX = useSpring(rawMouseX, { stiffness: 120, damping: 20, mass: 0.8 });

  const handleMouseMove = (e) => {
    if (!containerRef.current) return;
    const rect = containerRef.current.getBoundingClientRect();
    const nx = (e.clientX - (rect.left + rect.width / 2)) / (rect.width / 2);
    rawMouseX.set(Math.max(-1, Math.min(1, nx)));
  };

  const handleMouseLeave = () => {
    rawMouseX.set(0);
  };

  const handleOpenModal = (tech) => {
    setSelectedTech(tech);
    setModalState('loading');
    setTimeout(() => {
      setModalState('success');
    }, 120);
  };

  const handleCloseModal = () => {
    setSelectedTech(null);
    setModalState('idle');
  };

  useEffect(() => {
    const handleKeyDown = (e) => {
      if (e.key === 'Escape') handleCloseModal();
    };
    window.addEventListener('keydown', handleKeyDown);
    return () => window.removeEventListener('keydown', handleKeyDown);
  }, []);

  return (
    <section
      ref={containerRef}
      onMouseMove={handleMouseMove}
      onMouseLeave={handleMouseLeave}
      className="relative bg-[#0a0a0a] border-t border-[#1f1f1f]/50 overflow-hidden min-h-[820px] lg:min-h-[920px] flex items-center justify-center py-20 px-4 sm:px-8 select-none"
    >
      {/* 1. Subtle Radial Aura & Matrix Dots */}
      <div className="absolute inset-0 bg-[radial-gradient(#1f1f1f_1px,transparent_1px)] [background-size:32px_32px] opacity-35 pointer-events-none" />
      <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[500px] bg-white/5 rounded-full blur-[140px] pointer-events-none" />

      {/* 2. Optical Grid Axis Guides */}
      <div className="absolute inset-x-0 top-1/2 h-px bg-gradient-to-r from-transparent via-[#1f1f1f]/60 to-transparent pointer-events-none" />
      <div className="absolute inset-y-0 left-1/2 w-px bg-gradient-to-b from-transparent via-[#1f1f1f]/60 to-transparent pointer-events-none" />

      {/* 3. Infinite Vertical Flow Columns (Cards rise from bottom to top) */}
      <div className="absolute inset-0 w-full max-w-[1400px] mx-auto pointer-events-none [mask-image:linear-gradient(to_bottom,transparent_0%,#000_14%,#000_86%,transparent_100%)]">
        {FLOW_COLUMNS.map((col) => (
          <FlowingColumn
            key={col.id}
            column={col}
            mouseX={smoothMouseX}
            onSelectTech={handleOpenModal}
          />
        ))}
      </div>

      {/* 4. Center Typographic Anchor (Fixed / Static Center - Unobstructed) */}
      <div id="playground-center-anchor" className="relative z-20 max-w-md mx-auto text-center px-16 sm:px-20 lg:px-4">
        {/* Subtitle: EXPLORATIONS */}
        <motion.div
          initial={{ opacity: 0, y: 15 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
          className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#141414] border border-[#1f1f1f] text-[11px] font-mono text-[#878787] uppercase tracking-[0.3em] mb-4 shadow-lg"
        >
          <span className="w-1.5 h-1.5 rounded-full bg-white" />
          <span>EXPLORATIONS</span>
        </motion.div>

        {/* Main Headline: Bold Sans + Italic Serif */}
        <motion.h2
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.7, delay: 0.1 }}
          className="text-4xl sm:text-5xl md:text-6xl font-sans font-extrabold text-[#f5f5f5] tracking-tight leading-[1.1] mb-5"
        >
          TEKNOLOGI{' '}
          <span className="font-serif italic font-normal text-[#f5f5f5]">
            Pembuatan Web
          </span>
        </motion.h2>

        {/* Short Description */}
        <motion.p
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.7, delay: 0.2 }}
          className="text-xs sm:text-sm md:text-base text-[#878787] font-light leading-relaxed mb-8 max-w-md mx-auto"
        >
          Eksplorasi ekosistem teknologi modern yang menjadi fondasi arsitektur website ini, dirancang untuk kecepatan kompilasi kilat, animasi 60 FPS bebas jank, dan keandalan baremetal tingkat enterprise.
        </motion.p>

        {/* Action Buttons: Dribbble + Architecture RFC */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.7, delay: 0.3 }}
          className="flex flex-wrap items-center justify-center gap-3"
        >
          <a
            href={dribbbleUrl}
            target="_blank"
            rel="noopener noreferrer"
            className="group relative inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#141414] border border-[#1f1f1f] hover:border-[#EA4C89]/60 text-xs font-mono text-[#f5f5f5] transition-all duration-300 shadow-xl hover:shadow-[0_0_25px_rgba(234,76,137,0.25)] hover:scale-105"
          >
            <span>View on Dribbble</span>
            <span className="text-[#EA4C89] group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform duration-200">
              ↗
            </span>
          </a>

          <a
            href="#architecture"
            className="group inline-flex items-center gap-2 px-4 py-2.5 rounded-full text-xs font-mono text-[#878787] hover:text-[#f5f5f5] transition-colors"
          >
            <span>Architecture RFC</span>
            <span className="text-white group-hover:translate-x-1 transition-transform duration-200">
              →
            </span>
          </a>
        </motion.div>
      </div>

      {/* 5. Interactive Telemetry Modal (Four Boundary States) */}
      <AnimatePresence>
        {selectedTech && (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            onClick={handleCloseModal}
            className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md"
            role="dialog"
            aria-modal="true"
          >
            <motion.div
              initial={{ scale: 0.95, opacity: 0, y: 20 }}
              animate={{ scale: 1, opacity: 1, y: 0 }}
              exit={{ scale: 0.95, opacity: 0, y: 20 }}
              transition={{ type: 'spring', duration: 0.3 }}
              onClick={(e) => e.stopPropagation()}
              className="relative w-full max-w-2xl bg-[#141414] border border-[#1f1f1f] rounded-3xl shadow-[0_25px_70px_rgba(0,0,0,0.95)] p-6 sm:p-8 backdrop-blur-xl overflow-hidden"
            >
              {/* Dynamic Aura Glow */}
              <div
                className="absolute -top-24 -left-24 w-60 h-60 rounded-full blur-3xl opacity-20 pointer-events-none"
                style={{ backgroundColor: selectedTech.color }}
              />

              {/* State A: Loading Skeleton */}
              {modalState === 'loading' && (
                <div className="animate-pulse space-y-4">
                  <div className="flex items-center gap-4">
                    <div className="w-14 h-14 rounded-2xl bg-[#1f1f1f]" />
                    <div className="space-y-2 flex-1">
                      <div className="h-5 w-40 bg-[#1f1f1f]" />
                      <div className="h-3 w-28 bg-[#1f1f1f]" />
                    </div>
                  </div>
                  <div className="h-24 bg-[#1f1f1f] rounded-xl" />
                  <div className="h-24 bg-[#1f1f1f] rounded-xl" />
                </div>
              )}

              {/* State B: Error Boundary State */}
              {modalState === 'error' && (
                <div className="p-6 rounded-2xl bg-red-950/20 border border-red-800/40 text-center space-y-3 font-mono">
                  <p className="text-sm text-red-400">Gagal memuat telemetri spesifikasi teknologi.</p>
                  <button
                    type="button"
                    onClick={() => setModalState('loading')}
                    className="px-4 py-2 rounded-full bg-red-900/40 hover:bg-red-900/60 text-xs text-red-200 transition-colors border border-red-700/50"
                  >
                    Muat Ulang Telemetri
                  </button>
                </div>
              )}

              {/* State C: Success Content */}
              {modalState === 'success' && (
                <div className="relative z-10 space-y-6">
                  {/* Header */}
                  <div className="flex items-start justify-between pb-6 border-b border-[#1f1f1f]">
                    <div className="flex items-center gap-4">
                      <div
                        className="w-14 h-14 rounded-2xl bg-[#0a0a0a] border border-[#1f1f1f] p-3 flex items-center justify-center shrink-0 shadow-inner"
                        style={{ color: selectedTech.color, borderColor: `${selectedTech.color}40` }}
                      >
                        {selectedTech.logo ? (
                          <img src={selectedTech.logo} alt={selectedTech.name} className="w-8 h-8 object-contain drop-shadow-[0_2px_8px_rgba(0,0,0,0.8)]" />
                        ) : (
                          selectedTech.icon
                        )}
                      </div>
                      <div>
                        <div className="flex items-center gap-2.5 flex-wrap">
                          <h3 className="text-xl sm:text-2xl font-sans font-bold text-[#f5f5f5]">
                            {selectedTech.name}
                          </h3>
                          <span
                            className="text-[10px] font-mono px-2.5 py-0.5 rounded-full border"
                            style={{
                              borderColor: `${selectedTech.color}40`,
                              color: selectedTech.color,
                              backgroundColor: `rgba(${selectedTech.rgb}, 0.1)`
                            }}
                          >
                            [{selectedTech.category}]
                          </span>
                        </div>
                        <p className="text-xs font-mono text-[#878787] mt-1">
                          {selectedTech.role}
                        </p>
                      </div>
                    </div>

                    <button
                      type="button"
                      onClick={handleCloseModal}
                      aria-label="Tutup modal telemetri"
                      className="p-2 rounded-full bg-[#1a1a1a] hover:bg-[#262626] text-[#878787] hover:text-[#f5f5f5] border border-[#1f1f1f] transition-colors"
                    >
                      <svg className="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                      </svg>
                    </button>
                  </div>

                  {/* Explanation & Rationale */}
                  <div className="space-y-4 text-xs sm:text-sm text-[#a3a3a3] leading-relaxed">
                    <div>
                      <h4 className="text-[11px] font-mono text-[#878787] uppercase tracking-wider mb-1">
                        DESKRIPSI TEKNOLOGI
                      </h4>
                      <p>{selectedTech.explanation}</p>
                    </div>

                    <div>
                      <h4 className="text-[11px] font-mono text-[#878787] uppercase tracking-wider mb-1">
                        ALASAN PENGGUNAAN (RATIONALE)
                      </h4>
                      <p>{selectedTech.rationale}</p>
                    </div>
                  </div>

                  {/* Technical Specs Grid */}
                  <div>
                    <h4 className="text-[11px] font-mono text-[#878787] uppercase tracking-wider mb-2">
                      SPESIFIKASI ARSITEKTUR
                    </h4>
                    <div className="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                      {selectedTech.specs.map((spec, i) => (
                        <div
                          key={i}
                          className="p-2.5 rounded-xl bg-[#0a0a0a] border border-[#1f1f1f] flex flex-col justify-between"
                        >
                          <span className="text-[10px] text-[#878787] uppercase tracking-wider">
                            {spec.label}
                          </span>
                          <span className="text-xs font-semibold text-[#f5f5f5] mt-1 break-words">
                            {spec.value}
                          </span>
                        </div>
                      ))}
                    </div>
                  </div>

                  {/* Footer status */}
                  <div className="flex items-center justify-between pt-4 border-t border-[#1f1f1f] text-xs font-mono text-[#878787]">
                    <div className="flex items-center gap-2">
                      <span className="w-2 h-2 rounded-full bg-white" />
                      <span>Telemetri {selectedTech.name} aktif diperiksa</span>
                    </div>
                    <button
                      type="button"
                      onClick={handleCloseModal}
                      className="px-4 py-2 rounded-full bg-[#1a1a1a] hover:bg-[#262626] text-[#f5f5f5] border border-[#1f1f1f] transition-all"
                    >
                      Tutup
                    </button>
                  </div>
                </div>
              )}
            </motion.div>
          </motion.div>
        )}
      </AnimatePresence>
    </section>
  );
}
