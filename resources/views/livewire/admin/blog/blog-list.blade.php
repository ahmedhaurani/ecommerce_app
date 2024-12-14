<div class="container my-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">{{ __('Blogs') }}</h2>
        <input
            type="text"
            wire:model.live="search"
            class="form-control w-50"
            placeholder="{{ __('Search blogs...') }}"
        />
    </div>

    <!-- Blogs Table -->
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ __('Blog List') }}</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Created At') }}</th>
                        <th class="text-center">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($blogs as $blog)
                        <tr>
                            <td>{{ $blog->translation->title }}</td>
                            <td>{{ $blog->created_at->format('Y-m-d') }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('admin.blogs.edit', ['blogId' => $blog->id, 'locale' => 'en']) }}" class="btn btn-sm btn-outline-primary">
                                        {{ __('Edit (EN)') }}
                                    </a>
                                    <a href="{{ route('admin.blogs.edit', ['blogId' => $blog->id, 'locale' => 'ar']) }}" class="btn btn-sm btn-outline-secondary">
                                        {{ __('Edit (AR)') }}
                                    </a>
                                    <button wire:click="deleteBlog({{ $blog->id }})" class="btn btn-sm btn-outline-danger">
                                        {{ __('Delete') }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">
                                {{ __('No blogs found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($blogs->hasPages())
            <div class="card-footer">
                {{ $blogs->links() }}
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    @if ($confirmingDelete)
        <div class="modal fade show" style="display: block;" aria-modal="true" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">{{ __('Confirm Deletion') }}</h5>
                        <button
                            type="button"
                            class="btn-close"
                            aria-label="Close"
                            wire:click="$set('confirmingDelete', false)"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted">
                            {{ __('Are you sure you want to delete this blog? This action cannot be undone.') }}
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" wire:click="$set('confirmingDelete', false)">
                            {{ __('Cancel') }}
                        </button>
                        <button class="btn btn-danger" wire:click="confirmDelete">
                            {{ __('Confirm') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
