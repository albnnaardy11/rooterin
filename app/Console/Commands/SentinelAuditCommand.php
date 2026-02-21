<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Sentinel\SentinelService;
use Illuminate\Support\Facades\Log;

class SentinelAuditCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sentinel:audit {--force : Disregard cache and force a new audit entry}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute a holistic system audit and log the Genesis Mark to the Vault.';

    /**
     * Execute the console command.
     */
    public function handle(SentinelService $sentinel)
    {
        $this->info('[SRE] Initializing Genesis Audit Pulse...');
        
        $metrics = $sentinel->executeHolisticAudit();
        
        $this->table(
            ['Metric', 'Value'],
            collect($metrics)->map(function ($val, $key) {
                return [$key, is_array($val) ? json_encode($val) : $val];
            })->toArray()
        );

        $this->info('[OPERATIONAL] Genesis Mark captured in Sentinel Audit Logs.');
        
        return 0;
    }
}
