@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 max-w-2xl mx-auto">
    <h1 class="text-4xl font-extrabold text-gray-800 mb-6 text-center">Edit Subject: <span class="text-blue-600">{{ $subject->name }}</span></h1>

    <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-5">
            <label for="name" class="block text-gray-700 text-lg font-semibold mb-2">Subject Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $subject->name) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-800 text-base shadow-sm" placeholder="e.g., Mathematics, History" required>
        </div>
        <div class="mb-6">
            <label for="description" class="block text-gray-700 text-lg font-semibold mb-2">Description (Optional):</label>
            <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-800 text-base shadow-sm" placeholder="A brief overview of the subject">{{ old('description', $subject->description) }}</textarea>
        </div>
        <div class="flex justify-end space-x-4">
            <a href="{{ route('subjects.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                Cancel
            </a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                Update Subject
            </button>
        </div>
    </form>
</div>
@endsection