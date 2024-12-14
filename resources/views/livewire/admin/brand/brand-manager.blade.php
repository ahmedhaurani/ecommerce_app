<div>
    <div class="card mb-4">
        <div class="card-body">
            <h4>{{ $editing ? 'Edit Brand' : 'Create Brand' }}</h4>

            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="save">
                <div class="mb-3">
                    <label for="logo" class="form-label">Brand Logo</label>
                    <input type="file" wire:model="logo" class="form-control" id="logo" accept="image/*">
                    @error('logo') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Active Status -->
                <div class="form-check mb-3">
                    <input type="checkbox" wire:model="is_active" class="form-check-input" id="is_active">
                    <label class="form-check-label" for="is_active">Active</label>
                </div>

                <!-- Tabs for Language -->
                <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                    @foreach ($availableLocales as $locale)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $locale }}-tab" data-bs-toggle="tab" href="#tab-{{ $locale }}" role="tab" aria-controls="tab-{{ $locale }}" aria-selected="{{ $loop->first }}">
                                {{ strtoupper($locale) }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content" id="languageTabsContent">
                    @foreach ($availableLocales as $locale)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-{{ $locale }}" role="tabpanel" aria-labelledby="tab-{{ $locale }}-tab">
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

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        {{ $editing ? 'Update Brand' : 'Create Brand' }}
                    </button>
                    <a href="{{ route('admin.brands') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h4>Brand List</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Logo</th>
                        @foreach ($availableLocales as $locale)
                            <th>Name ({{ strtoupper($locale) }})</th>
                        @endforeach
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($brands as $brand)
                        <tr>
                            <td>
                                @if ($brand->logo)
                                    <img src="{{ asset('storage/' . $brand->logo) }}" alt="Logo" width="50">
                                @endif
                            </td>
                            @foreach ($availableLocales as $locale)
                                <td>{{ $brand->getTranslatedName($locale) }}</td>
                            @endforeach
                            <td>{{ $brand->is_active ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <button wire:click="editBrand({{ $brand->id }})" class="btn btn-sm btn-warning">Edit</button>
                                <button wire:click="deleteBrand({{ $brand->id }})" class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
