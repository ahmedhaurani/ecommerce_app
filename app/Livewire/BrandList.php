<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Brand;

class BrandList extends Component
{
    public $brands;

    public function mount()
    {
        // Get the current locale
        $locale = app()->getLocale();

        // Retrieve brands with translations and only active ones
        $this->brands = Brand::with(['translations' => function($query) use ($locale) {
            $query->where('locale', $locale);
        }])->where('is_active', true)->get();
    }

    public function render()
    {
        return view('livewire.brand-list');
    }
}

