<?php

namespace App\Livewire;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Product;
use App\Helpers\CartManagement;
use App\LiveWire\Partials\Navbar;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Category;
use App\Models\Brand;
class ProductsPage extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $selectedCategories = [];
    public $selectedBrands = [];
    public $selectedStatuses = [];
    public $priceRange = [0, 500000]; // Default price range


    //add product to cart
    public function addToCart($product_id, $variation_id = null) {
        $total_count = CartManagement::addItemToCart($product_id, $variation_id);

       $this->dispatch('update-cart-count', total_count: $total_count);
       $this->alert('success', 'Hello!', [
        'position' => 'bottom-end',
        'timer' => 3000,
        'toast' => true,
        'timerProgressBar' => true,
       ]);
    }
   public function showProductsByCategory($slug)
    {
        // Find the category by slug
        $category = Category::where('slug', $slug)->with('products')->firstOrFail();

        // Pass the category and its products to the view
        return view('livewire.products.by_category', compact('category'));
    }


    public function updatedSelectedCategories()
    {
        $this->resetPage();
    }

    public function updatedSelectedBrands()
    {
        $this->resetPage();
    }

    public function updatedSelectedStatuses()
    {
        $this->resetPage();
    }

    public function updatedPriceRange()
    {
        $this->resetPage();
    }
    public function render()
    {
        $locale = app()->getLocale(); // Get the current locale

        // Fetch categories with translations
        $categories = Category::with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])->get();

        // Fetch brands with translations
        $brands = Brand::with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])->get();

        // Fetch products with translations and apply filters
        $productQuery = Product::whereHas('translations', function ($query) use ($locale) {
            $query->where('locale', $locale);
        })->with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }]);

        // Apply filters
        if (!empty($this->selectedCategories)) {
            $productQuery->whereIn('category_id', $this->selectedCategories);
        }

        if (!empty($this->selectedBrands)) {
            $productQuery->whereIn('brand_id', $this->selectedBrands);
        }

        if (!empty($this->selectedStatuses)) {
            $productQuery->whereIn('status', $this->selectedStatuses);
        }

        if (!empty($this->priceRange)) {
            $productQuery->whereBetween('price', $this->priceRange);
        }

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
    }}

