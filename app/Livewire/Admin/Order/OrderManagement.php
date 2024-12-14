<?php

// namespace App\Livewire\Admin\Order;


// use Livewire\Component;
// use App\Models\Order;

// class OrderManagement extends Component
// {
//     public $orders;
//     public $selectedOrder;
//     public $orderStatus;

//     public function mount()
//     {
//         // Load initial orders
//         $this->orders = Order::with('items', 'user', 'deliveryOption')->get();
//     }

//     public function selectOrder($orderId)
//     {
//         // Load selected order details
//         $this->selectedOrder = Order::with('items', 'user', 'deliveryOption')->find($orderId);
//         $this->orderStatus = $this->selectedOrder->order_status;
//     }

//     public function updateOrderStatus()
//     {
//         $this->selectedOrder->update(['order_status' => $this->orderStatus]);
//         session()->flash('message', 'Order status updated successfully.');
//     }

//     public function render()
//     {
//         return view('livewire.admin.order.order-management');
//     }
// }




namespace App\Livewire\Admin\Order;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;

class OrderManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $selectedOrder;
    public $orderStatus;

    protected $queryString = ['search', 'statusFilter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function selectOrder($orderId)
    {
        $this->selectedOrder = Order::with('items', 'user', 'deliveryOption')->find($orderId);
        $this->orderStatus = $this->selectedOrder->order_status;
    }

    public function updateOrderStatus()
    {
        if ($this->selectedOrder) {
            $this->selectedOrder->update(['order_status' => $this->orderStatus]);
            session()->flash('message', 'Order status updated successfully.');
            $this->dispatchBrowserEvent('close-modal');
        }
    }

    public function render()
    {
        $orders = Order::with('items', 'user', 'deliveryOption')
            ->when($this->search, function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('order_status', $this->statusFilter);
            })
            ->paginate(10);

        return view('livewire.admin.order.order-management', [
            'orders' => $orders,
        ]);
    }
}
