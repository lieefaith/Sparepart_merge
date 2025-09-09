<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pengiriman extends Model
{
    protected $table = 'permintaan';

    protected $fillable = [
        'tiket_pengiriman',
        'user_id',
        'tiket_permintaan',
        'tanggal_transaksi',
        'status',
        'tanggal_perubahan',
    ];


    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($permintaan) {

            $lastTiketNumber = DB::table('pengiriman')
                ->select(DB::raw('MAX(CAST(SUBSTRING(tiket, 7) AS UNSIGNED)) as max_number'))
                ->value('max_number');

            $nextNumber = $lastTiketNumber ? $lastTiketNumber + 1 : 1;

            $permintaan->tiket = 'DEL-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function permintaan()
    {
        return $this->belongsTo(Permintaan::class);
    }

    public function details()
    {
        return $this->hasMany(PengirimanDetail::class, 'tiket', 'tiket');
    }
}
