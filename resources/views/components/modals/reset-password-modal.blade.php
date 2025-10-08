<!-- Reset Password Modal -->
<dialog id="resetPasswordModal" class="modal not-prose">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Reset Password for <span id="reset_user_name"></span></h3>
        <form method="POST" action="" id="resetPasswordForm">
            @csrf

            <label class="label">New Password *</label>
            <input type="password" name="password" id="reset_password" class="input input-bordered" required minlength="8">

            <label class="label">Confirm Password *</label>
            <input type="password" name="password_confirmation" id="reset_password_confirmation" class="input input-bordered" required minlength="8">

            <div class="label">
                <span class="label-text-alt text-base-content/60">Password must be at least 8 characters</span>
            </div>

            <div class="modal-action">
                <button type="submit" class="btn btn-primary">Reset Password</button>
                <button type="button" class="btn" onclick="document.getElementById('resetPasswordModal').close()">Cancel</button>
            </div>
        </form>
    </div>
</dialog>

<script>
function resetUserPassword(userId, userName) {
    // Set user name in modal
    document.getElementById('reset_user_name').textContent = userName;

    // Clear form fields
    document.getElementById('reset_password').value = '';
    document.getElementById('reset_password_confirmation').value = '';

    // Update form action
    document.getElementById('resetPasswordForm').action = `/admin/users/${userId}/reset-password`;

    // Show modal
    document.getElementById('resetPasswordModal').showModal();
}
</script>
