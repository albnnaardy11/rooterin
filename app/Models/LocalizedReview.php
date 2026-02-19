<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocalizedReview extends Model
{
    protected $fillable = ['seo_city_id', 'customer_name', 'location_suburb', 'rating', 'review_text', 'is_active'];

    public function city()
    {
        return $this->belongsTo(SeoCity::class, 'seo_city_id');
    }
}
