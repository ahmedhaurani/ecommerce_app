<div class="container mt-4">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Brand /</span> Create New Brand
      </h4>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    <div class="row">
        <div class="col-12">
    <div class="card mb-4">
        <div class="card-body">
    <form wire:submit.prevent="save">
        <div class="row mb-4">
            <div class="col-md-8">
                <!-- Language Tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    @foreach ($availableLocales as $locale)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $locale }}-tab" data-bs-toggle="tab" href="#tab-{{ $locale }}">
                                {{ strtoupper($locale) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="card mb-4">
                    <div class="card-body">
                <div class="tab-content">
                    @foreach ($availableLocales as $locale)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-{{ $locale }}">
                            <div class="mb-3">
                                <label for="name_{{ $locale }}" class="form-label">Name ({{ strtoupper($locale) }})</label>
                                <input type="text" wire:model.defer="name.{{ $locale }}" class="form-control" id="name_{{ $locale }}" required>
                                @error('name.' . $locale) <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description_{{ $locale }}" class="form-label">Description ({{ strtoupper($locale) }})</label>
                                <textarea wire:model.defer="description.{{ $locale }}" class="form-control" id="description_{{ $locale }}"></textarea>
                                @error('description.' . $locale) <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="meta_title_{{ $locale }}" class="form-label">Meta Title ({{ strtoupper($locale) }})</label>
                                <input type="text" wire:model.defer="meta_title.{{ $locale }}" class="form-control" id="meta_title_{{ $locale }}">
                                @error('meta_title.' . $locale) <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="meta_description_{{ $locale }}" class="form-label">Meta Description ({{ strtoupper($locale) }})</label>
                                <textarea wire:model.defer="meta_description.{{ $locale }}" class="form-control" id="meta_description_{{ $locale }}"></textarea>
                                @error('meta_description.' . $locale) <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="meta_keywords_{{ $locale }}" class="form-label">Meta Keywords ({{ strtoupper($locale) }})</label>
                                <input type="text" wire:model.defer="meta_keywords.{{ $locale }}" class="form-control" id="meta_keywords_{{ $locale }}">
                                @error('meta_keywords.' . $locale) <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

            <!-- Card for Brand Image -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Brand Logo</h5>
                        <div class="mb-3">
                            <input type="file" wire:model="logo" class="form-control" id="logo" accept="image/*">
                            @error('logo') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        @if ($logo)
                            <div class="mb-3">
                                <h6>Preview:</h6>
                                <img src="{{ $logo->temporaryUrl() }}" alt="Logo Preview" class="img-fluid">
                            </div>
                        @endif

                        <div class="form-check mb-3">

                            <input type="checkbox" wire:model="is_active" class="form-check-input" id="is_active">
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                        <p>Status: <strong>{{ $is_active ? 'Active' : 'Inactive' }}</strong></p>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Brand</button>
        <a href="{{ route('admin.brands.list') }}" class="btn btn-secondary">Back to List</a>
    </form>
</div>
</div>
</div>
</div>
</div>
