@extends('layouts.app')

@section('title', 'Server Error - ACM @ UVA')

@section('content')
    <div class="text-center py-12">
        <h1 class="text-6xl font-bold text-gray-400 mb-4">500</h1>
        <h2 class="text-2xl font-semibold mb-4">Server Error</h2>
        <p class="text-gray-600 mb-8">Something went wrong on our end. Please try again later.</p>
        <a href="/" class="btn btn-primary">Go Home</a>
    </div>
@endsection 