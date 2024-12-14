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
                            <input type="text" id="slug" class="form-control" wire:model.defer="product.slug">
                            @error('product.slug') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="price">Price</label>
                            <input type="number" id="price" class="form-control" wire:model.defer="product.price">
                            @error('product.price') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="stock">Stock</label>
                            <input type="number" id="stock" class="form-control" wire:model.defer="product.stock">
                            @error('product.stock') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="sku">SKU</label>
                            <input type="text" id="sku" class="form-control" wire:model.defer="product.sku">
                            @error('product.sku') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" id="in_stock" class="form-check-input" wire:model.defer="product.in_stock">
                            <label class="form-check-label" for="in_stock">In Stock</label>
                            @error('product.in_stock') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" id="is_active" class="form-check-input" wire:model.defer="product.is_active">
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
                    <ul class="nav nav-tabs" id="translationsTab" role="tablist">
                        @foreach ($locales as $index => $locale)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeLocale === $locale ? 'active' : '' }}" id="tab-{{ $locale }}"
                                data-bs-toggle="tab" data-bs-target="#locale-{{ $locale }}" type="button" role="tab"
                                aria-controls="locale-{{ $locale }}" aria-selected="{{ $activeLocale === $locale ? 'true' : 'false' }}">
                                {{ strtoupper($locale) }}
                            </button>
                        </li>
                        @endforeach
                    </ul>

                    <div class="tab-content mt-3" id="translationsTabContent">
                        @foreach ($locales as $locale)
                        <div class="tab-pane fade {{ $activeLocale === $locale ? 'show active' : '' }}" id="locale-{{ $locale }}"
                            role="tabpanel" aria-labelledby="tab-{{ $locale }}">
                            <div class="form-group mb-3">
                                <label for="name_{{ $locale }}">Title</label>
                                <input type="text" id="name_{{ $locale }}" class="form-control"
                                    wire:model.defer="translations.{{ $locale }}.name">
                                @error('translations.' . $locale . '.name') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="short_description_{{ $locale }}">Short Description</label>
                                <textarea id="short_description_{{ $locale }}" class="form-control"
                                    wire:model.defer="translations.{{ $locale }}.short_description"></textarea>
                                @error('translations.' . $locale . '.short_description') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            {{-- Quill Editor for Description --}}
                            <div class="form-group mb-3">
    <label for="description_{{ $locale }}">Description ({{ $locale }})</label>
    <div id="quill-container-{{ $locale }}" wire:ignore>
        <div id="quill-editor-{{ $locale }}" style="height: 200px;"></div>
    </div>

    <!-- Hidden textarea for Livewire binding -->
    <textarea id="quill-editor-area-{{ $locale }}" class="d-none"
              wire:model.defer="translations.{{ $locale }}.description"></textarea>

    @error('translations.' . $locale . '.description')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

                            <div class="form-group mb-3">
                                <label for="meta_title_{{ $locale }}">Meta Title</label>
                                <input type="text" id="meta_title_{{ $locale }}" class="form-control"
                                    wire:model.defer="translations.{{ $locale }}.meta_title">
                                @error('translations.' . $locale . '.meta_title') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="meta_description_{{ $locale }}">Meta Description</label>
                                <textarea id="meta_description_{{ $locale }}" class="form-control"
                                    wire:model.defer="translations.{{ $locale }}.meta_description"></textarea>
                                @error('translations.' . $locale . '.meta_description') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="meta_keywords_{{ $locale }}">Meta Keywords</label>
                                <input type="text" id="meta_keywords_{{ $locale }}" class="form-control"
                                    wire:model.defer="translations.{{ $locale }}.meta_keywords">
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
            <!-- Product Image Card -->
            <div class="card mb-4">
                <img src="path/to/your/image.jpg" class="card-img-top" alt="Product Image">
                <div class="card-body">
                    <h5 class="card-title">Product Image</h5>
                    <div class="form-group mb-3">
                        <input type="file" id="images" class="form-control" wire:model="images" multiple>
                        @error('images.*') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- Category Selection Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <h4>Select Category</h4>
                    <div class="form-group">
                        <label for="categorySelect">Category</label>
                        <select size="7" id="categorySelect" class="form-select" wire:model.defer="product.category_id">
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                @if ($category->children->isNotEmpty())
                                    <option disabled>{{ $category->getNameInLocale($locale) }}</option>
                                    @foreach ($category->children as $subCategory)
                                        <option value="{{ $subCategory->id }}">
                                            {{ $subCategory->getNameInLocale($locale) }}
                                        </option>
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
                        @error('product.category_id') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="brand">Select Brand</label>
                <select size="5" id="brand" class="form-control" wire:model.defer="product.brand_id">
                    <option value="">Select a brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">
                            {{ $brand->translations->where('locale', app()->getLocale())->first()->name ?? $brand->id }}
                        </option>
                    @endforeach
                </select>
                @error('product.brand_id') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <!-- Variation Section -->
            <div class="form-group mt-4">
                <label for="variations">Variations</label>
                <div id="variations">
                    @foreach ($product['variations'] as $index => $variation)
                    <div class="card mb-3" wire:key="variation-{{ $index }}">
                        <div class="card-body">
                            <h5 class="card-title">Variation {{ $index + 1 }}</h5>
                            <div class="form-group mb-3">
                                <label for="variation_sku_{{ $index }}">SKU</label>
                                <input type="text" id="variation_sku_{{ $index }}" class="form-control"
                                    wire:model.defer="product.variations.{{ $index }}.sku">
                                @error('product.variations.' . $index . '.sku') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="variation_price_{{ $index }}">Price</label>
                                <input type="number" id="variation_price_{{ $index }}" class="form-control"
                                    wire:model.defer="product.variations.{{ $index }}.price">
                                @error('product.variations.' . $index . '.price') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="variation_stock_{{ $index }}">Stock</label>
                                <input type="number" id="variation_stock_{{ $index }}" class="form-control"
                                    wire:model.defer="product.variations.{{ $index }}.stock">
                                @error('product.variations.' . $index . '.stock') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Tabs for Variation Translations -->
                            <ul class="nav nav-tabs" id="variationTab{{ $index }}" role="tablist">
                                @foreach ($locales as $locale)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $activeLocale === $locale ? 'active' : '' }}" id="variation-tab-{{ $locale }}-{{ $index }}"
                                        data-bs-toggle="tab" data-bs-target="#variation-{{ $locale }}-{{ $index }}" type="button" role="tab"
                                        aria-controls="variation-{{ $locale }}-{{ $index }}"
                                        aria-selected="{{ $activeLocale === $locale ? 'true' : 'false' }}">
                                        {{ strtoupper($locale) }}
                                    </button>
                                </li>
                                @endforeach
                            </ul>
                            <div class="tab-content mt-3" id="variationTabContent{{ $index }}">
                                @foreach ($locales as $locale)
                                <div class="tab-pane fade {{ $activeLocale === $locale ? 'show active' : '' }}" id="variation-{{ $locale }}-{{ $index }}"
                                    role="tabpanel" aria-labelledby="variation-tab-{{ $locale }}-{{ $index }}">
                                    <div class="form-group mb-3">
                                        <label for="variation_name_{{ $locale }}_{{ $index }}">Name</label>
                                        <input type="text" id="variation_name_{{ $locale }}_{{ $index }}" class="form-control"
                                            wire:model.defer="product.variations.{{ $index }}.translations.{{ $locale }}.name">
                                        @error('product.variations.' . $index . '.translations.' . $locale . '.name') <span class="text-danger">{{ $message }}</span> @enderror
                                        <button type="button" class="btn btn-danger mt-2" wire:click="removeVariation({{ $index }})">Remove</button>
                                    </div>

                                    {{--   for Variation Description --}}
                                    <div class="form-group mb-3">
                                        <label for="variation_description_{{ $variation->id }}">Variation Description</label>
                                        <textarea id="variation_description_{{ $variation->id }}" class="form-control"
                                                  wire:model.defer="variations.{{ $variation->id }}.description"></textarea>
                                        @error('variations.' . $variation->id . '.description')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
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
<!-- Include Quill JS and CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
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

        // Function to initialize Quill editors for descriptions only
        function initializeQuillEditor(locale) {
            let editorSelector = '#quill-editor-' + locale;
            let textareaSelector = '#quill-editor-area-' + locale;

            if (document.querySelector(editorSelector) && !document.querySelector(editorSelector).classList.contains('quill-initialized')) {
                var quill = new Quill(editorSelector, {
                    modules: { toolbar: toolbarOptions },
                    theme: 'snow'
                });

                // Mark as initialized to prevent duplicate initialization
                document.querySelector(editorSelector).classList.add('quill-initialized');

                var quillEditorArea = document.querySelector(textareaSelector);

                // Set initial content from the textarea
                quill.root.innerHTML = quillEditorArea.value;

                // Sync Quill editor changes to the hidden textarea and Livewire
                quill.on('text-change', function() {
    const translationKey = `${locale}.description`;

    quillEditorArea.value = quill.root.innerHTML;

    Livewire.emit('quillUpdate', {
        [translationKey]: quill.root.innerHTML
    });
});


                // Sync textarea changes to Quill editor
                quillEditorArea.addEventListener('input', function() {
                    quill.root.innerHTML = quillEditorArea.value;
                });

                // Handle Livewire updates (if any)
                window.addEventListener('load-cv-content-' + locale, event => {
                    quill.root.innerHTML = event.detail.content;
                    quillEditorArea.value = event.detail.content;
                });
            }
        }

        // Initialize Quill editor for the initially active tab (first locale)
        @foreach ($locales as $locale)
            initializeQuillEditor('{{ $locale }}');
        @endforeach

        // Preserve active tab state and initialize Quill when tabs are shown
        const translationsTab = document.querySelectorAll('#translationsTab button');
        translationsTab.forEach(tab => {
            tab.addEventListener('shown.bs.tab', function(event) {
                let locale = event.target.getAttribute('data-bs-target').replace('#locale-', '');

                // Initialize Quill editor for the active tab's locale if not already initialized
                initializeQuillEditor(locale);

                // Emit active locale to Livewire
                Livewire.emit('setActiveLocale', locale);
            });
        });

        Livewire.on('setActiveLocale', locale => {
            let tabTrigger = new bootstrap.Tab(document.querySelector('#tab-' + locale));
            tabTrigger.show();
        });

        // Handle Quill updates from Livewire
        Livewire.on('quillSetContent', ({ locale, content }) => {
            let editorSelector = '#quill-editor-' + locale;
            let quill = Quill.find(document.querySelector(editorSelector));
            if (quill) {
                quill.root.innerHTML = content;
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach ($locales as $locale)
            var quillEditor{{ $locale }} = new Quill('#quill-editor-{{ $locale }}', {
                theme: 'snow'
            });

            // Sync Quill content with the hidden textarea for Livewire

        @endforeach
    });
@endpush
