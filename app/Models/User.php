<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    const ROLE_SUPER_ADMIN = 'super_admin';
    const ROLE_KEPALA_RO = 'kepala_ro';
    const ROLE_KEPALA_GUDANG = 'kepala_gudang';
    const ROLE_USER = 'user';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'region',
        'mobile_number',
        'perusahaan',
        'noktp',
        'alamat',
        'bagian'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function roles(): array
    {
        return [
            self::ROLE_SUPER_ADMIN,
            self::ROLE_KEPALA_RO,
            self::ROLE_KEPALA_GUDANG,
            self::ROLE_USER,
        ];
    }

        public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isKepalaRO(): bool
    {
        return $this->role === self::ROLE_KEPALA_RO;
    }

    public function isKepalaGudang(): bool
    {
        return $this->role === self::ROLE_KEPALA_GUDANG;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function permintaan()
    {
        return $this->hasMany(Permintaan::class);
    }

    public function pengiriman()
    {
        return $this->hasMany(Pengiriman::class);
    }

    public function verifikasi()
    {
        return $this->hasMany(VerifikasiPermintaan::class, 'user_id');
    }

    public function signedVerifikasi()
    {
        return $this->hasMany(VerifikasiPermintaan::class, 'signed_by');
    }
}
