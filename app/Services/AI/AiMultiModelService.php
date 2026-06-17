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
     * UNICORP-GRADE: High-Availability Generation with Integrity Check
     */
    public function generateWithFailover($prompt, $systemInstruction = '', $format = 'text')
    {
        // 1. Primary Attempt (Gemini Pool)
        $geminiKey = $this->quotaGuard->getActiveKey();
        if ($geminiKey) {
            try {
                $response = $this->callGemini($geminiKey, $prompt, $systemInstruction);
                if ($response && $this->isValidOutput($response, $format)) {
                    return $response;
                }
            } catch (\Exception $e) {
                Log::warning("[SENTINEL-AI] Gemini Node Failure: " . $e->getMessage());
                $this->quotaGuard->reportFailure();
            }
        }

        // 2. Secondary Attempt (Groq Cloud Fallback if configured)
        $groqKey = \App\Models\Setting::get('groq_api_key', config('ai.groq_key'));
        if ($groqKey) {
            try {
                $response = $this->callGroq($groqKey, $prompt, $systemInstruction);
                if ($response && $this->isValidOutput($response, $format)) {
                    return $response;
                }
            } catch (\Exception $e) {
                Log::error("[SENTINEL-AI] Groq Fallback Failure: " . $e->getMessage());
            }
        }

        Log::emergency("[SENTINEL-AI] CRITICAL: All AI Models Failed. Entering Stasis.");
        return null;
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

        throw new \Exception("Gemini HTTP Error: " . $response->status());
    }

    protected function callGroq($key, $prompt, $systemInstruction)
    {
        $response = Http::timeout(30)->withToken($key)->post("https://api.groq.com/openai/v1/chat/completions", [
            'model' => 'llama-3.3-70b-versatile', // Llama 3.3 dari Meta (70B parameter, sangat cepat)
            'messages' => [
                ['role' => 'system', 'content' => $systemInstruction],
                ['role' => 'user', 'content' => $prompt]
            ]
        ]);

        if ($response->successful()) {
            return $response->json('choices.0.message.content');
        }

        throw new \Exception("Groq Web HTTP Error: " . $response->status() . " - " . $response->body());
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
            // Wrap in div to ensure single root for check if needed, but loadHTML is usually enough
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
