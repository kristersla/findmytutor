<x-app-layout>
    <div class="dashboard-wrapper">
        <div class="dashboard-header">
            <h1>Welcome back, {{ Auth::user()->name }} 👋</h1>
            <p>Your personalized dashboard overview.</p>
        </div>

        <div class="summary-cards">
            <div class="card">
                <h3>Favorites</h3>
                <p>{{ $favoriteTutors->count() }}</p>
            </div>
            <div class="card">
                <h3>Student Sessions</h3>
                <p>{{ $studentSessions->count() }}</p>
            </div>
            <div class="card">
                <h3>Tutor Sessions</h3>
                <p>{{ $tutorSessions->count() }}</p>
            </div>
        </div>

        <hr class="divider">

        <section class="section">
            <h2>My Favorite Tutors</h2>
            @if($favoriteTutors->isEmpty())
                <p class="text-muted">You haven't favorited any tutors yet.</p>
            @else
                <div class="card-grid">
                    @foreach($favoriteTutors as $tutor)
                        <div class="card">
                            <h3>{{ $tutor->user->name }}</h3>
                            <p>{{ $tutor->bio }}</p>
                            <a href="{{ route('tutors.show', $tutor->id) }}" class="btn-primary">View Profile</a>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="section">
            <h2>My Sessions</h2>

            <div class="session-group">
                <h3>As Student</h3>
                @forelse ($studentSessions as $session)
                    <div class="card session-card">
                        <p><strong>Tutor:</strong> {{ $session->tutorProfile->user->name ?? 'N/A' }}</p>
                        <p><strong>Date/Time:</strong> {{ $session->datetime }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($session->status) }}</p>
                        @if ($session->session_id && in_array($session->status, ['pending', 'approved']))
                            <form action="{{ route('sessions.cancel', $session->session_id) }}" method="POST">
                                @csrf
                                <button class="btn-warning">Cancel</button>
                            </form>
                        @endif
                    </div>
                    <br>
                @empty
                    <p class="text-muted">No sessions booked as student.</p>
                @endforelse
            </div>

            <div class="session-group">
                <h3>As Tutor</h3>
                @forelse ($tutorSessions as $session)
                    <div class="card session-card">
                        <p><strong>Student:</strong> {{ $session->student->name ?? 'N/A' }}</p>
                        <p><strong>Date/Time:</strong> {{ $session->datetime }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($session->status) }}</p>
                        @if ($session->status === 'pending')
                            <form action="{{ route('sessions.approve', ['session' => $session->session_id]) }}" method="POST">
                                @csrf
                                <button class="btn-success">Approve</button>
                            </form>
                            <form action="{{ route('sessions.reject', ['session' => $session->session_id]) }}" method="POST">
                                @csrf
                                <button class="btn-danger">Reject</button>
                            </form>
                        @endif
                        @if ($session->id && in_array($session->status, ['pending', 'approved']))
                            <form action="{{ route('sessions.cancel', $session->id) }}" method="POST">
                                @csrf
                                <button class="btn-warning">Cancel</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-muted">No sessions booked as tutor.</p>
                @endforelse
            </div>
        </section>
    </div>

    <style>
        .dashboard-wrapper {
            padding: 2rem 7rem;
            background: #f9fafb;
            font-family: 'Inter', sans-serif;
        }
        .dashboard-header h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #111827;
        }
        .dashboard-header p {
            color: #6b7280;
        }
        .summary-cards {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            flex: 1;
        }
        .card h3 {
            font-size: 1.25rem;
            color: #2563eb;
        }
        .divider {
            margin: 2rem 0;
            border: none;
            border-top: 1px solid #e5e7eb;
        }
        .section h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
        }
        .text-muted {
            color: #9ca3af;
        }
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }
        .session-group h3 {
            color: #047857;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }
        .session-card button {
            margin-top: 0.5rem;
        }
        .btn-primary, .btn-success, .btn-danger, .btn-warning {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: white;
            text-align: center;
        }
        .btn-primary { background: #3b82f6; }
        .btn-success { background: #10b981; }
        .btn-danger { background: #ef4444; }
        .btn-warning { background: #f59e0b; }
    </style>
</x-app-layout>