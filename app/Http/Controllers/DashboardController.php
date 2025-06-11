<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $studentSessions = $user->sessionsAsStudent()->latest()->get();
        $tutorSessions = $user->tutorProfile?->sessions()->latest()->get() ?? collect();
        $favoriteTutors = $user->favoriteTutors()->with('user')->get();

        return view('dashboard.index', compact('studentSessions', 'tutorSessions', 'favoriteTutors'));
    }
}

