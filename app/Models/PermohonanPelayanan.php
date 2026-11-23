<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanPelayanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nomor_tiket',
        'jenis_layanan',
        'nama_pemohon',
        'nik_pemohon',
        'telepon',
        'kelurahan',
        'alamat',
        'keterangan',
        'file_ktp_kk',
        'file_pengantar_rt',
        'file_pendukung',
        'status',
        'petugas_id',
        'diverifikasi_petugas_pada',
        'catatan_petugas',
        'file_hasil',
        'selesai_pada',
        'paraf_sekcam',
        'sekcam_id',
        'diverifikasi_sekcam_pada',
        'ttd_camat',
        'camat_id',
        'ditandatangani_camat_pada',
    ];

    protected $casts = [
        'selesai_pada' => 'datetime',
        'diverifikasi_petugas_pada' => 'datetime',
        'diverifikasi_sekcam_pada' => 'datetime',
        'ditandatangani_camat_pada' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function sekcam()
    {
        return $this->belongsTo(User::class, 'sekcam_id');
    }

    public function camat()
    {
        return $this->belongsTo(User::class, 'camat_id');
    }
}
