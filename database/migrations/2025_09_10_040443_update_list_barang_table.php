<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('list_barang', function (Blueprint $table) {
            // Hapus foreign key dulu
            $table->dropForeign(['kode_region']); 

            // Kalau mau ubah kolom juga (misalnya tetap string biasa tanpa foreign key)
            $table->string('kode_region')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('list_barang', function (Blueprint $table) {
            // Balikin lagi foreign key
            $table->foreign('kode_region')
                  ->references('kode_region')
                  ->on('region')
                  ->onDelete('set null');
        });
    }
};
