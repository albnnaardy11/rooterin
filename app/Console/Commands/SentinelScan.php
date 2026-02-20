<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Sentinel\SentinelService;
use Illuminate\Support\Facades\Log;

class SentinelScan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sentinel:scan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a deep system health scan and trigger alerts if critical issues are found.';

    /**
     * Execute the console command.
     */
    public function handle(SentinelService $sentinel)
    {
        $this->info('Starting Sentinel Deep Scan...');
        
        $results = $sentinel->monitorAll();
        
        $criticalIssues = [];

        // Check for CRITICAL status in any section
        foreach ($results as $section => $data) {
            if (is_array($data) && isset($data['status']) && $data['status'] === 'Critical') {
                $criticalIssues[] = strtoupper($section);
            }
        }

        if (!empty($criticalIssues)) {
            $msg = "[UNICORN SENTINEL] CRITICAL ALERT: " . implode(', ', $criticalIssues) . " detected at " . now()->toDateTimeString();
            $this->error($msg);
            
            // Trigger WhatsApp Alert (Simulated/Integrated)
            $sentinel->sendWhatsAppAlert($msg);
        } else {
            $this->info('All systems healthy. No critical issues detected.');
        }
    }
}
