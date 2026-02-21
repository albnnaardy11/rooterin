<?php

namespace App\Services\Sentinel\AI;

use App\Models\SentinelRiskProfile;
use App\Models\SentinelBehaviorLog;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class NeuralSentinelInference
{
    /**
     * UNICORP-GRADE: Comprehensive Risk Inference
     */
    public function introspectBehavior()
    {
        $ip = Request::ip();
        $profile = SentinelRiskProfile::firstOrCreate(['ip_address' => $ip]);
        
        // AMNESTY: Localhost or Auth Admins are exempt from catastrophic neural failure
        if ($this->hasAmnesty($ip)) {
            $profile->trust_score = 100;
            $profile->is_bot_probability = 0;
            return $profile;
        }

        // PHASE 1: Reputation Recovery (Time-Based Risk Decay)
        $this->applyReputationRecovery($profile);

        $this->checkTeleportTrap($profile);
        $this->checkRapidFingerprinting($profile);
        $this->checkMechanicalCadence($profile);
        
        // Final Probability Adjustment
        $this->calculateBotProbability($profile);
        
        $profile->last_seen_at = now();
        $profile->save();
        
        return $profile;
    }

    protected function applyReputationRecovery($profile)
    {
        if (!$profile->last_seen_at) return;

        $hoursPassed = now()->diffInHours($profile->last_seen_at);
        
        if ($hoursPassed >= 1) {
            // Recover 5 trust points per hour of absence/normalcy
            $recovery = $hoursPassed * 5;
            $profile->trust_score = min(100, $profile->trust_score + $recovery);
            
            Log::info("[SENTINEL-AI] Reputation Recovery for {$profile->ip_address}: +{$recovery} Trust Points.");
        }
    }

    public function needsPoW($profile)
    {
        // Ambang 70-80 Risk = 20-30 Trust Score
        $riskScore = 100 - $profile->trust_score;
        return ($riskScore >= 70 && $riskScore <= 85);
    }

    protected function hasAmnesty($ip)
    {
        // 1. Local environment bypass
        if (app()->environment('local') && in_array($ip, ['127.0.0.1', '::1'])) {
            return true;
        }

        // 2. Authenticated Admin check (if session available)
        try {
            if (auth()->check() && auth()->user()->is_admin) {
                return true;
            }
        } catch (\Exception $e) {
            // Middleware ran before session/auth
        }

        return false;
    }

    protected function checkTeleportTrap($profile)
    {
        $url = Request::path();
        $method = Request::method();
        $referrer = Request::header('referer');
        
        // Trap 1: Accessing admin without referrer or jumping directly to POST
        if (str_starts_with($url, 'admin/')) {
            $isDirectPost = ($method === 'POST' && !$referrer);
            $isExternalReferrer = ($referrer && !str_contains($referrer, Request::getHttpHost()));
            
            if ($isDirectPost || !$referrer || $isExternalReferrer) {
                $this->logViolation($profile, 'The Teleport Trap', 50, [
                    'url' => $url,
                    'referrer' => $referrer,
                    'is_direct_post' => $isDirectPost
                ]);
            }
        }
    }

    protected function checkRapidFingerprinting($profile)
    {
        $sessionId = session()->getId();
        $currentUA = Request::userAgent();
        
        $cacheKey = "sentinel:fingerprint:{$sessionId}";
        $previousUA = Cache::get($cacheKey);
        
        if ($previousUA && $previousUA !== $currentUA) {
            $this->logViolation($profile, 'Rapid Fingerprinting', 30, [
                'prev_ua' => $previousUA,
                'curr_ua' => $currentUA
            ]);
        }
        
        Cache::put($cacheKey, $currentUA, 3600);
    }

    protected function checkMechanicalCadence($profile)
    {
        $ip = Request::ip();
        $cacheKey = "sentinel:cadence:{$ip}";
        $now = microtime(true) * 1000; // ms
        
        $lastRequestTime = Cache::get($cacheKey);
        
        if ($lastRequestTime) {
            $diff = $now - $lastRequestTime;
            
            // Interval below 100ms is highly mechanical
            if ($diff < 100) {
                $this->logViolation($profile, 'Mechanical Cadence', 40, [
                    'interval_ms' => round($diff, 2)
                ]);
            }
        }
        
        Cache::put($cacheKey, $now, 60);
    }

    protected function logViolation($profile, $eventName, $delta, $context)
    {
        $profile->trust_score = max(0, $profile->trust_score - $delta);
        $profile->violation_count++;
        
        SentinelBehaviorLog::create([
            'risk_profile_id' => $profile->id,
            'event_name' => $eventName,
            'risk_delta' => -$delta,
            'context' => $context
        ]);
        
        Log::warning("[SENTINEL-AI] Risk Elevation for {$profile->ip_address}: $eventName. Trust: {$profile->trust_score}");
        
        // Global Synchronization (Phase 2 Gossip)
        if ($profile->trust_score < 20) {
            app(\App\Services\Sentinel\Cluster\SentinelIntercomService::class)->broadcastRiskSync($profile);
        }
    }

    protected function calculateBotProbability($profile)
    {
        // Simple heuristic: inverse of trust + weight on violations
        $baseProb = (100 - $profile->trust_score) / 100;
        $violationWeight = min(0.5, $profile->violation_count * 0.1);
        
        $profile->is_bot_probability = min(0.9999, $baseProb + $violationWeight);
    }
}
