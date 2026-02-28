<?php

namespace App\Services\Media;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // Assuming GD driver
use Gemini;
use App\Models\Media;

class MediaOptimizationService
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * UNICORP-GRADE: Asynchronous Asset Hardening (WebP + AI SEO)
     */
    public function optimizeAsset($path)
    {
        if (!File::exists($path)) return null;

        $extension = File::extension($path);
        if (!in_array(strtolower($extension), ['jpg', 'jpeg', 'png'])) return $path;

        try {
            Log::info("[SENTINEL-MEDIA] Hardening asset: " . basename($path));

            // 1. Convert to WebP (Lossless/High Compression)
            $image = $this->manager->read($path);
            $webpPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $path);
            
            $image->toWebp(80)->save($webpPath);

            // 2. Generate AI Alt Tag & Long Description via Gemini Vision
            $aiResult = $this->generateAiAltTag($path);

            // 3. Update DB record if exists
            $media = Media::where('file_path', 'like', '%' . basename($path))->first();
            if ($media) {
                $meta = is_array($media->metadata) ? $media->metadata : [];
                $meta['long_description'] = $aiResult['long_desc'] ?? null;
                $meta['ai_processed_at'] = now()->toIso8601String();

                $media->update([
                    'file_path' => str_replace(public_path(), '', $webpPath),
                    'alt' => $aiResult['alt'] ?? $media->alt,
                    'is_optimized' => true,
                    'metadata' => $meta
                ]);
            }

            // Clean up original if different
            if ($webpPath !== $path) File::delete($path);

            return $webpPath;
        } catch (\Exception $e) {
            Log::error("[SENTINEL-MEDIA] Optimization Failure: " . $e->getMessage());
            return $path;
        }
    }

    protected function generateAiAltTag($imagePath)
    {
        try {
            $apiKey = env('GEMINI_API_KEY');
            if (!$apiKey) return null;

            $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $apiKey;

            // UNICORP-GRADE: Semantic Enrichment Prompt
            $prompt = "Analyze this plumbing/drain cleaning image. 
            1. Provide a short 5-word SEO-friendly Alt text (Indonesian).
            2. Provide a 30-word Semantic Long Description for accessibility (Indonesian).
            Return ONLY JSON: {\"alt\": \"...\", \"long_desc\": \"...\"}";

            $response = \Illuminate\Support\Facades\Http::timeout(30)->post($endpoint, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                            ['inline_data' => [
                                'mime_type' => \Illuminate\Support\Facades\File::mimeType($imagePath),
                                'data' => base64_encode(\Illuminate\Support\Facades\File::get($imagePath))
                            ]]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;
                if ($text && preg_match('/\{.*\}/s', $text, $matches)) {
                    return json_decode($matches[0], true);
                }
            }
            return null;
        } catch (\Exception $e) {
            Log::error("[SENTINEL-MEDIA] Semantic Enrichment Failure: " . $e->getMessage());
            return null;
        }
    }
}
