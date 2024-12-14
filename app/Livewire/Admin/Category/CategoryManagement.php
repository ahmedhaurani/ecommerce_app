<?php

namespace App\Livewire\Admin\Category;

use Livewire\Component;
use App\Models\Category;

class CategoryManagement extends Component
{
    public $categories;
    public $availableLocales;
    public function mount()
    {
        $this->availableLocales = config('app.available_locales'); // Get available locales from config
        $this->categories = Category::with('children')->whereNull('parent_id')->get();
    }

    public function render()
    {
        return view('livewire.admin.category.category-management', [
            'availableLocales' => $this->availableLocales,
            'categories' => $this->categories,
        ]);
    }
}
