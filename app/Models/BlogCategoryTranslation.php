<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategoryTranslation extends Model
{
    protected $fillable = ['blog_category_id', 'locale', 'name'];

    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class);
    }
}
