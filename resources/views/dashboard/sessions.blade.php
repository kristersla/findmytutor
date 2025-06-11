@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">My Sessions</h1>

    {{-- Sessions as Student --}}
    <h2>As Student</h2>
    @forelse ($studentSessions as $session)
        <div class="card mb-3 p-3">
            <p><strong>Tutor:</strong> {{ $session->tutorProfile->user->name ?? 'N/A' }}</p>
            <p><strong>Date/Time:</strong> {{ $session->datetime }}</p>
            <p><strong>Status:</strong> {{ ucfirst($session->status) }}</p>
            @if ($session->session_id && in_array($session->status, ['pending', 'approved']))
                <form action="{{ route('sessions.cancel', $session->session_id) }}" method="POST" class="d-inline">

                    @csrf
                    <button class="btn btn-warning btn-sm">Cancel</button>
                </form>
            @endif
        </div>
    @empty
        <p>No sessions booked as student.</p>
    @endforelse

    {{-- Sessions as Tutor --}}
    <h2 class="mt-5">As Tutor</h2>
    @forelse ($tutorSessions as $session)
        <div class="card mb-3 p-3">
            <p><strong>Student:</strong> {{ $session->student->name ?? 'N/A' }}</p>
            <p><strong>Date/Time:</strong> {{ $session->datetime }}</p>
            <p><strong>Status:</strong> {{ ucfirst($session->status) }}</p>
            @if ($session->status === 'pending')
                <form action="{{ route('sessions.approve', ['session' => $session->session_id]) }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-success btn-sm">Approve</button>
                </form>

                <form action="{{ route('sessions.reject', ['session' => $session->session_id]) }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-danger btn-sm">Reject</button>
                </form>
            @endif

            @if ($session->id && in_array($session->status, ['pending', 'approved']))
                <form action="{{ route('sessions.cancel', $session->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-warning btn-sm">Cancel</button>
                </form>
            @endif


        </div>
    @empty
        <p>No sessions booked as tutor.</p>
    @endforelse

</div>
@endsection
