<div class="container my-4">
    <div class="card shadow">
        <!-- Card Header -->
        <div class="card-header text-white">
            <h2 class="mb-0">{{ __('Edit Blog') }}</h2>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <form wire:submit.prevent="save">
                <!-- Category Selector -->
                <div class="mb-4">
                    <label for="category_id" class="form-label">{{ __('Category') }}</label>
                    <select id="category_id" wire:model="category_id" class="form-select">
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->translation ? $category->translation->name : $category->slug }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- Title -->
                <div class="mb-4">
                    <label for="title" class="form-label">{{ __('Title') }}</label>
                    <input type="text" id="title" wire:model="title" class="form-control">
                    @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- Content -->
                <div class="mb-4">
                    <label for="content" class="form-label">{{ __('Content') }}</label>
                    <textarea id="content" wire:model="content" class="form-control" rows="4"></textarea>
                    @error('content') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- Image Upload -->
                <div class="mb-4">
                    <label for="image" class="form-label">{{ __('Image') }}</label>
                    @if ($existingImage)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $existingImage) }}" alt="Blog Image" class="img-thumbnail" width="150">
                        </div>
                    @endif
                    <input type="file" id="image" wire:model="image" class="form-control">
                    @error('image') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- Keywords -->
                <div class="mb-4">
                    <label for="keywords" class="form-label">{{ __('Keywords') }}</label>
                    <input type="text" id="keywords" wire:model="keywords" class="form-control">
                    @error('keywords') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- Meta Description -->
                <div class="mb-4">
                    <label for="meta_description" class="form-label">{{ __('Meta Description') }}</label>
                    <textarea id="meta_description" wire:model="meta_description" class="form-control" rows="3"></textarea>
                    @error('meta_description') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- Featured -->
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" id="featured" wire:model="featured" class="form-check-input">
                    <label for="featured" class="form-check-label">{{ __('Featured') }}</label>
                </div>

                <!-- Active -->
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" id="active" wire:model="active" class="form-check-input">
                    <label for="active" class="form-check-label">{{ __('Active') }}</label>
                </div>
            </form>
        </div>

        <!-- Card Footer -->
        <div class="card-footer d-flex justify-content-end">
            <button type="submit" class="btn btn-success me-2">{{ __('Save') }}</button>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        </div>
    </div>
</div>
