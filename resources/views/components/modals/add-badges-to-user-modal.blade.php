<!-- Add Badges to User Modal -->
<dialog id="addBadgesToUserModal" class="modal not-prose">
    <div class="modal-box max-h-3/4 overflow-y-auto">
        <h3 class="font-bold text-lg mb-4">Add Badges to User</h3>
        <form method="POST" action="" id="addBadgesToUserForm">
            @csrf
            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4 mb-4">
                <legend class="fieldset-legend">Select Badges</legend>
                
                <div class="space-y-2 max-h-64 overflow-y-auto">
                    @foreach($badges as $badge)
                        <label class="label cursor-pointer justify-start gap-3">
                            <input type="checkbox" name="badge_ids[]" value="{{ $badge->id }}" class="checkbox">
                            <div class="flex items-center gap-2">
                                <x-badge :badge="$badge" />
                                @if($badge->description)
                                    <span class="text-sm opacity-70">{{ $badge->description }}</span>
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>
            </fieldset>
            
            <div class="modal-action">
                <button type="submit" class="btn btn-primary">Add Badges</button>
                <button type="button" class="btn" onclick="document.getElementById('addBadgesToUserModal').close()">Cancel</button>
            </div>
        </form>
    </div>
</dialog>

<script>
function addBadgesToUser(userId, userName) {
    // Update modal title with user name
    document.querySelector('#addBadgesToUserModal h3').textContent = `Add Badges to ${userName}`;
    
    // Update form action
    document.getElementById('addBadgesToUserForm').action = `/admin/users/${userId}/badges`;
    
    // Clear any previously selected checkboxes
    document.querySelectorAll('#addBadgesToUserForm input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = false;
    });
    
    // Show modal
    document.getElementById('addBadgesToUserModal').showModal();
}
</script> 