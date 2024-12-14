

<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto rounded-lg" :dir="document.documentElement.dir">
    <section class="overflow-hidden bg-white py-11 font-poppins dark:bg-gray-800 rounded-lg">

        <div class="max-w-6xl px-4 py-4 mx-auto lg:py-8 md:px-6">
            <div class="flex flex-wrap -mx-4" :class="{'flex-row-reverse': document.documentElement.dir === 'rtl'}">

                <div class="w-full mb-8 md:w-1/2 md:mb-0" x-data="carousel({{ json_encode($images) }})">
                    <!-- Main Image Display -->
                    <div
                        class="relative w-full h-[400px] bg-gray-100 flex items-center justify-center rounded-lg overflow-hidden"
                        @mousedown="startDrag($event)"
                        @mousemove="drag($event)"
                        @mouseup="endDrag($event)"
                        @mouseleave="endDrag($event)"
                        @touchstart="startDrag($event)"
                        @touchmove="drag($event)"
                        @touchend="endDrag($event)">
                        <img :src="currentImage" alt="Main Product Image"
                            @click="openModal(currentImage)"
                            class="object-contain w-full h-full cursor-pointer transition-transform transform hover:scale-105">
                        <!-- Previous Button -->
                        <button @click="prevImage"
                            class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-gray-300 p-2 rounded-full hover:bg-gray-400 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6 text-gray-800">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                        </button>
                        <!-- Next Button -->
                        <button @click="nextImage"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gray-300 p-2 rounded-full hover:bg-gray-400 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6 text-gray-800">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </div>

                    <!-- Thumbnails -->
                    <div class="flex mt-4 space-x-2 justify-center">
                        <template x-for="(image, index) in images" :key="index">
                            <div :class="{'ring-2 ring-blue-500': currentIndex === index}"
                                class="w-16 h-16 rounded-lg overflow-hidden cursor-pointer hover:opacity-75 transition"
                                @click="selectImage(index)">
                                <img :src="image" alt="Thumbnail"
                                    class="object-cover w-full h-full">
                            </div>
                        </template>
                    </div>

                    <!-- Zoom Modal -->
                    <div x-show="isModalOpen" @click.away="closeModal"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 px-4">
                        <div @click.stop class="relative max-w-screen-sm w-full md:max-w-screen-md lg:max-w-screen-lg">
                            <!-- Close Button -->
                            <button @click="closeModal"
                                class="absolute top-4 right-4 bg-white p-2 rounded-full z-50 shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6 text-black">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <!-- Zoomed Image -->
                            <div class="relative w-full h-[80vh] flex items-center justify-center overflow-hidden">
                                <img :src="modalImage" alt="Zoomed Image"
                                    @mousemove="zoomImage($event)"
                                    @mouseleave="resetZoom"
                                    class="object-contain w-full h-full transition-transform transform"
                                    :style="zoomStyles">
                            </div>
                        </div>
                    </div>
                </div>






                <!-- Product Details -->
                <div class="w-full px-4 md:w-1/2">
                    <span>
                        <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="text-blue-500 hover:underline">{{ __('product.home') }}</a>

                        /
                        <a href="{{ route('brands.index', ['locale' => app()->getLocale()]) }}"
                           class="text-blue-500 hover:underline">
                           {{ __('product.brands') }}
                        </a>

                        / <a href="{{ route('brands.products', ['locale' => app()->getLocale(), 'brand_slug' => $product->brand->id]) }}"
                            class="text-blue-500 hover:underline">
                            {{ $product->brand->getTranslatedName() }}
                         </a>


                    </span>
                                        </span>

                    <div class="lg:pl-20">

                        <!-- Product Title -->
                        <div class="mb-4">
                            <h2 class="max-w-xl mb-6 text-3xl font-bold text-gray-800 dark:text-gray-400 md:text-4xl">
                                {{$translation->name}}
                            </h2>
                            <!-- Stock Badge -->
                            @if($product->in_stock > 0)
                            <span
                                class="inline-block px-3 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded-full">
                                {{ __('product.in_stock') }}
                            </span>
                            @else
                            <span
                                class="inline-block px-3 py-1 text-xs font-semibold text-red-800 bg-red-200 rounded-full">
                                {{ __('product.out_of_stock') }}
                            </span>
                            @endif

                            <!-- Discount Badge -->
                            @if(isset($discountPercentage) && $discountPercentage > 0)
                            <span
                                class="inline-block ml-2 px-3 py-1 text-xs font-semibold text-white bg-red-500 rounded-full">
                                {{ $discountPercentage }}% {{ __('product.sale') }}
                            </span>
                            @endif
                            <!-- Rating Stars -->
                            <div class="rating-stars flex justify-start items-center my-2">

                                @php
                                $averageRating = $product->averageRating();
                                $fullStars = floor($averageRating);
                                $halfStar = $averageRating - $fullStars >= 0.5;
                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                @endphp

                                @for ($i = 0; $i < $fullStars; $i++) <i class="fa fa-star star-filled"></i>
                                    @endfor

                                    @if ($halfStar)
                                    <!-- Apply a class to flip the half-star in RTL mode -->
                                    <i class="fa fa-star-half-alt star-filled"
                                        :class="{'rtl-flip': document.documentElement.dir === 'rtl'}"></i>
                                    @endif

                                    @for ($i = 0; $i < $emptyStars; $i++) <i class="fa fa-star star-empty"></i>
                                        @endfor
                                        {{ number_format($product->averageRating(), 1) }}/5 ({{
                                        $product->reviews->count() }})
                            </div>

                          <!-- Price Section -->
