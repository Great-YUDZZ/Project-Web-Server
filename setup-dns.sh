#!/usr/bin/env bash
# ==============================================================================
# Script Konfigurasi Domain Lokal - Portofolio Siswa TKJ
# Domain Utama: http://yuda.local
# Server: Linux Debian 13 & Nginx
# ==============================================================================

set -e

PROJECT_DIR="/var/www/project_tkj_yuda2"
NGINX_CONF_SRC="${PROJECT_DIR}/nginx/project_tkj_yuda2.conf"
NGINX_CONF_DEST="/etc/nginx/sites-available/project_tkj_yuda2"
NGINX_CONF_ENABLED="/etc/nginx/sites-enabled/project_tkj_yuda2"
HOSTS_FILE="/etc/hosts"

# Pastikan dijalankan sebagai root / sudo
if [ "$EUID" -ne 0 ]; then
    echo "================================================================="
    echo " [PERHATIAN] Script ini memerlukan hak akses root/sudo untuk:"
    echo " 1. Memperbarui /etc/hosts"
    echo " 2. Menerapkan konfigurasi Nginx di /etc/nginx/"
    echo " 3. Memperbarui zona DNS BIND9 (jika aktif)"
    echo ""
    echo " Silakan jalankan dengan perintah:"
    echo "   sudo bash setup-dns.sh"
    echo "================================================================="
    exit 1
fi

echo "=== [1/4] Memeriksa IP Address Server ==="
LOCAL_IP=$(hostname -I | awk '{print $1}')
if [ -z "$LOCAL_IP" ]; then
    LOCAL_IP="10.10.22.34"
fi
GATEWAY=$(ip route | grep default | awk '{print $3}' | head -n 1)
if [ -z "$GATEWAY" ]; then
    GATEWAY="10.10.18.1"
fi
DEF_DEV=$(ip route | grep default | awk '{print $5}' | head -n 1)
PREFIX="21"
if [ -n "$DEF_DEV" ]; then
    DETECTED_PREFIX=$(ip -4 -o addr show dev "$DEF_DEV" 2>/dev/null | awk '{print $4}' | cut -d/ -f2 | head -n 1 || true)
    if [ -n "$DETECTED_PREFIX" ]; then
        PREFIX="$DETECTED_PREFIX"
    fi
fi
echo "IP Lokal Terdeteksi: ${LOCAL_IP}"
echo "Gateway Jaringan   : ${GATEWAY}"
echo "Panjang Subnet     : /${PREFIX}"
echo "Hostname Mesin     : $(hostname)"

echo ""
echo "=== [2/4] Mengonfigurasi Local Mapping di ${HOSTS_FILE} ==="
if [ ! -f "${HOSTS_FILE}.bak" ]; then
    cp "${HOSTS_FILE}" "${HOSTS_FILE}.bak"
    echo "Backup ${HOSTS_FILE} dibuat di ${HOSTS_FILE}.bak"
fi

# Bersihkan entri lama agar rapi (hilangkan yudz.local dan variannya)
sed -i '/# Portofolio TKJ Yuda/d' "${HOSTS_FILE}"
sed -i '/yudz\.local/d' "${HOSTS_FILE}"
sed -i '/yudz\./d' "${HOSTS_FILE}"
sed -i '/yudzz\./d' "${HOSTS_FILE}"
sed -i '/yuda\.local/d' "${HOSTS_FILE}"
sed -i '/portofolio\./d' "${HOSTS_FILE}"

# Tambahkan entri yuda.local
cat <<EOF >> "${HOSTS_FILE}"
# Portofolio TKJ Yuda
127.0.0.1   yuda.local
${LOCAL_IP} yuda.local
EOF

echo "Domain berhasil dipetakan di ${HOSTS_FILE}:"
grep -A 2 "# Portofolio TKJ Yuda" "${HOSTS_FILE}"

# Konfigurasi BIND9 DNS Server jika terpasang di sistem
if [ -d "/etc/bind" ]; then
    echo ""
    echo "=== Mengonfigurasi BIND9 DNS Server (${LOCAL_IP}) ==="

    # Bersihkan zona yudz.local lama jika ada
    if [ -f "/etc/bind/named.conf.local" ]; then
        sed -i '/zone "yudz.local"/,/};/d' /etc/bind/named.conf.local
        rm -f /etc/bind/db.yudz.local
    fi

    # Buat file database zona yuda.local
    cat <<EOF > /etc/bind/db.yuda.local
\$TTL    604800
@   IN  SOA yuda.local. root.yuda.local. (
                  1         ; Serial
             604800         ; Refresh
              86400         ; Retry
            2419200         ; Expire
             604800 )       ; Negative Cache TTL

@   IN  NS  yuda.local.
@   IN  A   ${LOCAL_IP}
*   IN  A   ${LOCAL_IP}
EOF

    # Daftarkan zona yuda.local ke named.conf.local
    if [ -f "/etc/bind/named.conf.local" ] && ! grep -q 'zone "yuda.local"' /etc/bind/named.conf.local; then
        cat <<EOF >> /etc/bind/named.conf.local

zone "yuda.local" {
    type master;
    file "/etc/bind/db.yuda.local";
};
EOF
    fi

    if [ -f "/etc/bind/named.conf.options" ]; then
        cat <<EOF > /etc/bind/named.conf.options
options {
	directory "/var/cache/bind";
	forwarders {
		8.8.8.8;
		1.1.1.1;
	};
	allow-query { any; };
	dnssec-validation no;
};
EOF
    fi

    named-checkconf /etc/bind/named.conf || true
    systemctl restart named || true
    echo "BIND9 DNS server berhasil aktif untuk domain yuda.local"
