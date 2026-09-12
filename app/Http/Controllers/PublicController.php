<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Message;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display the public landing page.
     */
    public function index()
    {
        $skills = Skill::orderBy('category')->orderByDesc('level')->get();

        $featuredProjects = Project::where('is_featured', true)
            ->latest()
            ->take(4)
            ->get();

        if ($featuredProjects->isEmpty()) {
            $featuredProjects = Project::latest()->take(4)->get();
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

        return view('home', compact('skills', 'featuredProjects', 'categories', 'stats', 'certificates'));
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
