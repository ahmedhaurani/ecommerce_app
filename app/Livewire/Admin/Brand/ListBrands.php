<?php

namespace App\Livewire\Admin\Brand;


use App\Models\Brand;
use Livewire\Component;

class ListBrands extends Component
{
    public $brands;

    public function mount()
    {
        $this->brands = Brand::with('translations')->get();
    }

    public function deleteBrand($id)
    {
        if ($brand = Brand::find($id)) {
            $brand->delete();
            session()->flash('message', 'Brand deleted successfully.');
            $this->brands = Brand::with('translations')->get(); // Refresh list
        }
    }

    public function render()
    {
        return view('livewire.admin.brand.list-brands');
    }
}
