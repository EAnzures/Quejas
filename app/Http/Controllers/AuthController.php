<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.complaints.index');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');
        $credentials['role'] = 'admin';

        if (! Auth::attempt($credentials, $remember)) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => 'Las credenciales de administrador no son correctas.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.complaints.index'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('complaints.index');
    }
}
