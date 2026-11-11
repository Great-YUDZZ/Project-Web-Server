#!/bin/bash
set -euo pipefail

if [ "$(id -u)" -ne 0 ]; then
  echo "Jalankan dengan sudo: sudo bash scripts/install-hosting-ctl.sh" >&2
  exit 1
fi

CTL_DEST="/usr/local/sbin/hosting-ctl"
SUDOERS_DEST="/etc/sudoers.d/www-data-hosting"

cat > "$CTL_DEST" <<'CTL'
#!/bin/bash
set -euo pipefail

BIND_DIR="/etc/bind"
CONF_LOCAL="/etc/bind/named.conf.local"
NGINX_AVAIL="/etc/nginx/sites-available"
PRIMARY_VHOST="/etc/nginx/sites-available/project_tkj_yuda2"

die() {
  echo "$1" >&2
  exit 1
}

valid_domain() {
  local d="$1"
  if [ "${#d}" -gt 253 ] || [ "${#d}" -lt 4 ]; then return 1; fi
  if ! printf '%s' "$d" | grep -Eq '^[a-z0-9]([a-z0-9.-]*[a-z0-9])?$'; then return 1; fi
  if ! printf '%s' "$d" | grep -q '\.'; then return 1; fi
  return 0
}

server_ip() {
  local ip=""
  ip="$(hostname -I 2>/dev/null | awk '{print $1}')"
  if [ -z "$ip" ]; then ip="127.0.0.1"; fi
  printf '%s' "$ip"
}

bind_reload() {
  named-checkconf "$CONF_LOCAL" >/dev/null 2>&1 || named-checkconf >/dev/null 2>&1 || die "named-checkconf gagal"
  if command -v rndc >/dev/null 2>&1; then
    rndc reload >/dev/null 2>&1 || systemctl reload named >/dev/null 2>&1 || true
  else
    systemctl reload named >/dev/null 2>&1 || systemctl restart named >/dev/null 2>&1 || die "gagal reload named"
  fi
}

bump_serial() {
  local zonefile="$1"
  local serial
  serial="$(date +%s)"
  if grep -q '; Serial' "$zonefile"; then
    sed -i -E "s/[0-9]{10}[[:space:]]+; Serial/${serial} ; Serial/" "$zonefile" || true
  fi
}

cmd_service() {
  local id="${1:-}"
  local action="${2:-}"
  local unit=""
  case "$id" in
    nginx) unit="nginx" ;;
    php-fpm) unit="php8.4-fpm" ;;
    mariadb) unit="mariadb" ;;
    named) unit="named" ;;
    avahi-daemon) unit="avahi-daemon" ;;
    ssh) unit="ssh" ;;
    *) die "service tidak ada di allowlist" ;;
  esac
  case "$action" in
    start|stop|restart|reload) ;;
    *) die "action tidak valid" ;;
  esac
  systemctl "$action" "$unit"
  echo "Service $id ($unit) $action berhasil."
}

