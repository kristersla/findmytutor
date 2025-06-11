<?php

namespace App\Http\Controllers;

use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvailabilitySlotController extends Controller
{
    public function index()
    {
        $tutorProfile = Auth::user()->tutorProfile;

        $slots = $tutorProfile->availabilitySlots()->orderBy('day_of_week')->orderBy('start_time')->get();

        return view('availability.index', compact('slots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        Auth::user()->tutorProfile->availabilitySlots()->create($request->only('day_of_week', 'start_time', 'end_time'));

        return redirect()->back()->with('success', 'Slot added!');
    }

    public function destroy(AvailabilitySlot $availabilitySlot)
    {
        if ($availabilitySlot->tutorProfile->user_id !== Auth::id()) {
            abort(403);
        }

        $availabilitySlot->delete();

        return redirect()->back()->with('success', 'Slot deleted.');
    }
}
