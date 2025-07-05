@extends('layouts.app')

@section('title', 'Manage Users - Admin')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Manage Users</h1>
            <button class="btn btn-primary" onclick="document.getElementById('createUserModal').showModal()">
                <i class="fa fa-plus"></i> Create User
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="table table-zebra not-prose">
                <thead>
                    <tr>
                        <th class="px-4">User</th>
                        <th class="px-4">Email</th>
                        <th class="px-4">Badges</th>
                        <th class="px-4">Status</th>
                        <th class="px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="px-4">
                                <div class="flex items-center space-x-3">
                                    @if($user->image)
                                        <div class="avatar">
                                            <div class="mask mask-circle w-12 h-12">
                                                <img src="{{ Storage::url($user->image) }}" alt="{{ $user->first_name }}">
                                            </div>
                                        </div>
                                    @else
                                    <div class="avatar avatar-placeholder">
                                        <div class="bg-neutral text-neutral-content w-12 rounded-full">
                                            <span>{{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    @endif
                                    <div>
                                        <div class="font-bold">
                                            <a href="{{ route('user_page', $user->username) }}" class="hover:underline">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </a>
                                        </div>
                                        <div class="text-sm opacity-50">{{ $user->username }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4">{{ $user->email }}</td>
                            <td class="px-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($user->badges as $badge)
                                        <x-badge :badge="$badge" />
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4">
                                @if($user->is_admin)
                                    <span class="badge badge-primary">Admin</span>
                                @endif
                                @if($user->hidden)
                                    <span class="badge badge-warning">Hidden</span>
                                @endif
                            </td>
                            <td class="px-4">
                                <div class="flex space-x-2">
                                    <button class="btn btn-sm btn-outline" onclick="editUser({{ $user->id }})">Edit</button>
                                    <button class="btn btn-sm btn-primary" onclick="addBadgesToUser({{ $user->id }}, '{{ $user->first_name }} {{ $user->last_name }}')">Add Badges</button>
                                    <button class="btn btn-sm btn-warning" onclick="removeBadgesFromUser({{ $user->id }}, '{{ $user->first_name }} {{ $user->last_name }}')">Remove Badges</button>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
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
    
    @include('components.modals.create-user-modal')
    @include('components.modals.edit-user-modal')
    @include('components.modals.add-badges-to-user-modal')
    @include('components.modals.remove-badges-from-user-modal')
@endsection 