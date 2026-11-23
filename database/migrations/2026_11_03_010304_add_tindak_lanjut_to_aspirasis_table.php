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
        Schema::table('aspirasis', function (Blueprint $table) {
            $table->text('tindak_lanjut')->nullable()->after('pesan');
            $table->timestamp('ditindaklanjuti_pada')->nullable()->after('tindak_lanjut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aspirasis', function (Blueprint $table) {
            $table->dropColumn(['tindak_lanjut', 'ditindaklanjuti_pada']);
        });
    }
};
