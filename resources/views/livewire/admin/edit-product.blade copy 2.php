<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <!-- Form Section -->
        <div class="col-md-8">
            <!-- Product Details Card -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Product Details</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        <!-- Product Fields -->
                        <!-- ... Existing product fields ... -->

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
                            <!-- Translations Form -->
                            <div class="form-group mb-3">
                                <label for="name_{{ $locale }}">Name</label>
                                <input type="text" id="name_{{ $locale }}" class="form-control"
                                    wire:model="translations.{{ $locale }}.name">
                                @error('translations.' . $locale . '.name') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <!-- Add more translation fields as needed -->
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>





      <!-- Variations Card -->
      @foreach ($product['variations'] as $index => $variation)
      <div class="card mb-3">
          <div class="card-body">
              <h5 class="card-title">Variation {{ $index + 1 }}</h5>
              <button type="button" class="btn btn-danger mb-3" wire:click="removeVariation({{ $index }})">Remove</button>

              <!-- SKU Field -->
              <div class="form-group mb-3">
                  <label for="variation_sku_{{ $index }}">SKU</label>
                  <input type="text" id="variation_sku_{{ $index }}" class="form-control"
                      wire:model="product.variations.{{ $index }}.sku">
                  @error('product.variations.' . $index . '.sku') <div class="text-danger">{{ $message }}</div> @enderror
              </div>

              <!-- Price Field -->
              <div class="form-group mb-3">
                  <label for="variation_price_{{ $index }}">Price</label>
                  <input type="number" id="variation_price_{{ $index }}" class="form-control"
                      wire:model="product.variations.{{ $index }}.price">
                  @error('product.variations.' . $index . '.price') <div class="text-danger">{{ $message }}</div> @enderror
              </div>

              <!-- Stock Field -->
              <div class="form-group mb-3">
                  <label for="variation_stock_{{ $index }}">Stock</label>
                  <input type="number" id="variation_stock_{{ $index }}" class="form-control"
                      wire:model="product.variations.{{ $index }}.stock">
                  @error('product.variations.' . $index . '.stock') <div class="text-danger">{{ $message }}</div> @enderror
              </div>

              <!-- Translations -->
              @foreach ($locales as $locale)
              <div class="form-group mb-3">
                  <label for="variation_name_{{ $index }}_{{ $locale }}">Name ({{ strtoupper($locale) }})</label>
                  <input type="text" id="variation_name_{{ $index }}_{{ $locale }}" class="form-control"
                      wire:model="product.variations.{{ $index }}.translations.{{ $locale }}.name">
                  @error('product.variations.' . $index . '.translations.' . $locale . '.name') <div class="text-danger">{{ $message }}</div> @enderror
              </div>
              @endforeach
          </div>
      </div>
      @endforeach



        </div>

        <!-- Sidebar for Images and Other Details -->
        <div class="col-md-4">
            <!-- Images Card -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Product Images</h5>
                </div>
                <div class="card-body">
                    <input type="file" wire:model="images" multiple class="form-control mb-3">
                    @if ($images)
                    <div class="row">
                        @foreach ($images as $image)
                        <div class="col-4 mb-2">
                            <img src="{{ $image->temporaryUrl() }}" class="img-fluid" alt="Image preview">
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @if ($existingImages)
                    <div class="row">
                        @foreach ($existingImages as $index => $image)
                        <div class="col-4 mb-2">
                            <img src="{{ asset('storage/' . $image) }}" class="img-fluid" alt="Existing image">
                            <button type="button" class="btn btn-danger btn-sm mt-2" wire:click="removeImage({{ $index }})">Remove</button>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Categories and Brands -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Categories and Brands</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="category">Category</label>
                        <select id="category" class="form-control" wire:model="product.category_id">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('product.category_id') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="brand">Brand</label>
                        <select id="brand" class="form-control" wire:model="product.brand_id">
                            <option value="">Select Brand</option>
                            @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('product.brand_id') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
