<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TkjPortfolioTest extends TestCase
{
    use DatabaseTransactions;

    public function test_home_page_is_accessible_and_renders_skills_and_projects(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('I Made Yuda Pramana');
        $response->assertSee('Skill Matrix');
        $response->assertSee('Showcase Lab');
    }

    public function test_projects_archive_page_is_accessible(): void
    {
        $response = $this->get('/projects');

        $response->assertStatus(200);
        $response->assertSee('Dokumentasi lab');
    }

    public function test_project_detail_page_is_accessible(): void
    {
        $project = Project::first() ?? Project::create([
            'title' => 'Topologi Lab Uji Jaringan',
            'slug' => 'topologi-lab-uji-jaringan',
            'category' => 'Networking',
            'description' => 'Dokumentasi topologi lab uji.',
            'tools_used' => 'Cisco, Wireshark',
        ]);
        $this->assertNotNull($project);

        $response = $this->get('/projects/'.$project->slug);

        $response->assertStatus(200);
        $response->assertSee($project->title);
    }

    public function test_contact_form_submission_creates_message_in_database(): void
    {
        $data = [
            'sender_name' => 'Budi Santoso (Guru Penguji TKJ)',
            'email' => 'budi@smk-bisa.sch.id',
            'subject' => 'Uji Kompetensi Kejuruan Jaringan',
            'message' => 'Dokumentasi lab OSPF dan LEMP sangat terstruktur. Siap untuk sidang UKK.',
        ];

        $response = $this->post('/contact', $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('messages', [
            'email' => 'budi@smk-bisa.sch.id',
            'sender_name' => 'Budi Santoso (Guru Penguji TKJ)',
            'is_read' => false,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@tkj.lan',
            'password' => 'AdminTKJ2026!',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_admin_can_create_new_skill(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->post('/admin/skills', [
            'name' => 'Docker Containerization for Web Apps',
            'category' => 'sysadmin',
            'level' => 88,
        ]);

        $response->assertRedirect(route('admin.skills.index'));
        $this->assertDatabaseHas('skills', [
            'name' => 'Docker Containerization for Web Apps',
            'category' => 'sysadmin',
            'level' => 88,
        ]);
    }

    public function test_admin_can_create_new_project_with_topology_image(): void
    {
        Storage::fake('public');
        $admin = User::first();

        $file = UploadedFile::fake()->image('topology-lab.png', 800, 600);

        $response = $this->actingAs($admin)->post('/admin/projects', [
            'title' => 'Implementasi BGP Peering Multi-Homing',
            'category' => 'Networking',
            'description' => 'Konfigurasi BGP AS 64512 dan AS 64513 dengan eBGP multi-hop pada MikroTik RouterOS v7.',
            'tools_used' => 'MikroTik CCR, BGP, Wireshark',
            'demo_link' => 'https://github.com/example/bgp-lab',
            'is_featured' => true,
            'topology_image' => $file,
        ]);

        $response->assertRedirect(route('admin.projects.index'));
        $this->assertDatabaseHas('projects', [
            'title' => 'Implementasi BGP Peering Multi-Homing',
            'category' => 'Networking',
        ]);
    }

    public function test_admin_can_view_and_toggle_message_read_status(): void
    {
        $admin = User::first();
        $message = Message::create([
            'sender_name' => 'Penguji Industri',
            'email' => 'tester@isp.net.id',
            'subject' => 'Tes Kualifikasi Jaringan',
            'message' => 'Lanjut ke tahap interview teknis.',
            'is_read' => false,
        ]);

        // Viewing message marks it as read
        $response = $this->actingAs($admin)->get('/admin/messages/'.$message->id);
        $response->assertStatus(200);
        $this->assertTrue($message->fresh()->is_read);

        // Toggle back to unread
        $toggleResponse = $this->actingAs($admin)->patch('/admin/messages/'.$message->id.'/toggle-read');
        $toggleResponse->assertRedirect();
        $this->assertFalse($message->fresh()->is_read);
    }

    public function test_admin_dashboard_renders_server_monitoring_metrics(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Live Telemetry', false);
        $response->assertSee('Status Server', false);
        $response->assertSee('Beban CPU');
        $response->assertSee('Memori');
        $response->assertSee('Disk');
        $response->assertSee('MariaDB');
        $response->assertSee('Live');
        $response->assertSee('btn-toggle-live');
    }

    public function test_admin_can_fetch_live_server_metrics_via_json(): void
    {
        // Unauthenticated access must redirect to login
        $guestResponse = $this->getJson('/admin/dashboard/server-metrics');
        $guestResponse->assertStatus(401);

        $admin = User::first();
        $response = $this->actingAs($admin)->getJson('/admin/dashboard/server-metrics');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'system' => [
                'cpu' => ['cores', 'load_1m', 'load_5m', 'load_15m', 'percent', 'status'],
                'ram' => ['total_mb', 'used_mb', 'available_mb', 'total_formatted', 'used_formatted', 'free_formatted', 'percent', 'status'],
                'disk' => ['total_formatted', 'used_formatted', 'free_formatted', 'percent', 'status'],
                'uptime' => ['seconds', 'formatted'],
            ],
            'services' => [
                'database' => ['status', 'label', 'latency_ms', 'version', 'driver'],
                'php_fpm' => ['status', 'label', 'version', 'sapi', 'socket', 'opcache'],
                'web_server' => ['status', 'label', 'software', 'port'],
            ],
            'host' => ['hostname', 'os', 'kernel', 'arch', 'server_ip', 'php_version'],
        ]);

        // Second call exercises instant CPU /proc/stat delta logic
        $secondResponse = $this->actingAs($admin)->getJson('/admin/dashboard/server-metrics');
        $secondResponse->assertStatus(200);
        $this->assertIsNumeric($secondResponse->json('system.cpu.percent'));
    }

    public function test_admin_can_view_certificates_index(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->get('/admin/certificates');

        $response->assertStatus(200);
        $response->assertSee('Kredensial &amp; Sertifikasi Resmi', false);
        $response->assertSee('+ TAMBAH SERTIFIKAT');
    }

    public function test_admin_can_create_new_certificate_with_file(): void
    {
        Storage::fake('public');
        $admin = User::first();

        $fakePdf = UploadedFile::fake()->create('sertifikat-uji.pdf', 100, 'application/pdf');

        $response = $this->actingAs($admin)->post('/admin/certificates', [
            'title' => 'MikroTik Certified Network Associate (MTCNA)',
            'issuer' => 'MikroTik Training Center',
            'credential_id' => 'MTCNA-2026-998811',
            'issued_date' => 'Desember 2026',
            'duration_hours' => '24 Jam',
            'verification_status' => 'Certified Valid',
            'description' => 'Routing, Bridging, Wireless, Network Management.',
            'credential_url' => 'https://mikrotik.com/certificate/verify',
            'order' => 1,
            'is_featured' => true,
            'certificate_file' => $fakePdf,
        ]);

        $response->assertRedirect(route('admin.certificates.index'));
        $this->assertDatabaseHas('certificates', [
            'title' => 'MikroTik Certified Network Associate (MTCNA)',
            'credential_id' => 'MTCNA-2026-998811',
        ]);
    }

    public function test_admin_can_update_certificate(): void
    {
        $admin = User::first();
        $certificate = Certificate::create([
            'title' => 'Sertifikat Awal',
            'issuer' => 'Lembaga Awal',
            'credential_id' => 'ID-AWAL-01',
            'order' => 5,
            'is_featured' => true,
        ]);

        $response = $this->actingAs($admin)->put('/admin/certificates/'.$certificate->id, [
            'title' => 'Sertifikat Diperbarui',
            'issuer' => 'Lembaga Diperbarui',
            'credential_id' => 'ID-BARU-02',
            'order' => 1,
            'is_featured' => false,
        ]);

        $response->assertRedirect(route('admin.certificates.index'));
        $this->assertDatabaseHas('certificates', [
            'id' => $certificate->id,
            'title' => 'Sertifikat Diperbarui',
            'is_featured' => false,
        ]);
    }

    public function test_admin_can_delete_certificate(): void
    {
        $admin = User::first();
        $certificate = Certificate::create([
            'title' => 'Sertifikat Akan Dihapus',
            'issuer' => 'Instansi Hapus',
            'credential_id' => 'DEL-001',
        ]);

        $response = $this->actingAs($admin)->delete('/admin/certificates/'.$certificate->id);

        $response->assertRedirect(route('admin.certificates.index'));
        $this->assertDatabaseMissing('certificates', [
            'id' => $certificate->id,
        ]);
    }

    public function test_home_page_displays_database_certificates(): void
    {
        $certificate = Certificate::first();
        $this->assertNotNull($certificate);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee($certificate->title);
    }
}
