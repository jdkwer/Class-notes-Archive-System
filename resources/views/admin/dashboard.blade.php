@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">
                Admin Dashboard
            </h1>
            <p class="text-gray-600 mb-12">
                Only users with admin privileges can access this page.
            </p>

            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-semibold text-blue-800 mb-2">Statistics</h2>
                    <p class="text-lg text-gray-600">Total Users: <span class="font-bold">{{ $userCount }}</span></p>
                </div>

                <a href="{{ route('admin.users.index') }}"
                   class="inline-block px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 transition duration-300">
                    Manage Users
                </a>
            </div>
        </div>
    </div>
</div>
@endsection