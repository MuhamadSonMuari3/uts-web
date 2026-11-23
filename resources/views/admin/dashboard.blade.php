<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Kecamatan Alang-Alang Lebar Palembang</title>

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
                <!-- Brand & Navigation -->
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
                        <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-pemda-50 text-pemda-700 border border-pemda-200 transition flex items-center space-x-2">
                            <i class="fa-solid fa-clipboard-list"></i>
                            <span>Pengaduan Warga</span>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-600 hover:text-pemda-700 hover:bg-slate-100 transition flex items-center space-x-2">
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
            <a href="{{ route('admin.dashboard') }}" class="flex-1 text-center py-2 text-xs font-bold rounded-lg bg-pemda-600 text-white">
                <i class="fa-solid fa-clipboard-list mr-1"></i> Pengaduan
            </a>
            <a href="{{ route('admin.users.index') }}" class="flex-1 text-center py-2 text-xs font-bold rounded-lg text-slate-600 hover:bg-slate-200">
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

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Pengaduan</span>
                    <span class="text-2xl font-extrabold text-slate-900 mt-1 block">{{ $totalAspirasi }}</span>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-inbox"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-amber-500 uppercase tracking-wider block">Menunggu</span>
                    <span class="text-2xl font-extrabold text-amber-600 mt-1 block">{{ $menunggu }}</span>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-indigo-500 uppercase tracking-wider block">Diproses</span>
                    <span class="text-2xl font-extrabold text-indigo-600 mt-1 block">{{ $diproses }}</span>
                </div>
                <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-spinner"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-emerald-500 uppercase tracking-wider block">Selesai</span>
                    <span class="text-2xl font-extrabold text-emerald-600 mt-1 block">{{ $selesai }}</span>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-purple-500 uppercase tracking-wider block">Total User</span>
                    <span class="text-2xl font-extrabold text-purple-600 mt-1 block">{{ $totalUser }}</span>
                </div>
                <a href="{{ route('admin.users.index') }}" class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 hover:bg-purple-100 transition flex items-center justify-center text-lg" title="Kelola User">
                    <i class="fa-solid fa-users"></i>
                </a>
            </div>
        </div>

        <!-- Table Management Aspirasi Warga -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900">Daftar Pengaduan & Tindak Lanjut Masyarakat</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Pantau status laporan masyarakat dan berikan catatan/bukti tindak lanjut resmi</p>
                </div>
            </div>

            <!-- Filter & Search Bar -->
            <div class="p-4 bg-slate-50/70 border-b border-slate-200">
                <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, pesan, telepon, kategori, atau tindak lanjut..." class="w-full pl-9 pr-4 py-2 bg-white rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none">
                    </div>

                    <div class="sm:w-40">
                        <select name="status" onchange="this.form.submit()" class="w-full py-2 px-3 bg-white rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>⏳ Menunggu</option>
                            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>⚙️ Diproses</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>✅ Selesai</option>
                        </select>
                    </div>

                    <div class="sm:w-44">
                        <select name="kelurahan" onchange="this.form.submit()" class="w-full py-2 px-3 bg-white rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none cursor-pointer">
                            <option value="">Semua Kelurahan</option>
                            <option value="Alang-Alang Lebar" {{ request('kelurahan') == 'Alang-Alang Lebar' ? 'selected' : '' }}>Alang-Alang Lebar</option>
                            <option value="Talang Kelapa" {{ request('kelurahan') == 'Talang Kelapa' ? 'selected' : '' }}>Talang Kelapa</option>
                            <option value="Karya Baru" {{ request('kelurahan') == 'Karya Baru' ? 'selected' : '' }}>Karya Baru</option>
                            <option value="Srijaya" {{ request('kelurahan') == 'Srijaya' ? 'selected' : '' }}>Srijaya</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold transition">
                            Cari
                        </button>
                        @if(request('search') || request('status') || request('kelurahan'))
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-semibold transition" title="Reset Filter">
                            Reset
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3.5 px-4">Waktu & Pelapor</th>
                            <th class="py-3.5 px-4">Kelurahan</th>
                            <th class="py-3.5 px-4">Kategori & Isi Laporan</th>
                            <th class="py-3.5 px-4">Tindak Lanjut Petugas</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-700">
                        @forelse($aspirasis as $item)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-4 whitespace-nowrap">
                                <div class="font-extrabold text-slate-900">{{ $item->nama }}</div>
                                <div class="text-[11px] text-slate-500 flex items-center mt-0.5">
                                    <i class="fa-brands fa-whatsapp text-emerald-500 mr-1"></i> {{ $item->telepon }}
                                </div>
                                <div class="text-[10px] text-slate-400 mt-1">
                                    {{ $item->created_at->format('d M Y, H:i') }} WIB
                                </div>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-slate-100 text-slate-800 border border-slate-200">
                                    {{ $item->kelurahan }}
                                </span>
                            </td>
                            <td class="py-4 px-4 max-w-xs">
                                <span class="font-semibold text-amber-700 block mb-1 text-[11px]">
                                    <i class="fa-solid fa-tag text-[9px] mr-1"></i>{{ $item->kategori }}
                                </span>
                                <p class="text-slate-600 leading-relaxed">{{ $item->pesan }}</p>
                            </td>
                            <td class="py-4 px-4 max-w-xs">
                                @if($item->tindak_lanjut)
                                    <div class="p-2.5 rounded-xl bg-emerald-50 border border-emerald-100 text-slate-700 text-[11px]">
                                        <div class="flex items-center text-emerald-700 font-bold mb-1">
                                            <i class="fa-solid fa-clipboard-check mr-1"></i> Tindak Lanjut:
                                        </div>
                                        <p class="leading-relaxed">{{ $item->tindak_lanjut }}</p>
                                        @if($item->ditindaklanjuti_pada)
                                            <span class="block text-[10px] text-emerald-600 mt-1 font-medium">
                                                Update: {{ $item->ditindaklanjuti_pada->format('d/m/Y H:i') }}
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">Belum ada tindak lanjut</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <form action="{{ route('admin.aspirasi.status', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="px-2.5 py-1.5 rounded-lg text-xs font-bold border focus:outline-none cursor-pointer 
                                        @if($item->status == 'Menunggu') bg-amber-50 text-amber-700 border-amber-300
                                        @elseif($item->status == 'Diproses') bg-indigo-50 text-indigo-700 border-indigo-300
                                        @else bg-emerald-50 text-emerald-700 border-emerald-300 @endif">
                                        <option value="Menunggu" {{ $item->status == 'Menunggu' ? 'selected' : '' }}>⏳ Menunggu</option>
                                        <option value="Diproses" {{ $item->status == 'Diproses' ? 'selected' : '' }}>⚙️ Diproses</option>
                                        <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>✅ Selesai</option>
                                    </select>
                                </form>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <!-- Tombol Berikan / Edit Tindak Lanjut -->
                                    <button type="button" 
                                            onclick='openTindakLanjutModal(@json($item))'
                                            class="px-2.5 py-1.5 rounded-lg bg-pemda-50 hover:bg-pemda-100 text-pemda-700 font-bold transition flex items-center space-x-1" 
                                            title="Beri Catatan Tindak Lanjut">
                                        <i class="fa-solid fa-file-pen text-xs"></i>
                                        <span>Tindak Lanjut</span>
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.aspirasi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pengaduan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-rose-500 hover:bg-rose-50 transition" title="Hapus Pengaduan">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-folder-open text-3xl mb-2 block"></i>
                                Belum ada laporan aspirasi dari warga yang cocok.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($aspirasis->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $aspirasis->links() }}
            </div>
            @endif
        </div>
    </main>

    <!-- Modal Form Tindak Lanjut Pengaduan -->
    <div id="tindakLanjutModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-pemda-600 text-white flex items-center justify-center">
                        <i class="fa-solid fa-clipboard-check text-xs"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">Tindak Lanjut Pengaduan</h3>
                        <p id="modal_pelapor" class="text-xs text-slate-500">Pelapor: -</p>
                    </div>
                </div>
                <button type="button" onclick="closeTindakLanjutModal()" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form id="tindakLanjutForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PATCH')

                <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200">
                    <span class="text-[11px] font-bold text-amber-600 uppercase block mb-1">Isi Pengaduan Warga:</span>
                    <p id="modal_pesan" class="text-xs text-slate-700 italic leading-relaxed"></p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Penanganan *</label>
                    <select id="modal_status" name="status" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none font-bold">
                        <option value="Menunggu">⏳ Menunggu</option>
                        <option value="Diproses">⚙️ Diproses (Sedang Dikerjakan/Dikoordinasikan)</option>
                        <option value="Selesai">✅ Selesai (Telah Ditangani Tuntas)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Tindak Lanjut / Respon Kecamatan *</label>
                    <textarea id="modal_tindak_lanjut" name="tindak_lanjut" rows="4" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none leading-relaxed" placeholder="Tuliskan tindakan yang telah atau sedang diambil oleh pihak kecamatan... Contoh: Tim Trantib telah meninjau lokasi dan berkoordinasi dengan dinas terkait..."></textarea>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end space-x-2">
                    <button type="button" onclick="closeTindakLanjutModal()" class="px-4 py-2 rounded-xl border border-slate-300 text-slate-600 text-xs font-bold hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-pemda-600 hover:bg-pemda-700 text-white text-xs font-bold shadow-md transition">
                        Simpan Tindak Lanjut
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
        function openTindakLanjutModal(item) {
            const form = document.getElementById('tindakLanjutForm');
            form.action = `/admin/aspirasi/${item.id}/tindak-lanjut`;

            document.getElementById('modal_pelapor').textContent = `Pelapor: ${item.nama} (${item.telepon}) - Kel. ${item.kelurahan}`;
            document.getElementById('modal_pesan').textContent = `"${item.pesan}"`;
            document.getElementById('modal_status').value = item.status || 'Diproses';
            document.getElementById('modal_tindak_lanjut').value = item.tindak_lanjut || '';

            const modal = document.getElementById('tindakLanjutModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeTindakLanjutModal() {
            const modal = document.getElementById('tindakLanjutModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeTindakLanjutModal();
            }
        });
    </script>
</body>
</html>
