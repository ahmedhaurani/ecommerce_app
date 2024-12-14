<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="container mx-auto px-4">
      <h1 class="text-2xl font-semibold mb-4">Shopping Cart</h1>
      <div class="flex flex-col md:flex-row gap-4">
        <div class="md:w-3/4">
          <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
            <table class="w-full">
              <thead>
                <tr>
                  <th class="text-left font-semibold">Product</th>
                  <th class="text-left font-semibold">Price</th>
                  <th class="text-left font-semibold">Quantity</th>
                  <th class="text-left font-semibold">Total</th>
                  <th class="text-left font-semibold">Remove</th>
                </tr>
              </thead>
              <tbody>

                @forelse ($cart_items as $item)
                <tr wire:key="{{ $item['product_id'] }}">
                    <td class="py-4">
                        <div class="flex items-center">
                            <img class="h-16 w-16 mr-4" src="https://via.placeholder.com/150" alt="Product image">
                            <div>
                                <span class="font-semibold">{{ $item['name'] }}</span><br>
                                @if(isset($item['variation_name']))
                                    <span class="text-sm text-gray-500">{{ $item['variation_name'] }}</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="py-4">{{ $item['unit_amount'] }}</td>
                    <td class="py-4">
                        <div class="flex items-center">
                            <button
                                wire:click="decreaseQuantity({{ $item['product_id'] }}, {{ $item['variation_id'] ?? 'null' }})"
                                class="border rounded-md py-2 px-4 mr-2">
                                -
                            </button>
                            <span class="text-center w-8">{{ $item['quantity'] }}</span>
                            <button
                                wire:click="increaseQuantity({{ $item['product_id'] }}, {{ $item['variation_id'] ?? 'null' }})"
                                class="border rounded-md py-2 px-4 ml-2">
                                +
                            </button>
                        </div>
                    </td>
                    <td class="py-4">{{ $item['total_amount'] }}</td>
                    <td>
                        <button
                        wire:click="removeItem({{ $item['product_id'] }}, {{ $item['variation_id'] ?? 'null' }})"
                        class="bg-slate-300 border-2 border-slate-400 rounded-lg px-3 py-1 hover:bg-red-500 hover:text-white hover:border-red-700">
                        <span wire:loading.remove wire:target="removeItem({{ $item['product_id'] }}, {{ $item['variation_id'] ?? 'null' }})">Remove</span>
                        <span wire:loading wire:target="removeItem({{ $item['product_id'] }}, {{ $item['variation_id'] ?? 'null' }})">Removing...</span>
                    </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-4 text-center">No items in cart</td>
                </tr>
            @endforelse


                <!-- More product rows -->
              </tbody>
            </table>
          </div>
        </div>
        <div class="md:w-1/4">
          <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Summary</h2>
            <div class="flex justify-between mb-2">
              <span>Subtotal</span>
              <span>{{ $grand_total }}</span>
            </div>
            <div class="flex justify-between mb-2">
              <span>Taxes</span>
              <span>$1.99</span>
            </div>
            <div class="flex justify-between mb-2">
              <span>Shipping</span>
              <span>$0.00</span>
            </div>
            <hr class="my-2">
            <div class="flex justify-between mb-2">
              <span class="font-semibold">Total</span>
              <span class="font-semibold">$21.98</span>
            </div>
            @if ($cart_items)
            <button class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full">Checkout</button>

            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
