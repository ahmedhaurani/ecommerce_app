<?php

namespace App\Livewire\Admin\Brand;

use App\Models\Brand;
use App\Models\BrandTranslation;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditBrand extends Component
{
    use WithFileUploads;

    public $brand_id, $logo, $is_active;
    public $availableLocales;
    public $name = [], $description = [], $meta_title = [], $meta_description = [], $meta_keywords = [];

    protected $rules = [

        'name.*' => 'required|string',
        'description.*' => 'nullable|string',
        'meta_title.*' => 'nullable|string',
        'meta_description.*' => 'nullable|string',
        'meta_keywords.*' => 'nullable|string',
        'is_active' => 'boolean', //  validation for is_active
    ];
    public $brand;

    public function mount($id)
    {
        $this->brand = Brand::with('translations')->find($id);
        $this->brand_id = $this->brand->id;
        $this->logo = $this->brand->logo; // Set the existing logo
        $this->is_active = $this->brand->is_active; // Initialize is_active based on the brand

        foreach ($this->brand->translations as $translation) {
            $this->name[$translation->locale] = $translation->name;
            $this->description[$translation->locale] = $translation->description;
            $this->meta_title[$translation->locale] = $translation->meta_title;
            $this->meta_description[$translation->locale] = $translation->meta_description;
            $this->meta_keywords[$translation->locale] = $translation->meta_keywords;
        }

        $this->availableLocales = config('app.available_locales', []);
    }

    public function save()
    {
        // Validate fields; allow logo to be null
        $this->validate();

        // Fetch the brand
        $brand = Brand::with('translations')->find($this->brand_id);
        if (!$brand) {
            session()->flash('error', 'Brand not found!');
            return;
        }

        // Handle logo upload if a new logo is provided
        if ($this->logo && is_object($this->logo)) {
            $logoPath = $this->logo->store('logos', 'public');
            $brand->logo = $logoPath; // Update logo path if new logo is uploaded
        }

        // Update translations
        foreach ($this->availableLocales as $locale) {
            $translation = $brand->translations()->where('locale', $locale)->first();
            if ($translation) {
                $translation->name = $this->name[$locale];
                $translation->description = $this->description[$locale];
                $translation->meta_title = $this->meta_title[$locale];
                $translation->meta_description = $this->meta_description[$locale];
                $translation->meta_keywords = $this->meta_keywords[$locale];
                $translation->save();
            } else {
                $brand->translations()->create([
                    'locale' => $locale,
                    'name' => $this->name[$locale],
                    'description' => $this->description[$locale],
                    'meta_title' => $this->meta_title[$locale],
                    'meta_description' => $this->meta_description[$locale],
                    'meta_keywords' => $this->meta_keywords[$locale],
                ]);
            }
        }

        $brand->is_active = $this->is_active; // Update the active status
        $brand->save(); // Save the brand

        session()->flash('message', 'Brand updated successfully!');
    }


    public function render()
    {
        return view('livewire.admin.brand.edit-brand');
    }
}
