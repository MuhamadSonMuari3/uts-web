<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class MasyarakatAuthController extends Controller
{
    /**
     * Tampilkan form registrasi masyarakat.
     */
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('warga.dashboard');
        }
        return view('auth.register');
    }

    /**
     * Proses penyimpanan registrasi masyarakat.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nik' => ['required', 'numeric', 'digits:16', 'unique:users,nik'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'telepon' => ['required', 'string', 'max:20'],
            'kelurahan' => ['required', 'string', 'in:Alang-Alang Lebar,Karya Baru,Talang Kelapa,Srijaya'],
            'alamat' => ['required', 'string', 'max:500'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.numeric' => 'NIK harus berupa angka.',
            'nik.digits' => 'NIK harus berjumlah tepat 16 digit.',
            'nik.unique' => 'NIK ini sudah terdaftar dalam sistem.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'telepon.required' => 'Nomor WhatsApp / HP wajib diisi.',
            'kelurahan.required' => 'Pilih kelurahan domisili.',
            'kelurahan.in' => 'Kelurahan yang dipilih tidak valid.',
            'alamat.required' => 'Alamat domisili lengkap wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::create([
            'nik' => $validated['nik'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'telepon' => $validated['telepon'],
            'kelurahan' => $validated['kelurahan'],
            'alamat' => $validated['alamat'],
            'role' => 'masyarakat',
            'password' => Hash::make($validated['password']),
        ]);

        // Otomatis login setelah registrasi
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('warga.dashboard')
            ->with('success', 'Selamat datang ' . $user->name . '! Akun masyarakat Anda telah berhasil dibuat.');
    }

    /**
     * Tampilkan form login masyarakat.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('warga.dashboard');
        }
        return view('auth.login');
    }

    /**
     * Proses autentikasi login masyarakat.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'], // Bisa NIK atau Email
            'password' => ['required'],
        ], [
            'login.required' => 'NIK atau Email wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // Deteksi apakah input NIK (angka 16 digit) atau email
        $fieldType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'nik';

        $attemptCredentials = [
            $fieldType => $credentials['login'],
            'password' => $credentials['password'],
        ];

        $remember = $request->boolean('remember');

        if (Auth::attempt($attemptCredentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('warga.dashboard'))
                ->with('success', 'Selamat datang kembali di Dashboard Warga, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'login' => 'NIK/Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('login');
    }

    /**
     * Proses logout masyarakat.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('kecamatan.home')->with('info_auth', 'Anda telah berhasil keluar (logout).');
    }
}
