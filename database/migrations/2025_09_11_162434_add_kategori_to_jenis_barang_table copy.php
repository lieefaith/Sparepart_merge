<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jenis_barang', function (Blueprint $table) {
            $table->enum('kategori', ['aset', 'non-aset']);
        });
    }

    public function down(): void
    {
        Schema::table('jenis_barang', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};