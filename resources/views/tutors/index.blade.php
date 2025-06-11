@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Find a Tutor</h1>

    <form method="GET" action="{{ route('tutors.index') }}" class="mb-4">
        <input type="text" name="name" placeholder="Search by name" value="{{ request('name') }}">
        <input type="text" name="location" placeholder="Location" value="{{ request('location') }}">
        <input type="text" name="subject" placeholder="Subject" value="{{ request('subject') }}">
        <button type="submit">Search</button>
    </form>

    @foreach ($tutors as $tutor)
        <div class="card mb-3 p-3">
            <h3>
                <a href="{{ route('tutors.show', $tutor->id) }}">
                    {{ $tutor->user->name }}
                </a>
            </h3>
            <p><strong>Location:</strong> {{ $tutor->location }}</p>
            <p><strong>Subject:</strong> {{ $tutor->subject->name ?? '—' }}</p>
            <p><strong>Bio:</strong> {{ $tutor->bio }}</p>
        </div>
    @endforeach


    {{ $tutors->links() }}
</div>
@endsection
