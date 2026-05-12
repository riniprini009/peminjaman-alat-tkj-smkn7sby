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
        Schema::table('tipe_alat', function (Blueprint $table) {
            $table->foreignId('id_jenis')
                ->constrained('jenis_alat', 'id_jenis')
                ->cascadeOnDelete();
        });

        Schema::table('detail_alat', function (Blueprint $table) {
            $table->foreignId('id_tipe')
                ->constrained('tipe_alat', 'id_tipe')
                ->cascadeOnDelete();
        });

        Schema::table('siswa', function (Blueprint $table) {
            $table->foreignId('id_akun_user')
                ->constrained('akun_user', 'id_akun_user')
                ->cascadeOnDelete();
        });

        Schema::table('peminjaman', function (Blueprint $table) {
            $table->foreignId('id_siswa')
                ->constrained('siswa', 'id_siswa')
                ->cascadeOnDelete();
        });

        Schema::table('peminjaman_detail', function (Blueprint $table) {
            $table->foreignId('id_pinjam')
                ->constrained('peminjaman', 'id_pinjam')
                ->cascadeOnDelete();

            $table->foreignId('id_detail_alat')
                ->constrained('detail_alat', 'id_detail_alat')
                ->cascadeOnDelete();
        });

        Schema::table('peminjaman_tipe', function(Blueprint $table){
            $table->foreignId('id_pinjam')
                  ->constrained('peminjaman', 'id_pinjam')
                  ->cascadeOnDelete();
            
            $table->foreignId('id_tipe')
                  ->constrained('tipe_alat', 'id_tipe')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
