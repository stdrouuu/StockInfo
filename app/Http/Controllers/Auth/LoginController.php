<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Hardcoded user credentials (no database needed).
     */
    private array $users = [
        'admin' => [
            'username' => 'admin_utama',
            'password' => 'admin123',
            'name'     => 'Administrator',
        ],
        'staff' => [
            'username' => 'staff_toko',
            'password' => 'staff123',
            'name'     => 'Staff Gudang',
        ],
    ];

    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
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

        // Check if the credentials match the hardcoded user for the selected role
        if (
            isset($this->users[$role]) &&
            $this->users[$role]['username'] === $username &&
            $this->users[$role]['password'] === $password
        ) {
            // Kita tidak menyimpan session 'is_logged_in' agar bisa diam di login untuk testing berulang kali
            return redirect('/login')->with('status', 'Login berhasil!');
        }

        return back()->withErrors([
            'username' => 'Username atau kata sandi salah, atau tidak sesuai dengan peran yang dipilih.',
        ])->onlyInput('role');
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
