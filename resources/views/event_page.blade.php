@php use Carbon\Carbon; @endphp
@extends('app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-x-6 lg:gap-x-8 gap-y-5">
            {{-- Image Column --}}
            {{-- Original responsive classes: col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 --}}
            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/6 flex-shrink-0">
                <img src="{{ $event->image_url ?? asset('images/event_placeholder.png') }}"
                     {{-- Fallback placeholder image --}}
                     class="border-2 border-base-300 rounded-lg h-full w-full object-cover shadow-md"
                     alt="Image for event {{ $event->name }}">
            </div>

            {{-- Content Column --}}
            <div class="flex-grow">
                <h1 class="text-3xl lg:text-4xl font-bold mb-3">{{ $event->name }}</h1>

                {{-- Event Details --}}
                <div class="space-y-1 text-base-content/80 mb-4">
                    <p>
                        <strong class="font-semibold text-base-content">When: </strong>
                        {{ Carbon::parse($event->start)->format('F j, Y, g:i A') }}
                        @if ($event->end)
                            {{ Carbon::parse($event->end)->format('F j, Y, g:i A') }}
                        @endif
                    </p>
                    <p><strong class="font-semibold text-base-content">Where: </strong>{{ $event->location }}</p>
                </div>

                {{-- Event Description (handles Markdown) --}}
                @if($event->description)
                    <div class="prose prose-sm sm:prose-base max-w-none mb-6 text-base-content/90">
                        {!! Str::markdown($event->description) !!}
                        {{-- If description is plain text, use: <p>{{ $event->description }}</p> --}}
                    </div>
                @endif

                {{-- Attendance Form --}}
                {{--                @if (Auth::check())--}}
                {{--                    --}}{{-- For a POST to the current URL, or better, a dedicated named route --}}
                {{--                    <form action="{{ url()->current() }}" method="post">--}}
                {{--                        @csrf--}}
                {{--                        @if ($isCurrentUserAttending ?? false)--}}
                {{--                            @if ($event_happened ?? false)--}}
                {{--                                <button class="btn btn-error btn-sm sm:btn-md" type="submit">I didn't attend!</button>--}}
                {{--                            @else--}}
                {{--                                <button class="btn btn-error btn-sm sm:btn-md" type="submit">I'm not attending!</button>--}}
                {{--                            @endif--}}
                {{--                        @else--}}
                {{--                            @if ($event_happened ?? false)--}}
                {{--                                <button class="btn btn-success btn-sm sm:btn-md" type="submit">I attended!</button>--}}
                {{--                            @else--}}
                {{--                                <button class="btn btn-primary btn-sm sm:btn-md" type="submit">I'm attending!</button>--}}
                {{--                            @endif--}}
                {{--                        @endif--}}
                {{--                    </form>--}}
                {{--                @endif--}}
            </div>
        </div>

        {{-- Attendees Section --}}
        {{--        @if ($event->attendees && $event->attendees->count() > 0)--}}
        {{--            <div class="mt-8 pt-6 border-t border-base-300">--}}
        {{--                @if ($event->start >= now())--}}
        {{--                    <h2 class="text-2xl font-semibold mb-4">Who Attended ({{ $attendees->count() }})</h2>--}}
        {{--                @else--}}
        {{--                    <h2 class="text-2xl font-semibold mb-4">Who's Attending ({{ $attendees->count() }})</h2>--}}
        {{--                @endif--}}
        {{--                --}}{{-- Original responsive classes for attendees: col-2 (~6 per row), col-lg-1 (~12 per row on lg) --}}
        {{--                <div class="grid grid-cols-6 sm:grid-cols-8 md:grid-cols-10 lg:grid-cols-12 gap-3">--}}
        {{--                    @foreach ($event->attendees as $attendee)--}}
        {{--                        <a href="{{ route('user_page', $attendee->username) }}"--}}
        {{--                           class="tooltip tooltip-bottom block aspect-square" --}}{{-- DaisyUI tooltip --}}
        {{--                           data-tip="{{ $attendee->first_name }} {{ $attendee->last_name }}">--}}
        {{--                            --}}{{----}}
        {{--                                The profile_image partial should render a responsive image--}}
        {{--                                that fills its container (e.g., using w-full h-full object-cover rounded-full)--}}
        {{--                            --}}
        {{--                            @include('profile_image', ['user' => $attendee])--}}
        {{--                        </a>--}}
        {{--                    @endforeach--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        @endif--}}
    </div>
@endsection