cmd_sinkhole_add() {
  local domain="${1:-}"
  local ip="${2:-}"
  local srv_ip
  srv_ip="$(server_ip)"
  valid_domain "$domain" || die "domain tidak valid"
  if [ "$domain" = "yuda.local" ] || [ "$domain" = "localhost" ]; then
    die "domain terlindungi, tidak boleh di-sinkhole"
  fi
  case "$ip" in
    0.0.0.0|127.0.0.1) ;;
    "$srv_ip") ;;
    *) die "target ip tidak diizinkan" ;;
  esac
  if printf '%s' "$domain" | grep -Eq '^[a-z0-9-]+\.yuda\.local$'; then
    local label
    label="$(printf '%s' "$domain" | cut -d. -f1)"
    local parentfile="$BIND_DIR/db.yuda.local"
    [ -f "$parentfile" ] || die "zona parent yuda.local tidak ditemukan"
    cp -a "$parentfile" "$parentfile.bak.$(date +%s)"
    local esc_label
    esc_label="$(printf '%s' "$label" | sed 's/[][\.*^$/]/\\&/g')"
    grep -v -E "^${esc_label}[[:space:]]+IN[[:space:]]+A[[:space:]]+" "$parentfile" > "$parentfile.tmp" || true
    mv "$parentfile.tmp" "$parentfile"
    printf '%s 300 IN A %s\n' "$label" "$ip" >> "$parentfile"
    chmod 644 "$parentfile"
    bump_serial "$parentfile"
    named-checkzone "yuda.local" "$parentfile" >/dev/null 2>&1 || die "named-checkzone yuda.local gagal"
    bind_reload
    echo "Suspend $domain via record parent yuda.local -> $ip aktif."
    return 0
  fi
  if printf '%s' "$domain" | grep -Eq '^[a-z0-9-]+\.great-yuda\.my\.id$'; then
    local label2
    label2="$(printf '%s' "$domain" | cut -d. -f1)"
    local parentfile2="$BIND_DIR/db.great-yuda.my.id"
    [ -f "$parentfile2" ] || die "zona parent great-yuda.my.id tidak ditemukan"
    cp -a "$parentfile2" "$parentfile2.bak.$(date +%s)"
    local esc_label2
    esc_label2="$(printf '%s' "$label2" | sed 's/[][\.*^$/]/\\&/g')"
    grep -v -E "^${esc_label2}[[:space:]]+IN[[:space:]]+A[[:space:]]+" "$parentfile2" > "$parentfile2.tmp" || true
    mv "$parentfile2.tmp" "$parentfile2"
    printf '%s 300 IN A %s\n' "$label2" "$ip" >> "$parentfile2"
    chmod 644 "$parentfile2"
    bump_serial "$parentfile2"
    named-checkzone "great-yuda.my.id" "$parentfile2" >/dev/null 2>&1 || die "named-checkzone great-yuda.my.id gagal"
    bind_reload
    echo "Suspend $domain via record parent great-yuda.my.id -> $ip aktif."
    return 0
  fi
  local zonefile="$BIND_DIR/db.$domain"
  local serial
  serial="$(date +%s)"
  if [ -f "$zonefile" ]; then
    if [ ! -f "$zonefile.suspended.bak" ]; then cp -a "$zonefile" "$zonefile.suspended.bak"; fi
    cp -a "$zonefile" "$zonefile.bak.$(date +%s)"
  fi
  cat > "$zonefile" <<ZONE
\$TTL 300
@ IN SOA $domain. root.$domain. (
    $serial ; Serial
    3600 ; Refresh
    600 ; Retry
    86400 ; Expire
    300 ) ; Negative Cache TTL
@ IN NS $domain.
@ IN A $ip
* IN A $ip
ZONE
  chmod 644 "$zonefile"
  touch "$CONF_LOCAL"
  if ! grep -q "zone \"$domain\"" "$CONF_LOCAL"; then
    printf '\nzone "%s" {\n    type master;\n    file "/etc/bind/db.%s";\n};\n' "$domain" "$domain" >> "$CONF_LOCAL"
  fi
  named-checkconf "$CONF_LOCAL" >/dev/null 2>&1 || { named-checkconf >/dev/null 2>&1 || die "named-checkconf gagal"; }
  named-checkzone "$domain" "$zonefile" >/dev/null 2>&1 || die "named-checkzone gagal"
  bind_reload
  echo "Sinkhole $domain -> $ip aktif."
}

