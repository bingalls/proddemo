@extends('layouts.main')
@section('title', 'Edit Product')
@section('content')
    <div class="admin-container admin-center">
        <h1>Edit Product</h1>

        @if ($errors?->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.update.product', $product?->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Product Name</label>
                <input
                    class="form-control"
                    id="name"
                    maxlength="{{config('appfront.prodNameMax')}}"
                    minlength="{{config('appfront.prodNameMin')}}"
                    name="name"
                    required
                    type="text"
                    value="{{ old('name', $product?->name) }}"
                >
                @error('name')
                    <div class="error-message error-top">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea
                    class="form-control"
                    id="description"
                    {{-- Get biz rules through blade files for max limits --}}
                    maxlength="{{config('appfront.descMax')}}"
                    name="description"
                    required
                >{{ old('description', $product?->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input
                    class="form-control"
                    id="price"
                    max="{{config('appfront.priceMax')}}"
                    min="0"
                    name="price"
                    required
                    step="0.01"
                    type="number"
                    value="{{ old('price', $product?->price) }}"
                >
            </div>

            <div class="form-group">
                <label for="image">Current Image</label>
                @if($product?->image)
                    {{-- If you develop with TLS, then simplify this to secure_asset() only  --}}
                    @if($_SERVER['SERVER_NAME'] === '127.0.0.1')
                        <img src="{{ asset($product?->image) }}" class="product-image" alt="{{ $product?->name }}">
                    @else
                        <img src="{{ secure_asset($product?->image) }}" class="product-image" alt="{{ $product?->name }}">
                    @endif
                @endif
                <input
                    accept=".gif,.jpg,.jpeg,.png"
                    class="form-control"
                    id="image"
                    name="image"
                    type="file"
                >
                <small>Leave empty to keep current image</small>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="{{ route('admin.products') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
