<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\PermohonanPelayanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MasyarakatDashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard warga.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Data Riwayat Permohonan Pelayanan Publik
        $permohonanPelayanan = PermohonanPelayanan::where('user_id', $user->id)
            ->latest()
            ->paginate(5, ['*'], 'layanan_page');

        // Statistik Layanan Warga
        $totalLayanan = PermohonanPelayanan::where('user_id', $user->id)->count();
        $layananMenunggu = PermohonanPelayanan::where('user_id', $user->id)->whereIn('status', ['Diajukan', 'Diverifikasi'])->count();
        $layananDiproses = PermohonanPelayanan::where('user_id', $user->id)->where('status', 'Diproses')->count();
        $layananSelesai = PermohonanPelayanan::where('user_id', $user->id)->where('status', 'Selesai')->count();

        // 2. Data Riwayat Aspirasi & Pengaduan Warga
        $aspirasis = Aspirasi::where(function ($query) use ($user) {
            if (!empty($user->nik)) {
                $query->where('nik', $user->nik);
            }
            if (!empty($user->telepon)) {
                $query->orWhere('telepon', $user->telepon);
            }
            $query->orWhere('nama', $user->name);
        })->latest()->paginate(5, ['*'], 'aspirasi_page');

        // Statistik Pengaduan Warga
        $totalPengaduan = Aspirasi::where(function ($query) use ($user) {
            if (!empty($user->nik)) {
                $query->where('nik', $user->nik);
            }
            if (!empty($user->telepon)) {
                $query->orWhere('telepon', $user->telepon);
            }
            $query->orWhere('nama', $user->name);
        })->count();

        $aspirasiMenunggu = Aspirasi::where(function ($query) use ($user) {
            if (!empty($user->nik)) {
                $query->where('nik', $user->nik);
            }
            if (!empty($user->telepon)) {
                $query->orWhere('telepon', $user->telepon);
            }
            $query->orWhere('nama', $user->name);
        })->where('status', 'Menunggu')->count();

        $aspirasiDiproses = Aspirasi::where(function ($query) use ($user) {
            if (!empty($user->nik)) {
                $query->where('nik', $user->nik);
            }
            if (!empty($user->telepon)) {
                $query->orWhere('telepon', $user->telepon);
            }
            $query->orWhere('nama', $user->name);
        })->where('status', 'Diproses')->count();

        $aspirasiSelesai = Aspirasi::where(function ($query) use ($user) {
            if (!empty($user->nik)) {
                $query->where('nik', $user->nik);
            }
            if (!empty($user->telepon)) {
                $query->orWhere('telepon', $user->telepon);
            }
            $query->orWhere('nama', $user->name);
        })->where('status', 'Selesai')->count();

        return view('masyarakat.dashboard', compact(
            'user',
            'permohonanPelayanan',
            'totalLayanan',
            'layananMenunggu',
            'layananDiproses',
            'layananSelesai',
            'aspirasis',
            'totalPengaduan',
            'aspirasiMenunggu',
            'aspirasiDiproses',
            'aspirasiSelesai'
        ));
    }

    /**
     * Simpan pengajuan pelayanan publik baru beserta berkas persyaratan.
     */
    public function storePermohonan(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'jenis_layanan' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:1000',
            'file_ktp_kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Maksimal 5MB
            'file_pengantar_rt' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'jenis_layanan.required' => 'Pilih jenis layanan administrasi yang diinginkan.',
            'file_ktp_kk.required' => 'Wajib mengunggah scan / foto KTP atau Kartu Keluarga.',
            'file_ktp_kk.mimes' => 'Format file KTP/KK harus berupa PDF, JPG, JPEG, atau PNG.',
            'file_ktp_kk.max' => 'Ukuran file KTP/KK maksimal 5 MB.',
            'file_pengantar_rt.required' => 'Wajib mengunggah Surat Pengantar dari RT/RW.',
            'file_pengantar_rt.mimes' => 'Format Surat Pengantar harus berupa PDF, JPG, JPEG, atau PNG.',
            'file_pengantar_rt.max' => 'Ukuran file Surat Pengantar maksimal 5 MB.',
            'file_pendukung.mimes' => 'Format Dokumen Pendukung harus berupa PDF, JPG, JPEG, atau PNG.',
            'file_pendukung.max' => 'Ukuran file Dokumen Pendukung maksimal 5 MB.',
        ]);

        // Upload Berkas ke disk public
        $pathKtpKk = $request->file('file_ktp_kk')->store('berkas_layanan/ktp_kk', 'public');
        $pathPengantar = $request->file('file_pengantar_rt')->store('berkas_layanan/pengantar_rt', 'public');
        
        $pathPendukung = null;
        if ($request->hasFile('file_pendukung')) {
            $pathPendukung = $request->file('file_pendukung')->store('berkas_layanan/pendukung', 'public');
        }

        // Generate Nomor Tiket Layanan Unik: TIKET-YYYYMMDD-XXXX
        $nomorTiket = 'AAL-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        PermohonanPelayanan::create([
            'user_id' => $user->id,
            'nomor_tiket' => $nomorTiket,
            'jenis_layanan' => $validated['jenis_layanan'],
            'nama_pemohon' => $user->name,
            'nik_pemohon' => $user->nik ?? '-',
            'telepon' => $user->telepon ?? '-',
            'kelurahan' => $user->kelurahan ?? 'Alang-Alang Lebar',
            'alamat' => $user->alamat ?? '-',
            'keterangan' => $validated['keterangan'] ?? null,
            'file_ktp_kk' => $pathKtpKk,
            'file_pengantar_rt' => $pathPengantar,
            'file_pendukung' => $pathPendukung,
            'status' => 'Diajukan',
        ]);

        return back()->with('success', "Permohonan pelayanan berhasil diajukan dengan Nomor Tiket: {$nomorTiket}. Petugas kecamatan akan segera memeriksa berkas Anda.");
    }

    /**
     * Kirim pengaduan / aspirasi baru dari dashboard warga.
     */
    public function storeAspirasi(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'kategori' => 'required|string',
            'pesan' => 'required|string|max:1000',
        ]);

        Aspirasi::create([
            'nama' => $user->name,
            'nik' => $user->nik,
            'telepon' => $user->telepon ?? '-',
            'kelurahan' => $user->kelurahan ?? 'Alang-Alang Lebar',
            'kategori' => $validated['kategori'],
            'pesan' => $validated['pesan'],
            'status' => 'Menunggu',
        ]);

        return back()->with('success', 'Laporan/Aspirasi Anda berhasil dikirim dan masuk dalam antrean petugas kecamatan.');
    }

    /**
     * Update profil warga.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'telepon' => ['required', 'string', 'max:20'],
            'kelurahan' => ['required', 'string', 'in:Alang-Alang Lebar,Karya Baru,Talang Kelapa,Srijaya'],
            'alamat' => ['required', 'string', 'max:500'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'telepon' => $validated['telepon'],
            'kelurahan' => $validated['kelurahan'],
            'alamat' => $validated['alamat'],
        ];

        if (!empty($validated['password'])) {
            $payload['password'] = Hash::make($validated['password']);
        }

        /** @var \App\Models\User $userModel */
        $userModel = User::findOrFail($user->id);
        $userModel->update($payload);

        return back()->with('success', 'Data profil Anda berhasil diperbarui.');
    }
}
