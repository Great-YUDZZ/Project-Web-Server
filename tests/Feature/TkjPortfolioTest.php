<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TkjPortfolioTest extends TestCase
{
    public function test_home_page_is_accessible_and_renders_skills_and_projects(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('YUDA_PRATAMA');
        $response->assertSee('Skill Matrix');
        $response->assertSee('Showcase Proyek');
    }

    public function test_projects_archive_page_is_accessible(): void
    {
        $response = $this->get('/projects');

        $response->assertStatus(200);
        $response->assertSee('Dokumentasi Lab');
    }

    public function test_project_detail_page_is_accessible(): void
    {
        $project = Project::first();
        $this->assertNotNull($project);

        $response = $this->get('/projects/' . $project->slug);

        $response->assertStatus(200);
        $response->assertSee($project->title);
        $response->assertSee('DIAGRAM_TOPOLOGI_JARINGAN');
    }

    public function test_contact_form_submission_creates_message_in_database(): void
    {
        $data = [
            'sender_name' => 'Budi Santoso (Guru Penguji TKJ)',
            'email'       => 'budi@smk-bisa.sch.id',
            'subject'     => 'Uji Kompetensi Kejuruan Jaringan',
            'message'     => 'Dokumentasi lab OSPF dan LEMP sangat terstruktur. Siap untuk sidang UKK.',
        ];

        $response = $this->post('/contact', $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('messages', [
            'email'       => 'budi@smk-bisa.sch.id',
            'sender_name' => 'Budi Santoso (Guru Penguji TKJ)',
            'is_read'     => false,
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
            'email'    => 'admin@tkj.lan',
            'password' => 'AdminTKJ2026!',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_admin_can_create_new_skill(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->post('/admin/skills', [
            'name'     => 'Docker Containerization for Web Apps',
            'category' => 'sysadmin',
            'level'    => 88,
        ]);

        $response->assertRedirect(route('admin.skills.index'));
        $this->assertDatabaseHas('skills', [
            'name'     => 'Docker Containerization for Web Apps',
            'category' => 'sysadmin',
            'level'    => 88,
        ]);
    }

    public function test_admin_can_create_new_project_with_topology_image(): void
    {
        Storage::fake('public');
        $admin = User::first();

        $file = UploadedFile::fake()->image('topology-lab.png', 800, 600);

        $response = $this->actingAs($admin)->post('/admin/projects', [
            'title'          => 'Implementasi BGP Peering Multi-Homing',
            'category'       => 'Networking',
            'description'    => 'Konfigurasi BGP AS 64512 dan AS 64513 dengan eBGP multi-hop pada MikroTik RouterOS v7.',
            'tools_used'     => 'MikroTik CCR, BGP, Wireshark',
            'demo_link'      => 'https://github.com/example/bgp-lab',
            'is_featured'    => true,
            'topology_image' => $file,
        ]);

        $response->assertRedirect(route('admin.projects.index'));
        $this->assertDatabaseHas('projects', [
            'title'    => 'Implementasi BGP Peering Multi-Homing',
            'category' => 'Networking',
        ]);
    }

    public function test_admin_can_view_and_toggle_message_read_status(): void
    {
        $admin = User::first();
        $message = Message::create([
            'sender_name' => 'Penguji Industri',
            'email'       => 'tester@isp.net.id',
            'subject'     => 'Tes Kualifikasi Jaringan',
            'message'     => 'Lanjut ke tahap interview teknis.',
            'is_read'     => false,
        ]);

        // Viewing message marks it as read
        $response = $this->actingAs($admin)->get('/admin/messages/' . $message->id);
        $response->assertStatus(200);
        $this->assertTrue($message->fresh()->is_read);

        // Toggle back to unread
        $toggleResponse = $this->actingAs($admin)->patch('/admin/messages/' . $message->id . '/toggle-read');
        $toggleResponse->assertRedirect();
        $this->assertFalse($message->fresh()->is_read);
    }
}
