<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth; // Import Auth Facade to get the authenticated user

class MyOrdersPage extends Component
{
    public $orders; // Property to hold the user's orders

    public function mount()
    {
        // Fetch all orders for the currently authenticated user
        $this->orders = Order::with('items') // Load related order items
            ->where('user_id', Auth::id()) // Only fetch orders for the authenticated user
            ->latest() // Order by the most recent first
            ->get();
    }

    public function render()
    {
        return view('livewire.my-orders-page', [
            'orders' => $this->orders, // Pass orders to the view
        ]);
    }
}
