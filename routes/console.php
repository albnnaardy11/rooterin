<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * UNICORP-GRADE: SEO Intelligence Synchronizer (With Exponential Backoff)
 */
Artisan::command('seo:sync-gsc', function () {
    $this->info("[SENTINEL] Initiating GSC Intelligence Sync...");
    $service = app(\App\Services\Seo\GoogleSearchConsoleService::class);
    
    $maxAttempts = 3;
    $attempt = 0;
    $success = false;

    while ($attempt < $maxAttempts && !$success) {
        $attempt++;
        if ($service->syncHistoricalData(7)) {
            $success = true;
            $this->info("[SENTINEL] GSC Sync Successful on Attempt $attempt.");
        } else {
            if ($attempt < $maxAttempts) {
                $wait = pow(2, $attempt) * 5; // 10s, 20s...
                $this->warn("[SENTINEL] GSC Sync Failed. Retrying in {$wait}s... (Attempt $attempt/$maxAttempts)");
                sleep($wait);
            }
        }
    }

    if (!$success) {
        $this->error("[SENTINEL] GSC Sync FATAL FAIL after $maxAttempts attempts.");
        app(\App\Services\Sentinel\SentinelService::class)->sendWhatsAppAlert("CRITICAL: GSC Sync Failed after $maxAttempts retry cycles.");
    }
})->purpose('Synchronize historical GSC data with Resilience Protocol');

/**
 * UNICORP-GRADE: AI-Powered Dead Link Repository Healing
 */
Artisan::command('seo:repair-404', function () {
    $this->info("[SENTINEL] Repair Engine: Analyzing Dead Links...");
    $service = app(\App\Services\Seo\SeoRepairService::class);
    $service->analyzeDeadLinks();
    $this->info("[SENTINEL] SEO Healing Sequence Complete.");
})->purpose('Analyze dead links and generate AI-driven redirect suggestions');

/**
 * UNICORP-GRADE: Daily Admin Business Intelligence
 */
Artisan::command('sentinel:report-daily', function () {
    $this->info("[SENTINEL] Compiling Business Intelligence report...");
    $service = app(\App\Services\Admin\AdminReportService::class);
    $message = $service->generateDailySummary();
    $this->info("[SENTINEL] Daily Report Delivered via WhatsApp.");
})->purpose('Aggregate daily metrics and deliver to admin via WhatsApp');

/**
 * UNICORP-GRADE: Asynchronous Asset Hardening
 */
Artisan::command('media:optimize', function () {
    $this->info("[SENTINEL] Media Hardening Protocol Engaged.");
    $service = app(\App\Services\Media\MediaOptimizationService::class);
    
    // Scan public/assets/uploads for images (Simplified periodic scan)
    $files = \Illuminate\Support\Facades\File::allFiles(public_path('assets'));
    $count = 0;
    foreach ($files as $file) {
        $extension = strtolower($file->getExtension());
        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
            $service->optimizeAsset($file->getPathname());
            $count++;
            if ($count > 10) break; // Limit per run to prevent timeout
        }
    }
    $this->info("[SENTINEL] Processed $count assets. Hardening complete.");
})->purpose('Convert and optimize newly uploaded assets (WebP/AI Alt)');
