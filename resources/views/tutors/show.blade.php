@extends('layouts.app')
@php use Carbon\Carbon; @endphp

@section('content')
<style>
    .profile-wrapper {
        max-width: 800px;
        margin: auto;
        padding: 2rem 1rem;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    .card {
        background: #fff;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
    }

    .card h2 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.5rem;
    }

    .card p {
        margin: 0.3rem 0;
        color: #4b5563;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1rem;
    }

    .btn {
        display: inline-block;
        padding: 0.5rem 1.25rem;
        font-size: 0.9rem;
        font-weight: 600;
        border-radius: 8px;
        transition: 0.2s ease;
        text-align: center;
        white-space: nowrap;
    }

    .btn-success { background: #10b981; color: white; }
    .btn-success:hover { background: #059669; }

    .btn-warning { background: #f59e0b; color: white; }
    .btn-warning:hover { background: #d97706; }

    .btn-primary { background: #3b82f6; color: white; }
    .btn-primary:hover { background: #2563eb; }

    .btn-indigo { background: #6366f1; color: white; }
    .btn-indigo:hover { background: #4f46e5; }

    .input-field {
        width: 100%;
        padding: 0.6rem;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        margin-top: 0.3rem;
    }

    .review {
        background: #f9fafb;
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 1rem;
    }
</style>

<div class="profile-wrapper">
    <a href="{{ route('tutors.index') }}" class="text-blue-600 hover:underline">← Back to Tutor List</a>

    @if(session('success'))
        <div class="my-4 p-4 rounded bg-green-100 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <h2>{{ $tutor->user->name }}</h2>
        <p><strong>Location:</strong> {{ $tutor->location }}</p>
        <p><strong>Contact:</strong> {{ $tutor->contact_method }}</p>
        <p><strong>Subject:</strong> {{ $tutor->subject->name ?? '—' }}</p>
        <p><strong>Rate:</strong> €{{ $tutor->hourly_rate }}/hr</p>
        <p class="mt-3 text-gray-600">{{ $tutor->bio }}</p>

        @auth
        <div class="mt-4 flex gap-3 flex-wrap">
            @if(Auth::user()->favoriteTutors->contains($tutor->id))
                <form action="{{ route('tutors.unfavorite', $tutor->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-warning">Unfavorite</button>
                </form>
            @else
                <form action="{{ route('tutors.favorite', $tutor->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-success">Favorite</button>
                </form>
            @endif

            @if(Auth::id() !== $tutor->user->id)
                <a href="{{ route('messages.show', $tutor->user->id) }}" class="btn btn-primary">Message</a>
            @endif
        </div>
        @endauth
    </div>

    <div class="card">
        <h3 class="section-title">Reviews</h3>
        @forelse ($tutor->reviews as $review)
            <div class="review">
                <strong>{{ $review->user->name }}</strong> ⭐ {{ $review->rating }}/5
                <p class="mt-1 italic">{{ $review->comment }}</p>
            </div>
        @empty
            <p class="text-gray-500">No reviews yet.</p>
        @endforelse

        @auth
        @if (Auth::id() !== $tutor->user->id)
        <form action="{{ route('reviews.store', $tutor->id) }}" method="POST" class="mt-4">
            @csrf
            <label class="block mb-2">Rating</label>
            <select name="rating" class="input-field">
                @foreach ([1,2,3,4,5] as $star)
                    <option value="{{ $star }}">{{ $star }}</option>
                @endforeach
            </select>

            <label class="block mt-4 mb-2">Comment</label>
            <textarea name="comment" class="input-field"></textarea>

            <button type="submit" class="btn btn-primary mt-4">Submit Review</button>
        </form>
        @endif
        @endauth
    </div>

    <div class="card">
        <h3 class="section-title">Book a Session</h3>
        <form method="POST" action="{{ route('sessions.book', $tutor->id) }}">
            @csrf

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <label class="block mb-2">Available Time Slot</label>
            <select name="datetime" class="input-field" required>
                <option value="">Select a time slot</option>
                @foreach ($tutor->availabilitySlots as $slot)
                    @php
                        $dayNumber = Carbon::parse($slot->day_of_week)->dayOfWeekIso;
                        $date = Carbon::now()->startOfWeek()->addDays($dayNumber - 1);
                        $start = $date->copy()->setTimeFromTimeString($slot->start_time);
                        $end = $date->copy()->setTimeFromTimeString($slot->end_time);
                        if ($start->isPast()) { $start->addWeek(); $end->addWeek(); }
                    @endphp
                    <option value="{{ $start->format('Y-m-d\TH:i:s') }}">
                        {{ $slot->day_of_week }} — {{ $slot->start_time }} to {{ $slot->end_time }}
                    </option>
                @endforeach
            </select>

            <label class="block mt-4 mb-2">Notes</label>
            <textarea name="notes" class="input-field"></textarea>

            <button type="submit" class="btn btn-indigo mt-4">Book Session</button>
        </form>
    </div>
</div>
@endsection
