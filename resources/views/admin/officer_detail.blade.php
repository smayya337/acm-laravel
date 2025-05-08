@extends('app')

@section('content')
    <h1>Edit Officer</h1>
    <a class="btn btn-primary mb-2" href="{{ route('admin.officers') }}">Back</a>
    <form method="POST" action="{{ route('admin.officers.update', ['officer' => $officer]) }}"
          enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="space-y-4">
            <div class="form-control w-full">
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">User</legend>
                    <input type="search" id="userSearch" name="user_id" class="input w-full @error('user_id') input-error @enderror" placeholder="Type the user's name or username" list="userList" autocomplete="off" value="{{ old('user_id', $officer->user->username) }}" />
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
                    <input type="text" name="position" class="input w-full @error('position') input-error @enderror" placeholder="Position" value="{{ old('position', $officer->position) }}" />
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
                    <input type="number" name="year" class="input w-full @error('year') input-error @enderror" placeholder="Year" min="1819" value="{{ old('year', $officer->year) }}" />
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
                    <input type="number" name="sort_order" class="input w-full @error('sort_order') input-error @enderror" placeholder="Sort Order" min="0" value="{{ old('sort_order', $officer->sort_order) }}" />
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
    <label class="btn btn-error mt-2" for="deleteOfficerModal">Delete this officer</label>
    <input type="checkbox" id="deleteOfficerModal" class="modal-toggle"/>
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form method="POST" action="{{ route('admin.officers.delete', ['officer' => $officer]) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="flex justify-between items-center pb-3 mb-4 border-b border-base-300">
                    <h3 class="font-bold text-xl" id="deleteOfficerModalLabel">Are you sure you want to delete?</h3>
                    <label for="addOfficerModal"
                           class="btn btn-sm btn-circle btn-ghost absolute right-3 top-3">✕</label>
                </div>

                <div class="modal-action mt-6">
                    <label for="deleteOfficerModal" class="btn btn-ghost">Cancel</label>
                    <button type="submit" class="btn btn-error">Delete</button>
                </div>
            </form>
        </div>
        <label class="modal-backdrop" for="deleteOfficerModal">Close</label>
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
