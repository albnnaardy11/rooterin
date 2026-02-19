<?php

namespace App\Http\Middleware;

use App\Models\SeoRedirect;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeoRedirectMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();
        if ($path !== '/') {
            $path = '/' . $path;
        }

        $redirect = SeoRedirect::where('source_url', $path)
            ->where('is_active', true)
            ->first();

        if ($redirect) {
            return redirect($redirect->destination_url, $redirect->status_code);
        }

        return $next($request);
    }
}
