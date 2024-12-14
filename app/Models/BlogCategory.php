<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $fillable = ['slug', 'active'];

    public function translations()
    {
        return $this->hasMany(BlogCategoryTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(BlogCategoryTranslation::class)->where('locale', app()->getLocale());
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }
}
