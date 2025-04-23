@extends('layouts.main')
@section('title', 'Add New Product')
@section('content')
    <div class="admin-container admin-center">
        <h1>Add New Product</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.add.product.submit') }}" method="POST" enctype="multipart/form-data">
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
                    value="{{ old('name') }}"
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
                    maxlength="{{config('appfront.descMax')}}"
                    name="description"
                    required
                >{{ old('description') }}</textarea>
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
                    value="{{ old('price') }}"
                >
            </div>

            <div class="form-group">
                <label for="image">Product Image</label>
                <input
                    accept="image/*"
                    type="file"
                    id="image"
                    name="image"
                    class="form-control"
                >
                <small>Leave empty to use default image</small>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Add Product</button>
                <a href="{{ route('admin.products') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
