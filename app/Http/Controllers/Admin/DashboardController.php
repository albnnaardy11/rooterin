<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Service;
use App\Models\Project;
use App\Models\Message;
use App\Models\VisitorLog;
use App\Services\Seo\GoogleSearchConsoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $gscService;

    public function __construct(GoogleSearchConsoleService $gscService)
    {
        $this->gscService = $gscService;
    }

    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'total_services' => Service::count(),
            'total_projects' => Project::count(),
            'new_messages' => Message::where('status', 'new')->count(),
            'recent_posts' => Post::latest()->take(5)->get(),
            'recent_messages' => Message::latest()->take(5)->get(),
            
            // Local Analytics
            'total_views' => VisitorLog::count(),
            'views_today' => VisitorLog::whereDate('visited_at', today())->count(),
            'top_pages' => VisitorLog::select('url', DB::raw('count(*) as total'))
                            ->groupBy('url')
                            ->orderByDesc('total')
                            ->take(5)
                            ->get(),
            'visitor_chart' => $this->getVisitorChartData(),

            // Google Search Console integration
            'gsc' => $this->getGscStats()
        ];

        return view('admin.dashboard', compact('stats'));
    }

    private function getGscStats()
    {
        $performance = $this->gscService->getPerformanceStats(30);
        
        if (!$performance['active']) {
            return ['active' => false];
        }

        $labels = [];
        $clicks = [];
        $impressions = [];

        foreach ($performance['rows'] as $row) {
            $labels[] = date('M d', strtotime($row->getKeys()[0]));
            $clicks[] = $row->getClicks();
            $impressions[] = $row->getImpressions();
        }

        return [
            'active' => true,
            'labels' => $labels,
            'clicks' => $clicks,
            'impressions' => $impressions,
            'top_queries' => $this->gscService->getTopQueries(5)
        ];
    }

    private function getVisitorChartData()
    {
        $data = VisitorLog::select(
            DB::raw('DATE(visited_at) as date'),
            DB::raw('count(*) as total')
        )
        ->where('visited_at', '>=', now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        return [
            'labels' => $data->pluck('date')->map(fn($d) => date('M d', strtotime($d))),
            'values' => $data->pluck('total'),
        ];
    }
}
