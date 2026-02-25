<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // VALIDASI INPUT
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // CREDENTIALS MANUAL SUPAYA PAKE USERNAME, BUKAN EMAIL
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        // COBA LOGIN
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            // CEK USER VALID
            if (!$user) {
                Auth::logout();
                return back()->withErrors(['username' => 'Login gagal, user tidak ditemukan.']);
            }

            // CEK ROLE ADA NGGAK
            if (!$user->role) {
                Auth::logout();
                return back()->withErrors(['username' => 'Akun tidak memiliki role.']);
            }

            $role = $user->role->name;

            // REDIRECT BERDASARKAN ROLE
            return match ($role) {
                'admin'      => redirect()->intended('/admin/dashboard'),
                'supervisor' => redirect()->intended('/supervisor/dashboard'),
                'driver'     => redirect()->intended('/driver/trips'),
                default      => redirect('/'),
            };
        }

        // LOGIN GAGAL
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}