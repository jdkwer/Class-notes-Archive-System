@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-800">{{ $subject->name }} Notes</h1>
            @if($subject->description)
                <p class="text-gray-600 text-lg mt-2">{{ $subject->description }}</p>
            @endif
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('notes.create', ['subject_id' => $subject->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                Add New Note for {{ $subject->name }}
            </a>
            <a href="{{ route('subjects.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                Back to Subjects
            </a>
        </div>
    </div>

    @if($subject->notes->isEmpty())
        <p class="text-gray-600 text-center text-lg py-10">No notes found for this subject. Click "Add New Note" to get started!</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($subject->notes->sortByDesc('created_at') as $note)
                <div class="bg-white border border-green-200 rounded-xl shadow-md p-6 flex flex-col justify-between transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-lg">
                    <div>
                        <h2 class="text-2xl font-bold text-green-800 mb-2">{{ $note->title }}</h2>
                        <p class="text-gray-600 text-sm mb-3">
                            Added: {{ $note->created_at->format('M d, Y H:i') }}
                            @if ($note->updated_at != $note->created_at)
                                <br>Last Updated: {{ $note->updated_at->format('M d, Y H:i') }}
                            @endif
                        </p>
                        <div class="text-gray-700 text-base line-clamp-4">{{ $note->content }}</div>
                    </div>
                    <div class="flex flex-wrap gap-3 mt-4">
                        <a href="{{ route('notes.show', $note->id) }}" class="flex-1 bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md text-center text-sm shadow-sm transition duration-200 ease-in-out">
                            View Note
                        </a>
                        <a href="{{ route('notes.edit', $note->id) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-md text-center text-sm shadow-sm transition duration-200 ease-in-out">
                            Edit
                        </a>
                        <form action="{{ route('notes.destroy', $note->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this note?');" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-md text-center text-sm shadow-sm transition duration-200 ease-in-out">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection