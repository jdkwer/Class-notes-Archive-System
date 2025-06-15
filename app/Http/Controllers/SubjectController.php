<?php
namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Validation\Rule; // Correct import for Rule

class SubjectController extends Controller
{
    // Ensure only authenticated users can access these methods
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the subjects for the authenticated user.
     * Includes basic search functionality.
     */
    public function index(Request $request)
    {
        $query = Subject::where('user_id', Auth::id()); // Filter by authenticated user

        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm);
            });
        }

        $subjects = $query->orderBy('name')->get();
        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new subject.
     */
    public function create()
    {
        return view('subjects.create');
    }

    /**
     * Store a newly created subject in storage.
     * user_id is automatically set by the model's booted method.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,NULL,id,user_id,' . Auth::id(),
            'description' => 'nullable|string',
        ]);

        Subject::create($request->all());

        return redirect()->route('subjects.index')
                         ->with('success', 'Subject created successfully.');
    }

    /**
     * Display the specified subject (and its notes) for the authenticated user.
     */
    public function show(Subject $subject)
    {
        // Ensure the subject belongs to the authenticated user
        if ($subject->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Eager load notes for the subject
        $subject->load(['notes' => function($query) {
            $query->orderBy('created_at', 'desc'); // Order notes by creation date
        }]);

        return view('subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified subject for the authenticated user.
     */
    public function edit(Subject $subject)
    {
        // Ensure the subject belongs to the authenticated user
        if ($subject->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('subjects.edit', compact('subject'));
    }

    /**
     * Update the specified subject in storage for the authenticated user.
     */
    public function update(Request $request, Subject $subject)
    {
        // Ensure the subject belongs to the authenticated user
        if ($subject->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id . ',id,user_id,' . Auth::id(), // Unique per user, excluding self
            'description' => 'nullable|string',
        ]);

        $subject->update($request->all());

        return redirect()->route('subjects.index')
                         ->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified subject from storage for the authenticated user.
     */
    public function destroy(Subject $subject)
    {
        // Ensure the subject belongs to the authenticated user
        if ($subject->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $subject->delete();

        return redirect()->route('subjects.index')
                         ->with('success', 'Subject deleted successfully.');
    }
}