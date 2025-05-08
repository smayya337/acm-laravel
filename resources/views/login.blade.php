@extends('app')

@section('content')
    <h1>Log In</h1>
    @error('username')
    <div role="alert" class="alert alert-error mb-8">
        <i class="fa-solid fa-circle-xmark"></i>
        <span>{{ $message }}</span>
    </div>
    @enderror
    @error('password')
    <div role="alert" class="alert alert-error mb-8">
        <i class="fa-solid fa-circle-xmark"></i>
        <span>{{ $message }}</span>
    </div>
    @enderror
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        @if (session('status'))
            <div>{{ session('status') }}</div>
        @endif
        <label class="floating-label">
            <span>Username</span>
            <input id="username" type="text" name="username" value="{{ old('username') }}" class="input" placeholder="Username" required autofocus />
        </label>
        <label class="floating-label">
            <span>Password</span>
            <input id="password" type="password" name="password" class="input" placeholder="Password" required>
        </label>
        <div>
            <label class="me-1">Remember me</label>
            <input type="checkbox" class="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Log In</button>
        </div>
        {{--        <div>--}}
        {{--            <a href="{{ route('password.request') }}">Forgot your password?</a>--}}
        {{--        </div>--}}
    </form>
@endsection
