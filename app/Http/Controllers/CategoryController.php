<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // public function index()
    // {
    //     $locale = app()->getLocale(); // Get the current locale

    //     // Retrieve top-level categories with their translations and children
    //     $categories = Category::whereNull('parent_id')
    //         ->whereHas('translations', function ($query) use ($locale) {
    //             $query->where('locale', $locale);
    //         })
    //         ->with(['translations' => function ($query) use ($locale) {
    //             $query->where('locale', $locale);
    //         }, 'children.translations' => function ($query) use ($locale) {
    //             $query->where('locale', $locale);
    //         }])
    //         ->get();

    //     return view('categories.index', compact('categories'));
    // }
}
