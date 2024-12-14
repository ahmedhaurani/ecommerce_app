<?php

namespace App\Livewire\Admin\Category;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryAdd extends Component
{
    public $translations = [];
    public $availableLocales;
    public $categories;  // To store available categories for the dropdown
    public $parent_id = null;  // Store the selected parent category

    public function mount()
    {
        $this->availableLocales = config('app.available_locales', []);
        $this->categories = Category::all();  // Load existing categories
        foreach ($this->availableLocales as $locale) {
            $this->translations[$locale] = [
                'name' => '',
                'description' => '',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
            ];
        }
    }

    public function store()
    {
        // Validate the inputs
        foreach ($this->availableLocales as $locale) {
            Validator::make($this->translations[$locale], [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string',
            ])->validate();
        }

        // Generate slug based on the first locale's name
        $slug = Str::slug($this->translations[$this->availableLocales[0]]['name'] ?? '');

        // Create the category with the selected parent_id
        $category = Category::create([
            'parent_id' => $this->parent_id,  // Store the selected parent category
            'slug' => $slug,
        ]);

        // Save translations for each locale
        foreach ($this->availableLocales as $locale) {
            $category->translations()->create(array_merge($this->translations[$locale], [
                'locale' => $locale,
                'category_id' => $category->id,
            ]));
        }

        session()->flash('message', 'Category created successfully!');
        return redirect()->route('category.index');
    }

    public function render()
    {
        return view('livewire.admin.category.category-add', [
            'categories' => $this->categories,
        ]);
    }
}
