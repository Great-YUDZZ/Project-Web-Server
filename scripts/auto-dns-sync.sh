#!/usr/bin/env bash
# ==============================================================================
# Script Otomatis Sinkronisasi DNS & mDNS - yuda.local
# Menyesuaikan secara otomatis ke IP WiFi / Hotspot / Tethering yang sedang aktif
# ==============================================================================

set -e

STATE_FILE="/var/run/yuda-dns.ip"
HOSTS_FILE="/etc/hosts"
LOG_TAG="yuda-dns-sync"

# Logging helper
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] [$LOG_TAG] $*"
    logger -t "$LOG_TAG" "$*" 2>/dev/null || true
}

# Fungsi deteksi IP utama yang aktif
get_current_ip() {
    local ip=""
    
    # 1. Coba deteksi via route default
    local def_dev
    def_dev=$(ip route get 1.1.1.1 2>/dev/null | awk '{for(i=1;i<=NF;i++) if($i=="dev") print $(i+1)}' | head -n1)
    if [ -n "$def_dev" ]; then
        ip=$(ip -4 -o addr show dev "$def_dev" 2>/dev/null | awk '{print $4}' | cut -d/ -f1 | head -n1)
    fi
    
    # 2. Coba deteksi via default route tabel routing
    if [ -z "$ip" ]; then
        local def_dev2
        def_dev2=$(ip route show default 2>/dev/null | awk '{print $5}' | head -n1)
        if [ -n "$def_dev2" ]; then
            ip=$(ip -4 -o addr show dev "$def_dev2" 2>/dev/null | awk '{print $4}' | cut -d/ -f1 | head -n1)
        fi
    fi
    
    # 3. Fallback hostname -I (ambil IP non-docker / non-virtual pertama)
    if [ -z "$ip" ]; then
        for candidate in $(hostname -I 2>/dev/null); do
            # Abaikan 127.*, docker 172.17.*, virbr 192.168.122.*
            if [[ ! "$candidate" =~ ^127\. ]] && [[ ! "$candidate" =~ ^172\.17\. ]] && [[ ! "$candidate" =~ ^192\.168\.122\. ]]; then
                ip="$candidate"
                break
            fi
        done
    fi

    # 4. Fallback absolut
    if [ -z "$ip" ]; then
        ip=$(hostname -I 2>/dev/null | awk '{print $1}')
    fi

    echo "$ip"
}

