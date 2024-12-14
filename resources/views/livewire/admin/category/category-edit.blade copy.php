<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Edit Category</h3>
        </div>
        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <form wire:submit.prevent="update">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @foreach ($availableLocales as $index => $locale)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $index === 0 ? 'active' : '' }}" id="tab-{{ $locale }}"
                            data-bs-toggle="tab" data-bs-target="#{{ $locale }}" type="button" role="tab"
                            aria-controls="{{ $locale }}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                            {{ strtoupper($locale) }}
                        </button>
                    </li>
                    @endforeach
                </ul>
                @php
                function displayCategoryOptions($categories, $parentCategoryId, $level = 0, $currentCategoryId, $availableLocales) {
                    foreach ($categories as $category) {
                        $indent = str_repeat('-- ', $level);

                        // Display the category name for each available locale
                        $categoryNames = '';
                        foreach ($availableLocales as $locale) {
                            $translation = $category->translations->where('locale', $locale)->first();
                            $name = $translation ? $translation->name : 'No Translation';
                            $categoryNames .= strtoupper($locale) . ': ' . $name . ' | '; // Concatenate locale and name
                        }
                        $categoryNames = rtrim($categoryNames, ' | '); // Remove the trailing separator

                        // Output category with all translations
                        echo '<option value="' . $category->id . '" ' . ($parentCategoryId == $category->id ? 'selected' : '') . '>' . $indent . $categoryNames . '</option>';

                        // Recursively display children
                        if ($category->children->count() > 0 && $category->id != $currentCategoryId) {
                            displayCategoryOptions($category->children, $parentCategoryId, $level + 1, $currentCategoryId, $availableLocales);
                        }
                    }
                }
            @endphp

            <div class="form-group mt-3">
                <label for="parentCategory">Parent Category</label>
                <select class="form-control" wire:model="parentCategoryId">
                    <option value="">No Parent</option>
                    @php
                        displayCategoryOptions($categories, $parentCategoryId, 0, $categoryId, $availableLocales);
                    @endphp
                </select>
            </div>



                <div class="tab-content">
                    @foreach ($availableLocales as $locale)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $locale }}" role="tabpanel">
                            <div class="form-group mt-3">
                                <label>Category Name ({{ strtoupper($locale) }})</label>
                                <input type="text" class="form-control" wire:model="translations.{{ $locale }}.name" required>
                            </div>
                            <div class="form-group">
                                <label>Description ({{ strtoupper($locale) }})</label>
                                <textarea class="form-control" wire:model="translations.{{ $locale }}.description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Meta Title ({{ strtoupper($locale) }})</label>
                                <input type="text" class="form-control" wire:model="translations.{{ $locale }}.meta_title">
                            </div>
                            <div class="form-group">
                                <label>Meta Description ({{ strtoupper($locale) }})</label>
                                <textarea class="form-control" wire:model="translations.{{ $locale }}.meta_description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Meta Keywords ({{ strtoupper($locale) }})</label>
                                <input type="text" class="form-control" wire:model="translations.{{ $locale }}.meta_keywords">
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary mt-3">Update Category</button>
            </form>
        </div>
    </div>
</div>
