<div>
    <h1 class="text-xl font-bold mb-4">Manage Categories</h1>

    <!-- Success Message -->
    @if (session()->has('success'))
        <div class="bg-green-200 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Category Form -->
    <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="mb-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="name" class="block">Name</label>
                <input type="text" wire:model="name" id="name" class="border rounded p-2 w-full" required>
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="slug" class="block">Slug</label>
                <input type="text" wire:model="slug" id="slug" class="border rounded p-2 w-full" required>
                @error('slug') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="parent_id" class="block">Parent Category</label>
                <select wire:model="parent_id" id="parent_id" class="border rounded p-2 w-full">
                    <option value="">Select Parent</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="active" class="block">Active</label>
                <input type="checkbox" wire:model="active" id="active" class="h-5 w-5">
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                {{ $isEdit ? 'Update Category' : 'Create Category' }}
            </button>
            @if ($isEdit)
                <button type="button" wire:click="resetForm" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded">
                    Cancel
                </button>
            @endif
        </div>
    </form>

    <!-- Category List -->
    <h2 class="text-lg font-bold mb-2">Category List</h2>
    <table class="min-w-full border">
        <thead>
            <tr>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Slug</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td class="border px-4 py-2">{{ $category->name }}</td>
                    <td class="border px-4 py-2">{{ $category->slug }}</td>
                    <td class="border px-4 py-2">
                        <button wire:click="edit({{ $category->id }})" class="text-blue-500">Edit</button>
                        <button wire:click="delete({{ $category->id }})" class="text-red-500">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
