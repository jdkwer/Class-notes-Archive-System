<?php
// FILE: app/Models/Subject.php
// UPDATED: Added user_id and user relationship

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class Subject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', // Add user_id
        'name',
        'description',
    ];

    /**
     * The "booted" method of the model.
     * Ensure new subjects are always created with the current user's ID.
     */
    protected static function booted()
    {
        // When creating a subject, automatically set the user_id
        static::creating(function ($subject) {
            if (Auth::check()) { // Only set if a user is logged in
                $subject->user_id = Auth::id();
            }
        });
    }

    /**
     * Get the notes for the subject.
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Get the user that owns the subject.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}