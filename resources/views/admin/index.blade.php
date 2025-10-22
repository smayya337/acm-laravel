@extends('layouts.app')

@section('title', 'Admin Dashboard - ACM @ UVA')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>
        
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div class="stat bg-primary text-primary-content">
                <div class="stat-title text-primary-content">Total Users</div>
                <div class="stat-value">{{ $stats['users'] }}</div>
            </div>
            <div class="stat bg-secondary text-secondary-content">
                <div class="stat-title text-secondary-content">Total Events</div>
                <div class="stat-value">{{ $stats['events'] }}</div>
            </div>
            <div class="stat bg-accent text-accent-content">
                <div class="stat-title text-accent-content">Total Officers</div>
                <div class="stat-value">{{ $stats['officers'] }}</div>
            </div>
            <div class="stat bg-neutral text-neutral-content">
                <div class="stat-title text-neutral-content">Total Badges</div>
                <div class="stat-value">{{ $stats['badges'] }}</div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 p-8 bg-base-200 rounded-box">
            <div class="card bg-base-100 shadow-md not-prose">
                <div class="card-body">
                    <h2 class="card-title">Events</h2>
                    <p>Manage upcoming and past events</p>
                    <div class="card-actions justify-end gap-4">
                        <button class="btn btn-primary" onclick="document.getElementById('createEventModal').showModal()">Create Event</button>
                        <a href="{{ route('admin.events') }}" class="btn btn-outline">View All</a>
                    </div>
                </div>
            </div>
            
            <div class="card bg-base-100 shadow-md not-prose">
                <div class="card-body">
                    <h2 class="card-title">Users</h2>
                    <p>Manage user accounts and profiles</p>
                    <div class="card-actions justify-end gap-4">
                        <button class="btn btn-primary" onclick="document.getElementById('createUserModal').showModal()">Create User</button>
                        <a href="{{ route('admin.users') }}" class="btn btn-outline">View All</a>
                    </div>
                </div>
            </div>
            
            <div class="card bg-base-100 shadow-md not-prose">
                <div class="card-body">
                    <h2 class="card-title">Officers</h2>
                    <p>Manage current and past officers</p>
                    <div class="card-actions justify-end gap-4">
                        <button class="btn btn-primary" onclick="document.getElementById('createOfficerModal').showModal()">Add Officer</button>
                        <a href="{{ route('admin.officers') }}" class="btn btn-outline">View All</a>
                    </div>
                </div>
            </div>
            
            <div class="card bg-base-100 shadow-md not-prose">
                <div class="card-body">
                    <h2 class="card-title">Badges</h2>
                    <p>Manage user badges and achievements</p>
                    <div class="card-actions justify-end gap-4">
                        <button class="btn btn-primary" onclick="document.getElementById('createBadgeModal').showModal()">Create Badge</button>
                        <a href="{{ route('admin.badges') }}" class="btn btn-outline">View All</a>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-md not-prose">
                <div class="card-body">
                    <h2 class="card-title">API Tokens</h2>
                    <p>Manage API authentication tokens</p>
                    <div class="card-actions justify-end gap-4">
                        <a href="{{ route('admin.tokens') }}" class="btn btn-primary">Manage Tokens</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <!-- Include Modal Components -->
    @include('components.modals.create-event-modal')
    @include('components.modals.create-user-modal')
    @include('components.modals.create-officer-modal')
    @include('components.modals.create-badge-modal')

@endsection 