@extends('layouts.app')

@section('title', 'Login - ACM @ UVA')

@section('content')
    <div class="container mx-auto max-w-md">
        <h1 class="text-3xl font-bold mb-6">Login</h1>
        
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="next" value="{{ $next }}">
            
            <fieldset class="form-control">
                <legend class="fieldset-legend">
                    <span class="label-text">Username *</span>
                </legend>
                <input type="text" class="input input-bordered" id="username" name="username" required>
            </fieldset>
            
            <fieldset class="form-control">
                <legend class="fieldset-legend">
                    <span class="label-text">Password *</span>
                </legend>
                <input type="password" class="input input-bordered" id="password" name="password" required>
            </fieldset>
            
            <div class="form-control mt-6">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
@endsection 