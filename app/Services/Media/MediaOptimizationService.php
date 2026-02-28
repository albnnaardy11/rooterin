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

            // 2. Generate AI Alt Tag via Gemini Vision (if available)
            // Note: In a real Unicorp setup, this would be queued
            $altTag = $this->generateAiAltTag($path);

            // 3. Update DB record if exists
            $media = Media::where('file_path', 'like', '%' . basename($path))->first();
            if ($media) {
                $media->update([
                    'file_path' => str_replace(public_path(), '', $webpPath),
                    'alt' => $altTag ?: $media->alt,
                    'is_optimized' => true
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

            $response = \Illuminate\Support\Facades\Http::timeout(30)->post($endpoint, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "Identify the main subject in this plumbing/drain cleaning image. Provide a 5-word SEO-friendly Alt text for an Indonesian website. Return ONLY the text."],
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
                return $result['candidates'][0]['content']['parts'][0]['text'] ?? null;
            }
            return null;
        } catch (\Exception $e) {
            Log::error("[SENTINEL-MEDIA] AI Alt Gen Failure: " . $e->getMessage());
            return null;
        }
    }
}
