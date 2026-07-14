<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Share;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    public function store(Post $post)
    {
        $existingShare = Share::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->first();

        if (!$existingShare) {
            Share::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
            ]);
        }

        return response()->json([
            'shared' => true,
            'count' => $post->shares()->count(),
        ]);
    }
}