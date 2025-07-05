@extends('layouts.app')

@section('title', $event->name . ' - ACM @ UVA')

@section('content')
    <div class="row">
        <div class="col-md-4 not-prose">
            <div class="bg-base-100 rounded-lg p-6 shadow-sm border border-base-300">
                <div class="text-center">
                    @if($event->image)
                        <img src="{{ Storage::url($event->image) }}" class="w-32 h-32 md:w-40 md:h-40 rounded-lg object-cover mx-auto mb-4" alt="{{ $event->name }}">
                    @else
                        <div class="w-32 h-32 md:w-40 md:h-40 bg-neutral rounded-lg flex items-center justify-center mx-auto mb-4">
                            <span class="text-neutral-content text-2xl md:text-3xl font-bold">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                    @endif
                    
                    <h2 class="text-xl md:text-2xl font-bold mb-2">{{ $event->name }}</h2>
                    <p class="text-base-content/70 mb-4 flex items-center justify-center gap-2">
                        <i class="fa fa-map-marker-alt"></i>
                        {{ $event->location }}
                    </p>
                    
                    <div class="mb-4">
                        <h3 class="font-semibold text-sm uppercase tracking-wide text-base-content/60 mb-2">Date & Time</h3>
                        <div class="text-sm">
                            <div class="flex items-center justify-center gap-2 mb-1">
                                <i class="fa fa-clock"></i>
                                {{ $event->start->format('M j, Y g:i A') }}
                            </div>
                            @if($event->end)
                                <div class="flex items-center justify-center gap-2 text-base-content/70">
                                    <i class="fa fa-arrow-down"></i>
                                    {{ $event->end->format('M j, Y g:i A') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($event->description)
                        <div class="mb-4">
                            <h3 class="font-semibold text-sm uppercase tracking-wide text-base-content/60 mb-2">Description</h3>
                            <p class="text-sm leading-relaxed">{{ $event->description }}</p>
                        </div>
                    @endif
                    
                    @auth
                        @if(!auth()->user()->hidden)
                            @if(!$event->users->contains(auth()->user()))
                                <form method="POST" action="{{ route('events.join', $event) }}" class="mb-2">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm md:btn-md">
                                        <i class="fa fa-plus"></i> @if($event->start > now()) I'll Be There! @else I Was There! @endif
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('events.leave', $event) }}" class="mb-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-error btn-sm md:btn-md">
                                        <i class="fa fa-minus"></i> @if($event->start > now()) I Won't Be There! @else I Wasn't There! @endif
                                    </button>
                                </form>
                            @endif
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <h3>Attendees ({{ $event->users->count() }})</h3>
            @if($event->users->count() > 0)
                <div class="flex flex-wrap gap-8 p-8 bg-base-200 rounded-box not-prose">
                    @foreach($event->users as $user)
                        @include('user_card', ['user' => $user])
                    @endforeach
                </div>
            @else
                <p class="text-muted">@if($event->start > now()) No attendees yet. Be the first! @else No attendees. @endif</p>
            @endif
        </div>
    </div>
@endsection 