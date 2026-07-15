<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifications', compact('notifications'));
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
            ->update(['read' => false]);

        return back();
    }
}