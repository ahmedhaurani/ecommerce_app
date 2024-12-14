<li class="list-group-item">
    {{ $category->getTranslatedName(app()->getLocale()) }}
    @if ($category->children->isNotEmpty())
        <ul class="list-group mt-2">
            @foreach ($category->children as $child)
                @include('livewire.partials.admin.category-item', ['category' => $child])
            @endforeach
        </ul>
    @endif
</li>
