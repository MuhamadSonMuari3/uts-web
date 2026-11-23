<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Warga | Portal Pelayanan Kecamatan Alang-Alang Lebar</title>

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

    <!-- Top Citizen Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Brand & Portal Name -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('kecamatan.home') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-pemda-600 flex items-center justify-center text-white shadow-md">
                            <i class="fa-solid fa-landmark text-lg"></i>
                        </div>
                        <div>
                            <span class="block text-sm font-extrabold text-slate-900 leading-none">PORTAL PELAYANAN WARGA</span>
                            <span class="block text-[11px] font-semibold text-amber-600 mt-0.5">Kecamatan Alang-Alang Lebar</span>
                        </div>
                    </a>
                </div>

                <!-- Right profile & logout -->
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <a href="{{ route('kecamatan.home') }}" class="px-3 py-1.5 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 text-xs font-semibold flex items-center space-x-1.5 transition">
                        <i class="fa-solid fa-house text-[11px]"></i>
                        <span class="hidden sm:inline">Beranda Web</span>
                    </a>

                    <div class="hidden sm:flex items-center space-x-2 text-xs text-slate-600 border-l border-slate-200 pl-4">
                        <div class="w-8 h-8 rounded-full bg-pemda-100 text-pemda-700 flex items-center justify-center font-extrabold text-xs">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <span class="font-bold text-slate-800 block leading-tight">{{ $user->name }}</span>
                            <span class="text-[10px] text-slate-400">Kel. {{ $user->kelurahan ?? 'AAL' }}</span>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-3.5 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition shadow-sm flex items-center space-x-1.5">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
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

        @if($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
            <div class="flex items-center space-x-2 font-bold text-xs uppercase mb-1">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>Terdapat kesalahan saat memproses data/file:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-pemda-800 via-pemda-700 to-emerald-800 rounded-3xl p-6 sm:p-8 text-white shadow-lg mb-8 relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold uppercase bg-white/20 text-white mb-2">
                        <i class="fa-solid fa-id-card mr-1"></i> Data Pemohon Terverifikasi
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ $user->name }}!</h1>
                    <p class="text-xs sm:text-sm text-emerald-100 mt-1 max-w-xl">
                        Ajukan berkas pelayanan administrasi secara online, unggah dokumen persyaratan, dan pantau proses verifikasi dari Kantor Camat Alang-Alang Lebar tanpa perlu antre lama.
                    </p>
                </div>
                <div class="flex flex-wrap gap-2.5">
                    <button onclick="openLayananModal()" class="px-5 py-3 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-900 font-extrabold text-xs shadow-md transition flex items-center space-x-2">
                        <i class="fa-solid fa-file-circle-plus text-sm"></i>
                        <span>Ajukan Pelayanan Online</span>
                    </button>
                    <button onclick="openPengaduanModal()" class="px-4 py-3 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs border border-white/20 transition flex items-center space-x-2">
                        <i class="fa-solid fa-bullhorn"></i>
                        <span>Kirim Aspirasi</span>
                    </button>
                    <button onclick="openProfileModal()" class="px-3.5 py-3 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs border border-white/20 transition" title="Edit Profil">
                        <i class="fa-solid fa-user-pen"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Quick Stats Permohonan Pelayanan -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Layanan Diajukan</span>
                    <span class="text-2xl font-extrabold text-slate-900 mt-1 block">{{ $totalLayanan }}</span>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-amber-500 uppercase tracking-wider block">Verifikasi Berkas</span>
                    <span class="text-2xl font-extrabold text-amber-600 mt-1 block">{{ $layananMenunggu }}</span>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-indigo-500 uppercase tracking-wider block">Sedang Diproses</span>
                    <span class="text-2xl font-extrabold text-indigo-600 mt-1 block">{{ $layananDiproses }}</span>
                </div>
                <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-spinner"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-emerald-500 uppercase tracking-wider block">Selesai / Terbit</span>
                    <span class="text-2xl font-extrabold text-emerald-600 mt-1 block">{{ $layananSelesai }}</span>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
        </div>

        <!-- Section: PROSES PELAYANAN PUBLIK ONLINE (UTAMA) -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            <div class="p-6 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center space-x-2">
                        <span class="px-2.5 py-0.5 rounded-md text-[10px] font-extrabold uppercase bg-emerald-100 text-emerald-800">Pelayanan Aktif</span>
                        <h2 class="text-lg font-extrabold text-slate-900">Proses & Riwayat Pelayanan Publik Anda</h2>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">Pantau status berkas, catatan verifikator kecamatan, dan unduh dokumen hasil pengajuan</p>
                </div>
                <div>
                    <button onclick="openLayananModal()" class="px-4 py-2.5 rounded-xl bg-pemda-600 hover:bg-pemda-700 text-white text-xs font-bold transition shadow-sm flex items-center space-x-2">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <span>+ Ajukan Permohonan Baru</span>
                    </button>
                </div>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($permohonanPelayanan as $itemLayanan)
                <div class="p-6 hover:bg-slate-50/50 transition">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4">
                        <div>
                            <div class="flex items-center space-x-2.5">
                                <span class="font-mono text-xs font-extrabold text-pemda-700 bg-pemda-50 px-2.5 py-1 rounded-lg border border-pemda-200">
                                    {{ $itemLayanan->nomor_tiket }}
                                </span>
                                <h3 class="font-extrabold text-slate-900 text-sm sm:text-base">{{ $itemLayanan->jenis_layanan }}</h3>
                            </div>
                            <span class="text-[11px] text-slate-400 mt-1 block">
                                Diajukan pada: {{ $itemLayanan->created_at->format('d M Y, H:i') }} WIB • Kelurahan {{ $itemLayanan->kelurahan }}
                            </span>
                        </div>

                        <!-- Status Badge -->
                        <div>
                            @if($itemLayanan->status === 'Diajukan')
                                <span class="px-3 py-1.5 rounded-full text-xs font-extrabold bg-blue-50 text-blue-700 border border-blue-200 inline-flex items-center">
                                    <i class="fa-solid fa-paper-plane mr-1.5 text-[10px]"></i> Berkas Diajukan
                                </span>
                            @elseif($itemLayanan->status === 'Diverifikasi')
                                <span class="px-3 py-1.5 rounded-full text-xs font-extrabold bg-amber-50 text-amber-700 border border-amber-200 inline-flex items-center">
                                    <i class="fa-solid fa-file-circle-check mr-1.5 text-[10px]"></i> Berkas Diverifikasi
                                </span>
                            @elseif($itemLayanan->status === 'Menunggu TTD Camat')
                                <span class="px-3 py-1.5 rounded-full text-xs font-extrabold bg-purple-50 text-purple-700 border border-purple-200 inline-flex items-center">
                                    <i class="fa-solid fa-signature mr-1.5 text-[10px]"></i> Menunggu TTD Camat
                                </span>
                            @elseif($itemLayanan->status === 'Ditandatangani Camat')
                                <span class="px-3 py-1.5 rounded-full text-xs font-extrabold bg-indigo-50 text-indigo-800 border border-indigo-200 inline-flex items-center">
                                    <i class="fa-solid fa-stamp mr-1.5 text-[10px]"></i> Ditandatangani Camat (Siap Cetak / Diterbitkan)
                                </span>
                            @elseif($itemLayanan->status === 'Diproses')
                                <span class="px-3 py-1.5 rounded-full text-xs font-extrabold bg-slate-100 text-slate-700 border border-slate-300 inline-flex items-center">
                                    <i class="fa-solid fa-spinner mr-1.5 text-[10px] animate-spin"></i> Sedang Diproses Petugas
                                </span>
                            @elseif($itemLayanan->status === 'Selesai')
                                <span class="px-3 py-1.5 rounded-full text-xs font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200 inline-flex items-center">
                                    <i class="fa-solid fa-circle-check mr-1.5 text-[10px]"></i> Layanan Selesai
                                </span>
                            @elseif($itemLayanan->status === 'Ditolak')
                                <span class="px-3 py-1.5 rounded-full text-xs font-extrabold bg-rose-50 text-rose-700 border border-rose-200 inline-flex items-center">
                                    <i class="fa-solid fa-circle-xmark mr-1.5 text-[10px]"></i> Permohonan Ditolak
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Keterangan / Keperluan Pemohon -->
                    @if($itemLayanan->keterangan)
                    <div class="mb-4 text-xs text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <span class="font-bold text-slate-700 block mb-0.5">Catatan/Keperluan Pemohon:</span>
                        {{ $itemLayanan->keterangan }}
                    </div>
                    @endif

                    <!-- Dokumen Persyaratan yang Diunggah -->
                    <div class="mb-4">
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-2">Berkas Persyaratan yang Diunggah:</span>
                        <div class="flex flex-wrap gap-2.5">
                            @if($itemLayanan->file_ktp_kk)
                            <a href="{{ asset('storage/' . $itemLayanan->file_ktp_kk) }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold flex items-center space-x-1.5 border border-slate-200 transition">
                                <i class="fa-solid fa-file-pdf text-rose-500"></i>
                                <span>Scan KTP / KK</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[9px] text-slate-400 ml-1"></i>
                            </a>
                            @endif

                            @if($itemLayanan->file_pengantar_rt)
                            <a href="{{ asset('storage/' . $itemLayanan->file_pengantar_rt) }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold flex items-center space-x-1.5 border border-slate-200 transition">
                                <i class="fa-solid fa-file-lines text-amber-600"></i>
                                <span>Surat Pengantar RT/RW</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[9px] text-slate-400 ml-1"></i>
                            </a>
                            @endif

                            @if($itemLayanan->file_pendukung)
                            <a href="{{ asset('storage/' . $itemLayanan->file_pendukung) }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold flex items-center space-x-1.5 border border-slate-200 transition">
                                <i class="fa-solid fa-paperclip text-blue-500"></i>
                                <span>Dokumen Pendukung</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[9px] text-slate-400 ml-1"></i>
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Respon & Catatan Petugas Kecamatan -->
                    @if($itemLayanan->catatan_petugas || $itemLayanan->file_hasil)
                    <div class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200 text-xs">
                        <div class="flex items-center justify-between text-emerald-800 font-extrabold mb-1.5">
                            <span class="flex items-center">
                                <i class="fa-solid fa-building-columns mr-1.5"></i> Tindak Lanjut Petugas Kecamatan:
                            </span>
                            @if($itemLayanan->selesai_pada)
                                <span class="text-[10px] font-semibold text-emerald-600">
                                    Diselesaikan: {{ $itemLayanan->selesai_pada->format('d/m/Y H:i') }}
                                </span>
                            @endif
                        </div>
                        @if($itemLayanan->catatan_petugas)
                        <p class="text-emerald-900 leading-relaxed mb-2">{{ $itemLayanan->catatan_petugas }}</p>
                        @endif

                        @if($itemLayanan->ttd_camat)
                        <div class="my-2 p-2 bg-purple-50 border border-purple-200 rounded-xl flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-signature text-purple-700 text-sm"></i>
                                <div>
                                    <span class="text-[11px] font-extrabold text-purple-900 block">Tanda Tangan Digital Camat Sah</span>
                                    <span class="text-[10px] text-purple-700">Telah ditandatangani secara digital oleh Camat Alang-Alang Lebar</span>
                                </div>
                            </div>
                            <span class="text-[9px] font-extrabold bg-purple-200 text-purple-800 px-2 py-0.5 rounded-full uppercase">Terverifikasi</span>
                        </div>
                        @elseif($itemLayanan->paraf_sekcam)
                        <div class="my-2 p-2 bg-indigo-50 border border-indigo-200 rounded-xl flex items-center space-x-2 text-[10px] text-indigo-800 font-semibold">
                            <i class="fa-solid fa-check text-indigo-600"></i>
                            <span>Telah diverifikasi & diparaf oleh Sekretaris Camat</span>
                        </div>
                        @endif

                        @if($itemLayanan->file_hasil)
                        <div class="pt-2 border-t border-emerald-200 flex items-center justify-between">
                            <span class="text-emerald-800 font-bold text-[11px]">Dokumen Hasil Pelayanan:</span>
                            <a href="{{ asset('storage/' . $itemLayanan->file_hasil) }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[11px] shadow-sm flex items-center space-x-1 transition">
                                <i class="fa-solid fa-file-arrow-down"></i>
                                <span>Unduh Dokumen Hasil</span>
                            </a>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
                @empty
                <div class="p-12 text-center text-slate-400">
                    <div class="w-16 h-16 mx-auto rounded-2xl bg-slate-100 flex items-center justify-center text-3xl text-slate-400 mb-3">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-700">Belum Ada Pengajuan Pelayanan</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                        Anda belum mengajukan permohonan administrasi publik online. Klik tombol di bawah untuk mulai mengajukan dengan mengunggah berkas persyaratan.
                    </p>
                    <button onclick="openLayananModal()" class="mt-4 px-5 py-2.5 rounded-xl bg-pemda-600 hover:bg-pemda-700 text-white text-xs font-bold transition shadow-sm">
                        <i class="fa-solid fa-file-circle-plus mr-1"></i> Ajukan Pelayanan Sekarang
                    </button>
                </div>
                @endforelse
            </div>

            @if($permohonanPelayanan->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $permohonanPelayanan->appends(['aspirasi_page' => request('aspirasi_page')])->links() }}
            </div>
            @endif
        </div>

        <!-- Grid 2 Bagian: Aspirasi Pengaduan & Informasi Profil -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left 2 Cols: Riwayat Pengaduan & Aspirasi Warga -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-200 flex items-center justify-between">
                        <div>
                            <h2 class="text-base font-extrabold text-slate-900">Pengaduan & Aspirasi Lingkungan</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Keluhan jalan rusak, sampah, dan ketertiban lingkungan</p>
                        </div>
                        <button onclick="openPengaduanModal()" class="px-3.5 py-2 rounded-xl bg-amber-50 text-amber-800 hover:bg-amber-100 text-xs font-bold transition flex items-center space-x-1.5">
                            <i class="fa-solid fa-bullhorn text-xs"></i>
                            <span>Buat Pengaduan</span>
                        </button>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @forelse($aspirasis as $item)
                        <div class="p-6 hover:bg-slate-50/60 transition">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                                <div class="flex items-center space-x-2">
                                    <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                        <i class="fa-solid fa-tag text-[9px] mr-1 text-slate-400"></i>{{ $item->kategori }}
                                    </span>
                                    <span class="text-xs text-slate-400">• {{ $item->created_at->format('d M Y, H:i') }} WIB</span>
                                </div>
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold inline-flex items-center 
                                    @if($item->status == 'Menunggu') bg-amber-50 text-amber-700 border border-amber-200
                                    @elseif($item->status == 'Diproses') bg-indigo-50 text-indigo-700 border border-indigo-200
                                    @else bg-emerald-50 text-emerald-700 border border-emerald-200 @endif">
                                    {{ $item->status }}
                                </span>
                            </div>

                            <p class="text-xs text-slate-700 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-100 mb-3">
                                "{{ $item->pesan }}"
                            </p>

                            @if($item->tindak_lanjut)
                            <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-900">
                                <div class="font-bold text-emerald-800 mb-1 flex items-center">
                                    <i class="fa-solid fa-reply mr-1.5"></i> Respon Kecamatan:
                                </div>
                                <p>{{ $item->tindak_lanjut }}</p>
                            </div>
                            @endif
                        </div>
                        @empty
                        <div class="p-8 text-center text-slate-400 text-xs">
                            Belum ada laporan aspirasi dari Anda.
                        </div>
                        @endforelse
                    </div>

                    @if($aspirasis->hasPages())
                    <div class="p-4 border-t border-slate-200">
                        {{ $aspirasis->appends(['layanan_page' => request('layanan_page')])->links() }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Col: Profil Warga & Syarat Berkas -->
            <div class="space-y-6">
                <!-- Data Profil Card -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <div class="flex items-center space-x-2.5">
                            <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-sm font-bold">
                                <i class="fa-solid fa-address-card"></i>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-slate-900 text-sm">Profil Kependudukan</h3>
                                <span class="text-[10px] text-emerald-600 font-bold uppercase"><i class="fa-solid fa-circle-check mr-1"></i>Warga Terdaftar</span>
                            </div>
                        </div>
                        <button onclick="openProfileModal()" class="text-pemda-700 hover:text-pemda-800 text-xs font-bold">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </button>
                    </div>

                    <div class="py-4 space-y-3.5 text-xs">
                        <div>
                            <span class="text-[11px] text-slate-400 block font-medium">Nomor Induk Kependudukan (NIK)</span>
                            <span class="font-mono font-bold text-slate-900 text-sm tracking-wide">{{ $user->nik ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-[11px] text-slate-400 block font-medium">Nama Lengkap</span>
                            <span class="font-bold text-slate-800">{{ $user->name }}</span>
                        </div>
                        <div>
                            <span class="text-[11px] text-slate-400 block font-medium">Email & Nomor WhatsApp</span>
                            <span class="text-slate-700 block">{{ $user->email }}</span>
                            <span class="text-slate-700 block font-semibold">{{ $user->telepon ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-[11px] text-slate-400 block font-medium">Kelurahan & Alamat Domisili</span>
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-pemda-50 text-pemda-700 border border-pemda-200 mb-1">
                                Kel. {{ $user->kelurahan ?? 'Alang-Alang Lebar' }}
                            </span>
                            <p class="text-slate-600 leading-relaxed">{{ $user->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Info Panduan Berkas -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-6 text-white shadow-sm">
                    <div class="flex items-center space-x-2 text-amber-400 mb-2">
                        <i class="fa-solid fa-circle-info text-sm"></i>
                        <span class="text-xs font-bold uppercase tracking-wider">Petunjuk Berkas</span>
                    </div>
                    <h4 class="font-bold text-sm">Ketentuan Unggah Dokumen</h4>
                    <ul class="text-[11px] text-slate-300 mt-2 space-y-1.5 list-disc list-inside leading-relaxed">
                        <li>Format dokumen: <b>PDF, JPG, JPEG, atau PNG</b>.</li>
                        <li>Ukuran masing-masing file maksimal <b>5 MB</b>.</li>
                        <li>Pastikan foto/scan berkas jelas, tidak buram, dan tulisan terbaca sempurna.</li>
                        <li>Surat Pengantar RT/RW wajib berstempel resmi dari Ketua RT/RW setempat.</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <!-- MODAL FORM PENGAJUAN PELAYANAN PUBLIK & UPLOAD BERKAS -->
    <div id="layananModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-xl w-full shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200 max-h-[90vh] flex flex-col">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-pemda-600 text-white flex items-center justify-center">
                        <i class="fa-solid fa-file-circle-plus text-xs"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">Formulir Pelayanan Publik Online</h3>
                        <p class="text-xs text-slate-500">Lengkapi data dan unggah berkas persyaratan yang diperlukan</p>
                    </div>
                </div>
                <button type="button" onclick="closeLayananModal()" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('warga.layanan.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 overflow-y-auto flex-1">
                @csrf
                
                <!-- Info Otomatis Pemohon -->
                <div class="p-3 bg-emerald-50 rounded-2xl border border-emerald-100 text-xs text-emerald-800 flex items-center justify-between">
                    <div>
                        <span class="font-bold block">Pemohon: {{ $user->name }} (NIK: {{ $user->nik ?? '-' }})</span>
                        <span class="text-[11px] text-emerald-700">Kel. {{ $user->kelurahan ?? 'AAL' }} • Telp: {{ $user->telepon ?? '-' }}</span>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-200 text-emerald-900">Otomatis Terverifikasi</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Layanan Administrasi *</label>
                    <select name="jenis_layanan" required class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none font-bold text-slate-800">
                        <option value="">-- Pilih Layanan yang Diajukan --</option>
                        <option value="Perekaman & Pengurusan KTP-el / KK">Perekaman & Pengurusan KTP-el / Kartu Keluarga</option>
                        <option value="Surat Keterangan Pindah Domisili">Surat Keterangan Pindah Domisili (SKPWNI)</option>
                        <option value="Surat Keterangan Catatan Kepolisian (Pengantar SKCK)">Surat Keterangan Catatan Kepolisian (Pengantar SKCK)</option>
                        <option value="Surat Keterangan Tidak Mampu (SKTM) Pendidikan/Kesehatan">Surat Keterangan Tidak Mampu (SKTM) Pendidikan/Kesehatan</option>
                        <option value="Rekomendasi / Dispensasi Nikah">Rekomendasi / Dispensasi Nikah (N1-N4)</option>
                        <option value="Surat Keterangan Usaha (SKU) Mikro">Surat Keterangan Usaha (SKU) Mikro</option>
                        <option value="Pelayanan Administrasi Umum Lainnya">Pelayanan Administrasi Umum Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Keterangan / Keperluan Dokumen</label>
                    <textarea name="keterangan" rows="2" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none" placeholder="Tuliskan keperluan khusus (cth: Penggantian KK karena penambahan anggota keluarga baru)..."></textarea>
                </div>

                <!-- Bagian Upload Berkas -->
                <div class="border-t border-slate-200 pt-3">
                    <span class="text-xs font-extrabold text-slate-900 block mb-1">Unggah Dokumen Berkas Persyaratan</span>
                    <p class="text-[11px] text-slate-500 mb-3">Maksimal 5 MB per file (PDF, JPG, JPEG, PNG)</p>

                    <div class="space-y-3">
                        <!-- File 1: KTP / KK -->
                        <div class="p-3 rounded-2xl border border-dashed border-slate-300 hover:border-pemda-500 transition bg-slate-50/50">
                            <label class="block text-xs font-bold text-slate-800 mb-1 flex items-center justify-between">
                                <span><i class="fa-solid fa-id-card text-pemda-600 mr-1.5"></i> Scan/Foto KTP atau KK Asli *</span>
                                <span class="text-[10px] text-rose-600 font-semibold">Wajib Diunggah</span>
                            </label>
                            <input type="file" name="file_ktp_kk" required accept=".pdf,.jpg,.jpeg,.png" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-pemda-600 file:text-white hover:file:bg-pemda-700 cursor-pointer">
                        </div>

                        <!-- File 2: Surat Pengantar RT/RW -->
                        <div class="p-3 rounded-2xl border border-dashed border-slate-300 hover:border-pemda-500 transition bg-slate-50/50">
                            <label class="block text-xs font-bold text-slate-800 mb-1 flex items-center justify-between">
                                <span><i class="fa-solid fa-file-signature text-amber-600 mr-1.5"></i> Scan/Foto Surat Pengantar RT / RW *</span>
                                <span class="text-[10px] text-rose-600 font-semibold">Wajib Diunggah</span>
                            </label>
                            <input type="file" name="file_pengantar_rt" required accept=".pdf,.jpg,.jpeg,.png" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-amber-600 file:text-white hover:file:bg-amber-700 cursor-pointer">
                        </div>

                        <!-- File 3: Berkas Pendukung (Opsional) -->
                        <div class="p-3 rounded-2xl border border-dashed border-slate-300 hover:border-pemda-500 transition bg-slate-50/50">
                            <label class="block text-xs font-bold text-slate-800 mb-1 flex items-center justify-between">
                                <span><i class="fa-solid fa-paperclip text-blue-600 mr-1.5"></i> Dokumen Pendukung Lainnya (Akta Kelahiran, Ijazah, Buku Nikah, dll)</span>
                                <span class="text-[10px] text-slate-400 font-semibold">Opsional</span>
                            </label>
                            <input type="file" name="file_pendukung" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-700 file:text-white hover:file:bg-slate-800 cursor-pointer">
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end space-x-2">
                    <button type="button" onclick="closeLayananModal()" class="px-4 py-2 rounded-xl border border-slate-300 text-slate-600 text-xs font-bold hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-pemda-600 hover:bg-pemda-700 text-white text-xs font-bold shadow-md transition flex items-center space-x-1.5">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <span>Kirim Permohonan & Berkas</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL FORM BUAT PENGADUAN LINGKUNGAN / ASPIRASI -->
    <div id="pengaduanModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center">
                        <i class="fa-solid fa-bullhorn text-xs"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-900 text-base">Buat Laporan / Pengaduan Baru</h3>
                </div>
                <button type="button" onclick="closePengaduanModal()" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('warga.aspirasi.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Pengaduan *</label>
                    <select name="kategori" required class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none">
                        <option value="Pelayanan Administrasi KTP/KK">Pelayanan Administrasi KTP/KK</option>
                        <option value="Infrastruktur & Jalan Rusak">Infrastruktur & Jalan Rusak</option>
                        <option value="Drainase & Kebersihan Sampah">Drainase & Kebersihan Sampah</option>
                        <option value="Ketertiban & Keamanan">Ketertiban & Keamanan Lingkungan</option>
                        <option value="Lainnya">Saran / Aspirasi Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Rincian Laporan / Aspirasi *</label>
                    <textarea name="pesan" rows="4" required class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none leading-relaxed" placeholder="Tuliskan lokasi kejadian (RT/RW, nama jalan) dan detail keluhan secara jelas..."></textarea>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end space-x-2">
                    <button type="button" onclick="closePengaduanModal()" class="px-4 py-2 rounded-xl border border-slate-300 text-slate-600 text-xs font-bold hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold shadow-md transition">
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL FORM EDIT PROFIL -->
    <div id="profileModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-pemda-600 text-white flex items-center justify-center">
                        <i class="fa-solid fa-user-pen text-xs"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-900 text-base">Perbarui Profil Anda</h3>
                </div>
                <button type="button" onclick="closeProfileModal()" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('warga.profile.update') }}" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">NIK (KTP)</label>
                    <input type="text" value="{{ $user->nik ?? '-' }}" disabled class="w-full px-3 py-2 rounded-xl bg-slate-100 border border-slate-200 text-xs text-slate-500 font-mono cursor-not-allowed">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                        <input type="text" name="name" required value="{{ old('name', $user->name) }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email *</label>
                        <input type="email" name="email" required value="{{ old('email', $user->email) }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">No. WhatsApp / HP *</label>
                        <input type="text" name="telepon" required value="{{ old('telepon', $user->telepon) }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kelurahan Domisili *</label>
                        <select name="kelurahan" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none font-bold">
                            <option value="Alang-Alang Lebar" {{ $user->kelurahan == 'Alang-Alang Lebar' ? 'selected' : '' }}>Alang-Alang Lebar</option>
                            <option value="Talang Kelapa" {{ $user->kelurahan == 'Talang Kelapa' ? 'selected' : '' }}>Talang Kelapa</option>
                            <option value="Karya Baru" {{ $user->kelurahan == 'Karya Baru' ? 'selected' : '' }}>Karya Baru</option>
                            <option value="Srijaya" {{ $user->kelurahan == 'Srijaya' ? 'selected' : '' }}>Srijaya</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Domisili Lengkap *</label>
                    <textarea name="alamat" rows="2" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none">{{ old('alamat', $user->alamat) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Ganti Password (Opsional)</label>
                    <input type="password" name="password" minlength="6" placeholder="Kosongkan jika tidak ingin ganti password" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none">
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end space-x-2">
                    <button type="button" onclick="closeProfileModal()" class="px-4 py-2 rounded-xl border border-slate-300 text-slate-600 text-xs font-bold hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-pemda-600 hover:bg-pemda-700 text-white text-xs font-bold shadow-md transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer Warga -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-500 mt-auto">
        &copy; {{ date('Y') }} Kantor Camat Alang-Alang Lebar Palembang • Portal Pelayanan Masyarakat
    </footer>

    <script>
        function openLayananModal() {
            const m = document.getElementById('layananModal');
            m.classList.remove('hidden');
            m.classList.add('flex');
        }
        function closeLayananModal() {
            const m = document.getElementById('layananModal');
            m.classList.add('hidden');
            m.classList.remove('flex');
        }

        function openPengaduanModal() {
            const m = document.getElementById('pengaduanModal');
            m.classList.remove('hidden');
            m.classList.add('flex');
        }
        function closePengaduanModal() {
            const m = document.getElementById('pengaduanModal');
            m.classList.add('hidden');
            m.classList.remove('flex');
        }

        function openProfileModal() {
            const m = document.getElementById('profileModal');
            m.classList.remove('hidden');
            m.classList.add('flex');
        }
        function closeProfileModal() {
            const m = document.getElementById('profileModal');
            m.classList.add('hidden');
            m.classList.remove('flex');
        }

        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLayananModal();
                closePengaduanModal();
                closeProfileModal();
            }
        });
    </script>
</body>
</html>