cmd_sinkhole_remove() {
  local domain="${1:-}"
  valid_domain "$domain" || die "domain tidak valid"
  if printf '%s' "$domain" | grep -Eq '^[a-z0-9-]+\.yuda\.local$'; then
    local label
    label="$(printf '%s' "$domain" | cut -d. -f1)"
    local parentfile="$BIND_DIR/db.yuda.local"
    [ -f "$parentfile" ] || die "zona parent yuda.local tidak ditemukan"
    cp -a "$parentfile" "$parentfile.bak.$(date +%s)"
    local esc_label
    esc_label="$(printf '%s' "$label" | sed 's/[][\.*^$/]/\\&/g')"
    grep -v -E "^${esc_label}[[:space:]]+IN[[:space:]]+A[[:space:]]+" "$parentfile" > "$parentfile.tmp" || true
    mv "$parentfile.tmp" "$parentfile"
    chmod 644 "$parentfile"
    bump_serial "$parentfile"
    named-checkzone "yuda.local" "$parentfile" >/dev/null 2>&1 || die "named-checkzone yuda.local gagal"
    bind_reload
    echo "Unsuspend $domain via record parent yuda.local berhasil."
    return 0
  fi
  if printf '%s' "$domain" | grep -Eq '^[a-z0-9-]+\.great-yuda\.my\.id$'; then
    local label2
    label2="$(printf '%s' "$domain" | cut -d. -f1)"
    local parentfile2="$BIND_DIR/db.great-yuda.my.id"
    [ -f "$parentfile2" ] || die "zona parent great-yuda.my.id tidak ditemukan"
    cp -a "$parentfile2" "$parentfile2.bak.$(date +%s)"
    local esc_label2
    esc_label2="$(printf '%s' "$label2" | sed 's/[][\.*^$/]/\\&/g')"
    grep -v -E "^${esc_label2}[[:space:]]+IN[[:space:]]+A[[:space:]]+" "$parentfile2" > "$parentfile2.tmp" || true
    mv "$parentfile2.tmp" "$parentfile2"
    chmod 644 "$parentfile2"
    bump_serial "$parentfile2"
    named-checkzone "great-yuda.my.id" "$parentfile2" >/dev/null 2>&1 || die "named-checkzone great-yuda.my.id gagal"
    bind_reload
    echo "Unsuspend $domain via record parent great-yuda.my.id berhasil."
    return 0
  fi
  local zonefile="$BIND_DIR/db.$domain"
  if [ -f "$zonefile.suspended.bak" ]; then
    mv "$zonefile.suspended.bak" "$zonefile"
    chmod 644 "$zonefile"
    if [ -f "$CONF_LOCAL" ]; then
      if ! grep -q "zone \"$domain\"" "$CONF_LOCAL"; then
        printf '\nzone "%s" {\n    type master;\n    file "/etc/bind/db.%s";\n};\n' "$domain" "$domain" >> "$CONF_LOCAL"
      fi
    fi
    named-checkzone "$domain" "$zonefile" >/dev/null 2>&1 || die "named-checkzone gagal saat restore"
    bind_reload
    echo "Unsuspend $domain berhasil, zona asli dikembalikan."
    return 0
  fi
  if [ -f "$zonefile" ]; then mv "$zonefile" "$zonefile.bak.$(date +%s)"; fi
  if [ -f "$CONF_LOCAL" ]; then
    awk -v dom="$domain" '
      BEGIN { skip=0 }
      index($0, "zone \"" dom "\"") { skip=1; next }
      skip && /};/ { skip=0; next }
      !skip { print }
    ' "$CONF_LOCAL" > "$CONF_LOCAL.tmp"
    mv "$CONF_LOCAL.tmp" "$CONF_LOCAL"
    chmod 644 "$CONF_LOCAL"
  fi
  bind_reload
  echo "Sinkhole $domain dihapus."
}

cmd_dns_set() {
  local zone="${1:-}"
  local name="${2:-}"
  local type="${3:-}"
  local content="${4:-}"
  local ttl="${5:-3600}"
  case "$zone" in
    yuda.local|great-yuda.my.id) ;;
    *) die "zona tidak diizinkan" ;;
  esac
  case "$type" in
    A|CNAME) ;;
    *) die "tipe record tidak diizinkan" ;;
  esac
  if [ "$name" != "@" ]; then
    printf '%s' "$name" | grep -Eq '^[a-z0-9-]{1,63}$' || die "nama record tidak valid"
  fi
  if [ "$type" = "A" ]; then
    printf '%s' "$content" | grep -Eq '^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$' || die "content A harus IP"
  else
    valid_domain "${content%.}" || die "content CNAME harus domain"
  fi
  printf '%s' "$ttl" | grep -Eq '^[0-9]+$' || die "ttl tidak valid"
  local zonefile="$BIND_DIR/db.$zone"
  [ -f "$zonefile" ] || die "zone file tidak ditemukan"
  cp -a "$zonefile" "$zonefile.bak.$(date +%s)"
  local esc_name
  esc_name="$(printf '%s' "$name" | sed 's/[][\.*^$/]/\\&/g')"
  grep -v -E "^${esc_name}[[:space:]]+IN[[:space:]]+${type}[[:space:]]+" "$zonefile" > "$zonefile.tmp" || true
  mv "$zonefile.tmp" "$zonefile"
  printf '%s %s IN %s %s\n' "$name" "$ttl" "$type" "$content" >> "$zonefile"
  chmod 644 "$zonefile"
  bump_serial "$zonefile"
  named-checkzone "$zone" "$zonefile" >/dev/null 2>&1 || die "named-checkzone gagal, record dibatalkan"
  bind_reload
  echo "Record $name $type $content disimpan di $zone."
}

