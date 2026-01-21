@extends('layouts.app')

@section('title', 'Manage Events - Admin')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold mb-0">Manage Events</h1>
            <button class="btn btn-primary" onclick="document.getElementById('createEventModal').showModal()">
                <i class="fa fa-plus"></i> Create Event
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="table table-zebra not-prose">
                <thead>
                    <tr>
                        <th class="px-4">Name</th>
                        <th class="px-4">Date & Time</th>
                        <th class="px-4">Location</th>
                        <th class="px-4">Attendees</th>
                        <th class="px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td class="px-4">
                                <div class="flex items-center space-x-3">
                                    @if($event->image)
                                        <div class="avatar">
                                            <div class="mask mask-squircle w-12 h-12">
                                                <img src="{{ Storage::url($event->image) }}" alt="{{ $event->name }}">
                                            </div>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold">{{ $event->name }}</div>
                                        <div class="text-sm opacity-50">{{ Str::limit($event->description, 50) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4">
                                {{ $event->start->format('M j, Y g:i A') }}
                                @if($event->end)
                                    <br><span class="text-sm opacity-50">to {{ $event->end->format('M j, Y g:i A') }}</span>
                                @endif
                            </td>
                            <td class="px-4">{{ $event->location }}</td>
                            <td class="px-4">{{ $event->users->count() }}</td>
                            <td class="px-4">
                                <div class="flex space-x-2">
                                    <button class="btn btn-sm btn-outline" onclick="editEvent({{ $event->id }})">Edit</button>
                                    <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-error" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    @include('components.modals.create-event-modal')
    @include('components.modals.edit-event-modal')
@endsection 