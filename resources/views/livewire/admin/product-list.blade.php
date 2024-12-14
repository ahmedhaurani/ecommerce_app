<div class="container mt-5">
    <!-- Card Wrapper -->
    <div class="card">
        <div class="card-header">
            <h3>Product List</h3>
        </div>
        <div class="card-body">
            <!-- Search and Filter Section -->
            <!-- Flash Message -->
            @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif

            <div class="row mb-4">
                <div class="col-md-6">
                    <input type="text" wire:model.live="search" placeholder="Search by name..." class="form-control"
                        aria-label="Search by name">
                </div>
                <div class="col-md-6">
                    <select wire:model.live="category" class="form-select" aria-label="Filter by category">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->getTranslatedName(app()->getLocale()) }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <!-- Product Image -->
                            <td class="text-center">
                                @if (is_array($product->images) && count($product->images) > 0)
                                @foreach ($product->images as $image)
                                <img src="{{ asset('storage/' . $image) }}" class="rounded" width="50"
                                    alt="Product Image">
                                @endforeach
                                @elseif (is_string($product->images))
                                @php
                                $images = json_decode($product->images, true);
                                @endphp
                                @if (is_array($images) && count($images) > 0)
                                <img src="{{ asset('storage/' . $images[0]) }}" class="rounded" width="50"
                                    alt="Product Image">
                                @endif
                                @endif
                            </td>

                            <!-- Product Name and Description -->
                            <td>{{ $product->translation->name }}</td>
                            <td>{{ Str::limit($product->translate(app()->getLocale())->short_description, 50, '...') }}
                            </td>

                            <!-- Price -->
                            <td><strong>${{ number_format($product->price) }}</strong></td>

                            <!-- Stock Status -->
                            <td>
                                <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </td>

                            <!-- Action Buttons -->
                            <td class="d-flex">
                                <!-- Locale Icons -->
                                <div class="btn-group me-2" role="group">
                                    @foreach(array_keys(config('app.available_locales')) as $locale)
                                    <a href="{{ route('admin.products.edit_locale', ['productId' => $product->id, 'locale' => $locale]) }}"
                                        class="btn btn-outline-secondary btn-sm" title="Edit in {{ config('app.available_locales')[$locale] }}">
                                        <img src="{{ asset('images/flags/' . $locale . '.png') }}" width="20" alt="{{ $locale }} flag">
                                    </a>
                                    @endforeach
                                </div>


                                <!-- Edit Button -->
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                    class="btn btn-warning btn-sm me-2">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <!-- Delete Button with Confirmation Modal -->
                                <button wire:click="confirmDelete({{ $product->id }})"
                                    class="btn btn-danger btn-sm">Delete</button>


                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $product->id }}">Confirm
                                                    Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this product?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="#" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" wire:click="deleteProduct" class="btn btn-danger">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>






    @push('scripts')
    @script
    <script>
        window.addEventListener('open-delete-modal', event => {
        var myModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
            keyboard: false
        });
        myModal.show();
    });

    window.addEventListener('close-delete-modal', event => {
        var myModalEl = document.getElementById('deleteModal');
        var modal = bootstrap.Modal.getInstance(myModalEl);
        modal.hide();
    });
    </script>

    @endscript

    @endpush
