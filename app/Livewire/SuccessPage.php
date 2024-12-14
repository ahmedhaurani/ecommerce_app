<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SuccessPage extends Component
{
    public $order;

    public function mount()
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            abort(403, 'Unauthorized action.');
        }

        // Retrieve the latest order for the authenticated user with order items
        $this->order = Order::with('items')->where('user_id', Auth::id())->latest()->first();

        // If no order is found, return a 404 error
        if (!$this->order) {
            abort(404, 'Order not found.');
        }
    }

    public function render()
    {
        return view('livewire.success-page', [
            'order' => $this->order,
        ]);
    }
}
