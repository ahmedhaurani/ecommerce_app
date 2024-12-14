<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Product;
use App\Helpers\CartManagement;
use App\Models\Category;
use App\Models\Brand;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ProductsPage extends Component
{
    use WithPagination, LivewireAlert;

    public $selectedCategories = [];
    public $selectedBrands = [];
    public $priceRange = [0, 500000]; // Default price range
    public $sortBy = 'latest'; // Default sorting option

    // Add product to cart
    public function addToCart($product_id, $variation_id = null) {
        $total_count = CartManagement::addItemToCart($product_id, $variation_id);

        $this->dispatch('update-cart-count', total_count: $total_count);
        $this->alert('success', 'Added to Cart!', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
            'timerProgressBar' => true,
        ]);
    }

    public function updatedSelectedCategories() {
        $this->resetPage();
    }

    public function updatedSelectedBrands() {
        $this->resetPage();
    }

    public function updatedPriceRange() {
        $this->resetPage();
    }

    public function updatedSortBy() {
        $this->resetPage();
    }

    public function render() {
        $locale = app()->getLocale(); // Get current locale

        // Fetch categories with translations
        $categories = Category::with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])->get();

        // Fetch brands with translations
        $brands = Brand::with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])->get();

        // Fetch products and order by in_stock (in-stock first, out-of-stock second)
        $productQuery = Product::whereHas('translations', function ($query) use ($locale) {
            $query->where('locale', $locale);
        })->with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])
        ->orderBy('in_stock', 'desc'); // Order by in_stock column (in-stock first)

        // Paginate the result
        $products = $productQuery->paginate(6);

        // Attach translation to each product
        foreach ($products as $product) {
            $product->translation = $product->translations()->where('locale', $locale)->first();
            if (is_string($product->images)) {
                $product->images = json_decode($product->images, true);
            }
        }

        return view('livewire.products-page', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }


}
