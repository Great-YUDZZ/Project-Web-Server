<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\HostingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class HostingController extends Controller
{
    public function index(HostingService $hosting): View
    {
        return view('admin.hosting', [
            'overview' => $hosting->getOverview(),
            'tab' => request()->query('tab', 'cpanel'),
        ]);
    }

    public function overview(HostingService $hosting): JsonResponse
    {
        return response()->json($hosting->getOverview());
    }

    public function controlService(Request $request, HostingService $hosting, string $id): JsonResponse
    {
        try {
            $action = (string) $request->input('action', '');
            $confirmed = (bool) $request->boolean('confirm');
            $result = $hosting->serviceControl($id, $action, auth()->id(), $request->ip(), $confirmed);

            return response()->json(['ok' => true, 'output' => $result['output']]);
        } catch (RuntimeException $e) {
            return $this->error($e, 'Gagal mengontrol service.');
        }
    }

    public function healAll(Request $request, HostingService $hosting): JsonResponse
    {
        try {
            $result = $hosting->healAllServices(auth()->id(), $request->ip());

            return response()->json(['ok' => true, ...$result]);
        } catch (RuntimeException $e) {
            return $this->error($e, 'Gagal auto-heal services.');
        }
    }

    public function storeSinkhole(Request $request, HostingService $hosting): JsonResponse
    {
        try {
            $validated = $request->validate([
                'domain' => ['required', 'string', 'max:253'],
                'target_ip' => ['required', 'string', 'max:45'],
            ]);
            $sinkhole = $hosting->createSinkhole($validated['domain'], $validated['target_ip'], auth()->id(), $request->ip());

            return response()->json(['ok' => true, 'data' => $sinkhole], 201);
        } catch (RuntimeException $e) {
            return $this->error($e, 'Gagal membuat sinkhole.');
        }
    }

    public function destroySinkhole(Request $request, HostingService $hosting, string $domain): JsonResponse
    {
        try {
            $hosting->deleteSinkhole($domain, auth()->id(), $request->ip());

            return response()->json(['ok' => true]);
        } catch (RuntimeException $e) {
            return $this->error($e, 'Gagal menghapus sinkhole.');
        }
    }

    public function toggleVhost(Request $request, HostingService $hosting, string $domain): JsonResponse
    {
        try {
            $validated = $request->validate([
                'action' => ['required', 'string', 'in:suspend,unsuspend'],
                'engine' => ['nullable', 'string', 'in:nginx,aapanel'],
                'site_id' => ['nullable'],
            ]);

            $result = $hosting->toggleVhost(
                $domain,
                $validated['action'],
                auth()->id(),
                $request->ip(),
                $validated['engine'] ?? 'nginx',
                $validated['site_id'] ?? null
            );

            return response()->json(['ok' => true, ...$result]);
        } catch (RuntimeException $e) {
            return $this->error($e, 'Gagal mengubah status website.');
        }
    }

    public function storeDnsRecord(Request $request, HostingService $hosting): JsonResponse
    {
        try {
            $validated = $request->validate([
                'zone' => ['required', 'string'],
                'name' => ['required', 'string', 'max:63'],
                'type' => ['required', 'string'],
                'content' => ['required', 'string', 'max:255'],
                'ttl' => ['required', 'integer', 'between:60,86400'],
            ]);
            $hosting->createDnsRecord(
                $validated['zone'],
                $validated['name'],
                $validated['type'],
                $validated['content'],
                (int) $validated['ttl'],
                auth()->id(),
                $request->ip()
            );

            return response()->json(['ok' => true], 201);
        } catch (RuntimeException $e) {
            return $this->error($e, 'Gagal membuat DNS record.');
        }
    }

    public function destroyDnsRecord(Request $request, HostingService $hosting): JsonResponse
    {
        try {
            $validated = $request->validate([
                'zone' => ['required', 'string'],
                'name' => ['required', 'string'],
                'type' => ['required', 'string'],
            ]);
            $hosting->deleteDnsRecord($validated['zone'], $validated['name'], $validated['type'], auth()->id(), $request->ip());

            return response()->json(['ok' => true]);
        } catch (RuntimeException $e) {
            return $this->error($e, 'Gagal menghapus DNS record.');
        }
    }

    public function saveNginx(Request $request, HostingService $hosting): JsonResponse
    {
        try {
            $validated = $request->validate([
                'content' => ['required', 'string', 'max:100000'],
            ]);
            $result = $hosting->saveNginxConfig($validated['content'], auth()->id(), $request->ip());

            return response()->json(['ok' => true, ...$result]);
        } catch (RuntimeException $e) {
            return $this->error($e, 'Gagal menyimpan nginx.conf.');
        }
    }

    public function toggleFirewall(Request $request, HostingService $hosting): JsonResponse
    {
        try {
            $result = $hosting->toggleFirewall($request->boolean('enabled'), auth()->id(), $request->ip());

            return response()->json(['ok' => true, ...$result]);
        } catch (RuntimeException $e) {
            return $this->error($e, 'Gagal mengubah firewall.');
        }
    }

    public function storeFirewallRule(Request $request, HostingService $hosting): JsonResponse
    {
        try {
            $validated = $request->validate([
                'port' => ['required', 'string'],
                'protocol' => ['required', 'string'],
                'action' => ['required', 'string'],
                'source' => ['required', 'string'],
                'service' => ['required', 'string'],
            ]);
            $hosting->createFirewallRule(
                $validated['port'],
                $validated['protocol'],
                $validated['action'],
                $validated['source'],
                $validated['service'],
                auth()->id(),
                $request->ip()
            );

            return response()->json(['ok' => true], 201);
        } catch (RuntimeException $e) {
            return $this->error($e, 'Gagal menambah aturan firewall.');
        }
    }

    public function destroyFirewallRule(Request $request, HostingService $hosting): JsonResponse
    {
        try {
            $validated = $request->validate([
                'port' => ['required', 'string'],
                'protocol' => ['required', 'string'],
            ]);
            $hosting->deleteFirewallRule($validated['port'], $validated['protocol'], auth()->id(), $request->ip());

            return response()->json(['ok' => true]);
        } catch (RuntimeException $e) {
            return $this->error($e, 'Gagal menghapus aturan firewall.');
        }
    }

    public function storeCron(Request $request, HostingService $hosting): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:120'],
                'schedule' => ['required', 'string'],
                'command' => ['required', 'string', 'max:500'],
                'description' => ['nullable', 'string', 'max:500'],
            ]);
            $job = $hosting->createCronJob(
                $validated['name'],
                $validated['schedule'],
                $validated['command'],
                (string) ($validated['description'] ?? ''),
                auth()->id(),
                $request->ip()
            );

            return response()->json(['ok' => true, 'data' => $job], 201);
        } catch (RuntimeException $e) {
            return $this->error($e, 'Gagal membuat cron job.');
        }
    }

    public function runCron(Request $request, HostingService $hosting, int $id): JsonResponse
    {
        try {
            $result = $hosting->runCronJob($id, auth()->id(), $request->ip());

            return response()->json(['ok' => true, ...$result]);
        } catch (RuntimeException $e) {
            return $this->error($e, 'Gagal menjalankan cron job.');
        }
    }

    public function destroyCron(Request $request, HostingService $hosting, int $id): JsonResponse
    {
        try {
            $hosting->deleteCronJob($id, auth()->id(), $request->ip());

            return response()->json(['ok' => true]);
        } catch (RuntimeException $e) {
            return $this->error($e, 'Gagal menghapus cron job.');
        }
    }

    public function storeDatabase(Request $request, HostingService $hosting): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:64'],
                'username' => ['required', 'string', 'max:64'],
            ]);
            $hosting->createDatabase($validated['name'], $validated['username'], auth()->id(), $request->ip());

            return response()->json(['ok' => true], 201);
        } catch (RuntimeException $e) {
            return $this->error($e, 'Gagal membuat database.');
        }
    }

    public function destroyDatabase(Request $request, HostingService $hosting, string $name): JsonResponse
    {
        try {
            $hosting->deleteDatabase($name, auth()->id(), $request->ip());

            return response()->json(['ok' => true]);
        } catch (RuntimeException $e) {
            return $this->error($e, 'Gagal menghapus database.');
        }
    }

    public function backupDatabase(Request $request, HostingService $hosting): JsonResponse
    {
        try {
            $result = $hosting->createDatabaseBackup(auth()->id(), $request->ip());

            return response()->json(['ok' => true, ...$result]);
        } catch (RuntimeException $e) {
            return $this->error($e, 'Gagal membuat backup database.');
        }
    }

    private function error(RuntimeException $e, string $fallback): JsonResponse
    {
        $code = $e->getCode();
        if (! in_array($code, [404, 422, 500, 503], true)) {
            $code = 500;
        }

        return response()->json([
            'ok' => false,
            'message' => $e->getMessage() ?: $fallback,
        ], $code);
    }
}
