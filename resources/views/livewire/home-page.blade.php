<section class="bg-white w-full py-12">
    <div class="container mx-auto px-4 lg:px-8">
         <!-- Wrapper for the Image Box Section with reduced width -->
         <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Big Slider Image with fixed height on large screens -->
            <div class="lg:col-span-2 relative overflow-hidden rounded-lg shadow-lg" style="height: auto;">
                <div class="swiper bigImageSlider h-full" wire:ignore>
                    <div class="swiper-wrapper h-full">
                        @foreach($headSliderAds as $ad)
                            <div class="swiper-slide">
                                @if($ad->link)
                                    <a href="{{ $ad->link }}" target="_blank" rel="noopener noreferrer">
                                        <img src="{{ Storage::url($ad->image) }}" alt="{{ $ad->title }}" class="w-full h-full object-cover lg:max-h-[495px]">
                                    </a>
                                @else
                                    <img src="{{ Storage::url($ad->image) }}" alt="{{ $ad->title }}" class="w-full h-full object-cover lg:max-h-[495px]">
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="swiper-button-next text-gray-500 hover:text-gray-700"></div>
                    <div class="swiper-button-prev text-gray-500 hover:text-gray-700"></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>

            <!-- Static Boxes with fixed height to fit the big slider's height -->
            <div class="grid gap-4 lg:h-[495px]">
                @foreach($headSmallAds as $ad)
                    <div class="relative overflow-hidden rounded-lg shadow-lg h-60 lg:h-[240px]">
                        @if($ad->link)
                            <a href="{{ $ad->link }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ Storage::url($ad->image) }}" alt="{{ $ad->title }}" class="w-full h-full object-cover">
                            </a>
                        @else
                            <img src="{{ Storage::url($ad->image) }}" alt="{{ $ad->title }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                @endforeach
            </div>

        </div>




        <!-- Last Products Carousel -->
    <div class=" pt-12">
        <h2 class="text-2xl font-semibold text-gray-800 text-center">{{ __('product.latest_products') }}</h2>
        <div class="swiper lastProductsSwiper mb-10" wire:ignore>
            <div class="swiper-wrapper py-12">
                @foreach ($lastProducts as $product)
                    <div class="swiper-slide" wire:key="last-product-{{ $product->id }}">
                        @include('livewire.partials.product_card_content', ['product' => $product])
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-next text-gray-500 hover:text-gray-700"></div>
            <div class="swiper-button-prev text-gray-500 hover:text-gray-700"></div>
            <div class="swiper-pagination"></div>
        </div>

        <!-- Featured Products Carousel -->
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-2">{{ __('product.featured_products') }}  </h2>
        <div class="swiper featuredProductsSwiper mb-10" wire:ignore>
            <div class="swiper-wrapper py-12">
                @foreach ($featuredProducts as $product)
                    <div class="swiper-slide" wire:key="featured-product-{{ $product->id }}">
                        @include('livewire.partials.product_card_content', ['product' => $product])
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-next text-gray-500 hover:text-gray-700"></div>
            <div class="swiper-button-prev text-gray-500 hover:text-gray-700"></div>
            <div class="swiper-pagination"></div>
        </div>

        <!-- Random Products Carousel -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-2 text-center">{{ __('product.choose_for_you') }}</h2>
        <div class="swiper randomProductsSwiper mb-10" wire:ignore>
            <div class="swiper-wrapper py-12">
                @foreach ($randomProducts as $product)
                    <div class="swiper-slide" wire:key="random-product-{{ $product->id }}">
                        @include('livewire.partials.product_card_content', ['product' => $product])
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-next text-gray-500 hover:text-gray-700"></div>
            <div class="swiper-button-prev text-gray-500 hover:text-gray-700"></div>
            <div class="swiper-pagination"></div>
        </div>

                <!-- High Ordered Products Carousel -->

                <h2 class="text-2xl font-semibold text-gray-800 mb-2 text-center">{{ __('product.best_selling_products') }}</h2>
                <div class="swiper randomProductsSwiper mb-10" wire:ignore>
            <div class="swiper-wrapper py-12">
                @foreach ($highOrderedProducts as $product)
                    <div class="swiper-slide" wire:key="random-product-{{ $product->id }}">
                        @include('livewire.partials.product_card_content', ['product' => $product])
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-next text-gray-500 hover:text-gray-700"></div>
            <div class="swiper-button-prev text-gray-500 hover:text-gray-700"></div>
            <div class="swiper-pagination"></div>
        </div>

    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-12">
        @foreach($bottomSmallAds as $ad)
            <div class="relative overflow-hidden rounded-lg shadow-lg h-60">
                @if($ad->link)
                    <a href="{{ $ad->link }}" target="_blank" rel="noopener noreferrer">
                        <img src="{{ Storage::url($ad->image) }}" alt="{{ $ad->title }}" class="w-full h-full object-cover">
                    </a>
                @else
                    <img src="{{ Storage::url($ad->image) }}" alt="{{ $ad->title }}" class="w-full h-full object-cover">
                @endif
            </div>
        @endforeach
    </div>

    <div id="exampleModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-1/3 p-6">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ __('product.review_submitted') }}</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-4">{{ __('product.thank_you_for_review') }}</p>

            <div class="mt-6 flex justify-end space-x-4">
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 transition duration-200">
                    Cancel
                </button>
                <button onclick="closeModal()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-200">
                    OK
                </button>
            </div>
        </div>
    </div>

    <div id="exampleModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-1/3 p-6">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ __('product.review_submitted') }}</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-4">{{ __('product.thank_you_for_review') }}</p>

            <div class="mt-6 flex justify-end space-x-4">
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 transition duration-200">
                    Cancel
                </button>
                <button onclick="closeModal()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-200">
                    OK
                </button>
            </div>
        </div>
    </div>


    </div>
</section>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Initialize Swiper instances for each section
        function initSwiper(swiperClass, slidesPerViewDesktop = 4, slidesPerViewMobile = 2) {
            return new Swiper(`.${swiperClass}`, {
                loop: true,
                slidesPerView: slidesPerViewDesktop,
                spaceBetween: 30,
                pagination: { el: '.swiper-pagination', clickable: true },
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                autoplay: { delay: 8500, disableOnInteraction: false },
                breakpoints: {
                    0: { slidesPerView: slidesPerViewMobile },
                    640: { slidesPerView: slidesPerViewMobile },
                    1024: { slidesPerView: slidesPerViewDesktop },
                    1280: { slidesPerView: slidesPerViewDesktop }
                }
            });
        }

        // Initialize all Swipers
        initSwiper('lastProductsSwiper',6);
        initSwiper('featuredProductsSwiper', 5);
        initSwiper('randomProductsSwiper',6);
        initSwiper('highOrderedProductsSwiper');
    });
</script>
<script>
    window.livewire.on('show-verification-modal', () => {
        $('#exampleModal').removeClass('hidden').addClass('flex'); // Show modal
    });
</script>
@endpush
