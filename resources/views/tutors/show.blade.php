@extends('layouts.app')
@php use Carbon\Carbon; @endphp

@section('content')
<style>
    .profile-card {
        background: #ffffff;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1rem;
    }
    .btn-custom {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        color: white;
        text-align: center;
        transition: background 0.3s;
    }
    .btn-success { background-color: #10b981; }
    .btn-success:hover { background-color: #059669; }
    .btn-warning { background-color: #f59e0b; }
    .btn-warning:hover { background-color: #d97706; }
    .btn-primary { background-color: #3b82f6; }
    .btn-primary:hover { background-color: #2563eb; }
    .btn-indigo { background-color: #6366f1; }
    .btn-indigo:hover { background-color: #4f46e5; }
    .alert-box {
        background-color: #d1fae5;
        color: #065f46;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }
    .input-control {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        margin-top: 0.25rem;
    }
    .review-box {
        background-color: #f3f4f6;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }
</style>

<div class="container mx-auto px-4 py-6">
    <a href="{{ route('tutors.index') }}" class="text-blue-600 hover:underline mb-4 inline-block">← Back to Tutor List</a>

    @if(session('success'))
        <div class="alert-box">
            {{ session('success') }}
        </div>
    @endif

    <div class="profile-card">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $tutor->user->name }}</h2>
        <p><strong>Location:</strong> {{ $tutor->location }}</p>
        <p><strong>Contact:</strong> {{ $tutor->contact_method }}</p>
        <p><strong>Bio:</strong> {{ $tutor->bio }}</p>
        <p><strong>Subject:</strong> {{ $tutor->subject->name ?? '—' }}</p>
        <br>
        <p><strong>Hourly Rate:</strong> €{{ $tutor->hourly_rate }}</p>
        @auth
            <div class="flex gap-3 mt-4 flex-wrap">
                @if(Auth::user()->favoriteTutors->contains($tutor->id))
                    <form action="{{ route('tutors.unfavorite', $tutor->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn-custom btn-warning">Unfavorite</button>
                    </form>
                @else
                    <form action="{{ route('tutors.favorite', $tutor->id) }}" method="POST">
                        @csrf
                        <button class="btn-custom btn-success">Favorite</button>
                    </form>
                @endif

                @if(Auth::id() !== $tutor->user->id)
                    <a href="{{ route('messages.show', $tutor->user->id) }}" class="btn-custom btn-primary">
                        Message {{ $tutor->user->name }}
                    </a>
                @endif
            </div>
        @endauth
    </div>

    <div class="mt-10">
        <h3 class="section-title">Reviews</h3>
        @forelse ($tutor->reviews as $review)
            <div class="review-box">
                <strong>{{ $review->user->name }}</strong> ⭐ {{ $review->rating }}/5
                <p class="italic mt-1">{{ $review->comment }}</p>
            </div>
        @empty
            <p class="text-gray-500">No reviews yet.</p>
        @endforelse

        @auth
            @if (Auth::id() !== $tutor->user->id)
                <div class="mt-6">
                    <h4 class="section-title">Leave a Review</h4>
                    <form action="{{ route('reviews.store', $tutor->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Rating (1 to 5):</label>
                            <select name="rating" class="input-control">
                                @foreach ([1,2,3,4,5] as $star)
                                    <option value="{{ $star }}">{{ $star }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Comment (optional):</label>
                            <textarea name="comment" class="input-control"></textarea>
                        </div>

                        <button type="submit" class="btn-custom btn-primary">Submit Review</button>
                    </form>
                </div>
            @endif
        @endauth
    </div>

    <div class="mt-10">
        <h3 class="section-title">Book a Session</h3>
        <form method="POST" action="{{ route('sessions.book', $tutor->id) }}">
            @csrf
            @if ($errors->any())
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label>Select Available Time Slot:</label>
                <select name="datetime" class="input-control" required>
                    <option value="">Select a time slot</option>
                    @foreach ($tutor->availabilitySlots as $slot)
                        @php
                            $dayNumber = Carbon::parse($slot->day_of_week)->dayOfWeekIso;
                            $date = Carbon::now()->startOfWeek()->addDays($dayNumber - 1);
                            $start = $date->copy()->setTimeFromTimeString($slot->start_time);
                            $end = $date->copy()->setTimeFromTimeString($slot->end_time);

                            if ($start->isPast()) {
                                $start->addWeek();
                                $end->addWeek();
                            }
                        @endphp
                        <option value="{{ $start->format('Y-m-d\TH:i:s') }}">
                            {{ $slot->day_of_week }} — {{ $slot->start_time }} to {{ $slot->end_time }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label>Notes (optional):</label>
                <textarea name="notes" class="input-control"></textarea>
            </div>

            <button type="submit" class="btn-custom btn-indigo">Book Session</button>
        </form>
    </div>
</div>
@endsection
