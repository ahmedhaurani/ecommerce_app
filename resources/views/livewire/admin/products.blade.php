<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" id="slug" class="form-control" wire:model="product.slug">
            @error('product.slug') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" id="price" class="form-control" wire:model="product.price">
            @error('product.price') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="category_id">Category</label>
            <select id="category_id" class="form-control" wire:model="product.category_id">
                <option value="">Select a Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('product.category_id') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" id="stock" class="form-control" wire:model="product.stock">
            @error('product.stock') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="sku">SKU</label>
            <input type="text" id="sku" class="form-control" wire:model="product.sku">
            @error('product.sku') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="in_stock">In Stock</label>
            <input type="checkbox" id="in_stock" wire:model="product.in_stock">
            @error('product.in_stock') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="is_active">Is Active</label>
            <input type="checkbox" id="is_active" wire:model="product.is_active">
            @error('product.is_active') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="images">Images</label>
            <input type="file" id="images" class="form-control" wire:model="imageUploads" multiple>
            @error('imageUploads.*') <span class="error">{{ $message }}</span> @enderror
        </div>

        @foreach ($locales as $locale)
            <h5>Translation ({{ $locale }})</h5>
            <div class="form-group">
                <label for="name_{{ $locale }}">Name</label>
                <input type="text" id="name_{{ $locale }}" class="form-control" wire:model="translations.{{ $locale }}.name">
                @error('translations.{{ $locale }}.name') <span class="error">{{ $message }}</span> @enderror
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Save Product</button>
    </form>

    <h2>Product List</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Slug</th>
                <th>Price</th>
                <th>Category</th>
                <th>Stock</th>
                <th>SKU</th>
                <th>Images</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->slug }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>
                        @if ($product->images)
                            @foreach ($product->images as $image)
                                <img src="{{ asset('storage/' . $image) }}" width="50">
                            @endforeach
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
