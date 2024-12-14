<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Facades\App;
use App\Helpers\CartManagement;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ProductsByBrandPage extends Component
{
    use WithPagination, LivewireAlert;

    public $brand;

    protected $paginationTheme = 'tailwind';

    public function mount($locale, $brand_slug)
    {
        App::setLocale($locale); // Optional: Ensure app locale is set
        $this->brand = Brand::where('id', $brand_slug)->firstOrFail();
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
        $locale = App::getLocale();

        $products = Product::where('brand_id', $this->brand->id)
        ->whereHas('translations', fn($query) => $query->where('locale', $locale))
        ->with(['translations' => fn($query) => $query->where('locale', $locale)])
        ->orderBy('in_stock', 'desc') // Prioritize products with higher stock
        ->paginate(12);



        return view('livewire.products-by-brand-page', ['products' => $products]);
    }
}
