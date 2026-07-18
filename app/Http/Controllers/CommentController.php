<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Notification;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'content' => $request->content,
        ]);

        if($post->user_id != auth()->id()) {
            Notification::create([
                'user_id' => $post->user_id,
                'from_user_id' => auth()->id(),
                'type' => 'comment',
                'post_id' => $post->id,
                'message' => auth()->user()->name . ' commented on your post',
            ]);
        }

        return response()->json([
            'id' => $comment->id,
            'content' => $comment->content,
            'user_name' => auth()->user()->name,
            'count' => $post->comments()->count(),
        ]);
    }

    public function destroy(Request $request, Comment $comment)
    {
        $post = $comment->post;

        if ($comment->user_id !== auth()->id() && $post->user_id !== auth()->id()) {
            abort(403);
        }

        $comment->delete();

        return response()->json([
            'deleted' => true,
            'count' => $post->comments()->count(),
        ]);
    }
}