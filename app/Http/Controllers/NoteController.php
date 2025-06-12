<?php
// FILE: app/Http/Controllers/NoteController.php
// UPDATED: User authorization, basic search (within show)

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class NoteController extends Controller
{
    // Ensure only authenticated users can access these methods
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the notes (less used now, view via SubjectController@show primarily).
     */
    public function index()
    {
        $notes = Note::where('user_id', Auth::id())
                      ->with('subject')
                      ->orderBy('created_at', 'desc')
                      ->get();
        return view('notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new note.
     */
    public function create()
    {
        // Only show subjects belonging to the authenticated user
        $subjects = Subject::where('user_id', Auth::id())->orderBy('name')->get();
        return view('notes.create', compact('subjects'));
    }

    /**
     * Store a newly created note in storage.
     * user_id is automatically set by the model's booted method.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => [
                'required',
                'exists:subjects,id',
                // Custom rule to ensure the selected subject belongs to the current user
                function ($attribute, $value, $fail) {
                    if (!Subject::where('id', $value)->where('user_id', Auth::id())->exists()) {
                        $fail('The selected subject does not belong to you.');
                    }
                },
            ],
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Note::create($request->all());

        return redirect()->route('subjects.show', $request->subject_id)
                         ->with('success', 'Note created successfully.');
    }

    /**
     * Display the specified note for the authenticated user.
     */
    public function show(Note $note)
    {
        // Ensure the note belongs to the authenticated user
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified note for the authenticated user.
     */
    public function edit(Note $note)
    {
        // Ensure the note belongs to the authenticated user
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        // Only show subjects belonging to the authenticated user
        $subjects = Subject::where('user_id', Auth::id())->orderBy('name')->get();
        return view('notes.edit', compact('note', 'subjects'));
    }

    /**
     * Update the specified note in storage for the authenticated user.
     */
    public function update(Request $request, Note $note)
    {
        // Ensure the note belongs to the authenticated user
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'subject_id' => [
                'required',
                'exists:subjects,id',
                // Custom rule to ensure the selected subject belongs to the current user
                function ($attribute, $value, $fail) {
                    if (!Subject::where('id', $value)->where('user_id', Auth::id())->exists()) {
                        $fail('The selected subject does not belong to you.');
                    }
                },
            ],
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note->update($request->all());

        return redirect()->route('subjects.show', $note->subject_id)
                         ->with('success', 'Note updated successfully.');
    }

    /**
     * Remove the specified note from storage for the authenticated user.
     */
    public function destroy(Note $note)
    {
        // Ensure the note belongs to the authenticated user
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $subjectId = $note->subject_id;
        $note->delete();

        return redirect()->route('subjects.show', $subjectId)
                         ->with('success', 'Note deleted successfully.');
    }
}
