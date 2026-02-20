<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductionShield
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    protected $security;

    public function __construct(\App\Services\Security\SecurityAutomationService $security)
    {
        $this->security = $security;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): \Symfony\Component\HttpFoundation\Response
    {
        // 1. Stealth Check: Application Lockdown Status (L2 Redis)
        if ($this->security->isLockedDown()) {
            // Stealth Rejection: Generic 503 without details
            return response()->view('errors.503', [], 503);
        }

        // 2. Debug Suppressor: Runtime Force-Kill for Public Traffic
        $ip = $request->ip();
        $adminIps = ['127.0.0.1', '::1']; 
        
        if (!in_array($ip, $adminIps)) {
            config(['app.debug' => false]);
        }

        // 3. Brute Force Monitor for API Keys (Phantom/PASETO Bridge)
        if ($request->is('api/*')) {
            $key = 'brute_force_auth:' . $ip;
            $attempts = \Illuminate\Support\Facades\Cache::increment($key);
            
            if ($attempts === 1) {
                \Illuminate\Support\Facades\Cache::put($key, 1, 60);
            }

            if ($attempts > 5) {
                // Trigger AutoLockdown
                $this->security->triggerAutoLockdown($ip, "Brute Force Threshold Exceeded (>5 attempts/min on API)");
                return response()->view('errors.503', [], 503);
            }
        }

        return $next($request);
    }
}
