<?php

namespace Tests\Feature;

use App\Models\HostingAudit;
use App\Models\HostingCronJob;
use App\Models\HostingSinkhole;
use App\Models\User;
use App\Services\HostingService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HostingPanelTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_cannot_access_hosting_panel(): void
    {
        $response = $this->get('/admin/hosting');

        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_hosting_overview_json(): void
    {
        $response = $this->getJson('/admin/hosting/overview');

        $response->assertStatus(401);
    }

    public function test_admin_can_view_hosting_panel(): void
    {
        $admin = User::first();
        $this->assertNotNull($admin);

        $response = $this->actingAs($admin)->get('/admin/hosting');

        $response->assertStatus(200);
        $response->assertSee('Server &amp; Web Hosting Control Center', false);
        $response->assertSee('Sinkhole DNS Lokal', false);
        $response->assertSee('WHM Service Manager', false);
        $response->assertSee('hosting-tab', false);
    }

    public function test_admin_can_fetch_hosting_overview_json(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->getJson('/admin/hosting/overview');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'server' => ['distro', 'hostname', 'sharedIp', 'cpuCores', 'memory', 'disks', 'uptimeSeconds'],
            'domains',
            'dnsRecords',
            'sinkholes',
            'services',
            'databases' => ['instances', 'tables', 'backups'],
            'firewall' => ['enabled', 'rules', 'listeningPorts'],
            'cronJobs',
            'nginx' => ['configPath', 'currentConfig'],
            'activityLogs',
        ]);
    }

    public function test_hosting_service_rejects_protected_sinkhole_domain(): void
    {
        $service = app(HostingService::class);

        $this->expectExceptionCode(422);
        $service->createSinkhole('yuda.local', '0.0.0.0', User::first()?->id, '127.0.0.1');
    }

    public function test_hosting_service_rejects_invalid_sinkhole_domain_format(): void
    {
        $service = app(HostingService::class);

        $this->expectExceptionCode(422);
        $service->createSinkhole('bukan_domain!!', '0.0.0.0', User::first()?->id, '127.0.0.1');
    }

    public function test_hosting_service_rejects_ttxt_dns_type(): void
    {
        $service = app(HostingService::class);

        $this->expectExceptionCode(422);
        $service->createDnsRecord('yuda.local', 'app', 'TXT', 'v=spf1', 3600, User::first()?->id, '127.0.0.1');
    }

    public function test_hosting_service_rejects_unknown_service_id(): void
    {
        $service = app(HostingService::class);

        $this->expectExceptionCode(422);
        $service->serviceControl('tidak-ada', 'restart', User::first()?->id, '127.0.0.1', true);
    }

    public function test_hosting_service_rejects_stop_protected_service_without_confirm(): void
    {
        $service = app(HostingService::class);

        $this->expectExceptionCode(422);
        $service->serviceControl('nginx', 'stop', User::first()?->id, '127.0.0.1', false);
    }

    public function test_hosting_service_rejects_dangerous_cron_command(): void
    {
        $service = app(HostingService::class);

        $this->expectExceptionCode(422);
        $service->createCronJob('Evil', '0 * * * *', 'rm -rf /', 'test', User::first()?->id, '127.0.0.1');
    }

    public function test_admin_can_create_cron_job_via_allowed_command_and_it_is_audited(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->postJson('/admin/hosting/cron', [
            'name' => 'Cache Clear Uji',
            'schedule' => '0 * * * *',
            'command' => 'php artisan cache:clear',
            'description' => 'Uji allowlist cron',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('hosting_cron_jobs', ['name' => 'Cache Clear Uji']);
        $this->assertDatabaseHas('hosting_audits', ['action' => 'cron.add', 'target' => $response->json('data.id')]);
    }

    public function test_admin_cannot_create_cron_job_with_shell_injection(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->postJson('/admin/hosting/cron', [
            'name' => 'Evil',
            'schedule' => '0 * * * *',
            'command' => 'php artisan cache:clear; rm -rf /',
            'description' => '',
        ]);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('hosting_cron_jobs', ['name' => 'Evil']);
    }

    public function test_sinkhole_model_persists_and_overview_includes_it(): void
    {
        $admin = User::first();
        $sinkhole = HostingSinkhole::create([
            'domain' => 'example-blocked.test',
            'target_ip' => '0.0.0.0',
            'enabled' => true,
            'created_by' => $admin->id,
        ]);

        $this->assertDatabaseHas('hosting_sinkholes', ['domain' => 'example-blocked.test']);

        $service = app(HostingService::class);
        $overview = $service->getOverview();

        $this->assertContains($sinkhole->domain, array_column($overview['sinkholes'], 'domain'));
        $this->assertContains($sinkhole->domain, array_column($overview['dnsRecords'], 'zone'));
    }

    public function test_mutations_return_503_when_ctl_not_installed(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->postJson('/admin/hosting/services/nginx/control', [
            'action' => 'restart',
            'confirm' => 0,
        ]);

        // Di CI/dev tanpa hosting-ctl, respons harus informatif bukan 500 misterius.
        $this->assertContains($response->getStatusCode(), [200, 503]);
        if ($response->getStatusCode() === 503) {
            $response->assertJsonPath('message', 'hosting-ctl belum terinstall di server. Jalankan sekali: sudo bash scripts/install-hosting-ctl.sh');
        }
    }

    public function test_toggle_vhost_rejects_protected_domains(): void
    {
        $admin = User::first();

        // yuda.local adalah recovery panel admin dan WAJIB ditolak (422)
        $responseLocal = $this->actingAs($admin)->postJson('/admin/hosting/vhosts/yuda.local/toggle', [
            'action' => 'suspend',
        ]);
        $responseLocal->assertStatus(422)
            ->assertJsonPath('ok', false);

        // great-yuda.my.id BISA disuspend (bukan domain dilindungi)
        $responseGreat = $this->actingAs($admin)->postJson('/admin/hosting/vhosts/great-yuda.my.id/toggle', [
            'action' => 'suspend',
        ]);
        $this->assertContains($responseGreat->getStatusCode(), [200, 503]);

        // Kembalikan ke unsuspend agar state kembali aktif
        $this->actingAs($admin)->postJson('/admin/hosting/vhosts/great-yuda.my.id/toggle', [
            'action' => 'unsuspend',
        ]);
    }

    public function test_toggle_vhost_validates_action_input(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->postJson('/admin/hosting/vhosts/yudzz-app/toggle', [
            'action' => 'destroy_completely',
        ]);
        $response->assertStatus(422);
    }

    public function test_overview_includes_aapanel_status(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->getJson('/admin/hosting/overview');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'aapanel' => ['connected', 'message'],
            'aapanelUrl',
        ]);
    }
}
