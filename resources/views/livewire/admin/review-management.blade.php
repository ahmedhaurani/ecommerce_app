<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <h3>Pending Reviews</h3>
    @if($pendingReviews->isEmpty())
        <p>No pending reviews.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingReviews as $review)
                    <tr>
                        <td>{{ $review->user ? $review->user->name : $review->name }}</td>
                        <td>{{ $review->rating }}/5</td>
                        <td>{{ $review->review }}</td>
                        <td>
                            <button wire:click="approveReview({{ $review->id }})" class="btn btn-success">Approve</button>
                            <button wire:click="deleteReview({{ $review->id }})" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <hr>

    <h3>Approved Reviews</h3>
    @if($approvedReviews->isEmpty())
        <p>No approved reviews yet.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($approvedReviews as $review)
                    <tr>
                        <td>{{ $review->user ? $review->user->name : $review->name }}</td>
                        <td>{{ $review->rating }}/5</td>
                        <td>{{ $review->review }}</td>
                        <td>
                            <button wire:click="deleteReview({{ $review->id }})" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
