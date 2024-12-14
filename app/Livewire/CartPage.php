<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Helpers\CartManagement;
use Illuminate\Support\Facades\App;

class CartPage extends Component
{
    public $cart_items = [];
    public $grand_total;

    public function mount()
    {
        $this->updateCartItems();
    }

    public function updateCartItems()
    {
        $this->cart_items = CartManagement::getCartItemsFromCookie();
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
        $this->localizeCartItems();
    }

    protected function localizeCartItems()
    {
        $locale = App::getLocale(); // Get the current locale

        foreach ($this->cart_items as &$item) {
            // Fetch localized product name
            $product = Product::find($item['product_id']);
            if ($product) {
                $product_translation = $product->translations()->where('locale', $locale)->first();
                $item['name'] = $product_translation ? $product_translation->name : 'Product name not available';

                // Fetch localized variation name if exists
                if ($item['variation_id']) {
                    $variation = ProductVariation::find($item['variation_id']);
                    if ($variation) {
                        $variation_translation = $variation->translations()->where('locale', $locale)->first();
                        $item['variation_name'] = $variation_translation ? $variation_translation->name : 'Variation not available';
                    }
                }
            }
        }
    }

    public function removeItem($product_id, $variation_id = null)
    {
        $this->cart_items = CartManagement::removeCartItem($product_id, $variation_id);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
        $this->localizeCartItems();
        $this->dispatch('update-cart-count', total_count: count($this->cart_items));

    }

    public function increaseQuantity($product_id, $variation_id = null)
    {
        $this->cart_items = CartManagement::incrementQuantityToCartItem($product_id, $variation_id);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
        $this->localizeCartItems();
    }

    public function decreaseQuantity($product_id, $variation_id = null)
    {
        $this->cart_items = CartManagement::decrementQuantityToCartItem($product_id, $variation_id);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
        $this->localizeCartItems();
    }
    public function formatPrice($amount)
    {
        // Format the price based on the current locale
        if (app()->isLocale('ar')) { // For Arabic (RTL)
            return  number_format($amount, 0). ' د.ع ' ; // Adjust formatting as needed
        } else { // For English (LTR)
            return number_format($amount, 0). ' IQD' ;
        }
    }
    public function render()
    {
        return view('livewire.cart-page', [
            'formatPrice' => function($price) { return $this->formatPrice($price); } // Pass the formatPrice method to Blade
        ]);
    }
}
