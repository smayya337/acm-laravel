@extends('layouts.app')

@section('title', 'Manage Badges - Admin')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold mb-0">Manage Badges</h1>
            <button class="btn btn-primary" onclick="document.getElementById('createBadgeModal').showModal()">
                <i class="fa fa-plus"></i> Create Badge
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="table table-zebra not-prose">
                <thead>
                    <tr>
                        <th class="px-4">Badge</th>
                        <th class="px-4">Description</th>
                        <th class="px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($badges as $badge)
                        <tr>
                            <td class="px-4">
                                <x-badge :badge="$badge" />
                            </td>
                            <td class="px-4">{{ Str::limit($badge->description, 50) }}</td>
                            <td class="px-4">
                                <div class="flex space-x-2">
                                    <button class="btn btn-sm btn-outline" onclick="editBadge({{ $badge->id }})">Edit</button>
                                    <form method="POST" action="{{ route('admin.badges.destroy', $badge) }}" class="inline">
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
    
    @include('components.modals.create-badge-modal')
    @include('components.modals.edit-badge-modal')
@endsection 