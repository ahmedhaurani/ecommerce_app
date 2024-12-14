<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-semibold mb-4">{{ __('cart.shopping_cart') }}
        </h1>

        <!-- Flex container to align Cart and Summary side-by-side on large screens -->
        <div class="flex flex-col md:flex-row gap-4">

            <!-- Cart Items -->
            <div class="md:w-3/4">
                <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
                    <table class="w-full hidden md:table">
                        <thead>
                            <tr>
                                <th class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} font-semibold">{{ __('cart.image') }}</th>
                                <th class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} font-semibold">{{ __('cart.product') }}</th>
                                <th class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} font-semibold">{{ __('cart.price') }}</th>
                                <th class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} font-semibold">{{ __('cart.quantity') }}</th>
                                <th class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} font-semibold">{{ __('cart.total') }}</th>
                                <th class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} font-semibold">{{ __('cart.remove') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cart_items as $item)
                            <tr wire:key="{{ $item['product_id'] }}">
                                <td class="py-4">
                                    <img class="h-16 w-16" src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://via.placeholder.com/150' }}" alt="{{ $item['name'] }}">
                                </td>
                                <td class="py-4">
                                    <div>
                                        <span class="font-semibold">{{ $item['name'] }}</span><br>
                                        @if(isset($item['variation_name']))
                                            <span class="text-sm text-gray-500">{{ $item['variation_name'] }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4">{{ $formatPrice($item['unit_amount']) }}</td>
                                <td class="py-4">
                                    <div class="flex items-center ">
                                        <button wire:click="decreaseQuantity({{ $item['product_id'] }}, {{ $item['variation_id'] ?? 'null' }})" class="border rounded-md py-2 px-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}">-</button>
                                        <span class="text-center w-8">{{ $item['quantity'] }}</span>
                                        <button wire:click="increaseQuantity({{ $item['product_id'] }}, {{ $item['variation_id'] ?? 'null' }})" class="border rounded-md py-2 px-4 {{ app()->getLocale() === 'ar' ? 'mr-2' : 'ml-2' }}">+</button>
                                    </div>
                                </td>
                                <td class="py-4">{{ $formatPrice($item['total_amount']) }}</td>
                                <td>
                                    <button wire:click="removeItem({{ $item['product_id'] }}, {{ $item['variation_id'] ?? 'null' }})" class="border-2 rounded-lg px-3 py-1 hover:bg-red-700 hover:text-white bg-red-500">
                                        <i class="fas fa-trash-alt text-white"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center">{{ __('cart.no_items') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Mobile View - Stacked Layout -->
                    <div class="block md:hidden">
                        @forelse ($cart_items as $item)
                        <div class="flex items-start py-4 border-b ">
                            <!-- Image -->
                            <img class="w-24 h-24 {{ app()->getLocale() === 'ar' ? 'ml-4' : 'mr-4' }}" src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://via.placeholder.com/150' }}" alt="{{ $item['name'] }}">

                            <!-- Product Details -->
                            <div class="flex-1">
                                <div class="font-semibold text-base mb-2 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">{{ $item['name'] }}</div>
                                @if(isset($item['variation_name']))
                                    <div class="text-sm text-gray-500 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">{{ __('cart.flavor') }}: {{ $item['variation_name'] }}</div>
                                @endif
                                <div class="text-sm text-gray-700 font-semibold mb-2 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">{{ __('cart.price') }}: {{ $formatPrice($item['unit_amount']) }}</div>
                                <div class="flex items-center justify-between mt-4">
                                    <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : 'flex-row' }}">
                                        <button wire:click="decreaseQuantity({{ $item['product_id'] }}, {{ $item['variation_id'] ?? 'null' }})" class="border rounded-md py-1 px-3 text-sm {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}">-</button>
                                        <span class="mx-2">{{ $item['quantity'] }}</span>
                                        <button wire:click="increaseQuantity({{ $item['product_id'] }}, {{ $item['variation_id'] ?? 'null' }})" class="border rounded-md py-1 px-3 text-sm {{ app()->getLocale() === 'ar' ? 'mr-2' : 'ml-2' }}">+</button>
                                    </div>
                                    <button wire:click="removeItem({{ $item['product_id'] }}, {{ $item['variation_id'] ?? 'null' }})" class="text-red-600 text-sm hover:text-red-500 flex items-center">
                                        <i class="fa-solid fa-x  {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"></i>
                                    </button>
                                    {{-- <button wire:click="removeItem({{ $item['product_id'] }}, {{ $item['variation_id'] ?? 'null' }})"
                                    class="bg-red-500 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg text-xs flex items-center justify-center">
                                    <i class="fas fa-trash-alt"></i>
                                </button> --}}
                                </div>
                                <div class="mt-2 font-semibold text-lg ">{{ __('cart.total') }}: {{ $formatPrice($item['total_amount']) }}</div>
                            </div>
                        </div>
                        @empty
                        <div class="py-4 text-center">{{ __('cart.no_items') }}</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Summary Section - Aligned beside Cart Items on Large Screens -->
            <div class="md:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold mb-4 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">{{ __('cart.summary') }}</h2>
                    <div class="flex justify-between mb-2 {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
                        <span>{{ __('cart.subtotal') }}</span>
                        <span>{{ $formatPrice($grand_total) }}</span>
                    </div>
                    <div class="flex justify-between mb-2 {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
                        <span>{{ __('cart.shipping') }}</span>
                        <span>0.00</span>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between mb-2 {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
                        <span class="font-semibold">{{ __('cart.total') }}</span>
                        <span class="font-semibold">{{ $formatPrice($grand_total) }}</span>
                    </div>
                    @if ($cart_items)
                    <a href="{{ locale_route('checkout.show') }}" class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full text-center block">
                        {{ __('cart.checkout') }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
