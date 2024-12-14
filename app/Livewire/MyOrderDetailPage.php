<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MyOrderDetailPage extends Component
{
    public $orderId;
    public $order;

    public function mount($orderId)
    {
        $this->orderId = $orderId;
        $this->fetchOrderDetails();
    }

    public function fetchOrderDetails()
    {
        $this->order = Order::with(['items.product.translation']) // Eager load product and translation for the current locale
            ->where('id', $this->orderId)
            ->where('user_id', Auth::id()) // Ensure the order belongs to the authenticated user
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.my-order-detail-page', [
            'order' => $this->order,
        ]);
    }
}
