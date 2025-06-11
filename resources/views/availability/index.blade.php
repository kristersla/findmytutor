@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manage Availability Slots</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('availability.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="row">
            <div class="col-md-3">
                <label>Day of Week</label>
                <select name="day_of_week" class="form-control" required>
                    <option value="">Choose...</option>
                    @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                        <option value="{{ $day }}">{{ $day }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Start Time</label>
                <input type="time" name="start_time" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>End Time</label>
                <input type="time" name="end_time" class="form-control" required>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Add Slot</button>
            </div>
        </div>
    </form>

    <h4>Existing Slots</h4>
    <ul class="list-group">
        @forelse ($slots as $slot)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $slot->day_of_week }}: {{ $slot->start_time }} - {{ $slot->end_time }}</span>
                <form action="{{ route('availability.destroy', $slot->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </li>
        @empty
            <li class="list-group-item">No slots yet.</li>
        @endforelse
    </ul>
</div>
@endsection
