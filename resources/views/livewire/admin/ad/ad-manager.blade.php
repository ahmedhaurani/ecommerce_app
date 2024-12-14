<div class="p-6">
    <h2 class="text-lg font-bold mb-4">Manage Ads</h2>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="mb-4 text-green-500">{{ session('message') }}</div>
    @endif

    <!-- Ad Creation/Editing Form -->
    <form wire:submit.prevent="saveAd" class="mb-8">
        <div class="mb-4">
            <label class="block text-gray-700">Title</label>
            <input type="text" wire:model="title" class="w-full border rounded p-2">
            @error('title') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Image</label>
            <input type="file" wire:model="image" class="w-full border rounded p-2">
            @error('image') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Link</label>
            <input type="url" wire:model="link" class="w-full border rounded p-2">
            @error('link') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Position</label>
            <input type="number" wire:model="position" class="w-full border rounded p-2">
            @error('position') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Active</label>
            <input type="checkbox" wire:model="is_active"  class="mr-2"> Yes
        </div>

        <button type="submit" class="bg-blue-500 text-white p-2 rounded">
            {{ $adId ? 'Update Ad' : 'Add Ad' }}
        </button>
        @if($adId)
            <button type="button" wire:click="resetForm" class="bg-gray-500 text-white p-2 rounded ml-2">Cancel</button>
        @endif
    </form>

    <!-- Existing Ads -->
    <h3 class="text-md font-semibold mb-4">Existing Ads</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($ads as $ad)
            <div class="border rounded p-4 relative">
                <img src="{{ Storage::url($ad->image) }}" alt="{{ $ad->title }}" class="w-full h-40 object-cover mb-2">
                <h4 class="font-semibold">{{ $ad->title }}</h4>
                <p class="text-sm">Position: {{ $ad->position }}</p>
                @if($ad->link)
                    <a href="{{ $ad->link }}" target="_blank" class="text-blue-500 block mb-2">View Link</a>
                @endif
                <div class="flex justify-between mt-2">
                    <button wire:click="editAd({{ $ad->id }})" class="text-blue-500">Edit</button>
                    <button wire:click="deleteAd({{ $ad->id }})" class="text-red-500">Delete</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
