@extends('layouts.app')

@section('title', 'Manage API Tokens - Admin')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Manage API Tokens</h1>
            <button class="btn btn-primary" onclick="document.getElementById('createTokenModal').showModal()">
                <i class="fa fa-plus"></i> Create Token
            </button>
        </div>

        <!-- Display new token if just created -->
        @if(session('new_token'))
            <div role="alert" class="alert alert-success mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1">
                    <h3 class="font-bold">Token Created Successfully!</h3>
                    <div class="text-sm mt-2">
                        <p class="mb-2">Make sure to copy your new API token now. You won't be able to see it again!</p>
                        <div class="flex items-center gap-2">
                            <input type="text" readonly value="{{ session('new_token') }}" id="newTokenValue" class="input input-bordered flex-1 font-mono text-sm">
                            <button class="btn btn-sm" onclick="copyToken()">
                                <i class="fa fa-copy"></i> Copy
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="table table-zebra not-prose">
                <thead>
                    <tr>
                        <th class="px-4">Token Name</th>
                        <th class="px-4">User</th>
                        <th class="px-4">Abilities</th>
                        <th class="px-4">Created</th>
                        <th class="px-4">Last Used</th>
                        <th class="px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tokens as $token)
                        <tr>
                            <td class="px-4">
                                <div class="font-bold">{{ $token->name }}</div>
                                <div class="text-sm opacity-50 font-mono">
                                    @php
                                        // Remove the "1|" prefix and show first 16 characters
                                        $tokenHash = explode('|', $token->token)[1] ?? $token->token;
                                    @endphp
                                    {{ substr($tokenHash, 0, 16) }}...
                                </div>
                            </td>
                            <td class="px-4">
                                @if($token->tokenable)
                                    <div class="flex items-center space-x-3">
                                        @if($token->tokenable->image)
                                            <div class="avatar">
                                                <div class="mask mask-circle w-12 h-12">
                                                    <img src="{{ Storage::url($token->tokenable->image) }}" alt="{{ $token->tokenable->first_name }}">
                                                </div>
                                            </div>
                                        @else
                                            <div class="avatar avatar-placeholder">
                                                <div class="bg-neutral text-neutral-content w-12 rounded-full">
                                                    <span>{{ substr($token->tokenable->first_name, 0, 1) }}{{ substr($token->tokenable->last_name, 0, 1) }}</span>
                                                </div>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold">{{ $token->tokenable->first_name }} {{ $token->tokenable->last_name }}</div>
                                            <div class="text-sm opacity-50">{{ $token->tokenable->username }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-error">Deleted User</span>
                                @endif
                            </td>
                            <td class="px-4">
                                @if($token->abilities && count($token->abilities) > 0)
                                    @if(in_array('*', $token->abilities))
                                        <span class="badge badge-primary">All</span>
                                    @else
                                        @foreach($token->abilities as $ability)
                                            <span class="badge badge-outline">{{ $ability }}</span>
                                        @endforeach
                                    @endif
                                @else
                                    <span class="badge badge-primary">All</span>
                                @endif
                            </td>
                            <td class="px-4">
                                <div class="text-sm">{{ $token->created_at->format('M d, Y') }}</div>
                                <div class="text-xs opacity-50">{{ $token->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-4">
                                @if($token->last_used_at)
                                    <div class="text-sm">{{ $token->last_used_at->format('M d, Y') }}</div>
                                    <div class="text-xs opacity-50">{{ $token->last_used_at->format('h:i A') }}</div>
                                @else
                                    <span class="text-warning text-sm">Never</span>
                                @endif
                            </td>
                            <td class="px-4">
                                <form method="POST" action="{{ route('admin.tokens.destroy', $token->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-error" onclick="return confirm('Are you sure you want to delete this token? This action cannot be undone.')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-base-content/50">
                                No API tokens found. Create one to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Token Modal -->
    <dialog id="createTokenModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Create API Token</h3>
            <form method="POST" action="{{ route('admin.tokens.create') }}">
                @csrf
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Token Name</span>
                    </label>
                    <input type="text" name="name" class="input input-bordered" placeholder="e.g., Mobile App Token" required>
                    <label class="label">
                        <span class="label-text-alt">A descriptive name to identify this token</span>
                    </label>
                </div>

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">User</span>
                    </label>
                    <select name="user_id" class="select select-bordered" required>
                        <option value="">Select a user</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->first_name }} {{ $user->last_name }} ({{ $user->username }})
                                @if($user->is_admin) - Admin @endif
                            </option>
                        @endforeach
                    </select>
                    <label class="label">
                        <span class="label-text-alt">The user this token will authenticate as</span>
                    </label>
                </div>

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Abilities (Optional)</span>
                    </label>
                    <div class="text-sm text-base-content/70 mb-2">
                        Leave empty for full access, or specify custom abilities
                    </div>
                    <label class="label cursor-pointer justify-start gap-2">
                        <input type="checkbox" name="abilities[]" value="*" class="checkbox checkbox-sm" checked>
                        <span class="label-text">Full Access</span>
                    </label>
                </div>

                <div class="modal-action">
                    <button type="button" class="btn" onclick="document.getElementById('createTokenModal').close()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Token</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <script>
        function copyToken() {
            const tokenInput = document.getElementById('newTokenValue');
            tokenInput.select();
            document.execCommand('copy');

            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fa fa-check"></i> Copied!';
            btn.classList.add('btn-success');

            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove('btn-success');
            }, 2000);
        }
    </script>
@endsection
