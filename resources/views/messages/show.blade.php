@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Conversation with {{ $contact->name }}</h2>

    <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
        @foreach ($messages as $message)
            <div style="margin-bottom: 10px;">
                <strong>{{ $message->sender->id === auth()->id() ? 'You' : $message->sender->name }}:</strong>
                {{ $message->content }}
                <br>
                <small>{{ $message->sent_at }}</small>
            </div>
        @endforeach
    </div>

    <form action="{{ route('messages.store', $contact->id) }}" method="POST">
        @csrf
        <div>
            <textarea name="content" rows="3" class="form-control" required></textarea>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Send</button>
    </form>
</div>
@endsection
