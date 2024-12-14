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

    protected $paginationTheme = 'tailwind'; // Ensure Tailwind pagination
    public function resetFilters()
    {
        $this->selectedCategories = [];
        $this->selectedBrands = [];
        $this->priceRange = [0, 500000];
        $this->sortBy = 'latest';
        $this->resetPage();
    }

    // Add product to cart
    public function addToCart($product_id, $variation_id = null) {
        $total_count = CartManagement::addItemToCart($product_id, $variation_id);

        $this->dispatch('update-cart-count', $total_count);
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

        // Start building the product query
        // $productQuery = Product::whereHas('translations', function ($query) use ($locale) {
        //     $query->where('locale', $locale);
        // })->with(['translations' => function ($query) use ($locale) {
        //     $query->where('locale', $locale);
        // }]);
        $productQuery = Product::whereHas('translations', function ($query) use ($locale) {
            $query->where('locale', $locale);
        })->with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])
        ->orderBy('in_stock', 'desc'); // Order by in_stock column (in-stock first)

        // Apply Category Filters
        if (!empty($this->selectedCategories)) {
            $productQuery->whereIn('category_id', $this->selectedCategories);
        }

        // Apply Brand Filters
        if (!empty($this->selectedBrands)) {
            $productQuery->whereIn('brand_id', $this->selectedBrands);
        }

        // Apply Price Range Filters
        if (!empty($this->priceRange)) {
            $productQuery->whereBetween('price', [$this->priceRange[0], $this->priceRange[1]]);
        }

        // Apply Sorting
        switch ($this->sortBy) {
            case 'price_asc':
                $productQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productQuery->orderBy('price', 'desc');
                break;
            case 'latest':
            default:
                $productQuery->orderBy('created_at', 'desc');
                break;
        }

        // Paginate the result
        $products = $productQuery->paginate(20); // Adjust pagination as needed

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
