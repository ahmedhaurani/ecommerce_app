<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductList extends Component
{
    use WithPagination;

    public $search = ''; // For search functionality
    public $categoryFilter = ''; // For category filter
    public $brandFilter = ''; // For brand filter
    public $perPage = 10; // Items per page

    public $categories = [];
    public $brands = [];

   // protected $listeners = ['deleteProduct'];
    protected $listeners = ['updatedSearch'];

    public function mount()
    {
        $this->categories = Category::all();
        $this->brands = Brand::all();
    }
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'categoryFilter', 'brandFilter'])) {
            $this->resetPage();

            // Log or display the current values of filters for debugging
           dd("Filter Updated: ", [
                'search' => $this->search,
                'categoryFilter' => $this->categoryFilter,
                'brandFilter' => $this->brandFilter,
            ]);
        }
    }



    public function render()
    {
        $products = Product::query()
            ->join('product_translations', function ($join) {
                $join->on('products.id', '=', 'product_translations.product_id')
                     ->where('product_translations.locale', app()->getLocale());
            })
            ->select('products.*', 'product_translations.name as translated_name')
            ->when($this->categoryFilter, function ($query) {
                $query->where('products.category_id', $this->categoryFilter);
            })
            ->when($this->brandFilter, function ($query) {
                $query->where('products.brand_id', $this->brandFilter);
            })
            ->where('product_translations.name', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);

        return view('livewire.admin.product-list', [
            'products' => $products,
            'categories' => $this->categories,
            'brands' => $this->brands,
        ]);
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            session()->flash('message', 'Product deleted successfully.');
        } else {
            session()->flash('error', 'Product not found.');
        }
    }
}
