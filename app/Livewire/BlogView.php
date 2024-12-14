<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;

class BlogView extends Component
{
    public $locale;
    public $slug;
    public $blog;

    public function mount($locale, $slug)
    {
        // Ensure the locale is valid
        if (!in_array($locale, ['en', 'ar'])) {
            abort(404);
        }

        $this->locale = $locale;
        $this->slug = $slug;

        // Fetch the blog based on slug and locale
        $this->blog = Blog::with(['translation' => function ($query) {
            $query->where('locale', $this->locale);
        }])->where('slug', $this->slug)->first();

        if (!$this->blog || !$this->blog->translation) {
            abort(404); // Blog or translation not found
        }
    }

    public function render()
    {
        return view('livewire.blog-view', [
            'blog' => $this->blog,
        ])->layout('components.layouts.app', [
            'title' => $this->blog->translation->title,
            'metaDescription' => $this->blog->meta_description,
            'metaKeywords' => $this->blog->keywords,
            'mainImage' => $this->blog->image ? asset('storage/' . $this->blog->image) : null,
        ]);
    }

}
