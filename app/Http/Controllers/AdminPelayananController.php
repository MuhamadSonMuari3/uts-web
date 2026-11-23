<?php

namespace App\Http\Controllers;

use App\Models\PermohonanPelayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPelayananController extends Controller
{
    /**
     * Tampilkan daftar permohonan pelayanan publik dari warga.
     */
    public function index(Request $request)
    {
        $query = PermohonanPelayanan::with(['user', 'petugas', 'sekcam', 'camat']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kelurahan')) {
            $query->where('kelurahan', $request->kelurahan);
        }

        if ($request->filled('jenis_layanan')) {
            $query->where('jenis_layanan', $request->jenis_layanan);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_tiket', 'like', "%{$search}%")
                  ->orWhere('nama_pemohon', 'like', "%{$search}%")
                  ->orWhere('nik_pemohon', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $permohonans = $query->latest()->paginate(10)->withQueryString();

        $totalSemua = PermohonanPelayanan::count();
        $diajukan = PermohonanPelayanan::where('status', 'Diajukan')->count();
        $diverifikasi = PermohonanPelayanan::where('status', 'Diverifikasi')->count();
        $menungguTtd = PermohonanPelayanan::where('status', 'Menunggu TTD Camat')->count();
        $ditandatanganiCamat = PermohonanPelayanan::where('status', 'Ditandatangani Camat')->count();
        $diproses = PermohonanPelayanan::where('status', 'Diproses')->count();
        $selesai = PermohonanPelayanan::where('status', 'Selesai')->count();
        $ditolak = PermohonanPelayanan::where('status', 'Ditolak')->count();

        return view('admin.pelayanan.index', compact(
            'permohonans',
            'totalSemua',
            'diajukan',
            'diverifikasi',
            'menungguTtd',
            'ditandatanganiCamat',
            'diproses',
            'selesai',
            'ditolak'
        ));
    }

    /**
     * Tampilkan halaman detail / verifikasi berkas satu permohonan.
     */
    public function show($id)
    {
        $permohonan = PermohonanPelayanan::with(['user', 'petugas', 'sekcam', 'camat'])->findOrFail($id);
        return view('admin.pelayanan.show', compact('permohonan'));
    }

    /**
     * Update status dan proses verifikasi pelayanan publik.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diajukan,Diverifikasi,Menunggu TTD Camat,Ditandatangani Camat,Diproses,Selesai,Ditolak',
            'catatan_petugas' => 'nullable|string',
            'file_hasil' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'paraf_sekcam' => 'nullable|string',
            'ttd_camat' => 'nullable|string',
        ]);

        $permohonan = PermohonanPelayanan::findOrFail($id);
        $user = auth()->user();

        $status = $request->status;

        // Jika Camat membubuhkan tanda tangan baru dan status belum diset Selesai, otomatis ubah status ke 'Ditandatangani Camat'
        if ($request->filled('ttd_camat') && !in_array($status, ['Selesai', 'Ditolak'])) {
            $status = 'Ditandatangani Camat';
        }

        $payload = [
            'status' => $status,
            'catatan_petugas' => $request->catatan_petugas,
        ];

        // Jika petugas atau admin melakukan verifikasi awal
        if (in_array($user->role, ['petugas', 'admin']) && in_array($status, ['Diverifikasi', 'Menunggu TTD Camat', 'Ditandatangani Camat', 'Diproses', 'Selesai'])) {
            $payload['petugas_id'] = $user->id;
            $payload['diverifikasi_petugas_pada'] = now();
        }

        // Jika peran Sekretaris Camat memverifikasi / memparaf berkas
        if ($user->role === 'sekretaris_camat' || $request->filled('paraf_sekcam')) {
            $payload['paraf_sekcam'] = $request->paraf_sekcam ?: ($permohonan->paraf_sekcam ?: 'Disetujui & diparaf oleh Sekretaris Camat');
            $payload['sekcam_id'] = $user->id;
            $payload['diverifikasi_sekcam_pada'] = now();
        }

        // Jika peran Camat membubuhkan Tanda Tangan Digital
        if ($request->filled('ttd_camat')) {
            $payload['ttd_camat'] = $request->ttd_camat;
            $payload['camat_id'] = $user->id;
            $payload['ditandatangani_camat_pada'] = now();
        }

        if ($status === 'Selesai') {
            $payload['selesai_pada'] = now();
        }

        if ($request->hasFile('file_hasil')) {
            if ($permohonan->file_hasil && Storage::disk('public')->exists($permohonan->file_hasil)) {
                Storage::disk('public')->delete($permohonan->file_hasil);
            }
            $payload['file_hasil'] = $request->file('file_hasil')->store('berkas_layanan/hasil', 'public');
        }

        $permohonan->update($payload);

        return back()->with('success', "Status permohonan tiket [{$permohonan->nomor_tiket}] berhasil diperbarui menjadi {$status}.");
    }

    /**
     * Hapus pengajuan pelayanan.
     */
    public function destroy($id)
    {
        $permohonan = PermohonanPelayanan::findOrFail($id);

        // Hapus file dari storage jika ada
        if ($permohonan->file_ktp_kk) {
            Storage::disk('public')->delete($permohonan->file_ktp_kk);
        }
        if ($permohonan->file_pengantar_rt) {
            Storage::disk('public')->delete($permohonan->file_pengantar_rt);
        }
        if ($permohonan->file_pendukung) {
            Storage::disk('public')->delete($permohonan->file_pendukung);
        }
        if ($permohonan->file_hasil) {
            Storage::disk('public')->delete($permohonan->file_hasil);
        }

        $nomor = $permohonan->nomor_tiket;
        $permohonan->delete();

        return back()->with('success', "Permohonan layanan tiket [{$nomor}] berhasil dihapus.");
    }
}
