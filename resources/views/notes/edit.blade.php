@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 max-w-3xl mx-auto">
    <h1 class="text-4xl font-extrabold text-gray-800 mb-6 text-center">Edit Note: <span class="text-green-600">{{ $note->title }}</span></h1>

    <form action="{{ route('notes.update', $note->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-5">
            <label for="subject_id" class="block text-gray-700 text-lg font-semibold mb-2">Select Subject:</label>
            <select name="subject_id" id="subject_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-800 text-base shadow-sm" required>
                <option value="">-- Choose Subject --</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ (old('subject_id', $note->subject_id) == $subject->id) ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-5">
            <label for="title" class="block text-gray-700 text-lg font-semibold mb-2">Note Title:</label>
            <input type="text" name="title" id="title" value="{{ old('title', $note->title) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-800 text-base shadow-sm" placeholder="e.g., Lecture 1 Summary, Homework Solutions" required>
        </div>
        <div class="mb-6">
            <label for="content" class="block text-gray-700 text-lg font-semibold mb-2">Note Content:</label>
            <textarea name="content" id="content" rows="10" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-800 text-base shadow-sm" placeholder="Write your note content here..." required>{{ old('content', $note->content) }}</textarea>
        </div>
        <div class="flex justify-end space-x-4">
            <a href="{{ route('subjects.show', $note->subject_id) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                Cancel
            </a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                Update Note
            </button>
        </div>
    </form>
</div>
@endsection