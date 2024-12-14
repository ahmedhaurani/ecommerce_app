<div class="container mt-4">
    <h1 class="mb-4 text-center">Category Management</h1>

    <!-- Categories Structure -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Categories Structure</h2>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach ($categories as $category)
                    @include('livewire.partials.admin.category-item', ['category' => $category, 'level' => 0])
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Add Category Button -->
    <div class="text-center mt-4">
        <a href="{{ route('category.create') }}" class="btn btn-success">Add New Category</a>
    </div>
</div>
