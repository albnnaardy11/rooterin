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
        $agent = new Agent();
        $device = $agent->isMobile() ? 'mobile' : ($agent->isTablet() ? 'tablet' : 'desktop');

        EventLog::create([
            'event_type' => 'whatsapp_click',
            'page_url' => $request->input('url', url()->previous()),
            'device_type' => $device,
            'ip_address' => $request->ip(),
            'metadata' => [
                'browser' => $agent->browser(),
                'platform' => $agent->platform(),
                'source' => $request->input('source', 'unknown')
            ]
        ]);

        return response()->json(['status' => 'success']);
    }
}
