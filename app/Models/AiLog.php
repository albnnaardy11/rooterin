<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiLog extends Model
{
    protected $table = 'ai_logs';
    protected $fillable = [
        'feature_name', 
        'model_used', 
        'api_key_index', 
        'latency_ms',
        'is_success',
        'error_message'
    ];

    protected $casts = [
        'is_success' => 'boolean',
    ];
}
