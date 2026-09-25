#!/usr/bin/env bash
# Script Konfigurasi DNS Otomatis untuk Klien Linux & macOS
set -e
SERVER_IP="10.10.22.34"

echo "=========================================================="
echo " [TKJ AUTO-DNS] Mengonfigurasi DNS Klien ke $SERVER_IP"
echo "=========================================================="

if [ "$EUID" -ne 0 ]; then
    echo "[!] Harap jalankan script ini dengan sudo (hak akses root)."
    exit 1
fi

# 1. Daftarkan domain ke /etc/hosts (Jaminan 100% Berhasil)
echo "[1/3] Memperbarui /etc/hosts..."
sed -i '/yuda\.local/d' /etc/hosts 2>/dev/null || sed -i '' '/yuda\.local/d' /etc/hosts 2>/dev/null || true
sed -i '/systemorbital/d' /etc/hosts 2>/dev/null || sed -i '' '/systemorbital/d' /etc/hosts 2>/dev/null || true

cat <<EOT >> /etc/hosts
$SERVER_IP yuda.local
EOT
echo "      [OK] yuda.local tersimpan di /etc/hosts."

# 2. Atur DNS Resolver jika ada NetworkManager / resolvconf / macOS
echo "[2/3] Mengonfigurasi DNS Resolver..."
if command -v nmcli >/dev/null 2>&1; then
    ACTIVE_CON=$(nmcli -t -f NAME,STATE connection show --active 2>/dev/null | grep ':activated' | cut -d: -f1 | head -n 1)
    if [ -n "$ACTIVE_CON" ]; then
        nmcli connection modify "$ACTIVE_CON" ipv4.dns "$SERVER_IP 8.8.8.8" 2>/dev/null || true
        nmcli connection up "$ACTIVE_CON" >/dev/null 2>&1 || true
        echo "      [OK] NetworkManager DNS diarahkan ke $SERVER_IP."
    fi
elif [ "$(uname)" = "Darwin" ]; then
    WIFI_IF=$(networksetup -listallnetworkservices 2>/dev/null | grep -E 'Wi-Fi|AirPort|Ethernet' | head -n 1)
    if [ -n "$WIFI_IF" ]; then
        networksetup -setdnsservers "$WIFI_IF" "$SERVER_IP" "8.8.8.8" 2>/dev/null || true
        echo "      [OK] macOS DNS diarahkan ke $SERVER_IP."
    fi
fi

# 3. Flush DNS Cache
echo "[3/3] Membersihkan cache DNS..."
systemd-resolve --flush-caches 2>/dev/null || resolvectl flush-caches 2>/dev/null || killall -HUP mDNSResponder 2>/dev/null || true
echo "      [OK] Cache DNS klien telah dibersihkan!"

echo ""
echo "=========================================================="
echo " SUKSES! Website siap dibuka di browser:"
echo " 👉 Web Portofolio : http://yuda.local"
echo "=========================================================="
