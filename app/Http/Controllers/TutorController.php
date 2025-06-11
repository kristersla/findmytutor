<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TutorProfile;
use App\Models\Subject;

class TutorController extends Controller
{
    public function index(Request $request)
    {
        $query = TutorProfile::with('user', 'subject');

        // Apply search filters
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('subject')) {
            $query->whereHas('subject', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->subject . '%');
            });
        }

        if ($request->filled('name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        $tutors = $query->paginate(10);
        $subjects = Subject::all();

        return view('tutors.index', compact('tutors', 'subjects'));
    }

    public function show($id)
    {
        $tutor = TutorProfile::with(['user', 'subject', 'reviews.user'])->findOrFail($id);
        return view('tutors.show', compact('tutor'));
    }

    public function create()
    {
        $subjects = \App\Models\Subject::all();
        return view('tutors.become', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bio' => 'required|string|max:1000',
            'hourly_rate' => 'required|numeric|min:0',
            'subject_name' => 'required|string|max:255',
        ]);

        $subject = \App\Models\Subject::firstOrCreate(['name' => $request->subject_name]);

        \App\Models\TutorProfile::create([
            'user_id' => auth()->id(),
            'bio' => $request->bio,
            'hourly_rate' => $request->hourly_rate,
            'location' => $request->location,
            'contact_method' => $request->contact_method,
            'subject_id' => $subject->id,
        ]);


        return redirect()->route('availability.index')->with('success', 'Tutor profile created! Now add your available time slots.');
    }



}

