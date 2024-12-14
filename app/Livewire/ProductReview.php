<?php


namespace App\Livewire;

use App\Models\Review;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ProductReview extends Component
{
    public $productId;
    public $rating;
    public $review;
    public $name;
    public $isOpen = false; // Control modal visibility

    use LivewireAlert;

    public function showModal()
    {
        $this->isOpen = true;
    }

    public function hideModal()
    {
        $this->isOpen = false;
    }
    public function submitReview()
    {
        // Create a new review (make sure to uncomment and customize this section)
        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $this->productId,
            'rating' => $this->rating,
            'review' => $this->review,
            'name' => auth()->check() ? null : $this->name,
            'approved' => false,
        ]);

        // Show a success message using LivewireAlert
        $this->alert('success', __('product.review_submitted'), [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'confirmButtonText' => 'OK'
        ]);
        $this->dispatch('review-added');

        // Clear the form fields after submission
        $this->reset('rating', 'review', 'name');

    }


    public function render()
    {
        return view('livewire.product-review');
    }
}
