<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Support\Facades\Validator;

class ProductForm extends Component
{
    public $product = [];
    public $translations = [];
    public $locales = ['en', 'ar'];
    public $categories = [];

    protected $rules = [
        'product.slug' => 'required|string|max:255',
        'product.price' => 'required|numeric',
        'product.stock' => 'required|integer',
        'product.sku' => 'required|string|max:255',
        'product.in_stock' => 'required|boolean',
        'product.is_active' => 'required|boolean',
        'product.category_id' => 'required|exists:categories,id',  // Add validation rule for category
        'translations.*.name' => 'required|string|max:255',
        'translations.*.short_description' => 'required|string',
        'translations.*.description' => 'required|string',
        'translations.*.meta_title' => 'required|string|max:255',
        'translations.*.meta_description' => 'required|string',
        'translations.*.meta_keywords' => 'required|string',
    ];

    public function mount()
    {
        $this->product = [
            'slug' => '',
            'price' => '',
            'stock' => '',
            'sku' => '',
            'in_stock' => false,
            'is_active' => false,
            'category_id' => null,  // Initialize category_id
        ];

        foreach ($this->locales as $locale) {
            $this->translations[$locale] = [
                'locale' => $locale,
                'name' => '',
                'short_description' => '',
                'description' => '',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
            ];
        }

        $this->categories = Category::with('children')->whereNull('parent_id')->get();  // Fetch main categories
    }

    public function save()
    {
        $this->validate();

        $product = Product::create([
            'slug' => $this->product['slug'],
            'price' => $this->product['price'],
            'stock' => $this->product['stock'],
            'sku' => $this->product['sku'],
            'in_stock' => $this->product['in_stock'],
            'is_active' => $this->product['is_active'],
            'category_id' => $this->product['category_id'],  // Save category_id
            'images' => [], // Handle images if needed
        ]);

        foreach ($this->translations as $translation) {
            ProductTranslation::create([
                'product_id' => $product->id,
                'locale' => $translation['locale'],
                'name' => $translation['name'],
                'short_description' => $translation['short_description'],
                'description' => $translation['description'],
                'meta_title' => $translation['meta_title'],
                'meta_description' => $translation['meta_description'],
                'meta_keywords' => $translation['meta_keywords'],
            ]);
        }

        session()->flash('message', 'Product created successfully.');
        return redirect()->route('admin.products'); // Redirect to the products list or wherever you need
    }

    public function render()
    {
        return view('livewire.admin.product-form');
    }
}
