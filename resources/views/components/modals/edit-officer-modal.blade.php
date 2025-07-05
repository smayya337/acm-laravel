<!-- Edit Officer Modal -->
<dialog id="editOfficerModal" class="modal not-prose">
    <div class="modal-box max-h-3/4 overflow-y-auto">
        <h3 class="font-bold text-lg mb-4">Edit Officer</h3>
        <form method="POST" action="" id="editOfficerForm">
            @csrf
            @method('PUT')
            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4 mb-4">
                <legend class="fieldset-legend">Officer Information</legend>
                
                <label class="label">Position *</label>
                <input type="text" name="position" id="edit_position" class="input input-bordered" required>
                
                <label class="label">Year Elected *</label>
                <input type="number" name="year" id="edit_year" class="input input-bordered" required>
                
                <label class="label">Sort Order (Optional)</label>
                <input type="number" name="sort_order" id="edit_sort_order" class="input input-bordered" value="0">
            </fieldset>
            
            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4 mb-4">
                <legend class="fieldset-legend">User Assignment</legend>
                
                <label class="label">User *</label>
                <select name="user_id" id="edit_user_id" class="select select-bordered" required>
                    <option value="">Select User</option>
                    @foreach(\App\Models\User::where('hidden', false)->orderBy('first_name')->orderBy('last_name')->get() as $user)
                        <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }} ({{ $user->username }})</option>
                    @endforeach
                </select>
            </fieldset>
            
            <div class="modal-action">
                <button type="submit" class="btn btn-primary">Update Officer</button>
                <button type="button" class="btn" onclick="document.getElementById('editOfficerModal').close()">Cancel</button>
            </div>
        </form>
    </div>
</dialog>

<script>
function editOfficer(officerId) {
    // Fetch officer data
    fetch(`/admin/officers/${officerId}/edit`)
        .then(response => response.json())
        .then(data => {
            // Populate form fields
            document.getElementById('edit_position').value = data.position;
            document.getElementById('edit_year').value = data.year;
            document.getElementById('edit_sort_order').value = data.sort_order;
            document.getElementById('edit_user_id').value = data.user_id;
            
            // Update form action
            document.getElementById('editOfficerForm').action = `/admin/officers/${officerId}`;
            
            // Show modal
            document.getElementById('editOfficerModal').showModal();
        })
        .catch(error => {
            console.error('Error fetching officer data:', error);
            alert('Error loading officer data');
        });
}
</script> 