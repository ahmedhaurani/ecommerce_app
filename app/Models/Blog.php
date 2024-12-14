<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['slug', 'category_id', 'active', 'featured', 'image'];
    public function translations()
    {
        return $this->hasMany(BlogTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(BlogTranslation::class)->where('locale', app()->getLocale());
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }
}
