<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiQuota extends Model
{
    protected $table = 'ai_quotas';
    protected $fillable = [
        'feature_name', 
        'daily_limit', 
        'current_usage', 
        'last_reset_date',
        'assigned_model',
        'is_active'
    ];

    protected $casts = [
        'last_reset_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Check if quota is available and increment. Resets daily.
     */
    public function consume()
    {
        if (!$this->is_active) return false;

        if (!$this->last_reset_date || !$this->last_reset_date->isToday()) {
            $this->current_usage = 0;
            $this->last_reset_date = today();
        }

        if ($this->current_usage >= $this->daily_limit) {
            return false;
        }

        $this->current_usage++;
        $this->save();

        return true;
    }
}
