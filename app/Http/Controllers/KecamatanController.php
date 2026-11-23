<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    public function index()
    {
        // Data Kelurahan di Kecamatan Alang-Alang Lebar
        $kelurahan = [
            [
                'nama' => 'Alang-Alang Lebar',
                'deskripsi' => 'Pusat pemerintahan kecamatan dengan akses langsung ke Jl. Kolonel H. Burlian dan fasilitas publik utama.',
                'luas' => '9.82 km²',
                'penduduk' => '±28.450 Jiwa',
                'icon' => 'fa-landmark-flag'
            ],
            [
                'nama' => 'Karya Baru',
                'deskripsi' => 'Kawasan pemukiman dinamis, sentra UMKM kuliner, dan sentra perdagangan lokal.',
                'luas' => '8.65 km²',
                'penduduk' => '±31.200 Jiwa',
                'icon' => 'fa-store'
            ],
            [
                'nama' => 'Talang Kelapa',
                'deskripsi' => 'Sentra perumahan modern, pergudangan terpadu, dan berbatasan langsung dengan Banyuasin.',
                'luas' => '12.40 km²',
                'penduduk' => '±36.800 Jiwa',
                'icon' => 'fa-house-chimney'
            ],
            [
                'nama' => 'Srijaya',
                'deskripsi' => 'Kawasan hijau dan hunian strategis yang terhubung dengan akses lingkar barat Kota Palembang.',
                'luas' => '7.80 km²',
                'penduduk' => '±22.150 Jiwa',
                'icon' => 'fa-tree'
            ]
        ];

        // Layanan Publik Utama Kantor Camat
        $layanan = [
            [
                'kode' => 'KTP-EL & KK',
                'judul' => 'Perekaman & Pengurusan KTP-el / KK',
                'deskripsi' => 'Pelayanan perekaman biometrik KTP elektronik, pembaharuan Kartu Keluarga, dan surat pindah domisili.',
                'syarat' => ['Pengantar RT/RW', 'Fotokopi KK lama', 'Akta Kelahiran'],
                'waktu' => '1 - 2 Hari Kerja',
                'icon' => 'fa-id-card'
            ],
            [
                'kode' => 'SKCK & SKTM',
                'judul' => 'Surat Pengantar SKCK & SKTM',
                'deskripsi' => 'Legalisir pengantar SKCK kepolisian serta Surat Keterangan Tidak Mampu untuk beasiswa/BPJS.',
                'syarat' => ['Fotokopi KTP & KK', 'Surat Keterangan RT/RW', 'Pasfoto 4x6 (2 lembar)'],
                'waktu' => '30 Menit (Langsung Jadi)',
                'icon' => 'fa-file-signature'
            ],
            [
                'kode' => 'LEGALISASI & UMKM',
                'judul' => 'Rekomendasi Izin Usaha Mikro (IUMK)',
                'deskripsi' => 'Fasilitasi penerbitan surat rekomendasi izin bagi pelaku usaha mikro dan kecil warga kecamatan.',
                'syarat' => ['KTP Pemilik Usaha', 'Foto tempat usaha', 'Surat domisili usaha'],
                'waktu' => '1 Hari Kerja',
                'icon' => 'fa-briefcase'
            ],
            [
                'kode' => 'DISPENSASI NIKAH',
                'judul' => 'Dispensasi Nikah & Ahli Waris',
                'deskripsi' => 'Pelayanan administrasi pengantar nikah N1-N4 serta verifikasi pengesahan surat keterangan ahli waris.',
                'syarat' => ['Surat Keterangan Kematian', 'KTP seluruh ahli waris', 'Surat pernyataan bermaterai'],
                'waktu' => '1 - 3 Hari Kerja',
                'icon' => 'fa-scale-balanced'
            ]
        ];

        // Berita & Pengumuman Terkini
        $berita = [
            [
                'judul' => 'Sosialisasi Digitalisasi Pelayanan Administrasi Kependudukan di Balai Kecamatan AAL',
                'tanggal' => '18 Oktober 2026',
                'kategori' => 'Pelayanan Publik',
                'gambar' => 'https://images.unsplash.com/photo-1577495508048-b635879837f1?auto=format&fit=crop&w=700&q=80',
                'ringkasan' => 'Pemerintah Kecamatan Alang-Alang Lebar menggelar bimbingan teknis aktivasi Identitas Kependudukan Digital (IKD) bagi ketua RT dan RW se-Kecamatan.'
            ],
            [
                'judul' => 'Pencanangan Gerakan Gotong Royong & Penghijauan Taman Kota Kolonel H. Burlian',
                'tanggal' => '12 Oktober 2026',
                'kategori' => 'Lingkungan Hidup',
                'gambar' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=700&q=80',
                'ringkasan' => 'Camat bersama warga dan unsur Koramil/Polsek serentak membersihkan saluran drainase dan menanam 200 bibit pohon peneduh.'
            ],
            [
                'judul' => 'Bazar UMKM dan Pasar Murah TPID Sambut Hari Pangan Sedunia di Terminal AAL',
                'tanggal' => '05 Oktober 2026',
                'kategori' => 'Perekonomian',
                'gambar' => 'https://images.unsplash.com/photo-1488459716781-31db52582fe9?auto=format&fit=crop&w=700&q=80',
                'ringkasan' => 'Ratusan paket sembako murah disediakan untuk warga prasejahtera bekerja sama dengan Dinas Perdagangan Kota Palembang.'
            ]
        ];

        // Statistik Kecamatan
        $statistik = [
            'penduduk' => '118.600+',
            'kelurahan' => '4 Kelurahan',
            'rt_rw' => '240 RT / 48 RW',
            'luas_wilayah' => '38.67 km²'
        ];

        // 5 Aspirasi terbaru yang memiliki tindak lanjut atau status update untuk transparansi publik
        $aspirasiPublik = Aspirasi::latest()->take(6)->get();

        return view('kecamatan.landing', compact('kelurahan', 'layanan', 'berita', 'statistik', 'aspirasiPublik'));
    }

    public function aspirasi(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nik' => 'nullable|string|max:20',
            'telepon' => 'required|string|max:20',
            'kelurahan' => 'required|string',
            'kategori' => 'required|string',
            'pesan' => 'required|string|max:1000'
        ]);

        Aspirasi::create($validated);

        return back()->with('success_aspirasi', 'Terima kasih, Bapak/Ibu ' . htmlspecialchars($validated['nama']) . '. Laporan/Aspirasi Anda untuk Kelurahan ' . htmlspecialchars($validated['kelurahan']) . ' telah berhasil tersimpan dan akan segera ditindaklanjuti.');
    }
}
