<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    protected $fillable = [
        'nama',
        'nik',
        'telepon',
        'kelurahan',
        'kategori',
        'pesan',
        'status',
        'tindak_lanjut',
        'ditindaklanjuti_pada',
    ];

    protected $casts = [
        'ditindaklanjuti_pada' => 'datetime',
    ];
}
