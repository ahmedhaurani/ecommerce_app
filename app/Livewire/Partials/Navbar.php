<?php

namespace App\Livewire\Partials;
use App\Helpers\CartManagement;
use Livewire\Attributes\On;
use App\LiveWire\ProductsPage;
use Livewire\Component;
use App\Models\Category;

class Navbar extends Component
{
    public $categories;
    public $query = '';


    public $total_count = 0;
     public function mount() {
        $this->total_count = count(CartManagement::getCartItemsFromCookie());
      //  $this->categories = Category::whereNull('parent_id')->get();
  //    return $this->hasMany(Category::class, 'parent_id')->with('children');
  $this->categories = Category::whereNull('parent_id')
  ->with('children.children') // Loads subcategories and sub-subcategories
  ->where('active', 1)
  ->get();
     }

 #[On('update-cart-count')]
 public function updateCartCount($total_count) {

    $this->total_count = $total_count;
 }


//  public function search()
//  {
//      // Redirect to the search results page with the query as a parameter
//      return redirect()->route('search.results', ['query' => $this->query]);
//  }

public function search()
{
    // Redirect to the search results page with the query as a parameter
    return redirect()->route('search.results', [
        'locale' => app()->getLocale(),
        'query' => $this->query
    ]);
}

    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
