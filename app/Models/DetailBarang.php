<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBarang extends Model
{
    protected $table = 'detail_barang';

    public $timestamps = false;

    protected $fillable = [
        'tiket_sparepart',
        'jenis_id',
        'tipe_id',
        'vendor_id',
        'serial_number',
        'spk',
        'harga',
        'quantity',
        'keterangan',
        'kode_region',
        'tanggal',
        'pic',
        'department'
    ];

        protected $casts = [
        'tanggal' => 'date',
    ];


    public function listBarang()
    {
        return $this->belongsTo(ListBarang::class, 'tiket_sparepart', 'tiket_sparepart');
    }
}