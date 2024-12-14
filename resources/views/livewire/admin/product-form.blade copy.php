<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <!-- Form Section -->


        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-body">
                        <form wire:submit.prevent="save">
                            <!-- Product Fields -->
                            <div class="form-group mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug" class="form-control" wire:model="product.slug">
                                @error('product.slug') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="price">Price</label>
                                <input type="number" id="price" class="form-control" wire:model="product.price">
                                @error('product.price') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="stock">Stock</label>
                                <input type="number" id="stock" class="form-control" wire:model="product.stock">
                                @error('product.stock') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="sku">SKU</label>
                                <input type="text" id="sku" class="form-control" wire:model="product.sku">
                                @error('product.sku') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" id="in_stock" class="form-check-input"
                                    wire:model="product.in_stock">
                                <label class="form-check-label" for="in_stock">In Stock</label>
                                @error('product.in_stock') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" id="is_active" class="form-check-input"
                                    wire:model="product.is_active">
                                <label class="form-check-label" for="is_active">Is Active</label>
                                @error('product.is_active') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Tabs for Translations -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                @foreach ($locales as $index => $locale)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $index === 0 ? 'active' : '' }}" id="tab-{{ $locale }}"
                                        data-bs-toggle="tab" data-bs-target="#{{ $locale }}" type="button" role="tab"
                                        aria-controls="{{ $locale }}"
                                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
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
                                        @error('translations.' . $locale . '.name') <span class="text-danger">{{
                                            $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="short_description_{{ $locale }}">Short Description</label>
                                        <textarea id="short_description_{{ $locale }}" class="form-control"
                                            wire:model="translations.{{ $locale }}.short_description"></textarea>
                                        @error('translations.' . $locale . '.short_description') <span
                                            class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="description_{{ $locale }}">Description</label>
                                        <textarea id="description_{{ $locale }}" class="form-control"
                                            wire:model="translations.{{ $locale }}.description"></textarea>
                                        @error('translations.' . $locale . '.description') <span class="text-danger">{{
                                            $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="meta_title_{{ $locale }}">Meta Title</label>
                                        <input type="text" id="meta_title_{{ $locale }}" class="form-control"
                                            wire:model="translations.{{ $locale }}.meta_title">
                                        @error('translations.' . $locale . '.meta_title') <span class="text-danger">{{
                                            $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="meta_description_{{ $locale }}">Meta Description</label>
                                        <textarea id="meta_description_{{ $locale }}" class="form-control"
                                            wire:model="translations.{{ $locale }}.meta_description"></textarea>
                                        @error('translations.' . $locale . '.meta_description') <span
                                            class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="meta_keywords_{{ $locale }}">Meta Keywords</label>
                                        <input type="text" id="meta_keywords_{{ $locale }}" class="form-control"
                                            wire:model="translations.{{ $locale }}.meta_keywords">
                                        @error('translations.' . $locale . '.meta_keywords') <span
                                            class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary mt-4">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Image Section -->
        <div class="col-md-4">
            <!-- Replace with your image or image upload field -->
            <div class="card">
                <img src="path/to/your/image.jpg" class="card-img-top" alt="Product Image">
                <div class="card-body">
                    <h5 class="card-title">Product Image</h5>
                    <p class="card-text">Upload or select an image for your product.</p>
                </div>
            </div>

            <div class="mt-4">
                <div class="card">
                    <div class="card-body">
                        <h4>Select Category</h4>
                        <div class="form-group">
                            <label for="categorySelect">Category</label>
                            <select size="7" id="categorySelect" class="form-select" wire:model="product.category_id">
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    @if ($category->children->isNotEmpty())
                                        <!-- Display main category name -->
                                        <option disabled>{{ $category->getNameInLocale($locale) }}</option>
                                        @foreach ($category->children as $subCategory)
                                            <option value="{{ $subCategory->id }}">
                                                {{ $subCategory->getNameInLocale($locale) }}
                                            </option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                            @error('product.category_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <!-- Category Selection Section -->
      <!-- Variation Section -->
      <div class="form-group mt-4">
        <label for="variations">Variations</label>
        <div id="variations">
            @foreach ($product['variations'] as $index => $variation)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Variation {{ $index + 1 }}</h5>
                    <div class="form-group mb-3">
                        <label for="variation_sku_{{ $index }}">SKU</label>
                        <input type="text" id="variation_sku_{{ $index }}" class="form-control"
                            wire:model="product.variations.{{ $index }}.sku">
                        @error('product.variations.' . $index . '.sku') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="variation_price_{{ $index }}">Price</label>
                        <input type="number" id="variation_price_{{ $index }}" class="form-control"
                            wire:model="product.variations.{{ $index }}.price">
                        @error('product.variations.' . $index . '.price') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="variation_stock_{{ $index }}">Stock</label>
                        <input type="number" id="variation_stock_{{ $index }}" class="form-control"
                            wire:model="product.variations.{{ $index }}.stock">
                        @error('product.variations.' . $index . '.stock') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Tabs for Variation Translations -->
                    <ul class="nav nav-tabs" id="variationTab{{ $index }}" role="tablist">
                        @foreach ($locales as $locale)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="variation-tab-{{ $locale }}-{{ $index }}"
                                data-bs-toggle="tab" data-bs-target="#variation-{{ $locale }}-{{ $index }}" type="button" role="tab"
                                aria-controls="variation-{{ $locale }}-{{ $index }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ strtoupper($locale) }}
                            </button>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content mt-3" id="variationTabContent{{ $index }}">
                        @foreach ($locales as $locale)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="variation-{{ $locale }}-{{ $index }}"
                            role="tabpanel" aria-labelledby="variation-tab-{{ $locale }}-{{ $index }}">
                            <div class="form-group mb-3">
                                <label for="variation_name_{{ $locale }}_{{ $index }}">Name</label>
                                <input type="text" id="variation_name_{{ $locale }}_{{ $index }}" class="form-control"
                                    wire:model="product.variations.{{ $index }}.translations.{{ $locale }}.name">
                                @error('product.variations.' . $index . '.translations.' . $locale . '.name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach

            <button type="button" class="btn btn-secondary" wire:click="addVariation">Add Variation</button>
        </div>
    </div>

    </div>
</div>
