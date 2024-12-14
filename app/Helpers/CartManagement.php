<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Cookie;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductTranslation;

class CartManagement {
    // Add item to cart
    // static public function addItemToCart($product_id, $variation_id = null) {
    //     $locale = app()->getLocale(); // Get the current locale
    //     $cart_items = self::getCartItemsFromCookie();

    //     $existing_item = null;

    //     // Check if the item already exists in the cart
    //     foreach ($cart_items as $key => $item) {
    //         if ($item['product_id'] == $product_id && ($item['variation_id'] ?? null) == $variation_id) {
    //             $existing_item = $key;
    //             break;
    //         }
    //     }

    //     // If the item exists, increase the quantity
    //     if ($existing_item !== null) {
    //         $cart_items[$existing_item]['quantity']++;
    //         $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] *
    //             $cart_items[$existing_item]['unit_amount'];
    //     } else {
    //         // Retrieve product details
    //         $product = Product::where('id', $product_id)->first(['id', 'price', 'images']);
    //         $product_translation = ProductTranslation::where('product_id', $product_id)
    //             ->where('locale', $locale)
    //             ->first(['name']);

    //         // Default values
    //         $variation_name = null;
    //         $unit_amount = $product->price;

    //         // Retrieve variation details if variation_id is provided
    //         if ($variation_id) {
    //             $product_variation = ProductVariation::where('id', $variation_id)->first();
    //             if ($product_variation) {
    //                 $variation_translation = $product_variation->translations->firstWhere('locale', $locale);
    //                 $variation_name = $variation_translation ? $variation_translation->name : 'Variation not available';
    //                 $unit_amount = $product->price;
    //             } else {
    //                 $variation_name = 'Variation not available';
    //             }
    //         } else {
    //             $variation_name = $product_translation ? $product_translation->name : 'Product name not available';
    //         }

    //         if ($product) {
    //             $product_images = is_string($product->images) ? json_decode($product->images, true) : $product->images;
    //             $image = $product_images[0] ?? null; // Get the first image

    //             $cart_items[] = [
    //                 'product_id' => $product_id,
    //                 'variation_id' => $variation_id, // Ensure this key is set
    //                 'name' => $product_translation->name,
    //                 'image' => $image, // Assuming the first image is used
    //                 'quantity' => 1,
    //                 'unit_amount' => $unit_amount,
    //                 'total_amount' => $unit_amount
    //             ];
    //         }
    //     }

    //     self::addCartItemsToCookie($cart_items);
    //     return count($cart_items);
    // }

// Add item to cart
static public function addItemToCart($product_id, $variation_id = null)
{
    $locale = app()->getLocale(); // Get the current locale
    $cart_items = self::getCartItemsFromCookie();

    $existing_item_key = null;

    // Check if the item already exists in the cart
    foreach ($cart_items as $key => $item) {
        if ($item['product_id'] == $product_id && ($item['variation_id'] ?? null) == $variation_id) {
            $existing_item_key = $key;
            break;
        }
    }

    if ($existing_item_key !== null) {
        // Increment quantity and update total amount if the item exists
        $cart_items[$existing_item_key]['quantity']++;
        $cart_items[$existing_item_key]['total_amount'] = $cart_items[$existing_item_key]['quantity'] *
            $cart_items[$existing_item_key]['unit_amount'];
    } else {
        // Retrieve product details if the item doesn't exist
        $product = Product::find($product_id);
        $product_translation = ProductTranslation::where('product_id', $product_id)
            ->where('locale', $locale)
            ->first(['name']);

        if ($product) {
            $unit_amount = $product->sale_price ?? $product->price;
            $product_images = is_string($product->images) ? json_decode($product->images, true) : $product->images;
            $image = $product_images[0] ?? null; // Get the first image

            $cart_items[] = [
                'product_id' => $product_id,
                'variation_id' => $variation_id, // Ensure this key is set
                'name' => $product_translation->name,
                'image' => $image,
                'quantity' => 1,
                'unit_amount' => $unit_amount,
                'total_amount' => $unit_amount
            ];
        }
    }

    self::addCartItemsToCookie($cart_items);
    return count($cart_items);
}




    // Remove item from cart
// Remove item from cart
static public function removeCartItem($product_id, $variation_id = null) {
    $cart_items = self::getCartItemsFromCookie();
    foreach ($cart_items as $key => $item) {
        // Check both product_id and variation_id for matching items
        if ($item['product_id'] == $product_id && ($item['variation_id'] ?? null) == $variation_id) {
            unset($cart_items[$key]);
            break;
        }
    }

    // Reindex the array to prevent any potential issues with array keys
    $cart_items = array_values($cart_items);

    self::addCartItemsToCookie($cart_items);
    return $cart_items;
}


    // Add cart item to cookie
    static public function addCartItemsToCookie($cart_items) {
        Cookie::queue('cart_items', json_encode($cart_items), 60*24*30);
    }

    // Clear cart items from cookie
    static public function ClearCartItems() {
        Cookie::queue(Cookie::forget('cart_items'));
    }

    // Get all cart items from cookie
    static public function getCartItemsFromCookie() {
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        if(!$cart_items) {
            $cart_items = [];
        }
        return $cart_items;
    }

    // Increment item quantity in cart
    static public function incrementQuantityToCartItem($product_id, $variation_id = null) {
        $cart_items = self::getCartItemsFromCookie();

        foreach($cart_items as $key => $item) {
            if($item['product_id'] == $product_id && $item['variation_id'] == $variation_id) {
                $cart_items[$key]['quantity']++;
                $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
                break;
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    // Decrement item quantity in cart
    static public function decrementQuantityToCartItem($product_id, $variation_id = null) {
        $cart_items = self::getCartItemsFromCookie();

        foreach($cart_items as $key => $item) {
            if($item['product_id'] == $product_id && $item['variation_id'] == $variation_id) {
                if($cart_items[$key]['quantity'] > 1) {
                    $cart_items[$key]['quantity']--;
                    $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
                }
                break;
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    // Calculate total amount
    static public function calculateGrandTotal($items) {
        return array_sum(array_column($items, 'total_amount'));
    }
}
