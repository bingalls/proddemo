@extends('layouts.main')
@section('title', 'Admin - Products')
@section('content')
    <div class="admin-container">
        <div class="admin-header">
            <h1>Admin - Products</h1>
            <div>
                <a href="{{ route('admin.add.product') }}" class="btn btn-primary">Add New Product</a>
                <a href="{{ route('logout') }}" class="btn btn-secondary">Logout</a>
            </div>
        </div>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td class="image-size">
                        @if($product->image)
                            {{-- If you develop with TLS, then simplify this to secure_asset() only  --}}
                            @if($_SERVER['SERVER_NAME'] === '127.0.0.1')
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                            @else
                                <img src="{{ secure_asset($product->image) }}" alt="{{ $product->name }}">
                            @endif
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>
                        <a href="{{ route('admin.edit.product', $product->id) }}" class="btn btn-primary">Edit</a>
                        <button
                            class="btn btn-secondary"
                            {{-- Consider replacing onclick by attaching an event. Easier with a library --}}
                            onclick="if(confirm('Are you sure you want to delete this product?')){window.location='{{ route('admin.delete.product', $product->id) }}';}"
                        >Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
