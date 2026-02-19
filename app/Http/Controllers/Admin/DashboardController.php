<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Service;
use App\Models\Project;
use App\Models\Message;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'total_services' => Service::count(),
            'total_projects' => Project::count(),
            'new_messages' => Message::where('status', 'new')->count(),
            'recent_posts' => Post::latest()->take(5)->get(),
            'recent_messages' => Message::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
