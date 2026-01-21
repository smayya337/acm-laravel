@extends('layouts.app')

@section('title', 'Events - ACM @ UVA')

@section('content')
    <h1 class="center-on-mobile">Events</h1>
    <div class="mx-auto mt-8 grid grid-cols-1 gap-8 bg-base-200 p-8 rounded-box">
        @if($events->isEmpty())
            <p>No events found. Check back later!</p>
        @else
        @foreach($events as $event)
            @include('event_card', ['event' => $event])
        @endforeach
        @endif
    </div>
@endsection 