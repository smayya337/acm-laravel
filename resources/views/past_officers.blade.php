@extends('layouts.app')

@section('title', $academic_year . ' Officers - ACM @ UVA')

@section('content')
    <h1>{{ $academic_year }} Officers</h1>
    @include('leadership')
@endsection 