<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductTranslation;
use Livewire\WithFileUploads;

class Products extends Component
{
    use WithFileUploads;

    public $products = [];
    public $translations = [];
    public $locales = ['en', 'ar'];
    public $product = [
        'slug' => '',
        'price' => '',
        'category_id' => null,
        'stock' => '',
        'sku' => '',
        'in_stock' => false,
        'is_active' => false,
        'images' => [],
    ];
    public $imageUploads = [];

    protected $rules = [
        'product.slug' => 'required|string|max:255',
        'product.price' => 'required|numeric',
        'product.category_id' => 'required|exists:categories,id',
        'product.stock' => 'required|integer',
        'product.sku' => 'required|string|max:255',
        'product.in_stock' => 'required|boolean',
        'product.is_active' => 'required|boolean',
        'imageUploads.*' => 'nullable|image|max:2048', // Validation for images
        'translations.*.name' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->loadProducts();
    }

    public function loadProducts()
    {
        $this->products = Product::with('translations', 'variations.translations')->get();
    }

    public function save()
    {
        $this->validate();

        if ($this->imageUploads) {
            foreach ($this->imageUploads as $image) {
                $imagePaths[] = $image->store('products', 'public'); // Store images in 'public/products' directory
            }
            $this->product['images'] = $imagePaths;
        }

        $product = Product::create($this->product);

        foreach ($this->translations as $locale => $data) {
            $product->translations()->create([
                'locale' => $locale,
                'namse' => $data['name'],
                'short_description' => $data['short_description'] ?? '',
                'description' => $data['description'] ?? '',
                'meta_title' => $data['meta_title'] ?? '',
                'meta_description' => $data['meta_description'] ?? '',
                'meta_keywords' => $data['meta_keywords'] ?? '',
            ]);
        }

        $this->resetInput();
        $this->loadProducts();
        session()->flash('message', 'Product added successfully.');
    }

    public function resetInput()
    {
        $this->product = [
            'slug' => '',
            'price' => '',
            'category_id' => null,
            'stock' => '',
            'sku' => '',
            'in_stock' => false,
            'is_active' => false,
            'images' => [],
        ];
        $this->imageUploads = [];
        $this->translations = [];
    }

    public function render()
    {
        return view('livewire.admin.products');
    }
}
