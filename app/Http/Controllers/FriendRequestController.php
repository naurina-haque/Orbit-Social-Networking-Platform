<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
    // Send Request 
    public function send(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json(['error' => 'You cannot add yourself'], 422);
        }

        $existing = FriendRequest::where('sender_id', auth()->id())
            ->where('receiver_id', $user->id)
            ->first();

        if (!$existing) {
            FriendRequest::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $user->id,
                'status' => 'pending',
            ]);
        }

        return response()->json(['sent' => true]);
    }

    // Request accept
    public function accept(FriendRequest $friendRequest)
    {
        $friendRequest->update(['status' => 'accepted']);

        if (request()->expectsJson()) {
            return response()->json([
                'accepted' => true,
                'pending_count' => auth()->user()->pendingRequests()->count(),
            ]);
        }

        return back();
    }

    // Request decline 
    public function decline(FriendRequest $friendRequest)
    {
        $friendRequest->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'declined' => true,
                'pending_count' => auth()->user()->pendingRequests()->count(),
            ]);
        }

        return back();
    }
    public function index()
    {
        $pendingRequests = FriendRequest::where('receiver_id', auth()->id())
            ->where('status', 'pending')
            ->with('sender')
            ->latest()
            ->get();

        return view('friend_requests', compact('pendingRequests'));
    }
}