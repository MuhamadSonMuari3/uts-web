<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelayanan Publik Online | Admin Kecamatan Alang-Alang Lebar</title>

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
                        <a href="{{ route('admin.pelayanan.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-pemda-50 text-pemda-700 border border-pemda-200 transition flex items-center space-x-2">
                            <i class="fa-solid fa-file-signature"></i>
                            <span>Pelayanan Publik</span>
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-600 hover:text-pemda-700 hover:bg-slate-100 transition flex items-center space-x-2">
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
            <a href="{{ route('admin.pelayanan.index') }}" class="flex-1 text-center py-2 text-xs font-bold rounded-lg bg-pemda-600 text-white">
                <i class="fa-solid fa-file-signature mr-1"></i> Pelayanan
            </a>
            <a href="{{ route('admin.dashboard') }}" class="flex-1 text-center py-2 text-xs font-bold rounded-lg text-slate-600 hover:bg-slate-200">
                <i class="fa-solid fa-clipboard-list mr-1"></i> Pengaduan
            </a>
            <a href="{{ route('admin.users.index') }}" class="flex-1 text-center py-2 text-xs font-bold rounded-lg text-slate-600 hover:bg-slate-200">
                <i class="fa-solid fa-users-gear mr-1"></i> Users
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

        <!-- Stat Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-2.5 mb-8">
            <div class="bg-white p-3 rounded-2xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Masuk</span>
                <span class="text-lg font-extrabold text-slate-900 mt-1 block">{{ $totalSemua }}</span>
            </div>

            <div class="bg-white p-3 rounded-2xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-blue-500 uppercase tracking-wider block">Diajukan</span>
                <span class="text-lg font-extrabold text-blue-600 mt-1 block">{{ $diajukan }}</span>
            </div>

            <div class="bg-white p-3 rounded-2xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-amber-500 uppercase tracking-wider block">Diverifikasi</span>
                <span class="text-lg font-extrabold text-amber-600 mt-1 block">{{ $diverifikasi }}</span>
            </div>

            <div class="bg-white p-3 rounded-2xl border border-purple-200 bg-purple-50/50 shadow-sm">
                <span class="text-[10px] font-bold text-purple-600 uppercase tracking-wider block">Menunggu TTD</span>
                <span class="text-lg font-extrabold text-purple-700 mt-1 block">{{ $menungguTtd }}</span>
            </div>

            <div class="bg-white p-3 rounded-2xl border border-indigo-200 bg-indigo-50/50 shadow-sm">
                <span class="text-[10px] font-bold text-indigo-700 uppercase tracking-wider block">TTD Camat Sah</span>
                <span class="text-lg font-extrabold text-indigo-800 mt-1 block">{{ $ditandatanganiCamat }}</span>
            </div>

            <div class="bg-white p-3 rounded-2xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Diproses</span>
                <span class="text-lg font-extrabold text-slate-700 mt-1 block">{{ $diproses }}</span>
            </div>

            <div class="bg-white p-3 rounded-2xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-emerald-500 uppercase tracking-wider block">Selesai</span>
                <span class="text-lg font-extrabold text-emerald-600 mt-1 block">{{ $selesai }}</span>
            </div>

            <div class="bg-white p-3 rounded-2xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-rose-500 uppercase tracking-wider block">Ditolak</span>
                <span class="text-lg font-extrabold text-rose-600 mt-1 block">{{ $ditolak }}</span>
            </div>
        </div>

        <!-- Table Permohonan Pelayanan -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900">Verifikasi Berkas & Pelayanan Administrasi Publik</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Periksa kelengkapan berkas KTP/KK, pengantar RT, dan berikan status verifikasi / dokumen hasil</p>
                </div>
            </div>

            <!-- Filter & Search Bar -->
            <div class="p-4 bg-slate-50/70 border-b border-slate-200">
                <form action="{{ route('admin.pelayanan.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tiket, nama pemohon, NIK, nomor telepon..." class="w-full pl-9 pr-4 py-2 bg-white rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none">
                    </div>

                    <div class="sm:w-40">
                        <select name="status" onchange="this.form.submit()" class="w-full py-2 px-3 bg-white rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="Diajukan" {{ request('status') == 'Diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="Diverifikasi" {{ request('status') == 'Diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                            <option value="Menunggu TTD Camat" {{ request('status') == 'Menunggu TTD Camat' ? 'selected' : '' }}>Menunggu TTD Camat</option>
                            <option value="Ditandatangani Camat" {{ request('status') == 'Ditandatangani Camat' ? 'selected' : '' }}>Ditandatangani Camat</option>
                            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
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
                        <a href="{{ route('admin.pelayanan.index') }}" class="px-3 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-semibold transition" title="Reset Filter">
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
                            <th class="py-3.5 px-4">Tiket & Pemohon</th>
                            <th class="py-3.5 px-4">Layanan & Keperluan</th>
                            <th class="py-3.5 px-4">Berkas yang Diunggah</th>
                            <th class="py-3.5 px-4">Status & Catatan</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-700">
                        @forelse($permohonans as $item)
                        <tr class="hover:bg-slate-50 transition">
                            <!-- Tiket & Pemohon -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <a href="{{ route('admin.pelayanan.show', $item->id) }}" class="font-mono font-bold text-pemda-700 hover:text-pemda-900 hover:underline block transition">{{ $item->nomor_tiket }}</a>
                                @if($item->status == 'Diajukan')
                                <span class="inline-flex items-center gap-1 text-[9px] font-extrabold text-blue-700 bg-blue-50 border border-blue-200 px-1.5 py-0.5 rounded-full mb-0.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse inline-block"></span> Perlu Diperiksa
                                </span>
                                @endif
                                <div class="font-extrabold text-slate-900 mt-0.5">{{ $item->nama_pemohon }}</div>
                                <div class="text-[11px] text-slate-500 mt-0.5">
                                    NIK: <span class="font-mono">{{ $item->nik_pemohon }}</span> • Kel. {{ $item->kelurahan }}
                                </div>
                                <div class="text-[10px] text-slate-400 mt-0.5">
                                    <i class="fa-brands fa-whatsapp text-emerald-500 mr-1"></i>{{ $item->telepon }} • {{ $item->created_at->format('d/m/Y H:i') }}
                                </div>
                            </td>

                            <!-- Layanan -->
                            <td class="py-4 px-4 max-w-xs">
                                <span class="font-bold text-slate-900 block text-xs">{{ $item->jenis_layanan }}</span>
                                @if($item->keterangan)
                                    <p class="text-slate-500 text-[11px] mt-1 line-clamp-2">"{{ $item->keterangan }}"</p>
                                @endif
                            </td>

                            <!-- Berkas Upload -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <div class="flex flex-col gap-1.5">
                                    @if($item->file_ktp_kk)
                                    <a href="{{ asset('storage/' . $item->file_ktp_kk) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-[11px] font-semibold flex items-center space-x-1">
                                        <i class="fa-solid fa-id-card text-rose-500"></i>
                                        <span>Lihat KTP/KK</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                    </a>
                                    @endif

                                    @if($item->file_pengantar_rt)
                                    <a href="{{ asset('storage/' . $item->file_pengantar_rt) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-[11px] font-semibold flex items-center space-x-1">
                                        <i class="fa-solid fa-file-signature text-amber-600"></i>
                                        <span>Lihat Pengantar RT</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                    </a>
                                    @endif

                                    @if($item->file_pendukung)
                                    <a href="{{ asset('storage/' . $item->file_pendukung) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-[11px] font-semibold flex items-center space-x-1">
                                        <i class="fa-solid fa-paperclip text-slate-500"></i>
                                        <span>Berkas Pendukung</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>

                            <!-- Status & Catatan -->
                            <td class="py-4 px-4 max-w-xs">
                                <div class="mb-1">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold inline-block 
                                        @if($item->status == 'Diajukan') bg-blue-100 text-blue-800
                                        @elseif($item->status == 'Diverifikasi') bg-amber-100 text-amber-800
                                        @elseif($item->status == 'Menunggu TTD Camat') bg-purple-100 text-purple-800 border border-purple-200
                                        @elseif($item->status == 'Ditandatangani Camat') bg-indigo-100 text-indigo-900 border border-indigo-200
                                        @elseif($item->status == 'Diproses') bg-slate-100 text-slate-800
                                        @elseif($item->status == 'Selesai') bg-emerald-100 text-emerald-800
                                        @else bg-rose-100 text-rose-800 @endif">
                                        {{ $item->status }}
                                    </span>
                                </div>
                                @if($item->ttd_camat)
                                    <span class="text-[10px] text-purple-700 font-bold block"><i class="fa-solid fa-signature mr-1"></i>TTD Digital Camat Sah</span>
                                @elseif($item->paraf_sekcam)
                                    <span class="text-[10px] text-indigo-600 font-semibold block"><i class="fa-solid fa-check mr-1"></i>Diparaf Sekcam</span>
                                @endif
                                @if($item->catatan_petugas)
                                    <p class="text-[11px] text-slate-600 line-clamp-2 italic">{{ $item->catatan_petugas }}</p>
                                @endif
                                @if($item->file_hasil)
                                    <span class="text-[10px] text-emerald-600 font-bold block mt-1"><i class="fa-solid fa-check-double mr-1"></i>Dokumen Hasil Terbit</span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <!-- Tombol Detail & Verifikasi Berkas (Halaman Baru) -->
                                    <a href="{{ route('admin.pelayanan.show', $item->id) }}"
                                       class="px-2.5 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-bold transition flex items-center space-x-1"
                                       title="Buka Halaman Verifikasi Berkas">
                                        <i class="fa-solid fa-folder-open text-xs"></i>
                                        <span>Verifikasi</span>
                                    </a>

                                    <!-- Tombol Proses Cepat (Modal) -->
                                    <button type="button" 
                                            onclick='openProsesModal(@json($item))'
                                            class="px-2.5 py-1.5 rounded-lg bg-pemda-600 hover:bg-pemda-700 text-white font-bold transition flex items-center space-x-1" 
                                            title="Update Status Cepat">
                                        <i class="fa-solid fa-bolt text-xs"></i>
                                        <span>Cepat</span>
                                    </button>

                                    <form action="{{ route('admin.pelayanan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data permohonan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-rose-500 hover:bg-rose-50 transition" title="Hapus Pengajuan">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-folder-open text-3xl mb-2 block"></i>
                                Belum ada berkas permohonan pelayanan publik yang masuk.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($permohonans->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $permohonans->links() }}
            </div>
            @endif
        </div>
    </main>

    <!-- MODAL PROSES & VERIFIKASI BERKAS ADMIN -->
    <div id="prosesModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-pemda-600 text-white flex items-center justify-center">
                        <i class="fa-solid fa-file-circle-check text-xs"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">Proses & Verifikasi Permohonan</h3>
                        <p id="modal_tiket_label" class="text-xs text-slate-500">Tiket: -</p>
                    </div>
                </div>
                <button type="button" onclick="closeProsesModal()" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form id="prosesForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                @method('PATCH')

                <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200 text-xs">
                    <div class="font-bold text-slate-800" id="modal_layanan_label">-</div>
                    <div class="text-slate-500 mt-0.5" id="modal_pemohon_label">-</div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Penanganan *</label>
                    <select id="modal_status" name="status" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none font-bold">
                        <option value="Diajukan">Diajukan (Belum Diperiksa)</option>
                        <option value="Diverifikasi">Diverifikasi (Berkas Lengkap & Sah)</option>
                        <option value="Diproses">Diproses (Sedang Pengetikan/Tanda Tangan Camat)</option>
                        <option value="Selesai">Selesai (Surat Selesai / Terbit)</option>
                        <option value="Ditolak">Ditolak (Berkas Tidak Sesuai / Buram / Syarat Kurang)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Verifikator / Petugas Kecamatan</label>
                    <textarea id="modal_catatan" name="catatan_petugas" rows="3" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none" placeholder="Tuliskan catatan untuk warga (cth: Berkas telah diverifikasi, silakan unduh dokumen hasil di bawah atau ambil berkas fisik di loket)..."></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Upload File Hasil / Surat Resmi (Opsional)</label>
                    <input type="file" name="file_hasil" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-pemda-600 file:text-white hover:file:bg-pemda-700 cursor-pointer">
                    <span class="text-[10px] text-slate-400">Unggah file surat tanda tangan elektronik / scan surat jadi untuk dapat diunduh pemohon (PDF/JPG, maks 5MB)</span>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end space-x-2">
                    <button type="button" onclick="closeProsesModal()" class="px-4 py-2 rounded-xl border border-slate-300 text-slate-600 text-xs font-bold hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-pemda-600 hover:bg-pemda-700 text-white text-xs font-bold shadow-md transition">
                        Simpan & Kirim Status
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
        function openProsesModal(item) {
            const form = document.getElementById('prosesForm');
            form.action = `/admin/pelayanan/${item.id}/status`;

            document.getElementById('modal_tiket_label').textContent = `Tiket: ${item.nomor_tiket}`;
            document.getElementById('modal_layanan_label').textContent = item.jenis_layanan;
            document.getElementById('modal_pemohon_label').textContent = `Pemohon: ${item.nama_pemohon} (${item.telepon}) - Kel. ${item.kelurahan}`;
            document.getElementById('modal_status').value = item.status;
            document.getElementById('modal_catatan').value = item.catatan_petugas || '';

            const m = document.getElementById('prosesModal');
            m.classList.remove('hidden');
            m.classList.add('flex');
        }

        function closeProsesModal() {
            const m = document.getElementById('prosesModal');
            m.classList.add('hidden');
            m.classList.remove('flex');
        }

        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeProsesModal();
            }
        });
    </script>
</body>
</html>
