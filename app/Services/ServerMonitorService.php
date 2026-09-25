<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Throwable;

class ServerMonitorService
{
    /**
     * Get all gathered server metrics.
     */
    public function getAllMetrics(): array
    {
        return [
            'system' => $this->getSystemMetrics(),
            'services' => $this->getServiceStatus(),
            'host' => $this->getHostInfo(),
        ];
    }

    /**
     * Get CPU, RAM, Disk, and Uptime metrics.
     */
    public function getSystemMetrics(): array
    {
        $cpu = $this->getCpuMetrics();
        $ram = $this->getMemoryMetrics();
        $disk = $this->getDiskMetrics();
        $uptime = $this->getUptimeMetrics();

        return [
            'cpu' => $cpu,
            'ram' => $ram,
            'disk' => $disk,
            'uptime' => $uptime,
        ];
    }

    /**
     * Get CPU load and core metrics.
     */
    protected function getCpuMetrics(): array
    {
        $cores = 1;
        $cpuinfo = @file_get_contents('/proc/cpuinfo');
        if ($cpuinfo) {
            $counted = substr_count($cpuinfo, "processor\t:");
            if ($counted > 0) {
                $cores = $counted;
            }
        }

        $loads = function_exists('sys_getloadavg') ? sys_getloadavg() : [0, 0, 0];
        $load1m = round($loads[0] ?? 0, 2);
        $load5m = round($loads[1] ?? 0, 2);
        $load15m = round($loads[2] ?? 0, 2);

        // Calculate real-time instant CPU utilization from /proc/stat delta
        $utilizationPercent = $this->calculateInstantCpuUsage($load1m, $cores);

        return [
            'cores' => $cores,
            'load_1m' => $load1m,
            'load_5m' => $load5m,
            'load_15m' => $load15m,
            'percent' => $utilizationPercent,
            'status' => $this->getUsageStatus($utilizationPercent),
        ];
    }

    /**
     * Calculate instant CPU usage using /proc/stat delta across polling intervals.
     */
    protected function calculateInstantCpuUsage(float $fallbackLoad, int $cores): float
    {
        $stat = @file_get_contents('/proc/stat');
        if (! $stat) {
            return min(100, round(($fallbackLoad / max(1, $cores)) * 100, 1));
        }

        if (preg_match('/^cpu\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/', $stat, $m)) {
            $total = (int) $m[1] + (int) $m[2] + (int) $m[3] + (int) $m[4] + (int) $m[5] + (int) $m[6] + (int) $m[7] + (int) $m[8];
            $idle = (int) $m[4] + (int) $m[5]; // idle + iowait

            $prev = cache()->get('server_monitor_cpu_stat');
            cache()->put('server_monitor_cpu_stat', ['total' => $total, 'idle' => $idle], now()->addMinutes(5));

            if ($prev && isset($prev['total'], $prev['idle'])) {
                $diffTotal = $total - $prev['total'];
                $diffIdle = $idle - $prev['idle'];
                if ($diffTotal > 0) {
                    $used = $diffTotal - $diffIdle;

                    return min(100, max(0, round(($used / $diffTotal) * 100, 1)));
                }
            }
        }

        return min(100, round(($fallbackLoad / max(1, $cores)) * 100, 1));
    }

    /**
     * Get Memory (RAM) statistics from /proc/meminfo.
     */
    protected function getMemoryMetrics(): array
    {
        $totalKb = 0;
        $availableKb = 0;

        $meminfo = @file_get_contents('/proc/meminfo');
        if ($meminfo) {
            if (preg_match('/MemTotal:\s+(\d+)/', $meminfo, $totalMatch)) {
                $totalKb = (int) $totalMatch[1];
            }
            if (preg_match('/MemAvailable:\s+(\d+)/', $meminfo, $availMatch)) {
                $availableKb = (int) $availMatch[1];
            } elseif (preg_match('/MemFree:\s+(\d+)/', $meminfo, $freeMatch)) {
                $availableKb = (int) $freeMatch[1];
            }
        }

        if ($totalKb === 0) {
            // Fallback: estimate from PHP memory limit
            $totalKb = 1024 * 1024;
            $availableKb = 512 * 1024;
        }

        $usedKb = max(0, $totalKb - $availableKb);
        $percent = round(($usedKb / max(1, $totalKb)) * 100, 1);

        return [
            'total_mb' => round($totalKb / 1024, 0),
            'used_mb' => round($usedKb / 1024, 0),
            'available_mb' => round($availableKb / 1024, 0),
            'total_formatted' => $this->formatBytes($totalKb * 1024),
            'used_formatted' => $this->formatBytes($usedKb * 1024),
            'free_formatted' => $this->formatBytes($availableKb * 1024),
            'percent' => $percent,
            'status' => $this->getUsageStatus($percent),
        ];
    }

