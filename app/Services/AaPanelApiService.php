<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class AaPanelApiService
{
    private bool $enabled;
    private string $baseUrl;
    private string $apiSk;
    private int $timeout;

    public function __construct()
    {
        $this->enabled = (bool) config('hosting.aapanel.enabled', false);
        $this->baseUrl = (string) config('hosting.aapanel.base_url', 'http://127.0.0.1:7800');
        $this->apiSk = (string) config('hosting.aapanel.api_sk', '');
        $this->timeout = (int) config('hosting.aapanel.timeout', 5);
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function isConfigured(): bool
    {
        return $this->enabled && ! empty($this->apiSk) && ! empty($this->baseUrl);
    }

    public function getPanelUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Memeriksa konektivitas dan status panel aaPanel.
     *
     * @return array{connected: bool, message: string, version: ?string}
     */
    public function getStatus(): array
    {
        if (! $this->enabled) {
            return [
                'connected' => false,
                'message' => 'aaPanel API dinonaktifkan di konfigurasi (.env: AAPANEL_ENABLED=false)',
                'version' => null,
            ];
        }

        if (empty($this->apiSk)) {
            return [
                'connected' => false,
                'message' => 'API Secret Key aaPanel belum diisi (.env: AAPANEL_API_SK)',
                'version' => null,
            ];
        }

        try {
            $response = $this->request('/system?action=GetSystemTotal');
            if (isset($response['version']) || isset($response['status'])) {
                return [
                    'connected' => true,
                    'message' => 'Terhubung ke aaPanel (' . ($response['version'] ?? 'BT-Panel') . ')',
                    'version' => $response['version'] ?? 'Active',
                ];
            }

            return [
                'connected' => true,
                'message' => 'Terhubung ke aaPanel',
                'version' => 'Active',
            ];
        } catch (Throwable $e) {
            return [
                'connected' => false,
                'message' => 'Gagal menghubungi aaPanel: ' . $e->getMessage(),
                'version' => null,
            ];
        }
    }

    /**
     * Mengambil daftar situs yang terdaftar di aaPanel.
     *
     * @return array<int, array{id: int|string, domain: string, aliases: array, root: string, status: string, suspended: bool, canSuspend: bool, engine: string, sslEnabled: bool}>
     */
    public function getSites(): array
    {
        if (! $this->isConfigured()) {
            return [];
        }

        try {
            $data = $this->request('/data?action=getData', [
                'table' => 'sites',
                'limit' => 100,
                'p' => 1,
            ]);

            $sites = $data['data'] ?? [];
            if (! is_array($sites)) {
                return [];
            }

            $out = [];
            foreach ($sites as $site) {
                $domain = (string) ($site['name'] ?? '');
                if (empty($domain)) {
                    continue;
                }

                $statusRaw = (string) ($site['status'] ?? '1');
                $isSuspended = ($statusRaw === '0' || strtolower($statusRaw) === 'stopped');

                $out[] = [
                    'id' => (string) ($site['id'] ?? $domain),
                    'siteId' => $site['id'] ?? null,
                    'domain' => $domain,
                    'aliases' => [],
                    'type' => 'aapanel_vhost',
                    'root' => (string) ($site['path'] ?? '/www/wwwroot/' . $domain),
                    'target' => (string) ($site['path'] ?? '/www/wwwroot/' . $domain),
                    'port' => 80,
                    'status' => $isSuspended ? 'suspended' : 'active',
                    'suspended' => $isSuspended,
                    'sinkholeIp' => null,
                    'canSuspend' => true,
                    'sslEnabled' => false,
                    'sslProvider' => 'aaPanel SSL Manager',
                    'configPath' => 'aaPanel /www/server/panel/vhost',
                    'engine' => 'aapanel',
                ];
            }

            return $out;
        } catch (Throwable $e) {
            Log::warning('Gagal mengambil daftar website dari aaPanel: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Menghentikan (suspend) website di aaPanel.
     */
    public function stopSite(int|string $id, string $domain): array
    {
        $this->ensureConfigured();

        $response = $this->request('/site?action=SiteStop', [
            'id' => $id,
            'name' => $domain,
        ]);

        if (isset($response['status']) && ! $response['status']) {
            throw new RuntimeException($response['msg'] ?? 'Gagal mematikan situs di aaPanel.');
        }

        return $response;
    }

    /**
     * Menghidupkan (start/active) website di aaPanel.
     */
    public function startSite(int|string $id, string $domain): array
    {
        $this->ensureConfigured();

        $response = $this->request('/site?action=SiteStart', [
            'id' => $id,
            'name' => $domain,
        ]);

        if (isset($response['status']) && ! $response['status']) {
            throw new RuntimeException($response['msg'] ?? 'Gagal menghidupkan situs di aaPanel.');
        }

        return $response;
    }

    private function ensureConfigured(): void
    {
        if (! $this->enabled) {
            throw new RuntimeException('aaPanel API dinonaktifkan di konfigurasi.', 503);
        }
        if (empty($this->apiSk)) {
            throw new RuntimeException('API Secret Key aaPanel belum dikonfigurasi.', 503);
        }
    }

    /**
     * Mengirimkan request terotentikasi ke endpoint aaPanel.
     */
    private function request(string $endpoint, array $params = []): array
    {
        $now = time();
        $token = md5((string) $now . md5($this->apiSk));

        $payload = array_merge([
            'request_time' => $now,
            'request_token' => $token,
        ], $params);

        $url = rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/');

        $res = Http::withoutVerifying()
            ->asForm()
            ->timeout($this->timeout)
            ->post($url, $payload);

        if (! $res->successful()) {
            throw new RuntimeException('HTTP Error ' . $res->status() . ' dari aaPanel: ' . $res->body());
        }

        $json = $res->json();
        if (! is_array($json)) {
            throw new RuntimeException('Respons tidak valid dari aaPanel: ' . substr($res->body(), 0, 200));
        }

        return $json;
    }
}
