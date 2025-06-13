@extends('layouts.app')

@section('content')
<style>
    .availability-wrapper {
        max-width: 700px;
        margin: 40px auto;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    @media (max-width: 768px) {
        .availability-wrapper {
            margin: 20px 16px;
            padding: 20px;
        }
    }

    h2 {
        text-align: center;
        font-weight: bold;
        margin-bottom: 30px;
        font-size: 20px;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }

    .form-control {
        border-radius: 6px;
        padding: 10px;
        font-size: 15px;
        width: 100%;
    }

    .btn-primary {
        background-color: rgba(89, 131, 247, 0.63);
        border: none;
        font-weight: 600;
        padding: 12px;
        width: 100%;
        margin-top: 20px;
        border-radius: 6px;
    }

    .btn-primary:hover {
        background-color: rgba(44, 76, 166, 0.63);
    }

    .alert-success.custom-success {
        background-color: #d1fae5;
        color: #065f46;
        padding: 12px 20px;
        border-left: 5px solid #10b981;
        border-radius: 6px;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    .slot-card {
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        padding: 12px 16px;
        border-radius: 6px;
        font-size: 15px;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.2s ease;
    }

    .slot-card:hover {
        background-color: #f3f4f6;
    }

    .btn-outline-danger {
        background-color: rgba(189, 57, 57, 0.9);
        color: white;
        border: none;
        padding: 6px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        transition: background-color 0.2s ease;
    }

    .btn-outline-danger:hover {
        background-color: rgba(146, 43, 43, 0.9);
    }

    .form-row {
        margin-bottom: 20px;
    }
</style>

<div class="availability-wrapper">
    <h2>Manage Availability Slots</h2>

    @if(session('success'))
        <div class="alert alert-success custom-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('availability.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <label class="form-label">Day of Week</label>
            <select name="day_of_week" class="form-control" required>
                <option value="">Choose...</option>
                @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                    <option value="{{ $day }}">{{ $day }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <label class="form-label">Start Time</label>
            <input type="time" name="start_time" class="form-control" required>
        </div>

        <div class="form-row">
            <label class="form-label">End Time</label>
            <input type="time" name="end_time" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Slot</button>
    </form>

    <div class="mt-4">
        <h4>Existing Slots</h4>
        @forelse ($slots as $slot)
            <div class="slot-card">
                <div><strong>{{ $slot->day_of_week }}</strong>: {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}</div>
                <form action="{{ route('availability.destroy', $slot->id) }}" method="POST" style="margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </div>
        @empty
            <p class="text-muted">No slots yet.</p>
        @endforelse
    </div>
</div>
@endsection
