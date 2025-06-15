<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function ($subject) {
            // Remove forced lowercase to allow user input case
            // if (isset($subject->name)) {
            //     $subject->name = Str::lower($subject->name);
            // }
            if (empty($subject->user_id)) {
                $subject->user_id = Auth::id();
            }
        });
    }

    // Define relationships, etc.

    /**
     * Get the notes for the subject.
     */
    public function notes()
    {
        return $this->hasMany(\App\Models\Note::class);
    }
}
