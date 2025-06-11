<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <hr class="my-6">

            <div class="mb-6">
                <h2 class="text-lg font-semibold">My Favorite Tutors</h2>

                @if($favoriteTutors->isEmpty())
                    <p class="text-gray-500">You haven't favorited any tutors yet.</p>
                @else
                    <ul class="list-disc pl-5">
                        @foreach($favoriteTutors as $tutor)
                            <li class="mb-2">
                                <strong>{{ $tutor->user->name }}</strong><br>
                                <span>{{ $tutor->bio }}</span><br>
                                <a href="{{ route('tutors.show', $tutor->id) }}" class="btn btn-sm btn-outline-primary mt-1">View Profile</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <hr class="my-6">

            <div class="mb-6">
                <h2 class="text-lg font-semibold">My Upcoming Sessions</h2>

                <h3 class="mt-4 font-semibold">As Student</h3>
                @if($studentSessions->isEmpty())
                    <p class="text-gray-500">No sessions booked as student.</p>
                @else
                    <ul>
                        @foreach($studentSessions as $session)
                            <li class="mb-2">
                                Tutor: {{ $session->tutorProfile?->user->name ?? 'N/A' }}<br>
                                Date/Time: {{ $session->datetime }}<br>
                                Status: {{ $session->status }}
                            </li>
                        @endforeach
                    </ul>
                @endif

                <h3 class="mt-4 font-semibold">As Tutor</h3>
                @if($tutorSessions->isEmpty())
                    <p class="text-gray-500">No sessions booked as tutor.</p>
                @else
                    <ul>
                        @foreach($tutorSessions as $session)
                            <li class="mb-2">
                                Student: {{ $session->student?->name ?? 'N/A' }}<br>
                                Date/Time: {{ $session->datetime }}<br>
                                Status: {{ $session->status }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
