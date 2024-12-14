<label class="block ml-{{ $indent ?? 0 }}"> <!-- Adjust indentation based on the level -->
    <input type="checkbox" wire:model.live="selectedCategories" value="{{ $category->id }}"
           class="form-checkbox h-4 w-4 text-blue-600">
    <span class="ml-2 text-gray-700 dark:text-gray-300">
        @if(!empty($indent) && $indent > 0)
            -
        @endif
        {{ $category->translations->first()->name }}
    </span>
</label>

@if($category->subcategories && $category->subcategories->isNotEmpty())
    @foreach($category->subcategories as $subcategory)
        @include('partials.category-checkbox', ['category' => $subcategory, 'indent' => ($indent ?? 0) + 4])
    @endforeach
@endif
