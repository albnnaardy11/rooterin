<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$user = User::first();
auth()->login($user);

$routesToTest = [
    'admin/dashboard',
    'admin/projects',
    'admin/services',
    'admin/posts',
    'admin/settings',
    'admin/users',
    'admin/seo',
    'admin/vault',
    'admin/wiki',
    'admin/sentinel'
];

echo "Starting Admin Panel Audit...\n";
echo "-------------------------------\n";

foreach ($routesToTest as $uri) {
    try {
        $request = Request::create($uri, 'GET');
        $response = app()->handle($request);
        
        $status = $response->status();
        $contentLength = strlen($response->getContent());
        
        if ($status >= 200 && $status < 400) {
            echo "[SUCCESS] $uri => HTTP $status (Content: $contentLength bytes)\n";
        } else {
            echo "[ERROR]   $uri => HTTP $status\n";
            echo "          Check laravel logs for details.\n";
        }
    } catch (\Throwable $e) {
        echo "[FATAL]   $uri => " . $e->getMessage() . "\n";
    }
}

echo "-------------------------------\n";
echo "Audit Complete.\n";
