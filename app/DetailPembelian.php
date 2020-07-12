<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    protected $table = 'detail_pembelian';
    protected $fillable = ['pembelian_id','produk_konversi_stok_id','produk_stok_detail_exp_date','harga','qty','subtotal'];
    public $timestamps = false;
}
