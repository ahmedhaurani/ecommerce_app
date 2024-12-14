<section class="testimonials bg-gray-100 mb-10 py-10">
    <!-- Last Products Carousel -->
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Last Products</h2>
    <div class="swiper lastProductsSwiper mb-10" wire:ignore>
        <div class="swiper-wrapper py-12">
            @foreach ($lastProducts as $product)
                <div class="swiper-slide" wire:key="last-product-{{ $product->id }}">
                    <div class="p-4 bg-white rounded-lg shadow-lg transform transition-transform hover:scale-105">
                        <!-- Product Card Content without Separate Blade Include -->
                        <div class="group relative border-gray-200 dark:border-gray-700 flex flex-col w-full max-w-xs overflow-hidden rounded-lg border bg-white dark:bg-gray-900 shadow-md transition-transform transform hover:scale-105">
                            <a class="relative mx-2 mt-2 flex h-48 overflow-hidden rounded-xl" href="/products/{{$product->slug}}">
                                @php
                                    $images = is_string($product->images) ? json_decode($product->images, true) : $product->images;
                                    $firstImage = $images[0] ?? 'https://via.placeholder.com/300';
                                    $secondImage = $images[1] ?? null;
                                @endphp
                                <img class="absolute inset-0 h-full w-full object-cover transition-opacity duration-500 peer-hover:opacity-0" src="{{ asset('storage/' . ltrim($firstImage, '/')) }}" alt="{{ $product->translation->name ?? 'Product Image' }}">
                                @if ($secondImage)
                                    <img class="absolute inset-0 h-full w-full object-cover transition-opacity duration-500 opacity-0 peer-hover:opacity-100" src="{{ asset('storage/' . ltrim($secondImage, '/')) }}" alt="{{ $product->translation->name ?? 'Product Image' }}">
                                @endif

                                @if (!$product->isInStock())
                                    <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-semibold px-2 py-1 rounded">Out of Stock</span>
                                @endif
                                @if ($product->sale_price)
                                    <span class="absolute top-2 right-2 bg-green-600 text-white text-xs font-semibold px-2 py-1 rounded">Sale</span>
                                @endif
                            </a>
                            <div class="mt-0 px-2 pb-5 text-center">
                                <a href="/products/{{$product->slug}}">
                                    <h5 class="text-xs text-gray-700 dark:text-gray-200">{{ $product->translation->name ?? 'No name available' }}</h5>
                                </a>
                                <div class="mt-0 mb-0">
                                    @if ($product->sale_price)
                                        <span class="text-sm font-bold text-red-500">${{ number_format($product->sale_price, 2) }}</span>
                                        <span class="text-sm text-gray-400 line-through ml-2">${{ number_format($product->price, 2) }}</span>
                                    @else
                                        <span class="text-sm font-bold text-blue-500">${{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
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
                    </div>
                </div>
            @endforeach
        </div>
        <div class="swiper-button-next text-gray-500 hover:text-gray-700"></div>
        <div class="swiper-button-prev text-gray-500 hover:text-gray-700"></div>
        <div class="swiper-pagination"></div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Initialize Swiper without reinitialization
        const lastProductsSwiper = new Swiper('.lastProductsSwiper', {
            loop: true,
            slidesPerView: 4,
            spaceBetween: 30,
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            autoplay: { delay: 8500, disableOnInteraction: false },
            breakpoints: {
                0: { slidesPerView: 2 },
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 4 },
                1280: { slidesPerView: 4 }
            }
        });

        // Listen to Livewire update without reinitializing Swiper
        Livewire.hook('message.processed', (message, component) => {
            // Swiper is not re-initialized to avoid DOM conflicts
            console.log('Livewire processed message, no swiper reinit needed');
        });
    });
</script>
@endpush
