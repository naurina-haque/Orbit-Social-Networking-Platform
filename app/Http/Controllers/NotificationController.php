<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Models\Post;
use App\Models\FriendRequest;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        Notification::where('user_id', auth()->id())
            ->where('read', false)
            ->update(['read' => true]);

        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

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

        return view('notifications', compact(
            'notifications',
            'pendingRequests',
            'suggestedUsers',
            'friendsCount',
            'postsCount'
        ));
    }

    public function markAsRead($id)
    {
        $notification = Notification::find($id);
        $notification->update(['read' => true]);

        return back();
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('read', false)
            ->update(['read' => true]);

        return back();
    }
}