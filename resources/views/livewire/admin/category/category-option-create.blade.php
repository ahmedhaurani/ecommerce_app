<option value="{{ $category->id }}" {{ $parentCategoryId == $category->id ? 'selected' : '' }}>
    {{ str_repeat('-', $level) }}
    @foreach ($availableLocales as $locale)
        {{ strtoupper($locale) }}:
        {{ $category->translations->where('locale', $locale)->first()->name ?? 'Unnamed Category' }}
    @endforeach
</option>

@if ($category->children)
    @foreach ($category->children as $childCategory)
        @include('livewire.admin.category.category-option-create', ['category' => $childCategory, 'level' => $level + 1])
    @endforeach
@endif