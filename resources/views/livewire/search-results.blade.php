
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

