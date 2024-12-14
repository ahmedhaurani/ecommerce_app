<div class="w-full max-w-[85rem] py-6 px-4 sm:px-6 lg:px-8 mx-auto" x-data="{ open: false }">
    <section class="py-8 bg-gray-100 font-poppins dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="px-4 py-6 mx-auto max-w-7xl lg:py-8 md:px-6">
            <div class="flex flex-col lg:flex-row lg:space-x-6 rtl:space-x-reverse">

                <!-- Sidebar Filters -->
                <div class="w-full lg:w-1/4 mb-6 lg:mb-0">
                    <!-- Mobile Toggle Button -->
                    <div class="flex justify-between items-center mb-4 lg:hidden">
                        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200">{{ __('product.filters') }}</h2>
                        <button @click="open = true" class="text-gray-700 dark:text-gray-200 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>

                    <!-- Sidebar Panel -->
                    <div x-show="open || window.innerWidth >= 1024"
                         x-transition:enter="transition ease-in-out duration-300 transform"
                         x-transition:enter-start="-translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transition ease-in-out duration-300 transform"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="-translate-x-full"
                         class="fixed inset-y-0 left-0 z-50 bg-white dark:bg-gray-900 p-6 lg:relative lg:block lg:z-auto lg:bg-transparent lg:dark:bg-transparent shadow lg:shadow-none w-3/4 max-w-xs lg:max-w-none lg:w-full">
                        <!-- Mobile Close Button -->
                        <div class="flex justify-between items-center mb-4 lg:hidden">
                            <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200">{{ __('product.filters') }}</h2>
                            <button @click="open = false" class="text-gray-700 dark:text-gray-200 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Filters Content -->
                        <div class="space-y-6">
                            <!-- Category Filter -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-200 mb-2">{{ __('product.category') }}</h3>
                                <div class="space-y-2 max-h-60 overflow-y-auto">
                                    @foreach($categories as $category)
                                        @include('livewire.partials.category-checkbox', ['category' => $category, 'locale' => app()->getLocale()])
                                    @endforeach
                                </div>
                            </div>

                            <!-- Brand Filter -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-200 mb-2">{{ __('product.brand') }}</h3>
                                <div class="space-y-2 max-h-60 overflow-y-auto">
                                    @foreach($brands as $brand)
                                        <label class="block">
                                            <input type="checkbox" wire:model.live="selectedBrands" value="{{ $brand->id }}" class="form-checkbox h-4 w-4 text-blue-600">
                                            <span class="ml-2 text-gray-700 dark:text-gray-300">{{ $brand->translations->first()->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Price Range Filter -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-200 mb-2">{{ __('product.price_range') }}</h3>
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <input type="number" wire:model.live="priceRange.0" class="w-20 p-2 border border-gray-300 rounded-lg" placeholder="{{ __('product.min') }}" min="0">
                                    <span class="text-gray-700 dark:text-gray-300">-</span>
                                    <input type="number" wire:model.live="priceRange.1" class="w-20 p-2 border border-gray-300 rounded-lg" placeholder="{{ __('product.max') }}" min="0">
                                </div>
                            </div>

                            <!-- Reset Filters Button -->
                            <div class="flex justify-end">
                                <button wire:click="resetFilters" class="px-4 py-2 bg-red-600 text-white rounded-lg">
                                    {{ __('product.reset_filters') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Overlay for Mobile -->
                    <div x-show="open" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden" @click="open = false" x-transition></div>
                </div>

                <!-- Main Content -->
                <div class="w-full lg:w-3/4">
                    <!-- Sorting and Grid Header -->
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200">{{ __('product.products') }}</h2>
                        <div class="hidden lg:block">
                            <select wire:model="sortBy" class="p-2 border border-gray-300 rounded-lg">
                                <option value="latest">{{ __('product.latest') }}</option>
                                <option value="price_asc">{{ __('product.price_low_to_high') }}</option>
                                <option value="price_desc">{{ __('product.price_high_to_low') }}</option>
                            </select>
                        </div>
                    </div>


                    <!-- Grid layout for product items -->
                    <div class="grid grid-cols-2 gap-6 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4">
                        @forelse ($products as $product)
                        <div class="group relative border-gray-200 dark:border-gray-700 flex flex-col w-full max-w-xs overflow-hidden rounded-lg border bg-white dark:bg-gray-900 shadow-md transition-transform transform hover:scale-105">
                            <a class="relative mx-2 mt-2 flex h-48 overflow-hidden rounded-xl" href="{{ locale_route('products.show', ['slug' => $product->slug]) }}">
                                @php
                                    $images = $product->images;
                                    $firstImage = !empty($images) ? $images[0] : null;
                                    $secondImage = !empty($images) && count($images) > 1 ? $images[1] : null;
                                @endphp
                                @if ($firstImage)
                                    <img class="absolute inset-0 h-full w-full object-cover transition-opacity duration-500 peer-hover:opacity-0" src="{{ asset('storage/' . $firstImage) }}" alt="{{ $product->translation->name ?? __('product.default_product_image') }}">
                                @else
                                    <img class="absolute inset-0 h-full w-full object-cover" src="https://via.placeholder.com/300" alt="{{ __('product.placeholder_image') }}">
                                @endif
                                @if ($secondImage)
                                    <img class="absolute inset-0 h-full w-full object-cover transition-opacity duration-500 opacity-0 peer-hover:opacity-100" src="{{ asset('storage/' . $secondImage) }}" alt="{{ $product->translation->name ?? __('product.default_product_image') }}">
                                @endif

                                <!-- Out of Stock Badge -->
                                @if (!$product->isInStock())
                                    <span class="absolute top-2 left-2 rtl:left-auto rtl:right-2 bg-red-600 text-white text-xs font-semibold px-2 py-1 rounded">
                                        {{ __('product.out_of_stock') }}
                                    </span>
                                @endif
                            </a>
                            <div class="mt-0 px-2 pb-5 text-center">
                                <a href="{{ locale_route('products.show', ['slug' => $product->slug]) }}">
                                    <h5 class="text-xs text-gray-700 dark:text-gray-200">{{ $product->translation->name ?? __('product.no_name_available') }}</h5>
                                </a>
                                <div class="mt-2">
                                    @if ($product->sale_price)
                                        <span class="text-sm font-bold text-red-500">{{ number_format($product->sale_price) }} {{ __('general.currency_symbol') }}</span>
                                        <span class="text-sm font-semibold text-gray-400 line-through ml-2">{{ number_format($product->price) }}</span>
                                    @else
                                        <span class="text-sm font-bold text-blue-500">{{ number_format($product->price) }} {{ __('general.currency_symbol') }}</span>
                                    @endif
                                </div>


                                         <!-- Customer Reviews Section -->
                                         <div class="rating-stars flex justify-center my-2">
                                            @php
                                                $averageRating = $product->averageRating();
                                                $fullStars = floor($averageRating);
                                                $halfStar = $averageRating - $fullStars >= 0.5;
                                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                            @endphp

                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="fa fa-star text-yellow-400"></i>
                                            @endfor

                                            @if ($halfStar)
                                                <i class="fa fa-star-half-alt star-filled"></i>
                                            @endif

                                            @for ($i = 0; $i < $emptyStars; $i++)
                                                <i class="fa fa-star text-gray-300"></i>
                                            @endfor
                                        </div>
                                <!-- Add to Cart Button -->
                                @if ($product->isInStock())
                                    <a href="#" wire:click.prevent="addToCart({{ $product->id }})" class="hover:bg-blue-700 hover:ring-2 hover:ring-blue-400 transition duration-300 flex items-center justify-center rounded-md bg-blue-600 px-3 py-2 text-xs font-medium text-white">
                                        <span wire:loading.remove wire:target="addToCart({{ $product->id }})">
                                            {{ __('product.add_to_cart') }}
                                        </span>
                                        <span wire:loading wire:target="addToCart({{ $product->id }})" class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="animate-spin mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            {{ __('product.adding') }}
                                        </span>
                                    </a>
                                @else
                                    <button class=" items-center justify-center rounded-md bg-gray-400 px-3 py-2 text-xs font-medium text-white cursor-not-allowed" disabled>
                                        {{ __('product.out_of_stock') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                        @empty
                            <div class="col-span-full text-center text-gray-500 dark:text-gray-400">
                                {{ __('product.no_products_found') }}
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-end mt-10">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
