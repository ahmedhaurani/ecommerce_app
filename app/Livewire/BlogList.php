<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;

class BlogList extends Component
{
    public $locale;
    public $blogs;
    public $viewMode = 'grid'; // Default view mode is grid
    public function mount($locale)
    {
        // Ensure the locale is valid
        if (!in_array($locale, ['en', 'ar'])) {
            abort(404);
        }

        $this->locale = $locale;

        // Fetch blogs with translations for the selected locale
        $this->blogs = Blog::with(['translation' => function ($query) {
            $query->where('locale', $this->locale);
        }])->where('active', true) // Only active blogs
          ->orderBy('created_at', 'desc') // Latest blogs first
          ->get();
    }

    public function render()
    {
        return view('livewire.blog-list', ['blogs' => $this->blogs])
            ->layout('components.layouts.app'); // Use your main layout
    }
}
