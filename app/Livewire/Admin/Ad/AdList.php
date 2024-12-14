<?php

namespace App\Livewire\Admin\Ad;

use App\Models\Ad;
use Livewire\Component;

class AdList extends Component
{
    public $ads;
    public $deleteId;

    public function mount()
    {
        $this->loadAds();
    }

    public function loadAds()
    {
        $this->ads = Ad::orderBy('position', 'asc')->get();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function deleteAd()
    {
        $ad = Ad::findOrFail($this->deleteId);
        $ad->delete();

        $this->loadAds();
        $this->deleteId = null;

        session()->flash('message', 'Ad deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.ad.ad-list');
    }
}
