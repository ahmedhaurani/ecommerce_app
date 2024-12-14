<?php

namespace App\Livewire;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Product;
use App\Helpers\CartManagement;
use App\LiveWire\Partials\Navbar;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ProductsPage extends Component
{
    use WithPagination;
    use LivewireAlert;


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
    public function render()
    {

        $locale = app()->getLocale(); // Get the current locale

        // Retrieve products that have translations in the current locale
        $products = Product::whereHas('translations', function ($query) use ($locale) {
            $query->where('locale', $locale);
        })->with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])->get();

        // Attach translation to each product
        foreach ($products as $product) {
            // Find the translation for the current locale
            $product->translation = $product->translations()->Where('locale', $locale)->first();
        }
  return view('livewire.products-page', [
            'products' => $products,
        ]);

        // $productQuery = Product::query()->where('is_active' , 1);
        // return view('livewire.products-page', [
        //     'products' => $productQuery->paginate(6),
        // ]);
    }
}
