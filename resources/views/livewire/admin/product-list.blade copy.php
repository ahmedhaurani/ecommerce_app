<div class="container mt-5">
    <!-- Card Wrapper -->
    <div class="card">
        <div class="card-header">
            <h3>Product List</h3>
        </div>
        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <input type="text" wire:model.live="search" placeholder="Search by name..." class="form-control" aria-label="Search by name">
                </div>
                <div class="col-md-6">
                    <select wire:model.live="category" class="form-select" aria-label="Filter by category">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->getTranslatedName(app()->getLocale()) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="card mb-4">
                  <h5 class="card-header">Basic</h5>
                  <div class="card-body">
                    <p class="card-text">
                      Toggle the visibility of content across your project with a few classes and our JavaScript plugins.
                    </p>
                    <p class="demo-inline-spacing">
                      <a class="btn btn-primary me-1" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Link with href
                      </a>
                      <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Button with data-bs-target
                      </button>
                    </p>
                    <div class="collapse" id="collapseExample">
                      <div class="d-grid d-sm-flex p-3 border">
                        <img src="../../assets/img/elements/1.jpg" alt="collapse-image" height="125" class="me-4 mb-sm-0 mb-2">
                        <span>
                          Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <!-- Products Table -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
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
                                <td>
                                    @if (is_array($product->images) && count($product->images) > 0)
                                        @foreach ($product->images as $image)
                                            <img src="{{ asset('storage/' . $image) }}" width="50" alt="Product Image">
                                        @endforeach
                                    @elseif (is_string($product->images))
                                        @php
                                            $images = json_decode($product->images, true);
                                        @endphp
                                        @if (is_array($images) && count($images) > 0)
                                            <img src="{{ asset('storage/' . $images[0]) }}" width="50" alt="Product Image">
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $product->translate(app()->getLocale())->short_description }}</td>
                                <td><strong>${{ $product->price }}</strong></td>
                                <td>{{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="#" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
