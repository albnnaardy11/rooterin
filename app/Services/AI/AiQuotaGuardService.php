<?php

namespace App\Services\Ai;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AiQuotaGuardService
{
    protected $keys = [];
    protected $currentKeyIndex = 0;

    public function __construct()
    {
        $this->initializeKeyPool();
    }

    protected function initializeKeyPool()
    {
        // UNICORP-GRADE: High Availability Key Pool (Sentinel Protocol)
        $primary = env('GEMINI_API_KEY');
        if ($primary) $this->keys[] = $primary;

        for ($i = 2; $i <= 10; $i++) {
            $key = env("GEMINI_API_KEY_$i");
            if ($key) $this->keys[] = $key;
        }

        $this->currentKeyIndex = Cache::get('sentinel_ai_current_key_index', 0);
    }

    /**
     * UNICORP-GRADE: Retrieve an active node key with automatic rotation on 429
     */
    public function getActiveKey()
    {
        if (empty($this->keys)) {
            Log::critical("[SENTINEL-AI] No Gemini API Keys found in ENV pool.");
            return null;
        }

        // UNICORP-GRADE: Atomic Index Management
        $index = (int) Cache::get('sentinel_ai_current_key_index', 0);
        
        // Cyclic check: Try all keys starting from current index
        for ($i = 0; $i < count($this->keys); $i++) {
            $checkIndex = ($index + $i) % count($this->keys);
            
            $blockedUntil = Cache::get('sentinel_ai_key_blocked_at_' . $checkIndex);
            if (!$blockedUntil || now()->greaterThan($blockedUntil)) {
                // Update persistent index if we moved
                if ($checkIndex !== $index) {
                    Cache::put('sentinel_ai_current_key_index', $checkIndex, 86400);
                }
                $this->currentKeyIndex = $checkIndex;
                return $this->keys[$checkIndex];
            }
        }

        Log::emergency("[SENTINEL-AI] ALL NODES EXHAUSTED. System entering Failover-Static mode.");
        return null;
    }

    /**
     * UNICORP-GRADE: Masterpiece Rotation Protocol (Atomic)
     */
    public function rotateKey()
    {
        // Atomically increment the index
        $index = Cache::increment('sentinel_ai_current_key_index');
        $this->currentKeyIndex = $index % count($this->keys);
        
        // Persist the wrapped value back to avoid overflow issues (optional but cleaner)
        Cache::put('sentinel_ai_current_key_index', $this->currentKeyIndex, 86400);

        Log::warning("[SENTINEL-AI] Node Failover: Rotated to Key Index: " . $this->currentKeyIndex);
    }

    /**
     * Mark current key as failed (Rate limited / Quota reached)
     */
    public function reportFailure()
    {
        // Block for 1 hour
        Cache::put('sentinel_ai_key_blocked_at_' . $this->currentKeyIndex, now()->addHour(), 3600);
        $this->rotateKey();
        
        $this->sendWhatsAppAlert("AI-QUOTA: Key Index " . $this->currentKeyIndex . " reached its limit. Self-healing rotation engaged.");
    }

    public function getHealth()
    {
        return [
            'total_nodes' => count($this->keys),
            'active_index' => $this->currentKeyIndex,
            'status' => count($this->keys) > 0 ? 'Operational' : 'Critical'
        ];
    }

    protected function sendWhatsAppAlert($message)
    {
        // Integrated via Sentinel's communication bridge
        app(\App\Services\Sentinel\SentinelService::class)->sendWhatsAppAlert($message);
    }
}
