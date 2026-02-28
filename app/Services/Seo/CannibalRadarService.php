<?php

namespace App\Services\Seo;

use App\Models\SeoPerformanceStat;
use App\Services\Ai\AiQuotaGuardService;
use App\Services\Sentinel\SentinelService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CannibalRadarService
{
    /**
     * UNICORP-GRADE: Performant Conflict Detection
     * Identifies queries targeted by multiple URLs with stagnant/low performance.
     */
    public function scanConflicts()
    {
        // Thresholds: CTR < 2%, Position 5-15, multiple URLs for same query in last 30 days
        $subquery = DB::table('seo_performance_stats')
            ->select('query', 'url', 
                DB::raw('AVG(position) as avg_pos'), 
                DB::raw('AVG(ctr) as avg_ctr'),
                DB::raw('SUM(clicks) as total_clicks'))
            ->where('date', '>=', now()->subDays(30))
            ->groupBy('query', 'url')
            ->having('avg_pos', '>=', 5)
            ->having('avg_pos', '<=', 15)
            ->having('avg_ctr', '<', 2);

        $conflicts = DB::table(DB::raw("({$subquery->toSql()}) as stats"))
            ->mergeBindings($subquery)
            ->select('query', DB::raw('COUNT(url) as url_count'), DB::raw('GROUP_CONCAT(url) as urls'))
            ->groupBy('query')
            ->having('url_count', '>', 1)
            ->get();

        $results = [];
        foreach ($conflicts as $conflict) {
            $urlList = explode(',', $conflict->urls);
            $metrics = SeoPerformanceStat::where('query', $conflict->query)
                ->whereIn('url', $urlList)
                ->select('url', DB::raw('AVG(position) as pos'), DB::raw('SUM(clicks) as clicks'))
                ->groupBy('url')
                ->get();

            $results[] = [
                'query' => $conflict->query,
                'urls' => $metrics,
                'total_urls' => $conflict->url_count
            ];

            // High-Value Alert: Volume > 1000 impressions (approximated by clicks/ctr)
            // In a real setup, we'd have volume data, but here we use impressions from performance stats
            $totalImpressions = SeoPerformanceStat::where('query', $conflict->query)->sum('impressions');
            if ($totalImpressions > 1000) {
                app(SentinelService::class)->sendWhatsAppAlert("*HIGH-VALUE CANNIBALISM*\nQuery: *{$conflict->query}*\nURLs: {$conflict->url_count}\nWaste: High potential impressions lost in conflict zone.");
            }
        }

        return $results;
    }

    /**
     * UNICORP-GRADE: AI Strategic Intelligence
     */
    public function analyzeConflict(string $query, array $urls)
    {
        $guard = app(AiQuotaGuardService::class);
        $apiKey = $guard->getActiveKey();
        if (!$apiKey) return null;

        $prompt = "You are a Senior SEO Data Scientist at Unicorp. Analyze this 'Content Cannibalism' conflict:
        Query: $query
        Competing URLs: " . implode(', ', $urls) . "
        
        Analyze Search Intent and provide a strategic resolution:
        1. Action: MERGE (301 Redirect to Master), LINK (Reference from secondary to master), or DE_OPTIMIZE (Change focus of one URL).
        2. Master URL: Which URL should be the primary.
        3. Reason: Explain why based on perceived intent.
        
        Return ONLY JSON: {\"action\": \"...\", \"master_url\": \"...\", \"reason\": \"...\"}";

        try {
            $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey", [
                'contents' => [['parts' => [['text' => $prompt]]]]
            ]);

            if ($response->successful()) {
                $rawText = $response->json('candidates.0.content.parts.0.text');
                Log::info("[CANNIBAL-RADAR] AI Raw Response: " . substr($rawText, 0, 100));
                
                if ($rawText && preg_match('/\{.*\}/s', $rawText, $matches)) {
                    return json_decode($matches[0], true);
                } else {
                    Log::error("[CANNIBAL-RADAR] No JSON found in response.");
                }
            } else {
                Log::error("[CANNIBAL-RADAR] Gemini API Failed: " . $response->body());
                if ($response->status() === 429) {
                    $guard->reportFailure();
                }
            }
        } catch (\Exception $e) {
            Log::error("[CANNIBAL-RADAR] AI Analysis Error: " . $e->getMessage());
        }

        return null;
    }
}
