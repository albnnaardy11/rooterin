<?php

namespace App\Services\Ai;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use DOMDocument;

class AiMultiModelService
{
    protected $quotaGuard;

    public function __construct(AiQuotaGuardService $quotaGuard)
    {
        $this->quotaGuard = $quotaGuard;
    }

    /**
     * UNICORP-GRADE: High-Availability Generation with Integrity Check & Telemetry
     */
    public function generateWithFailover($prompt, $systemInstruction = '', $format = 'text', $featureName = 'general')
    {
        // 1. Quota & Routing Check
        $quota = \App\Models\AiQuota::firstOrCreate(
            ['feature_name' => $featureName],
            ['daily_limit' => 100, 'assigned_model' => 'gemini', 'last_reset_date' => today()]
        );

        if (!$quota->consume()) {
            Log::warning("[AI-GATEWAY] Quota exceeded for feature: $featureName");
            return null;
        }

        // 2. Caching Layer (Memoization)
        $cacheKey = 'ai_resp_' . md5($prompt . $systemInstruction . $format);
        if ($cached = \Illuminate\Support\Facades\Cache::get($cacheKey)) {
            // Log Cache Hit
            \App\Models\AiLog::create([
                'feature_name' => $featureName,
                'model_used' => 'cache',
                'latency_ms' => 0,
                'is_success' => true
            ]);
            return $cached;
        }

        $startTime = microtime(true);
        $response = null;
        $modelUsed = $quota->assigned_model;
        $keyUsed = null;
        $success = false;
        $errorMsg = null;

        try {
            if ($modelUsed === 'gemini') {
                $geminiKey = $this->quotaGuard->getActiveKey();
                if ($geminiKey) {
                    $keyUsed = 'gemini_' . $this->quotaGuard->getHealth()['active_index'];
                    $response = $this->callGemini($geminiKey, $prompt, $systemInstruction);
                    $success = true;
                } else {
                    // Failover to groq
                    $modelUsed = 'groq';
                }
            }

            if ($modelUsed === 'groq') {
                $groqKey = \App\Models\Setting::get('groq_api_key', config('ai.groq_key'));
                if ($groqKey) {
                    $keyUsed = 'groq_primary';
                    $response = $this->callGroq($groqKey, $prompt, $systemInstruction);
                    $success = true;
                }
            }
        } catch (\Exception $e) {
            $errorMsg = $e->getMessage();
            Log::error("[AI-GATEWAY] $modelUsed Failure: " . $errorMsg);
            if ($modelUsed === 'gemini') {
                $this->quotaGuard->reportFailure();
            }
        }

        $latency = round((microtime(true) - $startTime) * 1000);

        // 3. Output Validation & Integrity Check
        if ($success && $response && $this->isValidOutput($response, $format)) {
            // Cache successful response for 7 days
            \Illuminate\Support\Facades\Cache::put($cacheKey, $response, now()->addDays(7));
        } else {
            $success = false;
            $response = null;
            if (!$errorMsg) $errorMsg = "Output validation failed or empty response";
        }

        // 4. Telemetry Logging
        \App\Models\AiLog::create([
            'feature_name' => $featureName,
            'model_used' => $modelUsed,
            'api_key_index' => $keyUsed,
            'latency_ms' => $latency,
            'is_success' => $success,
            'error_message' => substr($errorMsg, 0, 255)
        ]);

        return $response;
    }

    protected function callGemini($key, $prompt, $systemInstruction)
    {
        $response = Http::timeout(30)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$key", [
            'contents' => [
                ['role' => 'user', 'parts' => [['text' => "$systemInstruction\n\n$prompt"]]]
            ]
        ]);

        if ($response->successful()) {
            return $response->json('candidates.0.content.parts.0.text');
        }

        throw new \Exception("Gemini HTTP Error: " . $response->status() . " " . $response->body());
    }

    protected function callGroq($key, $prompt, $systemInstruction)
    {
        $response = Http::timeout(30)->withToken($key)->post("https://api.groq.com/openai/v1/chat/completions", [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                ['role' => 'system', 'content' => $systemInstruction],
                ['role' => 'user', 'content' => $prompt]
            ]
        ]);

        if ($response->successful()) {
            return $response->json('choices.0.message.content');
        }

        throw new \Exception("Groq HTTP Error: " . $response->status() . " - " . $response->body());
    }

    /**
     * UNICORP-GRADE: HTML Integrity & Hallucination Guard
     */
    public function isValidOutput($content, $format)
    {
        if (empty($content)) return false;

        if ($format === 'html') {
            libxml_use_internal_errors(true);
            $doc = new DOMDocument();
            $valid = $doc->loadHTML('<?xml encoding="utf-8" ?><div>' . $content . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            
            if (!$valid || count(libxml_get_errors()) > 0) {
                Log::critical("[AI_HALLUCINATION] Structural HTML corruption detected. Content rejected.");
                libxml_clear_errors();
                return false;
            }
        }

        return true;
    }
}
