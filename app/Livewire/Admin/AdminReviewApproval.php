<?php

namespace App\Livewire\Admin;
use App\Models\Review;

use Livewire\Component;

class AdminReviewApproval extends Component
{
    public $reviews;

    public function mount()
    {
        $this->reviews = Review::where('approved', false)->get();
    }

    public function approve($reviewId)
    {
        $review = Review::find($reviewId);
        if ($review) {
            $review->update(['approved' => true]);
        }

        $this->mount(); // reload the reviews
    }

    public function render()
    {
        return view('livewire.admin.admin-review-approval', ['reviews' => $this->reviews]);
    }
}

