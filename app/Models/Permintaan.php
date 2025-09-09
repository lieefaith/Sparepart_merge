<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    protected $table = 'permintaan';

    protected $fillable = [
        'user_id',
        'tanggal_permintaan',
        'status',
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($permintaan) {
            $user   = auth()->user();
            $region = strtoupper($user->region);
            $year   = now()->year;

            // Cari tiket terakhir untuk region & tahun ini
            $lastPermintaan = self::where('tiket', 'like', "REQ-{$region}-{$year}-%")
                ->orderBy('id', 'desc')
                ->first();

            $number = 1;
            if ($lastPermintaan && preg_match('/(\d+)$/', $lastPermintaan->tiket, $matches)) {
                $number = (int)$matches[1] + 1;
            }

            $permintaan->tiket = "REQ-{$region}-{$year}-" . str_pad($number, 3, '0', STR_PAD_LEFT);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(PermintaanDetail::class, 'tiket', 'tiket');
    }

    public function histori()
    {
        return $this->hasOne(HistoriPermintaan::class, 'tiket', 'tiket');
    }
}
