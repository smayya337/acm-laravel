<!-- Remove Badges from User Modal -->
<dialog id="removeBadgesFromUserModal" class="modal not-prose">
    <div class="modal-box max-h-3/4 overflow-y-auto">
        <h3 class="font-bold text-lg mb-4">Remove Badges from User</h3>
        <form method="POST" action="" id="removeBadgesFromUserForm">
            @csrf
            @method('DELETE')
            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4 mb-4">
                <legend class="fieldset-legend">Select Badges to Remove</legend>
                
                <div id="userBadgesList" class="space-y-2 max-h-64 overflow-y-auto">
                    <!-- Badges will be populated dynamically -->
                </div>
            </fieldset>
            
            <div class="modal-action">
                <button type="submit" class="btn btn-error">Remove Badges</button>
                <button type="button" class="btn" onclick="document.getElementById('removeBadgesFromUserModal').close()">Cancel</button>
            </div>
        </form>
    </div>
</dialog>

<script>
function removeBadgesFromUser(userId, userName) {
    // Update modal title with user name
    document.querySelector('#removeBadgesFromUserModal h3').textContent = `Remove Badges from ${userName}`;
    
    // Update form action
    document.getElementById('removeBadgesFromUserForm').action = `/admin/users/${userId}/badges`;
    
    // Fetch user's badges
    fetch(`/admin/users/${userId}/badges`)
        .then(response => response.json())
        .then(data => {
            const badgesList = document.getElementById('userBadgesList');
            badgesList.innerHTML = '';
            
            if (data.badges.length === 0) {
                badgesList.innerHTML = '<p class="text-center opacity-70">This user has no badges to remove.</p>';
                return;
            }
            
            data.badges.forEach(badge => {
                const label = document.createElement('label');
                label.className = 'label cursor-pointer justify-start gap-3';
                label.innerHTML = `
                    <input type="checkbox" name="badge_ids[]" value="${badge.id}" class="checkbox">
                    <div class="flex items-center gap-2">
                        <span class="badge badge-${badge.color} hover:badge-${badge.color}-800">${badge.name}</span>
                        ${badge.description ? `<span class="text-sm opacity-70">${badge.description}</span>` : ''}
                    </div>
                `;
                badgesList.appendChild(label);
            });
        })
        .catch(error => {
            console.error('Error fetching user badges:', error);
            alert('Error loading user badges');
        });
    
    // Show modal
    document.getElementById('removeBadgesFromUserModal').showModal();
}
</script> 