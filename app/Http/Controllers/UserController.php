<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        $search = $request->input('search');
        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%');
            });
        }

        $users = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('user.user', compact('users', 'search'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => ['required', 'string', 'min:8'],
            'role'     => 'required|string|in:admin,staff',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('user.index')->with('success', 'User baru berhasil dibuat!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'role'     => 'required|string|in:admin,staff',
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $data = [
            'name'     => $request->name,
            'username' => $request->username,
            'role'     => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        if ($user->id === Auth::id()) {
            return redirect()->route('user.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus!');
    }

    /**
     * Update the authenticated user's password.
     */
    public function updateOwnPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('password_error', 'Password saat ini salah.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('password_success', 'Password Anda berhasil diperbarui!');
    }
}
