@extends('layouts.app')

@section('content')
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .tutor-form-wrapper {
        background-color: #f3f4f6; /* Light gray background instead of image */
        min-height: 93vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .tutor-form-container {
        background: white;
        padding: 30px 40px;
        border-radius: 10px;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        width: 100%;
    }

    .tutor-form-container h2 {
        text-align: center;
        margin-bottom: 20px;
        font-weight: bold;
        font-size: 20px
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: 600;
        display: block;
        margin-bottom: 6px;
    }

    .form-control {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
    }

    .btn-submit {
        background-color:rgb(88, 123, 218);
        color: white;
        border: none;
        padding: 12px 24px;
        font-weight: 600;
        border-radius: 6px;
        width: 100%;
        transition: background-color 0.3s ease;
    }

    .btn-submit:hover {
        background-color: rgb(63, 87, 153);
    }
</style>

<div class="tutor-form-wrapper">
    <form class="tutor-form-container" action="{{ route('tutor.save') }}" method="POST">
        @csrf
        <h2>Become a Tutor</h2>

        <div class="form-group">
            <label>Bio:</label>
            <textarea name="bio" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label>Hourly Rate (EUR):</label>
            <input type="number" name="hourly_rate" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Location:</label>
            <input type="text" name="location" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Contact Method (e.g. email, phone):</label>
            <input type="text" name="contact_method" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Subject:</label>
            <select name="subject_name" class="form-control" required>
                <option value="">Select a subject</option>
                <option value="math">Math</option>
                <option value="literature">Literature</option>
                <option value="writing">Writing</option>
                <option value="culinary">Culinary</option>
                <option value="biology">Biology</option>
                <option value="chemistry">Chemistry</option>
                <option value="physics">Physics</option>
                <option value="geography">Geography</option>
            </select>
        </div>
        <button type="submit" class="btn-submit">Create Tutor Profile</button>
    </form>
</div>
@endsection
