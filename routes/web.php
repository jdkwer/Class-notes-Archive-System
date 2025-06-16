<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\NoteController;

use App\Http\Middleware\AdminMiddleware;

use Illuminate\Support\Facades\Auth;

Route::get('/dashboard', function () {
    if (Auth::user() && Auth::user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('subjects.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    return redirect()->route('subjects.index');
})->middleware(['auth']); // Added auth middleware

// Group all our application routes under the 'auth' middleware
Route::middleware(['auth'])->group(function () {
    // Resource routes for Subjects (handles index, create, store, show, edit, update, destroy)
    Route::resource('subjects', SubjectController::class);

    // Resource routes for Notes
    Route::resource('notes', NoteController::class);
});

use App\Http\Controllers\AdminUserController;

// Admin routes protected by auth and admin middleware
use App\Http\Controllers\AdminDashboardController;

Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Admin user management routes
    Route::resource('users', AdminUserController::class)->except(['show', 'create', 'store']);
});

require __DIR__.'/auth.php';
