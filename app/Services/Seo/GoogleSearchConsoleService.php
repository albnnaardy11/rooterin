<?php

namespace App\Services\Seo;

use Google\Client;
use Google\Service\SearchConsole;
use Illuminate\Support\Facades\Log;

class GoogleSearchConsoleService
{
    protected $searchConsole;
    protected $siteUrl;

    public function __construct()
    {
        $client = new Client();
        $keyPath = storage_path('app/google-service-account.json');
        
        if (file_exists($keyPath)) {
            $client->setAuthConfig($keyPath);
            $client->addScope(SearchConsole::WEBMASTERS_READONLY);
            $this->searchConsole = new SearchConsole($client);
            $this->siteUrl = config('app.url'); // Ensure this matches exactly what's in GSC
        }
    }

    /**
     * Get search performance data.
     * 
     * @param int $days
     * @return array
     */
    public function getPerformanceStats(int $days = 30): array
    {
        if (!$this->searchConsole || !$this->siteUrl) {
            return ['active' => false];
        }

        try {
            $request = new SearchConsole\SearchAnalyticsQueryRequest();
            $request->setStartDate(now()->subDays($days)->format('Y-m-d'));
            $request->setEndDate(now()->subDays(1)->format('Y-m-d')); // GSC has delay
            $request->setDimensions(['date']);
            $request->setRowLimit(100);

            $response = $this->searchConsole->searchanalytics->query($this->siteUrl, $request);
            
            return [
                'active' => true,
                'rows' => $response->getRows(),
            ];
        } catch (\Exception $e) {
            Log::error('Google Search Console API Error: ' . $e->getMessage());
            return ['active' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Get top queries performance.
     * 
     * @param int $limit
     * @return array
     */
    public function getTopQueries(int $limit = 5): array
    {
        if (!$this->searchConsole || !$this->siteUrl) {
            return [];
        }

        try {
            $request = new SearchConsole\SearchAnalyticsQueryRequest();
            $request->setStartDate(now()->subDays(30)->format('Y-m-d'));
            $request->setEndDate(now()->subDays(1)->format('Y-m-d'));
            $request->setDimensions(['query']);
            $request->setRowLimit($limit);

            $response = $this->searchConsole->searchanalytics->query($this->siteUrl, $request);
            return $response->getRows() ?: [];
        } catch (\Exception $e) {
            Log::error('GSC Top Queries Error: ' . $e->getMessage());
            return [];
        }
    }
}
