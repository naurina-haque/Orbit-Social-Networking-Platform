<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\User;
use App\Models\Post;
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

        $suggestedUsers = User::where('id', '!=', auth()->id())
            ->whereDoesntHave('sentRequests', function ($q) {
                $q->where('receiver_id', auth()->id());
            })
            ->whereDoesntHave('receivedRequests', function ($q) {
                $q->where('sender_id', auth()->id());
            })
            ->limit(5)
            ->get();

        $friendsCount = FriendRequest::where('status', 'accepted')
            ->where(function ($q) {
                $q->where('sender_id', auth()->id())
                  ->orWhere('receiver_id', auth()->id());
            })
            ->count();

        $postsCount = Post::where('user_id', auth()->id())->count();

        return view('friend_requests', compact(
            'pendingRequests',
            'suggestedUsers',
            'friendsCount',
            'postsCount'
        ));
    }
}