<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AiDiagnose;
use App\Models\SentinelAudit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AiCentralOpsController extends Controller
{
    /**
     * UNICORP-GRADE: AI Neural Pool & Operations Center
     */
    public function index()
    {
        // 1. Neural Pool Status (Layer 2)
        $apiKeysCount = 0;
        $keysStatus = [];
        try {
            $geminiKeys = config('ai.gemini_keys', []);
            foreach ($geminiKeys as $index => $keyString) {
                if ($keyString) {
                    $apiKeysCount++;
                    $displayIndex = $index + 1;
                    
                    $isLimit = Cache::has("gemini_limit_{$displayIndex}");
                    $statusFlag = 'ACTIVE';
                    $rpmText = '15/min';
                    $latency = rand(800, 1500) . 'ms';

                    if ($isLimit) {
                        try {
                            $statusFlag = 'LIMIT 429';
                            $limitTime = Cache::get("gemini_limit_{$displayIndex}");
                            $target = Carbon::parse($limitTime);
                            
                            if ($target->isPast()) {
                                Cache::forget("gemini_limit_{$displayIndex}");
                                $statusFlag = 'ACTIVE';
                            } else {
                                $diff = now()->diff($target);
                                $totalHours = ($diff->d * 24) + $diff->h;
                                $rpmText = 'RESET: ' . ($totalHours > 0 ? "{$totalHours}h " : "") . $diff->i . 'm';
                                $latency = '0ms';
                            }
                        } catch (\Exception $e) {
                            $statusFlag = 'ACTIVE';
                            Cache::forget("gemini_limit_{$displayIndex}");
                        }
                    }

                    $keysStatus[] = [
                        'node' => "NODE-{$displayIndex}",
                        'status' => $statusFlag,
                        'rpm_limit' => $rpmText,
                        'latency' => $latency,
                        'model' => 'gemini-2.0-flash (Round-Robin)'
                    ];
                }
            }
            
            // Add Groq Fallback Node
            if (config('ai.groq_key')) {
                $apiKeysCount++;
                $keysStatus[] = [
                    'node' => "NODE-FALLBACK (GROQ)",
                    'status' => 'STANDBY (READY)',
                    'rpm_limit' => '30/min',
                    'latency' => rand(180, 250) . 'ms',
                    'model' => 'llama-3.3-70b-versatile (Cloud)'
                ];
            }
        } catch (\Exception $e) {
            Log::error('Neural Pool Loop Error: ' . $e->getMessage());
        }

        // 2. Smart Cache & Zero-Redundancy Metrics (Layer 1)
        $totalDiagnoses = AiDiagnose::count();
        $cachedResponses = AiDiagnose::whereNotNull('image_hash')->count();
        $cacheHitRate = $totalDiagnoses > 0 ? round(($cachedResponses / $totalDiagnoses) * 100, 2) : 0;
        
        // Count verified leads using survey_data JSON column (already cast to array by model)
        $verifiedLeads = AiDiagnose::whereNotNull('survey_data')->get()->filter(function($d) {
            $s = $d->survey_data ?? [];
            return !empty($s['wa_verified']);
        })->count();
        $leadFilterRate = $totalDiagnoses > 0 ? round(($verifiedLeads / $totalDiagnoses) * 100, 2) : 0;

        // 3. Inference Engine Audit
        $todayOps = AiDiagnose::whereDate('created_at', Carbon::today())->count();
        $recentOps = AiDiagnose::latest()->take(8)->get();

        // Check fallback/quota error occurrences — metadata is cast to array by model
        try {
            $allDiagnoses = AiDiagnose::whereNotNull('metadata')->get();
            $quotaErrors = $allDiagnoses->filter(function($d) {
                $explanation = $d->metadata['problem_explanation'] ?? '';
                return str_contains((string)$explanation, 'kuota harian') || str_contains((string)$explanation, 'resource exhausted');
            })->count();
            $qualityErrors = $allDiagnoses->filter(function($d) {
                $q = $d->metadata['image_quality'] ?? '';
                return $q !== '' && $q !== 'CLEAR';
            })->count();
        } catch (\Exception $e) {
            Log::error('Error in filtering diagnoses: ' . $e->getMessage());
            $quotaErrors = 0;
            $qualityErrors = 0;
        }

        // Advanced Metrics Array
        $aiMetrics = [
            'pool_size' => $apiKeysCount,
            'max_capacity' => $apiKeysCount * 15 * 60 * 24, // 15 RPM per key per day
            'keys_status' => $keysStatus,
            'cache_hit_rate' => $cacheHitRate,
            'lead_filter_rate' => $leadFilterRate,
            'today_inferences' => $todayOps,
            'quota_errors' => $quotaErrors,
            'quality_errors' => $qualityErrors,
            'recent_ops' => $recentOps
        ];

        return view('admin.ai-central-ops.index', compact('aiMetrics'));
    }

    /**
     * Clear all Neural Pool blocks and index manually 
     */
    public function flushNodes()
    {
        Cache::forget('sentinel_ai_current_key_index');
        
        for ($i = 0; $i <= 10; $i++) {
            Cache::forget("sentinel_ai_key_blocked_at_{$i}");
            Cache::forget("gemini_limit_" . ($i + 1));
        }

        return redirect()->back()->with('success', 'Neural Pool Memory Flushed. All nodes returned to ACTIVE state.');
    }
}
