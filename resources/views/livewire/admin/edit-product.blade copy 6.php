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


                                                        <!-- Quill Editor for Description -->



                                       <!-- Translations Section -->


    <!-- Quill Editor for Description -->
    <div class="form-group mb-3">
        <label for="description_{{ $locale }}">Description</label>
        <div id="quill-container-{{ $locale }}" wire:ignore>
            <div id="quill-editor-{{ $locale }}" style="height: 300px;"></div>
        </div>

        <!-- Hidden textarea for Livewire binding -->
        <textarea id="quill-editor-area-{{ $locale }}" class="d-none"
                  wire:model="translations.{{ $locale }}.description"></textarea>

        @error('translations.' . $locale . '.description')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>





<!-- CV Field -->
 {{-- <div class="mb-3">
    <label class="form-label" for="inputEmail"></label>
    <!-- Custom Toolbar -->
kkk
    <!-- Quill Editor -->
    <div id="quill-container" wire:ignore>
        <div id="quill-editor" class="mb-3" style="height: 300px;"></div>
    </div>

    <!-- Hidden textarea for Livewire binding -->
    <textarea
        rows="3"
        class="mb-3 d-none"
        name="body"
        id="quill-editor-area"
        wire:model="translations.{{ $locale }}.description"></textarea>

    @error('translations.' . $locale . '.description')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div> --}}



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

        <!-- Image and Category Selection Section -->
        <div class="col-md-4">
            <!-- Images Card -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Product Images</h5>
                </div>
                <div class="card-body">
                    <!-- Image Upload Input -->
                    <input type="file" wire:model="images" multiple class="form-control mb-3">

                    <!-- Display Existing Images -->
                    @if ($existingImages)
                    <div class="row">
                        @foreach ($existingImages as $index => $image)
                        <div class="col-4 mb-2 position-relative d-flex flex-column align-items-center">
                            <div class="image-container position-relative">
                                <img src="{{ asset('storage/' . $image) }}" class="img-fluid mb-2" alt="Existing image">
                                <!-- Remove Button -->
                                <button type="button" class="btn btn-danger btn-icon position-absolute top-0 end-0 m-2"
                                    wire:click="removeImage({{ $index }})">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                            <!-- Navigation Buttons Below Image -->
                            <div class="button-overlay d-flex justify-content-between w-100 mt-2">
                                <!-- Up Button -->
                                <button type="button" class="btn btn-outline-primary btn-icon"
                                    wire:click="moveImage({{ $index }}, 'up')" {{ $index === 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-arrow-up"></i>
                                </button>
                                <!-- Down Button -->
                                <button type="button" class="btn btn-outline-primary btn-icon"
                                    wire:click="moveImage({{ $index }}, 'down')" {{ $index === count($existingImages) - 1 ? 'disabled' : '' }}>
                                    <i class="bi bi-arrow-down"></i>
                                </button>
                                <!-- First Button -->
                                <button type="button" class="btn btn-success btn-icon"
                                    wire:click="moveImage({{ $index }}, 'first')" {{ $index === 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-arrow-up-circle"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Display Uploaded Images (Preview) -->
                    @if ($images)
                    <div class="row mt-3">
                        @foreach ($images as $image)
                        <div class="col-4 mb-2 position-relative d-flex flex-column align-items-center">
                            <div class="image-container position-relative">
                                <img src="{{ $image->temporaryUrl() }}" class="img-fluid mb-2" alt="Image preview">
                                <!-- Remove Button -->
                                <button type="button" class="btn btn-danger btn-icon position-absolute top-0 end-0 m-2"
                                    wire:click="removeNewImage({{ $loop->index }})">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>





            <!-- Category Selection Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <h4>Select Category</h4>
                    <div class="form-group">
                        <label for="categorySelect">Category</label>
                        <select size="7" id="categorySelect" class="form-select" wire:model="product.category_id">
                            <option value="">Select a category</option>

                            @foreach ($categories as $category)
                                {{-- Main category (disabled and styled) --}}
                                <option disabled style="background-color: #f0f0f0;">
                                    @foreach (config('app.available_locales') as $locale => $languageName)
                                        {{-- Display category name in both languages --}}
                                        {{ $category->getInLocale($locale) }} ({{ $languageName }})
                                        @if (!$loop->last) / @endif
                                    @endforeach
                                </option>

                                {{-- Subcategories --}}
                                @foreach ($category->children as $subCategory)
                                    <option value="{{ $subCategory->id }}" style="padding-left: 20px;">
                                        @foreach (config('app.available_locales') as $locale => $languageName)
                                            {{-- Display subcategory name in both languages --}}
                                            - {{ $subCategory->getInLocale($locale) }} ({{ $languageName }})
                                            @if (!$loop->last) / @endif
                                        @endforeach
                                    </option>

                                    {{-- Sub-subcategories --}}
                                    @if ($subCategory->children->isNotEmpty())
                                        @foreach ($subCategory->children as $subSubCategory)
                                            <option value="{{ $subSubCategory->id }}" style="padding-left: 40px;">
                                                @foreach (config('app.available_locales') as $locale => $languageName)
                                                    {{-- Display sub-subcategory name in both languages --}}
                                                    -- {{ $subSubCategory->getInLocale($locale) }} ({{ $languageName }})
                                                    @if (!$loop->last) / @endif
                                                @endforeach
                                            </option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endforeach
                        </select>
                        @error('product.category_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>


            <div class="form-group mb-3">
                <label for="brand">Select Brand</label>
                <select size="5" id="brand" class="form-control" wire:model="product.brand_id">
                    <option value="">Select a brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->translations->where('locale', app()->getLocale())->first()->name ?? $brand->id }}</option>
                    @endforeach
                </select>
                @error('product.brand_id') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
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
                                <button type="button" class="btn btn-danger" wire:click="removeVariation({{ $index }})">Remove</button>

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
</div>
@push('scripts')
<script type="text/javascript">
    const toolbarOptions = [
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'color': [] }, { 'background': [] }],
        ['blockquote', 'code-block'],
        [{ 'align': [] }],
        [{ 'direction': 'rtl' }],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],
        [{ 'indent': '-1'}, { 'indent': '+1' }],
        ['clean']
    ];

    document.addEventListener('DOMContentLoaded', function () {
        // Ensure the locales variable is correctly passed as a JSON object
        const locales = @json($locales);

        locales.forEach(locale => {
            const quillEditorId = 'quill-editor-' + locale;
            const quillEditorAreaId = 'quill-editor-area-' + locale;

            if (document.getElementById(quillEditorId)) {
                let editor = new Quill(`#${quillEditorId}`, {
                    modules: {
                        toolbar: toolbarOptions
                    },
                    theme: 'snow'
                });

                const quillEditorArea = document.getElementById(quillEditorAreaId);

                // Set initial content from the hidden textarea (for editing)
                editor.root.innerHTML = quillEditorArea.value;

                // Sync Quill editor changes to the hidden textarea
                editor.on('text-change', function () {
                    quillEditorArea.value = editor.root.innerHTML;
                    @this.set('translations.' + locale + '.description', quillEditorArea.value);
                });

                // Sync any textarea updates from Livewire to the Quill editor
                quillEditorArea.addEventListener('input', function () {
                    editor.root.innerHTML = quillEditorArea.value;
                });

                // Handle Livewire updates, e.g., when loading existing content
                window.addEventListener('load-cv-content-' + locale, event => {
                    editor.root.innerHTML = event.detail.content;
                    quillEditorArea.value = event.detail.content;
                });
            }
        });
    });
</script>
@endpush
