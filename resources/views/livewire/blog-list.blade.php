<div class="w-full max-w-[100rem] py-6 px-4 sm:px-6 lg:px-8 mx-auto rounded-lg">
    <section class="py-8 bg-gray-50 font-poppins dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="px-4 py-6 mx-auto max-w-7xl lg:py-8 md:px-6">
            <!-- Toggle View Button -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">{{ __('blog.blog') }}</h1>
                <div class="space-x-2">
                    <button wire:click="$set('viewMode', 'grid')" class="px-4 py-2 text-sm font-medium border rounded-lg shadow-sm hover:bg-blue-50 focus:outline-none
                {{ $viewMode === 'grid' ? 'bg-blue-500 text-white' : 'bg-white text-blue-500 border-blue-500' }}">
                        <i class="fas fa-th-large"></i> {{ __('Grid') }}
                    </button>
                    <button wire:click="$set('viewMode', 'list')" class="px-4 py-2 text-sm font-medium border rounded-lg shadow-sm hover:bg-blue-50 focus:outline-none
                {{ $viewMode === 'list' ? 'bg-blue-500 text-white' : 'bg-white text-blue-500 border-blue-500' }}">
                        <i class="fas fa-list"></i> {{ __('List') }}
                    </button>
                </div>
            </div>

            <!-- Blogs Section -->
            @if($blogs->isEmpty())
            <p class="text-center text-gray-500">{{ __('No blogs found.') }}</p>
            @else
            <div
                class="{{ $viewMode === 'grid' ? 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6' : 'space-y-4' }}">
                @foreach($blogs as $blog)
                @if($viewMode === 'grid')
                <!-- Grid View -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <a href="{{ route('blog.show', ['locale' => $locale, 'slug' => $blog->slug]) }}">
                        <!-- Blog Image -->
                        @if($blog->image)
                        <img src="{{ asset('storage/' . $blog->image) }}" class="w-full h-48 object-cover"
                            alt="{{ $blog->translation->title }}">
                        @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                            <i class="fas fa-image fa-2x"></i>
                        </div>
                        @endif
                    </a>
                    <div class="p-4">
                        <!-- Blog Title -->
                        <a href="{{ route('blog.show', ['locale' => $locale, 'slug' => $blog->slug]) }}">
                            <h5 class="text-lg font-bold text-gray-800 hover:text-blue-500 transition">
                                {{ $blog->translation->title }}
                            </h5>
                        </a>
                        <!-- Blog Content -->
                        <p class="text-gray-600">{{ Str::limit($blog->translation->content, 100) }}</p>
                        <!-- Read More Button -->
                        <a href="{{ route('blog.show', ['locale' => $locale, 'slug' => $blog->slug]) }}"
                            class="inline-block mt-4 px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-600 transition">
                            {{ __('blog.read_more') }}
                        </a>
                    </div>
                </div>

                @else
                <!-- List View -->
                <div class="flex bg-white rounded-lg shadow-lg overflow-hidden">
                    <a href="{{ route('blog.show', ['locale' => $locale, 'slug' => $blog->slug]) }}">
                        <!-- Blog Image -->
                        @if($blog->image)
                        <img src="{{ asset('storage/' . $blog->image) }}" class="w-32 h-32 object-contain"
                            alt="{{ $blog->translation->title }}">
                        @else
                        <div class="w-32 h-32 bg-gray-200 flex items-center justify-center text-gray-400">
                            <i class="fas fa-image fa-2x"></i>
                        </div>
                        @endif
                    </a>
                    <div class="p-4 flex-1">
                        <!-- Blog Title -->
                        <a href="{{ route('blog.show', ['locale' => $locale, 'slug' => $blog->slug]) }}">
                            <h5 class="text-lg font-bold text-gray-800 hover:text-blue-500 transition">
                                {{ $blog->translation->title }}
                            </h5>
                        </a>
                        <!-- Blog Content -->
                        <p class="text-gray-600">{{ Str::limit($blog->translation->content, 150) }}</p>
                        <!-- Read More Button -->
                        <a href="{{ route('blog.show', ['locale' => $locale, 'slug' => $blog->slug]) }}"
                            class="inline-block mt-2 px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-600 transition">
                            {{ __('blog.read_more') }}
                        </a>
                    </div>
                </div>

                @endif
                @endforeach
            </div>
            @endif
        </div>
    </section>
</div>
