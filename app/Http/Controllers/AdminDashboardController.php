<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalAspirasi = Aspirasi::count();
        $menunggu = Aspirasi::where('status', 'Menunggu')->count();
        $diproses = Aspirasi::where('status', 'Diproses')->count();
        $selesai = Aspirasi::where('status', 'Selesai')->count();

        $totalUser = User::count();
        $totalMasyarakat = User::where('role', 'masyarakat')->count();

        $query = Aspirasi::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kelurahan')) {
            $query->where('kelurahan', $request->kelurahan);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('pesan', 'like', "%{$search}%")
                  ->orWhere('tindak_lanjut', 'like', "%{$search}%");
            });
        }

        $aspirasis = $query->latest()->paginate(10)->withQueryString();

        return view('admin.dashboard', compact(
            'totalAspirasi',
            'menunggu',
            'diproses',
            'selesai',
            'totalUser',
            'totalMasyarakat',
            'aspirasis'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai',
            'tindak_lanjut' => 'nullable|string',
        ]);

        $aspirasi = Aspirasi::findOrFail($id);

        $payload = [
            'status' => $request->status,
        ];

        if ($request->has('tindak_lanjut')) {
            $payload['tindak_lanjut'] = $request->tindak_lanjut;
            $payload['ditindaklanjuti_pada'] = now();
        }

        $aspirasi->update($payload);

        return back()->with('success', "Status dan tindak lanjut pengaduan dari {$aspirasi->nama} berhasil diperbarui.");
    }

    public function tindakLanjut(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai',
            'tindak_lanjut' => 'required|string',
        ]);

        $aspirasi = Aspirasi::findOrFail($id);
        $aspirasi->update([
            'status' => $request->status,
            'tindak_lanjut' => $request->tindak_lanjut,
            'ditindaklanjuti_pada' => now(),
        ]);

        return back()->with('success', "Tindak lanjut pengaduan dari {$aspirasi->nama} berhasil disimpan.");
    }

    public function destroy($id)
    {
        $aspirasi = Aspirasi::findOrFail($id);
        $aspirasi->delete();

        return back()->with('success', 'Laporan/aspirasi berhasil dihapus.');
    }
}
