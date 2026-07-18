<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\User;
use App\Models\Post;

class FriendController extends Controller
{
    public function index()
    {
        $friends = FriendRequest::where('status', 'accepted')
            ->where(function ($q) {
                $q->where('sender_id', auth()->id())
                  ->orWhere('receiver_id', auth()->id());
            })
            ->with(['sender', 'receiver'])
            ->get();

        $pendingRequests = auth()->user()->pendingRequests()->with('sender')->latest()->take(5)->get();

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

        return view('friends', compact(
            'friends',
            'pendingRequests',
            'suggestedUsers',
            'friendsCount',
            'postsCount'
        ));
    }

    public function remove(FriendRequest $friendRequest)
    {
        $friendRequest->delete();

        return back()->with('success', 'Friend removed successfully.');
    }
}