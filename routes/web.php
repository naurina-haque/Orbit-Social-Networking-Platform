<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\ProfileViewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\SavedPostController;
use App\Models\SavedPost;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Share;
use App\Models\FriendRequest;
use App\Models\User;
use App\Models\Notification;

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/home', function () {
    $friendIds = FriendRequest::where('status', 'accepted')
        ->where(function ($q) {
            $q->where('sender_id', auth()->id())
              ->orWhere('receiver_id', auth()->id());
        })
        ->get()
        ->map(function ($req) {
            return $req->sender_id === auth()->id() ? $req->receiver_id : $req->sender_id;
        });

    $ownPosts = Post::where('user_id', auth()->id())
        ->with(['user', 'likes', 'comments.user', 'shares.user'])
        ->latest()
        ->get();

    $friendPosts = Post::whereIn('user_id', $friendIds)
        ->with(['user', 'likes', 'comments.user', 'shares.user'])
        ->latest()
        ->get();

    $sharedPosts = Post::whereHas('shares', function ($q) use ($friendIds) {
            $q->whereIn('user_id', $friendIds);
        })
        ->with(['user', 'likes', 'comments.user', 'shares.user'])
        ->latest()
        ->get();

    $posts = $ownPosts->merge($friendPosts)->merge($sharedPosts)->unique('id')->sortByDesc('created_at')->values();

    foreach ($posts as $post) {
        $share = $post->shares->firstWhere('user_id', auth()->id());
        if ($share) {
            $post->shared_by = $share->user;
        }
    }

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

    return view('home', compact('posts', 'pendingRequests', 'suggestedUsers', 'friendsCount', 'postsCount'));
})->middleware(['auth'])->name('home');

Route::get('/search', function () {
    $search = trim(request('search', ''));

    $users = User::query()
        ->where('id', '!=', auth()->id())
        ->when($search !== '', function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->orderBy('name')
        ->get();

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

    return view('search-results', compact(
        'search',
        'users',
        'pendingRequests',
        'suggestedUsers',
        'friendsCount',
        'postsCount'
    ));
})->middleware(['auth'])->name('people.search');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/{user}', [ProfileViewController::class, 'show'])->name('profile.show');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
    Route::get('/friend-requests', [FriendRequestController::class, 'index'])
        ->name('friend-requests');
    Route::get('/friends', [FriendController::class, 'index'])->name('friends');
});

require __DIR__.'/auth.php';
Route::post('/posts', [PostController::class, 'store'])->name('posts.store')->middleware(['auth', \App\Http\Middleware\EnsureProfileIsComplete::class]);
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware('auth')->name('posts.edit');
Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('auth')->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware('auth')->name('posts.destroy');
Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like')->middleware('auth');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');
Route::post('/posts/{post}/share', [ShareController::class, 'store'])->name('posts.share')->middleware('auth');

Route::post('/friend-request/{user}', [FriendRequestController::class, 'send'])->name('friend-request.send')->middleware('auth');
Route::post('/friend-request/{friendRequest}/accept', [FriendRequestController::class, 'accept'])->name('friend-request.accept')->middleware('auth');
Route::post('/friend-request/{friendRequest}/decline', [FriendRequestController::class, 'decline'])->name('friend-request.decline')->middleware('auth');
Route::delete('/friends/{friendRequest}', [FriendController::class, 'remove'])
    ->name('friends.remove');
Route::post('/posts/{post}/save', [SavedPostController::class, 'toggle'])
    ->middleware('auth')
    ->name('posts.save');
Route::get('/saved-posts', [SavedPostController::class, 'index'])
    ->middleware('auth')
    ->name('saved-posts');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware('auth')->name('posts.edit');
Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('auth')->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware('auth')->name('posts.destroy');