@extends('layouts.app')
@php use Carbon\Carbon; @endphp

@section('content')
    <a href="{{ route('tutors.index') }}" class="btn btn-secondary mb-3">← Back to list</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card p-4">
        <h2>{{ $tutor->user->name }}</h2>
        <p><strong>Location:</strong> {{ $tutor->location }}</p>
        <p><strong>Contact:</strong> {{ $tutor->contact_method }}</p>
        <p><strong>Bio:</strong> {{ $tutor->bio }}</p>
        <p><strong>Subject:</strong> {{ $tutor->subject->name ?? '—' }}</p>

        @auth
            @if(Auth::user()->favoriteTutors->contains($tutor->id))
                <form action="{{ route('tutors.unfavorite', $tutor->id) }}" method="POST" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-warning">Unfavorite</button>
                </form>
            @else
                <form action="{{ route('tutors.favorite', $tutor->id) }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="btn btn-success">Favorite</button>
                </form>
            @endif
        @endauth
        @auth
            @if(Auth::id() !== $tutor->user->id)
                <a href="{{ route('messages.show', $tutor->user->id) }}" class="btn btn-primary mt-2">
                    Message {{ $tutor->user->name }}
                </a>
            @endif
        @endauth

    </div>

    <hr>
    <h4>Reviews</h4>
    @forelse ($tutor->reviews as $review)
        <div class="border p-2 mb-2">
            <strong>{{ $review->user->name }}</strong> 
            ⭐ {{ $review->rating }}/5
            <br>
            <em>{{ $review->comment }}</em>
        </div>
    @empty
        <p>No reviews yet.</p>
    @endforelse
    @auth
        @if (Auth::id() !== $tutor->user->id)
            <hr>
            <h4>Leave a Review</h4>
            <form action="{{ route('reviews.store', $tutor->id) }}" method="POST">
                @csrf
                <div class="mb-2">
                    <label>Rating (1 to 5):</label>
                    <select name="rating" class="form-control" required>
                        @foreach ([1,2,3,4,5] as $star)
                            <option value="{{ $star }}">{{ $star }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-2">
                    <label>Comment (optional):</label>
                    <textarea name="comment" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        @endif
    @endauth


    <hr>
    <h4>Book a Session</h4>
    <form method="POST" action="{{ route('sessions.book', $tutor->id) }}">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-2">
            <label>Select Available Time Slot:</label>
            <select name="datetime" class="form-control" required>
                <option value="">Select a time slot</option>
                @foreach ($tutor->availabilitySlots as $slot)
                @php
                    $dayNumber = \Carbon\Carbon::parse($slot->day_of_week)->dayOfWeekIso;
                    $date = \Carbon\Carbon::now()->startOfWeek()->addDays($dayNumber - 1);
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

        <div class="mb-2">
            <label>Location:</label>
            <input type="text" name="location" class="form-control" value="Online" required>
        </div>

        <div class="mb-3">
            <label>Notes (optional):</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Book Session</button>
    </form>
@endsection
