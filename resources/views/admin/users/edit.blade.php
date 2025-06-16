@extends('layouts.app')

@section('content')
<div class="py-12 max-w-2xl mx-auto px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit User: {{ $user->name }}</h1>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white shadow rounded-lg p-6 mb-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="is_admin" class="block text-gray-700 font-semibold mb-2">Role</label>
            <select id="is_admin" name="is_admin" class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="0" {{ !$user->is_admin ? 'selected' : '' }}>User</option>
                <option value="1" {{ $user->is_admin ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
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
        <div class="flex space-x-4 items-center">
            <a href="{{ route('admin.users.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 transition duration-300 whitespace-nowrap">
                Cancel
            </a>
            <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition duration-300">
                Save
            </button>
        </div>
    </form>

    {{-- Separate form for Delete to prevent accidental submission with update --}}
    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
          onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');"
          class="inline-block mt-4"> {{-- Use inline-block to allow potential adjacent elements --}}
        @csrf
        @method('DELETE')
        <button type="submit"
                class="px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition duration-300">
            Delete User
        </button>
    </form>
</div>
@endsection
