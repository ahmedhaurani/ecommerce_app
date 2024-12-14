<div class="w-full max-w-[85rem] py-6 px-4 sm:px-6 lg:px-8 mx-auto" x-data="{ open: false }">
    <section class="py-8 bg-gray-100 font-poppins dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="px-4 py-6 mx-auto max-w-7xl lg:py-8 md:px-6">
    <h1 class="text-4xl font-bold text-center mb-8">{{ __('Brands') }}</h1>

    <!-- Responsive Grid for Brands -->
    <div class=" grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach ($brands as $brand)
            @php
                // Get the translated brand name and description
                $brandTranslation = $brand->translations->first();
            @endphp

            <!-- Brand Card -->
            <div class="p-6 bg-white shadow-lg rounded-lg transition-transform transform hover:scale-105 hover:shadow-2xl">
                <!-- Brand Logo -->
                <div class="flex justify-center mb-4">
                    @if ($brand->logo)
                        <img src="{{ Storage::url($brand->logo) }}"
                             alt="{{ $brandTranslation->name ?? 'Brand Logo' }}"
                             class="h-24 w-auto object-contain">
                    @else
                        <div class="h-24 w-24 bg-gray-200 rounded-full flex items-center justify-center">
                            <span class="text-gray-400 text-lg">{{ $brandTranslation->name ?? 'N/A' }}</span>
                        </div>
                    @endif
                </div>

                <!-- Brand Name -->
                <h2 class="text-xl font-semibold text-gray-800 text-center">
                    {{ $brandTranslation->name ?? 'Brand Name' }}
                </h2>

                <!-- Brand Description -->
                @if ($brandTranslation && $brandTranslation->description)
                    <p class="text-gray-600 text-center mt-4">
                        {{ Str::limit($brandTranslation->description, 100) }}
                    </p>
                @endif

                <!-- View Products Button -->
                <div class="mt-6 text-center">
                    <a href="{{ route('brands.products', ['locale' => session('locale', app()->getLocale()), 'brand_slug' => $brand->id]) }}"
                        class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition duration-300">
                        {{ __('View Products') }}
                    </a>
                </div>
            </div>
        @endforeach
    </div>
        </div>
    </section>
</div>
