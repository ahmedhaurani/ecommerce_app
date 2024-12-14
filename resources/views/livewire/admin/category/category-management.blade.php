<div class="container mt-4">
    <h2 class="mb-4">Categories</h2>

    @if ($categories->isEmpty())
        <div class="alert alert-info">
            No categories found. <a href="{{ route('category.create') }}" class="btn btn-link">Click here to add a new category.</a>
        </div>
    @else
        <div class="row">
            @foreach ($categories as $category)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">{{ $category->getTranslatedName('en') }}</h5>
                                <div class="text-muted small">
                                    @foreach ($availableLocales as $locale)
                                        <span class="badge bg-secondary me-1">
                                            {{ strtoupper($locale) }}: {{ $category->getTranslatedName($locale) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                <button wire:click="delete({{ $category->id }})" class="btn btn-sm btn-danger">Delete</button>
                            </div>
                        </div>
                        @if ($category->children->isNotEmpty())
                            <div class="card-body">
                                <h6>Subcategories:</h6>
                                <ul class="list-unstyled ms-3">
                                    @foreach ($category->children as $child)
                                        <li class="mb-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    {{-- <span>{{ $child->getTranslatedName('en') }}</span> --}}
                                                    <div class="text-muted small">  --
                                                        @foreach ($availableLocales as $locale)
                                                           <span class="badge bg-primary me-1">
                                                                {{ strtoupper($locale) }}: {{ $child->getTranslatedName($locale) }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div>

                                                    <a href="{{ route('category.edit', $child->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                                    <button wire:click="delete({{ $child->id }})" class="btn btn-sm btn-link text-danger">Delete</button>
                                                </div>
                                            </div>

                                            <!-- Nested subcategories -->
                                            @if ($child->children->isNotEmpty())
                                                <ul class="list-unstyled ms-3">
                                                    @foreach ($child->children as $grandchild)
                                                        <li class="mb-2">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    {{-- <span>{{ $grandchild->getTranslatedName('en') }}</span> --}}
                                                                    <div class="text-muted small"> ----
                                                                        @foreach ($availableLocales as $locale)
                                                                           <span class="badge bg-secondary me-1">
                                                                                {{ strtoupper($locale) }}: {{ $grandchild->getTranslatedName($locale) }}
                                                                            </span>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                <div>

                                                                    <a href="{{ route('category.edit', $grandchild->id) }}" class="btn btn-sm btn-success">Edit</a>

                                                                    <button wire:click="delete({{ $grandchild->id }})" class="btn btn-sm btn-link text-danger">Delete</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <a href="{{ route('category.create') }}" class="btn btn-success mt-3">Add Category</a>
</div>
