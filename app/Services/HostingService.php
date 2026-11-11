<?php

namespace App\Services;

use App\Models\HostingAudit;
use App\Models\HostingCronJob;
use App\Models\HostingSinkhole;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Symfony\Component\Process\Process;

class HostingService
{
    public const ACTIONS = ['start', 'stop', 'restart', 'reload'];

    public function __construct(
        private readonly ServerMonitorService $monitor,
        private readonly AaPanelApiService $aapanel
    ) {}

    public function getOverview(): array
    {
        return Cache::remember('hosting_overview', 3, fn () => $this->buildOverview());
    }

    public function bustOverviewCache(): void
    {
        Cache::forget('hosting_overview');
    }

    private function buildOverview(): array
    {
        $metrics = $this->monitor->getAllMetrics();

        return [
            'server' => $this->serverSummary($metrics),
            'summary' => [
                'sslProtectedDomains' => 0,
                'totalDbRows' => $this->totalDbRows(),
            ],
            'domains' => $this->domains(),
            'aapanel' => $this->aapanel->getStatus(),
            'aapanelUrl' => $this->aapanel->getPanelUrl(),
            'dnsRecords' => $this->dnsRecords(),
            'sinkholes' => HostingSinkhole::query()->orderByDesc('created_at')->get()->toArray(),
            'services' => $this->services(),
            'databases' => $this->databases(),
            'firewall' => $this->firewall(),
            'cronJobs' => HostingCronJob::query()->orderByDesc('created_at')->get()->toArray(),
            'nginx' => $this->nginxInfo(),
            'activityLogs' => $this->activityLogs(),
        ];
    }

    private function serverSummary(array $metrics): array
    {
        $distro = 'Debian 13 (Trixie)';
        if (is_readable('/etc/os-release')) {
            $os = @file_get_contents('/etc/os-release') ?: '';
            if (preg_match('/^PRETTY_NAME="([^"]+)"/m', $os, $m)) {
                $distro = $m[1];
            }
        }

        $diskTotalGb = (float) (($metrics['system']['disk']['total_formatted'] ?? '0 GB') ? $this->parseGb($metrics['system']['disk']['total_formatted']) : 0);
        $diskUsedGb = $this->parseGb($metrics['system']['disk']['used_formatted'] ?? '0 GB');

        return [
            'distro' => $distro,
            'kernel' => $metrics['host']['kernel'] ?? php_uname('r'),
            'hostname' => $metrics['host']['hostname'] ?? gethostname(),
            'sharedIp' => $this->serverIp(),
            'cpuCores' => $metrics['system']['cpu']['cores'] ?? 1,
            'cpuLoadPercent' => $metrics['system']['cpu']['percent'] ?? 0,
            'loadAvg' => [
                $metrics['system']['cpu']['load_1m'] ?? 0,
                $metrics['system']['cpu']['load_5m'] ?? 0,
                $metrics['system']['cpu']['load_15m'] ?? 0,
            ],
            'memory' => [
                'totalMb' => $metrics['system']['ram']['total_mb'] ?? 0,
                'usedMb' => $metrics['system']['ram']['used_mb'] ?? 0,
                'percent' => $metrics['system']['ram']['percent'] ?? 0,
            ],
            'disks' => [[
                'mount' => '/',
                'fs' => 'nvme/ext4',
                'sizeGb' => $diskTotalGb,
                'usedGb' => $diskUsedGb,
                'usePercent' => $metrics['system']['disk']['percent'] ?? 0,
            ]],
            'network' => $metrics['system']['network'] ?? [
                'rx_formatted' => '0 B/s',
                'tx_formatted' => '0 B/s',
                'total_formatted' => '0 B/s',
                'total_kbps' => 0,
            ],
            'uptimeSeconds' => $metrics['system']['uptime']['seconds'] ?? 0,
        ];
    }

    private function serverIp(): string
    {
        $ip = @trim(@shell_exec('hostname -I 2>/dev/null') ?: '');
        $first = explode(' ', $ip)[0] ?? '';

        return $first ?: (gethostbyname(gethostname()) ?: '127.0.0.1');
    }

    private function parseGb(string $formatted): float
    {
        if (preg_match('/([\d.]+)\s*(GB|MB|TB)/', $formatted, $m)) {
            $v = (float) $m[1];

            return match (strtoupper($m[2])) {
                'MB' => round($v / 1024, 2),
                'TB' => round($v * 1024, 2),
                default => $v,
            };
        }

        return 0.0;
    }

