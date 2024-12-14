<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
class CatgoriesPage extends Component
{
    public $categories;
    public $expandedCategories = [];
    public function mount()
    {
    //    $this->categories = Category::with('children')->where('active', 1)->get();
    $this->categories = Category::whereNull('parent_id')->get();
}

    public function toggle($categoryId)
    {
        if (in_array($categoryId, $this->expandedCategories)) {
            $this->expandedCategories = array_diff($this->expandedCategories, [$categoryId]);
        } else {
            $this->expandedCategories[] = $categoryId;
        }
    }
    public function render()
    {
        return view('livewire.catgories-page');
    }
}
