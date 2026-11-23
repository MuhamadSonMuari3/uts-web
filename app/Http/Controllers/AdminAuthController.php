<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            if (in_array(Auth::user()->role, ['admin', 'petugas', 'sekretaris_camat', 'camat'])) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('kecamatan.home');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Validasi role harus aparat kecamatan (admin, petugas, sekretaris_camat, atau camat)
            if (!in_array(Auth::user()->role, ['admin', 'petugas', 'sekretaris_camat', 'camat'])) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun Anda terdaftar sebagai masyarakat. Silakan login melalui portal warga.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            $roleLabel = match(Auth::user()->role) {
                'camat' => 'Bapak/Ibu Camat',
                'sekretaris_camat' => 'Sekretaris Camat',
                'petugas' => 'Petugas Pelayanan & Verifikasi',
                default => 'Administrator'
            };

            return redirect()->intended(route('admin.dashboard'))
                ->with('status', "Selamat datang kembali, {$roleLabel}!");
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'Anda telah berhasil keluar (logout).');
    }
}
