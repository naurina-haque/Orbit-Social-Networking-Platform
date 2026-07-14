<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;

class ProfileViewController extends Controller
{
    public function show(User $user)
    {
        $posts = Post::where('user_id', $user->id)
            ->with(['user', 'likes', 'comments.user', 'shares'])
            ->latest()
            ->get();

        $friendsCount = \App\Models\FriendRequest::where('status', 'accepted')
            ->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
            })
            ->count();

        $postsCount = $posts->count();

        $isOwnProfile = auth()->id() === $user->id;

        $isFriend = $isOwnProfile ? false : auth()->user()->isFriendWith($user->id);

        $hasSentRequest = $isOwnProfile ? false : auth()->user()->hasSentRequestTo($user->id);

        return view('profile-view', compact(
            'user', 'posts', 'friendsCount', 'postsCount',
            'isOwnProfile', 'isFriend', 'hasSentRequest'
        ));
    }
}