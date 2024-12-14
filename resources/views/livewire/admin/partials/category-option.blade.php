<option value="{{ $category->id }}" {{ $category->id == $parentCategoryId ? 'selected' : '' }} {{ $isCurrent ? 'disabled' : '' }}>
    {{ str_repeat('-', $category->depth) }}
    @foreach ($availableLocales as $locale)
        {{ $category->getTranslatedName($locale) }}
        @if (!$loop->last) / @endif
    @endforeach
</option>

@if ($category->children->isNotEmpty())
    @foreach ($category->children as $child)
        @include('livewire.partials.admin.category-option', [
            'category' => $child,
            'isCurrent' => $isCurrent, // Pass the current category check to children
            'availableLocales' => $availableLocales
        ])
    @endforeach
@endif
