#!/usr/bin/env bash
# ==============================================================================
# Installer Layanan Auto-DNS yuda.local
# Mengintegrasikan NetworkManager Dispatcher + Systemd Real-time Kernel Watcher
# ==============================================================================

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
SYNC_SRC="${SCRIPT_DIR}/auto-dns-sync.sh"
SYNC_BIN="/usr/local/bin/yuda-dns-sync"
NM_DISPATCHER="/etc/NetworkManager/dispatcher.d/99-yuda-dns.sh"
SYSTEMD_SERVICE="/etc/systemd/system/yuda-dns-autoupdate.service"

if [ "$EUID" -ne 0 ]; then
    echo "[PERINGATAN] Silakan jalankan script installer ini dengan sudo:"
    echo "  sudo bash $0"
    exit 1
fi

echo "=================================================================="
echo "  MEMASANG SISTEM OTOMATISASI DNS DINAMIS (http://yuda.local)"
echo "=================================================================="

# 1. Pasang binary yuda-dns-sync ke /usr/local/bin
echo "[1/4] Memasang engine sinkronisasi ke ${SYNC_BIN}..."
cp -f "${SYNC_SRC}" "${SYNC_BIN}"
chmod 755 "${SYNC_BIN}"

# 2. Pasang hook NetworkManager Dispatcher
if [ -d "/etc/NetworkManager/dispatcher.d" ]; then
    echo "[2/4] Memasang hook NetworkManager Dispatcher..."
    cat << 'EOF' > "${NM_DISPATCHER}"
#!/bin/sh
# Hook NetworkManager untuk pembaruan instan DNS yuda.local saat connect WiFi
case "$2" in
    up|dhcp4-change|dhcp6-change|connectivity-change)
        /usr/local/bin/yuda-dns-sync || true
        ;;
esac
EOF
    chmod 755 "${NM_DISPATCHER}"
    echo "      Hook aktif di ${NM_DISPATCHER}"
else
    echo "[2/4] Direktori NetworkManager dispatcher tidak ditemukan, melewati hook NM."
fi

# 3. Pasang Systemd Daemon Watcher (Real-time Netlink Kernel Monitor)
echo "[3/4] Mendaftarkan systemd service '${SYSTEMD_SERVICE}'..."
cat << EOF > "${SYSTEMD_SERVICE}"
[Unit]
Description=Yuda Local DNS Automatic IP Sync Daemon
After=network.target network-online.target
Wants=network-online.target

[Service]
Type=simple
ExecStart=/usr/local/bin/yuda-dns-sync --watch
Restart=always
RestartSec=5
StandardOutput=journal
StandardError=journal

[Install]
WantedBy=multi-user.target
EOF

systemctl daemon-reload
systemctl enable yuda-dns-autoupdate.service
systemctl restart yuda-dns-autoupdate.service
echo "      Service 'yuda-dns-autoupdate.service' berhasil diaktifkan dan berjalan."

# 4. Jalankan sinkronisasi perdana
echo "[4/4] Menjalankan sinkronisasi IP saat ini..."
"${SYNC_BIN}" --force

echo ""
echo "=================================================================="
echo "  SUKSES! AUTO-DNS TELAH AKTIF SECARA PERMANEN!"
echo "=================================================================="
echo " Kini laptop Anda akan OTOMATIS menyesuaikan domain 'yuda.local'"
echo " setiap kali:"
echo "  1. Terhubung ke WiFi baru (sekolah, rumah, kampus, cafe)"
echo "  2. Berpindah ke Hotspot HP / USB Tethering"
echo "  3. Terjadi perubahan IP DHCP dari router"
echo ""
echo " Anda TIDAK PERLU lagi menjalankan setup-dns.sh manual!"
echo " Cek status layanan kapan saja dengan:"
echo "   systemctl status yuda-dns-autoupdate.service"
echo "=================================================================="
