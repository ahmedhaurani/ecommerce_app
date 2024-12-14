<?php

namespace App\Livewire\Admin\Ad;

use App\Models\Ad;
use Livewire\WithFileUploads;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class AdManager extends Component
{
    use WithFileUploads;

    public $ads; // To list ads
    public $adId; // For editing specific ad
    public $title;
    public $image;
    public $link;
    public $position;
    public $is_active = true;

    public function mount()
    {
        $this->loadAds();
    }

    public function loadAds()
    {
        // Fetch all ads sorted by position
        $this->ads = Ad::orderBy('position', 'asc')->get();
    }

    public function saveAd()
    {
        // Validation rules
        $this->validate([
            'title' => 'nullable|string|max:255',
            'image' => $this->adId ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'position' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        // Handle image upload
        $imagePath = $this->image ? $this->image->store('ads', 'public') : null;

        // Create or update the ad
        Ad::updateOrCreate(
            ['id' => $this->adId],
            [
                'title' => $this->title,
                'image' => $imagePath ?? ($this->adId ? Ad::find($this->adId)->image : null),
                'link' => $this->link,
                'position' => $this->position ?? (Ad::max('position') + 1),
                'is_active' => $this->is_active,
            ]
        );

        // Reset form fields
        $this->resetForm();
        $this->loadAds();

        session()->flash('message', $this->adId ? 'Ad updated successfully.' : 'Ad created successfully.');
    }

    public function editAd($id)
    {
        // Fetch the ad for editing
        $ad = Ad::findOrFail($id);
        $this->adId = $ad->id;
        $this->title = $ad->title;
        $this->link = $ad->link;
        $this->position = $ad->position;
        $this->is_active = $ad->is_active;
    }

    public function deleteAd($id)
    {
        $ad = Ad::findOrFail($id);

        // Delete the image from storage
        if ($ad->image) {
            Storage::disk('public')->delete($ad->image);
        }

        // Delete the ad
        $ad->delete();
        $this->loadAds();

        session()->flash('message', 'Ad deleted successfully.');
    }

    public function resetForm()
    {
        $this->reset(['adId', 'title', 'image', 'link', 'position', 'is_active']);
    }

    public function render()
    {
        return view('livewire.admin.ad.ad-manager');
    }
}
