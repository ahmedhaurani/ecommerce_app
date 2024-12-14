<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
    public function show($id)
    {
        $product = Product::find($id);
        $locale = app()->getLocale(); // Get the current locale
        $translation = $product->translate($locale);

        return view('product.show', compact('product', 'translation'));
    }
}
