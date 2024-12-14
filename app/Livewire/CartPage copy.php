<?php

namespace App\Livewire;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;

use Livewire\Component;

class CartPage extends Component
{

    #[Title('Create Post')]
public $cart_items =[];
public $grand_total;

public function mount () {
    $this->cart_items = CartManagement::getCartItemsFromCookie();
    $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
}

public function removeItem($product_id, $variation_id = null) {
    $this->cart_items = CartManagement::removeCartItem($product_id, $variation_id);
    $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
}

public function increaseQuantity($product_id, $variation_id = null)
{
    $this->cart_items = CartManagement::incrementQuantityToCartItem($product_id, $variation_id);
    $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
}

public function decreaseQuantity($product_id, $variation_id = null)
{
    $this->cart_items = CartManagement::decrementQuantityToCartItem($product_id, $variation_id);
    $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
}
    public function render()
    {
        return view('livewire.cart-page');
    }
}
