<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SentinelBehaviorLog extends Model
{
    protected $fillable = ['risk_profile_id', 'event_name', 'risk_delta', 'context'];
    protected $casts = ['context' => 'array'];
}
