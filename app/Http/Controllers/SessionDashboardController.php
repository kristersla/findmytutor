<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Session;

class SessionDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $studentSessions = $user->sessionsAsStudent()
            ->with('tutorProfile.user')
            ->latest()
            ->get();

        $tutorSessions = collect();

        if ($user->tutorProfile) {
            $tutorSessions = \App\Models\Session::where('tutor_profile_id', $user->tutorProfile->id)->with('student')->latest()->get();
        }

        return view('dashboard.sessions', compact('studentSessions', 'tutorSessions'));
    }
}
