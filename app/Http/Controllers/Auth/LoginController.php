<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::check() || session('is_logged_in')) {
            return redirect()->route('dashboard.dashboard');
        }
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt. 
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
            'role'     => ['required', 'in:admin,staff'],
        ]);

        $role     = $request->input('role');
        $username = $request->input('username');
        $password = $request->input('password');

        // Attempt login using standard Laravel Auth
        if (Auth::attempt(['username' => $username, 'password' => $password, 'role' => $role])) {
            $user = Auth::user();
            
            session([
                'is_logged_in' => true,
                'user' => [
                    'name' => $user->name,
                    'role' => $user->role,
                    'username' => $user->username
                ]
            ]);

            return redirect()->route('dashboard.dashboard')->with('status', 'Login berhasil!');
        }

        return back()->withErrors([
            'username' => 'Username atau kata sandi salah, atau tidak sesuai dengan peran yang dipilih.',
        ])->onlyInput('role', 'username');
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
