#!/bin/bash
set -euo pipefail

# ==============================================================================
# Script Bantuan Instalasi Aman aaPanel Control Panel Hosting
# Project: Portofolio TKJ - Server & Web Hosting Control Center
# ==============================================================================

if [ "$(id -u)" -ne 0 ]; then
  echo "Error: Skrip ini wajib dijalankan dengan hak akses root/sudo." >&2
  echo "Contoh: sudo bash scripts/install-aapanel-safe.sh" >&2
  exit 1
fi

echo "=========================================================="
echo "  Pemeriksaan Prasyarat & Instalasi aaPanel (Debian/Ubuntu)"
echo "=========================================================="

# 1. Cek port 7800 dan 8888
echo "[1/4] Memeriksa ketersediaan port panel (7800 / 8888)..."
if ss -tulpn | grep -Eq ':(7800|8888)\b'; then
  echo "Peringatan: Port 7800 atau 8888 sudah digunakan oleh proses lain:"
  ss -tulpn | grep -E ':(7800|8888)\b'
  read -p "Tetap lanjutkan instalasi? (y/N): " -r CONFIRM
  if [[ ! "$CONFIRM" =~ ^[Yy]$ ]]; then
    echo "Instalasi dibatalkan."
    exit 0
  fi
else
  echo "Port 7800 dan 8888 bebas dan siap digunakan."
fi

# 2. Cek paket prasyarat
echo "[2/4] Memeriksa paket pendukung (curl, wget, python3)..."
apt-get update -y -qq
apt-get install -y -qq curl wget python3 python3-pip

# 3. Download dan jalankan installer aaPanel resmi
echo "[3/4] Mengunduh skrip instalasi aaPanel standalone..."
INSTALL_TMP="/tmp/aapanel_install.sh"
wget -O "$INSTALL_TMP" http://www.aapanel.com/script/install-ubuntu_6.0_en.sh || \
curl -sSO http://www.aapanel.com/script/install-ubuntu_6.0_en.sh

chmod +x "$INSTALL_TMP"

echo "----------------------------------------------------------"
echo "Menjalankan instalasi core aaPanel..."
echo "Catatan: Jangan menimpa Nginx di port 80 jika diminta."
echo "----------------------------------------------------------"

export INSTALL_FORCE="true"
bash "$INSTALL_TMP" -y -P 7800

# 4. Update hosting-ctl sudoers
echo "[4/4] Memperbarui izin sudoers hosting-ctl untuk fitur suspend website..."
if [ -f "/var/www/project_tkj_yuda2/scripts/install-hosting-ctl.sh" ]; then
  bash /var/www/project_tkj_yuda2/scripts/install-hosting-ctl.sh
fi

echo "=========================================================="
echo "  Instalasi Selesai!"
echo "=========================================================="
echo "Langkah selanjutnya untuk menghubungkan aaPanel ke Web Admin:"
echo "1. Buka URL login aaPanel yang ditampilkan di atas pada browser."
echo "2. Masuk ke menu 'Settings' -> aktifkan 'API'."
echo "3. Salin API-Secret (API-SK) dan tambahkan IP '127.0.0.1' ke IP Whitelist."
echo "4. Masukkan konfigurasi ke berkas /var/www/project_tkj_yuda2/.env:"
echo "     AAPANEL_ENABLED=true"
echo "     AAPANEL_BASE_URL=http://127.0.0.1:7800 (atau port yang tertera)"
echo "     AAPANEL_API_SK=<api_secret_key_anda>"
echo "5. Buka tab 'Domains & VHosts' di /admin/hosting untuk mengontrol website!"
echo "=========================================================="
