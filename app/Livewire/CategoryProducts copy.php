<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class CategoryProducts extends Component
{
    use WithPagination;

    public $category;
    public $selectedCategories = []; // Array to hold selected category IDs
    public $selectedBrands = [];
    public $priceRange = [0, 500000];
    public $sortBy = 'latest';

    protected $paginationTheme = 'tailwind';

    public function mount($slug)
    {
        // Find the category by its slug
        $this->category = Category::where('slug', $slug)->firstOrFail();

        // Preselect the current category in the filters
        $this->selectedCategories = [$this->category->id];
    }

    public function resetFilters()
    {
        // Reset all filters to default values
        $this->selectedCategories = []; // Empty this to show all products when no category is selected
        $this->selectedBrands = [];
        $this->priceRange = [0, 500000];
        $this->sortBy = 'latest';
        $this->resetPage(); // Reset pagination to the first page
    }

    public function render()
    {
        $locale = app()->getLocale();

        // Fetch categories and brands for filters
        $categories = Category::with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])->whereNull('parent_id')->get();

        $brands = Brand::with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])->get();

        // Determine category IDs to filter by
        $categoryIds = [];

        if (!empty($this->selectedCategories)) {
            // If categories are selected, gather main category and subcategory IDs
            foreach ($this->selectedCategories as $categoryId) {
                $category = Category::with('children')->find($categoryId);
                if ($category) {
                    // Include the main category ID
                    $categoryIds[] = $category->id;

                    // Include all subcategory IDs
                    $subCategoryIds = $category->children->pluck('id')->toArray();
                    $categoryIds = array_merge($categoryIds, $subCategoryIds);
                }
            }
        }

        // Filter products based on selected criteria
        $productQuery = Product::query();

        // Apply Category Filter if there are selected categories
        if (!empty($categoryIds)) {
            $productQuery->whereIn('category_id', $categoryIds);
        }

        // Apply Brand Filter
        if (!empty($this->selectedBrands)) {
            $productQuery->whereIn('brand_id', $this->selectedBrands);
        }

        // Apply Price Range Filter
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

        // Paginate products
        $products = $productQuery->paginate(20);

        return view('livewire.category-products', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'currentCategory' => $this->category, // Pass current category to view
        ]);
    }
}
