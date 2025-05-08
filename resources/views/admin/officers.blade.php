@extends('app')

@section('content')
    <h1>Edit Officers</h1>
    <label for="addOfficerModal" class="btn btn-primary mb-2">
{{--        TODO: add SVG icon here--}}
        Add Officer
    </label>
    <div class="overflow-x-auto">
        <table class="table not-prose">
            <!-- head -->
            <thead>
            <tr>
{{--                <th>--}}
{{--                    <label>--}}
{{--                        <input type="checkbox" class="checkbox" />--}}
{{--                    </label>--}}
{{--                </th>--}}
                <th>Name</th>
                <th>Position</th>
                <th>Academic Year</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <!-- row 1 -->
            @foreach($officers as $officer)
            <tr>
{{--                <th>--}}
{{--                    <label>--}}
{{--                        <input type="checkbox" class="checkbox" />--}}
{{--                    </label>--}}
{{--                </th>--}}
                <td>
                    <div class="flex items-center gap-3">
                        <a class="avatar" href="{{ route('user_page', ['user' => $officer->user]) }}">
                            <div class="mask mask-circle h-12 w-12">
                                @if($officer->user->image)
                                    <img
                                        src="{{ Storage::url($officer->user->image) }}"
                                        alt="Image of {{ $officer->user->first_name }} {{ $officer->user->last_name }}" />
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="-224 -192 896 1024" fill="currentColor"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"/></svg>
                                @endif
                            </div>
                        </a>
                        <div>
                            <a class="font-bold" href="{{ route('user_page', ['user' => $officer->user]) }}">{{ $officer->user->first_name }} {{ $officer->user->last_name }}</a>
                            <div class="text-sm opacity-50">{{ $officer->user->username }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    {{ $officer->position }}
                </td>
                <td>{{ $officer->year }}-{{ ($officer->year + 1) % 100 }}</td>
                <th>
                    <a class="btn btn-ghost btn-xs" href="{{ route('admin.officers.show', ['officer' => $officer]) }}">Edit</a>
                </th>
            </tr>
            @endforeach
            <!-- foot -->
            <tfoot>
            <tr>
{{--                <th></th>--}}
                <th>Name</th>
                <th>Position</th>
                <th>Academic Year</th>
                <th></th>
            </tr>
            </tfoot>
        </table>
    </div>
    <input type="checkbox" id="addOfficerModal" class="modal-toggle"/>
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form method="POST" action="{{ route('admin.officers') }}"
                  enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="flex justify-between items-center pb-3 mb-4 border-b border-base-300">
                    <h3 class="font-bold text-xl" id="addOfficerModalLabel">Add Officer</h3>
                    <label for="addOfficerModal"
                           class="btn btn-sm btn-circle btn-ghost absolute right-3 top-3">✕</label>
                </div>

                <div class="space-y-4">
                    <div class="form-control w-full">
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">User</legend>
                            <input type="search" id="userSearch" name="user_id" class="input w-full @error('user_id') input-error @enderror" placeholder="Type the user's name or username" list="userList" autocomplete="off" />
                            <datalist id="userList"></datalist>
                        </fieldset>
                        @error('user_id')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                    <div class="form-control w-full">
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">Position</legend>
                            <input type="text" name="position" class="input w-full @error('position') input-error @enderror" placeholder="Position" />
                        </fieldset>
                        @error('position')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                    <div class="form-control w-full">
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">Year Elected</legend>
                            <input type="number" name="year" class="input w-full @error('year') input-error @enderror" placeholder="Year" min="1819" value="{{ now()->year }}" />
                        </fieldset>
                        @error('year')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                    <div class="form-control w-full">
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">Sort Order</legend>
                            <input type="number" name="sort_order" class="input w-full @error('sort_order') input-error @enderror" placeholder="Sort Order" min="0" value="0" />
                        </fieldset>
                        @error('sort_order')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                </div>

                <div class="modal-action mt-6">
                    <label for="addOfficerModal" class="btn btn-ghost">Cancel</label>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        <label class="modal-backdrop" for="addOfficerModal">Close</label>
    </div>
@endsection

@push('scripts')
    <script>
        (() => {
            const input   = document.getElementById('userSearch');
            const list    = document.getElementById('userList');
            let   timeout = null;

            input.addEventListener('input', () => {
                clearTimeout(timeout);
                const q = input.value.trim();
                if (!q) {
                    list.innerHTML = '';
                    return;
                }
                timeout = setTimeout(() => {
                    fetch(`/admin/search/user?q=${encodeURIComponent(q)}`)
                        .then(res => res.json())
                        .then(users => {
                            list.innerHTML = '';
                            users.forEach(user => {
                                // Assuming each user has a 'name' property; adjust as needed
                                const option = document.createElement('option');
                                option.value = user.username;
                                option.innerHTML = `${user.first_name} ${user.last_name} (${user.username})`;
                                list.appendChild(option);
                            });
                        })
                        .catch(err => {
                            console.error('User search error:', err);
                        });
                }, 100); // debounce by 100ms
            });
        })();
    </script>
@endpush