cmd_dns_del() {
  local zone="${1:-}"
  local name="${2:-}"
  local type="${3:-}"
  case "$zone" in
    yuda.local|great-yuda.my.id) ;;
    *) die "zona tidak diizinkan" ;;
  esac
  case "$type" in
    A|CNAME) ;;
    *) die "tipe record tidak diizinkan" ;;
  esac
  local zonefile="$BIND_DIR/db.$zone"
  [ -f "$zonefile" ] || die "zone file tidak ditemukan"
  cp -a "$zonefile" "$zonefile.bak.$(date +%s)"
  local esc_name
  esc_name="$(printf '%s' "$name" | sed 's/[][\.*^$/]/\\&/g')"
  grep -v -E "^${esc_name}[[:space:]]+IN[[:space:]]+${type}[[:space:]]+" "$zonefile" > "$zonefile.tmp" || true
  mv "$zonefile.tmp" "$zonefile"
  chmod 644 "$zonefile"
  bump_serial "$zonefile"
  named-checkzone "$zone" "$zonefile" >/dev/null 2>&1 || die "named-checkzone gagal"
  bind_reload
  echo "Record $name $type di $zone dihapus."
}

cmd_nginx_save() {
  local src="${1:-}"
  [ -f "$src" ] || die "file temp tidak ditemukan"
  grep -q "server_name" "$src" || die "config harus mengandung server_name"
  local bak="$PRIMARY_VHOST.bak.$(date +%s)"
  cp -a "$PRIMARY_VHOST" "$bak" 2>/dev/null || die "tidak bisa backup vhost asli"
  cp "$src" "$PRIMARY_VHOST.tmp"
  chmod 644 "$PRIMARY_VHOST.tmp"
  mv "$PRIMARY_VHOST.tmp" "$PRIMARY_VHOST"
  if ! nginx -t >/dev/null 2>&1; then
    mv "$bak" "$PRIMARY_VHOST"
    die "nginx -t gagal, config dikembalikan"
  fi
  systemctl reload nginx
  echo "Nginx disimpan dan reload. Backup: $bak"
}

cmd_ufw_enable() {
  command -v ufw >/dev/null 2>&1 || die "ufw tidak terinstall"
  ufw --force enable >/dev/null 2>&1 || ufw enable >/dev/null 2>&1 || die "gagal enable ufw"
  echo "UFW enabled."
}

cmd_ufw_disable() {
  command -v ufw >/dev/null 2>&1 || die "ufw tidak terinstall"
  ufw disable >/dev/null 2>&1 || die "gagal disable ufw"
  echo "UFW disabled."
}

cmd_ufw_rule() {
  local port="${1:-}"
  local proto="${2:-}"
  local act="${3:-}"
  local src="${4:-}"
  local desc="${5:-}"
  command -v ufw >/dev/null 2>&1 || die "ufw tidak terinstall"
  printf '%s' "$port" | grep -Eq '^[0-9]{1,5}(:[0-9]{1,5})?$' || die "port tidak valid"
  case "$proto" in tcp|udp) ;; *) die "protokol tidak valid" ;; esac
  case "$act" in allow|deny|limit) ;; *) die "action tidak valid" ;; esac
  if [ "$src" != "0.0.0.0/0" ]; then
    printf '%s' "$src" | grep -Eq '^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+(/[0-9]+)?$' || die "source tidak valid"
  fi
  ufw "$act" from "$src" to any port "$port" proto "$proto" comment "$desc" >/dev/null 2>&1 || die "gagal menambah aturan ufw"
  echo "Aturan $act port $port/$proto ditambahkan."
}

