<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('/admin/login');
        }

        // Check if user has admin access (level 1 or 2)
        if (!in_array(Auth::user()->level_id, [1, 2])) {
            Auth::logout();
            return redirect('/admin/login')->withErrors(['email' => 'Akun Anda tidak terdaftar.']);
        }

        return $next($request);
    }
}
