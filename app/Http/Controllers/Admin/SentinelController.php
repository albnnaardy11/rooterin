<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Sentinel\SentinelService;
use Illuminate\Http\Request;

class SentinelController extends Controller
{
    protected $sentinel;

    public function __construct(SentinelService $sentinel)
    {
        $this->sentinel = $sentinel;
    }

    /**
     * Display the System Sentinel Dashboard.
     */
    public function index()
    {
        $healthData = $this->sentinel->monitorAll();
        
        return view('admin.sentinel.index', compact('healthData'));
    }

    /**
     * Run a manual deep scan and return the results.
     */
    public function scan()
    {
        $healthData = $this->sentinel->monitorAll();
        
        return response()->json([
            'success' => true,
            'message' => 'System scan completed successfully.',
            'data' => $healthData
        ]);
    }

    /**
     * Receive heartbeat from client-side AI engine.
     */
    public function heartbeat(Request $request)
    {
        $fps = $request->input('fps', 30);
        $latency = $request->input('latency', 100);

        \Illuminate\Support\Facades\Cache::put('sentinel_neural_fps', [
            'fps' => $fps,
            'latency' => $latency,
            'timestamp' => now()->toIso8601String()
        ], 60); // Keep for 1 minute

        return response()->json(['status' => 'Heartbeat received']);
    }
}
