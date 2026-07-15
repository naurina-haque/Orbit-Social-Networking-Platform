<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;

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

        return view('friends', compact('friends'));
    }
    public function remove(FriendRequest $friendRequest)
{
    $friendRequest->delete();

    return back()->with('success', 'Friend removed successfully.');
}
}