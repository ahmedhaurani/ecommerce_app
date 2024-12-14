<div>
    <h2>Pending Reviews</h2>

    @foreach($reviews as $review)
        <div class="review">
            <p><strong>Rating: {{ $review->rating }}/5</strong></p>
            <p>Review: {{ $review->review }}</p>

            @if ($review->name)

            @elseif ($review->user)
                <p>User: {{ $review->user->name }}</p>
            @endif

            <button wire:click="approve({{ $review->id }})" class="btn btn-success">Approve</button>
        </div>
        <hr>
    @endforeach


    {{-- <h2>Customer Reviews ({{ $product->reviews()->where('approved', true)->count() }})</h2>

<p>Average Rating: {{ number_format($product->reviews()->where('approved', true)->avg('rating'), 1) }}/5</p>

@foreach($product->reviews()->where('approved', true)->get() as $review)
    <div class="review">
        <p><strong>{{ $review->user ? $review->user->name : $review->visitor_name }}</strong></p>
        <p>Rating: {{ $review->rating }}/5</p>
        <p>{{ $review->review }}</p>
        <hr>
    </div>
@endforeach --}}

</div>
