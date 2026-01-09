<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek 1: Apakah user sudah login?
        // Cek 2: Apakah role user ADALAH 'admin'?
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Jika ya, silakan lewat (lanjut ke halaman tujuan)
            return $next($request);
        }

        // Jika bukan admin, tendang ke halaman home ('/') dengan pesan error 403
        return redirect('/');
    }
}