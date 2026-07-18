<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string|max:2000',
            'image' => 'nullable|image|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('home')->with('success', 'Post created!');
    }

    // New: Show the edit form
    public function edit(Post $post)
    {
        // Ensure only the owner can edit
        if ($post->user_id !== auth()->id()) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        return view('posts.edit', compact('post'));
    }

    // New: Handle the update logic
    public function update(Request $request, Post $post)
{
    // check ownership
    if ($post->user_id !== auth()->id()) {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }

    $request->validate([
        'content' => 'required|string|max:2000',
    ]);

    // update only content
    $post->update([
        'content' => $request->content,
    ]);

    return redirect()->route('home')->with('success', 'Post updated!');
}
public function destroy(Post $post)
{
    
    if ($post->user_id !== auth()->id()) {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }

    
    if ($post->image_path) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($post->image_path);
    }

    
    $post->delete();

    return redirect()->route('home')->with('success', 'Post deleted successfully!');
}
}