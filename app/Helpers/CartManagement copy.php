<?php

// namespace App\Helpers;
// use Illuminate\Support\Facades\Cookie;
// use App\Models\Product;
// use App\Models\ProductTranslation;

// class CartManagement {
//     //add item to cart
// static public function addItemToCart($product_id) {
//     $cart_items = self::getCartItemsFromCookie();

//     $existing_item = null;

//     foreach($cart_items as $key => $item){
//         if($item['product_id']== $product_id) {
//             $existing_item = $key;
//             break;
//         }
//     }

//     if($existing_item !== null) {
//         $cart_items[$existing_item]['quantity']++;
//         $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] *
//         $cart_items[$existing_item]['unit_amount'];

//     }else{
//         $product = Product::where('id' , $product_id)->first(['id', 'name', 'price', 'images']);
//         if($product) {
//             $cart_items[] = [
//                 'product_id' => $product_id,
//                 'name' => $product_name,
//                 'image' => $product->images[0],
//                 'quantity' => 1,
//                 'unit_amount' => $product->price,
//                 'total_amount' => $product_price
//             ];
//         }
//     }

//     self::addCartItemsToCookie($cart_items);
//     return count($cart_items);
// }

//     //remove item from cart
// static public function removeCartItem($product_id) {
//     $cart_items = self::getCartItemsFromCookie();
//     foreach($cart_items as $key => $item) {
//         if($item['product_id'] == $product_id) {
//             unset($cart_items[$key]);

//         }
//     }
//     self::addCartItemsToCookie($cart_items);
//     return $cart_items;
// }


//     // add cart item to cookie
// static public function addCartItemsToCookie($cart_items) {
//     Cookie::queue('cart_items',json_encode($cart_items), 60*24*30);

// }

//     //clear cart items from cookie

// static public function ClearCartItems() {
//     Cookie::queue(Cookie::forget('cart_items'));
// }
//     //get all cart items from cookie
// static public function getCartItemsFromCookie() {
//     $cart_items = json_decode(Cookie::get('cart_items'), true);
//     if(!$cart_items) {
//         $cart_items = [];
//     }
//     return $cart_items;
// }


//     //inc item
// static public function incrementQuantityToCartItem($product_id) {
//     $cart_items = self::getCartItemsFromCookie();

//     foreach($cart_items as $key => $item) {
//         if($item['product_id'] == $product_id){
//             $cart_items[$key]['quantity']++;
//             $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]
//             ['unit_amount'];
//         }
//     }

//     self::addCartItemsToCookie($cart_items);
//     return $cart_items;
// }


//     //dec item
//     static public function decrementQuantityToCartItem($product_id) {
//         $cart_items = self::getCartItemsFromCookie();

//         foreach($cart_items as $key => $item) {
//             if($item['product_id'] == $product_id){
//                 if($cart_items[$key]['quantity'] > 1) {
//                     $cart_items[$key]['quantity']--;
//                     $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
//                 }
//             }
//         }

//         self::addCartItemsToCookie($cart_items);
//         return $cart_items;
//     }


//     //calculate total
//     static public function calculateGrandTotal($items) {
//         return array_sun(array_column($items, 'total_amount'));
//     }

// }


namespace App\Helpers;
use Illuminate\Support\Facades\Cookie;
use App\Models\Product;
use App\Models\ProductTranslation;

class CartManagementcopy {
    //add item to cart
    static public function addItemToCart($product_id) {
        $locale = app()->getLocale(); // Get the current locale
        $cart_items = self::getCartItemsFromCookie();

        $existing_item = null;

        // Check if the item already exists in the cart
        foreach($cart_items as $key => $item) {
            if($item['product_id'] == $product_id) {
                $existing_item = $key;
                break;
            }
        }

        // If the item exists, increase the quantity
        if ($existing_item !== null) {
            $cart_items[$existing_item]['quantity']++;
            $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] *
                $cart_items[$existing_item]['unit_amount'];
        } else {
            // Retrieve product details
            $product = Product::where('id', $product_id)->first(['id', 'price', 'images']);
            $product_translation = ProductTranslation::where('product_id', $product_id)
                ->where('locale', $locale)
                ->first(['name']);

            if ($product && $product_translation) {
                $cart_items[] = [
                    'product_id' => $product_id,
                    'name' => $product_translation->name,
                    'image' => $product->images[0] ?? null, // Assuming the first image is used
                    'quantity' => 1,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price
                ];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }
    //remove item from cart
static public function removeCartItem($product_id) {
    $cart_items = self::getCartItemsFromCookie();
    foreach($cart_items as $key => $item) {
        if($item['product_id'] == $product_id) {
            unset($cart_items[$key]);

        }
    }
    self::addCartItemsToCookie($cart_items);
    return $cart_items;
}


    // add cart item to cookie
static public function addCartItemsToCookie($cart_items) {
    Cookie::queue('cart_items',json_encode($cart_items), 60*24*30);

}

    //clear cart items from cookie

static public function ClearCartItems() {
    Cookie::queue(Cookie::forget('cart_items'));
}
    //get all cart items from cookie
static public function getCartItemsFromCookie() {
    $cart_items = json_decode(Cookie::get('cart_items'), true);
    if(!$cart_items) {
        $cart_items = [];
    }
    return $cart_items;
}


    //inc item
static public function incrementQuantityToCartItem($product_id) {
    $cart_items = self::getCartItemsFromCookie();

    foreach($cart_items as $key => $item) {
        if($item['product_id'] == $product_id){
            $cart_items[$key]['quantity']++;
            $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]
            ['unit_amount'];
        }
    }

    self::addCartItemsToCookie($cart_items);
    return $cart_items;
}


    //dec item
    static public function decrementQuantityToCartItem($product_id) {
        $cart_items = self::getCartItemsFromCookie();

        foreach($cart_items as $key => $item) {
            if($item['product_id'] == $product_id){
                if($cart_items[$key]['quantity'] > 1) {
                    $cart_items[$key]['quantity']--;
                    $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
                }
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }


    //calculate total
    static public function calculateGrandTotal($items) {
        return array_sun(array_column($items, 'total_amount'));
    }

}
