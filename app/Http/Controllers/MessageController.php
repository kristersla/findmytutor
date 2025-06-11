<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $contacts = Message::where('sender_user_id', $userId)
            ->orWhere('receiver_user_id', $userId)
            ->with(['sender', 'receiver'])
            ->get()
            ->flatMap(function ($message) use ($userId) {
                return [$message->sender, $message->receiver];
            })
            ->unique('id')
            ->reject(fn($user) => $user->id === $userId)
            ->values();

        return view('messages.index', compact('contacts'));
    }

    public function show(User $user)
    {
        $authUserId = Auth::id();

        $messages = Message::where(function ($query) use ($authUserId, $user) {
            $query->where('sender_user_id', $authUserId)
                  ->where('receiver_user_id', $user->id);
        })->orWhere(function ($query) use ($authUserId, $user) {
            $query->where('sender_user_id', $user->id)
                  ->where('receiver_user_id', $authUserId);
        })->orderBy('sent_at')->get();

        return view('messages.show', [
            'messages' => $messages,
            'contact' => $user,
        ]);
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_user_id' => Auth::id(),
            'receiver_user_id' => $user->id,
            'content' => $request->input('content'),
            'sent_at' => now(),
        ]);

        return redirect()->route('messages.show', $user->id);
    }
}
