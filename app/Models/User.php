<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get the notes for the user.
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Get the subjects for the user.
     */
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    /**
     * Update the user's profile picture.
     *
     * @param string $path
     * @return void
     */
    public function updateProfilePicture(string $path): void
    {
        $this->profile_picture = $path;
        $this->save();
    }

    /**
     * Change the user's password.
     *
     * @param string $newPassword
     * @return void
     */
    public function changePassword(string $newPassword): void
    {
        $this->password = bcrypt($newPassword);
        $this->save();
    }

    /**
     * Check if the user has admin role.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    /**
     * Mark the user's email as verified.
     *
     * @return void
     */
    public function markEmailAsVerified(): void
    {
        $this->email_verified_at = now();
        $this->save();
    }

    /**
     * Log user activity.
     *
     * @param string $activity
     * @return void
     */
    public function logActivity(string $activity): void
    {
        // This is a stub. Implement logging logic as needed.
        // For example, save to a user_activities table or external service.
    }
}
