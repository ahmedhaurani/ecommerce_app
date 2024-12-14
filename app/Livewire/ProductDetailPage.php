<?php

namespace App\Livewire;
use App\Helpers\CartManagement;
use App\Models\Review;
use Illuminate\Support\Str;  // Import Str here
use App\Models\Product;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Traits\formatPrice;

class ProductDetailPage extends Component
{
    use formatPrice;

    public $slug;
    public $product;
    public $translation;
    public $quantity = 1;
    use LivewireAlert;
    public $selectedVariation = null; // Store the selected variation
    public $showReviewBox = false; // New property to control review box visibility
    public $discountPercentage;

    public function increment()
    {
        $this->quantity++;
    }

    // Method to decrease quantity
    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }
    public function decreaseQty() {
        if($this->quantity > 1){
            $this->quantity--;
            dd('Decreased Quantity:', $this->quantity);
        }
    }

    public function increaseQty() {
        $this->quantity++;

        dd('Increased Quantity:', $this->quantity);
    }
    public function mount($slug) {
        $this->slug = $slug;

        $product = Product::with(['variations.translation'])->where('slug', $this->slug)->firstOrFail();

        // Get the translation for the current locale
        $translation = $product->translation; // Assuming this method fetches the current locale translation

        // If no translation exists, redirect or abort with a 404
        if (!$translation) {
            return redirect()->route('products.index'); // Redirect to products listing or another page
            // Alternatively, you could abort:
            // abort(404, 'Translation not found');
        }

        // Set product and translation as properties to use in render()
        $this->product = $product;
        $this->translation = $translation;

        if (!is_null($product->sale_price) && $product->sale_price < $product->price) {
            $this->discountPercentage = round((($product->price - $product->sale_price) / $product->price) * 100);
        } else {
            $this->discountPercentage = null; // or 0, if you prefer to show 0% discount in this case
        }

    }

    public function toggleReviewBox()
    {
        $this->showReviewBox = !$this->showReviewBox; // Toggle visibility
    }
    public function updatedSelectedVariation($variation_id) {
        $this->selectedVariation = $variation_id;

    }
    public function test()
    {
        dd('Livewire is working');
    }
    public function addToCart($product_id, $variation_id) {
        $total_count = CartManagement::addItemToCart($product_id, $this->selectedVariation);
       // dd($this->selectedVariation);

       $this->dispatch('update-cart-count', total_count: $total_count);
       $this->alert('success', __('product.added_to_cart'), [
        'position' => 'bottom-end',
        'timer' => 3000,
        'toast' => true,
        'timerProgressBar' => true,
       ]);
    }
    // public function submitReview()
    // {
    //     // Create a new review (make sure to uncomment and customize this section)
    //     Review::create([
    //         'user_id' => auth()->id(),
    //         'product_id' => $this->product->id,
    //         'rating' => $this->rating,
    //         'review' => $this->review,
    //         'name' => auth()->check() ? null : $this->name,
    //         'approved' => false,
    //     ]);

    //     // Show a success message using LivewireAlert
    //     $this->alert('success', __('product.review_submitted'), [
    //         'position' => 'center',
    //         'timer' => 3000,
    //         'toast' => false,
    //         'showConfirmButton' => true,
    //         'confirmButtonText' => 'OK'
    //     ]);

    //     // Clear the form fields after submission
    //     $this->reset('rating', 'review', 'name');
    // }
        public function render()
    {
        // Fetch the product by slug, including variations and translations
        $product = Product::with(['variations.translation'])->where('slug', $this->slug)->firstOrFail();

        $translation = $product->translation; // Assuming this method fetches the current locale translation
        if (!$translation) {
            return redirect()->route('products.index'); // Redirect to products listing or another page
            // Alternatively, you could abort:
            // abort(404, 'Translation not found');
        }
           // Decode the images from JSON to an array
    $images = is_array($product->images) ? $product->images : json_decode($product->images, true);

    // Handle the case where decoding fails
    if (!is_array($images)) {
        $images = []; // Or handle this scenario accordingly
    }
    $ratingSummary = $product->reviews()->selectRaw('rating, COUNT(*) as count')->groupBy('rating')->get()->keyBy('rating');

        // Get the translation for the current locale
        $averageRating = $product->averageRating();
        $fullStars = floor($averageRating);
        $halfStar = $averageRating - $fullStars >= 0.5;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

        $images = is_array($product->images) ? $product->images : json_decode($product->images, true);
        $mainImage = !empty($images) ? asset('storage/' . $images[0]) : asset('default-image.jpg');

        // Ratings and Reviews
        $averageRating = $product->averageRating();
        $reviewCount = $product->reviews->count();
        $price = $product->sale_price ?? $product->price;
     //   $price = $this->formatPrice($product->sale_price ?? $product->price); // Format the price here

        $currency = __('general.currency_symbol'); // Adjust as per your app’s currency symbol setup
        $category = $product->category->name ?? 'General';
        $brand = $product->brand->name ?? 'Brand Name';

        // SEO Data
        $title = $translation->name;
        $metaDescription = Str::limit(strip_tags($translation->description), 160);
        $keywords = implode(', ', [$translation->name, $category, $brand, 'buy ' . $translation->name, 'shop ' . $translation->name]);
       // $product = Product::with(['variations.translation', 'category', 'brand'])->where('slug', $this->slug)->firstOrFail();
       $product = Product::with([
        'variations.translation',
        'category.translations', // Load category translations
        'brand.translations'     // Load brand translations
    ])->where('slug', $this->slug)->firstOrFail();

        $inStock = $product->in_stock > 0;


        // Get the translation for the current locale
        return view('livewire.product-detail-page', [
            'product' => $product,
            'translation' => $translation,
            'images' => $images,
            'ratingSummary' => $ratingSummary,
            'fullStars' => $fullStars,
            'halfStar' => $halfStar,
            'emptyStars' => $emptyStars,
        ])->layout('components.layouts.app', [
            'title' => $title,
            'metaDescription' => $metaDescription,
            'mainImage' => $mainImage,
            'averageRating' => $averageRating,
            'reviewCount' => $reviewCount,
            'price' => $price,
            'currency' => $currency,
            'category' => $category,
            'brand' => $brand,
            'keywords' => $keywords,
            'inStock' => $inStock,  // New variable

        ]);
    }
}
