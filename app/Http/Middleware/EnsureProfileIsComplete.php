<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileIsComplete
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            $incomplete = empty($user->bio) || empty($user->city) || empty($user->education);

            if ($incomplete) {
                return redirect()->route('profile.edit')
                    ->with('error', 'Please complete your profile (bio, city, education) before posting.');
            }
        }

        return $next($request);
    }
}
