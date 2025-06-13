@extends('layouts.app')

@section('content')
<style>
    .chat-container {
        max-width: 700px;
        margin: 2rem auto;
        background: #ffffff;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .hero-text {
        text-align: center;
        font-size: 20px;
        padding-bottom: 10px;
    }

    .chat-bubble {
        margin-bottom: 1rem;
        padding: 1rem;
        border-radius: 0.5rem;
        background-color: #f3f4f6;
    }

    .chat-sender {
        font-weight: bold;
        color: #374151;
    }

    .chat-meta {
        font-size: 0.875rem;
        color: #9ca3af;
    }

    .chat-form textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        resize: vertical;
    }

    .chat-form button {
        margin-top: 0.75rem;
        background-color: #3b82f6;
        color: white;
        padding: 0.5rem 1rem;
        border: none;
        width: 100%;
        border-radius: 0.375rem;
        transition: background 0.3s;
    }

    .chat-form button:hover {
        background-color: #2563eb;
    }

    @media (max-width: 768px) {
        .chat-container {
            margin: 2rem 1rem;
        }
    }
</style>

<div class="chat-container">
    <h2 class="hero-text">Conversation with <span style="font-weight: 600;">{{ $contact->name }}</span></h2>

    <div class="mb-6">
        @foreach ($messages as $message)
            <div class="chat-bubble">
                <div class="chat-sender">
                    {{ $message->sender->id === auth()->id() ? 'You' : $message->sender->name }}:
                </div>
                <div>{{ $message->content }}</div>
                <div class="chat-meta mt-1">{{ $message->sent_at }}</div>
            </div>
        @endforeach
    </div>

    <form action="{{ route('messages.store', $contact->id) }}" method="POST" class="chat-form">
        @csrf
        <textarea name="content" rows="3" placeholder="Start typing here..." required></textarea>
        <button type="submit">Send message</button>
    </form>
</div>
@endsection
