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

                <!-- Parent Category Selection -->
                {{-- <div class="form-group mt-3">
                    <label>Parent Category</label>
                    <select class="form-control" wire:model="parentCategoryId">
                        <option value="">None (Root)</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $parentCategoryId == $category->id ? 'selected' : '' }}>
                                @foreach ($availableLocales as $locale)
                                    {{ strtoupper($locale) }}:
                                    {{ $category->translations->where('locale', $locale)->first()->name ?? 'Unnamed Category' }}
                                @endforeach
                            </option>
                        @endforeach
                    </select>
                </div> --}}

               <!-- Parent Category Selection -->
               <div class="form-group mt-3">
                <label>Parent Category</label>
                <select class="form-control" wire:model="parentCategoryId">
                    <option value="">None (Root)</option>
                    @foreach ($categories as $category)
                        @include('livewire.admin.category.category-option', ['category' => $category, 'level' => 0])
                    @endforeach
                </select>
            </div>



                <button type="submit" class="btn btn-primary mt-3">Update Category</button>
            </form>
        </div>
    </div>
</div>
