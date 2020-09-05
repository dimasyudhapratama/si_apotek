<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailKoreksiStok extends Model
{
    protected $table = 'detail_koreksi_stok';
    protected $fillable = [
        'koreksi_stok_id',
        'produk_konversi_stok_id',
        'produk_stok_detail_exp_date',
        'qty_awal',
        'qty_akhir'
    ];

    public $timestamps = false;
}
