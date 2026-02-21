<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SentinelRiskProfile extends Model
{
    protected $fillable = ['ip_address', 'trust_score', 'violation_count', 'is_bot_probability', 'last_seen_at', 'behavior_metadata'];
    protected $casts = ['behavior_metadata' => 'array'];
}
