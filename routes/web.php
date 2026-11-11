<?php

use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HostingController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\PostMediaController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Guest & Visitors)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/dark-preview', [PublicController::class, 'index'])->name('dark.preview');
Route::get('/archive/classic', [PublicController::class, 'classicArchive'])->name('archive.classic');
Route::get('/projects', [PublicController::class, 'projects'])->name('projects.index');
Route::get('/projects/{slug}', [PublicController::class, 'projectDetail'])->name('projects.show');
Route::get('/blog', [PublicController::class, 'blog'])->name('blog.index');
Route::get('/blog/{slug}', [PublicController::class, 'blogDetail'])->name('blog.show');
Route::get('/ai', [ChatbotController::class, 'index'])->name('ai.index');
Route::get('/dns.sh', [PublicController::class, 'clientDnsScriptLinux'])->name('dns.script.sh');
Route::get('/dns.ps1', [PublicController::class, 'clientDnsScriptWindows'])->name('dns.script.ps1');
Route::post('/contact', [PublicController::class, 'contactSubmit'])->middleware('throttle:10,1')->name('contact.submit');
Route::post('/chatbot/message', [ChatbotController::class, 'handle'])->middleware('throttle:30,1')->name('chatbot.message');
Route::get('/api/telemetry', [PublicController::class, 'telemetry'])->middleware('throttle:60,1')->name('api.telemetry');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Admin Panel Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/server-metrics', [DashboardController::class, 'serverMetrics'])->name('dashboard.server-metrics');

    // Hosting & cPanel (lokal + sinkhole DNS), hanya auth admin
    Route::get('/hosting', [HostingController::class, 'index'])->name('hosting.index');
    Route::get('/hosting/overview', [HostingController::class, 'overview'])->name('hosting.overview')->middleware('throttle:60,1');
    Route::post('/hosting/services/heal', [HostingController::class, 'healAll'])->name('hosting.services.heal')->middleware('throttle:10,1');
    Route::post('/hosting/services/{id}/control', [HostingController::class, 'controlService'])->name('hosting.services.control')->middleware('throttle:30,1');
    Route::post('/hosting/sinkholes', [HostingController::class, 'storeSinkhole'])->name('hosting.sinkholes.store')->middleware('throttle:20,1');
    Route::delete('/hosting/sinkholes/{domain}', [HostingController::class, 'destroySinkhole'])->name('hosting.sinkholes.destroy')->middleware('throttle:20,1');
    Route::post('/hosting/vhosts/{domain}/toggle', [HostingController::class, 'toggleVhost'])->name('hosting.vhosts.toggle')->middleware('throttle:30,1');
    Route::post('/hosting/dns-records', [HostingController::class, 'storeDnsRecord'])->name('hosting.dns.store')->middleware('throttle:20,1');
    Route::delete('/hosting/dns-records', [HostingController::class, 'destroyDnsRecord'])->name('hosting.dns.destroy')->middleware('throttle:20,1');
    Route::post('/hosting/nginx', [HostingController::class, 'saveNginx'])->name('hosting.nginx.save')->middleware('throttle:5,1');
    Route::post('/hosting/firewall/toggle', [HostingController::class, 'toggleFirewall'])->name('hosting.firewall.toggle')->middleware('throttle:10,1');
    Route::post('/hosting/firewall/rules', [HostingController::class, 'storeFirewallRule'])->name('hosting.firewall.store')->middleware('throttle:20,1');
    Route::delete('/hosting/firewall/rules', [HostingController::class, 'destroyFirewallRule'])->name('hosting.firewall.destroy')->middleware('throttle:20,1');
    Route::post('/hosting/cron', [HostingController::class, 'storeCron'])->name('hosting.cron.store')->middleware('throttle:20,1');
    Route::post('/hosting/cron/{id}/run', [HostingController::class, 'runCron'])->name('hosting.cron.run')->middleware('throttle:10,1');
    Route::delete('/hosting/cron/{id}', [HostingController::class, 'destroyCron'])->name('hosting.cron.destroy')->middleware('throttle:20,1');
    Route::post('/hosting/databases', [HostingController::class, 'storeDatabase'])->name('hosting.databases.store')->middleware('throttle:10,1');
    Route::delete('/hosting/databases/{name}', [HostingController::class, 'destroyDatabase'])->name('hosting.databases.destroy')->middleware('throttle:5,1');
    Route::post('/hosting/databases/backup', [HostingController::class, 'backupDatabase'])->name('hosting.databases.backup')->middleware('throttle:3,1');

    // CRUD Projects
    Route::patch('/projects/{project}/toggle-hero', [ProjectController::class, 'toggleHero'])->name('projects.toggle-hero');
    Route::patch('/projects/{project}/toggle-featured', [ProjectController::class, 'toggleFeatured'])->name('projects.toggle-featured');
    Route::resource('projects', ProjectController::class);

    // CRUD Skills
    Route::resource('skills', SkillController::class);

    // CRUD Certificates
    Route::resource('certificates', CertificateController::class);

    // CRUD Posts (Blog)
    Route::patch('/posts/{post}/toggle-publish', [AdminPostController::class, 'togglePublish'])->name('posts.toggle-publish');
    Route::resource('posts', AdminPostController::class);

    // CRUD Post Media (Foto & Video)
    Route::post('/posts/media/upload', [PostMediaController::class, 'store'])->name('posts.media.upload');
    Route::patch('/posts/media/{media}', [PostMediaController::class, 'update'])->name('posts.media.update');
    Route::delete('/posts/media/{media}', [PostMediaController::class, 'destroy'])->name('posts.media.destroy');
    Route::post('/posts/media/reorder', [PostMediaController::class, 'reorder'])->name('posts.media.reorder');

    // Messages Inbox
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::patch('/messages/{message}/toggle-read', [MessageController::class, 'toggleRead'])->name('messages.toggle-read');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
});
