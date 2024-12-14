<?php

namespace App\Livewire\Admin\Order;
use Illuminate\Support\Facades\Log;


use Livewire\Component;
use App\Models\Order;

class OrderDetails extends Component
{
    public $orderId;
    public $order;
    public $tempOrderStatus; // Temporary variable

    public function mount($orderId)
    {
        $this->orderId = $orderId;
        $this->loadOrder();
        $this->tempOrderStatus = $this->order->order_status; // Initialize temporary status

    }

    public function loadOrder()
    {
        $this->order = Order::with('items', 'deliveryOption')->findOrFail($this->orderId);
    }

    public function render()
    {
        return view('livewire.admin.order.order-details');
    }

    public function test() {
        dd("hi");
    }
    public function updateOrderStatus()
    {

        Log::info('Updating order status:', [
            'order_id' => $this->order->id,
            'new_status' => $this->tempOrderStatus,
        ]);

        // Update the order status
        $this->order->order_status = $this->tempOrderStatus;
        $this->order->save();

        session()->flash('message', 'Order status updated successfully.');
        $this->loadOrder(); // Reload the order to reflect changes
    }


}
