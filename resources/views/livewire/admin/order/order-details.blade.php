<div class="container my-5">
    <h2 class="mb-4">Order Details (#{{ $order->id }})</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Customer Information</h5>
            <p><strong>Customer:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Phone:</strong> {{ $order->phone }}</p>
            <p><strong>Delivery:</strong> {{ $order->deliveryOption ? $order->deliveryOption->name : 'No delivery option selected' }}</p>
            <p><strong>Order Amount:</strong> <span class="text-success font-weight-bold">{{ $order->formattedPrice($order->total_amount) }}</span></p>
            <p><strong>Total Amount:</strong> <span class="text-danger font-weight-bold">{{ $order->formattedPrice($order->total_amount + $order->deliveryOption->price) }}</span></p>

        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Order Items</h5>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            @php
                                $images = json_decode($item->product->images);
                            @endphp
                            @if ($images && count($images) > 0)
                                <img src="{{ Storage::url($images[0]) }}" alt="{{ $item->getTranslatedProductName() }}" style="width: 50px; height: auto;" />
                            @else
                                <span>No Image</span>
                            @endif
                        </td>
                        <td>
                            {{ $item->getTranslatedProductName() }} -
                            {{ $item->getTranslatedVariationName() }}
                        </td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $order->formattedPrice($item->unit_price) }}</td>
                        <td>{{ $order->formattedPrice($item->total_price) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    @php
                        $subtotal = $order->items->sum('total_price');
                        $deliveryFee = $order->deliveryOption ? $order->deliveryOption->price : 0;
                        $total = $subtotal + $deliveryFee;
                    @endphp
                    <tr>
                        <td colspan="4" class="text-right"><strong>Subtotal:</strong></td>
                        <td>{{ $order->formattedPrice($subtotal) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Delivery Fee:</strong></td>
                        <td>{{ $order->formattedPrice($deliveryFee) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Total:</strong></td>
                        <td>{{ $order->formattedPrice($total) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


    <div>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Change Order Status</h5>
                <div class="form-group">
                    <label for="orderStatus">Order Status</label>
                    <select id="orderStatus" wire:model="tempOrderStatus" class="form-control mb-3">
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="canceled">Canceled</option>
                    </select>
                    <button wire:click="updateOrderStatus" class="btn btn-primary">Update Status</button>
                </div>

                @if (session()->has('message'))
                    <div class="alert alert-success mt-2">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
        </div>

        <button wire:click="test" class="btn btn-primary">Update Status</button>
    </div>
</div>
