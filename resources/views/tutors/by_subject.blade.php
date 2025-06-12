@extends('layouts.app')

@section('content')
<style>
   
    .tutor-list-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px 15px;
    }

    .tutor-list-container h2 {
        color: #1d4ed8;
        font-size: 20px;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-weight: bold;
        margin-bottom: 30px;
    }
    .tutor-card {
        display: flex;
        align-items: center;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 15px 20px;
        margin-bottom: 20px;
        transition: transform 0.2s ease;
    }

    .tutor-card:hover {
        transform: translateY(-3px);
    }

    .tutor-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 20px;
        background-color:rgb(243, 243, 243);
    }

    .tutor-info {
        flex: 1;
    }

    .tutor-info h5 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .tutor-info p {
        margin: 5px 0;
        color: #555;
    }

    .tutor-actions a {
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        color: #1d4ed8;
        margin-left: 10px;
    }
</style>

<div class="tutor-list-container">
    <h2 class="mb-4 text-center">{{ ucfirst($subject->name) }}</h2>

    @if ($tutors->isEmpty())
        <p class="text-center text-muted">No tutors found for this subject.</p>
    @else
        @foreach ($tutors as $tutor)
            <div class="tutor-card">
                <img src="{{ asset('images/user-icon.svg') }}" alt="Avatar" class="tutor-avatar">
                <div class="tutor-info">
                    <h5>{{ $tutor->user->name }}</h5>
                    <p>{{ Str::limit($tutor->bio, 80) }}</p>
                    <p><strong>Rate:</strong> €{{ $tutor->hourly_rate }}</p>
                </div>
                <div class="tutor-actions">
                    <a href="{{ route('tutors.show', $tutor->id) }}" class="btn btn-outline-primary btn-sm">View Profile</a>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
