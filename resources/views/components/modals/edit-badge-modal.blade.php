<!-- Edit Badge Modal -->
<dialog id="editBadgeModal" class="modal not-prose">
    <div class="modal-box max-h-3/4 overflow-y-auto">
        <h3 class="font-bold text-lg mb-4">Edit Badge</h3>
        <form method="POST" action="" id="editBadgeForm">
            @csrf
            @method('PUT')
            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4 mb-4">
                <legend class="fieldset-legend">Badge Information</legend>
                
                <label class="label">Badge Name *</label>
                <input type="text" name="name" id="edit_name" class="input input-bordered" required>
                
                <label class="label">Description (Optional)</label>
                <textarea name="description" id="edit_description" class="textarea textarea-bordered" rows="3"></textarea>
            </fieldset>
            
            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4 mb-4">
                <legend class="fieldset-legend">Appearance</legend>
                
                <label class="label">Color *</label>
                <select name="color" id="edit_color" class="select select-bordered" required>
                    <option value="red">Red</option>
                    <option value="yellow">Yellow</option>
                    <option value="green">Green</option>
                    <option value="blue">Blue</option>
                    <option value="gray">Gray</option>
                </select>
            </fieldset>
            
            <div class="modal-action">
                <button type="submit" class="btn btn-primary">Update Badge</button>
                <button type="button" class="btn" onclick="document.getElementById('editBadgeModal').close()">Cancel</button>
            </div>
        </form>
    </div>
</dialog>

<script>
function editBadge(badgeId) {
    // Fetch badge data
    fetch(`/admin/badges/${badgeId}/edit`)
        .then(response => response.json())
        .then(data => {
            // Populate form fields
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_description').value = data.description || '';
            document.getElementById('edit_color').value = data.color;
            
            // Update form action
            document.getElementById('editBadgeForm').action = `/admin/badges/${badgeId}`;
            
            // Show modal
            document.getElementById('editBadgeModal').showModal();
        })
        .catch(error => {
            console.error('Error fetching badge data:', error);
            alert('Error loading badge data');
        });
}
</script> 