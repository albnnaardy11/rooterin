<?php

namespace App\Services\Seo;

use App\Models\SeoKeyword;
use Illuminate\Support\Facades\Cache;

class InternalLinkService
{
    /**
     * Otomatis menyuntikkan link ke dalam konten teks berdasarkan keyword database.
     */
    public function automate(string $content): string
    {
        $keywords = Cache::remember('seo_internal_keywords', 3600, function() {
            return SeoKeyword::where('is_active', true)->orderByDesc('priority')->get();
        });

        if ($keywords->isEmpty()) return $content;

        foreach ($keywords as $keyword) {
            // Regex untuk mencari keyword, tapi hindari kata yang sudah didalam link <a> atau tag HTML lain
            $pattern = '/(?!(?:[^<]+>|[^>]+<\/a>))\b(' . preg_quote($keyword->keyword, '/') . ')\b/i';
            
            // Limit 1 link per keyword per konten agar tidak dianggap spam oleh Google
            $replacement = '<a href="' . $keyword->target_url . '" class="text-primary hover:underline font-semibold" title="' . $keyword->keyword . '">$1</a>';
            
            $content = preg_replace($pattern, $replacement, $content, 1);
        }

        return $content;
    }
}
