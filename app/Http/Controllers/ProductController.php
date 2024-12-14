<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
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

        return view('products.index', compact('products'));

    }
}
