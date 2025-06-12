@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-800">{{ $note->title }}</h1>
            <p class="text-gray-600 text-lg mt-2">Subject: <a href="{{ route('subjects.show', $note->subject->id) }}" class="text-blue-600 hover:underline">{{ $note->subject->name }}</a></p>
            <p class="text-gray-500 text-sm mt-1">
                Added: {{ $note->created_at->format('M d, Y H:i') }}
                @if ($note->updated_at != $note->created_at)
                    <br>Last Updated: {{ $note->updated_at->format('M d, Y H:i') }}
                @endif
            </p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('notes.edit', $note->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                Edit Note
            </a>
            <a href="{{ route('subjects.show', $note->subject->id) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                Back to Subject
            </a>
        </div>
    </div>

    <div class="prose max-w-none text-gray-700 leading-relaxed text-lg bg-gray-50 p-6 rounded-lg border border-gray-100 shadow-inner">
        <!-- Render content as plain text, or use a markdown parser if you install one (e.g., "Parsedown") -->
        <p>{!! nl2br(e($note->content)) !!}</p>
    </div>

    <div class="mt-8 flex justify-end">
        <form action="{{ route('notes.destroy', $note->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this note?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                Delete Note
            </button>
        </form>
    </div>
</div>
@endsection