<div class="inline-block mb-2 text-4xl font-bold text-gray-700 dark:text-gray-400">
    @if(!is_null($product->sale_price) && $product->sale_price < $product->price)
        <span class="text-red-600">
            {{ number_format($product->sale_price) }} {{ __('general.currency_symbol') }}
        </span>
        <span class="text-base font-bold text-gray-500 line-through dark:text-gray-400">
            {{ number_format($product->price) }} {{ __('general.currency_symbol') }}
        </span>
    @else
        <span>
            {{ number_format($product->price) }} {{ __('general.currency_symbol') }}
        </span>
    @endif
</div>



                            <!-- Description -->
                            {{-- <p class="max-w-md text-gray-700 dark:text-gray-400">
                                {!! $translation->description !!}
                            </p> --}}
                        </div>



                    <!-- Quantity Control -->
<div class="w-32 mb-8" :class="{ 'text-right': document.documentElement.dir === 'rtl' }">
    <label for="quantity"
        class="w-full pb-1 text-lg font-semibold text-gray-700 border-b border-blue-300 dark:border-gray-600 dark:text-gray-400">
        {{ __('product.quantity') }}
    </label>
    <div class="relative flex flex-row w-full h-10 mt-6 bg-transparent rounded-lg">
        <button wire:click="decrement"
            class="w-20 h-full text-gray-600 bg-gray-300 rounded-l outline-none cursor-pointer transition duration-200 hover:bg-gray-400 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-700 rtl:rounded-r rtl:rounded-l-none">
            <span class="m-auto text-2xl font-bold">-</span>
        </button>
        <input type="number" readonly
            class="flex items-center w-full font-semibold text-center text-gray-700 bg-gray-300 outline-none dark:bg-gray-900 dark:text-gray-400"
            value="{{ $quantity }}">
        <button wire:click="increment"
            class="w-20 h-full text-gray-600 bg-gray-300 rounded-r outline-none cursor-pointer transition duration-200 hover:bg-gray-400 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-700 rtl:rounded-l rtl:rounded-r-none">
            <span class="m-auto text-2xl font-bold ">+</span>
        </button>
    </div>
</div>




                        <!-- Product Variations -->
                      <!-- Product Variations -->
<div>
    @if($product->variations->isNotEmpty())
        <h2 class="text-xl font-semibold mb-2">{{ __('product.available_variations') }}</h2>
        <div class="flex flex-wrap gap-4 mb-6">
            @foreach($product->variations as $variation)
                @php
                    $variationTranslation = $variation->translation;
                @endphp
                                <button wire:click="$set('selectedVariation', {{ $variation->id }})"
                                    class="px-4 py-2 border rounded-md transition duration-200
                        {{ $selectedVariation == $variation->id ? 'bg-orange-500 text-white' : 'border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white' }}">
                    {{ $variationTranslation ? $variationTranslation->name : 'Variation not available' }}
                    - {{ $variation->price }}
                </button>
            @endforeach
        </div>
    {{-- @else
        <p class="text-gray-600">{{ __('product.no_variations') }}</p> --}}
    @endif
