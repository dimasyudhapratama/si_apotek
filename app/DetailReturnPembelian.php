<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailReturnPembelian extends Model
{
    protected $table = 'detail_return_pembelian';
    protected $fillable = ['return_pembelian_id','produk_konversi_stok_id','produk_stok_detail_exp_date','harga','qty','subtotal'];
    public $timestamps = false;
}
