<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\FriendRequest;

class ProfileViewController extends Controller
{
    public function show(User $user)
    {
        $posts = Post::where('user_id', $user->id)
            ->with(['user', 'likes', 'comments.user', 'shares'])
            ->latest()
            ->get();

        $friendIds = FriendRequest::where('status', 'accepted')
            ->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
            })
            ->get()
            ->map(function ($req) use ($user) {
                return $req->sender_id === $user->id ? $req->receiver_id : $req->sender_id;
            });

        $friends = User::whereIn('id', $friendIds)->get();

        $friendsCount = $friends->count();
        $postsCount = $posts->count();

        $isOwnProfile = auth()->id() === $user->id;
        $isFriend = $isOwnProfile ? false : auth()->user()->isFriendWith($user->id);
        $hasSentRequest = $isOwnProfile ? false : auth()->user()->hasSentRequestTo($user->id);

        return view('profile-view', compact(
            'user', 'posts', 'friends', 'friendsCount', 'postsCount',
            'isOwnProfile', 'isFriend', 'hasSentRequest'
        ));
    }
}