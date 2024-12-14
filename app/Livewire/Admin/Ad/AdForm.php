<?php

namespace App\Livewire\Admin\Ad;

use App\Models\Ad;
use Livewire\WithFileUploads;
use Livewire\Component;

class AdForm extends Component
{
    use WithFileUploads;

    public $adId;
    public $title;
    public $image;
    public $link;
    public $position;
    public $is_active = true; // Default to active for new ads
    public $existingAd;

    public function mount($id = null)
    {
        if ($id) {
            $ad = Ad::findOrFail($id);
            $this->adId = $ad->id;
            $this->title = $ad->title;
            $this->link = $ad->link;
            $this->position = $ad->position;
            $this->is_active = $ad->is_active; // Ensure boolean handling
            $this->existingAd = $ad;
        }
    }

    public function saveAd()
    {
        $this->validate([
            'title' => 'nullable|string|max:255',
            'image' => $this->adId ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'position' => 'nullable|string|max:255',
            'is_active' => 'boolean', // Validate as boolean
        ]);

        $imagePath = $this->image ? $this->image->store('ads', 'public') : null;

        Ad::updateOrCreate(
            ['id' => $this->adId],
            [
                'title' => $this->title,
                'image' => $imagePath ?? ($this->adId ? $this->existingAd->image : null),
                'link' => $this->link,
                'position' => $this->position ?? (Ad::max('position') + 1),
                'is_active' => $this->is_active, // Save as 0 or 1
            ]
        );

        session()->flash('message', $this->adId ? 'Ad updated successfully.' : 'Ad created successfully.');

        return redirect()->route('admin.ads');
    }

    public function render()
    {
        return view('livewire.admin.ad.ad-form');
    }
}
