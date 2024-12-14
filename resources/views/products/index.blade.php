{{-- <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ config('app.direction') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body> --}}
    <h1>Product List</h1>

    <ul>
        @forelse ($products as $product)
            <li>
                <h2>{{ $product->translation->name ?? 'No name available' }}</h2>
                <p>{{ $product->translation->description ?? 'No description available' }}</p>
                <p>Price: ${{ $product->price }}</p>
                <p>Stock: {{ $product->stock }}</p>
                <p>SKU: {{ $product->sku }}</p>
            </li>
        @empty
            <p>No products with translations available.</p>
        @endforelse
    </ul>
    {{-- <script src="{{ mix('js/app.js') }}"></script>
</body>
</html> --}}
