<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$key = config('ai.gemini_keys.0');
$model = "gemini-pro-vision";
echo "Testing Model: $model\n";

$response = \Illuminate\Support\Facades\Http::post("https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=$key", [
    'contents' => [['parts' => [['text' => 'hi']]]]
]);

echo "Status: " . $response->status() . "\n";
echo "Body: " . $response->body() . "\n";
