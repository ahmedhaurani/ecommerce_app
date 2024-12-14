<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="overflow-hidden bg-white py-11 font-poppins dark:bg-gray-800">
        <div class="max-w-6xl px-4 py-4 mx-auto lg:py-8 md:px-6">
            <div class="flex flex-wrap -mx-4">

                <div class="w-full mb-8 md:w-1/2 md:mb-0" x-data="carousel({{ json_encode($images) }})">
                    <div class="relative">
                        <!-- Main Image -->
                        <div class="relative mb-6 lg:mb-10 lg:h-2/4">
                            <img :src="currentImage" alt="Main Product Image"
                                class="object-cover w-full h-64 lg:h-full rounded-md shadow-lg">
                        </div>

                        <!-- Carousel Controls -->
                        <div class="absolute top-1/2 transform -translate-y-1/2 flex justify-between w-full px-4">
                            <button @click="prev" class="bg-gray-300 p-2 rounded-full hover:bg-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-800">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 19.5L8.25 12l7.5-7.5" />
                                </svg>
                            </button>
                            <button @click="next" class="bg-gray-300 p-2 rounded-full hover:bg-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-800">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Thumbnails -->
                    <div class="flex mt-4 space-x-2">
                        <template x-for="(image, index) in images" :key="index">
                            <div class="w-20 h-20 overflow-hidden rounded-md cursor-pointer hover:opacity-75"
                                @click="setCurrentImage(image)">
                                <img :src="image" alt="Thumbnail" class="object-cover w-full h-full">
                            </div>
                        </template>
                    </div>
                </div>
                <div class="w-full px-4 md:w-1/2 ">
                    <div class="lg:pl-20">
                        <div class="mb-8 ">
                            <h2 class="max-w-xl mb-6 text-2xl font-bold dark:text-gray-400 md:text-4xl">
                                {{$translation->name}}</h2>
                            <p class="inline-block mb-6 text-4xl font-bold text-gray-700 dark:text-gray-400 ">
                                <span> {{$product->price}}</span>
                                <span
                                    class="text-base font-normal text-gray-500 line-through dark:text-gray-400">$1800.99</span>
                            </p>
                            <p class="max-w-md text-gray-700 dark:text-gray-400">
                                {!! $translation->description !!}
                                {{--
                            <h2 class="text-2xl font-semibold">Overview</h2>
                            <ul>
                                <li><strong>Display:</strong> 6.1-inch Super Retina XDR display</li>
                                <li><strong>Processor:</strong> A15 Bionic chip with 6-core CPU and 4-core GPU</li>
                                <li><strong>Camera:</strong> Dual 12MP camera system with Ultra Wide and Wide cameras,
                                    Night mode, 4K Dolby Vision HDR recording</li>
                                <li><strong>Battery Life:</strong> Up to 19 hours of video playback</li>
                                <li><strong>5G Capabilities:</strong> Superfast 5G for faster download and upload speeds
                                </li>
                                <li><strong>Operating System:</strong> iOS 15 with all-new features</li>
                            </ul> --}}
                        </div>
                        <div>
                            <!-- Livewire Quantity Control -->
                            <div class="w-32 mb-8">
                                <label for=""
                                    class="w-full pb-1 text-xl font-semibold text-gray-700 border-b border-blue-300 dark:border-gray-600 dark:text-gray-400">Quantity</label>
                                <div class="relative flex flex-row w-full h-10 mt-6 bg-transparent rounded-lg">
                                    <button wire:click='decrement'
                                        class="w-20 h-full text-gray-600 bg-gray-300 rounded-l outline-none cursor-pointer dark:hover:bg-gray-700 dark:text-gray-400 hover:text-gray-700 dark:bg-gray-900 hover:bg-gray-400">
                                        <span class="m-auto text-2xl font-thin">-</span>
                                    </button>
                                    <input type="number" readonly
                                        class="flex items-center w-full font-semibold text-center text-gray-700 placeholder-gray-700 bg-gray-300 outline-none dark:text-gray-400 dark:placeholder-gray-400 dark:bg-gray-900 focus:outline-none text-md hover:text-black"
                                        placeholder="{{$quantity}}">
                                    <button wire:click='increment'
                                        class="w-20 h-full text-gray-600 bg-gray-300 rounded-r outline-none cursor-pointer dark:hover:bg-gray-700 dark:text-gray-400 dark:bg-gray-900 hover:text-gray-700 hover:bg-gray-400">
                                        <span class="m-auto text-2xl font-thin">+</span>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <h1>{{ $translation->name }}</h1>
                                <p>{{ $translation->description }}</p>

                                <!-- Display product variations -->
                                <div>
                                    @if($product->variations->isNotEmpty())
                                        <h2>Available Variations:</h2>
                                        <div class="flex flex-wrap gap-4">
                                            @foreach($product->variations as $variation)
                                                @php
                                                    $variationTranslation = $variation->translation;
                                                @endphp
                                                <button
                                                    wire:click="$set('selectedVariation', {{ $variation->id }})"
                                                    class="px-4 py-2 border rounded-md
                                                        {{ $selectedVariation == $variation->id ? 'bg-orange-500 text-white' : 'border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white' }}">
                                                    {{ $variationTranslation ? $variationTranslation->name : 'Variation not available' }}
                                                    - {{ $variation->price }}
                                                </button>
                                            @endforeach
                                        </div>
                                    @else
                                        <p>No variations available for this product.</p>
                                    @endif
                                </div>


                                <!-- Quantity input -->
                                {{-- <div>
                                    <label for="quantity">Quantity:</label>
                                    <input type="number" id="quantity" wire:model="quantity" min="1"
                                        value="{{ $quantity }}">
                                </div> --}}

                                <!-- Add to cart button -->
                                <button wire:click="addToCart">Add to Cart</button>
                            </div>




                            <button wire:click="addToCart({{ $product->id }}, {{ $variation_id ?? 'null' }})">Add to
                                Cart</button>

                            <div class="flex flex-wrap items-center gap-4">
                                <button  wire:click="addToCart({{ $product->id }}, {{ $variation_id ?? 'null' }})"
                                    class="w-full p-4 bg-blue-500 rounded-md lg:w-2/5 dark:text-gray-200 text-gray-50 hover:bg-blue-600 dark:bg-blue-500 dark:hover:bg-blue-700">
                                    Add to carti</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
<script>
    function carousel(images) {
        return {
            images: images.map(image => `{{ asset('storage/') }}/${image}`),
            currentImage: `{{ asset('storage/') }}/${images[0]}`,
            currentIndex: 0,
            next() {
                this.currentIndex = (this.currentIndex + 1) % this.images.length;
                this.currentImage = this.images[this.currentIndex];
            },
            prev() {
                this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                this.currentImage = this.images[this.currentIndex];
            },
            setCurrentImage(image) {
                this.currentImage = image;
                this.currentIndex = this.images.indexOf(image);
            }
        }
    }
</script>
