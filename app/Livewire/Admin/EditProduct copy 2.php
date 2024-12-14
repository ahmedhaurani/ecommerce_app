<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\ProductVariation;
use App\Models\VariationTranslation;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class EditProduct extends Component
{
    use WithFileUploads;

    public $product = [];
    public $translations = [];
    public $locales = ['en', 'ar'];
    public $categories = [];
    public $brands = [];
    public $images = [];
    public $existingImages = [];
    public $productId;

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

        $product = Product::with(['translations', 'variations.translations'])
            ->findOrFail($productId);

        $this->product = $product->toArray();
        $this->translations = ProductTranslation::where('product_id', $productId)
            ->get()
            ->keyBy('locale')
            ->map(function ($translation) {
                return $translation->only([
                    'name', 'short_description', 'description', 'meta_title', 'meta_description', 'meta_keywords'
                ]);
            })
            ->toArray();

        $this->existingImages = json_decode($product->images, true) ?? [];
        $this->categories = Category::with('children')->whereNull('parent_id')->get();
        $this->brands = Brand::with('translations')->get();

        // Initialize variations with translations keyed by locale
        foreach ($this->product['variations'] as &$variation) {
            $variationTranslations = collect($variation['translations'])->keyBy('locale');
            foreach ($this->locales as $locale) {
                if (!isset($variationTranslations[$locale])) {
                    $variationTranslations[$locale] = ['name' => ''];
                }
            }
            $variation['translations'] = $variationTranslations->toArray();
        }
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

    public function removeVariation($index)
    {
        unset($this->product['variations'][$index]);
        $this->product['variations'] = array_values($this->product['variations']);
    }

    public function removeImage($index)
    {
        $imageToRemove = $this->existingImages[$index];
        Storage::disk('public')->delete($imageToRemove);
        unset($this->existingImages[$index]);
        $this->existingImages = array_values($this->existingImages);
    }

    public function save()
    {
        $this->validate();

        // Initialize $imagePaths and handle file uploads
        $imagePaths = [];
        if ($this->images) {
            foreach ($this->images as $image) {
                $imagePaths[] = $image->store('products', 'public');
            }
        }

        // Ensure existingImages is an array
        $existingImages = is_array($this->existingImages) ? $this->existingImages : [];

        // Merge existing images with newly uploaded images
        $allImages = array_merge($existingImages, $imagePaths);

        // Update the product
        $product = Product::updateOrCreate(
            ['id' => $this->productId],
            [
                'slug' => $this->product['slug'],
                'price' => $this->product['price'],
                'stock' => $this->product['stock'],
                'sku' => $this->product['sku'],
                'in_stock' => $this->product['in_stock'],
                'is_active' => $this->product['is_active'],
                'category_id' => $this->product['category_id'],
                'brand_id' => $this->product['brand_id'],
                'images' => json_encode($allImages),
            ]
        );

        // Update or create translations
        foreach ($this->translations as $locale => $translation) {
            ProductTranslation::updateOrCreate(
                ['product_id' => $product->id, 'locale' => $locale],
                $translation
            );
        }

        // Update or create variations
        foreach ($this->product['variations'] as $variation) {
            $createdVariation = ProductVariation::updateOrCreate(
                ['id' => $variation['id'] ?? null, 'product_id' => $product->id],
                [
                    'sku' => $variation['sku'],
                    'price' => $variation['price'],
                    'stock' => $variation['stock'],
                ]
            );

            foreach ($variation['translations'] as $locale => $translation) {
                VariationTranslation::updateOrCreate(
                    ['variation_id' => $createdVariation->id, 'locale' => $locale],
                    ['name' => $translation['name']]
                );
            }
        }

        session()->flash('message', 'Product updated successfully.');
        return redirect()->route('admin.products');
    }


    public function render()
    {
        return view('livewire.admin.product-form', [
            'brands' => $this->brands,
        ]);
    }
}
