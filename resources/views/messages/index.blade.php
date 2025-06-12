@extends('layouts.app')

@section('content')
<style>
    .conversation-container {
        max-width: 700px;
        margin: 2rem auto;
        background: #ffffff;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .message-preview {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        transition: background 0.2s;
    }
    .message-preview:hover {
        background-color: #f9fafb;
    }
    .message-preview strong {
        font-size: 1rem;
        color: #1f2937;
    }
    .message-preview small {
        color: #6b7280;
    }
</style>

<div class="conversation-container">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Your Conversations</h2>
    <ul>
        @forelse ($contacts as $contact)
            @php
                $lastMessage = \App\Models\Message::where(function ($query) use ($contact) {
                    $query->where('sender_user_id', auth()->id())
                          ->where('receiver_user_id', $contact->id);
                })->orWhere(function ($query) use ($contact) {
                    $query->where('sender_user_id', $contact->id)
                          ->where('receiver_user_id', auth()->id());
                })->orderByDesc('sent_at')->first();
            @endphp

            <li class="message-preview">
                <a href="{{ route('messages.show', $contact->id) }}">
                    <strong>{{ $contact->name }}</strong><br>
                    <small>{{ $lastMessage?->content ?? 'No messages yet.' }}</small>
                </a>
            </li>
        @empty
            <li class="text-gray-500">No conversations yet.</li>
        @endforelse
    </ul>
</div>
@endsection
