<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard with useful stats.
     */
    public function index()
    {
        // Get total number of users
        $userCount = User::count();

        // Pass data to the admin dashboard view
        return view('admin.dashboard', compact('userCount'));
    }
}
