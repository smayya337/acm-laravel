<!-- Create Badge Modal -->
<dialog id="createBadgeModal" class="modal not-prose">
    <div class="modal-box max-h-3/4 overflow-y-auto">
        <h3 class="font-bold text-lg mb-4">Create New Badge</h3>
        <form method="POST" action="{{ route('admin.badges.store') }}">
            @csrf
            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4 mb-4">
                <legend class="fieldset-legend">Badge Information</legend>
                
                <label class="label">Badge Name *</label>
                <input type="text" name="name" class="input input-bordered" required>
                
                <label class="label">Description (Optional)</label>
                <textarea name="description" class="textarea textarea-bordered" rows="3"></textarea>
            </fieldset>
            
            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4 mb-4">
                <legend class="fieldset-legend">Appearance</legend>
                
                <label class="label">Color *</label>
                <select name="color" class="select select-bordered" required>
                    <option value="red">Red</option>
                    <option value="yellow">Yellow</option>
                    <option value="green">Green</option>
                    <option value="blue">Blue</option>
                    <option value="gray">Gray</option>
                </select>
            </fieldset>
            
            <div class="modal-action">
                <button type="submit" class="btn btn-primary">Create Badge</button>
                <button type="button" class="btn" onclick="document.getElementById('createBadgeModal').close()">Cancel</button>
            </div>
        </form>
    </div>
</dialog> 