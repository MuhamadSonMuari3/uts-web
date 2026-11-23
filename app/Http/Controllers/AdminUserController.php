<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%")
                  ->orWhere('kelurahan', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        $totalUser = User::count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalPetugas = User::where('role', 'petugas')->count();
        $totalSekcam = User::where('role', 'sekretaris_camat')->count();
        $totalCamat = User::where('role', 'camat')->count();
        $totalMasyarakat = User::where('role', 'masyarakat')->count();

        return view('admin.users.index', compact('users', 'totalUser', 'totalAdmin', 'totalPetugas', 'totalSekcam', 'totalCamat', 'totalMasyarakat'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => ['nullable', 'string', 'size:16', 'unique:users,nik'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'telepon' => ['nullable', 'string', 'max:20'],
            'kelurahan' => ['nullable', 'string', 'max:100'],
            'alamat' => ['nullable', 'string'],
            'role' => ['required', 'in:admin,petugas,sekretaris_camat,camat,masyarakat'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return back()->with('success', "Pengguna {$validated['name']} berhasil ditambahkan.");
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'nik' => ['nullable', 'string', 'size:16', Rule::unique('users', 'nik')->ignore($user->id)],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'telepon' => ['nullable', 'string', 'max:20'],
            'kelurahan' => ['nullable', 'string', 'max:100'],
            'alamat' => ['nullable', 'string'],
            'role' => ['required', 'in:admin,petugas,sekretaris_camat,camat,masyarakat'],
            'password' => ['nullable', 'string', 'min:6'],
        ];

        $validated = $request->validate($rules);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return back()->with('success', "Data pengguna {$user->name} berhasil diperbarui.");
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Jangan izinkan admin menghapus dirinya sendiri jika sedang login
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login.');
        }

        $nama = $user->name;
        $user->delete();

        return back()->with('success', "Pengguna {$nama} berhasil dihapus.");
    }
}
