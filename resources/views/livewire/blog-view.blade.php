{{-- <div class="w-full max-w-[85rem] py-6 px-4 sm:px-6 lg:px-8 bg-gray-100 mx-auto rounded-lg"> --}}
<div class="w-full max-w-[100rem] py-6 px-4 sm:px-6 lg:px-8 mx-auto rounded-lg">

    <section class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
        <!-- Blog Header Section -->
        <div class="relative">
            @if($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->translation->title }}"
                     class="w-full h-[400px] object-cover">
            @endif
            <div class="absolute bottom-0 left-0 bg-black bg-opacity-50 text-white p-4">
                <h1 class="text-4xl lg:text-5xl font-bold">{{ $blog->translation->title }}</h1>
                <p class="mt-2 text-sm">
                    By <span class="font-semibold">{{ $blog->author_name }}</span> | {{ $blog->created_at->format('M d, Y') }}
                </p>
            </div>
        </div>

        <!-- Blog Content Section -->
        <div class="p-6 lg:p-10">
            <div class="text-base text-justify prose lg:prose-xl prose-gray dark:prose-invert max-w-none">
                <p>{!! ($blog->translation->content) !!}</p>
            </div>
        </div>


        <!-- Blog Metadata Section -->
        <div class="border-t border-gray-200 dark:border-gray-700 p-6 bg-gray-100 dark:bg-gray-900">
            <h2 class="text-lg font-semibold mb-2">Additional Information</h2>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <p><strong>Keywords:</strong> {{ $blog->keywords }}</p>
                <p><strong>Meta Description:</strong> {{ $blog->meta_description }}</p>
            </div>
        </div>
    </section>
</div>
