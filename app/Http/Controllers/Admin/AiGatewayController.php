<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiLog;
use App\Models\AiQuota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AiGatewayController extends Controller
{
    public function index()
    {
        // Auto-create default quotas if they don't exist
        $defaultFeatures = ['general', 'seo', 'vision', 'wiki', 'blog'];
        foreach ($defaultFeatures as $feature) {
            AiQuota::firstOrCreate(
                ['feature_name' => $feature],
                ['daily_limit' => 100, 'assigned_model' => 'gemini', 'last_reset_date' => today()]
            );
        }

        $quotas = AiQuota::all();
        
        $todayLogs = AiLog::whereDate('created_at', today())->get();
        $totalRequests = $todayLogs->count();
        $successRequests = $todayLogs->where('is_success', true)->count();
        $failedRequests = $totalRequests - $successRequests;
        
        $avgLatency = $successRequests > 0 ? round($todayLogs->where('is_success', true)->avg('latency_ms')) : 0;
        
        // Group by feature
        $featureStats = AiLog::select('feature_name', DB::raw('count(*) as total'), DB::raw('avg(latency_ms) as avg_latency'))
            ->whereDate('created_at', today())
            ->groupBy('feature_name')
            ->get();

        return view('admin.ai-gateway.index', compact(
            'quotas', 'totalRequests', 'successRequests', 'failedRequests', 'avgLatency', 'featureStats'
        ));
    }

    public function updateQuota(Request $request, $id)
    {
        $quota = AiQuota::findOrFail($id);
        $quota->update([
            'daily_limit' => $request->daily_limit,
            'assigned_model' => $request->assigned_model,
        ]);

        return redirect()->back()->with('success', "Quota for {$quota->feature_name} updated successfully.");
    }
}
