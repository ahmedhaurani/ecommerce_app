<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Helpers\CartManagement;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

class SearchProducts extends Component
{
    use WithPagination, LivewireAlert;

    public $query = '';
    protected $paginationTheme = 'tailwind';

    public function mount($query = null)
    {
        $this->query = $query;
    }


    public function addToCart($product_id, $variation_id = null)
    {
        $total_count = CartManagement::addItemToCart($product_id, $variation_id);

        $this->dispatch('update-cart-count', $total_count);
        $this->alert('success', __('product.added_to_cart'), [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
            'timerProgressBar' => true,
        ]);
    }

    public function render()
    {
        $locale = app()->getLocale();

        $products = Product::whereHas('translations', function ($query) use ($locale) {
            $query->where('locale', $locale)
                  ->where('name', 'LIKE', '%' . $this->query . '%');
        })
        ->with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])
        ->orderBy('in_stock', 'desc') // Products with higher stock come first
        ->paginate(12); // Pagination for better performance

        return view('livewire.search-products', compact('products'));
    }
}
