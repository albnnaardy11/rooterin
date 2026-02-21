<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SentinelRiskProfile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SentinelController extends Controller
{
    /**
     * UNICORP-GRADE: System Sentinel Dashboard
     */
    public function index()
    {
        $healthData = app(\App\Services\Sentinel\SentinelService::class)->monitorAll();
        return view('admin.sentinel.index', compact('healthData'));
    }

    /**
     * UNICORP-GRADE: On-Demand Deep Scan
     */
    public function scan()
    {
        $healthData = app(\App\Services\Sentinel\SentinelService::class)->monitorAll();
        return response()->json(['success' => true, 'health' => $healthData]);
    }

    /**
     * UNICORP-GRADE: Sentinel Heartbeat API
     */
    public function heartbeat()
    {
        return response()->json([
            'status' => 'Operational',
            'timestamp' => now()->toIso8601String()
        ]);
    }

    /**
     * UNICORP-GRADE: PoW Challenge Verification
     */
    public function verifyChallenge(Request $request)
    {
        $token = $request->input('pow_token');
        $ip = $request->ip();

        if ($token && str_contains($token, ':')) {
            // Verify partial collision (simulated check)
            list($hash, $nonce) = explode(':', $token);
            
            if (str_starts_with($hash, '0000')) {
                $profile = SentinelRiskProfile::where('ip_address', $ip)->first();
                if ($profile) {
                    // Reputation Recovery: Reward for solving the challenge
                    $profile->trust_score = min(100, $profile->trust_score + 15);
                    $profile->violation_count = max(0, $profile->violation_count - 1);
                    $profile->save();
                    
                    Log::info("[SENTINEL-AI] PoW Challenge Solved by $ip. Trust Score elevated to {$profile->trust_score}");
                    
                    return redirect()->intended('/')->with('success', 'Human verification successful. Trust restored.');
                }
            }
        }

        return redirect()->back()->with('error', 'Koneksi Neural tidak stabil. Silakan coba lagi.');
    }

    /**
     * UNICORP-GRADE: Threat Heatmap Data
     */
    public function getHeatmapData()
    {
        $logs = \App\Models\SentinelBehaviorLog::select('event_name', 'context')
            ->latest()
            ->take(1000)
            ->get()
            ->groupBy(function($log) {
                return $log->context['url'] ?? 'unknown';
            })
            ->map(function($group) {
                return $group->count();
            });

        return response()->json($logs);
    }
}
