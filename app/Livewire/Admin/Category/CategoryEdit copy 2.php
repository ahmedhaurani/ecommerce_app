<?php

namespace App\Livewire\Admin\Category;


use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryEdit extends Component
{
    public $categoryId;
    public $translations = [];
    public $availableLocales;
    public $parentCategoryId;
    public $categories = [];

    public function mount($categoryId)
    {
        $this->categoryId = $categoryId;
        $this->availableLocales = config('app.available_locales', []);

        // Load all categories except the current one
        $this->categories = Category::where('id', '!=', $categoryId)->with('translations')->get();

        $category = Category::with('translations')->findOrFail($categoryId);
        $this->parentCategoryId = $category->parent_id;

        foreach ($this->availableLocales as $locale) {
            $this->translations[$locale] = [
                'name' => $category->translations->where('locale', $locale)->first()->name ?? '',
                'description' => $category->translations->where('locale', $locale)->first()->description ?? '',
                'meta_title' => $category->translations->where('locale', $locale)->first()->meta_title ?? '',
                'meta_description' => $category->translations->where('locale', $locale)->first()->meta_description ?? '',
                'meta_keywords' => $category->translations->where('locale', $locale)->first()->meta_keywords ?? '',
            ];
        }
    }

    public function update()
    {
        foreach ($this->availableLocales as $locale) {
            Validator::make($this->translations[$locale], [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string',
            ])->validate();
        }

        $category = Category::findOrFail($this->categoryId);
        $category->parent_id = $this->parentCategoryId;
        $category->save();

        foreach ($this->availableLocales as $locale) {
            $category->translations()->updateOrCreate(
                ['locale' => $locale],
                $this->translations[$locale]
            );
        }

        session()->flash('message', 'Category updated successfully!');
        return redirect()->route('category.management');
    }

    public function render()
    {
        return view('livewire.admin.category.category-edit');
    }
}
