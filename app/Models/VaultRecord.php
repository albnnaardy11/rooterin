<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VaultRecord extends Model
{
    protected $fillable = ['record_id', 'payload', 'quantum_signature', 'algorithm_version', 'metadata'];
    protected $casts = ['metadata' => 'array'];
}
