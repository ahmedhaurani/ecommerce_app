<div class="tree-item">
    <div class="d-flex align-items-center mb-2">
        <!-- Display category translations -->
        <div class="category-info">
            <span>{{ str_repeat('—', $level) }} {{ $category->getTranslatedName('en') }}</span>
            <div class="small text-muted">
                @foreach ($availableLocales as $locale)
                    <span class="badge bg-secondary me-1">
                        {{ strtoupper($locale) }}: {{ $category->getTranslatedName($locale) }}
                    </span>
                @endforeach
            </div>
        </div>

        <!-- Edit and Delete buttons -->
        <div class="ms-auto">
            <a href="{{ route('category.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <button wire:click="delete({{ $category->id }})" class="btn btn-danger btn-sm">Delete</button>
        </div>
    </div>

    <!-- Recursive display of child categories -->
    @if ($category->children->isNotEmpty())
        <div class="ms-4">
            @foreach ($category->children as $child)
                @include('livewire.partials.admin.category-tree-item', ['category' => $child, 'level' => $level + 1])
            @endforeach
        </div>
    @endif
</div>