    public function domains(): array
    {
        $dir = (string) config('hosting.nginx_sites_available');
        $out = [];
        $sinkholeMap = HostingSinkhole::query()->pluck('target_ip', 'domain')->all();

        if (is_dir($dir)) {
            foreach (@glob(rtrim($dir, '/').'/*') ?: [] as $file) {
                if (! is_file($file) || is_link($file)) {
                    continue;
                }
                $name = basename($file);
                if ($name === 'default' || str_ends_with($name, '.bak') || str_ends_with($name, '.tmp')) {
                    continue;
                }

                $bakFile = $file . '.live.bak';
                $isBakSuspended = file_exists($bakFile);

                // Jika disuspend, server_name diambil dari file backup jika ada
                $content = @file_get_contents($isBakSuspended ? $bakFile : $file) ?: (@file_get_contents($file) ?: '');
                $serverName = '';
                if (preg_match('/server_name\s+([^;]+);/', $content, $m)) {
                    $serverName = trim($m[1]);
                }
                $root = '';
                if (preg_match('/root\s+([^;]+);/', $content, $m)) {
                    $root = trim($m[1]);
                }
                $primary = strtok($serverName, " \t") ?: $name;
                $aliases = array_values(array_filter(array_map('trim', explode(' ', $serverName))));
                $aliases = array_values(array_diff($aliases, [$primary, '_']));

                $isSinkhole = isset($sinkholeMap[strtolower($primary)]);
                $suspended = $isBakSuspended || $isSinkhole;

                $canSuspend = ! $this->isProtectedVhost($primary, $name);

                $out[] = [
                    'id' => $name,
                    'domain' => $primary,
                    'aliases' => $aliases,
                    'type' => str_contains($content, 'fastcgi_pass') ? 'php_fastcgi' : 'static',
                    'root' => $root,
                    'target' => $root ?: '—',
                    'port' => 80,
                    'status' => $suspended ? 'suspended' : 'active',
                    'suspended' => $suspended,
                    'sinkholeIp' => $sinkholeMap[strtolower($primary)] ?? null,
                    'canSuspend' => $canSuspend,
                    'sslEnabled' => false,
                    'sslProvider' => 'HTTP only (Nginx :80)',
                    'configPath' => $file,
                    'engine' => 'nginx',
                ];
            }
        }

        if (empty($out)) {
            $out = $this->fallbackDomain();
        }

        // Integrasikan daftar website dari aaPanel (jika aaPanel aktif & terhubung)
        $aaSites = $this->aapanel->getSites();
        if (! empty($aaSites)) {
            $out = array_merge($out, $aaSites);
        }

        return $out;
    }

    private function fallbackDomain(): array
    {
        return [[
            'id' => 'project_tkj_yuda2',
            'domain' => 'great-yuda.my.id',
            'aliases' => ['www.great-yuda.my.id', 'yuda.local'],
            'type' => 'php_fastcgi',
            'root' => '/var/www/project_tkj_yuda2/public',
            'target' => '/var/www/project_tkj_yuda2/public',
            'port' => 80,
            'status' => 'active',
            'suspended' => false,
            'canSuspend' => false,
            'sinkholeIp' => null,
            'sslEnabled' => false,
            'sslProvider' => 'HTTP only (Nginx :80)',
            'configPath' => (string) config('hosting.primary_vhost'),
            'engine' => 'nginx',
        ]];
    }

    public function dnsRecords(): array
    {
        $bindDir = (string) config('hosting.bind_dir');
        $zones = ['yuda.local', 'great-yuda.my.id'];
        $records = [];

        foreach ($zones as $zone) {
            $file = rtrim($bindDir, '/').'/db.'.$zone;
            if (! is_readable($file)) {
                continue;
            }
            foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
                $line = trim($line);
                if (str_starts_with($line, ';') || str_starts_with($line, '$')) {
                    continue;
                }
                if (preg_match('/^(\S+)\s+IN\s+(A|CNAME|MX|TXT|NS|SOA)\s+(.+)$/', $line, $m)) {
                    $records[] = [
                        'id' => $zone.'|'.$m[1].'|'.$m[2].'|'.$m[3],
                        'zone' => $zone,
                        'name' => $m[1],
                        'type' => $m[2],
                        'content' => trim($m[3]),
                        'ttl' => 3600,
                        'proxied' => false,
                    ];
                }
            }
        }

        foreach (HostingSinkhole::query()->orderBy('domain')->get() as $sinkhole) {
            $records[] = [
                'id' => 'sinkhole|'.$sinkhole->domain,
                'zone' => $sinkhole->domain,
                'name' => '@',
                'type' => 'SINKHOLE',
                'content' => $sinkhole->target_ip,
                'ttl' => 300,
                'proxied' => false,
                'enabled' => (bool) $sinkhole->enabled,
            ];
        }

