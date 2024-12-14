<div class="w-full max-w-[85rem] py-6 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="py-6 bg-gray-50 font-poppins dark:bg-gray-800 rounded-lg">
        <div class="px-4 py-4 mx-auto max-w-7xl lg:py-6 md:px-6">
            <div class="flex flex-wrap mb-16 -mx-3">
                <div class="w-full px-3 lg:w-full">
                    <!-- Grid layout for product items -->
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-2 md:grid-cols-5">
                        @foreach ($products as $product)
                        <div class="group border-gray-100/30 flex w-full max-w-xs flex-col self-center overflow-hidden rounded-lg border bg-white shadow-md">
                            <a class="relative mx-1 mt-1 flex h-44 overflow-hidden rounded-xl" href="/products/{{$product->slug}}">
                                @php
                                    $images = $product->images;
                                    $firstImage = !empty($images) ? $images[0] : null;
                                    $secondImage = !empty($images) && count($images) > 1 ? $images[1] : null;
                                @endphp
                                @if ($firstImage)
                                    <img class="peer absolute top-0 right-0 h-full w-full object-cover" src="{{ asset('storage/' . $firstImage) }}" alt="{{ $product->translation->name ?? 'Product Image' }}">
                                @else
                                    <img class="peer absolute top-0 right-0 h-full w-full object-cover" src="https://via.placeholder.com/300" alt="Placeholder">
                                @endif
                                @if ($secondImage)
                                    <img class="peer peer-hover:right-0 absolute top-0 -right-96 h-full w-full object-cover transition-all delay-100 duration-1000 hover:right-0" src="{{ asset('storage/' . $secondImage) }}" alt="{{ $product->translation->name ?? 'Product Image' }}">
                                @endif
                                {{-- <svg class="group-hover:animate-ping group-hover:opacity-30 peer-hover:opacity-0 pointer-events-none absolute inset-x-0 bottom-5 mx-auto text-3xl text-white transition-opacity" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"><path fill="currentColor" d="M2 10a4 4 0 0 1 4-4h20a4 4 0 0 1 4 4v10a4 4 0 0 1-2.328 3.635a2.996 2.996 0 0 0-.55-.756l-8-8A3 3 0 0 0 14 17v7H6a4 4 0 0 1-4-4V10Zm14 19a1 1 0 0 0 1.8.6l2.7-3.6H25a1 1 0 0 0 .707-1.707l-8-8A1 1 0 0 0 16 17v12Z" /></svg> --}}
                            </a>
                            <div class="mt-1 px-5 pb-5 text-center">
                                <a href="/products/{{$product->slug}}">
                                    <h5 class="text-sm tracking-tight text-blue-500">{{ $product->translation->name ?? 'No name available' }}</h5>
                                </a>
                                <div class="mt-1 mb-1  items-center">
                                    <p >
                                        <span class="text-sm font-bold text-blue-500 ">${{ $product->price }}</span>
                                        @if ($product->original_price)
                                            <span class="text-sm text-white line-through ">${{ $product->original_price }}</span>
                                        @endif
                                    </p>
                                </div>
                                <h2>Customer Reviews ({{ $product->reviews->count() }})</h2>

                                <p>Average Rating: {{ number_format($product->averageRating(), 1) }}/5</p>

                                <div class="rating-stars">
                                    @php
                                        $averageRating = $product->averageRating(); // Get the average rating
                                        $fullStars = floor($averageRating); // Full stars
                                        $halfStar = $averageRating - $fullStars >= 0.5 ? true : false; // Half star if necessary
                                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0); // Empty stars
                                    @endphp

                                    <!-- Full stars -->
                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <i class="fa fa-star star-filled"></i>
                                    @endfor

                                    <!-- Half star -->
                                    @if ($halfStar)
                                        <i class="fa fa-star-half-alt star-filled"></i>
                                    @endif

                                    <!-- Empty stars -->
                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <i class="fa fa-star star-empty"></i>
                                    @endfor
                                </div>


                                {{-- <a href="#" wire:click.prevent="addToCart({{ $product->id }})" class="hover:border-white/40 flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-5 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4 focus:ring-blue-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Add to cart
                                </a> --}}

                                <a href="#" wire:click.prevent="addToCart({{ $product->id }})" class="hover:border-white/40 flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-5 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4 focus:ring-blue-300">
                                    <!-- Button content that changes on loading -->
                                    <span wire:loading.remove wire:target="addToCart({{ $product->id }})" class="text-xs flex items-center">
                                        <!-- Shopping cart icon -->
                                        {{-- <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg> --}}
                                        Add to cart
                                    </span>

                                    <!-- Loading state (Cart icon spins) -->
                                    <span wire:loading wire:target="addToCart({{ $product->id }})" class="flex items-center">
                                        <!-- Spinning cart icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="animate-spin mr-0 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </span>
                                </a>




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
