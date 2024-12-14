<?php

namespace App\Models;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariationTranslation extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the plural form of the model name
    protected $table = 'variation_translations';

    // Define fillable fields for mass assignment
    protected $fillable = [
        'variation_id',
        'locale',
        'name',
    ];

    /**
     * Get the variation that owns the translation.
     */
    public function variation()
    {
        return $this->belongsTo(ProductVariation::class, 'variation_id');
    }
}
