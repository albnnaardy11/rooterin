<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Seo\CannibalRadarService;
use App\Models\SeoRedirectSuggestion;
use App\Models\SeoPerformanceStat;
use App\Services\SentinelService;

class ResolveCannibal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seo:resolve-cannibal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan and suggest resolutions for keyword cannibalization conflicts.';

    public function handle(CannibalRadarService $radar)
    {
        $this->info("Scanning for Canonical/Cannibalization Conflicts...");
        $conflicts = $radar->scanConflicts();

        if (empty($conflicts)) {
            $this->info("Clean Slate. No keyword cannibalization detected.");
            return 0;
        }

        foreach ($conflicts as $conflict) {
            $this->warn("Conflict on Query: {$conflict['query']}");
            
            // Check if already has a suggestion
            $exists = SeoRedirectSuggestion::where('type', 'CANNIBAL')
                ->where('metadata->query', $conflict['query'])
                ->where('is_applied', false)
                ->exists();

            if ($exists) {
                $this->line(" - Suggestion already pending.");
                continue;
            }

            $urls = $conflict['urls']->pluck('url')->toArray();
            
            $analysis = $radar->analyzeConflict($conflict['query'], $urls);

            if ($analysis) {
                SeoRedirectSuggestion::create([
                    'type' => 'CANNIBAL',
                    'source_url' => $urls[0] == $analysis['master_url'] ? $urls[1] : $urls[0],
                    'suggested_url' => $analysis['master_url'],
                    'confidence' => 100,
                    'reason' => $analysis['reason'],
                    'metadata' => [
                        'query' => $conflict['query'],
                        'competing_urls' => $urls,
                        'suggested_action' => $analysis['action']
                    ]
                ]);
                $this->info(" - AI SUGGESTION: {$analysis['action']} for Master: {$analysis['master_url']}");
            }
        }

        $this->info("Resolution Scan Complete.");
        return 0;
    }
}
