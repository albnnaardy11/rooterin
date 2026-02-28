<?php

namespace App\Services\Seo;

use App\Models\Seo404Log;
use App\Models\SeoRedirectSuggestion;
use Illuminate\Support\Facades\Log;
use Gemini;
use Illuminate\Support\Facades\Cache;

class SeoRepairService
{
    /**
     * UNICORP-GRADE: Deep-Analysis of 404 Logs via AI matching
     */
    public function analyzeDeadLinks()
    {
        Log::info("[SENTINEL-SEO] Initiating Dead Link Analysis...");

        $deadLinks = Seo404Log::where('is_redirected', false)
            ->where('hits', '>', 5)
            ->orderBy('hits', 'desc')
            ->limit(10)
            ->get();

        if ($deadLinks->isEmpty()) return;

        // Get available "Healthy" URLs from sitemap or dynamic SEO tables
        $validUrls = $this->getValidUrls();

        foreach ($deadLinks as $link) {
            $this->repairWithAi($link, $validUrls);
        }
    }

    protected function getValidUrls()
    {
        // For simulation, we pull from cities and keywords (Common architectural pattern in this project)
        $urls = [url('/')];
        
        $cities = \App\Models\SeoCity::pluck('slug')->toArray();
        foreach ($cities as $city) $urls[] = url("/service-rooter-$city");

        $posts = \App\Models\Post::pluck('slug')->toArray();
        foreach ($posts as $post) $urls[] = url("/blog/$post");

        return array_unique($urls);
    }

    protected function repairWithAi($link, $validUrls)
    {
        $prompt = "You are an SEO Expert for 'RooterIN', a plumbing and drain cleaning service. 
        A user tried to access a dead link: '{$link->url}'.
        Below is a list of our valid URLs:
        " . implode("\n", array_slice($validUrls, 0, 100)) . "
        
        Tasks:
        1. Find the best matching URL from the valid list.
        2. Calculate a confidence score (0-1).
        3. Provide a brief reason.
        
        Return ONLY valid JSON like: {\"suggested_url\": \"...\", \"confidence\": 0.95, \"reason\": \"...\"}";

        try {
            $client = Gemini::client(env('GEMINI_API_KEY'));
            $result = $client->geminiPro()->generateContent($prompt);
            $response = json_decode($result->text(), true);

            if ($response && isset($response['suggested_url'])) {
                $suggestion = SeoRedirectSuggestion::updateOrCreate(
                    ['source_url' => $link->url],
                    [
                        'suggested_url' => $response['suggested_url'],
                        'confidence' => $response['confidence'] * 100,
                        'reason' => $response['reason'],
                        'is_applied' => false
                    ]
                );

                // AUTO-HEALING: If confidence > 90%, apply immediately
                if ($suggestion->confidence >= 90) {
                    $this->applyRedirect($suggestion, $link);
                }
            }
        } catch (\Exception $e) {
            Log::error("[SENTINEL-SEO] AI Repair Failure: " . $e->getMessage());
        }
    }

    public function applyRedirect($suggestion, $link)
    {
        \App\Models\SeoRedirect::updateOrCreate(
            ['old_url' => $suggestion->source_url],
            ['new_url' => $suggestion->suggested_url, 'type' => 301]
        );

        $suggestion->update([
            'is_applied' => true,
            'applied_at' => now()
        ]);

        $link->update(['is_redirected' => true]);

        Log::info("[SENTINEL-SEO] Auto-Healed 404: {$suggestion->source_url} -> {$suggestion->suggested_url}");
    }
}
