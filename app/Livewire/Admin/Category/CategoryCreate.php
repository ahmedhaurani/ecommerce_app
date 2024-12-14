<?php

namespace App\Livewire\Admin\Category;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class CategoryCreate extends Component
{
    use WithFileUploads;

    public $translations = [];
    public $availableLocales;
    public $defaultLocale; // Define default locale for slug
    public $parentCategoryId;
    public $categories = [];
    public $image;

    public function mount()
    {
        $this->availableLocales = config('app.available_locales', []);
        $this->defaultLocale = config('app.fallback_locale', 'en'); // Define your default locale
        $this->categories = Category::with('translations')
            ->whereNull('parent_id')
            ->get();
    }

    public function save()
    {
        // Validate inputs for all locales
        foreach ($this->availableLocales as $locale) {
            Validator::make($this->translations[$locale], [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string',
            ])->validate();
        }

        // Create a new category
        $category = new Category();
        $category->parent_id = $this->parentCategoryId;

        // Generate slug from the default locale's name
        $category->slug = Str::slug($this->translations[$this->defaultLocale]['name']); // Slug from default locale name

        // Handle image upload
        if ($this->image) {
            $imagePath = $this->image->store('categories', 'public');
            $category->image = $imagePath; // Save the image path in the category
        }

        $category->save();

        // Save translations for all locales
        foreach ($this->availableLocales as $locale) {
            $category->translations()->create([
                'locale' => $locale,
                'name' => $this->translations[$locale]['name'],
                'description' => $this->translations[$locale]['description'] ?? '',
                'meta_title' => $this->translations[$locale]['meta_title'] ?? '',
                'meta_description' => $this->translations[$locale]['meta_description'] ?? '',
                'meta_keywords' => $this->translations[$locale]['meta_keywords'] ?? '',
            ]);
        }

        session()->flash('message', 'Category created successfully!');
        return redirect()->route('category.management');
    }

    public function render()
    {
        return view('livewire.admin.category.category-create');
    }
}
