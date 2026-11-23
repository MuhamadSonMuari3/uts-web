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
        // Tambahkan role 'petugas' ke enum tabel users
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'petugas', 'sekretaris_camat', 'camat', 'masyarakat') NOT NULL DEFAULT 'masyarakat'");

        // Tambahkan pelacakan verifikator petugas di permohonan_pelayanans jika belum ada
        Schema::table('permohonan_pelayanans', function (Blueprint $table) {
            $table->foreignId('petugas_id')->nullable()->constrained('users')->nullOnDelete()->after('status');
            $table->timestamp('diverifikasi_petugas_pada')->nullable()->after('petugas_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan_pelayanans', function (Blueprint $table) {
            $table->dropForeign(['petugas_id']);
            $table->dropColumn(['petugas_id', 'diverifikasi_petugas_pada']);
        });

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'sekretaris_camat', 'camat', 'masyarakat') NOT NULL DEFAULT 'masyarakat'");
    }
};
