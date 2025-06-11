@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Conversations</h2>
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

            <li style="margin-bottom: 15px;">
                <a href="{{ route('messages.show', $contact->id) }}">
                    <strong>{{ $contact->name }}</strong><br>
                    <small>{{ $lastMessage?->content ?? 'No messages yet.' }}</small>
                </a>
            </li>
        @empty
            <li>No conversations yet.</li>
        @endforelse
    </ul>
</div>
@endsection
