<?php


namespace App\Livewire\Admin\Brand;

use Livewire\Component;
use App\Models\Brand;
use App\Models\BrandTranslation;
use Livewire\WithFileUploads; // Import the trait
class BrandManager extends Component
{
    use WithFileUploads; // Use the trait for file uploads
    public $brands;
    public $availableLocales;
    public $editing = false;
    public $brand_id;
    public $logo;
    public $is_active = true; // Default to active

    // Properties for each locale
    public $name = [];
    public $description = [];
    public $meta_title = [];
    public $meta_description = [];
    public $meta_keywords = [];

    public function mount()
    {
        $this->availableLocales = config('app.available_locales', []);
        $this->brands = Brand::with('translations')->get();
    }

    public function save()
    {
        $this->validate($this->getValidationRules());

        if ($this->editing) {
            $brand = Brand::find($this->brand_id);
            // Update brand
            $brand->logo = $this->logo->store('brands', 'public');
            $brand->is_active = $this->is_active;
            $brand->save();
        } else {
            $brand = Brand::create([
                'logo' => $this->logo->store('brands', 'public'),
                'is_active' => $this->is_active,
            ]);
            $this->brand_id = $brand->id;
        }

        foreach ($this->availableLocales as $locale) {
            BrandTranslation::updateOrCreate(
                ['brand_id' => $this->brand_id, 'locale' => $locale],
                [
                    'name' => $this->name[$locale],
                    'description' => $this->description[$locale],
                    'meta_title' => $this->meta_title[$locale],
                    'meta_description' => $this->meta_description[$locale],
                    'meta_keywords' => $this->meta_keywords[$locale],
                ]
            );
        }

        session()->flash('message', $this->editing ? 'Brand updated successfully.' : 'Brand created successfully.');
        $this->resetForm();
        $this->brands = Brand::with('translations')->get();
    }

    public function getValidationRules()
    {
        $rules = [];
        foreach ($this->availableLocales as $locale) {
            $rules["name.$locale"] = 'required|string|max:255';
            $rules["description.$locale"] = 'nullable|string';
            $rules["meta_title.$locale"] = 'nullable|string|max:255';
            $rules["meta_description.$locale"] = 'nullable|string';
            $rules["meta_keywords.$locale"] = 'nullable|string';
        }
        return $rules;
    }

    public function editBrand($id)
    {
        $this->editing = true;
        $brand = Brand::with('translations')->find($id);
        $this->brand_id = $brand->id;
        $this->logo = $brand->logo;
        $this->is_active = $brand->is_active;

        foreach ($this->availableLocales as $locale) {
            $translation = $brand->translations()->where('locale', $locale)->first();
            if ($translation) {
                $this->name[$locale] = $translation->name;
                $this->description[$locale] = $translation->description;
                $this->meta_title[$locale] = $translation->meta_title;
                $this->meta_description[$locale] = $translation->meta_description;
                $this->meta_keywords[$locale] = $translation->meta_keywords;
            }
        }
    }

    public function deleteBrand($id)
    {
        Brand::find($id)->delete();
        session()->flash('message', 'Brand deleted successfully.');
        $this->brands = Brand::with('translations')->get();
    }

    public function resetForm()
    {
        $this->brand_id = null;
        $this->logo = null;
        $this->is_active = true;
        $this->name = [];
        $this->description = [];
        $this->meta_title = [];
        $this->meta_description = [];
        $this->meta_keywords = [];
        $this->editing = false;
    }

    public function render()
    {
        return view('livewire.admin.brand.brand-manager');
    }
}
