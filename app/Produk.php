<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table ='produk';
    protected $fillable = [
        'id',
        'kategori_produk_id',
        'produsen_id',
        'supplier_id',
        'nama_produk',
        'harga_beli',
        'stok_minimal',
        'level_satuan',
        'status_pajak_produk'
    ];
    public $timestamps = false;

    function supplier(){
        return $this->belongsTo('App\Supplier');
    }
}
