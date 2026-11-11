<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Message;
use App\Models\Post;
use App\Models\Project;
use App\Models\Skill;
use App\Services\ServerMonitorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PublicController extends Controller
{
    /**
     * Display the public landing page (Dark Portfolio Architecture).
     */
    public function index(ServerMonitorService $monitor)
    {
        $skills = Skill::orderBy('category')->orderByDesc('level')->get();

        $heroProjects = Project::hero()->take(2)->get();
        if ($heroProjects->count() < 2) {
            $fallback = Project::featured()
                ->whereNotIn('id', $heroProjects->pluck('id'))
                ->take(2 - $heroProjects->count())
                ->get();
            $heroProjects = $heroProjects->concat($fallback);
        }

        $featuredProjects = Project::featured()->orderBy('order')->get();
        if ($featuredProjects->isEmpty()) {
            $featuredProjects = Project::orderBy('order')->get();
        }

        $certificates = Certificate::featured()
            ->orderBy('order')
            ->latest()
            ->get();

        if ($certificates->isEmpty()) {
            $certificates = Certificate::orderBy('order')->latest()->get();
        }

        $serverMetrics = $monitor->getAllMetrics();
        $projectsCount = Project::count();

        return view('home', compact('skills', 'heroProjects', 'featuredProjects', 'certificates', 'serverMetrics', 'projectsCount'));
    }

    /**
     * Display the archived classic earth-tone portfolio (2024-2025).
     */
    public function classicArchive(ServerMonitorService $monitor)
    {
        $skills = Skill::orderBy('category')->orderByDesc('level')->get();

        $heroProjects = Project::hero()->take(2)->get();
        if ($heroProjects->count() < 2) {
            $fallback = Project::featured()
                ->whereNotIn('id', $heroProjects->pluck('id'))
                ->take(2 - $heroProjects->count())
                ->get();
            $heroProjects = $heroProjects->concat($fallback);
        }

        $featuredProjects = Project::featured()->get();
        if ($featuredProjects->isEmpty()) {
            $featuredProjects = Project::orderBy('order')->latest()->take(6)->get();
        }

        $certificates = Certificate::featured()
            ->orderBy('order')
            ->latest()
            ->get();

        if ($certificates->isEmpty()) {
            $certificates = Certificate::orderBy('order')->latest()->get();
        }

        $categories = [
            'networking' => $skills->where('category', 'networking'),
            'sysadmin' => $skills->where('category', 'sysadmin'),
            'hardware' => $skills->where('category', 'hardware'),
            'tools' => $skills->where('category', 'tools'),
        ];

        $stats = [
            'total_projects' => Project::count(),
            'total_skills' => Skill::count(),
            'total_certificates' => Certificate::count(),
            'network_labs' => Project::where('category', 'like', '%Network%')->count(),
            'server_labs' => Project::where('category', 'like', '%Sysadmin%')->orWhere('category', 'like', '%Virtual%')->count(),
        ];
        $serverMetrics = $monitor->getAllMetrics();

        return view('archive.classic.home', compact('skills', 'heroProjects', 'featuredProjects', 'categories', 'stats', 'certificates', 'serverMetrics'));
    }

    /**
     * Return real-time server telemetry metrics for public engineering proof.
     */
    public function telemetry(ServerMonitorService $monitor): JsonResponse
    {
        if (auth()->check()) {
            return response()->json($monitor->getAllMetrics());
        }

        return response()->json($monitor->getPublicMetrics());
    }

    /**
     * Display all projects catalog with filters.
     */
    public function projects(Request $request)
    {
        $query = Project::query();

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('tools_used', 'like', "%{$search}%");
            });
        }

        if ($category = $request->input('category')) {
            if ($category !== 'all') {
                $query->where('category', $category);
            }
        }

        $projects = $query->latest()->paginate(9)->withQueryString();
        $categories = Project::select('category')->distinct()->pluck('category');

        return view('projects.index', compact('projects', 'categories'));
    }

    /**
     * Display single project detail.
     */
    public function projectDetail(string $slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        $relatedProjects = Project::where('id', '!=', $project->id)
            ->where('category', $project->category)
            ->take(3)
            ->get();

        if ($relatedProjects->isEmpty()) {
            $relatedProjects = Project::where('id', '!=', $project->id)->latest()->take(3)->get();
        }

        return view('projects.show', compact('project', 'relatedProjects'));
    }

    /**
     * Display personal blog catalog.
     */
    public function blog(Request $request)
    {
        $query = Post::published();

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        if ($category = $request->input('category')) {
            if ($category !== 'all') {
                $query->where('category', $category);
            }
        }

        $featuredPost = null;
        if (!$request->filled('q') && (!$request->filled('category') || $request->input('category') === 'all')) {
            $featuredPost = (clone $query)->latest('published_at')->first();
        }

        if ($featuredPost) {
            $posts = $query->where('id', '!=', $featuredPost->id)->latest('published_at')->paginate(6)->withQueryString();
        } else {
            $posts = $query->latest('published_at')->paginate(6)->withQueryString();
        }

        $categories = Post::published()->select('category')->distinct()->pluck('category');
        $totalPostsCount = Post::published()->count();

        return view('blog.index', compact('posts', 'featuredPost', 'categories', 'totalPostsCount'));
    }

    /**
     * Display personal blog article reader.
     */
    public function blogDetail(Request $request, string $slug)
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        // Anti-Spam: Cegah penggelembungan views_count dan spam query UPDATE ke database
        $viewedKey = 'viewed_post_'.$post->id;
        $ipKey = 'post_view_'.$post->id.'_'.$request->ip();
        if (! session()->has($viewedKey) && ! Cache::has($ipKey)) {
            $post->increment('views_count');
            session()->put($viewedKey, true);
            Cache::put($ipKey, true, now()->addMinutes(30));
        }

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($relatedPosts->isEmpty()) {
            $relatedPosts = Post::published()
                ->where('id', '!=', $post->id)
                ->latest('published_at')
                ->take(3)
                ->get();
        }

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    /**
     * Download client DNS setup script for Linux/macOS (restricted to private LAN & loopback).
     */
    public function clientDnsScriptLinux(Request $request)
    {
        $this->assertPrivateNetworkRequest($request);

        $path = resource_path('scripts/dns.sh');
        if (! file_exists($path)) {
            abort(404);
        }

        return response(file_get_contents($path), 200, [
            'Content-Type' => 'text/x-shellscript; charset=utf-8',
            'Content-Disposition' => 'inline; filename="dns.sh"',
        ]);
    }

    /**
     * Download client DNS setup script for Windows PowerShell (restricted to private LAN & loopback).
     */
    public function clientDnsScriptWindows(Request $request)
    {
        $this->assertPrivateNetworkRequest($request);

        $path = resource_path('scripts/dns.ps1');
        if (! file_exists($path)) {
            abort(404);
        }

        return response(file_get_contents($path), 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
            'Content-Disposition' => 'inline; filename="dns.ps1"',
        ]);
    }

    /**
     * Ensure request originates from LAN or loopback IP.
     */
    private function assertPrivateNetworkRequest(Request $request): void
    {
        $ip = $request->ip();
        $isLocal = in_array($ip, ['127.0.0.1', '::1'], true) ||
            filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;

        if (! $isLocal && ! auth()->check()) {
            abort(403, 'Akses skrip otomatisasi DNS dibatasi khusus untuk jaringan LAN / lokal.');
        }
    }

    /**
     * Handle incoming contact form message.
     */
    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'sender_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $validated['sender_name'] = strip_tags(trim($validated['sender_name']));
        $validated['subject'] = strip_tags(trim($validated['subject']));
        $validated['message'] = strip_tags(trim($validated['message']));

        Message::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesan berhasil terkirim ke Inbox Admin TKJ. Terima kasih atas kontak Anda!',
            ]);
        }

        return back()->with('success', 'Pesan Anda telah berhasil terkirim ke Admin TKJ. Terima kasih!')->withFragment('contact');
    }
}
