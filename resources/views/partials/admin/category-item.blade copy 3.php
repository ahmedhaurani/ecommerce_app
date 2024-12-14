<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Category Information -->
            <div>
                <strong class="text-primary">{{ str_repeat('-', $level) }} {{ $category->getTranslatedName('en') }}</strong>
                <div class="text-muted small">
                    <!-- Display translations in a smaller, inline style -->
                    @foreach ($availableLocales as $locale)
                        <span class="badge bg-secondary me-1">
                            {{ strtoupper($locale) }}: {{ $category->getTranslatedName($locale) }}
                        </span>
                    @endforeach
                </div>
            </div>

            <!-- Edit and Delete buttons -->
            <div>
                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <button wire:click="delete({{ $category->id }})" class="btn btn-danger btn-sm">Delete</button>
            </div>
        </div>

        <!-- Subcategories (Recursion) -->
        @if ($category->children->isNotEmpty())
            <div class="ms-4 mt-3">
                @foreach ($category->children as $child)
                    @include('livewire.partials.admin.category-item', ['category' => $child, 'level' => $level + 1])
                @endforeach
            </div>
        @endif
    </div>
</div>
