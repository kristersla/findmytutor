<x-app-layout>
    <style>
        .card-custom {
            border-radius: 1.25rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            background-color: #fff;
            transition: transform 0.2s ease-in-out;
        }
        .card-custom:hover {
            transform: translateY(-4px);
        }
        .fave-tutor {
            background-color: #0000;
        }
        .btn-soft {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            color: #fff;
            transition: background-color 0.3s ease;
        }
        .btn-yellow { background-color: #fbbf24; }
        .btn-yellow:hover { background-color: #f59e0b; }
        .btn-green { background-color: #10b981; }
        .btn-green:hover { background-color: #059669; }
        .btn-red { background-color: #ef4444; }
        .btn-red:hover { background-color: #dc2626; }
        .btn-link {
            color: #3b82f6;
            font-weight: 500;
        }
        .btn-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .dashboard-header {
                font-size: 1.5rem;
                text-align: center;
            }

            .summary-cards {
                display: flex !important;
                flex-direction: row !important;
                justify-content: space-between;
                gap: 0.5rem;
            }

            .summary-cards .card-custom {
                flex: 1 1 30%;
                padding: 1rem;
            }

            .summary-cards .card-custom p.text-2xl {
                font-size: 1.5rem;
            }
        }
    </style>

    <div class="max-w-6xl mx-auto px-6 py-10 font-sans">
        <div class="mb-6">
            <h1 class="dashboard-header text-2xl sm:text-4xl font-bold text-gray-900 truncate">
                Welcome, {{ Auth::user()->name }} 👋
            </h1>
        </div>

        <div class="summary-cards flex flex-col sm:grid sm:grid-cols-3 gap-4 mb-16">
            <div class="card-custom text-center w-full sm:w-auto">
                <p class="text-sm text-gray-500">Favorites</p>
                <p class="text-2xl sm:text-3xl font-semibold text-blue-600 mt-7">{{ $favoriteTutors->count() }}</p>
            </div>
            <div class="card-custom text-center w-full sm:w-auto">
                <p class="text-sm text-gray-500">Student Sessions</p>
                <p class="text-2xl sm:text-3xl font-semibold text-blue-600 mt-2">{{ $studentSessions->count() }}</p>
            </div>
            <div class="card-custom text-center w-full sm:w-auto">
                <p class="text-sm text-gray-500">Tutor Sessions</p>
                <p class="text-2xl sm:text-3xl font-semibold text-blue-600 mt-2">{{ $tutorSessions->count() }}</p>
            </div>
        </div>

        <div class="fave-tutor">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">My Favorite Tutors</h2>
            @if($favoriteTutors->isEmpty())
                <p class="text-gray-400 italic">You haven't favorited any tutors yet.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($favoriteTutors as $tutor)
                        <div class="card-custom">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $tutor->user->name }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $tutor->bio }}</p>
                            <a href="{{ route('tutors.show', $tutor->id) }}" class="btn-link mt-4 inline-block">View Profile</a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <br>
        <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">My Sessions</h2>
            <div class="space-y-10">
                @if ($studentSessions->isNotEmpty())
                    <div>
                        <h3 class="text-lg font-medium text-green-700 mb-2">As Student</h3>
                        @foreach ($studentSessions as $session)
                            <div class="card-custom">
                                <p class="text-sm"><strong>Tutor:</strong> {{ $session->tutorProfile->user->name ?? 'N/A' }}</p>
                                <p class="text-sm"><strong>Date/Time:</strong> {{ $session->datetime }}</p>
                                <p class="text-sm"><strong>Status:</strong> {{ ucfirst($session->status) }}</p>
                                @if ($session->session_id && in_array($session->status, ['pending', 'approved']))
                                    <form action="{{ route('sessions.cancel', $session->session_id) }}" method="POST" class="mt-3">
                                        @csrf
                                        <button class="btn-soft btn-yellow">Cancel</button>
                                    </form>
                                @endif
                            </div>
                            <br>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 italic">You haven't booked any sessions yet.</p>
                @endif

                @if ($tutorSessions->isNotEmpty())
                <div>
                    <h3 class="text-lg font-medium text-green-700 mb-2">As Tutor</h3>
                    @foreach ($tutorSessions as $session)
                        <div class="card-custom">
                            <p class="text-sm"><strong>Student:</strong> {{ $session->student->name ?? 'N/A' }}</p>
                            <p class="text-sm"><strong>Date/Time:</strong> {{ $session->datetime }}</p>
                            <p class="text-sm"><strong>Note:</strong> {{ ucfirst($session->notes) }}</p>
                            <br>
                            <p class="text-sm"><strong>Status:</strong> {{ ucfirst($session->status) }}</p>

                            @if ($session->status === 'pending')
                                <div class="flex gap-2 mt-3">
                                    <form action="{{ route('sessions.approve', ['session' => $session->session_id]) }}" method="POST">
                                        @csrf
                                        <button class="btn-soft btn-green">Approve</button>
                                    </form>
                                    <form action="{{ route('sessions.reject', ['session' => $session->session_id]) }}" method="POST">
                                        @csrf
                                        <button class="btn-soft btn-red">Reject</button>
                                    </form>
                                </div>
                            @endif
                            @if ($session->id && in_array($session->status, ['pending', 'approved']))
                                <form action="{{ route('sessions.cancel', $session->id) }}" method="POST" class="mt-3">
                                    @csrf
                                    <button class="btn-soft btn-yellow">Cancel</button>
                                </form>
                            @endif
                        </div>
                        <br>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
