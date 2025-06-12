@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-4">Admin Dashboard</h1>
    <p>Welcome to the admin dashboard. Only users with admin privileges can access this page.</p>

    <div class="mt-6">
        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            Manage Users
        </a>
    </div>
</div>
@endsection
