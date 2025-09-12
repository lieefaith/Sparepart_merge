<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('list_barang', function (Blueprint $table) {
            try {
                $table->dropForeign(['kode_region']);
            } catch (\Exception $e) {
                // Handle exception jika foreign key tidak ada
            }

            $table->dropColumn('kode_region');

            // Drop kolom-kolom lain
            $table->dropColumn(['status', 'pic', 'department', 'tanggal']);
            
            // Tambah kolom kategori setelah tipe_id
            $table->string('kategori')->after('tipe_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('list_barang', function (Blueprint $table) {
            $table->string('kode_region')->nullable();
            $table->enum('status', ['tersedia', 'dipesan', 'habis'])->default('tersedia');
            $table->string('pic')->nullable();
            $table->string('department')->nullable();
            $table->date('tanggal');

            // Hapus kolom kategori
            $table->dropColumn('kategori');

            $table->foreign('kode_region')
                ->references('kode_region')
                ->on('region')
                ->onDelete('set null');
        });
    }
};