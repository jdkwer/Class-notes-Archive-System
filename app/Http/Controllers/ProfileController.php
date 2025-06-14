<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the authenticated user's profile.
     */
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $rules = [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', Rule::unique('users')->ignore($user->id)],
            'profile_picture' => ['nullable', 'image', 'max:2048'], // max 2MB
        ];

        $validated = $request->validate($rules);

        $emailChanged = false;

        if (array_key_exists('name', $validated)) {
            $user->name = $validated['name'];
        }

        if (array_key_exists('email', $validated)) {
            if ($user->email !== $validated['email']) {
                $emailChanged = true;
            }
            $user->email = $validated['email'];
        }

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        if ($request->input('logout_after_update') === '1' && $emailChanged) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('success', 'Profile updated. Please log in again.');
        }

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}
