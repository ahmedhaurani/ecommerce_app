<?php

namespace App\Livewire\Admin\Brand;

use App\Models\Brand;
use App\Models\BrandTranslation;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateBrand extends Component
{
    use WithFileUploads;

    public $logo;
    public $availableLocales;
    public $name = [], $description = [], $meta_title = [], $meta_description = [], $meta_keywords = [];
    public $is_active = true; // Add this line

    protected $rules = [
        'logo' => 'nullable|image|max:1024',
        'name.*' => 'required|string',
        'description.*' => 'nullable|string',
        'meta_title.*' => 'nullable|string',
        'meta_description.*' => 'nullable|string',
        'meta_keywords.*' => 'nullable|string',
        'is_active' => 'boolean', // Add this line
    ];

    public function mount()
    {
        $this->availableLocales = config('app.available_locales', []);
    }

    public function save()
    {
        $this->validate();

        $brand = new Brand();

        if ($this->logo) {
            $brand->logo = $this->logo->store('brands', 'public');
        }

        $brand->is_active = $this->is_active; // Save the active status
        $brand->save();

        foreach ($this->availableLocales as $locale) {
            BrandTranslation::updateOrCreate(
                ['brand_id' => $brand->id, 'locale' => $locale],
                [
                    'name' => $this->name[$locale],
                    'description' => $this->description[$locale],
                    'meta_title' => $this->meta_title[$locale],
                    'meta_description' => $this->meta_description[$locale],
                    'meta_keywords' => $this->meta_keywords[$locale],
                ]
            );
        }

        session()->flash('message', 'Brand created successfully.');
        return redirect()->route('admin.brands.list');
    }

    public function render()
    {
        return view('livewire.admin.brand.create-brand');
    }
}
