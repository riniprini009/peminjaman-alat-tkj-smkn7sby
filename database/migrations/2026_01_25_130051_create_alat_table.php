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
        Schema::create('jenis_alat', function (Blueprint $table) {
            $table->id('id_jenis')->primary();
            $table->string('nama_jenis')->unique();
            $table->timestamps();
        });

        Schema::create('tipe_alat', function (Blueprint $table) {
            $table->id('id_tipe')->primary();
            $table->string('nama_tipe', 255)->unique();
            $table->integer('stok');
            $table->string('lokasi_rak', 5);
            $table->string('gambar')->nullable();
            $table->timestamps();
        });

        Schema::create('detail_alat', function (Blueprint $table) {
            $table->id('id_detail_alat')->primary();
            $table->string('kode_alat')->unique()->nullable();
            $table->enum('kondisi_alat', [
                'baik',
                'perlu perbaikan',
                'rusak',
                'hilang'
            ])->default('baik');
            $table->string('qr_code')->unique()->nullable();
            $table->enum('status_alat', [
                'tersedia',
                'tidak tersedia'
            ])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_alat');
        Schema::dropIfExists('tipe_alat');
        Schema::dropIfExists('jenis_alat');
    }
};
