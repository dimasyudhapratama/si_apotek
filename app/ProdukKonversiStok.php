<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdukKonversiStok extends Model
{
    protected $table = 'produk_konversi_stok';
    protected $fillable = [
        'produk_id','status_aktif','level','satuan','nilai_konversi',
        'laba_harga_biasa','harga_biasa','laba_harga_resep','harga_resep'
    ];
    public $timestamps = false;
}
