<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'parent_id', 'image', 'active'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class);
    }
    public function getNameInLocale($locale = 'en')
    {
        return $this->translations->firstWhere('locale', $locale)->name ?? $this->name;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function getTranslatedName($locale = 'en')
    {
        $translation = $this->translations()->where('locale', $locale)->first();
        return $translation ? $translation->name : $this->name;
    }
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
//     public function getDepthAttribute()
// {
//     $depth = 0;
//     $parent = $this->parent;

//     while ($parent) {
//         $depth++;
//         $parent = $parent->parent; // Traverse up the hierarchy
//     }

//     return $depth;
// }

public function getInLocale($locale)
{
    // Retrieve the translation for the specific locale
    $translation = $this->translations()->where('locale', $locale)->first();

    // Check if the translation exists for the given locale
    if ($translation && $translation->name) {
        return $translation->name;
    }

    // Optionally, fallback to default locale (e.g., English 'en') if needed
    $fallbackTranslation = $this->translations()->where('locale', 'en')->first();

    // If a fallback is found, return the fallback translation, otherwise return the original name
    return $fallbackTranslation ? $fallbackTranslation->name : $this->name;
}
public function isParent()
{
    return $this->subcategories()->exists();
}


}
