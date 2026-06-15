<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "DEBUG START\n";
$ai = config('ai');
echo "AI CONFIG TYPE: " . gettype($ai) . "\n";
if ($ai) {
    echo "AI CONFIG CONTENT:\n";
    print_r($ai);
} else {
    echo "AI CONFIG IS NULL OR EMPTY\n";
}
echo "DEBUG END\n";
