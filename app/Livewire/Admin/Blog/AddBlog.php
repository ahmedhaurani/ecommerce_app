<?php

namespace App\Livewire\Admin\Blog;

use Livewire\Component;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTranslation;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class AddBlog extends Component
{
    use WithFileUploads;

    public $title;
    public $content;
    public $category_id; // New field for category
    public $active = true;
    public $featured = false;
    public $image;
    public $keywords;
    public $meta_description;
    public $locale = 'en'; // Default locale
    public $slug; // Add a slug property

    protected $rules = [
        'title' => 'required|max:255',
        'content' => 'required',
        'category_id' => 'required|exists:categories,id', // Validate category
        'active' => 'boolean',
        'featured' => 'boolean',
        'image' => 'nullable|image|max:1024',
        'keywords' => 'nullable|string',
        'meta_description' => 'nullable|string|max:160',
    ];

    public function updatedTitle()
    {
        // Automatically generate slug when title is updated
        $this->slug = Str::slug($this->title);
    }

    public function save()
    {
        $this->validate();

        // Ensure the slug is unique
        if (Blog::where('slug', $this->slug)->exists()) {
            // Add a unique identifier if the slug already exists
            $this->slug = $this->slug . '-' . uniqid();
        }

        $blog = Blog::create([
            'category_id' => $this->category_id,
            'slug' => $this->slug, // Save the slug
            'active' => $this->active,
            'featured' => $this->featured,
        ]);

        BlogTranslation::create([
            'blog_id' => $blog->id,
            'locale' => $this->locale,
            'title' => $this->title,
            'content' => $this->content,
            'keywords' => $this->keywords,
            'meta_description' => $this->meta_description,
        ]);

        if ($this->image) {
            $path = $this->image->store('blogs', 'public');
            $blog->update(['image' => $path]);
        }

        session()->flash('message', __('Blog added successfully.'));
        return redirect()->route('admin.blogs.index');
    }

    public function render()
    {
        return view('livewire.admin.blog.add-blog', [
            'categories' => BlogCategory::where('active', true)->get(), // Pass active categories
        ]);
    }
}
