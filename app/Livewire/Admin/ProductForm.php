<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\ProductVariation;
use App\Models\VariationTranslation;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class ProductForm extends Component
{
    use WithFileUploads; // Ensure the WithFileUploads trait is used

    public $product = [];
    public $translations = [];
    public $locales = ['en'];
    public $categories = [];
    public $brands = []; // Add this line
    public $images = []; // Add this property for images

    protected $rules = [
        'product.slug' => 'required|string|max:255',
        'product.price' => 'required|numeric',
        'product.sale_price' => 'nullable|numeric|lt:product.price',
        'product.stock' => 'required|integer',
        'product.sku' => 'required|string|max:255',
        'product.in_stock' => 'required|boolean',
        'product.is_active' => 'required|boolean',
        'product.featured' => 'required|boolean',
        'product.category_id' => 'required|exists:categories,id',
        'product.brand_id' => 'required|exists:brands,id', // Add validation rule for brand_id
        'product.variations.*.sku' => 'required|string|max:255',
        'product.variations.*.price' => 'required|numeric',
        'product.variations.*.stock' => 'required|integer',
        'product.variations.*.translations.*.name' => 'required|string|max:255',
    ];

    public function removeVariation($index)
    {
        unset($this->product['variations'][$index]);
        $this->product['variations'] = array_values($this->product['variations']);
    }

    public function mount()
    {
        $this->product = [
            'slug' => '',
            'price' => '',
            'sale_price' => '',

            'stock' => '',
            'sku' => '',
            'in_stock' => true,
            'is_active' => true,
            'featured' => false,
            'category_id' => null,
            'brand_id' => null, // Add this line
            'variations' => [],
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

        $this->categories = Category::with('children')->whereNull('parent_id')->get();
        $this->brands = Brand::with('translations')->get(); // Add this line
    }

    public function addVariation()
    {
        $this->product['variations'][] = [
            'sku' => '',
            'price' => '',
            'stock' => '',
            'translations' => array_fill_keys($this->locales, ['name' => '']),
        ];
    }

    public function save()
    {
        $imagePaths = [];

        foreach ($this->images as $image) {
            $imagePaths[] = $image->store('products', 'public'); // Store each image in the 'products' directory within the 'public' disk
        }

        $this->validate();

        $product = Product::create([
            'slug' => $this->product['slug'],
            'price' => $this->product['price'],
            'sale_price' => $this->product['sale_price'],
            'stock' => $this->product['stock'],
            'sku' => $this->product['sku'],
            'in_stock' => $this->product['in_stock'],
            'is_active' => $this->product['is_active'],
            'featured' => $this->product['featured'],

            'category_id' => $this->product['category_id'],
            'brand_id' => $this->product['brand_id'],
            'images' => json_encode($imagePaths), // Save the image paths as a JSON array
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

        foreach ($this->product['variations'] as $variation) {
            $createdVariation = ProductVariation::create([
                'product_id' => $product->id,
                'sku' => $variation['sku'],
                'price' => $variation['price'],
                'stock' => $variation['stock'],
            ]);

            foreach ($variation['translations'] as $locale => $translation) {
                VariationTranslation::create([
                    'variation_id' => $createdVariation->id,
                    'locale' => $locale,
                    'name' => $translation['name'],
                ]);
            }
        }

        session()->flash('message', 'Product created successfully.');
        return redirect()->route('admin.products');
    }

    public function render()
    {
        return view('livewire.admin.product-form', [
            'brands' => $this->brands, // Pass brands to the view
        ]);
    }
}
