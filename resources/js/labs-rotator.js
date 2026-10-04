import gsap from 'gsap';

/**
 * Modul Rotator Sorotan Lab & Proyek Unggulan (#labs)
 * Mengatur pergantian proyek sorotan secara dinamis dengan animasi transisi halus,
 * rotasi otomatis terukur (progress bar), serta kendali manual interaktif.
 */
export const initLabsRotator = () => {
    const rotatorContainer = document.getElementById('labs-spotlight-rotator');
    const dataScript = document.getElementById('featured-projects-data');

    if (!rotatorContainer || !dataScript) return;

    let projects = [];
    try {
        projects = JSON.parse(dataScript.textContent);
    } catch (e) {
        console.error('Gagal mengurai data proyek unggulan:', e);
        return;
    }

    if (!Array.isArray(projects) || projects.length <= 1) {
        // Jika hanya ada 1 proyek atau data kosong, tidak perlu rotasi otomatis
        return;
    }

    // Elemen DOM Sorotan Utama
    const stageEl = document.getElementById('spotlight-stage');
    const imgEl = document.getElementById('spotlight-img');
    const titleEl = document.getElementById('spotlight-title');
    const categoryEl = document.getElementById('spotlight-category');
    const dateEl = document.getElementById('spotlight-date');
    const descEl = document.getElementById('spotlight-desc');
    const tagsContainer = document.getElementById('spotlight-tags');
    const linkSpec = document.getElementById('spotlight-link-spec');
    const linkDemo = document.getElementById('spotlight-link-demo');
    const numEl = document.getElementById('spotlight-num');
    const timerBar = document.getElementById('spotlight-timer-bar');

    // Tombol Kendali Navigasi
    const prevBtn = document.getElementById('spotlight-prev-btn');
    const nextBtn = document.getElementById('spotlight-next-btn');
    const pauseBtn = document.getElementById('spotlight-pause-btn');
    const pauseIcon = document.getElementById('spotlight-pause-icon');
    const playIcon = document.getElementById('spotlight-play-icon');
    const statusText = document.getElementById('spotlight-status-text');

    // Kartu Antrean Proyek
    const queueCards = document.querySelectorAll('[data-spotlight-index]');

    // Status Rotator
    let currentIndex = 0;
    const duration = 7000; // 7 detik per putaran
    const intervalTick = 50; // pembaruan progress bar setiap 50ms
    let elapsed = 0;
    let isPaused = false;
    let isHovered = false;
    let timerInterval = null;
    let isAnimating = false;

    // Fungsi Format Nomor (misal: 1 -> "01")
    const formatNumber = (num) => String(num).padStart(2, '0');

    // Perbarui Tampilan Proyek Aktif dengan Animasi GSAP
    const updateSpotlight = (newIndex, direction = 1) => {
        if (newIndex === currentIndex && timerInterval) return;
        if (isAnimating) return;

        isAnimating = true;
        const targetProject = projects[newIndex];
        if (!targetProject) {
            isAnimating = false;
            return;
        }

        // 1. Animasi Keluar Elemen Saat Ini
        const animatedTargets = [imgEl, titleEl, descEl, tagsContainer].filter(Boolean);
        const yOffsetOut = direction > 0 ? -12 : 12;
        const yOffsetIn = direction > 0 ? 14 : -14;

        gsap.to(animatedTargets, {
            opacity: 0,
            y: yOffsetOut,
            scale: 0.98,
            duration: 0.22,
            ease: 'power2.in',
            onComplete: () => {
                // 2. Modifikasi Data DOM
                currentIndex = newIndex;

                if (numEl) numEl.textContent = formatNumber(currentIndex + 1);
                if (titleEl) {
                    titleEl.textContent = targetProject.title;
                    titleEl.setAttribute('href', targetProject.url);
                }
                if (categoryEl) categoryEl.textContent = targetProject.category;
                if (dateEl) dateEl.textContent = targetProject.date || '';
                if (descEl) descEl.textContent = targetProject.description;
                if (linkSpec) linkSpec.setAttribute('href', targetProject.url);

                if (linkDemo) {
                    if (targetProject.demo_link) {
                        linkDemo.setAttribute('href', targetProject.demo_link);
                        linkDemo.classList.remove('hidden');
                    } else {
                        linkDemo.classList.add('hidden');
                    }
                }

                // Ganti Gambar
                if (imgEl) {
                    imgEl.src = targetProject.image_url;
                    imgEl.alt = targetProject.title;
                }

                // Perbarui Tag Alat / Teknologi
                if (tagsContainer) {
                    tagsContainer.innerHTML = '';
                    if (Array.isArray(targetProject.tools_list)) {
                        targetProject.tools_list.slice(0, 6).forEach((tag) => {
                            const badge = document.createElement('span');
                            badge.className = 'badge-earth-brown text-xs font-mono font-semibold';
                            badge.textContent = tag;
                            tagsContainer.appendChild(badge);
                        });
                    }
                }

                // Perbarui Status Visual Kartu Antrean
                queueCards.forEach((card) => {
                    const cardIndex = parseInt(card.getAttribute('data-spotlight-index'), 10);
                    const isCardActive = cardIndex === currentIndex;

                    if (isCardActive) {
                        card.classList.add('queue-item-active');
                        card.setAttribute('aria-current', 'true');
                    } else {
                        card.classList.remove('queue-item-active');
                        card.removeAttribute('aria-current');
                    }
                });

                // 3. Animasi Masuk Elemen Baru
                gsap.fromTo(animatedTargets, 
                    { opacity: 0, y: yOffsetIn, scale: 0.99 },
                    {
                        opacity: 1,
                        y: 0,
                        scale: 1,
                        duration: 0.36,
                        ease: 'power2.out',
                        stagger: 0.04,
                        onComplete: () => {
                            isAnimating = false;
                        }
                    }
                );
            }
        });

        // Reset hitungan waktu (progress bar)
        elapsed = 0;
        if (timerBar) {
            timerBar.style.width = '0%';
        }
    };

    // Navigasi ke Proyek Berikutnya
    const nextProject = () => {
        const nextIdx = (currentIndex + 1) % projects.length;
        updateSpotlight(nextIdx, 1);
    };

    // Navigasi ke Proyek Sebelumnya
    const prevProject = () => {
        const prevIdx = (currentIndex - 1 + projects.length) % projects.length;
        updateSpotlight(prevIdx, -1);
    };

    // Siklus Detik Timer Kemajuan
    const startTimer = () => {
        if (timerInterval) clearInterval(timerInterval);
        timerInterval = setInterval(() => {
            if (!isPaused && !isHovered && !isAnimating) {
                elapsed += intervalTick;
                const percent = Math.min((elapsed / duration) * 100, 100);
                if (timerBar) {
                    timerBar.style.width = `${percent}%`;
                }

                if (elapsed >= duration) {
                    elapsed = 0;
                    nextProject();
                }
            }
        }, intervalTick);
    };

    // Tombol Jeda / Lanjutkan Rotasi
    const togglePause = () => {
        isPaused = !isPaused;
        if (isPaused) {
            if (pauseIcon) pauseIcon.classList.add('hidden');
            if (playIcon) playIcon.classList.remove('hidden');
            if (statusText) statusText.textContent = 'Rotasi Dijeda';
            if (pauseBtn) pauseBtn.setAttribute('title', 'Lanjutkan rotasi otomatis');
        } else {
            if (pauseIcon) pauseIcon.classList.remove('hidden');
            if (playIcon) playIcon.classList.add('hidden');
            if (statusText) statusText.textContent = 'Rotasi Otomatis Aktif';
            if (pauseBtn) pauseBtn.setAttribute('title', 'Jeda rotasi otomatis');
        }
    };

    // Hubungkan Event Listener Tombol Navigasi
    if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            nextProject();
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
            e.preventDefault();
            prevProject();
        });
    }

    if (pauseBtn) {
        pauseBtn.addEventListener('click', (e) => {
            e.preventDefault();
            togglePause();
        });
    }

    // Klik pada Kartu Antrean
    queueCards.forEach((card) => {
        card.addEventListener('click', (e) => {
            const index = parseInt(card.getAttribute('data-spotlight-index'), 10);
            if (!isNaN(index) && index !== currentIndex) {
                const dir = index > currentIndex ? 1 : -1;
                updateSpotlight(index, dir);
            }
        });
    });

    // Jeda otomatis ketika kursor diarahkan ke dalam kontainer
    rotatorContainer.addEventListener('mouseenter', () => {
        isHovered = true;
    });

    rotatorContainer.addEventListener('mouseleave', () => {
        isHovered = false;
    });

    // Dukungan Navigasi Keyboard (Panah Kiri / Kanan ketika kontainer aktif)
    rotatorContainer.setAttribute('tabindex', '0');
    rotatorContainer.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight') {
            e.preventDefault();
            nextProject();
        } else if (e.key === 'ArrowLeft') {
            e.preventDefault();
            prevProject();
        }
    });

    // Inisialisasi awal timer
    startTimer();
};
