<div class="container mx-auto py-8">
    <div class="flex flex-wrap -mx-3">
        <!-- Sidebar for Filters -->
        <div class="w-full pr-2 lg:w-1/4 lg:block">
            <!-- Categories Filter -->
            <div class="p-4 mb-5 bg-white border border-gray-200 dark:border-gray-900 dark:bg-gray-900">
                <h2 class="text-2xl font-bold dark:text-gray-400">Categories</h2>
                <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
                <ul>
                    @foreach($categories as $category)
                        <li class="mb-4" wire:key="category-{{ $category->id }}">
                            <label class="flex items-center dark:text-gray-400">
                                <input type="checkbox" wire:model.live="selectedCategories" value="{{ $category->id }}" class="w-4 h-4 mr-2">
                                <span class="text-lg">{{ $category->translations->first()->name ?? $category->name }}</span>
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
                                <input type="checkbox" wire:model="selectedBrands" value="{{ $brand->id }}" class="w-4 h-4 mr-2">
                                <span class="text-lg dark:text-gray-400">{{ $brand->translations->first()->name ?? $brand->name }}</span>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Additional Filters (e.g., Status, Price Range) -->
            <div class="p-4 mb-5 bg-white border border-gray-200 dark:border-gray-900 dark:bg-gray-900">
                <h2 class="text-2xl font-bold dark:text-gray-400">Additional Filters</h2>
                <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>

                {{-- <!-- Status Filter -->
                <div class="mb-6">
                    <h3 class="mb-3 text-xl font-bold dark:text-gray-400">Status</h3>
                    @foreach($statuses as $status)
                        <label class="flex items-center mb-2 dark:text-gray-300">
                            <input type="checkbox" wire:model="selectedStatuses" value="{{ $status }}" class="w-4 h-4 mr-2">
                            <span>{{ ucfirst($status) }}</span>
                        </label>
                    @endforeach
                </div> --}}

                <!-- Price Range Filter -->
                <div class="mb-6">
                    <h3 class="mb-3 text-xl font-bold dark:text-gray-400">Price Range</h3>
                    <input type="range" wire:model="priceRange" min="0" max="10000" step="50" class="w-full">
                    <div class="flex justify-between mt-2">
                        <span class="dark:text-gray-300">Min: {{ $priceRange[0] }}</span>
                        <span class="dark:text-gray-300">Max: {{ $priceRange[1] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content for Products Display -->
        <div class="w-full px-3 lg:w-3/4">
            <div class="flex flex-wrap items-center">
                @foreach ($products as $product)
                    <div class="w-full px-3 mb-6 sm:w-1/2 md:w-1/3">
                        <div class="border border-gray-300 dark:border-gray-700">
                            <div class="relative bg-gray-200">
                                <a href="/products/{{$product->slug}}" class="">
                                    @php
                                        $images = $product->images;
                                        $firstImage = !empty($images) ? $images[0] : null;
                                    @endphp
                                    @if ($firstImage)
                                        <img src="{{ asset('storage/' . $firstImage) }}" alt="" class="object-cover w-full h-56 mx-auto ">
                                    @else
                                        <img src="https://via.placeholder.com/300" alt="Placeholder" class="object-cover w-full h-56 mx-auto ">
                                    @endif
                                </a>
                            </div>
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
                                <a wire:click.prevent='addToCart({{ $product->id }})' href="#" class="text-gray-500 flex items-center space-x-2 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-4 h-4 bi bi-cart3" viewBox="0 0 16 16">
                                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
                                    </svg>
                                    <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Add to Cart</span>
                                    <span wire:loading wire:target="addToCart({{ $product->id }})">Adding..</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
