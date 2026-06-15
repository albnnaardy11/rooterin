<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$key = config('ai.groq_key');
$response = \Illuminate\Support\Facades\Http::withToken($key)->get('https://api.groq.com/openai/v1/models');
$models = $response->json('data');
foreach($models as $m) {
    echo $m['id'] . "\n";
}
