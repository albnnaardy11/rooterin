<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SeoCity extends Model
{
    protected $fillable = ['name', 'slug', 'region', 'description_prefix', 'lsi_keywords', 'is_active'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($city) {
            if (empty($city->slug)) {
                $city->slug = Str::slug($city->name);
            }
        });
    }

    public function reviews()
    {
        return $this->hasMany(LocalizedReview::class);
    }
}
