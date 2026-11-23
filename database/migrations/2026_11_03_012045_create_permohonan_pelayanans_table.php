<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permohonan_pelayanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nomor_tiket')->unique();
            $table->string('jenis_layanan'); // e.g. KTP-el / KK, Surat Pindah, SKCK / SKTM, Dispensasi Nikah / Lainnya
            $table->string('nama_pemohon');
            $table->string('nik_pemohon', 16);
            $table->string('telepon', 20);
            $table->string('kelurahan');
            $table->text('alamat');
            $table->text('keterangan')->nullable();
            
            // Berkas Upload (Path di storage)
            $table->string('file_ktp_kk')->nullable(); // Foto KTP/KK
            $table->string('file_pengantar_rt')->nullable(); // Surat Pengantar RT/RW
            $table->string('file_pendukung')->nullable(); // Berkas Pendukung (Akta, Ijazah, dsb)
            
            // Status & Tindak Lanjut Petugas
            $table->enum('status', ['Diajukan', 'Diverifikasi', 'Diproses', 'Selesai', 'Ditolak'])->default('Diajukan');
            $table->text('catatan_petugas')->nullable();
            $table->string('file_hasil')->nullable(); // Dokumen hasil dari kecamatan jika ada
            $table->timestamp('selesai_pada')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_pelayanans');
    }
};
