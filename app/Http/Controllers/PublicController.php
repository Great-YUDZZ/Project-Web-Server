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
        return response()->json($monitor->getAllMetrics());
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
    public function blogDetail(string $slug)
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();
        $post->increment('views_count');

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
