<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $totalProjects = Project::count();
        $totalSkills   = Skill::count();
        $totalMessages = Message::count();
        $unreadMessages = Message::unread()->count();

        $recentProjects = Project::latest()->take(5)->get();
        $recentMessages = Message::latest()->take(5)->get();

        $skillsByCategory = [
            'networking' => Skill::where('category', 'networking')->count(),
            'sysadmin'   => Skill::where('category', 'sysadmin')->count(),
            'hardware'   => Skill::where('category', 'hardware')->count(),
            'tools'      => Skill::where('category', 'tools')->count(),
        ];

        return view('admin.dashboard', compact(
            'totalProjects',
            'totalSkills',
            'totalMessages',
            'unreadMessages',
            'recentProjects',
            'recentMessages',
            'skillsByCategory'
        ));
    }
}
