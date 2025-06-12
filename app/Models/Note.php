<?php
// FILE: app/Models/Note.php
// UPDATED: Added user_id and user relationship

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class Note extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', // Add user_id
        'subject_id',
        'title',
        'content',
    ];

    /**
     * The "booted" method of the model.
     * Ensure new notes are always created with the current user's ID.
     */
    protected static function booted()
    {
        // When creating a note, automatically set the user_id
        static::creating(function ($note) {
            if (Auth::check()) { // Only set if a user is logged in
                $note->user_id = Auth::id();
            }
        });
    }

    /**
     * Get the subject that owns the note.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the user that owns the note.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}