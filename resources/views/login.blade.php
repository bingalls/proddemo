@extends('layouts.main')
@section('title', 'Login')
@section('content')
    <div class="login-container">
        <h1>Admin Login</h1>

        @if(session('error'))
            <div class="error-message error-bottom">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input
                    autocomplete="email"
                    class="form-control"
                    id="email"
                    name="email"
                    required
                    type="email"
                    value="{{ config('app.env') === 'local' ? 'test@example.com' : old('email', '') }}"
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    autocomplete="current-password"
                    class="form-control"
                    id="password"
                    maxlength="{{config('appfront.passwordMax')}}"
                    minlength="{{config('appfront.passwordMin')}}"
                    name="password"
                    required
                    spellcheck="false"
                    type="password"
                    value="{{ config('app.env') === 'local' ? 'password' : old('password', '') }}"
                >
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>
@endsection
