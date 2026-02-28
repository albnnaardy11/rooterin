<?php

namespace Database\Seeders;

use App\Models\Partner;
use App\Services\Image\ImageOptimizationService;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PartnerDiscoverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sourcePath = public_path('images/partners');
        
        if (!File::exists($sourcePath)) {
            $this->command->error("Source directory $sourcePath does not exist.");
            return;
        }

        $files = File::files($sourcePath);
        $optimizer = new ImageOptimizationService();

        $this->command->info("Found " . count($files) . " files in public/images/partners. Starting ingestion...");

        foreach ($files as $index => $file) {
            $filename = $file->getFilename();
            
            // Prettify name from filename
            $name = pathinfo($filename, PATHINFO_FILENAME);
            $name = ucwords(str_replace(['-', '_', '.', '(', ')'], ' ', $name));
            
            // Skip if already exists
            if (Partner::where('name', $name)->exists()) {
                $this->command->warn("Skipping $name - already exists.");
                continue;
            }

            try {
                // Create a temporary UploadedFile instance for the optimizer
                $uploadedFile = new UploadedFile(
                    $file->getPathname(),
                    $filename,
                    File::mimeType($file->getPathname()),
                    null,
                    true
                );

                // Process through optimization service (WebP conversion)
                $logoPath = $optimizer->optimize($uploadedFile, 'partners', 500, 90);

                Partner::create([
                    'name' => $name,
                    'logo_path' => $logoPath,
                    'is_active' => true,
                    'order' => $index
                ]);

                $this->command->info("Ingested: $name -> WebP");
            } catch (\Exception $e) {
                $this->command->error("Failed to ingest $filename: " . $e->getMessage());
            }
        }

        $this->command->info("Ingestion complete. You can now manage these in the CMS.");
    }
}
