<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventLog extends Model
{
    protected $fillable = ['event_type', 'page_url', 'device_type', 'ip_address', 'metadata'];
    
    protected $casts = [
        'metadata' => 'json'
    ];
}
