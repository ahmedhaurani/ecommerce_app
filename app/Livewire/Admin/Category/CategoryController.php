<?php

namespace App\Livewire\Admin\Category;


use App\Models\Category;
use App\Models\CategoryTranslation;
use Livewire\Component;

class CategoryController extends Component
{
    public $categories;
    public $categoryId;
    public $parent_id;
    public $name;
    public $slug;
    public $image;
    public $active = 1;
    public $locale = 'en';
    public $translation = [];
    public $isEdit = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:categories,slug',
        'parent_id' => 'nullable|exists:categories,id',
        'image' => 'nullable|image|max:1024',
        'active' => 'required|boolean',
        'translation.*.name' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = Category::with('translations', 'children')->get();
    }

    public function store()
    {
        $this->validate();

        $category = Category::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'parent_id' => $this->parent_id,
            'image' => $this->image, // You can handle the image upload separately
            'active' => $this->active,
        ]);

        // Save translations
        foreach ($this->translation as $locale => $translationData) {
            CategoryTranslation::create([
                'category_id' => $category->id,
                'locale' => $locale,
                'name' => $translationData['name'],
                'description' => $translationData['description'] ?? null,
                'meta_title' => $translationData['meta_title'] ?? null,
                'meta_description' => $translationData['meta_description'] ?? null,
                'meta_keywords' => $translationData['meta_keywords'] ?? null,
            ]);
        }

        $this->resetForm();
        $this->loadCategories();
        session()->flash('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = Category::with('translations')->find($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->parent_id = $category->parent_id;
        $this->active = $category->active;
        $this->translation = $category->translations->keyBy('locale')->toArray();
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $this->categoryId,
            'translation.*.name' => 'required|string|max:255',
        ]);

        $category = Category::find($this->categoryId);
        $category->update([
            'name' => $this->name,
            'slug' => $this->slug,
            'parent_id' => $this->parent_id,
            'active' => $this->active,
        ]);

        // Update translations
        foreach ($this->translation as $locale => $translationData) {
            CategoryTranslation::updateOrCreate(
                ['category_id' => $category->id, 'locale' => $locale],
                [
                    'name' => $translationData['name'],
                    'description' => $translationData['description'] ?? null,
                    'meta_title' => $translationData['meta_title'] ?? null,
                    'meta_description' => $translationData['meta_description'] ?? null,
                    'meta_keywords' => $translationData['meta_keywords'] ?? null,
                ]
            );
        }

        $this->resetForm();
        $this->loadCategories();
        session()->flash('success', 'Category updated successfully.');
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        $this->loadCategories();
        session()->flash('success', 'Category deleted successfully.');
    }

    public function resetForm()
    {
        $this->categoryId = null;
        $this->name = '';
        $this->slug = '';
        $this->parent_id = null;
        $this->active = 1;
        $this->translation = [];
        $this->isEdit = false;
    }

    public function render()
    {
        return view('livewire.admin.category.category');
    }
}
