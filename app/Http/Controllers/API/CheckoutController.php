<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\DeliveryOption;
use App\Helpers\CartManagement;

class CheckoutController extends Controller
{
    /**
     * Fetch delivery options for checkout.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDeliveryOptions()
    {
        $deliveryOptions = DeliveryOption::all();
        return response()->json($deliveryOptions, 200);
    }

    /**
     * Calculate shipping cost based on selected delivery option.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateShippingCost(Request $request)
    {
        $deliveryId = $request->input('delivery_id');
        $deliveryOption = DeliveryOption::find($deliveryId);

        if ($deliveryOption) {
            return response()->json(['shipping_cost' => $deliveryOption->price], 200);
        }

        return response()->json(['error' => 'Invalid delivery option.'], 400);
    }

    /**
     * Place an order.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function placeOrder(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string',
            'delivery_id' => 'required|integer',
        ]);

        try {
            // Get cart items
            $cartItems = CartManagement::getCartItemsFromCookie();
            if (empty($cartItems)) {
                return response()->json(['error' => 'Cart is empty.'], 400);
            }

            $totalAmount = CartManagement::calculateGrandTotal($cartItems);
            $deliveryOption = DeliveryOption::find($validatedData['delivery_id']);
            $shippingCost = $deliveryOption ? $deliveryOption->price : 0.00;

            // Determine user ID if authenticated
            $userId = Auth::check() ? Auth::id() : null;

            // Create the order
            $order = Order::create([
                'user_id' => $userId,
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'country' => $validatedData['country'],
                'city' => $validatedData['city'],
                'address' => $validatedData['address'],
                'payment_method' => $validatedData['payment_method'],
                'delivery_option_id' => $validatedData['delivery_id'],
                'total_amount' => $totalAmount + $shippingCost,
                'order_status' => 'pending',
            ]);

            // Create order items
            foreach ($cartItems as $item) {
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

            // Clear the cart
            CartManagement::ClearCartItems();

            // Return success response
            return response()->json([
                'message' => 'Order placed successfully.',
                'order_id' => $order->id,
                'total_amount' => $order->total_amount,
            ], 201);

        } catch (\Exception $e) {
            Log::error('Order Placement Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to place the order.'], 500);
        }
    }
}