        return $records;
    }

    public function services(): array
    {
        $services = [];
        foreach ((array) config('hosting.services', []) as $id => $cfg) {
            $unit = (string) ($cfg['unit'] ?? $id);
            $active = $this->runFixed(['systemctl', 'is-active', '--quiet', $unit]);
            $services[] = [
                'id' => $id,
                'name' => $unit,
                'displayName' => (string) ($cfg['display'] ?? $id),
                'port' => $cfg['port'] ?? null,
                'status' => ($active['exit'] === 0) ? 'running' : 'stopped',
                'manager' => (string) ($cfg['manager'] ?? 'systemd'),
                'description' => (string) ($cfg['description'] ?? ''),
                'protected' => (bool) ($cfg['protected'] ?? false),
            ];
        }

        return $services;
    }

    public function serviceControl(string $serviceId, string $action, ?int $userId, ?string $ip, bool $confirmed = false): array
    {
        $services = (array) config('hosting.services', []);
        if (! isset($services[$serviceId])) {
            throw new RuntimeException('Service tidak ada di allowlist.', 422);
        }
        if (! in_array($action, self::ACTIONS, true)) {
            throw new RuntimeException('Action tidak valid.', 422);
        }
        if (($services[$serviceId]['protected'] ?? false) && $action === 'stop' && ! $confirmed) {
            throw new RuntimeException('Stop service protected butuh konfirmasi. Kirim confirm=1.', 422);
        }

        $result = $this->ctlCall(['service', $serviceId, $action]);
        $this->audit('service.'.$action, $serviceId, ['service' => $serviceId, 'action' => $action], $result['exit'] === 0 ? 'ok' : 'failed', $ip, $userId);
        $this->bustOverviewCache();

        return [
            'output' => trim($result['output']) !== '' ? trim($result['output']) : "Service {$serviceId} {$action} berhasil.",
            'exit' => $result['exit'],
        ];
    }

    public function healAllServices(?int $userId, ?string $ip): array
    {
        $healed = [];
        $failed = [];
        foreach ($this->services() as $svc) {
            if ($svc['status'] === 'running') {
                continue;
            }
            try {
                $res = $this->serviceControl((string) $svc['id'], 'start', $userId, $ip, true);
                $healed[] = $svc['id'];
            } catch (\Throwable $e) {
                $failed[$svc['id']] = $e->getMessage();
            }
        }
        $this->audit('service.heal', null, ['healed' => $healed, 'failed' => $failed], empty($failed) ? 'ok' : 'partial', $ip, $userId);
        $this->bustOverviewCache();

        return [
            'message' => empty($failed) ? 'Semua service telah diverifikasi dan berjalan.' : 'Sebagian service gagal dipulihkan.',
            'healed' => $healed,
            'failed' => $failed,
        ];
    }


    public function createSinkhole(string $domain, string $ip, ?int $userId, ?string $requestIp): HostingSinkhole
    {
        $domain = strtolower(trim($domain));
        $ip = trim($ip);

        if (! $this->isValidDomain($domain)) {
            throw new RuntimeException('Format domain tidak valid.', 422);
        }
        if ($this->isProtectedSinkholeDomain($domain)) {
            throw new RuntimeException('Domain ini dilindungi dan tidak boleh di-sinkhole (cegah lockout admin).', 422);
        }
        $allowed = (array) config('hosting.sinkhole.allow_targets', ['0.0.0.0', '127.0.0.1']);
        $allowed[] = $this->serverIp();
        if (! in_array($ip, $allowed, true)) {
            throw new RuntimeException('Target sinkhole hanya boleh 0.0.0.0, 127.0.0.1, atau IP server.', 422);
        }
        if (HostingSinkhole::where('domain', $domain)->exists()) {
            throw new RuntimeException('Sinkhole untuk domain ini sudah ada.', 422);
        }

        $result = $this->ctlCall(['sinkhole', 'add', $domain, $ip]);
        if ($result['exit'] !== 0) {
            $this->audit('sinkhole.add', $domain, ['ip' => $ip, 'output' => $result['output']], 'failed', $requestIp, $userId);
            throw new RuntimeException(trim($result['output']) ?: 'Gagal membuat sinkhole BIND9.', 500);
        }

        $sinkhole = HostingSinkhole::create([
            'domain' => $domain,
            'target_ip' => $ip,
            'enabled' => true,
            'created_by' => $userId,
        ]);

        $this->audit('sinkhole.add', $domain, ['ip' => $ip], 'ok', $requestIp, $userId);
        $this->bustOverviewCache();

        return $sinkhole;
    }

    public function deleteSinkhole(string $domain, ?int $userId, ?string $requestIp): void
    {
        $domain = strtolower(trim($domain));
        $sinkhole = HostingSinkhole::where('domain', $domain)->first();
        if (! $sinkhole) {
            throw new RuntimeException('Sinkhole tidak ditemukan.', 404);
        }

        $result = $this->ctlCall(['sinkhole', 'remove', $domain]);
        if ($result['exit'] !== 0) {
            $this->audit('sinkhole.remove', $domain, ['output' => $result['output']], 'failed', $requestIp, $userId);
            throw new RuntimeException(trim($result['output']) ?: 'Gagal menghapus sinkhole.', 500);
        }

        $sinkhole->delete();
        $this->audit('sinkhole.remove', $domain, [], 'ok', $requestIp, $userId);
        $this->bustOverviewCache();
    }

    public function isValidDomain(string $domain): bool
    {
        if (strlen($domain) > 253) {
            return false;
        }
        return (bool) preg_match('/^(?!-)[a-z0-9-]{1,63}(?<!-)(\.(?!-)[a-z0-9-]{1,63}(?<!-))*\.(?!-)[a-z0-9-]{2,63}(?<!-)$/', $domain);
    }

    private function isProtectedSinkholeDomain(string $domain): bool
    {
        $protected = array_map('strtolower', (array) config('hosting.sinkhole.protected_domains', []));
        return in_array($domain, $protected, true);
    }

    public function isProtectedVhost(string $domain, ?string $configName = null): bool
    {
        $domain = strtolower(trim($domain));
        $protected = array_map('strtolower', (array) config('hosting.vhost.protected', [
            'yuda_local',
            'yuda.local',
            'localhost',
            '127.0.0.1',
        ]));

        if (in_array($domain, $protected, true)) {
            return true;
        }

        if ($configName && in_array(strtolower(trim($configName)), $protected, true)) {
            return true;
        }

        return false;
    }

    /**
     * Mematikan (suspend) atau mengaktifkan kembali (unsuspend) website target.
     * Mendukung website Nginx native lokal (via hosting-ctl vhost) maupun website di aaPanel (via API).
     */
    public function toggleVhost(string $target, string $action, ?int $userId, ?string $requestIp, ?string $engine = null, int|string|null $siteId = null): array
    {
        $target = trim($target);
        $action = strtolower(trim($action));

        if (! in_array($action, ['suspend', 'unsuspend'], true)) {
            throw new RuntimeException('Aksi tidak valid. Gunakan suspend atau unsuspend.', 422);
        }

        if (! preg_match('/^[a-zA-Z0-9.\-]+$/', $target) || strlen($target) > 253) {
            throw new RuntimeException('Format target domain atau vhost tidak valid.', 422);
        }

        if ($this->isProtectedVhost($target)) {
            throw new RuntimeException('Domain ' . $target . ' adalah domain sistem yang dilindungi dan tidak boleh dimatikan.', 422);
        }

        if ($engine === 'aapanel') {
            if ($action === 'suspend') {
                $res = $this->aapanel->stopSite($siteId ?: $target, $target);
            } else {
                $res = $this->aapanel->startSite($siteId ?: $target, $target);
            }

            $this->audit('aapanel.site.' . $action, $target, [
                'domain' => $target,
                'site_id' => $siteId,
                'response' => $res,
            ], 'success', $requestIp, $userId);

            $this->bustOverviewCache();

            return [
                'domain' => $target,
                'engine' => 'aapanel',
                'action' => $action,
                'status' => $action === 'suspend' ? 'suspended' : 'active',
                'message' => 'Situs aaPanel ' . $target . ' berhasil di-' . ($action === 'suspend' ? 'suspend' : 'aktifkan') . '.',
            ];
        }

        // Default: Nginx Native via hosting-ctl
        $sub = ['vhost', $action, $target];
        $result = $this->ctlCall($sub);

        if ($result['exit'] !== 0) {
            throw new RuntimeException('Gagal mengubah status vhost ' . $target . ': ' . ($result['output'] ?: 'exit code ' . $result['exit']));
        }

        $this->audit('nginx.vhost.' . $action, $target, [
            'domain' => $target,
            'output' => $result['output'],
        ], 'success', $requestIp, $userId);

        $this->bustOverviewCache();

        return [
            'domain' => $target,
            'engine' => 'nginx',
            'action' => $action,
            'status' => $action === 'suspend' ? 'suspended' : 'active',
            'output' => $result['output'],
            'message' => 'Virtualhost ' . $target . ' berhasil di-' . ($action === 'suspend' ? 'suspend (HTTP 503)' : 'aktifkan kembali') . '.',
        ];
    }


    public function createDnsRecord(string $zone, string $name, string $type, string $content, int $ttl, ?int $userId, ?string $requestIp): void
    {
        $zone = strtolower(trim($zone));
        $type = strtoupper(trim($type));
        $name = trim($name);
        $content = trim($content);

        if (! in_array($zone, ['yuda.local', 'great-yuda.my.id'], true)) {
            throw new RuntimeException('Zona hanya boleh yuda.local atau great-yuda.my.id.', 422);
        }
        if (! in_array($type, ['A', 'CNAME'], true)) {
            throw new RuntimeException('Tipe record dibatasi A/CNAME. TXT/MX dinonaktifkan demi keamanan.', 422);
        }
        if ($name !== '@' && ! preg_match('/^(?!-)[a-z0-9-]{1,63}(?<!-)$/', strtolower($name))) {
            throw new RuntimeException('Nama record tidak valid.', 422);
        }
        if ($ttl < 60 || $ttl > 86400) {
            throw new RuntimeException('TTL harus 60-86400 detik.', 422);
        }
        if ($type === 'A' && filter_var($content, FILTER_VALIDATE_IP) === false) {
            throw new RuntimeException('Content A harus alamat IP valid.', 422);
        }
        if ($type === 'CNAME' && ! $this->isValidDomain(strtolower(rtrim($content, '.')))) {
            throw new RuntimeException('Content CNAME harus domain valid.', 422);
        }

        $result = $this->ctlCall(['dns', 'set', $zone, $name, $type, $content, (string) $ttl]);
        $this->audit('dns.add', $zone, compact('name', 'type', 'content', 'ttl'), $result['exit'] === 0 ? 'ok' : 'failed', $requestIp, $userId);
        if ($result['exit'] !== 0) {
            throw new RuntimeException(trim($result['output']) ?: 'Gagal menulis record DNS.', 500);
        }
        $this->bustOverviewCache();
    }

    public function deleteDnsRecord(string $zone, string $name, string $type, ?int $userId, ?string $requestIp): void
    {
        $zone = strtolower(trim($zone));
        $type = strtoupper(trim($type));
        $name = trim($name);

        if (! in_array($zone, ['yuda.local', 'great-yuda.my.id'], true)) {
            throw new RuntimeException('Zona tidak dikenal.', 422);
        }
        if (! in_array($type, ['A', 'CNAME'], true)) {
            throw new RuntimeException('Record ini tidak bisa dihapus dari panel.', 422);
        }

        $result = $this->ctlCall(['dns', 'del', $zone, $name, $type]);
        $this->audit('dns.del', $zone, compact('name', 'type'), $result['exit'] === 0 ? 'ok' : 'failed', $requestIp, $userId);
        if ($result['exit'] !== 0) {
            throw new RuntimeException(trim($result['output']) ?: 'Gagal menghapus record DNS.', 500);
        }
        $this->bustOverviewCache();
    }


    public function nginxInfo(): array
    {
        $primary = (string) config('hosting.primary_vhost');
        $repo = (string) config('hosting.repo_vhost');

        $content = '';
        if (is_readable($primary)) {
            $content = @file_get_contents($primary) ?: '';
        } elseif (is_readable($repo)) {
            $content = @file_get_contents($repo) ?: '';
        }

        return [
            'configPath' => $primary,
            'repoPath' => $repo,
            'currentConfig' => $content,
            'generatedPreview' => '',
        ];
    }

    public function saveNginxConfig(string $content, ?int $userId, ?string $requestIp): array
    {
        if (trim($content) === '' || strlen($content) > 100_000) {
            throw new RuntimeException('Konten nginx tidak kosong dan maksimal 100KB.', 422);
        }
        if (! str_contains($content, 'server_name') || ! str_contains($content, 'root')) {
            throw new RuntimeException('Config harus mengandung server_name dan root.', 422);
        }
        if (preg_match('/\$\{|;.*\$\(|`/', $content)) {
            throw new RuntimeException('Konten mengandung pola berbahaya.', 422);
        }

        // Pertahanan Mendalam: Larang direktif eskalasi hak akses & arbitrary file write/read
        $forbiddenDirectives = [
            '/\b(fastcgi_param\s+PHP_VALUE|fastcgi_param\s+PHP_ADMIN_VALUE)\b/i' => 'Direktif manipulasi runtime PHP (PHP_VALUE) dilarang.',
            '/\bautoindex\s+on\b/i' => 'Direktif autoindex on dilarang.',
            '/\b(root|alias)\s+(?!\/var\/www\/)/i' => 'Root/alias harus berada di dalam direktori /var/www/.',
            '/\b(access_log|error_log)\s+(?!\/var\/log\/nginx\/|\b(off|syslog:)\b)/i' => 'Log file hanya boleh di /var/log/nginx/ atau off.',
            '/\binclude\s+(?!\/etc\/nginx\/)/i' => 'Include hanya diizinkan untuk file konfigurasi di /etc/nginx/.',
            '/\b(lua_|perl_|js_|load_module)\b/i' => 'Eksekusi embedded script module di dalam Nginx dilarang.',
        ];

        foreach ($forbiddenDirectives as $pattern => $msg) {
            if (preg_match($pattern, $content)) {
                throw new RuntimeException('Konfigurasi ditolak: ' . $msg, 422);
            }
        }

        $tmp = storage_path('app/private/hosting/nginx-'.uniqid().'.conf');
        @mkdir(dirname($tmp), 0755, true);
        file_put_contents($tmp, $content);

        try {
            $result = $this->ctlCall(['nginx', 'save', $tmp]);
            $this->audit('nginx.save', 'project_tkj_yuda2', ['bytes' => strlen($content)], $result['exit'] === 0 ? 'ok' : 'failed', $requestIp, $userId);
            if ($result['exit'] !== 0) {
                throw new RuntimeException(trim($result['output']) ?: 'nginx -t gagal.', 500);
            }
        } finally {
            @unlink($tmp);
        }

        $this->bustOverviewCache();

        return [
            'message' => 'Konfigurasi nginx berhasil disimpan dan reload.',
            'content' => $this->nginxInfo()['currentConfig'] ?? $content,
        ];
    }


    public function firewall(): array
    {
        $listening = [];
        $ss = $this->runFixed(['ss', '-tuln']);
        if ($ss['exit'] === 0) {
            foreach (explode("\n", $ss['output']) as $line) {
                if (preg_match('/:(\\d+)\\b/', $line, $m)) {
                    $listening[] = ['localPort' => (int) $m[1], 'protocol' => str_contains($line, 'tcp') ? 'tcp' : 'udp', 'process' => ''];
                }
            }
        }

        $enabled = false;
        $rules = [];
        $ufw = $this->runFixed(['sudo', '-n', 'ufw', 'status', 'verbose']);
        if ($ufw['exit'] === 0) {
            $enabled = stripos($ufw['output'], 'Status: active') !== false;
            foreach (explode("\n", $ufw['output']) as $line) {
                if (preg_match('/^(\S+)\s+(ALLOW|DENY|LIMIT)\s+/', trim($line), $m)) {
                    $rules[] = [
                        'id' => md5($line),
                        'port' => $m[1],
                        'protocol' => 'TCP',
                        'action' => $m[2],
                        'source' => 'any',
                        'service' => trim($line),
                    ];
                }
            }
        }

        return [
            'enabled' => $enabled,
            'rules' => $rules,
            'listeningPorts' => array_values(array_unique($listening, SORT_REGULAR)),
            'available' => $this->runFixed(['which', 'ufw'])['exit'] === 0,
        ];
    }

    public function toggleFirewall(bool $enabled, ?int $userId, ?string $requestIp): array
    {
        $result = $this->ctlCall(['ufw', $enabled ? 'enable' : 'disable']);
        $this->audit('firewall.toggle', null, ['enabled' => $enabled], $result['exit'] === 0 ? 'ok' : 'failed', $requestIp, $userId);
        if ($result['exit'] !== 0) {
            throw new RuntimeException(trim($result['output']) ?: 'Gagal mengubah firewall.', 500);
        }
        $this->bustOverviewCache();

        return ['firewallEnabled' => $enabled, 'message' => $enabled ? 'Firewall UFW diaktifkan' : 'Firewall UFW dinonaktifkan'];
    }

    public function createFirewallRule(string $port, string $protocol, string $action, string $source, string $service, ?int $userId, ?string $requestIp): void
    {
        if (! preg_match('/^\d{1,5}(:\d{1,5})?$/', $port)) {
            throw new RuntimeException('Port tidak valid.', 422);
        }
        if (! in_array($protocol, ['TCP', 'UDP'], true) || ! in_array($action, ['ALLOW', 'DENY', 'LIMIT'], true)) {
            throw new RuntimeException('Protokol/action tidak valid.', 422);
        }
        if ($source !== '0.0.0.0/0' && filter_var(strtok($source, '/'), FILTER_VALIDATE_IP) === false) {
            throw new RuntimeException('Source IP/CIDR tidak valid.', 422);
        }
        if ($service === '' || strlen($service) > 60 || preg_match('/[;&|`$]/', $service)) {
            throw new RuntimeException('Deskripsi layanan tidak valid.', 422);
        }

        $result = $this->ctlCall(['ufw', 'rule', $port, strtolower($protocol), strtolower($action), $source, $service]);
        $this->audit('firewall.add', $port, compact('protocol', 'action', 'source', 'service'), $result['exit'] === 0 ? 'ok' : 'failed', $requestIp, $userId);
        if ($result['exit'] !== 0) {
            throw new RuntimeException(trim($result['output']) ?: 'Gagal menambah aturan firewall.', 500);
        }
        $this->bustOverviewCache();
    }

    public function deleteFirewallRule(string $port, string $protocol, ?int $userId, ?string $requestIp): void
    {
        if (! preg_match('/^\d{1,5}(:\d{1,5})?$/', $port) || ! in_array($protocol, ['TCP', 'UDP'], true)) {
            throw new RuntimeException('Port/protokol tidak valid.', 422);
        }
        $result = $this->ctlCall(['ufw', 'del', $port, strtolower($protocol)]);
        $this->audit('firewall.del', $port, compact('protocol'), $result['exit'] === 0 ? 'ok' : 'failed', $requestIp, $userId);
        if ($result['exit'] !== 0) {
            throw new RuntimeException(trim($result['output']) ?: 'Gagal menghapus aturan firewall.', 500);
        }
        $this->bustOverviewCache();
    }


    private const CRON_ALLOWLIST = '/^(php artisan [a-z0-9:_\-]+|curl -s https?:\/\/[a-zA-Z0-9.\-]+\S*|sleep \d+)$/';

    private function assertSafeCronCommand(string $command): void
    {
        if (! preg_match(self::CRON_ALLOWLIST, $command)) {
            throw new RuntimeException('Command cron tidak ada di allowlist. Hanya php artisan, sleep, atau curl publik yang diizinkan.', 422);
        }

        // Mitigasi SSRF: Jika perintah menggunakan curl, pastikan tidak menembak IP loopback / internal private
        if (str_starts_with($command, 'curl')) {
            $parts = explode(' ', $command);
            $url = end($parts);
            $host = parse_url($url, PHP_URL_HOST);
            if (! $host) {
                throw new RuntimeException('URL cron tidak valid.', 422);
            }
            $hostLower = strtolower($host);
            if (in_array($hostLower, ['localhost', '127.0.0.1', '0.0.0.0', '::1'], true) || str_ends_with($hostLower, '.local')) {
                throw new RuntimeException('Cron job dilarang mengakses alamat loopback atau internal server.', 422);
            }
            $resolvedIp = gethostbyname($host);
            if (filter_var($resolvedIp, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
                throw new RuntimeException('Cron job dilarang mengakses rentang IP privat atau lokal.', 422);
            }
        }
    }

    public function createCronJob(string $name, string $schedule, string $command, string $description, ?int $userId, ?string $requestIp): HostingCronJob
    {
        if (! preg_match('/^(\*|(\d+|\*\/\d+|\d+-\d+)(,(\d+|\*\/\d+|\d+-\d+))?)\s+(\*|(\d+|\*\/\d+|\d+-\d+)(,(\d+|\*\/\d+|\d+-\d+))?)\s+(\*|(\d+|\*\/\d+|\d+-\d+)(,(\d+|\*\/\d+|\d+-\d+))?)\s+(\*|(\d+|\*\/\d+|\d+-\d+)(,(\d+|\*\/\d+|\d+-\d+))?)\s+(\*|(\d+|\*\/\d+|\d+-\d+)(,(\d+|\*\/\d+|\d+-\d+))?)$/', $schedule)) {
            throw new RuntimeException('Ekspresi cron 5-field tidak valid.', 422);
        }
        $this->assertSafeCronCommand($command);

        $job = HostingCronJob::create(compact('name', 'schedule', 'command', 'description'));
        $this->audit('cron.add', (string) $job->id, compact('name', 'schedule'), 'ok', $requestIp, $userId);
        $this->bustOverviewCache();

        return $job;
    }

    public function runCronJob(int $id, ?int $userId, ?string $requestIp): array
    {
        $job = HostingCronJob::find($id);
        if (! $job) {
            throw new RuntimeException('Cron job tidak ditemukan.', 404);
        }
        $this->assertSafeCronCommand((string) $job->command);

        $parts = explode(' ', (string) $job->command);
        $result = $this->runFixed($parts, 15);

        $job->update([
            'last_run_at' => now(),
            'last_status' => $result['exit'] === 0 ? 'success' : 'failed',
            'last_output' => mb_substr(trim($result['output']), 0, 2000) ?: '(no output)',
        ]);

        $this->audit('cron.run', (string) $job->id, ['exit' => $result['exit']], $result['exit'] === 0 ? 'ok' : 'failed', $requestIp, $userId);
        $this->bustOverviewCache();

        return ['output' => $job->last_output, 'exit' => $result['exit']];
    }

    public function deleteCronJob(int $id, ?int $userId, ?string $requestIp): void
    {
        $job = HostingCronJob::find($id);
        if (! $job) {
            throw new RuntimeException('Cron job tidak ditemukan.', 404);
        }
        $job->delete();
        $this->audit('cron.del', (string) $id, [], 'ok', $requestIp, $userId);
        $this->bustOverviewCache();
    }


    public function databases(): array
    {
        $tables = [];
        try {
            $dbName = config('database.connections.mysql.database', config('database.default'));
            $rows = DB::select("SELECT TABLE_NAME, ENGINE, TABLE_ROWS, ROUND((DATA_LENGTH + INDEX_LENGTH) / 1024, 2) AS size_kb FROM information_schema.TABLES WHERE TABLE_SCHEMA = ? ORDER BY TABLE_NAME", [$dbName]);
            foreach ($rows as $row) {
                $tables[] = [
                    'tableName' => $row->TABLE_NAME,
                    'engine' => $row->ENGINE ?? 'InnoDB',
                    'rows' => (int) ($row->TABLE_ROWS ?? 0),
                    'sizeKb' => (float) ($row->size_kb ?? 0),
                ];
            }
        } catch (\Throwable) {
            $tables = [];
        }

        $backups = [];
        $backupDir = storage_path('app/private/backups');
        if (is_dir($backupDir)) {
            foreach (@glob(rtrim($backupDir, '/').'/*.sql.gz') ?: [] as $file) {
                $backups[] = [
                    'filename' => basename($file),
                    'sizeBytes' => @filesize($file) ?: 0,
                ];
            }
        }

        $dbName = (string) (config('database.connections.mysql.database') ?: 'project_tkj_yuda2');

        return [
            'instances' => [[
                'id' => 'db-main',
                'name' => $dbName,
                'engine' => 'MariaDB',
                'host' => config('database.connections.mysql.host', '127.0.0.1'),
                'port' => config('database.connections.mysql.port', 3306),
                'username' => config('database.connections.mysql.username', 'yuda_user'),
                'charset' => 'utf8mb4_unicode_ci',
                'privileges' => 'ALL PRIVILEGES',
            ]],
            'tables' => $tables,
            'backups' => $backups,
        ];
    }

    private function totalDbRows(): int
    {
        try {
            $dbName = config('database.connections.mysql.database', config('database.default'));
            $row = DB::selectOne('SELECT COALESCE(SUM(TABLE_ROWS), 0) AS total FROM information_schema.TABLES WHERE TABLE_SCHEMA = ?', [$dbName]);

            return (int) ($row->total ?? 0);
        } catch (\Throwable) {
            return 0;
        }
    }

    public function createDatabase(string $name, string $username, ?int $userId, ?string $requestIp): void
    {
        $this->assertDbAdminEnabled();
        if (! preg_match('/^[a-zA-Z0-9_]+$/', $name) || ! preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            throw new RuntimeException('Nama database/username hanya boleh huruf, angka, underscore.', 422);
        }
        DB::statement("CREATE DATABASE IF NOT EXISTS `{$name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $this->audit('database.create', $name, compact('username'), 'ok', $requestIp, $userId);
        $this->bustOverviewCache();
    }

    public function deleteDatabase(string $name, ?int $userId, ?string $requestIp): void
    {
        $this->assertDbAdminEnabled();
        $mainDb = (string) config('database.connections.mysql.database', '');
        if ($name === $mainDb || $name === 'db-main') {
            throw new RuntimeException('Database utama aplikasi dilindungi dan tidak bisa dihapus.', 422);
        }
        if (! preg_match('/^[a-zA-Z0-9_]+$/', $name)) {
            throw new RuntimeException('Nama database tidak valid.', 422);
        }
        DB::statement("DROP DATABASE `{$name}`");
        $this->audit('database.delete', $name, [], 'ok', $requestIp, $userId);
        $this->bustOverviewCache();
    }

    public function createDatabaseBackup(?int $userId, ?string $requestIp): array
    {
        $this->assertDbAdminEnabled();
        $backupDir = storage_path('app/private/backups');
        @mkdir($backupDir, 0755, true);
        $dbName = (string) config('database.connections.mysql.database', 'project_tkj_yuda2');
        $filename = $dbName.'-'.now()->format('Ymd-His').'.sql.gz';
        $path = rtrim($backupDir, '/').'/'.$filename;

        $env = $_SERVER;
        $env['MYSQL_PWD'] = (string) config('database.connections.mysql.password', '');
        $process = new Process([
            'mysqldump',
            '--host='.(string) config('database.connections.mysql.host', '127.0.0.1'),
            '--port='.(string) config('database.connections.mysql.port', 3306),
            '--user='.(string) config('database.connections.mysql.username', 'yuda_user'),
            '--single-transaction',
            '--databases',
            $dbName,
        ], null, $env, null, 60);

        try {
            $process->run();
            $sql = $process->getOutput() ?: '';
            if ($process->getExitCode() !== 0 || $sql === '') {
                throw new RuntimeException(trim($process->getErrorOutput()) ?: 'mysqldump gagal.', 500);
            }
            file_put_contents($path, gzencode($sql, 6));
        } catch (RuntimeException $e) {
            $this->audit('database.backup', $dbName, [], 'failed', $requestIp, $userId);

            throw $e;
        }

        $this->audit('database.backup', $dbName, ['filename' => $filename], 'ok', $requestIp, $userId);
        $this->bustOverviewCache();

        return ['backup' => ['filename' => $filename, 'sizeBytes' => @filesize($path) ?: 0]];
    }

    private function assertDbAdminEnabled(): void
    {
        if (! (bool) env('HOSTING_DB_ADMIN_ENABLED', false)) {
            throw new RuntimeException('Fitur tulis DB dinonaktifkan. Aktifkan HOSTING_DB_ADMIN_ENABLED=true di .env dan pastikan user DB punya hak CREATE/DROP.', 422);
        }
    }


    private function ctlCall(array $sub): array
    {
        $ctl = (string) config('hosting.ctl', '/usr/local/sbin/hosting-ctl');
        if (! is_executable($ctl)) {
            throw new RuntimeException(
                'hosting-ctl belum terinstall di server. Jalankan sekali: sudo bash scripts/install-hosting-ctl.sh',
                503
            );
        }

        $result = $this->runFixed(array_merge(['sudo', '-n', $ctl], $sub), 30);
        if ($result['exit'] === 127 || str_contains($result['output'], 'a password is required')) {
            throw new RuntimeException('sudo untuk hosting-ctl ditolak. Pastikan sudoers /etc/sudoers.d/www-data-hosting sudah terinstall.', 503);
        }

        return $result;
    }

    private function runFixed(array $argv, int $timeout = 10): array
    {
        try {
            $process = new Process($argv, null, null, null, $timeout);
            $process->run();

            return [
                'exit' => $process->getExitCode() ?? 1,
                'output' => trim(($process->getOutput() ?: '')."\n".($process->getErrorOutput() ?: '')),
            ];
        } catch (\Throwable $e) {
            return ['exit' => 1, 'output' => $e->getMessage()];
        }
    }

    private function audit(string $action, ?string $target, array $payload, string $result, ?string $ip, ?int $userId): void
    {
        try {
            HostingAudit::create([
                'user_id' => $userId,
                'action' => $action,
                'target' => $target,
                'payload' => $payload,
                'result' => $result,
                'ip' => $ip,
            ]);
        } catch (\Throwable) {
        }
    }

    private function activityLogs(): array
    {
        return HostingAudit::query()
            ->latest()
            ->take(50)
            ->get()
            ->map(fn (HostingAudit $log) => [
                'id' => $log->id,
                'category' => strtoupper(explode('.', $log->action)[0] ?? 'SYSTEM'),
                'action' => $log->action,
                'target' => $log->target ?? '—',
                'result' => $log->result,
                'timestamp' => $log->created_at?->toIso8601String(),
            ])
            ->values()
            ->all();
    }
}
