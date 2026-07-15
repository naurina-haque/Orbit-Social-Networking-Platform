<?php

namespace App\Http\Controllers;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
     public function toggle(Post $post)
    {
        $existingLike = Like::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
             $liked = false;
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
            ]);
            $liked = true;
             if($post->user_id != auth()->id()) {
        Notification::create([
            'user_id' => $post->user_id,
            'from_user_id' => auth()->id(),
            'type' => 'like',
            'post_id' => $post->id,
            'message' => auth()->user()->name . ' liked your post',
        ]);
    }
        }

        return response()->json([
            'liked' => $liked,
            'count' => $post->likes()->count(),
        ]);
    }
}
