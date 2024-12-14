<?php

namespace App\Models;
use App\Traits\FormatsPrice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\DeliveryOption;

class Order extends Model
{
    use HasFactory;
    use FormatsPrice;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'country',
        'city',
        'address',
        'payment_method',
        'delivery_option_id',
        'total_amount',
        'order_status',
    ];

    // Define the relationship with OrderItem
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryOption()
{
    return $this->belongsTo(DeliveryOption::class);
}

public function formattedPrice($amount)
{
    return number_format($amount);
}

}
