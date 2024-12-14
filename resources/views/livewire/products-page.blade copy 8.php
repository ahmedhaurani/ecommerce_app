<div class="w-full max-w-[85rem] py-6 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="py-8 bg-gray-100 font-poppins dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="px-4 py-6 mx-auto max-w-7xl lg:py-8 md:px-6">
            <div class="flex flex-wrap mb-12 -mx-3">
                <div class="w-full px-1 lg:w-full">
                    <!-- Grid layout for product items -->
                    <div class="grid grid-cols-2 gap-6 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5">
                        @foreach ($products as $product)
                        <div class="group border-gray-200 dark:border-gray-700 flex flex-col w-full max-w-xs overflow-hidden rounded-lg border bg-white dark:bg-gray-900 shadow-md transition-transform transform hover:scale-105">
                            <a class="relative mx-2 mt-2 flex h-48 overflow-hidden rounded-xl" href="/products/{{$product->slug}}">
                                @php
                                    $images = $product->images;
                                    $firstImage = !empty($images) ? $images[0] : null;
                                    $secondImage = !empty($images) && count($images) > 1 ? $images[1] : null;
                                @endphp
                                @if ($firstImage)
                                    <img class="absolute inset-0 h-full w-full object-cover transition-opacity duration-500 peer-hover:opacity-0" src="{{ asset('storage/' . $firstImage) }}" alt="{{ $product->translation->name ?? 'Product Image' }}">
                                @else
                                    <img class="absolute inset-0 h-full w-full object-cover" src="https://via.placeholder.com/300" alt="Placeholder">
                                @endif
                                @if ($secondImage)
                                    <img class="absolute inset-0 h-full w-full object-cover transition-all duration-500 opacity-0 peer-hover:opacity-100" src="{{ asset('storage/' . $secondImage) }}" alt="{{ $product->translation->name ?? 'Product Image' }}">
                                @endif
                            </a>
                            <div class="mt-0 px-2 pb-5 text-center">
                                <a href="/products/{{$product->slug}}">
                                    <h5 class="text-xs text-gray-700 dark:text-gray-200">{{ $product->translation->name ?? 'No name available' }}</h5>
                                </a>
                                <div class="mt-0 mb-0">
                                    <span class="text-sm font-bold text-blue-500">${{ $product->price }}</span>
                                    @if ($product->original_price)
                                        <span class="text-sm text-gray-400 line-through ml-2">${{ $product->original_price }}</span>
                                    @endif
                                </div>

                                <!-- Customer Reviews Section -->
                                {{-- <h5 class="text-sm font-medium text-gray-600 dark:text-gray-400">Customer Reviews ({{ $product->reviews->count() }})</h5> --}}
                                {{-- <p class="text-gray-600 dark:text-gray-400 text-sm">Average Rating: {{ number_format($product->averageRating(), 1) }}/5</p> --}}
                                <div class="rating-stars flex justify-center my-2">
                                    @php
                                        $averageRating = $product->averageRating();
                                        $fullStars = floor($averageRating);
                                        $halfStar = $averageRating - $fullStars >= 0.5;
                                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                    @endphp

                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <i class="fa fa-star star-filled"></i>
                                    @endfor

                                    @if ($halfStar)
                                        <!-- Apply a class to flip the half-star in RTL mode -->
                                        <i class="fa fa-star-half-alt star-filled" :class="{'rtl-flip': document.documentElement.dir === 'rtl'}"></i>
                                    @endif

                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <i class="fa fa-star star-empty"></i>
                                    @endfor
                                </div>




                                <!-- Add to Cart Button -->
                                <a href="#" wire:click.prevent="addToCart({{ $product->id }})" class="hover:bg-blue-700 hover:ring-2 hover:ring-blue-400 transition duration-300 flex items-center justify-center rounded-md bg-blue-600 px-1 py-2 text-xs font-medium text-white focus:outline-none focus:ring-4 focus:ring-blue-300">
                                    <span wire:loading.remove wire:target="addToCart({{ $product->id }})">
                                        Add to Cart
                                    </span>
                                    <span wire:loading wire:target="addToCart({{ $product->id }})" class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="animate-spin mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Adding...
                                    </span>
                                </a>
                            </div>
                        </div>
                        @endforeach
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
