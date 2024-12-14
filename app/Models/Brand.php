<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'is_active'
    ];

    public function translations()
    {
        return $this->hasMany(BrandTranslation::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function getTranslatedName()
    {
        // Get the current application locale (e.g., 'en' or 'ar')
        $locale = app()->getLocale();

        // Retrieve the translation based on the current locale
        $translation = $this->translations()->where('locale', $locale)->first();

        // Return the translated name if available; otherwise, return the default name
        return $translation ? $translation->name : $this->name;
    }

}