</div>

                        <!-- Add to Cart Button -->
                        @if($product->in_stock > 0)
                        <button wire:click="addToCart({{ $product->id }}, {{ $variation_id ?? 'null' }})"
                            class="w-full p-4 bg-blue-500 rounded-md lg:w-2/5 text-white hover:bg-blue-600 transition duration-200 dark:bg-blue-500 dark:hover:bg-blue-700  font-semibold">
                            {{ __('product.add_to_cart') }}
                        </button>
                        @else
                        <button disabled
                            class="w-full p-4 bg-gray-400 rounded-md lg:w-2/5 text-white cursor-not-allowed">
                            {{ __('product.out_of_stock') }}
                        </button>
                        @endif

                    </div>
                </div>

            </div>
            <div class="mt-10 grid grid-cols-1 md:grid-cols-1 gap-8">

                <div
                    class="text-base text-justify text-gray-800 dark:text-gray-100 p-6 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md">


                    {!! $translation->description !!}

                </div>
            </div>
            <!-- Rating Summary -->
            <div class="mt-10 grid grid-cols-1 md:grid-cols-1 gap-8">
                <!-- Rating Summary -->
                <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md">
                    <h3 class="text-3xl font-semibold text-gray-800 dark:text-gray-300">{{ __('product.rating_summary')
                        }}</h3>

                    <!-- Overall Rating Display (optional) -->
                    <div class="mt-4 flex items-center ">
                        <span class="text-4xl font-bold text-yellow-500">{{
                            number_format($product->reviews()->avg('rating'), 1) }}</span>
                        <div class="flex ml-2">
                            <div class="">

                                @php
                                $averageRating = $product->averageRating();
                                $fullStars = floor($averageRating);
                                $halfStar = $averageRating - $fullStars >= 0.5;
                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                @endphp

                                @for ($i = 0; $i < $fullStars; $i++) <i class="fa fa-star star-filled-big"></i>
                                    @endfor

                                    @if ($halfStar)
                                    <!-- Apply a class to flip the half-star in RTL mode -->
                                    <i class="fa fa-star-half-alt star-filled-big"
                                        :class="{'rtl-flip': document.documentElement.dir === 'rtl'}"></i>
                                    @endif

                                    @for ($i = 0; $i < $emptyStars; $i++) <i class="fa fa-star star-empty-big"></i>
                                        @endfor
                                        {{ number_format($product->averageRating(), 1) }}/5 ({{
                                        $product->reviews->count() }})
                            </div>

                            {{-- @for ($i = 1; $i <= $fullStars; $i++) <i
                                class="fas fa-star {{ $i <= round($product->reviews()->avg('rating')) ? 'text-yellow-500' : 'text-gray-300' }} w-6 h-6">
                                </i>
                                @endfor
                                @if ($halfStar)
                                <!-- Apply a class to flip the half-star in RTL mode -->
                                <i class="fa fa-star-half-alt star-filled-big"
                                    :class="{'rtl-flip': document.documentElement.dir === 'rtl'}"></i>
                                @endif
                                @for ($i = 0; $i < $emptyStars; $i++) <i class="fa fa-star star-empty-big"></i>
                                    @endfor --}}
                        </div>
                        <span class="ml-4 text-gray-600 dark:text-gray-400">{{ $product->reviews()->count() }}
                            reviews</span>
                    </div>

                    <!-- Rating Breakdown -->
                    <div class="flex flex-col mt-2 space-y-3 ">
                        @for($i = 5; $i >= 1; $i--)
                        <div class="flex items-center">
                            <!-- Star and Label -->
                            <span class="w-16 font-semibold text-gray-700 dark:text-gray-400 flex items-center">
                                <i class="fas fa-star text-yellow-500 mr-1"></i> {{ $i }}
                            </span>

                            <!-- Progress Bar -->
                            <div class="relative w-full h-6 bg-gray-300 rounded-lg overflow-hidden mx-3">
                                <div class="absolute top-0 left-0 h-full bg-yellow-400 rounded-lg transition-all duration-300"
                                    style="width: {{ $product->reviews()->count() ? ($ratingSummary[$i]->count ?? 0) / $product->reviews()->count() * 100 : 0 }}%">
                                </div>
                            </div>

                            <!-- Review Count -->
                            <span class="text-gray-700 dark:text-gray-400">{{ $ratingSummary[$i]->count ?? 0 }} </span>
                        </div>
                        @endfor
                    </div>
                </div>

                <!-- Submit Your Review -->
                <!-- Add Review Button -->
                <!-- Add Review Button -->

                <button wire:click="toggleReviewBox"
                    class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600">
                    {{ __('product.submit_review') }}
                </button>
                @if (session()->has('message'))
                <div class="p-4 mb-4 text-green-800 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-200">
                    {{ __('product.review_submitted') }}
                </div>
                @endif
                <!-- Review Box (conditionally displayed) -->
                @if($showReviewBox)
                <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                        {{ __('product.submit_review') }}
                    </h3>

                    @livewire('product-review', ['productId' => $product->id])

                    <!-- Close Button for Review Box -->
                    <button wire:click="toggleReviewBox"
                        class="bg-red-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-600 mt-4">
                        {{ __('product.cancel_review') }}
                    </button>
                </div>
                @endif



            </div>




            <!-- Reviews Section -->
            <!-- Reviews Section -->
            <div class="mt-10">
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ __('product.customer_reviews') }}
                </h3>
                @php
                $reviews = $product->reviews()->where('approved', true)->get();
                @endphp

                @if($reviews->isEmpty())
                <p class="mt-4 text-gray-600">{{ __('product.no_reviews') }}</p>
                @else
                @foreach($reviews as $review)
                <div class="p-4 my-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md transition-colors duration-500">
                    <p class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                        {{ $review->user ? $review->user->name : $review->name }}
                    </p>
                    <p class="flex items-center">
                        {{ __('product.rating') }}:
                        @for($i = 1; $i <= 5; $i++) <i
                            class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} w-5 h-5">
                            </i>
                            @endfor
                    </p>
                    <p class="mt-2 text-gray-700 dark:text-gray-300">{{ $review->review }}</p>
                </div>
                @endforeach
                @endif
            </div>


        </div>
    </section>


