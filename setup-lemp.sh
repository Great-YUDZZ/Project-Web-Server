#!/usr/bin/env bash
# ==============================================================================
# Setup & Deployment Script - Website Portofolio Siswa TKJ
# Stack: LEMP (Linux Debian/Ubuntu, Nginx, MariaDB, PHP 8.4-FPM, Laravel 12)
# ==============================================================================

set -e

PROJECT_DIR="/var/www/project_tkj_yuda2"
NGINX_CONF_SRC="${PROJECT_DIR}/nginx/project_tkj_yuda2.conf"
NGINX_CONF_DEST="/etc/nginx/sites-available/project_tkj_yuda2"
NGINX_CONF_ENABLED="/etc/nginx/sites-enabled/project_tkj_yuda2"

echo "=== [1/5] Memeriksa Direktori & Environment ==="
cd "$PROJECT_DIR"
if [ ! -f .env ]; then
    echo "Menyalin .env.example ke .env..."
    cp .env.example .env
    php artisan key:generate
fi

echo "=== [2/5] Menyiapkan Permission Storage & Cache ==="
chmod -R 775 storage bootstrap/cache
if [ "$EUID" -eq 0 ]; then
    chown -R www-data:www-data storage bootstrap/cache
fi

echo "=== [3/5] Menghubungkan Storage Symlink ==="
php artisan storage:link || true

echo "=== [4/5] Kompilasi Aset Frontend Vite (Tailwind CSS v4) ==="
npm run build

echo "=== [5/5] Migrasi Database & Seeding Data Awal ==="
php artisan migrate --force

echo ""
echo "================================================================="
echo "  Setup Berhasil! Kredensial Admin Awal:"
echo "  URL Login: http://localhost:8000/login (atau domain Nginx)"
echo "  Email    : admin@tkj.lan"
echo "  Password : AdminTKJ2026!"
echo "================================================================="
echo "Untuk mengaktifkan Nginx Virtual Host & DNS Domain Lokal (yuda.local):"
echo "  sudo bash setup-dns.sh"
echo ""
echo "Atau secara manual:"
echo "  sudo cp ${NGINX_CONF_SRC} ${NGINX_CONF_DEST}"
echo "  sudo ln -sf ${NGINX_CONF_DEST} ${NGINX_CONF_ENABLED}"
echo "  sudo nginx -t"
echo "  sudo systemctl reload nginx"
echo "================================================================="
