@extends('app')

@section('content')
    <h1>Log In</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        @if (session('status'))
            <div>{{ session('status') }}</div>
        @endif
        <div>
            <label for="username">Username</label>
            <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
            @error('username')
            <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
            @error('password')
            <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                Remember me
            </label>
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
        {{--        <div>--}}
        {{--            <a href="{{ route('password.request') }}">Forgot your password?</a>--}}
        {{--        </div>--}}
    </form>
@endsection
