<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\ProfileViewController;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Share;
use App\Models\FriendRequest;
use App\Models\User;

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/home', function () {
    $posts = Post::with(['user', 'likes', 'comments.user', 'shares'])->latest()->get();

    $pendingRequests = auth()->user()->pendingRequests()->with('sender')->get();

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

    return view('home', compact('posts', 'pendingRequests', 'suggestedUsers', 'friendsCount', 'postsCount'));
})->middleware(['auth'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/{user}', [ProfileViewController::class, 'show'])->name('profile.show');
});

require __DIR__.'/auth.php';
Route::post('/posts', [PostController::class, 'store'])->name('posts.store')->middleware('auth');
Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like')->middleware('auth');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
Route::post('/posts/{post}/share', [ShareController::class, 'store'])->name('posts.share')->middleware('auth');

Route::post('/friend-request/{user}', [FriendRequestController::class, 'send'])->name('friend-request.send')->middleware('auth');
Route::post('/friend-request/{friendRequest}/accept', [FriendRequestController::class, 'accept'])->name('friend-request.accept')->middleware('auth');
Route::post('/friend-request/{friendRequest}/decline', [FriendRequestController::class, 'decline'])->name('friend-request.decline')->middleware('auth');