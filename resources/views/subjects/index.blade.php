@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-4xl font-extrabold text-gray-800">Subjects</h1>
        <a href="{{ route('subjects.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
            Add New Subject
        </a>
    </div>

    @if($subjects->isEmpty())
        <p class="text-gray-600 text-center text-lg py-10">No subjects found. Start by adding a new one!</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($subjects as $subject)
                <div class="bg-white border border-blue-200 rounded-xl shadow-md p-6 flex flex-col justify-between transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-lg">
                    <div>
                        <h2 class="text-2xl font-bold text-blue-800 mb-2">{{ $subject->name }}</h2>
                        <p class="text-gray-600 mb-4">{{ $subject->description ?: 'No description provided.' }}</p>
                    </div>
                    <div class="flex flex-wrap gap-3 mt-4">
                        <a href="{{ route('subjects.show', $subject->id) }}" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md text-center text-sm shadow-sm transition duration-200 ease-in-out">
                            View Notes ({{ $subject->notes->count() }})
                        </a>
                        <a href="{{ route('subjects.edit', $subject->id) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-md text-center text-sm shadow-sm transition duration-200 ease-in-out">
                            Edit
                        </a>
                        <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subject and all its notes?');" class="flex-1">
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