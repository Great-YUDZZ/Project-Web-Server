<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Skill;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DarkPortfolioTest extends TestCase
{
    use DatabaseTransactions;

    public function test_dark_preview_route_returns_ok_and_renders_landing_page(): void
    {
        $response = $this->get('/dark-preview');

        $response->assertStatus(200);
        $response->assertSee('I Made Yuda Pramana');
        $response->assertDontSee("KOLEKSI '26", false);
        $response->assertSee('dark-portfolio-root');
        $response->assertSee('dark-loading-screen');
        $response->assertSee('hero-hls-video');
        $response->assertSee('footer-hls-video');
        $response->assertSee('Unggulan');
        $response->assertSee('technologies');
        $response->assertSee('Teknologi');
        $response->assertSee('tech-circle-orb');
        $response->assertSee('tech-modal-overlay');
        $response->assertSee('Laravel');
        $response->assertSee('Tailwind');
        $response->assertSee('Vite');
        $response->assertSee('GSAP');
        $response->assertSee('Nginx');
        $response->assertSee('Debian');
        $response->assertSee('MySQL');
        $response->assertSee('Three.js');
        $response->assertSee("PORTFOLIO '26", false);
        $response->assertSee('skills');
        $response->assertSee('TECH STACK PEMBUATAN');
        $response->assertSee('Go 1.25+');
        $response->assertSee('Fyne GUI');
        $response->assertSee('Electron');
        $response->assertSee('Flutter 3.x');
    }
}
