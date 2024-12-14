<?php

// app/Http/Livewire/Admin/EditProduct.php

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

class EditProduct extends Component
{
    use WithFileUploads;

    public $productId;
    public $product = [];
    public $translations = [];
    public $locales = ['en', 'ar'];
    public $categories = [];
    public $brands = [];
    public $images = [];

    protected $rules = [
        'product.slug' => 'required|string|max:255',
        'product.price' => 'required|numeric',
        'product.stock' => 'required|integer',
        'product.sku' => 'required|string|max:255',
        'product.in_stock' => 'required|boolean',
        'product.is_active' => 'required|boolean',
        'product.category_id' => 'required|exists:categories,id',
        'product.brand_id' => 'required|exists:brands,id',
        'product.variations.*.sku' => 'required|string|max:255',
        'product.variations.*.price' => 'required|numeric',
        'product.variations.*.stock' => 'required|integer',
        'product.variations.*.translations.*.name' => 'required|string|max:255',
    ];

    public function mount($productId)
    {
        $this->productId = $productId;
        $this->loadProduct();
        $this->categories = Category::with('children')->whereNull('parent_id')->get();
        $this->brands = Brand::with('translations')->get();
    }

    public function loadProduct()
    {
        $product = Product::with(['translations', 'variations'])->findOrFail($this->productId);
        $this->product = $product->toArray();
        $this->translations = $product->translations->keyBy('locale')->map(function ($item) {
            return $item->toArray();
        })->toArray();
        $this->images = $product->images;    }

    public function save()
    {
        $this->validate();

        // Update product data
        $product = Product::findOrFail($this->productId);
        $product->update([
            'slug' => $this->product['slug'],
            'price' => $this->product['price'],
            'stock' => $this->product['stock'],
            'sku' => $this->product['sku'],
            'in_stock' => $this->product['in_stock'],
            'is_active' => $this->product['is_active'],
            'category_id' => $this->product['category_id'],
            'brand_id' => $this->product['brand_id'],
            'images' => json_encode($this->images),
        ]);

        // Update product translations
        foreach ($this->translations as $locale => $translation) {
            ProductTranslation::updateOrCreate(
                ['product_id' => $product->id, 'locale' => $locale],
                $translation
            );
        }

        // Update product variations
        foreach ($this->product['variations'] as $index => $variation) {
            $createdVariation = ProductVariation::updateOrCreate(
                ['product_id' => $product->id, 'id' => $variation['id'] ?? null],
                [
                    'sku' => $variation['sku'],
                    'price' => $variation['price'],
                    'stock' => $variation['stock'],
                ]
            );

            foreach ($variation['translations'] as $locale => $translation) {
                VariationTranslation::updateOrCreate(
                    ['variation_id' => $createdVariation->id, 'locale' => $locale],
                    $translation
                );
            }
        }

        session()->flash('message', 'Product updated successfully.');
        return redirect()->route('admin.products');
    }

    public function render()
    {
        return view('livewire.admin.edit-product', [
            'brands' => $this->brands,
        ]);
    }
}
