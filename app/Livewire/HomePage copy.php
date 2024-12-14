<?php


namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\App;

// class HomePage extends Component
// {
//     public $lastProducts;
//     public $featuredProducts;
//     public $randomProducts;
//     public $highOrderedProducts;

//     public function mount()
//     {
//         $locale = App::getLocale(); // Get the current application locale

//         // Fetch products with translations for the specified locale
//         $this->lastProducts = Product::whereHas('translations', function ($query) use ($locale) {
//             $query->where('locale', $locale);
//         })
//         ->with(['translations' => function ($query) use ($locale) {
//             $query->where('locale', $locale);
//         }])
//         ->latest()
//         ->take(10)
//         ->get();

//         $this->featuredProducts = Product::whereHas('translations', function ($query) use ($locale) {
//             $query->where('locale', $locale);
//         })
//         ->with(['translations' => function ($query) use ($locale) {
//             $query->where('locale', $locale);
//         }])
//         ->take(10)
//         ->get();

//         $this->randomProducts = Product::whereHas('translations', function ($query) use ($locale) {
//             $query->where('locale', $locale);
//         })
//         ->with(['translations' => function ($query) use ($locale) {
//             $query->where('locale', $locale);
//         }])
//         ->inRandomOrder()
//         ->take(10)
//         ->get();

//         $this->highOrderedProducts = Product::whereHas('translations', function ($query) use ($locale) {
//             $query->where('locale', $locale);
//         })
//         ->with(['translations' => function ($query) use ($locale) {
//             $query->where('locale', $locale);
//         }])
//         ->take(10)
//         ->get();
//     }

//     public function render()
//     {
//         return view('livewire.home-page');
//     }
// }




class HomePage extends Component
{
    public $lastProducts;
    public $featuredProducts;
    public $randomProducts;
    public $highOrderedProducts;

    public function mount()
    {
        $locale = App::getLocale(); // Get the current application locale

        // Fetch and decode images for last products
        $this->lastProducts = $this->getProductsByLocale($locale, 'latest');

        // Fetch and decode images for featured products
        $this->featuredProducts = $this->getProductsByLocale($locale);

        // Fetch and decode images for random products
        $this->randomProducts = $this->getProductsByLocale($locale, 'random');

        // Fetch and decode images for high-ordered products
        $this->highOrderedProducts = $this->getProductsByLocale($locale);
    }

    private function getProductsByLocale($locale, $order = null)
    {
        $query = Product::whereHas('translations', function ($query) use ($locale) {
            $query->where('locale', $locale);
        })->with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }]);

        // Apply order if specified
        if ($order === 'latest') {
            $query->latest();
        } elseif ($order === 'random') {
            $query->inRandomOrder();
        }

        // Fetch products
        $products = $query->take(10)->get();

        // Decode images and assign translations
        foreach ($products as $product) {
            $product->translation = $product->translations->first();
            if (is_string($product->images)) {
                $product->images = json_decode($product->images, true);
            }
        }

        return $products;
    }

    public function render()
    {
        return view('livewire.home-page');
    }
}
