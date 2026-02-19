<?php

namespace App\Services\Seo;

use Google\Client;
use Google\Service\AnalyticsData;
use Illuminate\Support\Facades\Log;

class GoogleAnalyticsService
{
    protected $analyticsService;
    protected $propertyId;

    public function __construct()
    {
        $client = new Client();
        $keyPath = storage_path('app/google-service-account.json');
        
        if (file_exists($keyPath)) {
            $client->setAuthConfig($keyPath);
            $client->addScope('https://www.googleapis.com/auth/analytics.readonly');
            $this->analyticsService = new AnalyticsData($client);
            $this->propertyId = config('services.google.analytics_property_id');
        }
    }

    /**
     * Get basic GA4 stats for the dashboard.
     * 
     * @param int $days
     * @return array
     */
    public function getBasicStats(int $days = 30): array
    {
        if (!$this->analyticsService || !$this->propertyId) {
            return ['active' => false];
        }

        try {
            $request = new AnalyticsData\RunReportRequest([
                'dateRanges' => [
                    new AnalyticsData\DateRange(['startDate' => "{$days}daysAgo", 'endDate' => 'today'])
                ],
                'metrics' => [
                    new AnalyticsData\Metric(['name' => 'activeUsers']),
                    new AnalyticsData\Metric(['name' => 'screenPageViews']),
                    new AnalyticsData\Metric(['name' => 'sessions']),
                ],
                'dimensions' => [
                    new AnalyticsData\Dimension(['name' => 'date'])
                ]
            ]);

            $response = $this->analyticsService->properties->runReport("properties/{$this->propertyId}", $request);
            
            return [
                'active' => true,
                'rows' => $response->getRows(),
            ];
        } catch (\Exception $e) {
            Log::error('GA4 API Error: ' . $e->getMessage());
            return ['active' => false, 'error' => $e->getMessage()];
        }
    }
}
