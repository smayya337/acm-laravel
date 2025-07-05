<!-- Edit Event Modal -->
<dialog id="editEventModal" class="modal not-prose">
    <div class="modal-box max-h-3/4 overflow-y-auto">
        <h3 class="font-bold text-lg mb-4">Edit Event</h3>
        <form method="POST" action="" id="editEventForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4 mb-4">
                <legend class="fieldset-legend">Event Details</legend>
                
                <label class="label">Event Name *</label>
                <input type="text" name="name" id="edit_name" class="input input-bordered" required>
                
                <label class="label">Location *</label>
                <input type="text" name="location" id="edit_location" class="input input-bordered" required>
                
                <label class="label">Description (Optional)</label>
                <textarea name="description" id="edit_description" class="textarea textarea-bordered" rows="3"></textarea>
            </fieldset>
            
            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4 mb-4">
                <legend class="fieldset-legend">Schedule</legend>
                
                <label class="label">Start Date & Time *</label>
                <input type="datetime-local" name="start" id="edit_start" class="input input-bordered" required>
                
                <label class="label">End Date & Time (Optional)</label>
                <input type="datetime-local" name="end" id="edit_end" class="input input-bordered">
            </fieldset>
            
            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4 mb-4">
                <legend class="fieldset-legend">Media</legend>
                
                <label class="label">Event Image (Optional)</label>
                <input type="file" name="image" class="file-input file-input-bordered" accept="image/*">
                <div class="label">
                    <span class="label-text-alt text-base-content/60">Maximum file size: @maxUploadSize</span>
                </div>
            </fieldset>
            
            <div class="modal-action">
                <button type="submit" class="btn btn-primary">Update Event</button>
                <button type="button" class="btn" onclick="document.getElementById('editEventModal').close()">Cancel</button>
            </div>
        </form>
    </div>
</dialog>

<script>
function editEvent(eventId) {
    // Fetch event data
    fetch(`/admin/events/${eventId}/edit`)
        .then(response => response.json())
        .then(data => {
            // Populate form fields
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_location').value = data.location;
            document.getElementById('edit_description').value = data.description || '';
            document.getElementById('edit_start').value = data.start;
            document.getElementById('edit_end').value = data.end || '';
            
            // Update form action
            document.getElementById('editEventForm').action = `/admin/events/${eventId}`;
            
            // Show modal
            document.getElementById('editEventModal').showModal();
        })
        .catch(error => {
            console.error('Error fetching event data:', error);
            alert('Error loading event data');
        });
}
</script> 