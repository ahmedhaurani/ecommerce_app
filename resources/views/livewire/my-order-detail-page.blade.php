<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-4xl font-bold text-slate-500">{{ __('myorder.order_details') }}</h1>

    <!-- Grid -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mt-5">
      <!-- Customer Card -->
      <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
        <div class="p-4 md:p-5 flex gap-x-4">
          <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
            <svg class="flex-shrink-0 size-5 text-gray-600 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
              <circle cx="9" cy="7" r="4" />
              <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
              <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
          </div>
          <div class="grow">
            <p class="text-xs uppercase tracking-wide text-gray-500">{{ __('myorder.customer') }}</p>
            <div class="mt-1">{{ $order->first_name }} {{ $order->last_name }}</div>
          </div>
        </div>
      </div>
      <!-- End Card -->

      <!-- Order Date Card -->
      <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
        <div class="p-4 md:p-5 flex gap-x-4">
          <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
            <svg class="flex-shrink-0 size-5 text-gray-600 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M5 22h14" />
              <path d="M5 2h14" />
              <path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22" />
              <path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2" />
            </svg>
          </div>
          <div class="grow">
            <p class="text-xs uppercase tracking-wide text-gray-500">{{ __('myorder.order_date') }}</p>
            <h3 class="text-xl font-medium text-gray-800 dark:text-gray-200">{{ $order->created_at->format('d-m-Y') }}</h3>
          </div>
        </div>
      </div>
      <!-- End Card -->

      <!-- Order Status Card -->
      <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
        <div class="p-4 md:p-5 flex gap-x-4">
          <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
            <svg class="flex-shrink-0 size-5 text-gray-600 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 11V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h6" />
              <path d="m12 12 4 10 1.7-4.3L22 16Z" />
            </svg>
          </div>
          <div class="grow">
            <p class="text-xs uppercase tracking-wide text-gray-500">{{ __('myorder.order_status') }}</p>
            <span class="bg-yellow-500 py-1 px-3 rounded text-white shadow">{{ $order->order_status }}</span>
          </div>
        </div>
      </div>
      <!-- End Card -->

      <!-- Payment Status Card -->
      <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
        <div class="p-4 md:p-5 flex gap-x-4">
          <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
            <svg class="flex-shrink-0 size-5 text-gray-600 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M5 12s2.545-5 7-5c4.454 0 7 5 7 5s-2.546 5-7 5c-4.455 0-7-5-7-5z" />
              <path d="M12 13a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
              <path d="M21 17v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2" />
              <path d="M21 7V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2" />
            </svg>
          </div>
          <div class="grow">
            <p class="text-xs uppercase tracking-wide text-gray-500">{{ __('myorder.payment_status') }}</p>
            <span class="bg-green-500 py-1 px-3 rounded text-white shadow">{{ __('myorder.paid') }}</span>
          </div>
        </div>
      </div>
      <!-- End Card -->
    </div>
    <!-- End Grid -->

    <div class="flex flex-col md:flex-row gap-4 mt-4">
      <div class="md:w-3/4">
        <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
          <table class="w-full">
            <thead>
              <tr>
                <th class="text-left font-semibold text-center">{{ __('myorder.product') }}</th>
                <th class="text-left font-semibold text-center">{{ __('myorder.price') }}</th>
                <th class="text-left font-semibold text-center">{{ __('myorder.quantity') }}</th>
                <th class="text-left font-semibold text-center">{{ __('myorder.total') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($order->items as $item)
              <tr wire:key="53">
                <td class="py-4 text-center">
                  <div class="flex items-center">
                    @php
                      $images = json_decode($item->product->images, true);
                      $firstImage = $images[0] ?? null;
                    @endphp
                    @if ($firstImage)
                        <img class="h-16 w-16 mr-4" src="{{ asset('storage/' . $firstImage) }}" alt="Product Image" class="object-cover w-full h-56 mx-auto">
                    @else
                        <img class="h-16 w-16 mr-4" src="https://via.placeholder.com/300" alt="Placeholder" class="object-cover w-full h-56 mx-auto">
                    @endif
                    <div>
                      <span class="font-semibold">{{ $item->product->translation->name ?? __('myorder.product_name') }}</span>
                      @if($item->variation)
                          <div class="text-sm text-gray-500">{{ $item->variation->translation->name ?? __('myorder.n_a') }}</div>
                      @endif
                    </div>
                  </div>
                </td>
                <td class="py-4 text-center">{{ $order->formattedPrice($item->unit_price) }}</td>
                <td class="py-4 text-center">{{ $item->quantity }}</td>
                <td class="py-4 text-center">{{ $order->formattedPrice($item->total_price) }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
          <h1 class="font-3xl font-bold text-slate-500 mb-3">{{ __('myorder.shipping_address') }}</h1>
          <div class="flex justify-between items-center">
            <div>
              <p>{{ $order->address }}</p>
            </div>
            <div>
              <p class="font-semibold">{{ __('myorder.phone') }}:</p>
              <p>{{ $order->phone }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="md:w-1/4">
        <div class="bg-white rounded-lg shadow-md p-6">
          <h2 class="text-lg font-semibold mb-4">{{ __('myorder.summary') }}</h2>
          <div class="flex justify-between mb-2">
            <span>{{ __('myorder.subtotal') }}</span>
            <span>{{ $order->formattedPrice($order->total_amount) }}</span>
          </div>
          <div class="flex justify-between mb-2">
            <span>{{ __('myorder.taxes') }}</span>
            <span>0.00</span>
          </div>
          <div class="flex justify-between mb-2">
            <span>{{ __('myorder.shipping') }}</span>
            <span>{{ $order->formattedPrice($order->deliveryOption->price) }}</span>
          </div>
          <hr class="my-2">
          <div class="flex justify-between mb-2">
            <span class="font-semibold">{{ __('myorder.grand_total') }}</span>
            <span class="font-semibold">{{ $order->formattedPrice($order->total_amount + $order->deliveryOption->price) }}</span>
          </div>
        </div>
      </div>
    </div>
</div>
