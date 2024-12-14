<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="py-10 bg-gray-50 font-poppins dark:bg-gray-800 rounded-lg">
        <div class="px-4 py-4 mx-auto max-w-7xl lg:py-6 md:px-6">
            <div class="flex flex-wrap mb-24 -mx-3">
                {{-- <div class="w-full pr-2 lg:w-1/4 lg:block">
                    <!-- Sidebar content here -->
                    <div class="p-4 mb-5 bg-white border border-gray-200 dark:border-gray-900 dark:bg-gray-900">
                        <h2 class="text-2xl font-bold dark:text-gray-400">Categories</h2>
                        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
                        <ul>
                            @foreach($categories as $category)
                            <li class="mb-4" wire:key="category-{{ $category->id }}">
                                <label class="flex items-center dark:text-gray-400">
                                    <input type="checkbox" wire:model.live="selectedCategories"
                                        value="{{ $category->id }}" class="w-4 h-4 mr-2">
                                    <span class="text-lg">{{ $category->translations->first()->name ?? $category->name
                                        }}</span>
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Brands Filter -->
                    <div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
                        <h2 class="text-2xl font-bold dark:text-gray-400">Brands</h2>
                        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
                        <ul>
                            @foreach($brands as $brand)
                            <li class="mb-4" wire:key="brand-{{ $brand->id }}">
                                <label class="flex items-center dark:text-gray-300">
                                    <input type="checkbox" wire:model="selectedBrands" value="{{ $brand->id }}"
                                        class="w-4 h-4 mr-2">
                                    <span class="text-lg dark:text-gray-400">{{ $brand->translations->first()->name ??
                                        $brand->name }}</span>
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div> --}}
                <div class="w-full px-3 lg:w-4/4">
                    {{-- <div class="px-3 mb-4">
                        <div
                            class="items-center justify-between hidden px-3 py-2 bg-gray-100 md:flex dark:bg-gray-900 ">
                            <div class="flex items-center justify-between">
                                <select wire:model.live="sortBy"
                                    class="block w-40 text-base bg-gray-100 cursor-pointer dark:text-gray-400 dark:bg-gray-900">
                                    <option value="latest">Sort by Latest</option>
                                    <option value="oldest">Sort by Oldest</option>
                                    <option value="low_price">Sort by Low Price</option>
                                    <option value="high_price">Sort by High Price</option>
                                </select>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Grid layout for product items -->
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 md:grid-cols-4">
                        @foreach ($products as $product)
                        <div class="bg-white border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden relative">
                            <!-- Out of Stock Badge -->
                            @if ($product->in_stock <= 0)
                                <div class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded">
                                    Out of Stock
                                </div>
                            @endif

                            <a href="/products/{{$product->slug}}" class="">
                                @php
                                    $images = $product->images;
                                    $firstImage = !empty($images) ? $images[0] : null;
                                @endphp
                                @if ($firstImage)
                                    <img src="{{ asset('storage/' . $firstImage) }}" alt="" class="object-cover w-full h-56 mx-auto">
                                @else
                                    <img src="https://via.placeholder.com/300" alt="Placeholder" class="object-cover w-full h-56 mx-auto">
                                @endif
                            </a>

                            <div class="p-3">
                                <div class="flex items-center justify-between gap-2 mb-2">
                                    <h3 class="text-xl font-medium dark:text-gray-400">
                                        {{ $product->translation->name ?? 'No name available' }}
                                    </h3>
                                </div>
                                <p class="text-lg">
                                    <span class="text-green-600 dark:text-green-600">{{ $product->price }}</span>
                                </p>
                            </div>

                            <div class="flex justify-center p-4 border-t border-gray-300 dark:border-gray-700">
                                <a wire:click.prevent="addToCart({{$product->id}})" href="#"
                                    class="text-gray-500 flex items-center space-x-2 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="w-4 h-4 bi bi-cart3" viewBox="0 0 16 16">
                                        <path
                                            d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z">
                                        </path>
                                    </svg>
                                    <button class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded"
                                        wire:click="addToCart({{ $product->id }}, {{ $variation_id ?? 'null' }})">Add to
                                        Cart
                                    <span wire:loading
                                        wire:target="addToCart({{ $product->id }}, {{ $variation_id ?? 'null' }})">Adding..</span>
                                    </button>
                                </a>
                            </div>
                        </div>

                    @endforeach
                </div>
                <!-- Pagination -->
                <div class="flex justify-end mt-6">
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                </div>
                <!-- End Pagination -->
            </div>
        </div>
</div>
</section>
</div>
