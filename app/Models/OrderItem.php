<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'variation_id',
        'name',
        'quantity',
        'unit_price',
        'total_price',
    ];

    // Define the relationship back to Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Optionally, define the relationship to Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Optionally, define the relationship to ProductVariation
    public function variation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function getTranslatedProductName()
    {
        return $this->product ? $this->product->getTranslatedName() : 'Unknown Product';
    }
    public function getTranslatedVariationName()
    {
        return $this->variation ? $this->variation->translation()->first()->name : 'No Variation';
    }
}