cmd_ufw_del() {
  local port="${1:-}"
  local proto="${2:-}"
  command -v ufw >/dev/null 2>&1 || die "ufw tidak terinstall"
  printf '%s' "$port" | grep -Eq '^[0-9]{1,5}(:[0-9]{1,5})?$' || die "port tidak valid"
  case "$proto" in tcp|udp) ;; *) die "protokol tidak valid" ;; esac
  local num
  num="$(ufw status numbered 2>/dev/null | grep -E "[\[] *[0-9]+[\]]" | grep -F "$port" | head -n 1 | sed -E 's/.*\[([0-9]+)\].*/\1/' || true)"
  if [ -z "$num" ]; then die "aturan port $port tidak ditemukan"; fi
  echo "y" | ufw delete "$num" >/dev/null 2>&1 || die "gagal menghapus aturan ufw"
  echo "Aturan port $port dihapus."
}

is_protected_vhost() {
  local target="$1"
  case "$target" in
    yuda_local|yuda.local|localhost|127.0.0.1) return 0 ;;
  esac
  return 1
}

find_vhost_file() {
  local target="$1"
  if [ -f "$NGINX_AVAIL/$target" ]; then
    printf '%s' "$NGINX_AVAIL/$target"
    return 0
  fi
  local f=""
  for f in "$NGINX_AVAIL"/*; do
    [ -f "$f" ] || continue
    case "$f" in *.bak) continue ;; esac
    if grep -Eq "server_name\s+[^;]*\b${target}\b" "$f"; then
      printf '%s' "$f"
      return 0
    fi
  done
  for f in "$NGINX_AVAIL"/*.live.bak; do
    [ -f "$f" ] || continue
    local orig="${f%.live.bak}"
    if grep -Eq "server_name\s+[^;]*\b${target}\b" "$f"; then
      printf '%s' "$orig"
      return 0
    fi
  done
  return 1
}

cmd_vhost_suspend() {
  local target="${1:-}"
  [ -n "$target" ] || die "domain atau vhost name harus diisi"
  if is_protected_vhost "$target"; then
    die "domain $target dilindungi dan tidak boleh disuspend"
  fi
  local vfile
  vfile="$(find_vhost_file "$target" || true)"
  [ -n "$vfile" ] || die "vhost untuk $target tidak ditemukan di $NGINX_AVAIL"

  local vname
  vname="$(basename "$vfile")"
  if is_protected_vhost "$vname"; then
    die "vhost $vname dilindungi dan tidak boleh disuspend"
  fi

  local bak="${vfile}.live.bak"
  if [ -f "$bak" ]; then
    echo "vhost $vname sudah dalam status suspend."
    return 0
  fi

  local sn
  sn="$(grep -E '^\s*server_name\s+' "$vfile" | head -n 1 | sed -E 's/^\s*server_name\s+//; s/;.*//' || true)"
  if [ -z "$sn" ]; then
    sn="$target"
  fi

  cp -p "$vfile" "$bak"
  cat > "$vfile" <<NGX
# Auto-generated by hosting-ctl: vhost suspended
server {
    listen 80;
    listen [::]:80;
    server_name $sn;
    root /var/www/project_tkj_yuda2/public/maintenance;

    location / {
        return 503;
    }

    error_page 503 /suspended.html;
    location = /suspended.html {
        root /var/www/project_tkj_yuda2/public/maintenance;
        internal;
    }
}
NGX

  if [ ! -e "/etc/nginx/sites-enabled/$vname" ]; then
    ln -sf "$vfile" "/etc/nginx/sites-enabled/$vname"
  fi

  if ! nginx -t >/dev/null 2>&1; then
    cp -p "$bak" "$vfile"
    rm -f "$bak"
    die "nginx -t gagal saat suspend, konfigurasi dikembalikan"
  fi

  systemctl reload nginx || nginx -s reload || true
  echo "vhost $vname ($sn) berhasil disuspend (HTTP 503)."
}

