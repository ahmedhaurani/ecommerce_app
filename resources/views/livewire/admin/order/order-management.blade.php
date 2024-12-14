<div class="container">
    <h2 class="my-4">Order Management</h2>

    <!-- Filters -->
    <div class="mb-4 flex flex-wrap items-center gap-4">
        <input type="text" wire:model.live="search" placeholder="Search by name, email, phone..."
            class="form-control w-full md:w-1/3" />

        <select wire:model.live="statusFilter" class="form-control w-full md:w-1/4">
            <option value="">Filter by Status</option>
            <option value="pending">Pending</option>
            <option value="processing">Processing</option>
            <option value="shipped">Shipped</option>
            <option value="delivered">Delivered</option>
            <option value="canceled">Canceled</option>
        </select>
    </div>

    <!-- Orders Table -->
    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>${{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <span class="badge
                                    @if($order->order_status == 'pending') bg-warning
                                    @elseif($order->order_status == 'processing') bg-info
                                    @elseif($order->order_status == 'shipped') bg-primary
                                    @elseif($order->order_status == 'delivered') bg-success
                                    @elseif($order->order_status == 'canceled') bg-danger
                                    @endif">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-primary" wire:click="selectOrder({{ $order->id }})" data-toggle="modal" data-target="#orderModal">
                                    View Details
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    @if($selectedOrder)
        <div wire:ignore.self class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderModalLabel">Order Details (#{{ $selectedOrder->id }})</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Customer:</strong> {{ $selectedOrder->first_name }} {{ $selectedOrder->last_name }}</p>
                        <p><strong>Email:</strong> {{ $selectedOrder->email }}</p>
                        <p><strong>Phone:</strong> {{ $selectedOrder->phone }}</p>
                        <p><strong>Delivery:</strong> {{ $selectedOrder->deliveryOption ? $selectedOrder->deliveryOption->name : 'No delivery option selected' }}</p>
                        <p><strong>Total Amount:</strong> ${{ number_format($selectedOrder->total_amount, 2) }}</p>

                        <h5>Order Items</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($selectedOrder->items as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->unit_price, 2) }}</td>
                                        <td>${{ number_format($item->total_price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Change Order Status -->
                        <div class="form-group">
                            <label for="orderStatus">Order Status</label>
                            <select id="orderStatus" wire:model="orderStatus" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="canceled">Canceled</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" wire:click="updateOrderStatus" class="btn btn-success">Update Status</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
