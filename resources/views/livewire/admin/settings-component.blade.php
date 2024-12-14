<div class="container mt-5">
    <h2 class="mb-4">Website Settings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="saveSettings">
        @csrf

        <!-- Site Name -->
        <div class="mb-3">
            <label for="site_name" class="form-label">Site Name</label>
            <input type="text" wire:model.defer="site_name" id="site_name" class="form-control" required>
            @error('site_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Site Description -->
        <div class="mb-3">
            <label for="site_description" class="form-label">Site Description</label>
            <textarea wire:model.defer="site_description" id="site_description" class="form-control" rows="3"></textarea>
            @error('site_description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Logo Upload -->
        <div class="mb-3">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" wire:model="logo" id="logo" class="form-control">
            @if($current_logo)
                <div class="mt-2">
                    <p>Current Logo:</p>
                    <img src="{{ Storage::url($current_logo) }}" alt="Logo" class="img-fluid" width="100">
                </div>
            @endif
            @error('logo') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Favicon Upload -->
        <div class="mb-3">
            <label for="favicon" class="form-label">Favicon</label>
            <input type="file" wire:model="favicon" id="favicon" class="form-control">
            @if($current_favicon)
                <div class="mt-2">
                    <p>Current Favicon:</p>
                    <img src="{{ Storage::url($current_favicon) }}" alt="Favicon" class="img-fluid" width="32">
                </div>
            @endif
            @error('favicon') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Meta Description -->
        <div class="mb-3">
            <label for="meta_description" class="form-label">Meta Description</label>
            <textarea wire:model.defer="meta_description" id="meta_description" class="form-control" rows="2"></textarea>
            @error('meta_description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Meta Keyword -->
        <div class="mb-3">
            <label for="meta_keyword" class="form-label">Meta Keyword</label>
            <textarea wire:model.defer="meta_keyword" id="meta_keyword" class="form-control" rows="2"></textarea>
            @error('meta_keyword') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Header Ads Text -->
        <div class="mb-3">
            <label for="header_ads_text" class="form-label">Header Ads Text</label>
            <textarea wire:model.defer="header_ads_text" id="header_ads_text" class="form-control" rows="2"></textarea>
            @error('header_ads_text') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Footer Text -->
        <div class="mb-3">
            <label for="footer_text" class="form-label">Footer Text</label>
            <textarea wire:model.defer="footer_text" id="footer_text" class="form-control" rows="2"></textarea>
            @error('footer_text') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Social Media Links -->
        <div class="mb-3">
            <label for="facebook" class="form-label">Facebook URL</label>
            <input type="url" wire:model.defer="facebook" id="facebook" class="form-control">
            @error('facebook') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <!-- Repeat for Instagram, Snapchat, YouTube, and X -->

        <!-- Maintenance Mode Toggle -->
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" wire:model.defer="maintenance_mode" id="maintenance_mode">
            <label class="form-check-label" for="maintenance_mode">Maintenance Mode</label>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Save Settings</button>
    </form>
</div>
