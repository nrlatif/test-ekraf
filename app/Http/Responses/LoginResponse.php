<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse
    {
        // Check if user has admin access after login
        if (Auth::check() && in_array(Auth::user()->level_id, [1, 2])) {
            return redirect()->intended('/admin');
        }
        
        // If not admin, logout and redirect to login
        Auth::logout();
        return redirect('/admin/login')->withErrors(['email' => 'Akun Anda tidak terdaftar sebagai admin.']);
    }
}
