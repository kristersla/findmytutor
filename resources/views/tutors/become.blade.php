@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Become a Tutor</h2>

    <form action="{{ route('tutor.save') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Bio:</label>
            <textarea name="bio" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Hourly Rate (EUR):</label>
            <input type="number" name="hourly_rate" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Location:</label>
            <input type="text" name="location" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Contact Method (e.g. email, phone):</label>
            <input type="text" name="contact_method" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Subject:</label>
            <input type="text" name="subject_name" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Tutor Profile</button>
    </form>
</div>
@endsection
