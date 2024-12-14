<li class="list-group-item">
    <div class="d-flex justify-content-between align-items-center">
        <!-- Category Name with translation and prefix based on level -->
        <div>
            @foreach ($availableLocales as $locale)
                <!-- Display translations in the same line using span -->
                <span>
                    {{-- Prefix based on category level --}}
                    {{ str_repeat('-', $level) }} {{ $category->getTranslatedName($locale) }}
                    @if (!$loop->last)
                        {{-- Add separator between languages if it's not the last language --}}
                        |
                    @endif
                </span>
            @endforeach
        </div>

        <!-- Edit and Delete buttons -->
        <div>
            <a href="{{ route('category.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <button wire:click="delete({{ $category->id }})" class="btn btn-danger btn-sm">Delete</button>
        </div>
    </div>

    <!-- Subcategories (Recursion) -->
    @if ($category->children->isNotEmpty())
        <ul class="list-group mt-2 ms-4">
            @foreach ($category->children as $child)
                @include('livewire.partials.admin.category-item', ['category' => $child, 'level' => $level + 1])
            @endforeach
        </ul>
    @endif
</li>
