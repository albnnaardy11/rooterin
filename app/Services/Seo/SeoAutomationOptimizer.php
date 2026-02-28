<?php

namespace App\Services\Seo;

use App\Models\WikiEntity;
use App\Models\SeoSetting;
use App\Models\Seo404Log;
use App\Models\SeoRedirect;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SeoAutomationOptimizer
{
    /**
     * Auto-Link Orphan Pages based on keywords
     */
    public function autoInterlinkOrphans()
    {
        $scanner = new OrphanScannerService();
        $orphans = $scanner->scan();
        $count = 0;

        foreach ($orphans as $path => $data) {
            // Find a relevant main entity to link FROM
            $targetKeyword = $data['title'];
            $provider = WikiEntity::where('description', 'not like', "%$path%")
                ->where('description', 'like', "%$targetKeyword%")
                ->first();

            if ($provider) {
                $link = "<a href=\"$path\" class=\"text-primary font-bold hover:underline\">$targetKeyword</a>";
                $provider->description = str_replace($targetKeyword, $link, $provider->description);
                $provider->save();
                $count++;
            }
        }
        return $count;
    }

    /**
     * Auto-Redirect 404s to closest matching Slugs
     */
    public function autoFix404s()
    {
        $logs = Seo404Log::where('is_redirected', false)->where('hits', '>', 5)->get();
        $fixed = 0;

        foreach ($logs as $log) {
            $path = parse_url($log->url, PHP_URL_PATH);
            $segments = explode('/', trim($path, '/'));
            $lastSegment = end($segments);

            // Try to find a matching wiki or service slug
            $match = WikiEntity::where('slug', 'like', "%$lastSegment%")->first() 
                     ?? \App\Models\Service::where('slug', 'like', "%$lastSegment%")->first();

            if ($match) {
                $destination = $match instanceof WikiEntity ? "/wiki/{$match->slug}" : "/layanan/{$match->slug}";
                
                SeoRedirect::create([
                    'source_url' => $path,
                    'destination_url' => $destination,
                    'status_code' => 301
                ]);

                $log->is_redirected = true;
                $log->save();
                $fixed++;
            }
        }
        return $fixed;
    }

    /**
     * Boost Authority of Weak Pages using AI suggestions (Interface for Batch AI)
     */
    public function generateMetaOptimization($entityId)
    {
        $entity = WikiEntity::find($entityId);
        if (!$entity) return null;

        // Logic to hit Gemini and suggest better Meta Title/Desc
        return [
            'original_title' => $entity->title,
            'suggested_title' => $entity->title . " - Solusi Kebocoran Pipa Terpercaya",
            'suggested_desc' => "Temukan panduan lengkap tentang " . $entity->title . " hanya di RooterIn. Ahli deteksi kebocoran pipa nomor 1 di Indonesia."
        ];
    }
}
