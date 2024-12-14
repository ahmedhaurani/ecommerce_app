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
    public $selectedCategory; // To store the category ID based on slug

    protected $paginationTheme = 'tailwind';

    /**
     * Mount the component and set the selected category based on category_slug.
     *
     * @param string|null $category_slug
     */
    public function mount($category_slug = null)
    {
        if ($category_slug) {
            $category = Category::where('slug', $category_slug)->first();
            if ($category) {
                $this->selectedCategory = $category->id;
            }
        }
        $this->resetPage();
    }

    /**
     * Reset all filters.
     */
    public function resetFilters()
    {
        $this->selectedCategories = [];
        $this->selectedBrands = [];
        $this->priceRange = [0, 500000];
        $this->selectedCategory = null;
        $this->resetPage();
    }

    /**
     * Add a product to the cart.
     *
     * @param int $product_id
     * @param int|null $variation_id
     */
    public function addToCart($product_id, $variation_id = null)
    {
        $total_count = CartManagement::addItemToCart($product_id, $variation_id);

        $this->dispatch('update-cart-count', $total_count);
        $this->alert('success', 'Added to Cart!', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
            'timerProgressBar' => true,
        ]);
    }

    public function updatedSelectedCategories()
    {
        $this->resetPage();
    }

    public function updatedSelectedBrands()
    {
        $this->resetPage();
    }

    public function updatedPriceRange()
    {
        $this->resetPage();
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function updatedSelectedCategory()
    {
        $this->resetPage();
    }

    /**
     * Render the products page with filtered products, categories, and brands.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $locale = app()->getLocale();

        // Fetch categories with translations for display
        $categories = Category::with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }, 'subcategories.translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])
        ->whereNull('parent_id') // Get only parent categories
        ->get();

        // Fetch brands with translations
        $brands = Brand::with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])->get();

        // Start building the product query
        $productQuery = Product::whereHas('translations', function ($query) use ($locale) {
            $query->where('locale', $locale);
        })->with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])->orderBy('in_stock', 'desc');

        // Apply Category Filter if selectedCategory is set
        if ($this->selectedCategory) {
            $category = Category::with('subcategories')->find($this->selectedCategory);

            if ($category) {
                $subcategoryIds = [$category->id];

                // Collect IDs of all subcategories if any
                foreach ($category->subcategories as $subcategory) {
                    $subcategoryIds[] = $subcategory->id;
                }

                // Filter products by selected category and its subcategory IDs
                $productQuery->whereIn('category_id', $subcategoryIds);
            }
        }

        // Apply additional filters based on user selections
        if (!empty($this->selectedCategories)) {
            $productQuery->whereIn('category_id', $this->selectedCategories);
        }

        if (!empty($this->selectedBrands)) {
            $productQuery->whereIn('brand_id', $this->selectedBrands);
        }

        if (!empty($this->priceRange)) {
            $productQuery->whereBetween('price', [$this->priceRange[0], $this->priceRange[1]]);
        }

        // Apply sorting
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

        // Paginate the results
        $products = $productQuery->paginate(20);

        // Attach translations and decode images
        foreach ($products as $product) {
            $product->translation = $product->translations()->where('locale', $locale)->first();
            if (is_string($product->images)) {
                $product->images = json_decode($product->images, true);
            }
        }

        // Return the view with data
        return view('livewire.products-page', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
}
