<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\Sentinel\SentinelService;
use Illuminate\Support\Facades\Cache;

echo "--- Inisialisasi Black-Box & Anti-Flapping Simulation ---" . PHP_EOL;

$sentinel = app(SentinelService::class);
$reflection = new ReflectionClass($sentinel);
$method = $reflection->getMethod('checkMemoryPanic');
$method->setAccessible(true);

// Reset Counters
if (file_exists(storage_path('vault/arr_state.json'))) unlink(storage_path('vault/arr_state.json'));
Cache::forget('system_lockdown_active');

// 1. Simulasikan Lonjakan RAM (65MB)
echo "[SIMULATION] Triggering Memory Panic (65MB)..." . PHP_EOL;
$panicValue = 65 * 1024 * 1024;
$method->invoke($sentinel, $panicValue);

// 2. Verifikasi Forensik
$forensicsDir = storage_path('vault/forensics');
$files = glob($forensicsDir . '/*.json');
echo "[FORENSICS] Files captured: " . count($files) . PHP_EOL;

// 3. Simulasikan Anti-Flapping (Trigger 4x)
echo "[SIMULATION] Triggering Anti-Flapping (Reboot 4 more times)..." . PHP_EOL;
for($i=0; $i<4; $i++) {
    $method->invoke($sentinel, $panicValue);
}

$lockdown = Cache::get('system_lockdown_active');
echo "[STATUS] Bunker Mode Active: " . ($lockdown ? 'YES' : 'NO') . PHP_EOL;

$lockdown = Cache::get('system_lockdown_active');
echo "[STATUS] Bunker Mode Active: " . ($lockdown ? 'YES' : 'NO') . PHP_EOL;

echo "--- Simulation Complete ---" . PHP_EOL;
