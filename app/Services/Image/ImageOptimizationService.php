<?php

namespace App\Services\Image;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageOptimizationService
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Optimize and save image.
     * 
     * @param UploadedFile $file
     * @param string $folder
     * @param int $width
     * @param int $quality
     * @return string
     */
    public function optimize(UploadedFile $file, string $folder = 'uploads', int $width = 1200, int $quality = 80): string
    {
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.webp';
        $path = $folder . '/' . $filename;

        $image = $this->manager->read($file);
        
        // Resize if width is larger than constraint
        if ($image->width() > $width) {
            $image->scale(width: $width);
        }

        // Convert to WebP and compress
        $encoded = $image->toWebp($quality);

        // Save to storage
        Storage::disk('public')->put($path, (string) $encoded);

        return '/storage/' . $path;
    }
}
