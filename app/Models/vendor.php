<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ['nama_vendor'];

    protected $table = 'vendor';

    public $timestamps = false;

    public function listBarang()
    {
        return $this->hasMany(ListBarang::class, 'vendor_id');
    }
}