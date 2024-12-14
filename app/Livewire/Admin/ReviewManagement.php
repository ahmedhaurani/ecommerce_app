<?php

namespace App\Livewire\Admin;

use App\Models\Review;
use Livewire\Component;

class ReviewManagement extends Component
{
    public $pendingReviews;
    public $approvedReviews;

    public function mount()
    {
        // Fetch pending and approved reviews
        $this->pendingReviews = Review::where('approved', false)->get();
        $this->approvedReviews = Review::where('approved', true)->get();
    }

    // Method to approve a review
    public function approveReview($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $review->approved = true;
        $review->save();

        // Refresh the data
        $this->mount();

        session()->flash('message', 'Review approved successfully!');
    }

    // Method to delete a review
    public function deleteReview($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $review->delete();

        // Refresh the data
        $this->mount();

        session()->flash('message', 'Review deleted successfully!');
    }

    public function render()
    {
        return view('livewire.admin.review-management');
    }
}