cmd_vhost_unsuspend() {
  local target="${1:-}"
  [ -n "$target" ] || die "domain atau vhost name harus diisi"
  local vfile
  vfile="$(find_vhost_file "$target" || true)"
  [ -n "$vfile" ] || die "vhost untuk $target tidak ditemukan di $NGINX_AVAIL"

  local vname
  vname="$(basename "$vfile")"
  local bak="${vfile}.live.bak"

  if [ ! -f "$bak" ]; then
    echo "vhost $vname tidak dalam status suspend."
    return 0
  fi

  cp -p "$bak" "$vfile"
  if ! nginx -t >/dev/null 2>&1; then
    die "nginx -t gagal saat restore vhost $vname"
  fi

  rm -f "$bak"
  systemctl reload nginx || nginx -s reload || true
  echo "vhost $vname berhasil dihidupkan kembali (Active)."
}

cmd_vhost_status() {
  local target="${1:-}"
  [ -n "$target" ] || die "domain atau vhost name harus diisi"
  local vfile
  vfile="$(find_vhost_file "$target" || true)"
  [ -n "$vfile" ] || die "vhost untuk $target tidak ditemukan di $NGINX_AVAIL"

  local bak="${vfile}.live.bak"
  if [ -f "$bak" ]; then
    echo "suspended"
  else
    echo "active"
  fi
}

main() {
  local sub="${1:-}"
  case "$sub" in
    service) cmd_service "${2:-}" "${3:-}" ;;
    sinkhole)
      case "${2:-}" in
        add) cmd_sinkhole_add "${3:-}" "${4:-}" ;;
        remove) cmd_sinkhole_remove "${3:-}" ;;
        *) die "sinkhole action tidak valid" ;;
      esac
      ;;
    dns)
      case "${2:-}" in
        set) cmd_dns_set "${3:-}" "${4:-}" "${5:-}" "${6:-}" "${7:-}" ;;
        del) cmd_dns_del "${3:-}" "${4:-}" "${5:-}" ;;
        *) die "dns action tidak valid" ;;
      esac
      ;;
    nginx)
      case "${2:-}" in
        save) cmd_nginx_save "${3:-}" ;;
        *) die "nginx action tidak valid" ;;
      esac
      ;;
    ufw)
      case "${2:-}" in
        enable) cmd_ufw_enable ;;
        disable) cmd_ufw_disable ;;
        rule) cmd_ufw_rule "${3:-}" "${4:-}" "${5:-}" "${6:-}" "${7:-}" ;;
        del) cmd_ufw_del "${3:-}" "${4:-}" ;;
        *) die "ufw action tidak valid" ;;
      esac
      ;;
    vhost)
      case "${2:-}" in
        suspend) cmd_vhost_suspend "${3:-}" ;;
        unsuspend) cmd_vhost_unsuspend "${3:-}" ;;
        status) cmd_vhost_status "${3:-}" ;;
        *) die "vhost action tidak valid (gunakan suspend/unsuspend/status)" ;;
      esac
      ;;
    *) die "subcommand tidak dikenal" ;;
  esac
}

main "$@"
CTL

chmod 755 "$CTL_DEST"
chown root:www-data "$CTL_DEST" 2>/dev/null || chown root:root "$CTL_DEST"

cat > "$SUDOERS_DEST" <<SUD
www-data, yudz ALL=(root) NOPASSWD: /usr/local/sbin/hosting-ctl service *, /usr/local/sbin/hosting-ctl sinkhole *, /usr/local/sbin/hosting-ctl dns *, /usr/local/sbin/hosting-ctl nginx *, /usr/local/sbin/hosting-ctl ufw *, /usr/local/sbin/hosting-ctl vhost *
SUD

chmod 440 "$SUDOERS_DEST"
if ! visudo -cf "$SUDOERS_DEST"; then
  echo "visudo gagal, sudoers dibatalkan" >&2
  rm -f "$SUDOERS_DEST"
  exit 1
fi

echo "Terinstall: $CTL_DEST dan $SUDOERS_DEST"
echo "Verifikasi: sudo -u www-data sudo -n $CTL_DEST service nginx reload"
echo "Catatan: reload nginx untuk uji, restart hanya jika perlu."