    /**
     * Get Disk Storage metrics.
     */
    protected function getDiskMetrics(): array
    {
        $path = base_path();
        $totalBytes = @disk_total_space($path) ?: (100 * 1024 * 1024 * 1024);
        $freeBytes = @disk_free_space($path) ?: (50 * 1024 * 1024 * 1024);
        $usedBytes = max(0, $totalBytes - $freeBytes);
        $percent = round(($usedBytes / max(1, $totalBytes)) * 100, 1);

        return [
            'total_formatted' => $this->formatBytes($totalBytes),
            'used_formatted' => $this->formatBytes($usedBytes),
            'free_formatted' => $this->formatBytes($freeBytes),
            'percent' => $percent,
            'status' => $this->getUsageStatus($percent),
        ];
    }

    /**
     * Get System Uptime.
     */
    protected function getUptimeMetrics(): array
    {
        $seconds = 0;
        $uptimeContent = @file_get_contents('/proc/uptime');
        if ($uptimeContent) {
            $parts = explode(' ', trim($uptimeContent));
            $seconds = (int) ($parts[0] ?? 0);
        }

        $days = floor($seconds / 86400);
        $hours = floor(($seconds % 86400) / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        $formatted = [];
        if ($days > 0) {
            $formatted[] = "{$days} hari";
        }
        if ($hours > 0 || $days > 0) {
            $formatted[] = "{$hours} jam";
        }
        $formatted[] = "{$minutes} menit";

        return [
            'seconds' => $seconds,
            'formatted' => implode(' ', $formatted),
        ];
    }

    /**
     * Check LEMP stack services status.
     */
    public function getServiceStatus(): array
    {
        return [
            'database' => $this->checkDatabaseService(),
            'php_fpm' => $this->checkPhpFpmService(),
            'web_server' => $this->checkWebServerService(),
        ];
    }

    /**
     * Check Database connectivity, latency, and version.
     */
    protected function checkDatabaseService(): array
    {
        try {
            $startTime = microtime(true);
            $results = DB::select('SELECT VERSION() as version');
            $latencyMs = round((microtime(true) - $startTime) * 1000, 2);
            $version = $results[0]->version ?? 'Unknown';

            return [
                'status' => 'online',
                'label' => 'Online / Active',
                'latency_ms' => $latencyMs,
                'version' => $version,
                'driver' => config('database.default'),
            ];
        } catch (Throwable $e) {
            return [
                'status' => 'offline',
                'label' => 'Offline / Error',
                'latency_ms' => null,
                'version' => 'Unavailable',
                'driver' => config('database.default'),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Check PHP & PHP-FPM status.
     */
    protected function checkPhpFpmService(): array
    {
        $fpmSockets = [
            '/run/php/php8.4-fpm.sock',
            '/run/php/php8.3-fpm.sock',
            '/run/php/php-fpm.sock',
        ];

        $hasSocket = false;
        $activeSocket = null;
        foreach ($fpmSockets as $sock) {
            if (@file_exists($sock)) {
                $hasSocket = true;
                $activeSocket = $sock;
                break;
            }
        }

        $sapi = php_sapi_name();
        $isFpm = str_contains($sapi, 'fpm') || $hasSocket;

        return [
            'status' => $isFpm ? 'online' : 'normal',
            'label' => $isFpm ? 'PHP-FPM Active' : 'CLI / Built-in',
            'version' => 'PHP '.PHP_VERSION,
            'sapi' => $sapi,
            'socket' => $activeSocket,
            'opcache' => extension_loaded('Zend OPcache') && ini_get('opcache.enable') == '1',
        ];
    }

    /**
     * Check Web Server (Nginx or built-in).
     */
    protected function checkWebServerService(): array
    {
        $serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'Nginx (Unix)';
        $serverPort = $_SERVER['SERVER_PORT'] ?? 80;

        return [
            'status' => 'online',
            'label' => 'Serving Requests',
            'software' => $serverSoftware,
            'port' => $serverPort,
        ];
    }

    /**
     * Get host hardware and OS information.
     */
    public function getHostInfo(): array
    {
        return [
            'hostname' => gethostname() ?: 'tkj-server',
            'os' => php_uname('s'),
            'kernel' => php_uname('r'),
            'arch' => php_uname('m'),
            'server_ip' => $_SERVER['SERVER_ADDR'] ?? gethostbyname(gethostname()),
            'php_version' => PHP_VERSION,
        ];
    }

    /**
     * Format raw bytes into human readable format.
     */
    protected function formatBytes(float|int $bytes, int $precision = 1): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision).' '.$units[$pow];
    }

    /**
     * Classify usage percentage to status tier.
     */
    protected function getUsageStatus(float $percent): string
    {
        if ($percent >= 85) {
            return 'danger';
        }
        if ($percent >= 65) {
            return 'warning';
        }

        return 'normal';
    }
}
