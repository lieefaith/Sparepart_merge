<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_barang', function (Blueprint $table) {
            // Hapus foreign key kalau ada
            $table->dropForeign(['kode_region']); 

            // Ubah kolom quantity (default jadi 1)
            $table->integer('quantity')->default(1)->change();

            // Tambah kolom baru
            $table->enum('status', ['tersedia', 'dipesan', 'habis'])->default('tersedia');
        });
    }

    public function down(): void
    {
        Schema::table('detail_barang', function (Blueprint $table) {
            // Rollback: hapus kolom status
            $table->dropColumn('status');

            // Balikin quantity default ke 0
            $table->integer('quantity')->default(0)->change();

            // Balikin foreign key
            $table->foreign('kode_region')->references('kode_region')->on('region')->onDelete('cascade');
        });
    }
};

