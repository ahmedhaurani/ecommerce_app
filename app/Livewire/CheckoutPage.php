<?php

namespace App\Livewire;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Main;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\DeliveryOption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Helpers\CartManagement;
use App\Mail\OrderPlaced;
use Illuminate\Support\Facades\Mail;

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
    public $delivery ;
    public $delivery_options;
    public $shipping_cost = 0.00; // Initialize shipping cost

    public function mount()
    {
        // Fetch delivery options from your model or configuration
        $this->delivery_options = DeliveryOption::all(); // Assuming DeliveryOption is your model for delivery options
        $this->country = app()->getLocale() === 'ar' ? 'العراق' : 'Iraq';

    }
    public function updatedDelivery($value)
    {
        // This method is triggered whenever the 'delivery' property is updated
        $this->calculateShippingCost();
    }

    public function calculateShippingCost()
    {
        // Check if 'delivery' property is set
        if ($this->delivery) {
            // Retrieve the selected delivery option
            $deliveryOption = DeliveryOption::find($this->delivery);

            // Debugging output to verify correct delivery option and price
            // Uncomment the line below to use dd for debugging if needed
            // dd('Selected Delivery ID:', $this->delivery, 'Delivery Option Details:', $deliveryOption, 'Shipping Cost:', $deliveryOption ? $deliveryOption->price : 'No price found');

            // Update shipping cost
            $this->shipping_cost = $deliveryOption ? $deliveryOption->price : 0.00;
        } else {
            // If no delivery option is selected
            $this->shipping_cost = 0.00;
        }
    }

    public function placeOrder() {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string',
            'delivery' => 'required|string',
        ]);

        try {
            // Proceed with placing the order after validation passes
            $cart_items = CartManagement::getCartItemsFromCookie();

            // Check if the cart is empty
            if (empty($cart_items)) {
                session()->flash('error', 'Your cart is empty. Please add items to your cart before placing an order.');
                return;
            }

            $totalAmount = CartManagement::calculateGrandTotal($cart_items);
            $redirect_url = route('success', ['locale' => session('locale') ?? 'en']);;

            // Determine the user ID if authenticated, else set it to null
            $user_id = Auth::check() ? Auth::id() : null;

            // Create the order
            $order = Order::create([
                'user_id' => $user_id, // This will be null if the user is not authenticated
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'country' => $this->country,
                'city' => $this->city,
                'address' => $this->address,
                'payment_method' => $this->payment_method,
                'delivery_option_id' => $this->delivery,
                'total_amount' => $totalAmount,
                'order_status' => 'pending', // default order status
            ]);

            // Create order items
            foreach ($cart_items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'variation_id' => $item['variation_id'],
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_amount'],
                    'total_price' => $item['total_amount'],
                ]);
            }

            // Clear the cart after placing the order
            CartManagement::ClearCartItems();

           // Mail::to(request()->user())->send(new OrderPlaced($order));

            session()->flash('success', 'Your order has been placed successfully.');
          //  return redirect()->route('success', ['locale' => app()->getLocale()]);
            return redirect()->route('success', ['locale' => session('locale') ?? 'en']);

        } catch (\Exception $e) {
            Log::error('Order Placement Error: '.$e->getMessage());
            session()->flash('error', 'There was an error placing your order. Please try again. Error: ' . $e->getMessage());
        }
    }


    public function formatPrice($amount)
    {
        // Format the price based on the current locale
        if (app()->isLocale('ar')) { // For Arabic (RTL)
            return  number_format($amount, 0). 'د.ع ' ; // Adjust formatting as needed
        } else { // For English (LTR)
            return number_format($amount, 0). ' IQD' ;
        }
    }
    public function render()
{
    $cart_items = CartManagement::getCartItemsFromCookie();
    $grand_total = CartManagement::calculateGrandTotal($cart_items);

    // Format cart items
    // foreach ($cart_items as $item) {
    //     $item->formatted_price = $this->formatPrice($item->price);
    //     $item->formatted_total_price = $this->formatPrice($item->total_price);
    // }

    // Format grand total and shipping cost
    $formatted_grand_total = $this->formatPrice($grand_total);
    $formatted_shipping_cost = $this->formatPrice($this->shipping_cost);
    $formated_total = $this->formatPrice($grand_total + $this->shipping_cost );
    return view('livewire.checkout-page', [
        'cart_items' => $cart_items,
        'grand_total' => $formatted_grand_total,
        'shipping_cost' => $this->shipping_cost,
        'total' => $formated_total,
        'formatPrice' => function($price) { return $this->formatPrice($price); } // Pass the formatPrice method to Blade


    ]);
}

    // public function render()
    // {




    //     $cart_items = CartManagement::getCartItemsFromCookie();
    //     $grand_total =CartManagement::calculateGrandTotal($cart_items);
    //     return view('livewire.checkout-page',[
    //         'cart_items' => $cart_items,
    //         'grand_total' => $grand_total,
    //         'shipping_cost' => $this->shipping_cost // Pass shipping cost to the view

    //     ]);
    // }
}
