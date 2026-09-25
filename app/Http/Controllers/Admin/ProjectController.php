<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::query();

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('tools_used', 'like', "%{$search}%");
            });
        }

        $projects = $query->orderBy('order')->latest()->paginate(15)->withQueryString();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:projects,slug'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'tools_used' => ['nullable', 'string', 'max:255'],
            'demo_link' => ['nullable', 'url', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
            'is_hero' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
            'topology_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
        ]);

        if (empty($validated['slug'])) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $count = 1;
            while (Project::where('slug', $slug)->exists()) {
                $slug = $baseSlug.'-'.$count++;
            }
            $validated['slug'] = $slug;
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_hero'] = $request->boolean('is_hero');
        $validated['order'] = (int) $request->input('order', 0);

        if ($request->hasFile('topology_image')) {
            $path = $request->file('topology_image')->store('topologies', 'public');
            $validated['topology_image'] = $path;
        }

        Project::create($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Dokumentasi proyek/lab berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:projects,slug,'.$project->id],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'tools_used' => ['nullable', 'string', 'max:255'],
            'demo_link' => ['nullable', 'url', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
            'is_hero' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
            'topology_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_hero'] = $request->boolean('is_hero');
        $validated['order'] = (int) $request->input('order', 0);

        if ($request->hasFile('topology_image')) {
            // Remove old image if stored in public disk
            if ($project->topology_image && ! Str::startsWith($project->topology_image, ['http://', 'https://', '/images/'])) {
                Storage::disk('public')->delete($project->topology_image);
            }

            $path = $request->file('topology_image')->store('topologies', 'public');
            $validated['topology_image'] = $path;
        }

        $project->update($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Data proyek/lab berhasil diperbarui.');
    }

    /**
     * Toggle Hero status.
     */
    public function toggleHero(Project $project)
    {
        $project->update(['is_hero' => ! $project->is_hero]);
        $status = $project->is_hero ? 'dipin ke Hero Header Beranda' : 'dilepas dari Hero Header';

        return back()->with('success', "Proyek {$project->title} berhasil {$status}.");
    }

    /**
     * Toggle Featured status.
     */
    public function toggleFeatured(Project $project)
    {
        $project->update(['is_featured' => ! $project->is_featured]);
        $status = $project->is_featured ? 'dijadikan Proyek Unggulan' : 'dihapus dari Proyek Unggulan';

        return back()->with('success', "Proyek {$project->title} berhasil {$status}.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->topology_image && ! Str::startsWith($project->topology_image, ['http://', 'https://', '/images/'])) {
            Storage::disk('public')->delete($project->topology_image);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Proyek/lab berhasil dihapus.');
    }
}
