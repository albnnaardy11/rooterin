<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$models = \Illuminate\Support\Facades\Http::withToken(config('ai.groq_key'))->get('https://api.groq.com/openai/v1/models')->json('data');
foreach ($models as $m) {
    if (str_contains(strtolower($m['id']), 'vision')) {
        echo "FOUND VISION: " . $m['id'] . "\n";
    }
}
echo "MODELS: " . implode(',', collect($models)->pluck('id')->toArray()) . "\n";
