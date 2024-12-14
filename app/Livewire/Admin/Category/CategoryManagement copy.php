<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Livewire\Component;

class CategoryManagement extends Component
{
    public $slug, $parent_id, $image, $active, $categoryId;
    public $translations = [];
    public $availableLocales;
    public $editMode = false;

    public function mount($categoryId = null)
    {


        $this->availableLocales = config('app.available_locales', []);
        // Check if available locales are loaded correctly
        if (empty($this->availableLocales)) {
            throw new \Exception('Available locales are not set in the configuration.');
        }

        // Initialize translations
        foreach ($this->availableLocales as $locale) {
            $this->translations[$locale] = [
                'name' => '',
                'description' => '',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => ''
            ];
        }

        if ($categoryId) {
            $this->editMode = true;
            $this->loadCategory($categoryId);
        }
    }


    public function loadCategory($categoryId)
    {
        $this->editMode = true;
        $category = Category::with('translations')->findOrFail($categoryId);
        $this->categoryId = $category->id;
        $this->slug = $category->slug;
        $this->parent_id = $category->parent_id;
        $this->image = $category->image;
        $this->active = $category->active;

        // Populate the translations array with the existing data
        foreach ($category->translations as $translation) {
            if (isset($this->translations[$translation->locale])) {
                $this->translations[$translation->locale] = [
                    'name' => $translation->name,
                    'description' => $translation->description,
                    'meta_title' => $translation->meta_title,
                    'meta_description' => $translation->meta_description,
                    'meta_keywords' => $translation->meta_keywords,
                ];
            }
        }
    }

    protected function rules()
    {
        $rules = [
            'slug' => 'required|string|unique:categories,slug,' . ($this->categoryId ?: 'NULL') . ',id',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|string',
            'active' => 'boolean',
        ];

        // Add rules for translations for all available locales
        foreach ($this->availableLocales as $locale) {
            $rules['translations.' . $locale . '.name'] = 'required|string|max:255';
            $rules['translations.' . $locale . '.description'] = 'nullable|string';
            $rules['translations.' . $locale . '.meta_title'] = 'nullable|string|max:255';
            $rules['translations.' . $locale . '.meta_description'] = 'nullable|string|max:255';
            $rules['translations.' . $locale . '.meta_keywords'] = 'nullable|string';
        }

        return $rules;
    }

    public function store()
    {
        $this->validate();

        $category = Category::create([
            'slug' => $this->slug,
            'parent_id' => $this->parent_id,
            'image' => $this->image,
            'active' => $this->active,
        ]);

        foreach ($this->availableLocales as $locale) {
            CategoryTranslation::create([
                'category_id' => $category->id,
                'locale' => $locale,
                'name' => $this->translations[$locale]['name'],
                'description' => $this->translations[$locale]['description'],
                'meta_title' => $this->translations[$locale]['meta_title'],
                'meta_description' => $this->translations[$locale]['meta_description'],
                'meta_keywords' => $this->translations[$locale]['meta_keywords'],
            ]);
        }

        session()->flash('message', 'Category created successfully!');
        $this->resetForm();
    }

    public function update()
    {
        $this->validate();

        $category = Category::findOrFail($this->categoryId);
        $category->update([
            'slug' => $this->slug,
            'parent_id' => $this->parent_id,
            'image' => $this->image,
            'active' => $this->active,
        ]);

        // Update translations
        foreach ($this->availableLocales as $locale) {
            $translation = CategoryTranslation::firstOrNew([
                'category_id' => $category->id,
                'locale' => $locale,
            ]);

            $translation->update([
                'name' => $this->translations[$locale]['name'],
                'description' => $this->translations[$locale]['description'],
                'meta_title' => $this->translations[$locale]['meta_title'],
                'meta_description' => $this->translations[$locale]['meta_description'],
                'meta_keywords' => $this->translations[$locale]['meta_keywords'],
            ]);
        }

        session()->flash('message', 'Category updated successfully!');
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->slug = '';
        $this->parent_id = null;
        $this->image = '';
        $this->active = 0;
        $this->categoryId = null;
        $this->editMode = false;

        foreach ($this->availableLocales as $locale) {
            $this->translations[$locale] = [
                'name' => '',
                'description' => '',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => ''
            ];
        }
    }

    public function render()
    {
        return view('livewire.admin.category.category-management');
    }
}
