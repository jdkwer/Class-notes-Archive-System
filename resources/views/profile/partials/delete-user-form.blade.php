<form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirmDelete()">
    @csrf
    @method('DELETE')

    <div class="mb-4">
        <label for="delete_reason" class="block text-gray-700 font-semibold mb-2">Why do you want to delete your account?</label>
        <textarea id="delete_reason" name="delete_reason" rows="3" class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required></textarea>
    </div>

    <div class="mb-4">
        <label for="password" class="block text-gray-700 font-semibold mb-2">Confirm Password</label>
        <input id="password" name="password" type="password" required class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" />
    </div>

    <div class="mt-6 flex justify-end">
        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition duration-300">
            Delete Account
        </button>
    </div>
</form>

<script>
    function confirmDelete() {
        const reason = document.getElementById('delete_reason').value.trim();
        if (!reason) {
            alert('Please provide a reason for deleting your account.');
            return false;
        }
        const password = document.getElementById('password').value.trim();
        if (!password) {
            alert('Please enter your password to confirm account deletion.');
            return false;
        }
        return confirm('Are you sure you want to delete your account? This action cannot be undone.');
    }
</script>