fi

# Konfigurasi Avahi Daemon (mDNS / Bonjour untuk iPhone, Mac, dan Linux)
if [ -d "/etc/avahi" ]; then
    echo ""
    echo "=== Mengonfigurasi Avahi mDNS Daemon (${LOCAL_IP}) ==="
    if [ -f "/etc/avahi/avahi-daemon.conf" ]; then
        sed -i 's/^#*host-name=.*/host-name=yuda/' /etc/avahi/avahi-daemon.conf
        if ! grep -q '^host-name=yuda' /etc/avahi/avahi-daemon.conf; then
            sed -i '/\[server\]/a host-name=yuda' /etc/avahi/avahi-daemon.conf
        fi
    fi
    if [ -f "/etc/avahi/hosts" ]; then
        sed -i '/yudz\.local/d' /etc/avahi/hosts
        sed -i '/yuda\.local/d' /etc/avahi/hosts
        echo "${LOCAL_IP} yuda.local" >> /etc/avahi/hosts
    fi
    systemctl restart avahi-daemon || true
    echo "Avahi mDNS berhasil aktif untuk domain yuda.local"
fi

echo ""
echo "=== [3/4] Menerapkan Konfigurasi Virtual Host Nginx ==="
rm -f /etc/nginx/sites-enabled/default
rm -f /etc/nginx/sites-enabled/portfolio

cp "${NGINX_CONF_SRC}" "${NGINX_CONF_DEST}"
ln -sf "${NGINX_CONF_DEST}" "${NGINX_CONF_ENABLED}"

# Pastikan permission storage & cache benar untuk web server
chmod -R 775 "${PROJECT_DIR}/storage" "${PROJECT_DIR}/bootstrap/cache"
chown -R www-data:www-data "${PROJECT_DIR}/storage" "${PROJECT_DIR}/bootstrap/cache"

# Bersihkan cache view dan config Laravel
su -s /bin/bash -c "cd ${PROJECT_DIR} && php artisan view:clear && php artisan config:clear" yudz || true

echo "Menguji sintaks konfigurasi Nginx..."
nginx -t

echo "Memuat ulang layanan Nginx..."
systemctl reload nginx

echo ""
echo "=== [4/4] Verifikasi Akses HTTP via http://yuda.local ==="
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" -H "Host: yuda.local" http://127.0.0.1/ || true)
SITE_TITLE=$(curl -s -H "Host: yuda.local" http://127.0.0.1/ | grep -o "<title>[^<]*" | head -n 1 | sed 's/<title>//' || true)

echo "Respon HTTP Host 'yuda.local': ${HTTP_CODE}"
echo "Judul Halaman Web            : ${SITE_TITLE}"

echo ""
echo "================================================================="
echo "  PANDUAN LENGKAP AKSES MULTIPLATFORM (http://yuda.local):"
echo "================================================================="
echo ""
echo " METODE 1: AKSES DARI HP ANDROID (DI JARINGAN SAAT INI)"
echo " Agar HP Android bisa membuka http://yuda.local:"
echo ""
echo " [Langkah A] Matikan DNS Pribadi (Wajib):"
echo "   - Buka Pengaturan HP -> Koneksi / Jaringan -> DNS Pribadi (Private DNS)"
echo "   - Ubah setelan menjadi 'Nonaktif' (Off)"
echo "   (PENTING: Jika tidak dinonaktifkan, Android mengabaikan DNS lokal)"
echo ""
echo " [Langkah B] Atur Setelan IP WiFi HP ke Statik:"
echo "   - Buka Pengaturan WiFi -> Ketuk ikon gerigi/nama WiFi yang terhubung"
echo "   - Ubah Setelan IP dari 'DHCP' ke 'Statik'"
echo "   - Masukkan konfigurasi berikut:"
echo "     * IP Address            : 10.10.22.210 (atau IP HP Anda)"
echo "     * Gateway / Router      : ${GATEWAY}"
echo "     * Panjang Awalan Subnet : ${PREFIX}"
echo "     * DNS 1                 : ${LOCAL_IP}"
echo "     * DNS 2                 : 8.8.8.8"
echo "   - Simpan pengaturan WiFi"
echo ""
echo " [Langkah C] Buka Browser HP:"
echo "   👉 http://yuda.local"
echo ""
echo " ---------------------------------------------------------------"
echo " METODE 2: AKSES DARI iPHONE (iOS) / MAC / LINUX"
echo "   Perangkat Apple & Linux langsung mendukung mDNS lokal."
echo "   Cukup buka Safari / Chrome dan ketik langsung:"
echo "   👉 http://yuda.local"
echo ""
echo " ---------------------------------------------------------------"
echo " METODE 3: HOTSPOT LAPTOP (CARA PALING OTOMATIS & ANTI-RIBET)"
echo " Jika penguji/guru ingin HP langsung bisa buka http://yuda.local"
echo " tanpa menyetel DNS statik di HP:"
echo " 1. Buat Hotspot dari laptop:"
echo "    sudo nmcli dev wifi hotspot ifname ${DEF_DEV:-wlp2s0} ssid 'Lab-TKJ-Yuda' password 'yuda12345'"
echo " 2. Hubungkan HP ke WiFi 'Lab-TKJ-Yuda'"
echo " 3. Buka browser di HP dan ketik: http://yuda.local"
echo "================================================================="

