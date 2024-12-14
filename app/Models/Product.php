<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\VariationTranslation;

class Product extends Model
{
    protected $fillable = [
        'slug',
        'price',
        'sale_price',
        'category_id',
        'brand_id',
        'stock',
        'sku',
        'in_stock',  // Add to fillable attributes
        'is_active', // Add to fillable attributes
        'featured',
        'translations',
        'images', // Include images in fillable attributes
    ];

    protected $casts = [
        'images' => 'array', // Cast images to array when accessing
        'in_stock' => 'boolean', // Cast to boolean
        'is_active' => 'boolean', // Cast to boolean
    ];
    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function translate($locale)
    {
        return $this->translations()->where('locale', $locale)->first();
    }

    public function getTranslation()
    {
        $locale = app()->getLocale(); // Get the current locale
        return $this->translations()->where('locale', $locale)->first();
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function translation()
    {
        return $this->hasOne(ProductTranslation::class)
            ->where('locale', app()->getLocale());
    }
    public function getTranslatedName()
    {
        // Returns the product name for the current locale
        $translation = $this->translation()->first();
        return $translation ? $translation->name : $this->name; // or a default name if translation doesn't exist
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Define the relationship with Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews()
    {
        // Return only approved reviews
        return $this->hasMany(Review::class)->where('approved', true);
    }

    public function averageRating()
    {
        // Calculate the average rating of only approved reviews
        return $this->reviews()->avg('rating');
    }
    public function isInStock()
    {
        return $this->in_stock > 0;
    }
}
