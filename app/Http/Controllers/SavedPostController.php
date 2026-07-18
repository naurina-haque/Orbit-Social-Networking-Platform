<?php

namespace App\Http\Controllers;

use App\Models\SavedPost;
use App\Models\Post;
use Illuminate\Http\Request;

class SavedPostController extends Controller
{
    public function index()
    {
        $savedPosts = SavedPost::with(['post.user', 'post.likes', 'post.comments.user', 'post.shares'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get()
            ->pluck('post')
            ->filter();

        $pendingRequests = auth()->user()->pendingRequests()->with('sender')->get();

        $suggestedUsers = \App\Models\User::where('id', '!=', auth()->id())
            ->whereDoesntHave('sentRequests', function ($q) {
                $q->where('receiver_id', auth()->id());
            })
            ->whereDoesntHave('receivedRequests', function ($q) {
                $q->where('sender_id', auth()->id());
            })
            ->limit(5)
            ->get();

        $friendsCount = \App\Models\FriendRequest::where('status', 'accepted')
            ->where(function ($q) {
                $q->where('sender_id', auth()->id())
                  ->orWhere('receiver_id', auth()->id());
            })
            ->count();

        $postsCount = Post::where('user_id', auth()->id())->count();

        return view('saved-posts', compact(
            'savedPosts',
            'pendingRequests',
            'suggestedUsers',
            'friendsCount',
            'postsCount'
        ));
    }

    public function toggle(Post $post)
    {
        $savedPost = SavedPost::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->first();

        if ($savedPost) {
            $savedPost->delete();

            return back()->with('success', 'Post removed from saved posts.');
        }

        SavedPost::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
        ]);

        return back()->with('success', 'Post saved.');
    }
}
