<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Kasir;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (Auth::guard('kasir')->check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        // Cari kasir berdasarkan username
        $kasir = Kasir::where('username', $request->username)->first();

        // Cek apakah kasir ditemukan dan password cocok
        if ($kasir && Hash::check($request->password, $kasir->password)) {
            // Login berhasil
            Auth::guard('kasir')->login($kasir);
            
            // Regenerate session untuk keamanan
            $request->session()->regenerate();
            
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Login berhasil! Selamat datang ' . $kasir->nama_kasir);
        }

        // Login gagal
        return back()
            ->withInput($request->only('username'))
            ->withErrors([
                'username' => 'Username atau password salah.',
            ]);
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        Auth::guard('kasir')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'Anda berhasil logout');
    }
}