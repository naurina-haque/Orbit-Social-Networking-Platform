<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Orbit') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body style="margin:0; font-family: 'Figtree', sans-serif; background: #F2F6FB; color: #1E293B;">
        <div style="min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px;">
            <div style="text-align:center; max-width:480px;">
                <h1 style="font-size:48px; font-weight:800; margin:0 0 12px; background: linear-gradient(135deg, #3B5BDB, #0EA5E9 55%, #14B8A6); -webkit-background-clip:text; background-clip:text; color:transparent;">Orbit</h1>
                <p style="font-size:18px; color:#64748B; margin:0 0 24px;">Connect. Share. Discover.</p>
                <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" style="display:inline-block; padding:12px 24px; border-radius:10px; font-size:15px; font-weight:700; color:#fff; background:linear-gradient(135deg, #3B5BDB, #0EA5E9 55%, #14B8A6); text-decoration:none;">Login</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" style="display:inline-block; padding:12px 24px; border-radius:10px; font-size:15px; font-weight:700; color:#1E293B; background:#F2F6FB; border:1px solid #E2E8F0; text-decoration:none;">Register</a>
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>
