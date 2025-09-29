<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelian';
    protected $fillable = ['nomor_beli', 'nama_supplier', 'tanggal', 'grand_total'];

    // Relasi: 1 pembelian punya banyak detail
    public function details()
    {
        return $this->hasMany(DetailPembelian::class, 'pembelian_id');
    }
}