sync_dns() {
    local force_update=${1:-0}
    local current_ip
    current_ip=$(get_current_ip)

    if [ -z "$current_ip" ]; then
        log "Tidak ada antarmuka jaringan dengan IP IPv4 aktif saat ini."
        return 0
    fi

    local prev_ip=""
    if [ -f "$STATE_FILE" ]; then
        prev_ip=$(cat "$STATE_FILE" 2>/dev/null || true)
    fi

    if [ "$force_update" -eq 0 ] && [ "$current_ip" = "$prev_ip" ]; then
        # IP sama, tidak perlu update ulang
        return 0
    fi

    log "Perubahan IP terdeteksi: '${prev_ip:-none}' -> '${current_ip}'"

    # [1] Perbarui /etc/hosts (Bersihkan semua entri domain lain)
    if [ -f "$HOSTS_FILE" ]; then
        sed -i '/# Portofolio TKJ Yuda/d' "$HOSTS_FILE"
        sed -i '/# Interactive Solar System Engine/d' "$HOSTS_FILE"
        sed -i '/# Local DNS Mapping/d' "$HOSTS_FILE"
        sed -i '/yudz\.local/d' "$HOSTS_FILE"
        sed -i '/yudz\./d' "$HOSTS_FILE"
        sed -i '/yuda\.local/d' "$HOSTS_FILE"
        sed -i '/systemorbital/d' "$HOSTS_FILE"
        sed -i '/tatasurya/d' "$HOSTS_FILE"
        sed -i '/musik\./d' "$HOSTS_FILE"
        sed -i '/musik\.local/d' "$HOSTS_FILE"
        cat <<EOF >> "$HOSTS_FILE"
# Portofolio TKJ Yuda
127.0.0.1   yuda.local
${current_ip} yuda.local
EOF
        log "Berhasil memperbarui ${HOSTS_FILE} dengan IP: ${current_ip} (HANYA yuda.local)"
    fi

    # [2] Hapus hook dispatcher lama jika ada
    rm -f /etc/NetworkManager/dispatcher.d/99-sync-dns-ip.sh 2>/dev/null || true

    # [3] Bersihkan Virtual Host Nginx lama
    rm -f /etc/nginx/sites-enabled/web_tata_surya 2>/dev/null || true
    rm -f /etc/nginx/sites-enabled/portfolio 2>/dev/null || true
    rm -f /etc/nginx/sites-enabled/default 2>/dev/null || true

    # [4] Perbarui BIND9 DNS Server (jika terpasang)
    if [ -d "/etc/bind" ]; then
        # Bersihkan zona selain yuda.local
        if [ -f "/etc/bind/named.conf.local" ]; then
            sed -i '/zone "yudz.local"/,/};/d' /etc/bind/named.conf.local
            sed -i '/zone "systemorbital.local"/,/};/d' /etc/bind/named.conf.local
            sed -i '/zone "tatasurya.local"/,/};/d' /etc/bind/named.conf.local
            sed -i '/zone "musik.id"/,/};/d' /etc/bind/named.conf.local
            rm -f /etc/bind/db.systemorbital.local /etc/bind/db.tatasurya.local /etc/bind/db.musik.id 2>/dev/null || true

            if ! grep -q 'zone "yuda.local"' /etc/bind/named.conf.local; then
                cat <<EOF >> /etc/bind/named.conf.local

zone "yuda.local" {
    type master;
    file "/etc/bind/db.yuda.local";
};
EOF
            fi
        fi

        local serial
        serial=$(date +%s)
        cat <<EOF > /etc/bind/db.yuda.local
\$TTL    604800
@   IN  SOA yuda.local. root.yuda.local. (
                  ${serial} ; Serial
             604800         ; Refresh
              86400         ; Retry
            2419200         ; Expire
             604800 )       ; Negative Cache TTL

@   IN  NS  yuda.local.
@   IN  A   ${current_ip}
*   IN  A   ${current_ip}
EOF

        if [ -f "/etc/bind/named.conf.options" ] && ! grep -q 'allow-recursion' /etc/bind/named.conf.options; then
            cat <<EOF > /etc/bind/named.conf.options
options {
	directory "/var/cache/bind";
	listen-on port 53 { any; };
	listen-on-v6 port 53 { any; };
	allow-query { any; };
	allow-query-cache { any; };
	recursion yes;
	allow-recursion { any; };
	forwarders {
		8.8.8.8;
		1.1.1.1;
	};
	dnssec-validation no;
	auth-nxdomain no;
};
EOF
        fi

        named-checkconf /etc/bind/named.conf 2>/dev/null || true
        systemctl reload named 2>/dev/null || systemctl restart named 2>/dev/null || true
        log "Berhasil memperbarui zona BIND9 db.yuda.local -> ${current_ip} (HANYA yuda.local)"
    fi

    # [5] Perbarui Avahi mDNS Daemon (untuk iOS, MacOS, Linux)
    if [ -d "/etc/avahi" ]; then
        if [ -f "/etc/avahi/hosts" ]; then
            sed -i '/yudz\.local/d' /etc/avahi/hosts
            sed -i '/systemorbital/d' /etc/avahi/hosts
            sed -i '/tatasurya/d' /etc/avahi/hosts
            sed -i '/musik/d' /etc/avahi/hosts
            sed -i '/yuda\.local/d' /etc/avahi/hosts
            echo "${current_ip} yuda.local" >> /etc/avahi/hosts
        fi
        systemctl reload avahi-daemon 2>/dev/null || systemctl restart avahi-daemon 2>/dev/null || true
        log "Berhasil memperbarui Avahi mDNS -> ${current_ip}"
    fi

    # [6] Update IP pada helper scripts klien
    local proj_dir="/var/www/project_tkj_yuda2"
    if [ -f "${proj_dir}/public/dns.sh" ]; then
        sed -i "s/^SERVER_IP=.*/SERVER_IP=\"${current_ip}\"/" "${proj_dir}/public/dns.sh" 2>/dev/null || true
    fi
    if [ -f "${proj_dir}/public/dns.ps1" ]; then
        sed -i "s/^\$ServerIP =.*/\$ServerIP = \"${current_ip}\"/" "${proj_dir}/public/dns.ps1" 2>/dev/null || true
    fi

    # Simpan state IP terbaru
    echo "$current_ip" > "$STATE_FILE"
    log "Sinkronisasi DNS otomatis selesai. http://yuda.local siap diakses via ${current_ip}"
}

# Mode Daemon Watcher (Real-time monitoring via Netlink kernel events)
run_watch_mode() {
    log "Memulai layanan monitoring IP real-time (Kernel Netlink Watcher)..."
    
    # Lakukan sinkronisasi awal saat daemon start
    sync_dns 1 || true

    # Pantau perubahan alamat IP secara real-time
    ip monitor address 2>/dev/null | while read -r line; do
        # Tunggu 1 detik agar konfigurasi DHCP/NetworkManager stabil
        sleep 1
        sync_dns 0 || true
    done
}

# Parsing argument CLI
case "$1" in
    --watch|-w)
        run_watch_mode
        ;;
    --force|-f)
        sync_dns 1
        ;;
    *)
        sync_dns 0
        ;;
esac
