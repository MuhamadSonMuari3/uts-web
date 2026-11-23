<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna | Admin Kecamatan Alang-Alang Lebar</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        pemda: {
                            500: '#16a34a',
                            600: '#15803d',
                            700: '#166534',
                            800: '#14532d',
                            900: '#052e16'
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Top Admin Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Brand & Nav Links -->
                <div class="flex items-center space-x-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-pemda-600 flex items-center justify-center text-white shadow-md">
                            <i class="fa-solid fa-shield-halved text-xl"></i>
                        </div>
                        <div>
                            <span class="block text-sm font-extrabold text-slate-900 leading-none">PANEL ADMINISTRATOR</span>
                            <span class="block text-[11px] font-semibold text-amber-600 mt-0.5">Kecamatan Alang-Alang Lebar</span>
                        </div>
                    </div>

                    <!-- Navigation Tabs -->
                    <nav class="hidden md:flex items-center space-x-2">
                        <a href="{{ route('admin.pelayanan.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-600 hover:text-pemda-700 hover:bg-slate-100 transition flex items-center space-x-2">
                            <i class="fa-solid fa-file-signature"></i>
                            <span>Pelayanan Publik</span>
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-600 hover:text-pemda-700 hover:bg-slate-100 transition flex items-center space-x-2">
                            <i class="fa-solid fa-clipboard-list"></i>
                            <span>Pengaduan & Aspirasi</span>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-pemda-50 text-pemda-700 border border-pemda-200 transition flex items-center space-x-2">
                            <i class="fa-solid fa-users-gear"></i>
                            <span>Kelola Pengguna</span>
                        </a>
                    </nav>
                </div>

                <!-- Right profile & logout -->
                <div class="flex items-center space-x-4">
                    <div class="hidden sm:flex items-center space-x-2 text-xs text-slate-600">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="font-medium">{{ Auth::user()->name ?? 'Administrator' }}</span>
                        <span class="text-slate-400">({{ Auth::user()->role ?? 'admin' }})</span>
                    </div>

                    <a href="{{ route('kecamatan.home') }}" target="_blank" class="px-3 py-1.5 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 text-xs font-semibold flex items-center space-x-1.5 transition">
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        <span>Lihat Web</span>
                    </a>

                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-3.5 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition shadow-sm flex items-center space-x-1.5">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Mobile Nav Bar -->
        <div class="md:hidden flex border-t border-slate-200 px-4 py-2 bg-slate-50 space-x-2">
            <a href="{{ route('admin.dashboard') }}" class="flex-1 text-center py-2 text-xs font-bold rounded-lg text-slate-600 hover:bg-slate-200">
                <i class="fa-solid fa-clipboard-list mr-1"></i> Pengaduan
            </a>
            <a href="{{ route('admin.users.index') }}" class="flex-1 text-center py-2 text-xs font-bold rounded-lg bg-pemda-600 text-white">
                <i class="fa-solid fa-users-gear mr-1"></i> Kelola User
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Flash Alert -->
        @if(session('success'))
        <div id="alert-box" class="mb-6 p-4 rounded-2xl bg-emerald-700 text-white shadow-md flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i class="fa-solid fa-circle-check text-xl text-emerald-300"></i>
                <span class="text-xs sm:text-sm font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="document.getElementById('alert-box').remove()" class="text-emerald-200 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
        </div>
        @endif

        @if(session('error'))
        <div id="alert-box-err" class="mb-6 p-4 rounded-2xl bg-rose-700 text-white shadow-md flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i class="fa-solid fa-triangle-exclamation text-xl text-rose-300"></i>
                <span class="text-xs sm:text-sm font-medium">{{ session('error') }}</span>
            </div>
            <button onclick="document.getElementById('alert-box-err').remove()" class="text-rose-200 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
            <div class="flex items-center space-x-2 font-bold text-xs uppercase mb-1">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>Terdapat kesalahan pengisian data:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-5 gap-3.5 mb-8">
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total User</span>
                    <span class="text-xl font-extrabold text-slate-900 mt-1 block">{{ $totalUser }}</span>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider block">Warga</span>
                    <span class="text-xl font-extrabold text-emerald-700 mt-1 block">{{ $totalMasyarakat }}</span>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-id-card"></i>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-teal-600 uppercase tracking-wider block">Petugas Verifikator</span>
                    <span class="text-xl font-extrabold text-teal-700 mt-1 block">{{ $totalPetugas }}</span>
                </div>
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-user-check"></i>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-indigo-600 uppercase tracking-wider block">Sekcam & Camat</span>
                    <span class="text-xl font-extrabold text-indigo-700 mt-1 block">{{ $totalSekcam + $totalCamat }}</span>
                </div>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-signature"></i>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-purple-600 uppercase tracking-wider block">Admin</span>
                    <span class="text-xl font-extrabold text-purple-700 mt-1 block">{{ $totalAdmin }}</span>
                </div>
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
            </div>
        </div>

        <!-- Filter & Header Actions -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            <div class="p-6 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900">Data Master Pengguna</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Kelola akun administrator kecamatan dan data akun masyarakat terdaftar</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <button onclick="openAddModal()" class="px-4 py-2.5 rounded-xl bg-pemda-600 hover:bg-pemda-700 text-white text-xs font-bold transition shadow-sm flex items-center space-x-2">
                        <i class="fa-solid fa-user-plus"></i>
                        <span>Tambah User Baru</span>
                    </button>
                </div>
            </div>

            <!-- Search and Filter Bar -->
            <div class="p-4 bg-slate-50/70 border-b border-slate-200">
                <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIK, email, no HP, atau kelurahan..." class="w-full pl-9 pr-4 py-2 bg-white rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none">
                    </div>

                    <div class="sm:w-44">
                        <select name="role" onchange="this.form.submit()" class="w-full py-2 px-3 bg-white rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none cursor-pointer">
                            <option value="">Semua Peran / Role</option>
                            <option value="masyarakat" {{ request('role') == 'masyarakat' ? 'selected' : '' }}>Masyarakat (Warga)</option>
                            <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas Verifikasi</option>
                            <option value="sekretaris_camat" {{ request('role') == 'sekretaris_camat' ? 'selected' : '' }}>Sekretaris Camat</option>
                            <option value="camat" {{ request('role') == 'camat' ? 'selected' : '' }}>Camat</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin (Kecamatan)</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold transition">
                            Cari
                        </button>
                        @if(request('search') || request('role'))
                        <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-semibold transition" title="Reset Filter">
                            Reset
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- User Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3.5 px-4">Nama & NIK</th>
                            <th class="py-3.5 px-4">Kontak</th>
                            <th class="py-3.5 px-4">Kelurahan & Alamat</th>
                            <th class="py-3.5 px-4">Role</th>
                            <th class="py-3.5 px-4">Terdaftar</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-700">
                        @forelse($users as $user)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-4 whitespace-nowrap">
                                <div class="font-extrabold text-slate-900 flex items-center space-x-2">
                                    <span>{{ $user->name }}</span>
                                    @if(auth()->id() === $user->id)
                                        <span class="px-2 py-0.5 rounded text-[10px] bg-amber-100 text-amber-800 font-bold">Anda</span>
                                    @endif
                                </div>
                                <div class="text-[11px] text-slate-500 mt-0.5">
                                    <i class="fa-regular fa-id-badge mr-1 text-slate-400"></i> NIK: <span class="font-mono">{{ $user->nik ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="text-slate-800 font-medium block">{{ $user->email }}</span>
                                <span class="text-[11px] text-slate-500 flex items-center mt-0.5">
                                    <i class="fa-solid fa-phone text-slate-400 mr-1 text-[10px]"></i> {{ $user->telepon ?? '-' }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                @if($user->kelurahan)
                                    <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-800 border border-slate-200 inline-block mb-1">
                                        {{ $user->kelurahan }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">-</span>
                                @endif
                                <p class="text-slate-500 text-[11px] line-clamp-1" title="{{ $user->alamat }}">{{ $user->alamat ?? '-' }}</p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                @if($user->role === 'camat')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800 border border-amber-200">
                                        <i class="fa-solid fa-stamp mr-1"></i> CAMAT
                                    </span>
                                @elseif($user->role === 'sekretaris_camat')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-indigo-100 text-indigo-800 border border-indigo-200">
                                        <i class="fa-solid fa-file-signature mr-1"></i> SEKRETARIS CAMAT
                                    </span>
                                @elseif($user->role === 'petugas')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-teal-100 text-teal-800 border border-teal-200">
                                        <i class="fa-solid fa-user-check mr-1"></i> PETUGAS VERIFIKASI
                                    </span>
                                @elseif($user->role === 'admin')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-purple-100 text-purple-700 border border-purple-200">
                                        <i class="fa-solid fa-user-shield mr-1"></i> ADMIN
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                        <i class="fa-solid fa-user mr-1"></i> WARGA
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap text-slate-500">
                                {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <button type="button" 
                                            onclick='openEditModal(@json($user))'
                                            class="p-2 rounded-lg text-amber-600 hover:bg-amber-50 transition" 
                                            title="Edit Data User">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-rose-500 hover:bg-rose-50 transition" title="Hapus User">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-user-slash text-3xl mb-2 block"></i>
                                Tidak ditemukan data pengguna.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </main>

    <!-- Modal Tambah User -->
    <div id="addModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-pemda-600 text-white flex items-center justify-center">
                        <i class="fa-solid fa-user-plus text-xs"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-900 text-base">Tambah Pengguna Baru</h3>
                </div>
                <button type="button" onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                        <input type="text" name="name" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none" placeholder="Cth: Budi Santoso">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email *</label>
                        <input type="email" name="email" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none" placeholder="budi@example.com">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">NIK (16 Digit)</label>
                        <input type="text" name="nik" maxlength="16" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none" placeholder="16 Digit NIK KTP">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="telepon" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none" placeholder="08xxxxxxxxxx">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kelurahan</label>
                        <select name="kelurahan" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none">
                            <option value="">-- Pilih Kelurahan --</option>
                            <option value="Alang-Alang Lebar">Alang-Alang Lebar</option>
                            <option value="Talang Kelapa">Talang Kelapa</option>
                            <option value="Karya Baru">Karya Baru</option>
                            <option value="Srijaya">Srijaya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Peran Akun (Role) *</label>
                        <select name="role" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none font-bold text-pemda-800">
                            <option value="masyarakat">Masyarakat (Warga)</option>
                            <option value="petugas">Petugas Verifikasi Berkas</option>
                            <option value="sekretaris_camat">Sekretaris Camat</option>
                            <option value="camat">Camat (Penandatangan Digital)</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Lengkap</label>
                    <textarea name="alamat" rows="2" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none" placeholder="Jl. Contoh RT 01 RW 02..."></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Password Baru *</label>
                    <input type="password" name="password" required minlength="6" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none" placeholder="Minimal 6 karakter">
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end space-x-2">
                    <button type="button" onclick="closeAddModal()" class="px-4 py-2 rounded-xl border border-slate-300 text-slate-600 text-xs font-bold hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-pemda-600 hover:bg-pemda-700 text-white text-xs font-bold shadow-md transition">
                        Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div id="editModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-amber-600 text-white flex items-center justify-center">
                        <i class="fa-solid fa-user-pen text-xs"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-900 text-base">Edit Data Pengguna</h3>
                </div>
                <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form id="editForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                        <input type="text" id="edit_name" name="name" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email *</label>
                        <input type="email" id="edit_email" name="email" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">NIK (16 Digit)</label>
                        <input type="text" id="edit_nik" name="nik" maxlength="16" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Telepon / WhatsApp</label>
                        <input type="text" id="edit_telepon" name="telepon" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kelurahan</label>
                        <select id="edit_kelurahan" name="kelurahan" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none">
                            <option value="">-- Pilih Kelurahan --</option>
                            <option value="Alang-Alang Lebar">Alang-Alang Lebar</option>
                            <option value="Talang Kelapa">Talang Kelapa</option>
                            <option value="Karya Baru">Karya Baru</option>
                            <option value="Srijaya">Srijaya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Peran Akun (Role) *</label>
                        <select id="edit_role" name="role" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none font-bold text-pemda-800">
                            <option value="masyarakat">Masyarakat (Warga)</option>
                            <option value="petugas">Petugas Verifikasi Berkas</option>
                            <option value="sekretaris_camat">Sekretaris Camat</option>
                            <option value="camat">Camat (Penandatangan Digital)</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Lengkap</label>
                    <textarea id="edit_alamat" name="alamat" rows="2" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Password Baru (Opsional)</label>
                    <input type="password" name="password" minlength="6" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none" placeholder="Kosongkan bila tidak ingin mengganti password">
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end space-x-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl border border-slate-300 text-slate-600 text-xs font-bold hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold shadow-md transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer Admin -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-500 mt-auto">
        &copy; {{ date('Y') }} Kantor Camat Alang-Alang Lebar Palembang • Administrator Dashboard
    </footer>

    <script>
        function openAddModal() {
            const modal = document.getElementById('addModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeAddModal() {
            const modal = document.getElementById('addModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openEditModal(user) {
            const form = document.getElementById('editForm');
            form.action = `/admin/users/${user.id}`;
            document.getElementById('edit_name').value = user.name || '';
            document.getElementById('edit_email').value = user.email || '';
            document.getElementById('edit_nik').value = user.nik || '';
            document.getElementById('edit_telepon').value = user.telepon || '';
            document.getElementById('edit_kelurahan').value = user.kelurahan || '';
            document.getElementById('edit_alamat').value = user.alamat || '';
            document.getElementById('edit_role').value = user.role || 'masyarakat';

            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close on ESC
        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAddModal();
                closeEditModal();
            }
        });
    </script>
</body>
</html>
