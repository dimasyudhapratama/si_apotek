<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $table = 'detail_penjualan';
    protected $fillable = ['penjualan_id','produk_konversi_stok_id','produk_stok_detail_exp_date','harga','qty','subtotal'];
    public $timestamps = false;
}
