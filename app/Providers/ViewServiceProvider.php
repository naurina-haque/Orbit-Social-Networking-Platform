<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\FriendRequest;
use App\Models\Notification;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('layouts.navigation', function ($view) {
            if (auth()->check()) {
                $view->with([
                    'friendRequestCount' => FriendRequest::where('receiver_id', auth()->id())
                        ->where('status', 'pending')
                        ->count(),
                    'notificationCount' => Notification::where('user_id', auth()->id())
                        ->where('read', false)
                        ->count(),
                ]);
            } else {
                $view->with([
                    'friendRequestCount' => 0,
                    'notificationCount' => 0,
                ]);
            }
        });
    }
}
