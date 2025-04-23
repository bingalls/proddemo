@extends('layouts.main')
@section('title', 'Products')
@section('content')
    <div class="container">
        <h1>Products</h1>

        <div class="products-grid">
            @forelse ($products as $product)
                <div class="product-card">
                    @if ($product->image)
                        {{-- If you develop with TLS, then simplify this to secure_asset() only  --}}
                        @if($_SERVER['SERVER_NAME'] === '127.0.0.1')
                            <img src="{{ asset($product->image) }}" class="product-image" alt="{{ $product->name }}">
                        @else
                            <img src="{{ secure_asset($product->image) }}" class="product-image" alt="{{ $product->name }}">
                        @endif
                    @endif
                    <div class="product-info">
                        <h2 class="product-title">{{ $product->name }}</h2>
                        <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                        <div class="price-container">
                            <span class="price-usd">${{ number_format($product->price, 2) }}</span>
                            <span class="price-eur">&euro;{{ number_format($product->price * $exchangeRate, 2) }}</span>
                        </div>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            @empty
                <div class="empty-message">
                    <p>No products found.</p>
                </div>
            @endforelse
        </div>

        <div class="exchange-rate exchange-center">
            <p>Exchange Rate: 1 USD = {{ number_format($exchangeRate, 4) }} EUR</p>
        </div>
    </div>
@endsection
