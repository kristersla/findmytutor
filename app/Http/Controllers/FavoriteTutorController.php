<?php

namespace App\Http\Controllers;

use App\Models\TutorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteTutorController extends Controller
{
    public function store(TutorProfile $tutorProfile)
    {
        Auth::user()->favoriteTutors()->syncWithoutDetaching([$tutorProfile->id]);
        return back()->with('success', 'Tutor added to favorites!');
    }

    public function destroy(TutorProfile $tutorProfile)
    {
        Auth::user()->favoriteTutors()->detach($tutorProfile->id);
        return back()->with('success', 'Tutor removed from favorites.');
    }
}

