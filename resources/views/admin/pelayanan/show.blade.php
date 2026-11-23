<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Berkas #{{ $permohonan->nomor_tiket }} | Admin Kecamatan Alang-Alang Lebar</title>
    <meta name="description" content="Halaman verifikasi berkas pengajuan pelayanan publik oleh admin kecamatan.">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        pemda: {
                            50:  '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#16a34a',
                            600: '#15803d',
                            700: '#166534',
                            800: '#14532d',
                            900: '#052e16'
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.4s ease-out',
                        'slide-up': 'slideUp 0.4s ease-out',
                    },
                    keyframes: {
                        fadeIn: { from: { opacity: '0' }, to: { opacity: '1' } },
                        slideUp: { from: { opacity: '0', transform: 'translateY(16px)' }, to: { opacity: '1', transform: 'translateY(0)' } },
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255,255,255,0.85); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
        .berkas-preview-img { transition: transform 0.3s ease; }
        .berkas-preview-img:hover { transform: scale(1.02); }
        .status-timeline-dot { position: relative; }
        .status-timeline-dot::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 100%;
            transform: translateX(-50%);
            width: 2px;
            height: 24px;
            background: #e2e8f0;
        }
        .status-timeline-dot:last-child::before { display: none; }
        /* Custom scrollbar for modal */
        .modal-scroll::-webkit-scrollbar { width: 6px; }
        .modal-scroll::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 3px; }
        .modal-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        /* Checklist toggle animation */
        .checklist-item input[type="checkbox"]:checked + .checklist-label {
            text-decoration: line-through;
            color: #64748b;
        }
        .checklist-item input[type="checkbox"]:checked + .checklist-label .check-icon {
            background: #16a34a;
            border-color: #16a34a;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-200 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- ===== TOP ADMIN NAVBAR ===== -->
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

                <!-- Right: logout -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.pelayanan.index') }}" class="px-3 py-1.5 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 text-xs font-semibold flex items-center space-x-1.5 transition">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i>
                        <span>Kembali ke Daftar</span>
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

    <!-- ===== MAIN CONTENT ===== -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in">

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
        <div id="alert-err" class="mb-6 p-4 rounded-2xl bg-rose-700 text-white shadow-md flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i class="fa-solid fa-triangle-exclamation text-xl text-rose-300"></i>
                <span class="text-xs sm:text-sm font-medium">{{ session('error') }}</span>
            </div>
            <button onclick="document.getElementById('alert-err').remove()" class="text-rose-200 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
        </div>
        @endif

        <!-- ===== PAGE HEADER ===== -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('admin.pelayanan.index') }}" class="text-xs text-slate-400 hover:text-pemda-700 transition font-medium">Pelayanan Publik</a>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-300"></i>
                    <span class="text-xs font-bold text-pemda-700">Verifikasi Berkas</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-pemda-600 flex items-center justify-center text-white text-base shadow-md flex-shrink-0">
                        <i class="fa-solid fa-file-circle-check"></i>
                    </div>
                    Verifikasi Berkas Permohonan
                </h1>
                <p class="text-xs text-slate-500 mt-1 ml-13">Periksa kelengkapan dan keabsahan berkas yang diunggah oleh pemohon.</p>
            </div>

            <!-- Status Badge -->
            <div class="flex flex-col items-start sm:items-end gap-2">
                <span class="font-mono text-sm font-extrabold text-pemda-700 tracking-wider">{{ $permohonan->nomor_tiket }}</span>
                <span class="px-4 py-1.5 rounded-full text-xs font-extrabold inline-flex items-center gap-1.5
                    @if($permohonan->status == 'Diajukan') bg-blue-100 text-blue-800
                    @elseif($permohonan->status == 'Diverifikasi') bg-amber-100 text-amber-800
                    @elseif($permohonan->status == 'Diproses') bg-indigo-100 text-indigo-800
                    @elseif($permohonan->status == 'Selesai') bg-emerald-100 text-emerald-800
                    @else bg-rose-100 text-rose-800 @endif">
                    @if($permohonan->status == 'Diajukan') <i class="fa-solid fa-paper-plane text-[10px]"></i>
                    @elseif($permohonan->status == 'Diverifikasi') <i class="fa-solid fa-check text-[10px]"></i>
                    @elseif($permohonan->status == 'Diproses') <i class="fa-solid fa-gear fa-spin text-[10px]"></i>
                    @elseif($permohonan->status == 'Selesai') <i class="fa-solid fa-circle-check text-[10px]"></i>
                    @else <i class="fa-solid fa-xmark text-[10px]"></i>
                    @endif
                    {{ $permohonan->status }}
                </span>
            </div>
        </div>

        <!-- ===== MAIN GRID ===== -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- ===== LEFT COLUMN: Info Pemohon + Berkas ===== -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Card: Data Pemohon -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden animate-slide-up">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-xs">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <h2 class="font-extrabold text-sm text-slate-900">Data Identitas Pemohon</h2>
                        </div>
                        <span class="text-[10px] text-slate-400 font-medium">Diajukan: {{ $permohonan->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap Pemohon</p>
                                <p class="text-sm font-extrabold text-slate-900">{{ $permohonan->nama_pemohon }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">NIK (16 Digit)</p>
                                <p class="text-sm font-bold font-mono text-slate-800">{{ $permohonan->nik_pemohon }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor Telepon / WhatsApp</p>
                                <p class="text-sm font-bold text-slate-800 flex items-center gap-1.5">
                                    <i class="fa-brands fa-whatsapp text-emerald-600"></i>
                                    {{ $permohonan->telepon }}
                                </p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kelurahan</p>
                                <p class="text-sm font-bold text-slate-800">{{ $permohonan->kelurahan }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat Lengkap</p>
                                <p class="text-sm text-slate-700 leading-relaxed">{{ $permohonan->alamat }}</p>
                            </div>
                            @if($permohonan->keterangan)
                            <div class="sm:col-span-2">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Keterangan / Keperluan</p>
                                <div class="bg-amber-50 border border-amber-100 rounded-xl p-3 text-sm text-amber-900 leading-relaxed italic">
                                    "{{ $permohonan->keterangan }}"
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Jenis Layanan yang Diminta -->
                        <div class="mt-5 pt-5 border-t border-slate-100">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Jenis Layanan yang Dimohonkan</p>
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-pemda-50 border border-pemda-200 rounded-xl">
                                <i class="fa-solid fa-file-signature text-pemda-700 text-sm"></i>
                                <span class="text-sm font-extrabold text-pemda-800">{{ $permohonan->jenis_layanan }}</span>
                            </div>
                        </div>

                        @if($permohonan->user)
                        <div class="mt-3 pt-3 border-t border-slate-100 flex items-center gap-2">
                            <i class="fa-solid fa-circle-user text-slate-400"></i>
                            <span class="text-xs text-slate-500">Akun terdaftar: <strong class="text-slate-700">{{ $permohonan->user->email }}</strong></span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Card: Berkas yang Diunggah -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden animate-slide-up" style="animation-delay: 0.1s">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center text-xs">
                                <i class="fa-solid fa-folder-open"></i>
                            </div>
                            <h2 class="font-extrabold text-sm text-slate-900">Berkas yang Diunggah Pemohon</h2>
                        </div>
                        <span class="text-[11px] font-bold text-slate-500">
                            {{ (($permohonan->file_ktp_kk ? 1 : 0) + ($permohonan->file_pengantar_rt ? 1 : 0) + ($permohonan->file_pendukung ? 1 : 0)) }} / 3 berkas
                        </span>
                    </div>

                    <div class="p-6 space-y-4">

                        <!-- Berkas 1: KTP/KK -->
                        <div id="berkas-ktp" class="group border border-slate-200 rounded-2xl overflow-hidden transition hover:border-pemda-300 hover:shadow-md">
                            <div class="px-4 py-3 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center text-xs">
                                        <i class="fa-solid fa-id-card"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-extrabold text-slate-900">Berkas 1: KTP / Kartu Keluarga</p>
                                        <p class="text-[10px] text-slate-500">Scan atau foto jelas KTP/KK pemohon</p>
                                    </div>
                                </div>
                                @if($permohonan->file_ktp_kk)
                                    <span class="flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-1 rounded-lg">
                                        <i class="fa-solid fa-check-circle"></i> Ada
                                    </span>
                                @else
                                    <span class="flex items-center gap-1 text-[10px] font-bold text-rose-700 bg-rose-50 border border-rose-200 px-2 py-1 rounded-lg">
                                        <i class="fa-solid fa-xmark-circle"></i> Tidak Ada
                                    </span>
                                @endif
                            </div>
                            @if($permohonan->file_ktp_kk)
                                @php $ext = strtolower(pathinfo($permohonan->file_ktp_kk, PATHINFO_EXTENSION)); @endphp
                                <div class="p-4">
                                    @if(in_array($ext, ['jpg','jpeg','png']))
                                        <div class="relative bg-slate-100 rounded-xl overflow-hidden" style="max-height: 300px;">
                                            <img src="{{ asset('storage/' . $permohonan->file_ktp_kk) }}"
                                                 alt="KTP/KK Pemohon"
                                                 class="berkas-preview-img w-full object-contain cursor-pointer rounded-xl"
                                                 style="max-height: 300px;"
                                                 onclick="openImageModal('{{ asset('storage/' . $permohonan->file_ktp_kk) }}', 'KTP / Kartu Keluarga — {{ $permohonan->nama_pemohon }}')"
                                            >
                                            <div class="absolute top-2 right-2">
                                                <button onclick="openImageModal('{{ asset('storage/' . $permohonan->file_ktp_kk) }}', 'KTP / Kartu Keluarga — {{ $permohonan->nama_pemohon }}')"
                                                        class="bg-slate-900/70 hover:bg-slate-900 text-white text-[10px] px-2.5 py-1.5 rounded-lg font-bold flex items-center gap-1 transition">
                                                    <i class="fa-solid fa-expand"></i> Perbesar
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mt-3 flex gap-2">
                                            <a href="{{ asset('storage/' . $permohonan->file_ktp_kk) }}" target="_blank"
                                               class="flex-1 text-center px-3 py-2 rounded-xl border border-slate-300 text-slate-700 text-xs font-bold hover:bg-slate-50 transition flex items-center justify-center gap-1.5">
                                                <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka di Tab Baru
                                            </a>
                                            <a href="{{ asset('storage/' . $permohonan->file_ktp_kk) }}" download
                                               class="flex-1 text-center px-3 py-2 rounded-xl bg-pemda-600 hover:bg-pemda-700 text-white text-xs font-bold transition flex items-center justify-center gap-1.5">
                                                <i class="fa-solid fa-download"></i> Unduh
                                            </a>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                                            <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                                                <i class="fa-solid fa-file-pdf text-red-600 text-xl"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-bold text-slate-800 truncate">Dokumen PDF — KTP/KK</p>
                                                <p class="text-[10px] text-slate-500">Format PDF, klik untuk membuka</p>
                                            </div>
                                            <div class="flex gap-1.5">
                                                <a href="{{ asset('storage/' . $permohonan->file_ktp_kk) }}" target="_blank"
                                                   class="px-3 py-1.5 rounded-xl border border-slate-300 text-slate-700 text-[11px] font-bold hover:bg-slate-100 transition">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <a href="{{ asset('storage/' . $permohonan->file_ktp_kk) }}" download
                                                   class="px-3 py-1.5 rounded-xl bg-pemda-600 hover:bg-pemda-700 text-white text-[11px] font-bold transition">
                                                    <i class="fa-solid fa-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="p-4">
                                    <div class="flex items-center gap-2 p-3 bg-rose-50 rounded-xl border border-rose-100">
                                        <i class="fa-solid fa-triangle-exclamation text-rose-500"></i>
                                        <span class="text-xs text-rose-700 font-semibold">Berkas KTP/KK tidak ditemukan atau belum diunggah.</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Berkas 2: Pengantar RT/RW -->
                        <div id="berkas-pengantar" class="group border border-slate-200 rounded-2xl overflow-hidden transition hover:border-pemda-300 hover:shadow-md">
                            <div class="px-4 py-3 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-xs">
                                        <i class="fa-solid fa-file-signature"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-extrabold text-slate-900">Berkas 2: Surat Pengantar RT/RW</p>
                                        <p class="text-[10px] text-slate-500">Surat keterangan / pengantar dari Ketua RT atau RW</p>
                                    </div>
                                </div>
                                @if($permohonan->file_pengantar_rt)
                                    <span class="flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-1 rounded-lg">
                                        <i class="fa-solid fa-check-circle"></i> Ada
                                    </span>
                                @else
                                    <span class="flex items-center gap-1 text-[10px] font-bold text-rose-700 bg-rose-50 border border-rose-200 px-2 py-1 rounded-lg">
                                        <i class="fa-solid fa-xmark-circle"></i> Tidak Ada
                                    </span>
                                @endif
                            </div>
                            @if($permohonan->file_pengantar_rt)
                                @php $ext2 = strtolower(pathinfo($permohonan->file_pengantar_rt, PATHINFO_EXTENSION)); @endphp
                                <div class="p-4">
                                    @if(in_array($ext2, ['jpg','jpeg','png']))
                                        <div class="relative bg-slate-100 rounded-xl overflow-hidden" style="max-height: 300px;">
                                            <img src="{{ asset('storage/' . $permohonan->file_pengantar_rt) }}"
                                                 alt="Surat Pengantar RT/RW"
                                                 class="berkas-preview-img w-full object-contain cursor-pointer rounded-xl"
                                                 style="max-height: 300px;"
                                                 onclick="openImageModal('{{ asset('storage/' . $permohonan->file_pengantar_rt) }}', 'Surat Pengantar RT/RW — {{ $permohonan->nama_pemohon }}')"
                                            >
                                            <div class="absolute top-2 right-2">
                                                <button onclick="openImageModal('{{ asset('storage/' . $permohonan->file_pengantar_rt) }}', 'Surat Pengantar RT/RW — {{ $permohonan->nama_pemohon }}')"
                                                        class="bg-slate-900/70 hover:bg-slate-900 text-white text-[10px] px-2.5 py-1.5 rounded-lg font-bold flex items-center gap-1 transition">
                                                    <i class="fa-solid fa-expand"></i> Perbesar
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mt-3 flex gap-2">
                                            <a href="{{ asset('storage/' . $permohonan->file_pengantar_rt) }}" target="_blank"
                                               class="flex-1 text-center px-3 py-2 rounded-xl border border-slate-300 text-slate-700 text-xs font-bold hover:bg-slate-50 transition flex items-center justify-center gap-1.5">
                                                <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka di Tab Baru
                                            </a>
                                            <a href="{{ asset('storage/' . $permohonan->file_pengantar_rt) }}" download
                                               class="flex-1 text-center px-3 py-2 rounded-xl bg-pemda-600 hover:bg-pemda-700 text-white text-xs font-bold transition flex items-center justify-center gap-1.5">
                                                <i class="fa-solid fa-download"></i> Unduh
                                            </a>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                                            <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                                                <i class="fa-solid fa-file-pdf text-red-600 text-xl"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-bold text-slate-800 truncate">Dokumen PDF — Pengantar RT/RW</p>
                                                <p class="text-[10px] text-slate-500">Format PDF, klik untuk membuka</p>
                                            </div>
                                            <div class="flex gap-1.5">
                                                <a href="{{ asset('storage/' . $permohonan->file_pengantar_rt) }}" target="_blank"
                                                   class="px-3 py-1.5 rounded-xl border border-slate-300 text-slate-700 text-[11px] font-bold hover:bg-slate-100 transition">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <a href="{{ asset('storage/' . $permohonan->file_pengantar_rt) }}" download
                                                   class="px-3 py-1.5 rounded-xl bg-pemda-600 hover:bg-pemda-700 text-white text-[11px] font-bold transition">
                                                    <i class="fa-solid fa-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="p-4">
                                    <div class="flex items-center gap-2 p-3 bg-rose-50 rounded-xl border border-rose-100">
                                        <i class="fa-solid fa-triangle-exclamation text-rose-500"></i>
                                        <span class="text-xs text-rose-700 font-semibold">Surat Pengantar RT/RW tidak ditemukan atau belum diunggah.</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Berkas 3: Pendukung (Opsional) -->
                        <div id="berkas-pendukung" class="group border border-slate-200 rounded-2xl overflow-hidden transition hover:border-pemda-300 hover:shadow-md">
                            <div class="px-4 py-3 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-slate-200 text-slate-600 flex items-center justify-center text-xs">
                                        <i class="fa-solid fa-paperclip"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-extrabold text-slate-900">Berkas 3: Dokumen Pendukung <span class="font-normal text-slate-400">(Opsional)</span></p>
                                        <p class="text-[10px] text-slate-500">Akta kelahiran, ijazah, surat nikah, atau dokumen pendukung lainnya</p>
                                    </div>
                                </div>
                                @if($permohonan->file_pendukung)
                                    <span class="flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-1 rounded-lg">
                                        <i class="fa-solid fa-check-circle"></i> Ada
                                    </span>
                                @else
                                    <span class="flex items-center gap-1 text-[10px] font-bold text-slate-500 bg-slate-100 border border-slate-200 px-2 py-1 rounded-lg">
                                        <i class="fa-solid fa-minus"></i> Tidak Diunggah
                                    </span>
                                @endif
                            </div>
                            @if($permohonan->file_pendukung)
                                @php $ext3 = strtolower(pathinfo($permohonan->file_pendukung, PATHINFO_EXTENSION)); @endphp
                                <div class="p-4">
                                    @if(in_array($ext3, ['jpg','jpeg','png']))
                                        <div class="relative bg-slate-100 rounded-xl overflow-hidden" style="max-height: 300px;">
                                            <img src="{{ asset('storage/' . $permohonan->file_pendukung) }}"
                                                 alt="Dokumen Pendukung"
                                                 class="berkas-preview-img w-full object-contain cursor-pointer rounded-xl"
                                                 style="max-height: 300px;"
                                                 onclick="openImageModal('{{ asset('storage/' . $permohonan->file_pendukung) }}', 'Dokumen Pendukung — {{ $permohonan->nama_pemohon }}')"
                                            >
                                            <div class="absolute top-2 right-2">
                                                <button onclick="openImageModal('{{ asset('storage/' . $permohonan->file_pendukung) }}', 'Dokumen Pendukung — {{ $permohonan->nama_pemohon }}')"
                                                        class="bg-slate-900/70 hover:bg-slate-900 text-white text-[10px] px-2.5 py-1.5 rounded-lg font-bold flex items-center gap-1 transition">
                                                    <i class="fa-solid fa-expand"></i> Perbesar
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mt-3 flex gap-2">
                                            <a href="{{ asset('storage/' . $permohonan->file_pendukung) }}" target="_blank"
                                               class="flex-1 text-center px-3 py-2 rounded-xl border border-slate-300 text-slate-700 text-xs font-bold hover:bg-slate-50 transition flex items-center justify-center gap-1.5">
                                                <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka di Tab Baru
                                            </a>
                                            <a href="{{ asset('storage/' . $permohonan->file_pendukung) }}" download
                                               class="flex-1 text-center px-3 py-2 rounded-xl bg-pemda-600 hover:bg-pemda-700 text-white text-xs font-bold transition flex items-center justify-center gap-1.5">
                                                <i class="fa-solid fa-download"></i> Unduh
                                            </a>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                                            <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                                                <i class="fa-solid fa-file-pdf text-red-600 text-xl"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-bold text-slate-800 truncate">Dokumen PDF — Berkas Pendukung</p>
                                                <p class="text-[10px] text-slate-500">Format PDF, klik untuk membuka</p>
                                            </div>
                                            <div class="flex gap-1.5">
                                                <a href="{{ asset('storage/' . $permohonan->file_pendukung) }}" target="_blank"
                                                   class="px-3 py-1.5 rounded-xl border border-slate-300 text-slate-700 text-[11px] font-bold hover:bg-slate-100 transition">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <a href="{{ asset('storage/' . $permohonan->file_pendukung) }}" download
                                                   class="px-3 py-1.5 rounded-xl bg-pemda-600 hover:bg-pemda-700 text-white text-[11px] font-bold transition">
                                                    <i class="fa-solid fa-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="p-4">
                                    <p class="text-xs text-slate-400 italic text-center py-2">Pemohon tidak melampirkan dokumen pendukung tambahan.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Berkas Hasil (jika sudah terbit) -->
                        @if($permohonan->file_hasil)
                        <div class="border-2 border-emerald-300 rounded-2xl overflow-hidden bg-emerald-50">
                            <div class="px-4 py-3 bg-emerald-100 border-b border-emerald-200 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-xs">
                                        <i class="fa-solid fa-check-double"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-extrabold text-emerald-900">Dokumen Hasil / Surat Resmi Kecamatan</p>
                                        <p class="text-[10px] text-emerald-700">Dokumen yang telah diterbitkan oleh petugas kecamatan</p>
                                    </div>
                                </div>
                                <span class="flex items-center gap-1 text-[10px] font-bold text-emerald-800 bg-emerald-200 px-2 py-1 rounded-lg">
                                    <i class="fa-solid fa-star"></i> Sudah Terbit
                                </span>
                            </div>
                            <div class="p-4">
                                <div class="flex items-center gap-3 p-3 bg-white rounded-xl border border-emerald-200">
                                    <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-file-certificate text-emerald-700 text-xl"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-bold text-emerald-900">Dokumen Hasil Resmi</p>
                                        <p class="text-[10px] text-emerald-700">Selesai: {{ $permohonan->selesai_pada ? $permohonan->selesai_pada->format('d M Y, H:i') . ' WIB' : '-' }}</p>
                                    </div>
                                    <div class="flex gap-1.5">
                                        <a href="{{ asset('storage/' . $permohonan->file_hasil) }}" target="_blank"
                                           class="px-3 py-1.5 rounded-xl border border-emerald-300 text-emerald-700 text-[11px] font-bold hover:bg-emerald-100 transition">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ asset('storage/' . $permohonan->file_hasil) }}" download
                                           class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold transition">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Status Verifikator Berkas, Paraf Sekcam & Tanda Tangan Camat -->
                        <div class="border border-slate-200 rounded-2xl overflow-hidden bg-slate-50/60 p-4 space-y-4">
                            <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                                <i class="fa-solid fa-file-shield text-indigo-600"></i> Tahapan Verifikasi & Legalisasi Berkas
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5">
                                <!-- 1. Petugas Verifikator -->
                                <div class="p-3 bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-[11px] font-bold text-slate-700 flex items-center gap-1.5">
                                                <i class="fa-solid fa-user-check text-teal-600"></i> Verifikasi Berkas
                                            </span>
                                            @if($permohonan->petugas || $permohonan->diverifikasi_petugas_pada)
                                                <span class="text-[9px] font-extrabold text-teal-700 bg-teal-50 border border-teal-200 px-2 py-0.5 rounded-full">LENGKAP</span>
                                            @else
                                                <span class="text-[9px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">Belum</span>
                                            @endif
                                        </div>
                                        @if($permohonan->petugas || $permohonan->diverifikasi_petugas_pada)
                                            <p class="text-[11px] text-slate-700 font-medium">Petugas telah memverifikasi seluruh kelengkapan berkas fisik/digital.</p>
                                        @else
                                            <p class="text-[11px] text-slate-400 italic">Menunggu pemeriksaan dan verifikasi berkas oleh Petugas Loket.</p>
                                        @endif
                                    </div>
                                    <div class="mt-2 pt-2 border-t border-slate-100 text-[10px] text-slate-500">
                                        Petugas: <strong>{{ $permohonan->petugas ? $permohonan->petugas->name : '-' }}</strong><br>
                                        Waktu: {{ $permohonan->diverifikasi_petugas_pada ? $permohonan->diverifikasi_petugas_pada->format('d/m/Y H:i') : '-' }}
                                    </div>
                                </div>

                                <!-- 2. Paraf Sekcam -->
                                <div class="p-3 bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-[11px] font-bold text-slate-700 flex items-center gap-1.5">
                                                <i class="fa-solid fa-file-signature text-indigo-600"></i> Paraf Sekcam
                                            </span>
                                            @if($permohonan->paraf_sekcam)
                                                <span class="text-[9px] font-extrabold text-indigo-700 bg-indigo-50 border border-indigo-200 px-2 py-0.5 rounded-full">DIPARAF</span>
                                            @else
                                                <span class="text-[9px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">Belum</span>
                                            @endif
                                        </div>
                                        @if($permohonan->paraf_sekcam)
                                            <p class="text-xs text-slate-800 italic font-medium">"{{ $permohonan->paraf_sekcam }}"</p>
                                        @else
                                            <p class="text-[11px] text-slate-400 italic">Menunggu paraf dari Sekretaris Camat.</p>
                                        @endif
                                    </div>
                                    <div class="mt-2 pt-2 border-t border-slate-100 text-[10px] text-slate-500">
                                        Sekcam: <strong>{{ $permohonan->sekcam ? $permohonan->sekcam->name : '-' }}</strong><br>
                                        Waktu: {{ $permohonan->diverifikasi_sekcam_pada ? $permohonan->diverifikasi_sekcam_pada->format('d/m/Y H:i') : '-' }}
                                    </div>
                                </div>

                                <!-- 3. Tanda Tangan Digital Camat -->
                                <div class="p-3 bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-[11px] font-bold text-slate-700 flex items-center gap-1.5">
                                                <i class="fa-solid fa-signature text-purple-600"></i> TTD Digital Camat
                                            </span>
                                            @if($permohonan->ttd_camat)
                                                <span class="text-[9px] font-extrabold text-purple-700 bg-purple-50 border border-purple-200 px-2 py-0.5 rounded-full">SAH</span>
                                            @else
                                                <span class="text-[9px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">Menunggu</span>
                                            @endif
                                        </div>
                                        @if($permohonan->ttd_camat)
                                            <div class="bg-slate-50 border border-slate-100 rounded-lg p-1.5 flex justify-center mb-1">
                                                <img src="{{ $permohonan->ttd_camat }}" alt="Tanda Tangan Camat" class="h-12 object-contain">
                                            </div>
                                        @else
                                            <p class="text-[11px] text-slate-400 italic">Dokumen belum dibubuhi TTD Camat.</p>
                                        @endif
                                    </div>
                                    <div class="mt-2 pt-2 border-t border-slate-100 text-[10px] text-slate-500">
                                        Camat: <strong>{{ $permohonan->camat ? $permohonan->camat->name : '-' }}</strong><br>
                                        Waktu: {{ $permohonan->ditandatangani_camat_pada ? $permohonan->ditandatangani_camat_pada->format('d/m/Y H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ===== RIGHT COLUMN: Checklist Verifikasi + Form Keputusan ===== -->
            <div class="space-y-6">

                <!-- Card: Checklist Verifikasi Berkas -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden animate-slide-up" style="animation-delay: 0.15s">
                    <div class="px-5 py-4 border-b border-slate-100 bg-slate-50">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs">
                                <i class="fa-solid fa-list-check"></i>
                            </div>
                            <h2 class="font-extrabold text-sm text-slate-900">Checklist Verifikasi Berkas</h2>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1.5">Tandai poin yang sudah diperiksa dan memenuhi syarat</p>
                    </div>
                    <div class="p-5 space-y-3" id="checklist-container">
                        @php
                        $checklists = [
                            ['id' => 'chk1', 'icon' => 'fa-id-card', 'color' => 'rose', 'label' => 'KTP/KK diunggah dengan jelas & terbaca', 'sub' => 'Foto/scan tidak buram, gelap, atau terpotong'],
                            ['id' => 'chk2', 'icon' => 'fa-file-signature', 'color' => 'amber', 'label' => 'Surat Pengantar RT/RW ada & valid', 'sub' => 'Bertanda tangan & cap RT/RW setempat'],
                            ['id' => 'chk3', 'icon' => 'fa-user-check', 'color' => 'blue', 'label' => 'NIK pemohon sesuai KTP', 'sub' => 'NIK 16 digit cocok dengan yang tertera di KTP'],
                            ['id' => 'chk4', 'icon' => 'fa-map-marker-alt', 'color' => 'purple', 'label' => 'Alamat & Kelurahan sesuai wilayah', 'sub' => 'Termasuk dalam wilayah Kecamatan Alang-Alang Lebar'],
                            ['id' => 'chk5', 'icon' => 'fa-file-alt', 'color' => 'teal', 'label' => 'Jenis layanan sesuai berkas yang dilampirkan', 'sub' => 'Berkas pendukung relevan dengan permohonan'],
                        ];
                        @endphp

                        @foreach($checklists as $item)
                        <label class="checklist-item flex items-start gap-3 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition group" for="{{ $item['id'] }}">
                            <div class="flex-shrink-0 mt-0.5">
                                <div id="{{ $item['id'] }}-box"
                                     class="w-5 h-5 rounded-md border-2 border-slate-300 flex items-center justify-center transition-all duration-200 group-hover:border-pemda-400">
                                    <i class="fa-solid fa-check text-[9px] text-white hidden" id="{{ $item['id'] }}-check"></i>
                                </div>
                            </div>
                            <input type="checkbox" id="{{ $item['id'] }}" class="sr-only" onchange="toggleChecklist('{{ $item['id'] }}')">
                            <div class="flex-1 min-w-0">
                                <p id="{{ $item['id'] }}-label" class="text-xs font-bold text-slate-800 leading-tight transition-all">{{ $item['label'] }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $item['sub'] }}</p>
                            </div>
                        </label>
                        @endforeach

                        <!-- Progress Bar Checklist -->
                        <div class="pt-2">
                            <div class="flex justify-between items-center mb-1.5">
                                <span class="text-[10px] font-bold text-slate-500">Kelengkapan Verifikasi</span>
                                <span id="checklist-score" class="text-[10px] font-extrabold text-pemda-700">0 / 5</span>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-2">
                                <div id="checklist-bar" class="bg-pemda-500 h-2 rounded-full transition-all duration-500" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card: Timeline Status -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden animate-slide-up" style="animation-delay: 0.2s">
                    <div class="px-5 py-4 border-b border-slate-100 bg-slate-50">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-xs">
                                <i class="fa-solid fa-timeline"></i>
                            </div>
                            <h2 class="font-extrabold text-sm text-slate-900">Alur Status Permohonan</h2>
                        </div>
                    </div>
                    <div class="p-5">
                        @php
                        $statusOrder = ['Diajukan', 'Diverifikasi', 'Menunggu TTD Camat', 'Ditandatangani Camat', 'Diproses', 'Selesai'];
                        $currentIdx = array_search($permohonan->status, $statusOrder);
                        if ($permohonan->status === 'Ditolak') $currentIdx = -1;
                        $statusIcons = [
                            'Diajukan' => 'fa-paper-plane',
                            'Diverifikasi' => 'fa-check',
                            'Menunggu TTD Camat' => 'fa-file-signature',
                            'Ditandatangani Camat' => 'fa-stamp',
                            'Diproses' => 'fa-gear',
                            'Selesai' => 'fa-check-double'
                        ];
                        $statusColors = [
                            'active' => 'bg-pemda-600 text-white border-pemda-600',
                            'done'   => 'bg-pemda-100 text-pemda-700 border-pemda-300',
                            'wait'   => 'bg-slate-100 text-slate-400 border-slate-200',
                        ];
                        @endphp

                        @if($permohonan->status === 'Ditolak')
                        <div class="flex items-center gap-3 p-3 bg-rose-50 border border-rose-200 rounded-xl mb-4">
                            <div class="w-8 h-8 rounded-lg bg-rose-600 text-white flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-xmark text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs font-extrabold text-rose-800">Permohonan Ditolak</p>
                                <p class="text-[10px] text-rose-600">Berkas tidak memenuhi syarat atau tidak lengkap</p>
                            </div>
                        </div>
                        @endif

                        <div class="space-y-3">
                            @foreach($statusOrder as $idx => $st)
                            @php
                                $isDone   = $currentIdx > $idx;
                                $isActive = $currentIdx == $idx;
                                $colorClass = $isActive ? $statusColors['active'] : ($isDone ? $statusColors['done'] : $statusColors['wait']);
                                $textClass  = $isActive ? 'text-slate-900 font-extrabold' : ($isDone ? 'text-slate-600 font-bold' : 'text-slate-400 font-medium');
                            @endphp
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl border-2 flex items-center justify-center flex-shrink-0 text-xs {{ $colorClass }} transition-all">
                                    @if($isDone)
                                        <i class="fa-solid fa-check text-[10px]"></i>
                                    @elseif($isActive)
                                        <i class="fa-solid {{ $statusIcons[$st] }} text-[10px]"></i>
                                    @else
                                        <i class="fa-solid fa-circle text-[6px]"></i>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs {{ $textClass }}">{{ $st }}</p>
                                    @if($isActive)
                                        <p class="text-[10px] text-pemda-600 font-medium">Status saat ini</p>
                                    @endif
                                </div>
                                @if($isActive)
                                <span class="ml-auto text-[9px] bg-pemda-600 text-white px-2 py-0.5 rounded-full font-bold">SEKARANG</span>
                                @endif
                            </div>
                            @if($idx < count($statusOrder) - 1)
                            <div class="ml-4 w-px h-3 bg-slate-200"></div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Card: Form Keputusan Verifikasi -->
                <div class="bg-white rounded-3xl border-2 border-pemda-200 shadow-lg overflow-hidden animate-slide-up" style="animation-delay: 0.25s">
                    <div class="px-5 py-4 border-b border-pemda-100 bg-gradient-to-r from-pemda-600 to-pemda-700">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs">
                                <i class="fa-solid fa-stamp"></i>
                            </div>
                            <div>
                                <h2 class="font-extrabold text-sm text-white">Keputusan Verifikasi</h2>
                                <p class="text-[10px] text-pemda-200">Perbarui status & berikan catatan resmi</p>
                            </div>
                        </div>
                    </div>
                    <form id="verifikasiForm" action="{{ route('admin.pelayanan.status', $permohonan->id) }}" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                        @csrf
                        @method('PATCH')

                        <!-- Status -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5" for="status-select">
                                <i class="fa-solid fa-toggle-on text-pemda-600 mr-1"></i>Status Penanganan *
                            </label>
                            <select id="status-select" name="status" required
                                    onchange="handleStatusChange(this.value)"
                                    class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none font-bold cursor-pointer bg-white">
                                <option value="Diajukan" {{ $permohonan->status == 'Diajukan' ? 'selected' : '' }}>📥 Diajukan (Belum Diperiksa)</option>
                                <option value="Diverifikasi" {{ $permohonan->status == 'Diverifikasi' ? 'selected' : '' }}>✅ Diverifikasi (Berkas Lengkap & Sah)</option>
                                <option value="Menunggu TTD Camat" {{ $permohonan->status == 'Menunggu TTD Camat' ? 'selected' : '' }}>✒️ Menunggu TTD Camat (Paraf Sekcam Sah)</option>
                                <option value="Ditandatangani Camat" {{ $permohonan->status == 'Ditandatangani Camat' ? 'selected' : '' }}>🖋️ Ditandatangani Camat (TTD Digital Sah)</option>
                                <option value="Diproses" {{ $permohonan->status == 'Diproses' ? 'selected' : '' }}>⚙️ Diproses (Pencetakan / Penomoran Surat)</option>
                                <option value="Selesai" {{ $permohonan->status == 'Selesai' ? 'selected' : '' }}>🎉 Selesai (Surat Sah & Terbit)</option>
                                <option value="Ditolak" {{ $permohonan->status == 'Ditolak' ? 'selected' : '' }}>❌ Ditolak (Berkas Tidak Sesuai / Kurang)</option>
                            </select>
                        </div>

                        <!-- Hint otomatis berdasarkan status -->
                        <div id="status-hint" class="hidden rounded-xl p-3 text-xs leading-relaxed"></div>

                        <!-- BAGIAN KHUSUS: Paraf Sekretaris Camat (Jika Sekcam / Admin) -->
                        @if(in_array(auth()->user()->role, ['sekretaris_camat', 'admin']))
                        <div class="p-4 bg-indigo-50/70 border border-indigo-200 rounded-2xl space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-extrabold text-indigo-900">
                                    <i class="fa-solid fa-file-signature text-indigo-600 mr-1"></i>Paraf Verifikasi Sekcam
                                </label>
                                @if($permohonan->paraf_sekcam)
                                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">Sudah Diparaf</span>
                                @endif
                            </div>
                            <input type="text" name="paraf_sekcam" value="{{ $permohonan->paraf_sekcam ?? 'Berkas diverifikasi lengkap & sah oleh Sekretaris Camat' }}" 
                                   class="w-full px-3 py-2 rounded-xl border border-indigo-200 text-xs focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-white font-medium"
                                   placeholder="Catatan paraf Sekcam...">
                            <p class="text-[10px] text-indigo-700">Otomatis mencatat identitas & waktu verifikasi Sekretaris Camat sebelum diajukan ke Camat.</p>
                        </div>
                        @endif

                        <!-- BAGIAN KHUSUS: Tanda Tangan Digital Camat (Jika Camat / Admin) -->
                        @if(in_array(auth()->user()->role, ['camat', 'admin']))
                        <div class="p-4 bg-purple-50/70 border border-purple-200 rounded-2xl space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-extrabold text-purple-900">
                                    <i class="fa-solid fa-signature text-purple-600 mr-1"></i>Tanda Tangan Digital Camat
                                </label>
                                @if($permohonan->ttd_camat)
                                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">Sudah TTD</span>
                                @endif
                            </div>
                            
                            <p class="text-[10px] text-purple-700 leading-relaxed">Bapak/Ibu Camat dapat membubuhkan tanda tangan langsung menggunakan kursor mouse atau sentuhan layar pada kanvas di bawah ini:</p>
                            
                            <!-- Canvas TTD Digital -->
                            <div class="bg-white border-2 border-dashed border-purple-300 rounded-xl p-2 relative flex flex-col items-center">
                                <canvas id="signature-pad" width="340" height="150" class="border border-slate-200 rounded-lg touch-none bg-white cursor-crosshair w-full" style="max-width: 100%; height: 140px;"></canvas>
                                <div class="w-full flex items-center justify-between mt-2 pt-1 border-t border-slate-100">
                                    <span class="text-[10px] text-slate-400 italic">Bubuhkan tanda tangan di atas garis</span>
                                    <button type="button" onclick="clearSignature()" class="px-2.5 py-1 text-[10px] font-bold text-rose-600 hover:bg-rose-50 rounded-lg transition flex items-center gap-1">
                                        <i class="fa-solid fa-eraser"></i> Bersihkan Canvas
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="ttd_camat" id="ttd_camat_input" value="{{ $permohonan->ttd_camat }}">
                        </div>
                        @endif

                        <!-- Catatan Petugas -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5" for="catatan-input">
                                <i class="fa-solid fa-pen-to-square text-slate-500 mr-1"></i>Catatan Resmi Petugas
                            </label>
                            <textarea id="catatan-input" name="catatan_petugas" rows="4"
                                      class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-pemda-500 focus:outline-none leading-relaxed resize-none"
                                      placeholder="Tuliskan catatan verifikasi untuk pemohon, cth: 'Berkas telah diverifikasi, silakan ambil surat jadi di loket pelayanan pada jam kerja...'">{{ $permohonan->catatan_petugas }}</textarea>
                        </div>

                        <!-- Upload Dokumen Hasil -->
                        <div id="upload-hasil-section">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                <i class="fa-solid fa-file-arrow-up text-indigo-600 mr-1"></i>Upload Dokumen Hasil Resmi <span class="font-normal text-slate-400">(Opsional)</span>
                            </label>
                            @if($permohonan->file_hasil)
                            <div class="mb-2 p-2 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-2 text-xs text-emerald-700">
                                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                                <span class="font-semibold">Dokumen hasil sudah ada.</span>
                                <a href="{{ asset('storage/' . $permohonan->file_hasil) }}" target="_blank" class="underline font-bold">Lihat</a>
                            </div>
                            <p class="text-[10px] text-slate-400 mb-1.5">Upload file baru untuk menggantikan dokumen hasil yang sudah ada.</p>
                            @endif
                            <div class="border-2 border-dashed border-slate-300 rounded-xl p-4 text-center hover:border-pemda-400 transition cursor-pointer" id="drop-zone" onclick="document.getElementById('file-hasil-input').click()">
                                <i class="fa-solid fa-cloud-arrow-up text-2xl text-slate-400 mb-2 block"></i>
                                <p class="text-xs font-bold text-slate-600">Klik untuk pilih file atau drag & drop</p>
                                <p class="text-[10px] text-slate-400 mt-1">PDF, JPG, JPEG, PNG — Maks 5MB</p>
                                <input type="file" id="file-hasil-input" name="file_hasil" accept=".pdf,.jpg,.jpeg,.png" class="sr-only" onchange="previewFileHasil(this)">
                            </div>
                            <div id="file-hasil-preview" class="hidden mt-2 p-2.5 bg-indigo-50 border border-indigo-200 rounded-xl flex items-center gap-2">
                                <i class="fa-solid fa-file text-indigo-600 text-sm"></i>
                                <span id="file-hasil-name" class="text-xs font-bold text-indigo-800 flex-1 truncate"></span>
                                <button type="button" onclick="clearFileHasil()" class="text-slate-400 hover:text-rose-500 transition">
                                    <i class="fa-solid fa-xmark text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2 border-t border-slate-100 space-y-2">
                            <button type="submit" id="submit-btn"
                                    class="w-full px-5 py-3 rounded-xl bg-pemda-600 hover:bg-pemda-700 active:bg-pemda-800 text-white text-sm font-extrabold shadow-lg shadow-pemda-200 transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-stamp"></i>
                                Simpan Keputusan Verifikasi
                            </button>
                            <a href="{{ route('admin.pelayanan.index') }}"
                               class="w-full px-5 py-2.5 rounded-xl border border-slate-300 text-slate-600 text-xs font-bold hover:bg-slate-50 transition flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                                Kembali ke Daftar
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Card: Aksi Berbahaya -->
                <div class="bg-white rounded-3xl border border-rose-200 shadow-sm overflow-hidden animate-slide-up" style="animation-delay: 0.3s">
                    <div class="px-5 py-4 border-b border-rose-100 bg-rose-50">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center text-xs">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>
                            <h2 class="font-extrabold text-sm text-rose-800">Zona Berbahaya</h2>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-slate-500 mb-3 leading-relaxed">Menghapus permohonan akan menghapus semua data dan berkas secara permanen dan tidak dapat dipulihkan.</p>
                        <form action="{{ route('admin.pelayanan.destroy', $permohonan->id) }}" method="POST"
                              onsubmit="return confirm('PERINGATAN: Tindakan ini tidak dapat dibatalkan.\n\nApakah Anda yakin ingin menghapus permohonan tiket [{{ $permohonan->nomor_tiket }}] beserta seluruh berkasnya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-extrabold transition flex items-center justify-center gap-2 shadow-md shadow-rose-100">
                                <i class="fa-solid fa-trash-can"></i>
                                Hapus Permohonan & Seluruh Berkas
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-500 mt-auto">
        &copy; {{ date('Y') }} Kantor Camat Alang-Alang Lebar Palembang • Panel Administrator
    </footer>

    <!-- ===== MODAL: Image Preview ===== -->
    <div id="imageModal" class="fixed inset-0 z-50 bg-slate-900/90 backdrop-blur-md hidden items-center justify-center p-4"
         onclick="if(event.target===this) closeImageModal()">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden max-w-4xl w-full max-h-[90vh] flex flex-col animate-slide-up">
            <div class="px-5 py-3.5 border-b border-slate-200 bg-slate-50 flex items-center justify-between flex-shrink-0">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-slate-800 text-white flex items-center justify-center text-xs">
                        <i class="fa-solid fa-image"></i>
                    </div>
                    <p id="image-modal-title" class="text-xs font-extrabold text-slate-900">Preview Dokumen</p>
                </div>
                <div class="flex items-center gap-2">
                    <a id="image-modal-download" href="#" download class="px-3 py-1.5 rounded-xl bg-pemda-600 hover:bg-pemda-700 text-white text-[11px] font-bold flex items-center gap-1.5 transition">
                        <i class="fa-solid fa-download"></i> Unduh
                    </a>
                    <a id="image-modal-open" href="#" target="_blank" class="px-3 py-1.5 rounded-xl border border-slate-300 text-slate-700 text-[11px] font-bold hover:bg-slate-50 flex items-center gap-1.5 transition">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka
                    </a>
                    <button onclick="closeImageModal()" class="w-8 h-8 rounded-xl bg-slate-200 hover:bg-rose-100 hover:text-rose-600 flex items-center justify-center transition">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>
            </div>
            <div class="overflow-auto flex-1 bg-slate-100 flex items-center justify-center p-4">
                <img id="image-modal-src" src="" alt="Preview Dokumen" class="max-w-full object-contain rounded-xl shadow-lg" style="max-height: 75vh;">
            </div>
        </div>
    </div>

    <script>
        /* ===========================
           CHECKLIST VERIFIKASI
        =========================== */
        let checkedCount = 0;
        const totalChecks = 5;

        function toggleChecklist(id) {
            const cb = document.getElementById(id);
            const box = document.getElementById(id + '-box');
            const checkIcon = document.getElementById(id + '-check');
            const label = document.getElementById(id + '-label');

            if (cb.checked) {
                box.classList.remove('border-slate-300');
                box.classList.add('bg-pemda-600', 'border-pemda-600');
                checkIcon.classList.remove('hidden');
                label.classList.add('line-through', 'text-slate-400');
                label.classList.remove('text-slate-800');
                checkedCount++;
            } else {
                box.classList.add('border-slate-300');
                box.classList.remove('bg-pemda-600', 'border-pemda-600');
                checkIcon.classList.add('hidden');
                label.classList.remove('line-through', 'text-slate-400');
                label.classList.add('text-slate-800');
                checkedCount--;
            }

            updateChecklistProgress();
        }

        function updateChecklistProgress() {
            const pct = Math.round((checkedCount / totalChecks) * 100);
            document.getElementById('checklist-score').textContent = checkedCount + ' / ' + totalChecks;
            document.getElementById('checklist-bar').style.width = pct + '%';

            const bar = document.getElementById('checklist-bar');
            if (pct === 100) {
                bar.className = 'h-2 rounded-full transition-all duration-500 bg-emerald-500';
            } else if (pct >= 60) {
                bar.className = 'h-2 rounded-full transition-all duration-500 bg-amber-500';
            } else {
                bar.className = 'h-2 rounded-full transition-all duration-500 bg-pemda-500';
            }
        }

        /* ===========================
           STATUS HINT
        =========================== */
        const statusHints = {
            'Diajukan': { cls: 'bg-blue-50 border border-blue-200 text-blue-800', icon: 'fa-info-circle', text: 'Permohonan baru masuk. Berkas belum diperiksa oleh petugas.' },
            'Diverifikasi': { cls: 'bg-emerald-50 border border-emerald-200 text-emerald-800', icon: 'fa-check-circle', text: 'Berkas dinyatakan <strong>lengkap dan sah</strong>. Siap diteruskan ke tahap paraf/TTD.' },
            'Menunggu TTD Camat': { cls: 'bg-purple-50 border border-purple-200 text-purple-800', icon: 'fa-signature', text: 'Telah diparaf oleh Sekretaris Camat dan sedang <strong>menunggu pengesahan tanda tangan digital Camat</strong>.' },
            'Ditandatangani Camat': { cls: 'bg-indigo-50 border border-indigo-200 text-indigo-800', icon: 'fa-stamp', text: 'Dokumen telah <strong>sah ditandatangani Camat secara digital</strong>. Petugas loket dapat menerbitkan dokumen hasil.' },
            'Diproses': { cls: 'bg-indigo-50 border border-indigo-200 text-indigo-800', icon: 'fa-gear', text: 'Dokumen sedang dalam proses pengetikan, penomoran surat, atau pemrosesan administrasi lanjutan.' },
            'Selesai': { cls: 'bg-teal-50 border border-teal-200 text-teal-800', icon: 'fa-check-double', text: 'Surat telah selesai diterbitkan dengan tanda tangan digital sah dan dapat diunduh pemohon.' },
            'Ditolak': { cls: 'bg-rose-50 border border-rose-200 text-rose-800', icon: 'fa-times-circle', text: 'Permohonan ditolak karena berkas tidak sesuai. Tuliskan alasan penolakan di catatan petugas.' },
        };

        function handleStatusChange(value) {
            const hint = document.getElementById('status-hint');
            if (statusHints[value]) {
                const h = statusHints[value];
                hint.className = 'rounded-xl p-3 text-xs leading-relaxed flex items-start gap-2 ' + h.cls;
                hint.innerHTML = `<i class="fa-solid ${h.icon} mt-0.5 flex-shrink-0"></i><span>${h.text}</span>`;
                hint.classList.remove('hidden');
            } else {
                hint.classList.add('hidden');
            }
        }

        // Trigger on page load
        handleStatusChange(document.getElementById('status-select').value);

        /* ===========================
           FILE UPLOAD PREVIEW
        =========================== */
        function previewFileHasil(input) {
            const preview = document.getElementById('file-hasil-preview');
            const nameEl = document.getElementById('file-hasil-name');
            if (input.files && input.files[0]) {
                nameEl.textContent = input.files[0].name;
                preview.classList.remove('hidden');
            }
        }

        function clearFileHasil() {
            document.getElementById('file-hasil-input').value = '';
            document.getElementById('file-hasil-preview').classList.add('hidden');
        }

        /* Drag & Drop */
        const dropZone = document.getElementById('drop-zone');
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-pemda-500', 'bg-pemda-50');
        });
        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-pemda-500', 'bg-pemda-50');
        });
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-pemda-500', 'bg-pemda-50');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('file-hasil-input').files = files;
                previewFileHasil(document.getElementById('file-hasil-input'));
            }
        });

        /* ===========================
           IMAGE MODAL
        =========================== */
        function openImageModal(src, title) {
            document.getElementById('image-modal-src').src = src;
            document.getElementById('image-modal-title').textContent = title;
            document.getElementById('image-modal-download').href = src;
            document.getElementById('image-modal-open').href = src;

            const modal = document.getElementById('imageModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeImageModal();
        });

        /* ===========================
           SUBMIT BUTTON LOADING
        =========================== */
        document.getElementById('verifikasiForm').addEventListener('submit', function() {
            if (canvas && hasDrawn) {
                const ttdInput = document.getElementById('ttd_camat_input');
                if (ttdInput) {
                    ttdInput.value = canvas.toDataURL('image/png');
                }
            }

            const btn = document.getElementById('submit-btn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';
            btn.classList.add('opacity-70');
        });

        /* ===========================
           CANVAS TANDA TANGAN DIGITAL CAMAT
        =========================== */
        const canvas = document.getElementById('signature-pad');
        let ctx = null;
        let isDrawing = false;
        let hasDrawn = false;

        if (canvas) {
            ctx = canvas.getContext('2d');
            ctx.strokeStyle = '#1e1b4b'; // deep indigo/navy ink
            ctx.lineWidth = 2.5;
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';

            function getMousePos(e) {
                const rect = canvas.getBoundingClientRect();
                const scaleX = canvas.width / rect.width;
                const scaleY = canvas.height / rect.height;
                return {
                    x: (e.clientX - rect.left) * scaleX,
                    y: (e.clientY - rect.top) * scaleY
                };
            }

            function getTouchPos(e) {
                const rect = canvas.getBoundingClientRect();
                const touch = e.touches[0];
                const scaleX = canvas.width / rect.width;
                const scaleY = canvas.height / rect.height;
                return {
                    x: (touch.clientX - rect.left) * scaleX,
                    y: (touch.clientY - rect.top) * scaleY
                };
            }

            canvas.addEventListener('mousedown', (e) => {
                isDrawing = true;
                hasDrawn = true;
                const pos = getMousePos(e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
            });

            canvas.addEventListener('mousemove', (e) => {
                if (!isDrawing) return;
                const pos = getMousePos(e);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
            });

            window.addEventListener('mouseup', () => {
                if (isDrawing) {
                    isDrawing = false;
                    document.getElementById('ttd_camat_input').value = canvas.toDataURL('image/png');
                }
            });

            // Touch events for mobile/tablet/touchscreen
            canvas.addEventListener('touchstart', (e) => {
                e.preventDefault();
                isDrawing = true;
                hasDrawn = true;
                const pos = getTouchPos(e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
            }, { passive: false });

            canvas.addEventListener('touchmove', (e) => {
                e.preventDefault();
                if (!isDrawing) return;
                const pos = getTouchPos(e);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
            }, { passive: false });

            canvas.addEventListener('touchend', (e) => {
                e.preventDefault();
                if (isDrawing) {
                    isDrawing = false;
                    document.getElementById('ttd_camat_input').value = canvas.toDataURL('image/png');
                }
            }, { passive: false });
        }

        function clearSignature() {
            if (canvas && ctx) {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                document.getElementById('ttd_camat_input').value = '';
                hasDrawn = false;
            }
        }
    </script>
</body>
</html>
