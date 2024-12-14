<div class="w-full max-w-[85rem] py-6 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="py-8 bg-gray-100 font-poppins dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="px-4 py-6 mx-auto max-w-7xl lg:py-8 md:px-6">
            <h2 class="text-2xl font-semibold mb-4 text-gray-700 dark:text-gray-200">
                {{ __('search.search_results_for', ['query' => $query]) }}
            </h2>

            @if($products->isEmpty())
                <p class="text-center text-gray-500 dark:text-gray-400">
                    {{ __('search.no_products_found') }}
                </p>
            @else
                <div class="grid grid-cols-2 gap-6 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4">
                    @foreach($products as $product)
                        @include('livewire.partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                <!-- Pagination Links -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </section>
</div>
