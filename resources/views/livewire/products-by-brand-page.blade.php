<div class="w-full max-w-[85rem] py-6 px-4 sm:px-6 lg:px-8 mx-auto rounded-lg">
    <section class="py-8 bg-gray-100 font-poppins dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="px-4 py-6 mx-auto max-w-7xl lg:py-8 md:px-6">
            <div class="container mx-auto py-12">
                <h1 class="text-4xl font-bold text-center mb-8">{{ $brand->getTranslatedName() }}</h1>

                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @forelse ($products as $product)
                        <div
                            class="group relative border-gray-200 dark:border-gray-700 flex flex-col w-full max-w-xs overflow-hidden rounded-lg border bg-white dark:bg-gray-900 shadow-md transition-transform transform hover:scale-105">
                            <!-- Product Image -->
                            <a class="relative mx-2 mt-2 flex h-48 overflow-hidden rounded-xl"
                                href="{{ route('products.show', ['locale' => app()->getLocale(), 'slug' => $product->slug]) }}">
                                @php
                                    $images = json_decode($product->images, true);
                                    $firstImage = $images[0] ?? 'placeholder-image.jpg';
                                    $secondImage = $images[1] ?? null;
                                @endphp

                                @if ($firstImage)
                                    <img class="absolute inset-0 h-full w-full object-cover transition-opacity duration-500 peer-hover:opacity-0"
                                        src="{{ asset('storage/' . $firstImage) }}"
                                        alt="{{ $product->translation->name ?? __('Product Image') }}">
                                @endif

                                @if ($secondImage)
                                    <img class="absolute inset-0 h-full w-full object-cover transition-all duration-500 opacity-0 peer-hover:opacity-100"
                                        src="{{ asset('storage/' . $secondImage) }}"
                                        alt="{{ $product->translation->name ?? __('Product Image') }}">
                                @endif
                            </a>

                            <!-- Sale and Stock Badges -->
                            <div class="absolute top-2 left-2 flex space-x-2">
                                @if ($product->sale_price && $product->price)
                                    @php
                                        $discountPercentage = round((($product->price - $product->sale_price) / $product->price) * 100);
                                    @endphp
                                    <span
                                        class="bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded">
                                        {{ $discountPercentage }}% {{ __('Sale') }}
                                    </span>
                                @endif
                            </div>
                            @if (!$product->isInStock())
                                <span
                                    class="absolute top-2 right-2 bg-red-600 text-white text-xs font-semibold px-2 py-1 rounded">
                                    {{ __('Out of Stock') }}
                                </span>
                            @endif

                            <!-- Product Details -->
                            <div class="mt-0 px-2 pb-5 text-center">
                                <a href="{{ route('products.show', ['locale' => app()->getLocale(), 'slug' => $product->slug]) }}">
                                    <h5 class="text-xs text-gray-700 dark:text-gray-200">
                                        {{ $product->translation->name ?? 'No name available' }}
                                    </h5>
                                </a>
                                <div class="mt-2">
                                    @if ($product->sale_price)
                                        <span class="text-sm font-bold text-red-500">{{ number_format($product->sale_price) }} {{ __('general.currency_symbol') }}</span>
                                        <span class="text-sm font-semibold text-gray-400 line-through ml-2">{{ number_format($product->price) }}</span>
                                    @else
                                        <span class="text-sm font-bold text-blue-500">{{ number_format($product->price) }} {{ __('general.currency_symbol') }}</span>
                                    @endif
                                </div>

                                <!-- Rating Stars -->
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
                                        <i class="fa fa-star-half-alt text-yellow-400"></i>
                                    @endif

                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <i class="fa fa-star text-gray-300"></i>
                                    @endfor
                                </div>

                                <!-- Add to Cart Button -->
                                @if ($product->isInStock())
                                    <a href="#" wire:click.prevent="addToCart({{ $product->id }})"
                                        class="flex items-center justify-center rounded-md bg-blue-600 px-3 py-2 text-xs font-medium text-white transition duration-300 hover:bg-blue-700 hover:ring-2 hover:ring-blue-400">
                                        {{ __('Add to Cart') }}
                                    </a>
                                @else
                                    <button
                                        class="items-center justify-center rounded-md bg-gray-400 px-3 py-2 text-xs font-medium text-white cursor-not-allowed"
                                        disabled>
                                        {{ __('Out of Stock') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-gray-500">
                            {{ __('No products found for this brand.') }}
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
