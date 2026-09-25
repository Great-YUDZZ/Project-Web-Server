<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Message;
use App\Models\Project;
use App\Models\Skill;
use App\Services\ServerMonitorService;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(ServerMonitorService $monitor)
    {
        $totalProjects = Project::count();
        $totalSkills = Skill::count();
        $totalCertificates = Certificate::count();
        $totalMessages = Message::count();
        $unreadMessages = Message::unread()->count();

        $recentProjects = Project::latest()->take(5)->get();
        $recentMessages = Message::latest()->take(5)->get();
        $certificates = Certificate::orderBy('order')->latest()->take(6)->get();

        $skillsByCategory = [
            'networking' => Skill::where('category', 'networking')->count(),
            'sysadmin' => Skill::where('category', 'sysadmin')->count(),
            'hardware' => Skill::where('category', 'hardware')->count(),
            'tools' => Skill::where('category', 'tools')->count(),
        ];

        $serverMetrics = $monitor->getAllMetrics();

        return view('admin.dashboard', compact(
            'totalProjects',
            'totalSkills',
            'totalCertificates',
            'totalMessages',
            'unreadMessages',
            'recentProjects',
            'recentMessages',
            'certificates',
            'skillsByCategory',
            'serverMetrics'
        ));
    }

    /**
     * Return real-time server metrics as JSON for live AJAX monitoring.
     */
    public function serverMetrics(ServerMonitorService $monitor): JsonResponse
    {
        return response()->json($monitor->getAllMetrics());
    }
}
