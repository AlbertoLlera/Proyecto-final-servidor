<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LogoutController extends Controller
{
    public function store(Request $request)
    {
        auth()->logout();

        // Invalidate the session so any cached browser session data becomes useless
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $sessionCookie = config('session.cookie');
        Cookie::queue(Cookie::forget($sessionCookie));
        Cookie::queue(Cookie::forget('XSRF-TOKEN'));

        $recaller = auth()->getRecallerName();
        if ($recaller) {
            Cookie::queue(Cookie::forget($recaller));
        }

        return redirect()->route('login');
    }
}
