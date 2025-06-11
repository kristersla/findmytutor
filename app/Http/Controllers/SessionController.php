<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\TutorProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class SessionController extends Controller
{
    public function book(Request $request, TutorProfile $tutor)
    {
        $validated = $request->validate([
            'datetime' => 'required|date|after:now',
            'location' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Check for bad words using Neutrino API
        if (!empty($validated['notes']) && $this->containsProfanity($validated['notes'])) {
            return back()->withErrors(['notes' => 'Please remove inappropriate language from your notes.'])->withInput();
        }

        Session::create([
            'tutor_profile_id' => $tutor->id,
            'student_user_id' => Auth::id(),
            'datetime' => $validated['datetime'],
            'status' => 'pending',
            'location' => $validated['location'],
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('tutors.show', $tutor->id)->with('success', 'Session booked successfully!');
    }
    
    public function approve(Session $session)
    {
        $session->update(['status' => 'approved']);
        return redirect()->route('sessions.dashboard')->with('success', 'Session approved.');
    }

    public function reject(Session $session)
    {
        $session->update(['status' => 'rejected']);
        return redirect()->route('sessions.dashboard')->with('success', 'Session rejected.');
    }

    public function cancel(Session $session)
    {
        $session->update(['status' => 'canceled']);
        return redirect()->route('sessions.dashboard')->with('success', 'Session canceled.');
    }

    private function containsProfanity($text)
    {
        $response = Http::asForm()->post('https://neutrinoapi.net/bad-word-filter', [
            'user-id' => env('NEUTRINO_USER_ID'),
            'api-key' => env('NEUTRINO_API_KEY'),
            'content' => $text,
            'censor-character' => '*',
        ]);

        $data = $response->json();

        return $data['is-bad'] ?? false;
    }


}
