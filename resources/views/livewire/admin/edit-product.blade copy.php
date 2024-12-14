<!-- resources/views/livewire/admin/edit-product.blade.php -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <!-- Form Section -->
        <div class="col-md-8">
            <!-- Product Details Card -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Edit Product</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        <!-- Product Fields -->
                        <div class="form-group mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" id="slug" class="form-control" wire:model="product.slug">
                            @error('product.slug') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="price">Price</label>
                            <input type="number" id="price" class="form-control" wire:model="product.price">
                            @error('product.price') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="stock">Stock</label>
                            <input type="number" id="stock" class="form-control" wire:model="product.stock">
                            @error('product.stock') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="sku">SKU</label>
                            <input type="text" id="sku" class="form-control" wire:model="product.sku">
                            @error('product.sku') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" id="in_stock" class="form-check-input" wire:model="product.in_stock">
                            <label class="form-check-label" for="in_stock">In Stock</label>
                            @error('product.in_stock') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" id="is_active" class="form-check-input" wire:model="product.is_active">
                            <label class="form-check-label" for="is_active">Is Active</label>
                            @error('product.is_active') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>

            <!-- Translations Card -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Translations</h5>
                </div>
                <div class="card-body">
                    <!-- Tabs for Translations -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @foreach ($locales as $index => $locale)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $index === 0 ? 'active' : '' }}" id="tab-{{ $locale }}"
                                data-bs-toggle="tab" data-bs-target="#{{ $locale }}" type="button" role="tab"
                                aria-controls="{{ $locale }}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                {{ strtoupper($locale) }}
                            </button>
                        </li>
                        @endforeach
                    </ul>

                    <div class="tab-content mt-3" id="myTabContent">
                        @foreach ($locales as $index => $locale)
                        <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="{{ $locale }}"
                            role="tabpanel" aria-labelledby="tab-{{ $locale }}">
                            <div class="form-group mb-3">
                                <label for="name_{{ $locale }}">Title</label>
                                <input type="text" id="name_{{ $locale }}" class="form-control"
                                    wire:model="translations.{{ $locale }}.name">
                                @error('translations.' . $locale . '.name') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="short_description_{{ $locale }}">Short Description</label>
                                <textarea id="short_description_{{ $locale }}" class="form-control"
                                    wire:model="translations.{{ $locale }}.short_description"></textarea>
                                @error('translations.' . $locale . '.short_description') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="description_{{ $locale }}">Description</label>
                                <textarea id="description_{{ $locale }}" class="form-control"
                                    wire:model="translations.{{ $locale }}.description"></textarea>
                                @error('translations.' . $locale . '.description') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="meta_title_{{ $locale }}">Meta Title</label>
                                <input type="text" id="meta_title_{{ $locale }}" class="form-control"
                                    wire:model="translations.{{ $locale }}.meta_title">
                                @error('translations.' . $locale . '.meta_title') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="meta_description_{{ $locale }}">Meta Description</label>
                                <textarea id="meta_description_{{ $locale }}" class="form-control"
                                    wire:model="translations.{{ $locale }}.meta_description"></textarea>
                                @error('translations.' . $locale . '.meta_description') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="meta_keywords_{{ $locale }}">Meta Keywords</label>
                                <input type="text" id="meta_keywords_{{ $locale }}" class="form-control"
                                    wire:model="translations.{{ $locale }}.meta_keywords">
                                @error('translations.' . $locale . '.meta_keywords') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Upload Section -->
        <div class="col-md-4">
            <!-- Images Card -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Product Images</h5>
                </div>
                <div class="card-body">
                    <input type="file" wire:model="images" multiple>
                    @error('images.*') <div class="text-danger">{{ $message }}</div> @enderror

                    <div class="mt-3">
                        @if ($images)
                        <ul class="list-group">
                            @if (!empty($images) && is_array($images))
                            <ul class="list-group">
                                @foreach ($images as $image)
                                <li class="list-group-item">
                                    {{ basename($image) }} <!-- Display the file name -->
                                    <img src="{{ asset('storage/' . $image) }}" width="100" alt="Product Image">
                                </li>
                                @endforeach
                            </ul>
                        @endif

                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
