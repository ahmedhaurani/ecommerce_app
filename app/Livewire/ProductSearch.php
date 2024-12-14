<?php

// namespace App\Livewire;

// use Livewire\Component;
// use App\Models\Product;
// use Illuminate\Support\Facades\Log;

// class ProductSearch extends Component
// {
//     public $searchTerm = '';
//     public $products = [];

//     public function mount($query = null)
//     {
//         // Initialize the searchTerm with the query parameter if provided
//         $this->searchTerm = request()->get('query', '');

//         // Log to confirm the query parameter is received
//         Log::info('Mounting ProductSearch with query:', ['searchTerm' => $this->searchTerm]);

//         if ($this->searchTerm) {
//             $this->performSearch();
//         }
//     }

//     public function updatedSearchTerm()
//     {
//         $this->performSearch();
//     }

//     public function performSearch()
//     {
//         $locale = app()->getLocale();

//         if (strlen($this->searchTerm) > 1) {
//             $this->products = Product::whereHas('translations', function ($query) use ($locale) {
//                     $query->where('locale', $locale)
//                           ->where('name', 'LIKE', '%' . $this->searchTerm . '%');
//                 })
//                 ->with(['translations' => function ($query) use ($locale) {
//                     $query->where('locale', $locale);
//                 }])
//                 ->get();  // Keep as collection, no need for ->toArray()

//             \Log::info('Products Found:', ['products' => $this->products->toArray()]);  // Log to confirm data
//         } else {
//             $this->products = collect();  // Empty collection if searchTerm is too short
//         }
//     }


//     public function search()
//     {
//         return redirect()->route('product.search', ['query' => $this->searchTerm]);
//     }

//     public function render()
//     {
//         return view('livewire.product-search', [
//             'products' => $this->products,
//         ]);
//     }
// }


namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

use Illuminate\Http\Request;

class ProductSearch extends Component
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Fetch products based on the search query
        $products = Product::where('name', 'LIKE', "%{$query}%")
                           ->orWhere('description', 'LIKE', "%{$query}%")
                           ->get();

        // Pass the results to a view (e.g., 'search-results')
        return view('livewire.search-results', compact('products', 'query'));
    }
}
