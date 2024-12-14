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
                    <input type="file" wire:model="images" multiple class="form-control mb-3">
                    <!-- Existing Images Display -->
                    @if ($existingImages)
                    <div class="row">
                        @foreach ($existingImages as $index => $image)
                        <div class="col-4 mb-2 position-relative d-flex flex-column align-items-center">
                            <div class="image-container position-relative">
                                <img src="{{ asset('storage/' . $image) }}" class="img-fluid mb-2" alt="Existing image">
                                <button type="button" class="btn btn-danger btn-icon position-absolute top-0 end-0 m-2"
                                    wire:click="removeImage({{ $index }})">
                                    <i class="bi bi-x-circle"></i>
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
                            <option disabled style="background-color: #f0f0f0;">
                                @foreach (config('app.available_locales') as $locale => $languageName)
                                    {{ $category->getInLocale($locale) }} ({{ $languageName }})
                                    @if (!$loop->last) / @endif
                                @endforeach
                            </option>
                            @foreach ($category->children as $subCategory)
                            <option value="{{ $subCategory->id }}" style="padding-left: 20px;">
                                @foreach (config('app.available_locales') as $locale => $languageName)
                                    - {{ $subCategory->getInLocale($locale) }} ({{ $languageName }})
                                    @if (!$loop->last) / @endif
                                @endforeach
                            </option>
                            @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    // Define toolbar options for Quill
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

    // Simple debounce function to limit the rate of function calls
    function debounce(func, delay) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const locales = @json($locales);

        // Initialize Quill editors for each locale
        locales.forEach(locale => {
            const quillEditorId = 'quill-editor-' + locale;
            const quillEditorAreaId = 'quill-editor-area-' + locale;

            const quillEditorElement = document.getElementById(quillEditorId);
            const quillEditorAreaElement = document.getElementById(quillEditorAreaId);

            if (quillEditorElement && quillEditorAreaElement) {
                // Initialize Quill editor
                let editor = new Quill(`#${quillEditorId}`, {
                    modules: {
                        toolbar: toolbarOptions
                    },
                    theme: 'snow'
                });

                // Set initial content from the hidden textarea
                editor.root.innerHTML = quillEditorAreaElement.value;

                // Create a debounced function to update Livewire
                const debouncedSet = debounce((content) => {
                    @this.set(`translations.${locale}.description`, content);
                }, 500); // 500ms delay

                // Listen for text changes in Quill and update Livewire
                editor.on('text-change', function () {
                    const content = editor.root.innerHTML;
                    quillEditorAreaElement.value = content;
                    debouncedSet(content);
                });

                // Listen for changes from Livewire and update Quill editor if needed
                quillEditorAreaElement.addEventListener('input', function () {
                    if (editor.root.innerHTML !== quillEditorAreaElement.value) {
                        editor.root.innerHTML = quillEditorAreaElement.value;
                    }
                });

                // Listen for custom Livewire events to load content
                window.addEventListener('load-cv-content-' + locale, event => {
                    editor.root.innerHTML = event.detail.content;
                    quillEditorAreaElement.value = event.detail.content;
                });
            }
        });

        // Preserve active tab across Livewire updates using localStorage

        // Retrieve the stored active tab or default to the first locale
        let activeTab = localStorage.getItem('activeTab') || `#{{ $locales[0] ?? 'en' }}`;

        // Activate the stored tab using Bootstrap's Tab API
        const activeTabElement = document.querySelector(`a[href="${activeTab}"]`);
        if (activeTabElement) {
            const tabInstance = new bootstrap.Tab(activeTabElement);
            tabInstance.show();
        }

        // Listen for tab changes and store the active tab in localStorage
        const tabLinks = document.querySelectorAll('.nav-link');
        tabLinks.forEach(tab => {
            tab.addEventListener('shown.bs.tab', function (event) {
                localStorage.setItem('activeTab', event.target.getAttribute('href'));
            });
        });

        // After Livewire updates the DOM, re-activate the stored tab
        Livewire.hook('message.processed', (message, component) => {
            const storedTab = localStorage.getItem('activeTab');
            if (storedTab) {
                const tabElement = document.querySelector(`a[href="${storedTab}"]`);
                if (tabElement) {
                    const tabInstance = new bootstrap.Tab(tabElement);
                    tabInstance.show();
                }
            }
        });
    });
</script>
@endpush
