<div class="w-full max-w-[85rem] py-6 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="py-6 bg-gray-50 font-poppins dark:bg-gray-800 rounded-lg">
        <div class="px-4 py-4 mx-auto max-w-7xl lg:py-6 md:px-6">
            <div class="flex flex-wrap mb-16 -mx-3">
                <div class="w-full px-3 lg:w-full">
                    <!-- Grid layout for product items -->
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-2 md:grid-cols-5">
                        @foreach ($products as $product)
                        <div class="bg-white border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden relative shadow hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1 hover:scale-105">
                            <!-- Out of Stock Badge -->
                            @if ($product->in_stock <= 0)
                                <div class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded">
                                    Out of Stock
                                </div>
                            @endif

                            <a href="/products/{{$product->slug}}">
                                @php
                                    $images = $product->images;
                                    $firstImage = !empty($images) ? $images[0] : null;
                                @endphp
                                @if ($firstImage)
                                    <img src="{{ asset('storage/' . $firstImage) }}" alt="" class="object-cover w-full h-48 sm:h-56 mx-auto transition-transform duration-300 transform hover:scale-110">
                                @else
                                    <img src="https://via.placeholder.com/300" alt="Placeholder" class="object-cover w-full h-48 sm:h-56 mx-auto transition-transform duration-300 transform hover:scale-110">
                                @endif
                            </a>

                            <div class="p-3">
                                <h3 class="text-center text-sm sm:text-m text-gray-900 dark:text-gray-400 truncate hover:text-blue-500">
                                    {{ $product->translation->name ?? 'No name available' }}
                                </h3>
                                <p class="text-center text-sm sm:text-lg font-bold text-blue-600 dark:text-blue-500 mt-1 sm:mt-2">
                                    {{ $product->price }}
                                </p>
                            </div>

                            <div class="flex justify-center p-3 sm:p-4 border-t border-gray-300 dark:border-gray-700">
                                <button wire:click.prevent="addToCart({{$product->id}})" class="bg-blue-500 hover:bg-blue-400 text-white text-sm sm:text-base font-bold py-1 sm:py-2 px-3 sm:px-4 rounded-md transition duration-200 ease-in-out focus:outline-none">
                                    Add to Cart
                                    <span wire:loading wire:target="addToCart({{ $product->id }})">Adding..</span>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-end mt-6">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
