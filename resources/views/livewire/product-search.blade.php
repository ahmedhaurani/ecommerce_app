{{-- <div class="relative">
    <input type="text" wire:model.debounce.300ms="searchTerm"
           placeholder="Search for products..."
           class="w-full p-2 border rounded-lg focus:outline-none"
           wire:keydown.enter="search" />

    <!-- Live Search Results Dropdown -->
    @if(strlen($searchTerm) > 1 && count($products) > 0)
        <div class="absolute top-full left-0 w-full bg-white border rounded-lg shadow-lg mt-1 z-[1000]">
            @foreach($products as $product)
                <a href="" class="block p-2 hover:bg-gray-100">
                    {{ $product->translation->name ?? $product->name }}
                </a>
            @endforeach
        </div>
    @endif

    <!-- Full Search Results -->
    <div class="mt-4">
        <h2 class="text-lg font-semibold mb-4">Search Results for "{{ $searchTerm }}"</h2>
        @if(count($products) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($products as $product)
                    <a href="" class="block p-4 border rounded-lg hover:shadow-lg">
                        <h3 class="text-gray-800">{{ $product->translation->name ?? $product->name }}</h3>
                        <p class="text-gray-600">{{ $product->price }}</p>
                    </a>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No products found matching "{{ $searchTerm }}"</p>
        @endif
    </div>
</div> --}}


<div class="container mx-auto p-4">
    <h2 class="text-2xl font-semibold mb-4">Search Results for "{{ $query }}"</h2>

    @if($products->isEmpty())
        <p>No products found.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="border p-4 rounded-lg">
                    <h3 class="text-xl font-semibold">{{ $product->name }}</h3>
                    <p>{{ $product->description }}</p>
                    <a href="{{ route('products.show', $product->id) }}" class="text-blue-500 hover:underline">View Product</a>
                </div>
            @endforeach
        </div>
    @endif
</div>

