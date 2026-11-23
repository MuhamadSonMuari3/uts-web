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
        // 1. Modifikasi kolom role pada tabel users
        // Menggunakan DB::statement agar kompatibel dengan MySQL Enum tanpa perlu doctrine/dbal
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'sekretaris_camat', 'camat', 'masyarakat') NOT NULL DEFAULT 'masyarakat'");

        // 2. Tambahkan kolom paraf sekcam dan tanda tangan camat di permohonan_pelayanans
        Schema::table('permohonan_pelayanans', function (Blueprint $table) {
            // Status alur: Diajukan -> Diverifikasi Sekcam -> Ditandatangani Camat -> Selesai / Ditolak
            $table->text('paraf_sekcam')->nullable()->after('catatan_petugas');
            $table->foreignId('sekcam_id')->nullable()->constrained('users')->nullOnDelete()->after('paraf_sekcam');
            $table->timestamp('diverifikasi_sekcam_pada')->nullable()->after('sekcam_id');

            $table->longText('ttd_camat')->nullable()->after('diverifikasi_sekcam_pada'); // data URL base64 atau path file
            $table->foreignId('camat_id')->nullable()->constrained('users')->nullOnDelete()->after('ttd_camat');
            $table->timestamp('ditandatangani_camat_pada')->nullable()->after('camat_id');
        });

        // 3. Update enum status permohonan agar mencakup alur baru: 'Menunggu TTD Camat'
        DB::statement("ALTER TABLE permohonan_pelayanans MODIFY COLUMN status ENUM('Diajukan', 'Diverifikasi', 'Menunggu TTD Camat', 'Diproses', 'Selesai', 'Ditolak') NOT NULL DEFAULT 'Diajukan'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan_pelayanans', function (Blueprint $table) {
            $table->dropForeign(['sekcam_id']);
            $table->dropForeign(['camat_id']);
            $table->dropColumn([
                'paraf_sekcam',
                'sekcam_id',
                'diverifikasi_sekcam_pada',
                'ttd_camat',
                'camat_id',
                'ditandatangani_camat_pada'
            ]);
        });

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'masyarakat') NOT NULL DEFAULT 'masyarakat'");
        DB::statement("ALTER TABLE permohonan_pelayanans MODIFY COLUMN status ENUM('Diajukan', 'Diverifikasi', 'Diproses', 'Selesai', 'Ditolak') NOT NULL DEFAULT 'Diajukan'");
    }
};
