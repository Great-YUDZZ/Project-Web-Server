<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use DatabaseTransactions;

    public function test_blog_index_is_accessible_and_renders_published_posts(): void
    {
        $post = Post::published()->first();
        $this->assertNotNull($post);

        $response = $this->get('/blog');

        $response->assertStatus(200);
        $response->assertSee('Catatan rekayasa');
        $response->assertSee($post->title);
        $response->assertSee('Semua Kategori');
    }

    public function test_blog_detail_is_accessible_and_increments_views(): void
    {
        $post = Post::published()->first();
        $this->assertNotNull($post);

        $initialViews = $post->views_count;

        $response = $this->get('/blog/' . $post->slug);

        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSee($post->category);
        $response->assertSee('Kembali ke Katalog Jurnal');

        $this->assertEquals($initialViews + 1, $post->fresh()->views_count);
    }

    public function test_draft_posts_are_not_visible_to_public(): void
    {
        $draftPost = Post::create([
            'title' => 'Artikel Rahasia Belum Rilis',
            'slug' => 'artikel-rahasia-belum-rilis',
            'excerpt' => 'Artikel ini masih berstatus draft rahasia.',
            'content' => 'Konten internal yang belum dipublikasikan.',
            'category' => 'Sysadmin',
            'is_published' => false,
            'reading_time' => 3,
        ]);

        $responseIndex = $this->get('/blog');
        $responseIndex->assertStatus(200);
        $responseIndex->assertDontSee($draftPost->title);

        $responseDetail = $this->get('/blog/' . $draftPost->slug);
        $responseDetail->assertStatus(404);
    }

    public function test_blog_search_and_category_filter(): void
    {
        $response = $this->get('/blog?q=Debian');
        $response->assertStatus(200);

        $responseCat = $this->get('/blog?category=Linux+%26+Sysadmin');
        $responseCat->assertStatus(200);
    }

    public function test_footer_contains_blog_shortcut_link(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee(route('blog.index'));
        $response->assertSee('Blog Pribadi');
    }

    public function test_admin_posts_routes_require_authentication(): void
    {
        $response = $this->get('/admin/posts');
        $response->assertRedirect('/login');

        $responseCreate = $this->get('/admin/posts/create');
        $responseCreate->assertRedirect('/login');
    }

    public function test_admin_can_perform_full_post_crud_and_toggle_publish(): void
    {
        $admin = User::first() ?? User::factory()->create();

        $response = $this->actingAs($admin)->get('/admin/posts');
        $response->assertStatus(200);
        $response->assertSee('Daftar Artikel');

        $storeResponse = $this->actingAs($admin)->post('/admin/posts', [
            'title' => 'Pengujian Arsitektur Kernel Baru',
            'category' => 'Linux & Sysadmin',
            'excerpt' => 'Deskripsi ringkas pengujian performa arsitektur kernel.',
            'content' => "## Subheading Pengujian\n\nPenjelasan konfigurasi sysctl kernel.\n\n- Parameter 1\n- Parameter 2",
            'tags' => 'kernel, testing, sysctl',
            'is_published' => 1,
        ]);

        $storeResponse->assertRedirect('/admin/posts');
        $storeResponse->assertSessionHas('success');

        $createdPost = Post::where('title', 'Pengujian Arsitektur Kernel Baru')->first();
        $this->assertNotNull($createdPost);
        $this->assertEquals('pengujian-arsitektur-kernel-baru', $createdPost->slug);
        $this->assertTrue($createdPost->is_published);

        $toggleResponse = $this->actingAs($admin)->patch('/admin/posts/' . $createdPost->id . '/toggle-publish');
        $toggleResponse->assertRedirect();
        $this->assertFalse($createdPost->fresh()->is_published);

        $updateResponse = $this->actingAs($admin)->put('/admin/posts/' . $createdPost->id, [
            'title' => 'Pengujian Arsitektur Kernel Revisi',
            'slug' => 'pengujian-arsitektur-kernel-revisi',
            'category' => 'Networking',
            'excerpt' => 'Revisi deskripsi ringkas.',
            'content' => 'Konten revisi pengujian kernel.',
            'tags' => 'kernel, revised',
            'is_published' => 1,
        ]);

        $updateResponse->assertRedirect('/admin/posts');
        $this->assertEquals('Pengujian Arsitektur Kernel Revisi', $createdPost->fresh()->title);

        $deleteResponse = $this->actingAs($admin)->delete('/admin/posts/' . $createdPost->id);
        $deleteResponse->assertRedirect('/admin/posts');
        $this->assertNull(Post::find($createdPost->id));
    }
}
