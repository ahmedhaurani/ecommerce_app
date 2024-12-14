<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
        {{ __('checkout.checkout') }}
    </h1>

    @if (session()->has('error'))
        <div class="bg-red-500 text-white p-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('success'))
        <div class="bg-green-500 text-white p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent='placeOrder'>
        <div class="grid grid-cols-12 gap-4">
            <div class="md:col-span-12 lg:col-span-8 col-span-12">
                <!-- Card -->
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <!-- Shipping Address -->
                    <div class="mb-6">
                        <h2 class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                            {{ __('checkout.shipping_address') }}
                        </h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="first_name">
                                    {{ __('checkout.first_name') }}
                                </label>
                                <input wire:model='first_name'
                                    class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none"
                                    id="first_name" type="text">
                                @error('first_name')
                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="last_name">
                                    {{ __('checkout.last_name') }}
                                </label>
                                <input wire:model='last_name'
                                    class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none"
                                    id="last_name" type="text">
                                @error('last_name')
                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="phone">
                                {{ __('checkout.phone') }}
                            </label>
                            <input wire:model='phone'
                                class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none"
                                id="phone" type="text">
                            @error('phone')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="address">
                                {{ __('checkout.address') }}
                            </label>
                            <input wire:model='address'
                                class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none"
                                id="address" type="text">
                            @error('address')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="city">
                                {{ __('checkout.city') }}
                            </label>
                            <input wire:model='city'
                                class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none"
                                id="city" type="text">
                            @error('city')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="country">
                                    {{ __('checkout.country') }}
                                </label>
                                <input wire:model='country'
                                type="text"
                                class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none"
                                id="country"
                                value="{{ app()->getLocale() === 'ar' ? 'العراق' : 'Iraq' }}"
                                disabled
                            >

                                @error('country')
                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="email">
                                    {{ __('checkout.email') }}
                                </label>
                                <input wire:model='email'
                                    class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none"
                                    id="email" type="text">
                                @error('email')
                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="text-lg font-semibold mb-4">
                        {{ __('checkout.select_delivery_option') }}
                    </div>
                    <ul class="grid w-full gap-6 md:grid-cols-2">
                        @foreach($delivery_options as $option)
                            <li wire:key='{{$option->id}}' wire:click="calculateShippingCost">
                                <input wire:model='delivery' type="radio" name="delivery" value="{{ $option->id }}" id="delivery-{{ $option->id }}" class="hidden peer" required />
                                <label for="delivery-{{ $option->id }}" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600">
                                    <div class="block">
                                        <div class="w-full text-lg font-semibold">
                                            {{ $option->name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $option->description }} - {{ number_format($option->price) }}
                                        </div>
                                    </div>
                                </label>
                            </li>
                        @endforeach
                    </ul>

                    <div class="text-lg font-semibold mb-4">
                        {{ __('checkout.select_payment_method') }}
                    </div>
                    <ul class="grid w-full gap-6 md:grid-cols-2">
                        <li>
                            <input wire:model='payment_method' class="hidden peer" id="payment-cod" type="radio" value="cod" required />
                            <label for="payment-cod" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                        {{ __('checkout.cash_on_delivery') }}
                                    </div>
                                </div>
                            </label>
                        </li>
                        <li>
                            <input wire:model='payment_method' class="hidden peer" id="payment-stripe" type="radio" value="stripe" />
                            <label for="payment-stripe" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                        {{ __('checkout.stripe') }}
                                    </div>
                                </div>
                            </label>
                        </li>
                    </ul>
                </div>
                <!-- End Card -->
            </div>
            <div class="md:col-span-12 lg:col-span-4 col-span-12">
                <!-- Order Summary Section -->
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        {{ __('checkout.order_summary') }}
                    </div>
                    <div class="flex justify-between mb-2 font-bold dark:text-white">
                        <span>{{ __('checkout.subtotal') }}</span>
                        <span>{{ $grand_total }}</span>
                    </div>
                    <div class="flex justify-between mb-2 font-bold dark:text-white">
                        <span>{{ __('checkout.taxes') }}</span>
                        <span>0.00</span>
                    </div>
                    <div class="flex justify-between mb-2 font-bold dark:text-white">
                        <span>{{ __('checkout.shipping_cost') }}</span>
                        <span>{{ $formatPrice($shipping_cost) }}</span>
                    </div>
                    <hr class="bg-slate-400 my-4 h-1 rounded">
                    <div class="flex justify-between mb-2 font-bold dark:text-white">
                        <span>{{ __('checkout.grand_total') }}</span>
                        <span>{{ $total }}</span>
                    </div>
                </div>

                <!-- Place Order Button -->
                <button type='submit' class="bg-green-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-green-600">
                    <span wire:loading.remove>{{ __('checkout.place_order') }}</span>
                    <span wire:loading>{{ __('checkout.processing') }}</span>
                </button>

                <!-- Basket Summary Section -->
                <div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        {{ __('checkout.basket_summary') }}
                    </div>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700" role="list">
                        @foreach ($cart_items as $ci)
                            <li class="py-3 sm:py-4" wire:key={{ $ci['product_id'] }}>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <img alt="{{ $ci['name'] }}" class="w-12 h-12 rounded-full" src="{{ $ci['image'] ? asset('storage/' . $ci['image']) : 'https://via.placeholder.com/150' }}" >

                                        {{-- <img alt="{{ __('checkout.product_image') }}" class="w-12 h-12 rounded-full" src="https://iplanet.one/cdn/shop/files/iPhone_15_Pro_Max_Blue_Titanium_PDP_Image_Position-1__en-IN_1445x.jpg?v=1695435917"> --}}
                                    </div>
                                    <div class="flex-1 min-w-0 ms-4">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ $ci['name'] }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                            {{ __('checkout.quantity') }}: {{ $ci['quantity'] }}
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        {{ $formatPrice($ci['total_amount']) }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
