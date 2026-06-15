<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$key = config('ai.groq_key');
$model = "groq/compound-mini"; // WHO KNOWS?
echo "Testing Model: $model with fake image data...\n";

$response = \Illuminate\Support\Facades\Http::withToken($key)->post("https://api.groq.com/openai/v1/chat/completions", [
    'model' => $model,
    'messages' => [
        [
            'role' => 'user', 
            'content' => [
                ['type' => 'text', 'text' => 'hi'],
                ['type' => 'image_url', 'image_url' => ['url' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==']]
            ]
        ]
    ]
]);

echo "Status: " . $response->status() . "\n";
echo "Body: " . $response->body() . "\n";
