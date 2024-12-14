<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto" >
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-semibold mb-4">{{ __('Shopping cCart') }}</h1>
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Cart Items -->
            <div class="md:w-3/4">
                <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} font-semibold">{{ __('Product') }}</th>
                                <th class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} font-semibold">{{ __('Price') }}</th>
                                <th class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} font-semibold">{{ __('Quantity') }}</th>
                                <th class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} font-semibold">{{ __('Total') }}</th>
                                <th class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} font-semibold">{{ __('Remove') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cart_items as $item)
                            <tr wire:key="{{ $item['product_id'] }}">
                                <td class="py-4">
                                    <div class="flex {{ app()->getLocale() === 'ar' ? 'flex-row' : 'flex-row' }} items-center">
                                        <img class="h-16 w-16 {{ app()->getLocale() === 'ar' ? 'ml-4' : 'mr-4' }}"
                                            src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://via.placeholder.com/150' }}"
                                            alt="{{ $item['name'] }}">
                                        <div>
                                            <span class="font-semibold">{{ $item['name'] }}</span><br>
                                            @if(isset($item['variation_name']))
                                            <span class="text-sm text-gray-500">{{ $item['variation_name'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4">{{ $formatPrice($item['unit_amount']) }}</td>
                                <td class="py-4">
                                    <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'flex-row' : '' }}">
                                        <button wire:click="decreaseQuantity({{ $item['product_id'] }}, {{ $item['variation_id'] ?? 'null' }})"
                                            class="border rounded-md py-2 px-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}">
                                            -
                                        </button>
                                        <span class="text-center w-8">{{ $item['quantity'] }}</span>
                                        <button wire:click="increaseQuantity({{ $item['product_id'] }}, {{ $item['variation_id'] ?? 'null' }})"
                                            class="border rounded-md py-2 px-4 {{ app()->getLocale() === 'ar' ? 'mr-2' : 'ml-2' }}">
                                            +
                                        </button>
                                    </div>
                                </td>
                                <td class="py-4">{{ $formatPrice($item['total_amount']) }}</td>
                                <td>
                                    <button wire:click="removeItem({{ $item['product_id'] }}, {{ $item['variation_id'] ?? 'null' }})"
                                        class="border-2 rounded-lg px-3 py-1 hover:bg-red-700 hover:text-white bg-red-500">
                                        <span wire:loading.remove
                                            wire:target="removeItem({{ $item['product_id'] }}, {{ $item['variation_id'] ?? 'null' }})">
                                            <i class="fas fa-trash-alt text-white"></i>
                                        </span>
                                        <span wire:loading
                                            wire:target="removeItem({{ $item['product_id'] }}, {{ $item['variation_id'] ?? 'null' }})">...</span>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center">{{ __('No items in cart') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Summary -->
            <div class="md:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Summary') }}</h2>
                    <div class="flex justify-between mb-2">
                        <span>{{ __('Subtotal') }}</span>
                        <span>{{ $formatPrice($grand_total) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>{{ __('Taxes') }}</span>
                        <span>0.00</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>{{ __('Shipping') }}</span>
                        <span>0.00</span>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">{{ __('Total') }}</span>
                        <span class="font-semibold">{{ $formatPrice($grand_total) }}</span>
                    </div>
                    @if ($cart_items)
                    <a href="{{ route('checkout.show') }}" class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full text-center block">
                        {{ __('Checkout') }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
