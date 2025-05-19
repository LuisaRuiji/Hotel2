<section class="space-y-6" id="delete-account">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    @error('account')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
    @enderror

    <!-- Simple button that opens the form directly -->
    <button type="button" class="btn btn-danger" onclick="toggleDeleteForm()">
        {{ __('Delete Account') }}
    </button>

    <!-- Hidden Delete Form -->
    <div id="deleteFormContainer" style="display: none; margin-top: 20px; padding: 20px; border: 1px solid #f5c2c7; border-radius: 5px; background-color: #fff1f2;">
        <form id="deleteAccountForm" method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')
            
            <h5 class="mb-3 text-danger">{{ __('Are you sure you want to delete your account?') }}</h5>
            
            <p class="mb-4">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.') }}</p>
            
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" name="password" type="password" class="form-control" required autofocus>
                @error('password', 'userDeletion')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-end mt-4">
                <button type="button" class="btn btn-secondary me-2" onclick="toggleDeleteForm()">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
            </div>
        </form>
    </div>

    <script>
        function toggleDeleteForm() {
            const container = document.getElementById('deleteFormContainer');
            if (container.style.display === 'none') {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
                // Clear password field when hiding the form
                document.getElementById('password').value = '';
            }
        }
    </script>
</section>
