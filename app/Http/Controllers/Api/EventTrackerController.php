<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventLog;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class EventTrackerController extends Controller
{
    public function trackWhatsApp(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('WA Track Request:', $request->all());

        try {
            $agent = new Agent();
            $device = $agent->isMobile() ? 'mobile' : ($agent->isTablet() ? 'tablet' : 'desktop');

            $log = EventLog::create([
                'event_type' => 'whatsapp_click',
                'page_url' => $request->input('url', url()->previous()),
                'device_type' => $device,
                'ip_address' => $request->ip(),
                'metadata' => [
                    'source' => $request->input('source', 'unknown'),
                    'ua' => $request->userAgent()
                ]
            ]);
            
            \Illuminate\Support\Facades\Log::info('WA Track Success ID: ' . $log->id);
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('WA Track Error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }
}
