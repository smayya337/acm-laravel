@extends('layouts.app')

@section('title', 'Manage Officers - Admin')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold mb-0">Manage Officers</h1>
            <button class="btn btn-primary" onclick="document.getElementById('createOfficerModal').showModal()">
                <i class="fa fa-plus"></i> Add Officer
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="table table-zebra not-prose">
                <thead>
                    <tr>
                        <th class="px-4">Officer</th>
                        <th class="px-4">Position</th>
                        <th class="px-4">Year</th>
                        <th class="px-4">Sort Order</th>
                        <th class="px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($officers as $officer)
                        <tr>
                            <td class="px-4">
                                <div class="flex items-center space-x-3">
                                    @if($officer->user->image)
                                        <div class="avatar">
                                            <div class="mask mask-circle w-12 h-12">
                                                <img src="{{ Storage::url($officer->user->image) }}" alt="{{ $officer->user->first_name }}">
                                            </div>
                                        </div>
                                    @else
                                        <div class="avatar avatar-placeholder">
                                            <div class="bg-secondary text-secondary-content w-12 rounded-full">
                                                <span>{{ substr($officer->user->first_name, 0, 1) }}{{ substr($officer->user->last_name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold">{{ $officer->user->first_name }} {{ $officer->user->last_name }}</div>
                                        <div class="text-sm opacity-50">{{ $officer->user->username }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4">{{ $officer->position }}</td>
                            <td class="px-4">{{ $officer->year }}-{{ $officer->year + 1 }}</td>
                            <td class="px-4">{{ $officer->sort_order }}</td>
                            <td class="px-4">
                                <div class="flex space-x-2">
                                    <button class="btn btn-sm btn-outline" onclick="editOfficer({{ $officer->id }})">Edit</button>
                                    <form method="POST" action="{{ route('admin.officers.destroy', $officer) }}" class="inline">
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
    
    @include('components.modals.create-officer-modal')
    @include('components.modals.edit-officer-modal')
@endsection 