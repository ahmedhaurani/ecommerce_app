<div class="container-xl flex-grow-1 container-p-y">

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Brand /</span> Lisst
      </h4>
      <div class="row">
        <div class="col-12">
    <div class="card mb-4">
        <div class="card-body">
            <h4>Brands List</h4>

            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <a href="{{ route('admin.brands.create') }}" class="btn btn-primary mb-3">Add New Brand</a>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($brands as $brand)
                        <tr>
                            <td><img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" width="50"></td>
                            <td>{{ $brand->translations->first()->name ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <button wire:click="deleteBrand({{ $brand->id }})" class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>
