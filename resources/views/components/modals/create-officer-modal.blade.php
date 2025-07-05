<!-- Create Officer Modal -->
<dialog id="createOfficerModal" class="modal not-prose">
    <div class="modal-box max-h-3/4 overflow-y-auto">
        <h3 class="font-bold text-lg mb-4">Add New Officer</h3>
        <form method="POST" action="{{ route('admin.officers.store') }}">
            @csrf
            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4 mb-4">
                <legend class="fieldset-legend">Officer Information</legend>
                
                <label class="label">Position *</label>
                <input type="text" name="position" class="input input-bordered" required>
                
                <label class="label">Year Elected *</label>
                <input type="number" name="year" class="input input-bordered" value="{{ date('Y') }}" required>
                
                <label class="label">Sort Order (Optional)</label>
                <input type="number" name="sort_order" class="input input-bordered" value="0">
            </fieldset>
            

            
            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4 mb-4">
                <legend class="fieldset-legend">User Assignment</legend>
                
                <label class="label">User *</label>
                <select name="user_id" class="select select-bordered" required>
                    <option value="">Select User</option>
                    @foreach(\App\Models\User::where('hidden', false)->orderBy('first_name')->orderBy('last_name')->get() as $user)
                        <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }} ({{ $user->username }})</option>
                    @endforeach
                </select>
            </fieldset>
            
            <div class="modal-action">
                <button type="submit" class="btn btn-primary">Add Officer</button>
                <button type="button" class="btn" onclick="document.getElementById('createOfficerModal').close()">Cancel</button>
            </div>
        </form>
    </div>
</dialog> 