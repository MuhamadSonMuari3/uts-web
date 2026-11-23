<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update enum status permohonan_pelayanans agar mencakup:
        // 'Diajukan', 'Diverifikasi', 'Menunggu TTD Camat', 'Ditandatangani Camat', 'Diproses', 'Selesai', 'Ditolak'
        DB::statement("ALTER TABLE permohonan_pelayanans MODIFY COLUMN status ENUM('Diajukan', 'Diverifikasi', 'Menunggu TTD Camat', 'Ditandatangani Camat', 'Diproses', 'Selesai', 'Ditolak') NOT NULL DEFAULT 'Diajukan'");

        // Update data yang sudah punya TTD Camat namun statusnya masih 'Diproses' agar langsung menjadi 'Ditandatangani Camat'
        DB::table('permohonan_pelayanans')
            ->whereNotNull('ttd_camat')
            ->where('status', 'Diproses')
            ->update(['status' => 'Ditandatangani Camat']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE permohonan_pelayanans MODIFY COLUMN status ENUM('Diajukan', 'Diverifikasi', 'Menunggu TTD Camat', 'Diproses', 'Selesai', 'Ditolak') NOT NULL DEFAULT 'Diajukan'");
    }
};
