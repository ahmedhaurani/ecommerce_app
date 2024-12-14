<?php


namespace App\Livewire;
use App\Models\Ad;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\App;
use App\Helpers\CartManagement; // Import CartManagement if you haven't
use Jantinnerezo\LivewireAlert\LivewireAlert;

class HomePage extends Component
{
    use LivewireAlert;
    public $lastProducts;
    public $featuredProducts;
    public $randomProducts;
    public $highOrderedProducts;
    public $headSliderAds;
    public $headSmallAds;
    public $bottomSmallAds;
    public $showModal = false; // Property to control modal visibility

    public function showModal()
    {
        $this->showModal = true; // Set to true to show the modal
    }

    public function hideModal()
    {
        $this->showModal = false; // Set to false to hide the modal
    }
    public function mount()
    {
        $locale = App::getLocale();
        $this->lastProducts = $this->getProductsByLocale($locale, 'latest');
        $this->featuredProducts = $this->getProductsByLocale($locale, 'featured');
        $this->randomProducts = $this->getProductsByLocale($locale, 'random');
        $this->highOrderedProducts = $this->getProductsByLocale($locale);
        $this->headSliderAds = Ad::where('position', 'head-slider')->where('is_active', true)->get();
        $this->headSmallAds = Ad::where('position', 'head-small')->where('is_active', true)->take(2)->get();
        $this->bottomSmallAds = Ad::where('position', 'bottom-small')->where('is_active', true)->take(3)->get();

    }

    private function getProductsByLocale($locale, $order = null)
    {
        $query = Product::whereHas('translations', function ($query) use ($locale) {
            $query->where('locale', $locale);
        })->with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }]);

        if ($order === 'latest') {
            $query->latest();
        } elseif ($order === 'random') {
            $query->inRandomOrder();
        }  elseif ($order === 'featured') {
            $query->where('featured', true); // Adjust this condition to match your database schema
        }

        $products = $query->take(10)->get();

        foreach ($products as $product) {
            $product->translation = $product->translations->first();
            if (is_string($product->images)) {
                $product->images = json_decode($product->images, true);
            }
        }

        return $products;
    }
public function testt () {
    $this->dispatch('show-verification-modal');
}
    // Add this method to handle adding to cart
    public function addToCart($product_id, $variation_id = null)
    {
        $total_count = CartManagement::addItemToCart($product_id, $variation_id);

        $this->dispatch('update-cart-count', $total_count);
        $this->alert('success', 'Added to Cart!', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
            'timerProgressBar' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.home-page');
    }
}
