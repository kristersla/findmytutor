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
        $subjects = Subject::whereHas('tutorProfiles')->get();

        return view('tutors.index', compact('tutors', 'subjects'));
    }

    public function show($id)
    {
        $tutor = TutorProfile::with(['user', 'subject', 'reviews.user'])->findOrFail($id);
        return view('tutors.show', compact('tutor'));
    }

    public function create()
    {
        $subjects = Subject::all();
        return view('tutors.become', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bio' => 'required|string|max:1000',
            'hourly_rate' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'contact_method' => 'required|string|max:255',
            'subject_name' => 'required|string|max:255',
        ]);

        $subject = Subject::firstOrCreate(['name' => $request->subject_name]);

        TutorProfile::create([
            'user_id' => auth()->id(),
            'bio' => $request->bio,
            'hourly_rate' => $request->hourly_rate,
            'location' => $request->location,
            'contact_method' => $request->contact_method,
            'subject_id' => $subject->id,
        ]);

        return redirect()->route('availability.index')->with('success', 'Tutor profile created! Now add your available time slots.');
    }


    public function showBySubject($subjectName)
    {
        $subject = Subject::where('name', $subjectName)->firstOrFail();

        $tutors = TutorProfile::where('subject_id', $subject->id)
            ->with('user')
            ->get();

        return view('tutors.by_subject', compact('subject', 'tutors'));
    }

    public function updateTutorInfo(Request $request)
    {
        $request->validate([
            'bio' => 'nullable|string|max:1000',
            'hourly_rate' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'contact_method' => 'nullable|string|max:255',
            'subject_name' => 'nullable|string|max:255',
        ]);

        $tutor = \App\Models\TutorProfile::where('user_id', auth()->id())->firstOrFail();

        if ($request->filled('subject_name')) {
            $subject = \App\Models\Subject::firstOrCreate(['name' => $request->subject_name]);
            $tutor->subject_id = $subject->id;
        }

        $tutor->update($request->only('bio', 'hourly_rate', 'location', 'contact_method'));

        return redirect()->back()->with('success', 'Tutor profile updated successfully.');
    }

}
