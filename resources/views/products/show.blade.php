@extends('layouts.main')
@section('title', $product?->name)
@section('content')
    <!DOCTYPE html>
    <div class="container">
        <div class="product-detail">
            <div>
                @if ($product?->image)
                    {{-- If you develop with TLS, then simplify this to secure_asset() only  --}}
                    @if($_SERVER['SERVER_NAME'] === '127.0.0.1')
                        <img alt="details" src="{{ asset($product->image) }}" class="product-detail-image" />
                    @else
                        <img alt="details" src="{{ secure_asset($product->image) }}"  class="product-detail-image" />
                    @endif
                @endif
            </div>
            <div class="product-detail-info">
                <h1 class="product-detail-title">{{ $product?->name }}</h1>
                <p class="product-id">Product ID: {{ $product?->id }}</p>

                <div class="price-container">
                    <span class="price-usd">${{ number_format($product?->price, 2) }}</span>
                    <span class="price-eur">&euro;{{ number_format($product?->price * $exchangeRate, 2) }}</span>
                </div>

                <div class="divider"></div>

                <div class="product-detail-description">
                    <h4 class="description-title">Description</h4>
                    <p>{{ $product?->description }}</p>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('index') }}" class="btn btn-secondary">Back to Products</a>
                    <button class="btn btn-primary">Add to Cart</button>
                </div>

                <p class="exchange-rate">
                    Exchange Rate: 1 USD = {{ number_format($exchangeRate, 4) }} EUR
                </p>
            </div>
        </div>
    </div>
@endsection
