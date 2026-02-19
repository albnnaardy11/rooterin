<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Jenssegers\Agent\Agent;
use Symfony\Component\HttpFoundation\Response;

class PreRenderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $agent = new Agent();

        // Detect if the requester is a bot (Googlebot, Bingbot, etc)
        if ($agent->isRobot()) {
            $cacheKey = 'seo_prerender_' . md5($request->fullUrl() . '_' . app()->getLocale());

            // Serve cached HTML if available for bots (Static Site Generation feel)
            if (Cache::has($cacheKey)) {
                return response(Cache::get($cacheKey))
                    ->header('X-Prerender-Cache', 'HIT')
                    ->header('Content-Type', 'text/html');
            }

            // If not cached, let the request proceed and cache it for next time
            $response = $next($request);

            if ($response->getStatusCode() === 200) {
                Cache::put($cacheKey, $response->getContent(), 86400); // 24 hours
            }

            return $response;
        }

        return $next($request);
    }
}
