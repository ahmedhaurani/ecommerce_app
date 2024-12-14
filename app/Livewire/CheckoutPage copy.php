<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Helpers\CartManagement;
class CheckoutPage extends Component
{

    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $country;
    public $city;
    public $address;
    public $payment_method;
    public $delivery;


    public function placeOrder() {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string',  // or any validation that matches your payment method format
            'delivery' => 'required|string', // or any validation that matches your delivery format
        ]);

        $cart_items = CartManagement::getCartItemsFromCookie();
        $line_items =[];


    }

    public function render()
    {




        $cart_items = CartManagement::getCartItemsFromCookie();
        $grand_total =CartManagement::calculateGrandTotal($cart_items);
        return view('livewire.checkout-page',[
            'cart_items' => $cart_items,
            'grand_total' => $grand_total
        ]);
    }
}
