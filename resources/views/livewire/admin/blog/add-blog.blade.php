<div class="container my-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header text-white">
                    <h4 class="mb-0">{{ __('Add Blog') }}</h4>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        <!-- Category -->
                        <div class="form-group">
                            <label for="category_id">{{ __('Category') }}</label>
                            <select id="category_id" wire:model="category_id" class="form-control">
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->translation ? $category->translation->name : $category->slug }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Title -->
                        <div class="form-group">
                            <label>{{ __('Title') }}</label>
                            <input type="text" wire:model="title" class="form-control">
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Content -->
                        <div class="form-group">
                            <label>{{ __('Content') }}</label>
                            <textarea wire:model="content" class="form-control" rows="5"></textarea>
                            @error('content') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Image -->
                        <div class="form-group">
                            <label>{{ __('Image') }}</label>
                            <input type="file" wire:model="image" class="form-control">
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Keywords -->
                        <div class="form-group">
                            <label>{{ __('Keywords') }}</label>
                            <input type="text" wire:model="keywords" class="form-control">
                        </div>

                        <!-- Meta Description -->
                        <div class="form-group">
                            <label>{{ __('Meta Description') }}</label>
                            <textarea wire:model="meta_description" class="form-control" rows="3"></textarea>
                        </div>

                        <!-- Featured Checkbox -->
                        <div class="form-check mb-3">
                            <input type="checkbox" wire:model="featured" class="form-check-input" id="featured">
                            <label for="featured" class="form-check-label">{{ __('Featured') }}</label>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button class="btn btn-success">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
