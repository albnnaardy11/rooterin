<?php

namespace App\Repositories\Eloquent;

use App\Models\AiDiagnose;
use App\Models\EventLog;
use App\Repositories\Contracts\AiIntelligenceRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class AiIntelligenceRepository implements AiIntelligenceRepositoryInterface
{
    public function getHeatmapData()
    {
        // Cache for 5 mins to prevent DB strain while maintaining 'near-live' feel
        return Cache::remember('ai_intelligence_heatmap_v2', 300, function () {
            return AiDiagnose::select('latitude', 'longitude', 'final_deep_score', 'diagnose_id', 'result_label', 'city_location')
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->orderBy('created_at', 'desc')
                ->limit(500) // Support up to 500 active hotspots
                ->get();
        });
    }

    public function getMaterialDistribution()
    {
        return AiDiagnose::select('material_type', DB::raw('count(*) as total'))
            ->groupBy('material_type')
            ->get();
    }

    public function getContextualStats()
    {
        return AiDiagnose::select('location_context', 'result_label', DB::raw('count(*) as total'))
            ->groupBy('location_context', 'result_label')
            ->get();
    }

    public function getAnomaliesTimeline()
    {
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        return AiDiagnose::where('created_at', '>=', $thirtyDaysAgo)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    }

    public function getRegionalLeaderboard()
    {
        return AiDiagnose::select('city_location', DB::raw('count(*) as total'), DB::raw('SUM(CASE WHEN final_deep_score = "A" THEN 1 ELSE 0 END) as high_severity'))
            ->groupBy('city_location')
            ->orderBy('high_severity', 'desc')
            ->limit(5)
            ->get();
    }

    public function getRecentActivities()
    {
        return AiDiagnose::orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
    }

    public function getConversionStats()
    {
        $totalDiagnoses = AiDiagnose::count();
        $totalWhatsAppClicks = EventLog::where('event_type', 'whatsapp_click')->count();
        
        $healthScore = 100;
        if($totalDiagnoses > 0) {
            $severityA = AiDiagnose::where('final_deep_score', 'A')->count();
            // Each Severity A drops infrastructure health by 0.5 points
            $healthScore = max(10, 100 - ($severityA * 0.5));
        }

        $conversionRate = $totalDiagnoses > 0 ? ($totalWhatsAppClicks / $totalDiagnoses) * 100 : 0;

        return [
            'total_diagnoses' => $totalDiagnoses,
            'total_clicks' => $totalWhatsAppClicks,
            'conversion_rate' => round($conversionRate, 2),
            'health_score' => round($healthScore, 1)
        ];
    }

    public function getSeasonalTrends()
    {
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        
        // Analyze "Lemak/FOG" trends for weekend vs weekday
        $trends = AiDiagnose::where('created_at', '>=', $thirtyDaysAgo)
            ->where(function($query) {
                $query->where('result_label', 'like', '%Lemak%')
                      ->orWhere('result_label', 'like', '%FOG%');
            })
            ->select(DB::raw('DAYOFWEEK(created_at) as dayNum'), DB::raw('count(*) as total'))
            ->groupBy('dayNum')
            ->get();

        $weekendTotal = 0; // Fri (6), Sat (7), Sun (1)
        $weekdayTotal = 0; // Mon-Thu (2-5)

        foreach ($trends as $trend) {
            if (in_array($trend->dayNum, [1, 6, 7])) {
                $weekendTotal += $trend->total;
            } else {
                $weekdayTotal += $trend->total;
            }
        }

        $avgWeekend = $weekendTotal / 3; // 3 days
        $avgWeekday = $weekdayTotal / 4; // 4 days

        $increase = $avgWeekday > 0 ? (($avgWeekend - $avgWeekday) / $avgWeekday) * 100 : 0;

        return [
            'weekend_avg' => $avgWeekend,
            'weekday_avg' => $avgWeekday,
            'increase_percent' => round($increase, 2),
            'alert_triggered' => $increase > 20
        ];
    }

    public function getExportData($severity = ['A', 'B'])
    {
        return AiDiagnose::whereIn('final_deep_score', $severity)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
