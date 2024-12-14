<div class="container my-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-lg font-bold">{{ $adId ? 'Edit Ad' : 'Add Ad' }}</h2>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="saveAd">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" wire:model="title" class="form-control">
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" wire:model="image" class="form-control">
                            @if ($existingAd && !$image)
                                <img src="{{ Storage::url($existingAd->image) }}" alt="{{ $title }}" class="img-thumbnail mt-2" style="width: 150px;">
                            @endif
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Link</label>
                            <input type="url" wire:model="link" class="form-control">
                            @error('link') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Position</label>
                            <input type="text" wire:model="position" class="form-control">
                            @error('position') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-check-label">Active</label>
                            <input type="checkbox" wire:model="is_active" class="form-check-input" value="1">
                        </div>

                        <button type="submit" class="btn btn-primary">{{ $adId ? 'Update' : 'Add' }} Ad</button>
                        <a href="{{ route('admin.ads') }}" class="btn btn-secondary">Cancel</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
