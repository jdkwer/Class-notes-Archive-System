@extends('layouts.app')

@section('content')
<div class="py-12 max-w-2xl mx-auto px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Profile</h1>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6 mb-6">
        @csrf
        @method('PATCH')

        <input type="hidden" name="logout_after_update" id="logout_after_update" value="0" />

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}"
                   class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                   class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

        <div class="mb-4 flex flex-col items-center">
            <label for="profile_picture" class="block text-gray-700 font-semibold mb-2">Profile Picture</label>
            @if ($user->profile_picture)
                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="mb-2 w-32 h-32 object-cover rounded-full">
            @else
                <div class="mb-2 w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center text-gray-500">
                    No Image
                </div>
            @endif
            <label for="profile_picture" class="cursor-pointer text-indigo-600 hover:text-indigo-800 transition duration-300">
                Change Profile Picture
            </label>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="hidden" />
        </div>

        <button type="submit"
                class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition duration-300">
            Save
        </button>
    </form>

    <script>
        document.getElementById('profileForm').addEventListener('submit', function(event) {
            event.preventDefault();
            if (confirm('Do you want to log out to proceed with the changes if you change your email?')) {
                document.getElementById('logout_after_update').value = '1';
            } else {
                document.getElementById('logout_after_update').value = '0';
            }
            this.submit();
        });
    </script>
</div>
@endsection