</div>

@push('scripts')
<script>
    // function carousel(images) {
    //     return {
    //         images: images.map(image => `{{ asset('storage/') }}/${image}`),
    //         currentImage: `{{ asset('storage/') }}/${images[0]}`,
    //         currentIndex: 0,
    //         next() {
    //             this.currentIndex = (this.currentIndex + 1) % this.images.length;
    //             this.currentImage = this.images[this.currentIndex];
    //         },
    //         prev() {
    //             this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
    //             this.currentImage = this.images[this.currentIndex];
    //         },
    //         setCurrentImage(image) {
    //             this.currentImage = image;
    //             this.currentIndex = this.images.indexOf(image);
    //         }
    //     }
    // }


        function carousel(images) {
    return {
        images: images.map(image => `{{ asset('storage/') }}/${image}`), // Laravel asset paths
        currentIndex: 0,
        startX: 0,
        isDragging: false,

        get currentImage() {
            return this.images[this.currentIndex];
        },

        nextImage() {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
        },

        prevImage() {
            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
        },

        selectImage(index) {
            this.currentIndex = index;
        },

        // Drag Handlers
        startDrag(event) {
            this.isDragging = true;
            this.startX = event.type === 'mousedown' ? event.clientX : event.touches[0].clientX;
        },

        drag(event) {
            if (!this.isDragging) return;

            const currentX = event.type === 'mousemove' ? event.clientX : event.touches[0].clientX;
            const deltaX = currentX - this.startX;

            // If drag exceeds threshold, move to next or previous image
            if (deltaX > 50) {
                this.prevImage();
                this.isDragging = false;
            } else if (deltaX < -50) {
                this.nextImage();
                this.isDragging = false;
            }
        },

        endDrag() {
            this.isDragging = false;
        },
    };
}




</script>


@endpush
