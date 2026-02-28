<?php

namespace App\Services\Seo;

use Illuminate\Support\Str;

class SeoGraderService
{
    public function analyze($content, $title, $metaDescription = '', $targetKeyword = '')
    {
        $report = [
            'score' => 0,
            'warnings' => [],
            'success' => [],
            'stats' => [
                'word_count' => str_word_count(strip_tags($content)),
                'keyword_density' => 0,
            ]
        ];

        $score = 100;

        // 1. Title Length Audit (Optimal: 50-60 chars)
        $titleLen = strlen($title);
        if ($titleLen < 40) {
            $report['warnings'][] = "Title terlalu pendek ($titleLen karakter). Google lebih suka 50-60 karakter.";
            $score -= 10;
        } elseif ($titleLen > 70) {
            $report['warnings'][] = "Title terlalu panjang ($titleLen karakter). Akan terpotong di hasil pencarian.";
            $score -= 10;
        } else {
            $report['success'][] = "Panjang Title optimal.";
        }

        // 2. Meta Description
        $metaLen = strlen($metaDescription);
        if ($metaLen < 120) {
            $report['warnings'][] = "Meta description terlalu singkat ($metaLen karakter). Usahakan 150-160 karakter.";
            $score -= 15;
        } elseif ($metaLen > 180) {
            $report['warnings'][] = "Meta description terlalu panjang. Optimal 160 karakter.";
            $score -= 10;
        } else {
            $report['success'][] = "Meta description optimal.";
        }

        // 3. Header Structure (H2 Tags)
        if (!Str::contains($content, ['<h2', '## '])) {
            $report['warnings'][] = "Tidak ada tag H2. Struktur artikel kurang kuat untuk SEO.";
            $score -= 15;
        } else {
            $report['success'][] = "Struktur Header (H2) terdeteksi.";
        }

        // 4. Keyword Density
        if ($targetKeyword) {
            $count = substr_count(strtolower(strip_tags($content)), strtolower($targetKeyword));
            $density = ($report['stats']['word_count'] > 0) ? ($count / $report['stats']['word_count']) * 100 : 0;
            $report['stats']['keyword_density'] = round($density, 2) . '%';

            if ($density < 0.5) {
                $report['warnings'][] = "Keyword density terlalu rendah ({$report['stats']['keyword_density']}). Masukkan kata kunci '$targetKeyword' lebih sering secara natural.";
                $score -= 15;
            } elseif ($density > 3) {
                $report['warnings'][] = "Keyword density terlalu tinggi ({$report['stats']['keyword_density']}). Hati-hati dianggap spam (Keyword Stuffing).";
                $score -= 10;
            } else {
                $report['success'][] = "Keyword density '$targetKeyword' ideal.";
            }
        }

        // 5. Image Alt Tags
        if (Str::contains($content, '<img') && !Str::contains($content, 'alt=')) {
            $report['warnings'][] = "Terdapat gambar tanpa tag ALT. Google tidak bisa membaca konteks gambar.";
            $score -= 10;
        }

        $report['score'] = max(0, $score);
        return $report;
    }
}
