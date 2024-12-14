<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductController extends Controller
{
    /**
     * Get the list of products with filters, sorting, and pagination.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Get the language from the request (default to 'en' if not provided)
        $locale = $request->input('lang', 'en'); // or use $request->header('Accept-Language', 'en');
        App::setLocale($locale);

        // Retrieve filters from the request
        $selectedCategories = $request->input('categories', []); // Array of category IDs
        $selectedBrands = $request->input('brands', []);         // Array of brand IDs
        $priceRange = $request->input('price_range', [0, 2000000]); // Default price range
        $sortBy = $request->input('sort_by', 'latest');          // Default sorting
        $categorySlug = $request->input('category_slug');        // Category slug if provided

        // Start building the product query
        $productQuery = Product::whereHas('translations', function ($query) use ($locale) {
            $query->where('locale', $locale);
        })->with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])->orderBy('in_stock', 'desc');

        // Filter by category slug if provided
        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $subcategoryIds = $category->subcategories->pluck('id')->toArray();
                $subcategoryIds[] = $category->id;
                $productQuery->whereIn('category_id', $subcategoryIds);
            }
        }

        // Apply category filters
        if (!empty($selectedCategories)) {
            $subcategoryIds = [];
            foreach ($selectedCategories as $categoryId) {
                $category = Category::with('subcategories')->find($categoryId);
                if ($category) {
                    $subcategoryIds[] = $category->id;
                    $subcategoryIds = array_merge($subcategoryIds, $category->subcategories->pluck('id')->toArray());
                }
            }
            $productQuery->whereIn('category_id', $subcategoryIds);
        }

        // Apply brand filters
        if (!empty($selectedBrands)) {
            $productQuery->whereIn('brand_id', $selectedBrands);
        }

        // Apply price range filters
        if (!empty($priceRange)) {
            $productQuery->whereBetween('price', [$priceRange[0], $priceRange[1]]);
        }

        // Apply sorting
        switch ($sortBy) {
            case 'price_asc':
                $productQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productQuery->orderBy('price', 'desc');
                break;
            case 'latest':
            default:
                $productQuery->orderBy('created_at', 'desc');
                break;
        }

        // Paginate the results
        $products = $productQuery->paginate(20);

        // Format the response
        $response = $products->map(function ($product) use ($locale) {
            return [
                'id' => $product->id,
                'name' => $product->translations()->where('locale', $locale)->value('name'),
                'description' => $product->translations()->where('locale', $locale)->value('description'),
                'price' => $product->price,
                'images' => json_decode($product->images, true),
                'in_stock' => $product->in_stock,
            ];
        });

        return response()->json([
            'products' => $response,
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ]);
    }

    /**
     * Get the list of categories.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories(Request $request)
    {
        $locale = $request->input('lang', 'en');
        App::setLocale($locale);

        $categories = Category::with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }, 'subcategories.translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])->whereNull('parent_id')->get();

        return response()->json($categories);
    }

    /**
     * Get the list of brands.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function brands(Request $request)
    {
        $locale = $request->input('lang', 'en');
        App::setLocale($locale);

        $brands = Brand::with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])->get();

        return response()->json($brands);
    }
}
