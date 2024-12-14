<div class="container my-5">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-lg font-bold mb-4">Ads List</h2>
                    @if (session()->has('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif
                    <a href="/admin/ads/create" class="btn btn-primary">Add Ad</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Position</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ads as $ad)
                                <tr>
                                    <td>
                                        <img src="{{ Storage::url($ad->image) }}" alt="{{ $ad->title }}" class="img-thumbnail" style="width: 75px;">
                                    </td>
                                    <td>{{ $ad->title }}</td>
                                    <td>{{ $ad->position }}</td>
                                    <td>
                                        <a href="{{ route('admin.ads.edit', $ad->id) }}" class="btn btn-sm btn-info">Edit</a>
                                         <button wire:click="confirmDelete({{ $ad->id }})" class="btn btn-sm btn-danger">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            @if ($deleteId)
                <div class="modal fade show d-block" style="background: rgba(0, 0, 0, 0.5);" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm Deletion</h5>
                                <button type="button" wire:click="$set('deleteId', null)" class="btn-close" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this ad?</p>
                            </div>
                            <div class="modal-footer">
                                <button wire:click="deleteAd" class="btn btn-danger">Yes, Delete</button>
                                <button wire:click="$set('deleteId', null)" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
