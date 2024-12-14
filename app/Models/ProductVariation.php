<?php

namespace App\Models;
use App\Models\Product;
use App\Models\VariationTranslation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the plural form of the model name
    protected $table = 'product_variations';

    // Define fillable fields for mass assignment
    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'stock',
    ];

    /**
     * Get the product that owns the variation.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the translations for the variation.
     */


     public function translations()
     {
         return $this->hasMany(VariationTranslation::class, 'variation_id');
     }
     public function translation()
     {
         return $this->hasOne(VariationTranslation::class, 'variation_id')
             ->where('locale', app()->getLocale());
     }


}
