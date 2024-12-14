<?php

namespace App\Livewire\Admin\Blog;

use Livewire\Component;
use App\Models\Blog;
use Livewire\WithPagination;

class BlogLists extends Component
{
    use WithPagination;

    public $search = ''; // For search functionality
    public $confirmingDelete = false; // Delete confirmation modal
    public $blogToDelete; // Blog ID for deletion

    protected $queryString = ['search'];

    public function deleteBlog($id)
    {
        $this->blogToDelete = $id;
        $this->confirmingDelete = true;
    }

    public function confirmDelete()
    {
        Blog::findOrFail($this->blogToDelete)->delete();
        $this->confirmingDelete = false;
        $this->blogToDelete = null;

        session()->flash('message', __('Blog deleted successfully.'));
    }

    public function render()
    {
        $blogs = Blog::where('active', true)
            ->whereHas('translation', function ($query) {
                $query->where('locale', 'en') // Search only in English titles
                      ->where('title', 'like', '%' . $this->search . '%');
            })
            ->with('translations') // Load translations for all locales
            ->paginate(10);

        return view('livewire.admin.blog.blog-list', ['blogs' => $blogs]);
    }
}
