<div class="container mt-5">
    <div class="row">
        <!-- Category Edit Card -->
        <div class="col-md-8">
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
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $locale }}"
                                role="tabpanel">
                                <div class="form-group mt-3">
                                    <label>Category Name ({{ strtoupper($locale) }})</label>
                                    <input type="text" class="form-control" wire:model="translations.{{ $locale }}.name"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label>Description ({{ strtoupper($locale) }})</label>
                                    <textarea class="form-control"
                                        wire:model="translations.{{ $locale }}.description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Meta Title ({{ strtoupper($locale) }})</label>
                                    <input type="text" class="form-control"
                                        wire:model="translations.{{ $locale }}.meta_title">
                                </div>
                                <div class="form-group">
                                    <label>Meta Description ({{ strtoupper($locale) }})</label>
                                    <textarea class="form-control"
                                        wire:model="translations.{{ $locale }}.meta_description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Meta Keywords ({{ strtoupper($locale) }})</label>
                                    <input type="text" class="form-control"
                                        wire:model="translations.{{ $locale }}.meta_keywords">
                                </div>
                            </div>
                            @endforeach
                        </div>





                        <button type="submit" class="btn btn-primary mt-3 w-100">Update Category</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Parent Category and Status Card -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Parent Category</h4>
                </div>
                <div class="card-body">
                                    <!-- Image Upload -->
                                    <div class="form-group mt-3">
                                        <label>Category Image</label>

                                        <input type="file" class="form-control" wire:model="image">
                                        <!-- Current Image Preview -->
                                        @if ($existingImage)
                                        <div class="form-group mt-3">
                                            <label>Current Image</label>
                                            <img src="{{ asset('storage/' . $existingImage) }}" alt="Category Image"
                                                class="img-thumbnail w-100">
                                        </div>
                                        @endif
                                        @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div></div></div>

            <!-- Parent Category Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Parent Category</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Select Parent Category</label>
                        <select class="form-control" wire:model="parentCategoryId">
                            <option value="">None (Root)</option>
                            @foreach ($categories as $category)
                            @include('livewire.admin.category.category-option', ['category' => $category, 'level' => 0])
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Status Card -->
            <div class="card">

                <div class="card-header">
                    <h4>Status</h4>
                </div>
                <div class="card-body">
                    <!-- Example of status display (could be a dropdown or toggle switch) -->
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" wire:model="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
