<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CustomLoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function create()
    {
        return view('auth.custom-login');
    }

    /**
     * Handle login request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Check if user has admin access (level 1 or 2)
            if (in_array(Auth::user()->level_id, [1, 2])) {
                return redirect()->intended(route('filament.admin.pages.dashboard'));
            } else {
                // If user doesn't have admin access, logout and redirect back
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'Akun Anda tidak terdaftar',
                ]);
            }
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    /**
     * Handle logout request.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
