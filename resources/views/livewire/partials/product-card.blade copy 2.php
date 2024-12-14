<div class="group relative border-gray-200 dark:border-gray-700 flex flex-col w-full max-w-xs overflow-hidden rounded-lg border bg-white dark:bg-gray-900 shadow-md transition-transform transform hover:scale-105">
    <a class="relative mx-2 mt-2 flex h-48 overflow-hidden rounded-xl" href="/products/{{$product->slug}}">
        @php
            $images = $product->images;
            $firstImage = $images[0] ?? 'https://via.placeholder.com/300';
            $secondImage = $images[1] ?? null;
        @endphp
        <img class="absolute inset-0 h-full w-full object-cover transition-opacity duration-500 peer-hover:opacity-0" src="{{ asset('storage/' . $firstImage) }}" alt="{{ $product->translation->name ?? 'Product Image' }}">
        @if ($secondImage)
            <img class="absolute inset-0 h-full w-full object-cover transition-opacity duration-500 opacity-0 peer-hover:opacity-100" src="{{ asset('storage/' . $secondImage) }}" alt="{{ $product->translation->name ?? 'Product Image' }}">
        @endif

        <!-- Sale Badge -->
        @if ($product->sale_price)
            <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded">
                Sale
            </span>
        @endif

        <!-- Out of Stock Badge -->
        @if (!$product->isInStock())
            <span class="absolute top-2 right-2 bg-gray-600 text-white text-xs font-semibold px-2 py-1 rounded">
                Out of Stock
            </span>
        @endif
    </a>
    <div class="mt-0 px-2 pb-5 text-center">
        <a href="/products/{{$product->slug}}">
            <h5 class="text-xs text-gray-700 dark:text-gray-200">{{ $product->translation->name ?? 'No name available' }}</h5>
        </a>
        <div class="mt-2">
            @if ($product->sale_price)
                <span class="text-sm font-bold text-red-500">${{ number_format($product->sale_price, 2) }}</span>
                <span class="text-sm text-gray-400 line-through ml-2">${{ number_format($product->price, 2) }}</span>
            @else
                <span class="text-sm font-bold text-blue-500">${{ number_format($product->price, 2) }}</span>
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
            <a href="#" wire:click.prevent="addToCart({{ $product->id }})" class="hover:bg-blue-700 hover:ring-2 hover:ring-blue-400 transition duration-300 flex items-center justify-center rounded-md bg-blue-600 px-3 py-2 text-xs font-medium text-white">
                <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Add to Cart</span>
                <span wire:loading wire:target="addToCart({{ $product->id }})" class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="animate-spin mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4z" />
                    </svg> Adding...
                </span>
            </a>
        @else
            <button class="rounded-md bg-gray-400 px-3 py-2 text-xs font-medium text-white cursor-not-allowed" disabled>Out of Stock</button>
        @endif
    </div>
</div>
