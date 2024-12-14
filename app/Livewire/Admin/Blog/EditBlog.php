<?php

namespace App\Livewire\Admin\Blog;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Blog;
use App\Models\BlogCategory;

use App\Models\BlogTranslation;
use Illuminate\Support\Facades\Storage;

class EditBlog extends Component
{
    public $blogId;
    public $locale = 'en';
    public $title;
    public $content;
    public $active;
    public $featured;
    public $image;
    public $existingImage;
    public $keywords;
    public $meta_description;
    public $category_id;
    public $categories = [];

    protected $rules = [
        'title' => 'required|max:255',
        'content' => 'required',
        'active' => 'boolean',
        'featured' => 'boolean',
        'image' => 'nullable|image|max:1024',
        'keywords' => 'nullable|string',
        'meta_description' => 'nullable|string|max:160',
        'category_id' => 'required|exists:blog_categories,id',
    ];

    public function mount($blogId, $locale = 'en')
    {
        $this->blogId = $blogId;
        $this->locale = $locale;

        // Load the blog and its translation
        $blog = Blog::with(['translations' => function ($query) {
            $query->where('locale', $this->locale);
        }])->findOrFail($blogId);

        $translation = $blog->translations->first();

        $this->title = $translation->title ?? '';
        $this->content = $translation->content ?? '';
        $this->active = $blog->active;
        $this->featured = $blog->featured;
        $this->existingImage = $blog->image;
        $this->keywords = $translation->keywords ?? '';
        $this->meta_description = $translation->meta_description ?? '';
        $this->category_id = $blog->category_id;

        // Load categories with translations
        $this->categories = BlogCategory::with('translation')->where('active', 1)->get();
    }

    public function save()
    {
        $this->validate();

        $blog = Blog::findOrFail($this->blogId);

        // Update main blog attributes
        $blog->update([
            'active' => $this->active,
            'featured' => $this->featured,
            'category_id' => $this->category_id,
        ]);

        // Update or create translation
        BlogTranslation::updateOrCreate(
            ['blog_id' => $blog->id, 'locale' => $this->locale],
            [
                'title' => $this->title,
                'content' => $this->content,
                'keywords' => $this->keywords,
                'meta_description' => $this->meta_description,
            ]
        );

        // Handle image upload
        if ($this->image) {
            if ($this->existingImage) {
                Storage::disk('public')->delete($this->existingImage);
            }
            $path = $this->image->store('blogs', 'public');
            $blog->update(['image' => $path]);
        }

        session()->flash('message', __('Blog updated successfully.'));
        return redirect()->route('admin.blogs.index');
    }

    public function render()
    {
        return view('livewire.admin.blog.edit-blog', [
            'categories' => $this->categories,
        ]);
    }
}
