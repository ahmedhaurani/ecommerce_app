<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public $search = '';
    public $category = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => null],
    ];
    // public function mount()
    // {
    //     $this->category = 0;
    // }
    // Reset pagination when filtering or searching


    public $productToDelete = null;

    public function confirmDelete($productId)
    {
        $this->productToDelete = $productId;
        $this->dispatch('open-delete-modal');
    }

    public function deleteProduct()
    {
        $product = Product::findOrFail($this->productToDelete);
        $product->delete();

        $this->dispatch('close-delete-modal');
        $this->productToDelete = null;
        session()->flash('message', 'Product deleted successfully.');
        $this->resetPage();
    }


    public function updatedSearch()
    {
//        dd($this->category);

        $this->resetPage();
    }

    public function updatedCategory()
    {
      //  dd($this->category);
        $this->resetPage();
    }


    public function render()
    {
        $locale = app()->getLocale();
        $categories = Category::all();


        $products = Product::with(['translations' => function($query) use ($locale) {
                $query->where('locale', $locale);
            }])
            ->when($this->category, function($query) {
                $query->where('category_id', $this->category);
            })
            ->when($this->search, function($query) use ($locale) {
                $query->whereHas('translations', function($query) use ($locale) {
                    $query->where('locale', $locale)
                          ->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate(20);

            // if(!empty($this->category)) {
            //     $products = Product::whereIn('category_id', $this->category);
            // }
        return view('livewire.admin.product-list', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
