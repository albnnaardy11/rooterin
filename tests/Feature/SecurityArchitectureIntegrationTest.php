<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use App\Services\Security\SecurityAutomationService;
use App\Services\Sentinel\SentinelService;
use Mockery;

class SecurityArchitectureIntegrationTest extends TestCase
{
    protected $start_time;
    protected $start_memory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->start_time = microtime(true);
        $this->start_memory = memory_get_usage();
        
        // Ensure app is in production mode for Security tests
        Config::set('app.env', 'production');
    }

    protected function tearDown(): void
    {
        // 4. Performance Integration: Audit
        $execution_time = (microtime(true) - $this->start_time) * 1000;
        $memory_diff = (memory_get_usage() - $this->start_memory) / 1024 / 1024;

        // Cleanup: EntropyGuard reclamation
        \App\Services\Security\EntropyGuard::reclaim();

        // 5. Sentinel Reporting Sync Logic
        // In modern Laravel testing, we can check for failures via $this->getStatus() or similar,
        // but for simplicity and reliability in this environment:
        $success = $this->status() === 0; // PHPUnit style
        $status = $success ? 'OPERATIONAL' : 'CRITICAL';
        $pulse = $status . ' (VERIFIED ELITE)';
        Cache::put('security_pulse_status', $pulse, 3600);

        if ($execution_time > 200 || $memory_diff > 40) {
            Cache::put('sentinel_test_integrity', 'THRESHOLD_VIOLATION', 3600);
        } else {
            Cache::put('sentinel_test_integrity', 'PASS', 3600);
        }

        Mockery::close();
        parent::tearDown();
    }

    /**
     * 1. Entry-Level: ProductionShield Negative Test
     */
    public function test_production_shield_forces_debug_false_on_public_ip()
    {
        // Simulate Public IP
        $this->withServerVariables(['REMOTE_ADDR' => '1.2.3.4']);
        
        // Force debug to true initially
        Config::set('app.debug', true);

        // Access any route
        $response = $this->get('/');

        // Verify ProductionShield forced app.debug to false
        $this->assertFalse(config('app.debug'), "ProductionShield FAILED to suppress debug mode for public traffic.");
    }

    /**
     * 2. Mid-Level: Boundary Value & State Analysis (AutoLockdown)
     */
    public function test_autolockdown_trigger_on_5th_failed_attempt()
    {
        $ip = '10.20.30.40';
        Cache::flush(); // Reset counters
        
        // Simulate 5 attempts (ProductionShield triggers at > 5)
        // Let's do 6 to trigger
        for ($i = 1; $i <= 6; $i++) {
            $this->withServerVariables(['REMOTE_ADDR' => $ip])
                 ->get('/api/brute-force-test');
        }

        // Verify system status in Cache (Simulating Sentinel Dashboard)
        $this->assertTrue(Cache::get('system_lockdown_active'), "AutoLockdown FAILED to trigger after 5 attempts.");
        $this->assertEquals('DISABLED', Cache::get('sentinel_shield_status'), "Sentinel Shield Status not updated to DISABLED.");
    }

    public function test_sentinel_test_integrity_sync()
    {
        // Simulate a pass
        $this->assertTrue(true);
        
        // After this test finishes, tearDown will run and set Cache
        // We can't check the current test's side effect INSIDE the test easily 
        // without complex hooks, so we verify that the SERVICE can sync.
        $sentinel = app(SentinelService::class);
        $status = $sentinel->syncSecurityPulse('OPERATIONAL');
        
        $this->assertStringContainsString('OPERATIONAL (VERIFIED)', $status);
    }
}
